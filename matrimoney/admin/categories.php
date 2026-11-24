<?php
// Categories & subcategories (one table for all modules): categories.php?m=marketplace | directory | events | support
require __DIR__ . '/_boot.php';
$mods = ['marketplace' => 'Marketplace', 'directory' => 'Professional & Business Directory', 'events' => 'Events', 'support' => 'Community Support (assistance types)', 'jobs' => 'Jobs'];
$m = isset($mods[$_GET['m'] ?? '']) ? $_GET['m'] : 'marketplace';
$self = 'categories.php?m=' . $m;

function pl_cat_usage(string $m, int $id): int {
    $n = 0;
    foreach (pl_entity_keys() as $k) {
        $E = pl_entity($k);
        if ($E['cat'] !== $m) continue;
        foreach ($E['fields'] as $col => $f) if (in_array($f['type'], ['category', 'subcategory'], true)) $n += scalar("SELECT COUNT(*) FROM {$E['table']} WHERE $col=?", [$id]);
    }
    return $n;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $act = $_POST['action'] ?? ''; $id = (int)($_POST['id'] ?? 0);
    $own = $id ? rows('SELECT * FROM categories WHERE id=? AND module=?', [$id, $m])[0] ?? null : null;
    if ($act === 'save') {
        $name = mb_substr(trim((string)($_POST['name'] ?? '')), 0, 120);
        $parent = (int)($_POST['parent_id'] ?? 0) ?: null;
        if ($parent && !scalar('SELECT COUNT(*) FROM categories WHERE id=? AND module=? AND parent_id IS NULL', [$parent, $m])) $parent = null;
        if ($name === '') flash('Name is required.', 'error');
        elseif ($own) {
            if ($parent === $id || ($parent && scalar('SELECT COUNT(*) FROM categories WHERE parent_id=?', [$id]))) $parent = $own['parent_id'];
            db()->prepare('UPDATE categories SET name=?, slug=?, parent_id=?, sort_order=?, icon=? WHERE id=?')->execute([$name, pl_slugify($name), $parent, (int)($_POST['sort_order'] ?? 0), mb_substr(trim((string)($_POST['icon'] ?? '')), 0, 60), $id]);
            pl_audit('category_update', null, $id, $name); flash('Category saved');
        } else {
            db()->prepare('INSERT INTO categories (module, parent_id, name, slug, sort_order, icon) VALUES (?,?,?,?,?,?)')->execute([$m, $parent, $name, pl_slugify($name), (int)($_POST['sort_order'] ?? 0), mb_substr(trim((string)($_POST['icon'] ?? '')), 0, 60)]);
            pl_audit('category_create', null, (int)db()->lastInsertId(), $name); flash('Category added');
        }
    } elseif ($own && $act === 'toggle') {
        db()->prepare('UPDATE categories SET is_active=? WHERE id=? OR parent_id=?')->execute([$own['is_active'] ? 0 : 1, $id, $own['parent_id'] ? -1 : $id]);
        flash('Category ' . ($own['is_active'] ? 'deactivated' : 'activated'));
    } elseif ($own && $act === 'delete') {
        $used = pl_cat_usage($m, $id);
        foreach (rows('SELECT id FROM categories WHERE parent_id=?', [$id]) as $s) $used += pl_cat_usage($m, (int)$s['id']);
        if ($used) flash("This category is used by $used records. Deactivate it instead.", 'error');
        else { db()->prepare('DELETE FROM categories WHERE id=? OR parent_id=?')->execute([$id, $id]); pl_audit('category_delete', null, $id, $own['name']); flash('Category deleted'); }
    }
    header('Location: ' . $self); exit;
}

