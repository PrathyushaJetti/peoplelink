<?php
/* Matrimony packages run on the common payment engine: packages (module_key='matrimony') -> transactions -> user_packages.
   packages.contact_views = contact requests allowed per purchase (NULL = unlimited). user_packages.posts_used counts the credits used. */

function mat_package_out(array $p): array {
    return ['id' => (int)$p['id'], 'name' => $p['name'], 'price' => (float)$p['price'], 'validity_days' => (int)$p['validity_days'],
        'contact_views' => $p['contact_views'] === null ? null : (int)$p['contact_views'], 'description' => $p['description'],
        'features' => array_values(array_filter(array_map('trim', preg_split('/\R/', (string)$p['features'])))), 'is_featured' => (bool)$p['is_featured']];
}

function mat_packages(int $cid): array {
    // a community's own packages; communities without any use the default (global) set
    $own = rows("SELECT * FROM packages WHERE module_key=? AND is_active=1 AND community_id=? AND visibility_type<>'global' ORDER BY sort_order, price", [MAT_MODULE, $cid]);
    if (!$own) $own = rows("SELECT * FROM packages WHERE module_key=? AND is_active=1 AND visibility_type='global' ORDER BY sort_order, price", [MAT_MODULE]);
    return array_map('mat_package_out', $own);
}

function mat_package(int $id, int $cid): ?array {
    // only a package this community actually offers (its own set, or the default set when it has none)
    foreach (mat_packages($cid) as $p) if ($p['id'] === $id) return $p;
    return null;
}

/* Active (paid, not expired) matrimony packages of the user, oldest expiry first. */
function mat_active_packages(int $uid): array {
    db()->exec("UPDATE user_packages SET status='expired' WHERE status='active' AND expires_at < NOW()");
    return array_map(function ($r) {
        $limit = $r['contact_views'] === null ? null : (int)$r['contact_views'];
        return ['user_package_id' => (int)$r['id'], 'package_id' => (int)$r['package_id'], 'name' => $r['name'], 'starts_at' => $r['starts_at'], 'expires_at' => $r['expires_at'],
            'days_left' => max(0, (int)ceil((strtotime($r['expires_at']) - time()) / 86400)), 'contact_views' => $limit, 'used' => (int)$r['posts_used'],
            'remaining' => $limit === null ? null : max(0, $limit - (int)$r['posts_used'])];
    }, rows("SELECT up.*, p.name, p.contact_views FROM user_packages up LEFT JOIN packages p ON p.id=up.package_id
        WHERE up.user_id=? AND up.module_key=? AND up.status='active' AND up.expires_at >= NOW() ORDER BY up.expires_at", [$uid, MAT_MODULE]));
}

/* Summary used by the UI: one combined entitlement. remaining null = unlimited. */
function mat_entitlement(int $uid): array {
    $act = mat_active_packages($uid);
    if (!$act) return ['active' => false, 'packages' => [], 'remaining' => 0, 'expires_at' => null];
    $unlimited = (bool)array_filter($act, fn($a) => $a['remaining'] === null);
    return ['active' => true, 'packages' => $act, 'remaining' => $unlimited ? null : array_sum(array_column($act, 'remaining')), 'expires_at' => max(array_column($act, 'expires_at'))];
}

/* Takes one contact credit. Returns the user_package id used, 0 for unlimited, or null when nothing is left. */
function mat_use_credit(int $uid): ?int {
    foreach (mat_active_packages($uid) as $a) {
        if ($a['remaining'] === null) return 0;
        if ($a['remaining'] > 0) {
            // atomic: two requests at the same moment cannot use more credits than the package allows
            $s = db()->prepare("UPDATE user_packages SET posts_used=posts_used+1 WHERE id=? AND status='active' AND posts_used < ?");
            $s->execute([$a['user_package_id'], $a['contact_views']]);
            if ($s->rowCount() === 1) return $a['user_package_id'];
        }
    }
    return null;
}

function mat_refund_credit(?int $userPackageId): void {
    if ($userPackageId) db()->prepare('UPDATE user_packages SET posts_used=GREATEST(posts_used-1,0) WHERE id=?')->execute([$userPackageId]);
}

function mat_payment_history(int $uid): array {
    $new = array_map('pl_txn_out', rows('SELECT * FROM transactions WHERE user_id=? AND module_key=? ORDER BY id DESC LIMIT 100', [$uid, MAT_MODULE]));
    // orders placed with the old manual flow (matrimony_payments), shown read-only
    $old = array_map(fn($r) => ['id' => null, 'txn_code' => 'MAT-ORD-' . $r['id'], 'module' => MAT_MODULE, 'package' => $r['name'], 'amount' => (float)$r['amount'], 'currency' => 'INR',
        'status' => $r['status'], 'method' => 'manual', 'created_at' => $r['purchased_at'], 'paid_at' => $r['status'] === 'paid' ? $r['purchased_at'] : null, 'legacy' => true],
        rows('SELECT py.*, pk.name FROM matrimony_payments py JOIN matrimony_profiles pr ON pr.id=py.profile_id LEFT JOIN matrimony_packages pk ON pk.id=py.package_id WHERE pr.user_id=? ORDER BY py.id DESC', [$uid]));
    return array_merge($new, $old);
}
