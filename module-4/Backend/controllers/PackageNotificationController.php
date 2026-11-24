<?php
/* Packages + payments (common Razorpay engine) and matrimony notifications. */

/* packages: matrimony packages from the common packages table (same response key as before) */
pl_action('packages', fn($x) => ['packages' => mat_packages((int)$x['cid'])], true, false);
pl_action('package_details', function ($x) {
    $p = mat_package((int)($_GET['id'] ?? 0), (int)$x['cid']);
    return $p ? ['package' => $p] : mat_err('Package not found.', 'PACKAGE_NOT_FOUND', 404);
}, true, false);

/* my_packages: active entitlement + payment history */
pl_action('my_packages', function ($x) {
    $e = mat_entitlement($x['uid']);
    return ['active' => $e['packages'][0] ?? null, 'entitlement' => $e, 'orders' => mat_payment_history($x['uid'])];
}, false, false);

/* order_package: creates a Razorpay order for a matrimony package. The price is read on the server. Finish with payment_verify. */
pl_action('order_package', function ($x) {
    if (!pl_my_profile($x['uid'], $x['cid'])) return mat_err('Create your matrimony profile first.', 'PROFILE_REQUIRED');
    $pk = mat_package((int)($_POST['package_id'] ?? 0), (int)$x['cid']);
    if (!$pk) return mat_err('This package is not available.', 'PACKAGE_NOT_FOUND', 404);
    return pl_txn_create($x['user'], $x['cid'], $pk['id']);
});

pl_action('matrimony_notifications', function ($x) {
    [$page, $per] = mat_page();
    $me = pl_my_profile($x['uid'], $x['cid'] ?: null);
    $r = mat_paged(mat_notifications($x['uid'], (int)$x['cid'], $me), $page, $per, 'notifications');
    $r['unread'] = scalar('SELECT COUNT(*) FROM user_notifications WHERE user_id=? AND is_read=0 AND type=?', [$x['uid'], MAT_NOTIFY_TYPE]);
    return $r;
}, false, false);
pl_action('matrimony_notification_read', fn($x) => mat_notification_read($x['uid'], (string)($_POST['id'] ?? ''), !empty($_POST['all'])));