$cats = pl_categories($m, false);
render_header('Categories — ' . $mods[$m], 'auto', $user, $comm); ?>
<div class="tabs anim"><?php foreach ($mods as $k => $l): ?><a class="<?= $k === $m ? 'on' : '' ?>" href="?m=<?= $k ?>"><?= e($l) ?></a><?php endforeach; ?></div>
<div class="grid2 anim">
  <div class="card"><div class="card-h"><h3>Categories & subcategories</h3><button type="button" class="btn btn-sm btn-primary" data-open="catDlg" data-title="New category" data-fill="<?= e(json_encode(['id' => 0, 'name' => '', 'parent_id' => '', 'sort_order' => 0, 'icon' => ''])) ?>"><?= icon('fa-plus') ?> Add</button></div>
    <?php if (!$cats): ?><div class="empty"><?= icon('fa-tags', 'big') ?>No categories.</div><?php else: ?>
    <div class="tw"><table class="rt"><thead><tr><th>Name</th><th>Order</th><th>Status</th><th>Actions</th></tr></thead><tbody>
    <?php foreach ($cats as $c): foreach (array_merge([$c], $c['subcategories']) as $row): $isSub = (bool)$row['parent_id'];
        $fill = e(json_encode(['id' => $row['id'], 'name' => $row['name'], 'parent_id' => $row['parent_id'] ?? '', 'sort_order' => $row['sort_order'], 'icon' => $row['icon'] ?? ''])); ?>
      <tr><td data-label="Name"><?= $isSub ? '<span class="muted">└</span> ' . e($row['name']) : '<b>' . e($row['name']) . '</b> <small class="muted">(' . count($c['subcategories']) . ' sub)</small>' ?></td>
        <td data-label="Order"><?= (int)$row['sort_order'] ?></td><td data-label="Status"><?= badge($row['is_active'] ? 'active' : 'inactive') ?></td>
        <td data-label="Actions"><div class="actions"><button type="button" class="btn btn-sm btn-line" data-open="catDlg" data-title="Edit category" data-fill="<?= $fill ?>"><?= icon('fa-pen') ?></button>
          <form class="inline" method="post"><?= pl_csrf_field() ?><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><button class="btn btn-sm <?= $row['is_active'] ? 'btn-orange' : 'btn-line' ?>"><?= $row['is_active'] ? 'Deactivate' : 'Activate' ?></button></form>
          <form class="inline" method="post" data-confirm="Delete this category<?= $isSub ? '' : ' and its subcategories' ?>?"><?= pl_csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><button class="btn btn-sm btn-red"><?= icon('fa-trash') ?></button></form></div></td></tr>
    <?php endforeach; endforeach; ?></tbody></table></div><?php endif; ?></div>
  <div class="card"><div class="card-h"><h3>How it works</h3></div>
    <p class="muted">Categories are shown in the app's filters and posting forms. A category that is already used by listings or profiles cannot be deleted; deactivate it to hide it from new posts.</p>
    <p class="muted">The app reads this list from <code>api.php?action=<?= e(['marketplace' => 'marketplace_categories', 'directory' => 'directory_categories', 'events' => 'events_categories', 'support' => 'support_categories', 'jobs' => 'jobs_categories'][$m]) ?></code>.</p></div>
</div>
<dialog id="catDlg"><h3 data-dtitle>Category</h3>
  <form method="post"><?= pl_csrf_field() ?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="0" data-keep>
    <label>Name</label><input name="name" required maxlength="120">
    <label>Parent (leave empty for a main category)</label><select name="parent_id"><option value="">— Main category —</option><?php foreach ($cats as $c): ?><option value="<?= (int)$c['id'] ?>"><?= e($c['name']) ?></option><?php endforeach; ?></select>
    <div class="row2"><div><label>Display order</label><input type="number" name="sort_order" value="0"></div><div><label>Icon (Font Awesome, optional)</label><input name="icon" placeholder="fa-car"></div></div>
    <div class="dlg-actions"><button type="button" class="btn btn-line" data-close>Cancel</button><button class="btn btn-primary">Save</button></div></form></dialog>
<?php render_footer();
