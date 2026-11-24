<?php
/* Matrimony notifications go to the common user_notifications table (type='matrimony'), with push via pl_notify_user().
   Older admin notices (approval etc.) live in matrimony_notifications with audience 'all' or 'profile:ID'; the list merges them read-only. */

function mat_notify(int $profileId, int $cid, string $title, string $message, string $event, ?int $relatedProfileId = null): void {
    $uid = mat_profile_user($profileId);
    if (!$uid) return;
    $prefs = pl_mat_privacy(rows('SELECT details FROM matrimony_profiles WHERE id=?', [$profileId])[0] ?? []);
    $push = true;
    if (str_contains($event, 'interest') && !$prefs['notifyInterests']) $push = false;
    if (str_contains($event, 'contact') && !$prefs['notifyContacts']) $push = false;
    pl_notify_user($uid, $cid, $title, $message, MAT_NOTIFY_TYPE, $event, $relatedProfileId, $push);
}

function mat_notifications(int $uid, int $cid, ?array $me): array {
    $own = array_map(fn($n) => ['id' => 'u' . $n['id'], 'title' => $n['title'], 'message' => $n['message'], 'event' => $n['entity'], 'profile_id' => $n['entity_id'] ? (int)$n['entity_id'] : null,
        'is_read' => (bool)$n['is_read'], 'created_at' => $n['created_at']],
        rows('SELECT * FROM user_notifications WHERE user_id=? AND type=? ORDER BY id DESC LIMIT 200', [$uid, MAT_NOTIFY_TYPE]));
    $legacy = [];
    if ($cid) {
        $aud = $me ? ['all', 'profile:' . $me['id']] : ['all'];
        $since = $me['created_at'] ?? date('Y-m-d H:i:s');
        $legacy = array_map(fn($n) => ['id' => 'm' . $n['id'], 'title' => $n['title'], 'message' => $n['message'], 'event' => 'matrimony_' . $n['type'], 'profile_id' => null, 'is_read' => true, 'created_at' => $n['created_at']],
            rows('SELECT * FROM matrimony_notifications WHERE community_id=? AND audience IN (' . implode(',', array_fill(0, count($aud), '?')) . ") AND (audience<>'all' OR created_at >= ?) AND NOT (audience LIKE 'profile:%' AND type='general') ORDER BY id DESC LIMIT 100",
                array_merge([$cid], $aud, [$since])));
    }
    $all = array_merge($own, $legacy);
    usort($all, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));
    return $all;
}

function mat_notification_read(int $uid, string $id, bool $all): array {
    if ($all) db()->prepare('UPDATE user_notifications SET is_read=1 WHERE user_id=? AND type=?')->execute([$uid, MAT_NOTIFY_TYPE]);
    elseif (preg_match('/^u(\d+)$/', $id, $m)) db()->prepare('UPDATE user_notifications SET is_read=1 WHERE id=? AND user_id=?')->execute([(int)$m[1], $uid]);
    return ['message' => 'Marked as read.', 'unread' => scalar('SELECT COUNT(*) FROM user_notifications WHERE user_id=? AND is_read=0 AND type=?', [$uid, MAT_NOTIFY_TYPE])];
}
