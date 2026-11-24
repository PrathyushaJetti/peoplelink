<?php
$GLOBALS['PL_ACTIONS'] = [];

function pl_action(string $name, callable $fn, bool $public = false, bool $write = true): void {
    $GLOBALS['PL_ACTIONS'][$name] = ['fn' => $fn, 'public' => $public, 'write' => $write];
}

pl_action('search', fn($x) => pl_search($x['cid'], $_GET + $_POST, (int)($_REQUEST['page'] ?? 1), (int)($_REQUEST['per'] ?? 12), $x['uid']), true, false);
pl_action('profile', function ($x) {
    $id = (int)($_REQUEST['id'] ?? 0);
    if (!$id && !empty($_REQUEST['code'])) $id = scalar('SELECT id FROM matrimony_profiles WHERE profile_code=?', [$_REQUEST['code']]);
    // Members may only open profiles of THEIR community (server-side community_id). Visitors and admins are not locked.
    $lock = $x['uid'] && ($x['user']['role'] ?? '') !== 'admin';
    $p = pl_get_profile($id, $lock ? ($x['cid'] ?: -1) : null, $x['uid']);
    return $p ? ['profile' => $p] : ['error' => 'Profile not found.', 'code' => 'PROFILE_NOT_FOUND', '_code' => 404];
}, true, false);
pl_action('session', function ($x) {
    $u = $x['user']; $me = $u ? pl_my_profile((int)$u['id'], $x['cid'] ?: null) : null;
    return [
        'csrf' => csrf_token(), 'logged_in' => (bool)$u,
        'user' => $u ? ['id' => (int)$u['id'], 'name' => $u['name'], 'email' => $u['email'], 'role' => $u['role']] : null,
        'community' => $x['comm'] ? ['id' => (int)$x['comm']['id'], 'name' => $x['comm']['name'], 'slug' => $x['comm']['slug']] : null,
        'profile' => $me ? ['id' => (int)$me['id'], 'code' => $me['profile_code'], 'name' => $me['full_name'], 'status' => $me['status']] : null,
    ];
}, true, false);
pl_action('me', fn($x) => ['profile' => pl_me($x['uid'], $x['cid'])], false, false);
pl_action('saved', fn($x) => ['profiles' => pl_saved($x['uid'], $x['cid'])], false, false);
pl_action('interests', fn($x) => pl_interests($x['uid'], $x['cid']), false, false);
pl_action('packages', fn($x) => ['packages' => pl_packages((int)$x['cid'])], true, false);
pl_action('my_packages', fn($x) => pl_my_packages($x['uid'], $x['cid']), false, false);
pl_action('communities',fn($x) => ['communities' => rows('SELECT id,name,slug FROM communities WHERE is_active=1 ORDER BY id')], true, false);

pl_action('create_profile', function ($x) {
    $r = pl_create_profile($x['uid'], $x['cid'], $_POST);
    if (empty($r['error']) && !empty($_FILES)) { $ph = pl_add_photos($x['uid'], $x['cid'], $_FILES); if (!empty($ph['error'])) $r['photo_error'] = $ph['error']; }
    return $r;
});
pl_action('update_profile', fn($x) => pl_update_profile($x['uid'], $x['cid'], $_POST));
pl_action('save_preferences', fn($x) => pl_save_prefs($x['uid'], $x['cid'], $_POST));
pl_action('upload_photos', fn($x) => pl_add_photos($x['uid'], $x['cid'], $_FILES));
pl_action('delete_photo', fn($x) => pl_delete_photo($x['uid'], $x['cid'], (int)($_POST['photo_id'] ?? 0)));
pl_action('set_primary_photo', fn($x) => pl_set_primary($x['uid'], $x['cid'], (int)($_POST['photo_id'] ?? 0)));
pl_action('send_interest', fn($x) => pl_send_interest($x['uid'], $x['cid'], (int)($_POST['profile_id'] ?? 0), (string)($_POST['interest_message'] ?? $_POST['message'] ?? '')));
pl_action('respond_interest', fn($x) => pl_respond_interest($x['uid'], $x['cid'], (int)($_POST['interest_id'] ?? 0), (string)($_POST['decision'] ?? '')));
pl_action('withdraw_interest', fn($x) => pl_withdraw_interest($x['uid'], $x['cid'], (int)($_POST['interest_id'] ?? 0)));
pl_action('matrimony_privacy', fn($x) => ($p = pl_my_profile($x['uid'], $x['cid'])) ? ['privacy' => pl_mat_privacy($p), 'is_active' => (bool)$p['is_active']] : ['error' => 'Create your profile first.'], false, false);
pl_action('matrimony_privacy_save', fn($x) => pl_save_mat_privacy($x['uid'], $x['cid'], $_POST));
pl_action('blocked_profiles', fn($x) => ['profiles' => pl_blocked_profiles($x['uid'])], false, false);
pl_action('block_profile',fn($x) => pl_block_profile($x['uid'], $x['cid'], (int)($_POST['profile_id'] ?? 0), ($_POST['block'] ?? '1') !== '0'));
pl_action('profile_set_active',fn($x) => pl_set_profile_active($x['uid'], $x['cid'], !empty($_POST['active'])));
pl_action('toggle_save',fn($x) => pl_toggle_save($x['uid'], (int)($_POST['profile_id'] ?? 0), $x['cid']));
pl_action('report_profile', fn($x) => pl_report($x['user'], $x['cid'], (int)($_POST['profile_id'] ?? 0), (string)($_POST['reason'] ?? '')));
pl_action('order_package', fn($x) => pl_order_package($x['uid'], $x['cid'], (int)($_POST['package_id'] ?? 0)));
pl_action('my_support_requests', fn($x) => ['requests' => pl_my_support_requests($x['uid'])], false, false);
pl_action('support_request',fn($x) => pl_support_request($x['user'], $x['cid'] ?: null, $_POST));

foreach (glob(__DIR__ . '/ext/*.php') ?: [] as $ext) require $ext;
require __DIR__ . '/jobs_api.php'; // after ext/ so the job-specific actions replace the generic registry ones

pl_action('save_device_token', fn($x) => pl_save_device_token($x['uid'], (string)($_POST['token'] ?? ''), (string)($_POST['platform'] ?? ''), (string)($_POST['device_id'] ?? ''), (string)($_POST['app_version'] ?? '')));
pl_action('remove_device_token', fn($x) => pl_remove_device_token($x['uid'], (string)($_POST['token'] ?? '')));
