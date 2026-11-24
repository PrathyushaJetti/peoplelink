<?php
// App API: User Profile / Account - profile, settings, privacy, password, devices (max active devices), deactivate, delete request, notifications.

/* on/off preferences kept in users.prefs besides push / sms / email (website settings page), default on */
const PL_ACCOUNT_FLAGS = ['community_updates', 'payment_updates', 'show_city', 'show_professional', 'show_matrimony', 'show_marketplace_contact'];

function pl_account_out(array $u): array {
    $p = json_decode($u['prefs'] ?? '', true) ?: [];
    return ['id' => (int)$u['id'], 'name' => $u['name'], 'email' => $u['email'], 'phone' => $u['phone'], 'role' => $u['role'],
        'gender' => $u['gender'] ?? null, 'dob' => $u['dob'] ?? null, 'city' => $u['city'] ?? null, 'state' => $u['state'] ?? null, 'country' => $u['country'] ?? null,
        'about' => $u['about'] ?? null, 'photo' => $u['photo'] ?? null, 'photo_thumbnail' => pl_thumb($u['photo'] ?? null),
        'community_id' => $u['community_id'] ? (int)$u['community_id'] : null, 'community_name' => pl_community_names()[$u['community_id']] ?? null,
        'account_status' => $u['status'] ?? 'active', 'phone_verified' => (bool)($u['phone_verified'] ?? 0), 'email_verified' => (bool)($u['email_verified'] ?? 0),
        'registered_at' => $u['created_at'], 'delete_requested' => !empty($u['delete_requested_at']),
        'settings' => ['push_enabled' => $p['push_enabled'] ?? true, 'sms_enabled' => $p['sms_enabled'] ?? true, 'email_enabled' => $p['email_enabled'] ?? true, 'language' => $p['language'] ?? 'en']
            + array_combine(PL_ACCOUNT_FLAGS, array_map(fn($k) => $p[$k] ?? true, PL_ACCOUNT_FLAGS))];
}

pl_action('account_profile', fn($x) => ['account' => pl_account_out($x['user']), 'member_profile_status' => pl_my_member($x['uid'], $x['cid'])['status'] ?? null], false, false);
pl_action_nocomm('account_profile');

pl_action('account_update', function ($x) {
    $u = $x['user']; $set = [];
    if (isset($_POST['name'])) { $n = mb_substr(trim((string)$_POST['name']), 0, 120); if ($n === '') return ['error' => 'Name is required.', 'code' => 'VALIDATION_ERROR']; $set['name'] = $n; }
    if (isset($_POST['phone'])) {
        $ph = preg_replace('/[^\d+]/', '', (string)$_POST['phone']);
        if ($ph !== '' && !preg_match('/^\+?\d{6,15}$/', $ph)) return ['error' => 'Enter a valid mobile number.', 'code' => 'VALIDATION_ERROR'];
        if ($ph !== (string)$u['phone']) { $set['phone'] = $ph; $set['phone_verified'] = 0; }
    }
    if (isset($_POST['gender'])) $set['gender'] = in_array($_POST['gender'], PL_GENDERS, true) ? $_POST['gender'] : null;
    if (isset($_POST['dob'])) $set['dob'] = ($ts = strtotime((string)$_POST['dob'])) ? date('Y-m-d', $ts) : null;
    foreach (['city' => 80, 'state' => 80, 'country' => 80, 'about' => 2000] as $k => $len) if (isset($_POST[$k])) $set[$k] = mb_substr(trim((string)$_POST[$k]), 0, $len);
    if (!empty($_FILES['photo']) && ($_FILES['photo']['error'] ?? 4) !== UPLOAD_ERR_NO_FILE) {
        $r = pl_store_upload($_FILES['photo'], 'users');
        if (!empty($r['error'])) return ['error' => $r['error'], 'code' => 'VALIDATION_ERROR'];
        pl_delete_file($u['photo'] ?? null); $set['photo'] = $r['url'];
    }
    if (!$set) return ['error' => 'Nothing to update.', 'code' => 'VALIDATION_ERROR'];
    db()->prepare('UPDATE users SET ' . implode(',', array_map(fn($k) => "$k=?", array_keys($set))) . ' WHERE id=?')->execute(array_merge(array_values($set), [$x['uid']]));
    return ['message' => 'Profile updated.', 'account' => pl_account_out(rows('SELECT * FROM users WHERE id=?', [$x['uid']])[0])];
});
pl_action_nocomm('account_update');

pl_action('account_settings', fn($x) => ['settings' => pl_account_out($x['user'])['settings']], false, false);
pl_action('account_settings_save', function ($x) {
    $p = json_decode($x['user']['prefs'] ?? '', true) ?: [];
    foreach (array_merge(['push_enabled', 'sms_enabled', 'email_enabled'], PL_ACCOUNT_FLAGS) as $k) if (isset($_POST[$k])) $p[$k] = in_array(strtolower((string)$_POST[$k]), ['1', 'true', 'yes', 'on'], true);
    if (isset($_POST['language'])) $p['language'] = mb_substr(preg_replace('/[^a-z\-]/i', '', (string)$_POST['language']), 0, 10);
    db()->prepare('UPDATE users SET prefs=? WHERE id=?')->execute([json_encode($p), $x['uid']]);
    if (isset($_POST['push_enabled']) && !$p['push_enabled']) db()->prepare('UPDATE device_tokens SET is_active=0 WHERE user_id=?')->execute([$x['uid']]);
    return ['message' => 'Settings saved.'];
});
foreach (['account_settings', 'account_settings_save'] as $__a) pl_action_nocomm($__a);
// account_privacy / account_privacy_save are aliases of privacy_settings(_save), see members_api.php

