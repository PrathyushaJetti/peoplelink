<?php
// Shared loader for Family Profile, Family Members and Member Details (real data, same-community privacy rules).
require_once dirname(__DIR__, 2) . '/matrimoney/includes/bridge.php';
pl_ensure_schema();

$mfUser = current_user();
if (!$mfUser) { header('Location: ' . DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/first/m-f-registration/family-profile.php')); exit; }
$mfUid = (int)$mfUser['id'];
$mfComm = pl_resolve_community($mfUid);
if (!$mfComm) { header('Location: /peoplelink/first/community-page.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/first/m-f-registration/family-profile.php')); exit; }
$mfCid = (int)$mfComm['id'];

/* No family to show: admins go to the admin list, members to the registration form (with a reason) */
function mf_no_family(array $user, array $comm): void {
    if (($user['role'] ?? '') === 'admin') header('Location: ' . DASHBOARD_URL . 'admin/manage.php?e=family&c=' . urlencode($comm['slug']));
    else header('Location: /peoplelink/first/m-f-registration/member-family-registration.php?status=nofamily');
    exit;
}

/* status words used by these designs */
function mf_status(?string $s): string { return ['approved' => 'Active', 'pending' => 'Pending Approval', 'rejected' => 'Incomplete'][$s ?? ''] ?? 'Inactive'; }

/* The family to show: ?family=ID (an approved family of my community) or my own family. Returns null when there is none. */
function mf_family(int $uid, int $cid, ?int $id): ?array {
    if ($id) {
        $f = rows('SELECT * FROM families WHERE id=? AND community_id=?', [$id, $cid])[0] ?? null;
        if ($f && (int)$f['user_id'] !== $uid && ($f['status'] !== 'approved' || !$f['is_active'])) return null; // others see only approved families
        return $f;
    }
    return rows('SELECT * FROM families WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [$uid, $cid])[0] ?? null;
}

/* everything the three pages need about one family */
function mf_bundle(array $f, int $uid): array {
    $own = (int)$f['user_id'] === $uid;
    $fd = json_decode($f['details'] ?? '', true) ?: [];
    $priv = ($fd['privacy'] ?? []) + ['show_mobile' => false, 'show_email' => false, 'show_address' => false, 'show_family_members' => true, 'allow_contact' => true];
    $head = rows('SELECT * FROM members WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [(int)$f['user_id'], (int)$f['community_id']])[0] ?? null;
    if ($head && !$own && pl_mf_vis($head['family_visibility'] ?? 'members') === 'private') $priv['show_family_members'] = false;
    $where = $own ? '' : " AND status='approved' AND is_active=1";
    $all = rows("SELECT * FROM family_members WHERE family_id=?$where ORDER BY is_head DESC, id", [$f['id']]);
    return ['own' => $own, 'fd' => $fd, 'priv' => $priv, 'head' => $head, 'md' => json_decode($head['details'] ?? '', true) ?: [], 'all' => $all,
        'self' => array_values(array_filter($all, fn($m) => (int)$m['is_head'] === 1))[0] ?? null,
        'others' => array_values(array_filter($all, fn($m) => (int)$m['is_head'] !== 1))];
}
function pl_mf_vis(?string $v): string { return in_array($v, ['public', 'members', 'private'], true) ? $v : 'members'; }

/* first name of a relation among the family members, e.g. the Father */
function mf_rel(array $list, string $rel): string { foreach ($list as $m) if ($m['relationship'] === $rel) return $m['full_name']; return ''; }
