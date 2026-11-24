<?php
/* Member notifications, shared by the website (bell + Notifications page) and the app API.
   A member sees: their own alerts (user_id = them) + broadcasts for their community or for everyone
   (user_id NULL) sent after they joined. Broadcast read state is per member (notification_reads). */

/* own tiny query helpers so this file can be loaded from any header (no helpers.php / e() clashes) */
function pl_nrows(string $s, array $p = []): array { $q = db()->prepare($s); $q->execute($p); return $q->fetchAll(PDO::FETCH_ASSOC); }
function pl_nval(string $s, array $p = []) { $q = db()->prepare($s); $q->execute($p); return $q->fetchColumn(); }

function pl_notif_tables(): void {
    static $done = false; if ($done) return; $done = true;
    try {
        db()->exec('CREATE TABLE IF NOT EXISTS notification_reads (notification_id INT NOT NULL, user_id INT NOT NULL,
            read_at DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (notification_id, user_id), KEY idx_user (user_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
    } catch (Throwable $e) { error_log('PL notif table: ' . $e->getMessage()); }
}

/* the member's id, community and join date (broadcasts before joining are not shown) */
function pl_notif_ctx(int $uid): ?array {
    $u = pl_nrows('SELECT id, community_id, created_at FROM users WHERE id=?', [$uid])[0] ?? null;
    return $u ? ['uid' => (int)$u['id'], 'cid' => $u['community_id'] ? (int)$u['community_id'] : 0, 'since' => $u['created_at'] ?: '2000-01-01'] : null;
}

/* WHERE clause + params for "notifications visible to this member"; $cat filters by group */
function pl_notif_where(array $c, string $cat = ''): array {
    $w = '(n.user_id=? OR (n.user_id IS NULL AND (n.community_id IS NULL OR n.community_id=?) AND n.created_at >= ?))';
    $a = [$c['uid'], $c['cid'], $c['since']];
    $types = pl_notif_categories()[$cat]['types'] ?? null;
    if ($cat === 'announcements') $w .= ' AND n.user_id IS NULL';
    elseif ($types) { $w .= ' AND n.type IN (' . implode(',', array_fill(0, count($types), '?')) . ')'; $a = array_merge($a, $types); }
    return [$w, $a];
}

/* filter tabs on the Notifications page */
function pl_notif_categories(): array {
    return [
        '' => ['label' => 'All'],
        'family' => ['label' => 'Family & tree', 'types' => ['approval', 'family_tree', 'account']],
        'matrimony' => ['label' => 'Matrimony', 'types' => ['matrimony']],
        'jobs' => ['label' => 'Jobs', 'types' => ['job', 'job_application', 'job_closing', 'package_expiry', 'job_package']],
        'payments' => ['label' => 'Payments', 'types' => ['payment']],
        'announcements' => ['label' => 'Announcements'],
    ];
}

/* read state: own alerts use is_read; broadcasts use notification_reads */
function pl_notif_read_sql(): string {
    return 'IF(n.user_id IS NULL, EXISTS(SELECT 1 FROM notification_reads r WHERE r.notification_id=n.id AND r.user_id=?), n.is_read)';
}

function pl_notif_unread(int $uid): int {
    pl_notif_tables(); $c = pl_notif_ctx($uid); if (!$c) return 0;
    [$w, $a] = pl_notif_where($c);
    try { return (int)pl_nval('SELECT COUNT(*) FROM user_notifications n WHERE ' . $w . ' AND NOT ' . pl_notif_read_sql(), array_merge($a, [$uid])); }
    catch (Throwable $e) { return 0; }
}

function pl_notif_list(int $uid, string $cat = '', int $page = 1, int $per = 20, bool $unreadOnly = false): array {
    pl_notif_tables(); $c = pl_notif_ctx($uid); if (!$c) return ['items' => [], 'total' => 0];
    [$w, $a] = pl_notif_where($c, $cat);
    if ($unreadOnly) { $w .= ' AND NOT ' . pl_notif_read_sql(); $a[] = $uid; }
    $total = (int)pl_nval("SELECT COUNT(*) FROM user_notifications n WHERE $w", $a);
    $page = max(1, $page); $per = max(1, min(50, $per));
    $items = pl_nrows('SELECT n.*, ' . pl_notif_read_sql() . " AS is_read_now FROM user_notifications n WHERE $w ORDER BY n.id DESC LIMIT $per OFFSET " . (($page - 1) * $per), array_merge([$uid], $a));
    foreach ($items as &$n) { $n['is_read_now'] = (bool)$n['is_read_now']; $n['link'] = pl_notif_link($n); $n['icon'] = pl_notif_icon($n); }
    return ['items' => $items, 'total' => $total];
}

/* mark one ($id) or all visible notifications as read for this member */
function pl_notif_mark_read(int $uid, ?int $id = null): void {
    pl_notif_tables(); $c = pl_notif_ctx($uid); if (!$c) return;
    if ($id) {
        $n = pl_nrows('SELECT id, user_id FROM user_notifications WHERE id=?', [$id])[0] ?? null; if (!$n) return;
        if ($n['user_id'] === null) db()->prepare('INSERT IGNORE INTO notification_reads (notification_id, user_id) VALUES (?,?)')->execute([$id, $uid]);
        elseif ((int)$n['user_id'] === $uid) db()->prepare('UPDATE user_notifications SET is_read=1 WHERE id=?')->execute([$id]);
        return;
    }
    db()->prepare('UPDATE user_notifications SET is_read=1 WHERE user_id=? AND is_read=0')->execute([$uid]);
    [$w, $a] = pl_notif_where($c);
    db()->prepare("INSERT IGNORE INTO notification_reads (notification_id, user_id) SELECT n.id, ? FROM user_notifications n WHERE n.user_id IS NULL AND $w")->execute(array_merge([$uid], $a));
}

/* where a notification should take the member on the website (null = no page) */
function pl_notif_link(array $n): ?string {
    $base = '/peoplelink/first/'; $ent = (string)($n['entity'] ?? ''); $type = (string)($n['type'] ?? ''); $title = (string)($n['title'] ?? '');
    if ($type === 'matrimony') return '/peoplelink/module-4/Frontend/pages/notifications.php';
    if ($type === 'family_tree') return $base . 'family-tree/family-tree-enquiry.php#track';
    if ($ent === 'families' && stripos($title, 'tree') !== false) return $base . 'family-tree/view-family-tree.php';
    if (in_array($ent, ['families', 'family_members'], true)) return $base . 'm-f-registration/family-profile.php';
    if ($ent === 'members' || $type === 'account') return $base . 'profile/my-profile.php';
    if ($ent === 'transactions' || $type === 'payment') return $base . 'payment/my-payments.php';
    if ($ent === 'jobs' || $type === 'job_closing') return $base . 'job/my-posted-jobs.php';
    if ($type === 'job_application') return $base . (stripos($title, 'New application') === 0 ? 'job/my-posted-jobs.php' : 'job/my-applications.php');
    if ($ent === 'user_packages' || in_array($type, ['package_expiry', 'job_package'], true)) return $base . 'job/global-job-packages.php';
    if ($ent === 'support_requests' || $type === 'support') return $base . 'community/my-support-requests.php';
    if ($type === 'event') return $base . 'events-ads.php';
    return null;
}

function pl_notif_icon(array $n): string {
    $t = (string)($n['type'] ?? '');
    if ($n['user_id'] === null) return 'bi-megaphone-fill';
    return ['matrimony' => 'bi-heart-fill', 'family_tree' => 'bi-diagram-3-fill', 'approval' => 'bi-patch-check-fill', 'payment' => 'bi-credit-card-fill',
        'account' => 'bi-person-fill-gear', 'support' => 'bi-life-preserver', 'event' => 'bi-calendar-event-fill', 'job_closing' => 'bi-briefcase-fill',
        'job_application' => 'bi-briefcase-fill', 'package_expiry' => 'bi-box-seam-fill', 'job_package' => 'bi-box-seam-fill', 'enquiry' => 'bi-chat-dots-fill'][$t] ?? 'bi-bell-fill';
}

/* "5 min ago", "Yesterday", "21 Nov 2026" */
function pl_notif_ago(string $dt): string {
    $t = strtotime($dt); if (!$t) return ''; $d = time() - $t;
    if ($d < 60) return 'Just now';
    if ($d < 3600) return floor($d / 60) . ' min ago';
    if ($d < 86400 && date('Y-m-d', $t) === date('Y-m-d')) return floor($d / 3600) . ' h ago';
    if (date('Y-m-d', $t) === date('Y-m-d', strtotime('-1 day'))) return 'Yesterday, ' . date('h:i A', $t);
    return date('d M Y, h:i A', $t);
}
