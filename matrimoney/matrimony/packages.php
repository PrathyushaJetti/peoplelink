<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/auth.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login(); $cid = $comm['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $act = $_POST['action'] ?? ''; $id = (int)($_POST['id'] ?? 0);
    if ($act === 'save') {
        $name = trim($_POST['name'] ?? ''); $price = (int)($_POST['price'] ?? 0); $days = (int)($_POST['validity_days'] ?? 0);
        if ($name === '' || $price <= 0 || $days <= 0) flash('Enter a name, a price and validity in days.', 'error');
        elseif ($id) { db()->prepare('UPDATE matrimony_packages SET name=?,price=?,validity_days=? WHERE id=? AND community_id=?')->execute([$name, $price, $days, $id, $cid]); flash('Package updated'); }
        else { db()->prepare('INSERT INTO matrimony_packages (community_id,name,price,validity_days) VALUES (?,?,?,?)')->execute([$cid, $name, $price, $days]); flash('Package created'); }
    } elseif ($act === 'toggle' && $id) {
        db()->prepare('UPDATE matrimony_packages SET is_active = 1 - is_active WHERE id=? AND community_id=?')->execute([$id, $cid]); flash('Package status changed');
    }
    back();
}
$list = rows('SELECT pk.*, (SELECT COUNT(*) FROM matrimony_payments py WHERE py.package_id=pk.id AND py.status=\'paid\') sold FROM matrimony_packages pk WHERE community_id=? ORDER BY price', [$cid]);
render_header('Matrimony Packages', 'Matrimony/Packages', $user, $comm); ?>
<div class="card-h anim"><div><h3>Subscription plans</h3><small class="muted">Plans members can buy for this community.</small></div>
  <button class="btn btn-primary" data-open="pkgDlg" data-title="Create package"><?= icon('fa-plus') ?> Create package</button></div>
<?php if (!$list): ?><div class="card"><div class="empty"><?= icon('fa-gift','big') ?>No packages yet. Create the first one.</div></div><?php else: ?>
<div class="plans"><?php foreach ($list as $i => $pk): $fill = e(json_encode(['id' => $pk['id'], 'name' => $pk['name'], 'price' => $pk['price'], 'validity_days' => $pk['validity_days']])); ?>
  <div class="plan <?= $pk['is_active'] ? '' : 'off' ?>" style="animation-delay:<?= $i * .07 ?>s">
    <div class="plan-h"><h3><?= e($pk['name']) ?></h3><?= badge($pk['is_active'] ? 'active' : 'inactive') ?></div>
    <div class="pr"><?= money($pk['price']) ?> <small>/ <?= (int)$pk['validity_days'] ?> days</small></div>
    <ul><li>Valid for <?= (int)$pk['validity_days'] ?> days</li><li><?= (int)$pk['sold'] ?> purchase<?= $pk['sold'] == 1 ? '' : 's' ?> so far</li></ul>
    <div class="actions"><button class="btn btn-sm btn-blue" data-open="pkgDlg" data-title="Edit package" data-fill="<?= $fill ?>"><?= icon('fa-pen') ?> Edit</button>
      <form class="inline" method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int)$pk['id'] ?>">
        <button class="btn btn-sm <?= $pk['is_active'] ? 'btn-orange' : 'btn-line' ?>"><?= $pk['is_active'] ? 'Deactivate' : 'Activate' ?></button></form></div></div>
<?php endforeach; ?></div><?php endif; ?>
<dialog id="pkgDlg"><h3 data-dtitle>Create package</h3><small class="muted">Set the plan name, price and validity.</small>
  <form method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="0" data-keep>
    <label>Package name</label><input name="name" required placeholder="e.g. Gold">
    <div class="row2"><div><label>Price (₹)</label><input type="number" name="price" min="1" required></div><div><label>Validity (days)</label><input type="number" name="validity_days" min="1" required></div></div>
    <div class="dlg-actions"><button type="button" class="btn btn-line" data-close>Cancel</button><button class="btn btn-primary">Save package</button></div></form></dialog>
<?php render_footer();