pl_action('account_change_password', function ($x) {
    $cur = (string)($_POST['current_password'] ?? ''); $new = (string)($_POST['new_password'] ?? $_POST['password'] ?? '');
    if (!password_verify($cur, (string)$x['user']['password_hash'])) return ['error' => 'Current password is wrong.', 'code' => 'INVALID_CREDENTIALS', '_code' => 401];
    if (strlen($new) < 6) return ['error' => 'New password must be at least 6 characters.', 'code' => 'VALIDATION_ERROR'];
    if (isset($_POST['confirm']) && $new !== (string)$_POST['confirm']) return ['error' => 'Passwords do not match.', 'code' => 'VALIDATION_ERROR'];
    db()->prepare('UPDATE users SET password_hash=? WHERE id=?')->execute([password_hash($new, PASSWORD_DEFAULT), $x['uid']]);
    $n = pl_revoke_all_sessions($x['uid'], true);
    pl_audit('user:password_changed', null, $x['uid'], 'by user');
    return ['message' => 'Password changed.' . ($n ? " Logged out of $n other device(s)." : '')];
});
pl_action_nocomm('account_change_password');

pl_action('account_devices', function ($x) {
    $me = pl_session_hash();
    return ['limit' => pl_device_limit(), 'devices' => array_map(fn($s) => ['id' => (int)$s['id'], 'device_name' => $s['device_name'], 'platform' => $s['platform'], 'ip' => $s['ip'],
        'logged_in_at' => $s['created_at'], 'last_seen_at' => $s['last_seen_at'], 'is_current' => $s['session_hash'] === $me], pl_active_sessions($x['uid']))];
}, false, false);
pl_action('account_logout_device', function ($x) {
    $id = (int)($_POST['id'] ?? $_POST['session_id'] ?? 0);
    $s = rows('SELECT session_hash FROM user_sessions WHERE id=? AND user_id=?', [$id, $x['uid']])[0] ?? null;
    if (!$s) return ['error' => 'Device not found.', 'code' => 'NOT_FOUND', '_code' => 404];
    pl_revoke_session($id, $x['uid']);
    if ($s['session_hash'] === pl_session_hash()) pl_session_logout();
    return ['message' => 'Device logged out.'];
});
pl_action('account_logout_all', function ($x) {
    $all = in_array(strtolower((string)($_POST['include_current'] ?? '')), ['1', 'true', 'yes'], true);
    $n = pl_revoke_all_sessions($x['uid'], !$all);
    if ($all) pl_session_logout();
    return ['message' => $all ? 'Logged out of all devices.' : "Logged out of $n other device(s)."];
});
pl_action('account_deactivate', function ($x) {
    if (!password_verify((string)($_POST['password'] ?? ''), (string)$x['user']['password_hash'])) return ['error' => 'Password is wrong.', 'code' => 'INVALID_CREDENTIALS', '_code' => 401];
    db()->prepare("UPDATE users SET status='deactivated' WHERE id=?")->execute([$x['uid']]);
    pl_audit('user:deactivated', null, $x['uid'], 'by user');
    pl_revoke_all_sessions($x['uid']); pl_session_logout();
    return ['message' => 'Your account is deactivated. Log in again any time to reactivate it.'];
});
pl_action('account_delete_request', function ($x) {
    if (!password_verify((string)($_POST['password'] ?? ''), (string)$x['user']['password_hash'])) return ['error' => 'Password is wrong.', 'code' => 'INVALID_CREDENTIALS', '_code' => 401];
    db()->prepare('UPDATE users SET delete_requested_at=NOW(), delete_reason=? WHERE id=?')->execute([mb_substr(trim((string)($_POST['reason'] ?? '')), 0, 255), $x['uid']]);
    pl_audit('user:delete_requested', null, $x['uid'], 'by user', $x['cid'] ?: null);
    return ['message' => 'Your account deletion request has been received. Our team will process it.'];
});
foreach (['account_devices', 'account_logout_device', 'account_logout_all', 'account_deactivate', 'account_delete_request'] as $__a) pl_action_nocomm($__a);

/* in-app notifications (personal + community broadcasts) */
pl_action('notifications', function ($x) {
    require_once dirname(__DIR__) . '/notifications.php';
    [$page, $per] = pl_api_page();
    $cat = (string)($_GET['category'] ?? $_POST['category'] ?? '');
    $d = pl_notif_list((int)$x['uid'], isset(pl_notif_categories()[$cat]) ? $cat : '', $page, $per, !empty($_GET['unread']) || !empty($_POST['unread']));
    return ['unread' => pl_notif_unread((int)$x['uid']), 'page' => $page, 'total' => $d['total'],
        'categories' => array_map(fn($k, $c) => ['key' => $k, 'label' => $c['label']], array_keys(pl_notif_categories()), pl_notif_categories()),
        'notifications' => array_map(fn($n) => ['id' => (int)$n['id'], 'title' => $n['title'], 'message' => $n['message'], 'type' => $n['type'], 'entity' => $n['entity'],
            'entity_id' => $n['entity_id'] ? (int)$n['entity_id'] : null, 'is_announcement' => $n['user_id'] === null, 'is_read' => $n['is_read_now'],
            'created_at' => $n['created_at'], 'web_link' => $n['link']], $d['items'])];
}, false, false);
pl_action('notification_read', function ($x) {
    require_once dirname(__DIR__) . '/notifications.php';
    if (!empty($_POST['all'])) pl_notif_mark_read((int)$x['uid']);
    else pl_notif_mark_read((int)$x['uid'], (int)($_POST['id'] ?? 0));
    return ['message' => 'Marked as read.', 'unread' => pl_notif_unread((int)$x['uid'])];
});
foreach (['notifications', 'notification_read'] as $__a) pl_action_nocomm($__a);
