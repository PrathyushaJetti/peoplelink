<?php
$GLOBALS['ROOT'] = '../';
require_once __DIR__ . '/../includes/bridge.php'; require_once __DIR__ . '/../includes/layout.php';
[$user, $comm] = require_login();
pl_ensure_schema();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_check(); $act = $_POST['action'] ?? ''; $id = (int)($_POST['id'] ?? 0);
    if ($act === 'toggle' && $id) {
        db()->prepare('UPDATE communities SET is_active = 1 - is_active WHERE id=?')->execute([$id]);
        flash('Community status changed'); back();
    }
    if ($act === 'seed') {
        $r = pl_seed_communities();
        flash($r['added'] . ' added, ' . $r['filled'] . ' content fields filled (of ' . $r['total'] . ' communities in file)'); back();
    }
    if ($act === 'bulk') {
        $added = 0;
        foreach (preg_split('/\r?\n/', (string)($_POST['names'] ?? '')) as $name) {
            $name = trim($name); $slug = pl_slugify($name);
            if ($name === '' || $slug === '' || scalar('SELECT COUNT(*) FROM communities WHERE slug=?', [$slug])) continue;
            db()->prepare('INSERT INTO communities (name,slug,is_active) VALUES (?,?,1)')->execute([mb_substr($name, 0, 80), $slug]); $added++;
        }
        flash($added . ' communit' . ($added === 1 ? 'y' : 'ies') . ' added', $added ? 'success' : 'error'); back();
    }
    if ($act === 'save') {
        $name = trim($_POST['name'] ?? ''); $slug = pl_slugify($_POST['slug'] ?? '') ?: pl_slugify($name);
        if ($name === '' || $slug === '') { flash('Name is required.', 'error'); back($id ? 'edit=' . $id : ''); }
        if (scalar('SELECT COUNT(*) FROM communities WHERE slug=? AND id<>?', [$slug, $id])) { flash('That slug is already used by another community.', 'error'); back($id ? 'edit=' . $id : ''); }
        $v = [mb_substr($name, 0, 80), $slug, !empty($_POST['is_active']) ? 1 : 0, (int)($_POST['sort_order'] ?? 0),
              trim($_POST['about'] ?? ''), trim($_POST['intro'] ?? ''), trim($_POST['history'] ?? '')];
        $cols = ['name', 'slug', 'is_active', 'sort_order', 'about', 'intro', 'history'];
        // Community Home configuration (content itself comes live from the modules by community_id)
        $order = [];
        foreach (array_keys(PL_HOME_MODULES) as $mk) if (!empty($_POST['hm_on'][$mk])) $order[$mk] = (int)($_POST['hm_order'][$mk] ?? 0);
        asort($order);
        array_push($cols, 'welcome_text', 'home_modules'); array_push($v, trim($_POST['welcome_text'] ?? ''), implode(',', array_keys($order)));
        $old = $id ? (rows('SELECT banner, about_banner FROM communities WHERE id=?', [$id])[0] ?? []) : [];
        foreach (['banner', 'about_banner'] as $img) {
            $f = $_FILES[$img] ?? null;
            if ($f && ($f['error'] ?? 4) !== UPLOAD_ERR_NO_FILE) {
                $up = pl_store_upload($f, 'communities');
                if (!empty($up['error'])) { flash($up['error'], 'error'); back($id ? 'edit=' . $id : ''); }
                pl_delete_file($old[$img] ?? null); $cols[] = $img; $v[] = $up['url'];
            } elseif (!empty($_POST['remove_' . $img])) { pl_delete_file($old[$img] ?? null); $cols[] = $img; $v[] = null; }
        }
        if ($id) { db()->prepare('UPDATE communities SET ' . implode(',', array_map(fn($c) => "$c=?", $cols)) . ' WHERE id=?')->execute(array_merge($v, [$id])); }
        else { db()->prepare('INSERT INTO communities (' . implode(',', $cols) . ') VALUES (' . implode(',', array_fill(0, count($cols), '?')) . ')')->execute($v); $id = (int)db()->lastInsertId(); }
        pl_audit('community_save', null, $id, $name, $id);
        flash('Community saved'); back('edit=' . $id);
    }
    back();
}

$editId = isset($_GET['edit']) ? (int)$_GET['edit'] : null;
$ed = $editId ? (rows('SELECT * FROM communities WHERE id=?', [$editId])[0] ?? null) : null;
$q = trim($_GET['q'] ?? '');
$list = rows('SELECT c.*, (SELECT COUNT(*) FROM matrimony_profiles p WHERE p.community_id=c.id) profiles FROM communities c' . ($q !== '' ? ' WHERE c.name LIKE ? OR c.slug LIKE ?' : '') . ' ORDER BY c.sort_order, c.name', $q !== '' ? ["%$q%", "%$q%"] : []);
$total = scalar('SELECT COUNT(*) FROM communities'); $live = scalar('SELECT COUNT(*) FROM communities WHERE is_active=1');
$filled = scalar("SELECT COUNT(*) FROM communities WHERE about<>'' AND intro<>'' AND history<>''");
render_header('Communities', 'Communities/All Communities', $user, $comm);

if ($editId !== null && ($ed || $editId === 0)): $ed = $ed ?: ['id' => 0, 'name' => '', 'slug' => '', 'is_active' => 1, 'sort_order' => 0]; ?>
<div class="card anim">
  <div class="card-h"><h3><?= $ed['id'] ? 'Edit community' : 'New community' ?></h3>
    <div class="actions"><?php if ($ed['id']): ?><a class="btn btn-line btn-sm" target="_blank" rel="noopener" href="<?= e(FRONTEND_URL . 'community-page.php?c=' . $ed['slug']) ?>"><?= icon('fa-arrow-up-right-from-square') ?> View page</a><?php endif; ?>
      <a class="btn btn-line btn-sm" href="communities.php"><?= icon('fa-arrow-left') ?> Back</a></div></div>
  <form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)$ed['id'] ?>">
    <div class="row2"><div><label>Community name</label><input name="name" required value="<?= e($ed['name']) ?>"></div><div><label>URL slug (page / subdomain name)</label><input name="slug" value="<?= e($ed['slug']) ?>" placeholder="auto from name"></div></div>
    <div class="row2"><div><label>Display order</label><input type="number" name="sort_order" value="<?= (int)($ed['sort_order'] ?? 0) ?>"></div><div><label>Visibility</label><select name="is_active"><option value="1" <?= $ed['is_active'] ? 'selected' : '' ?>>Active (page is live)</option><option value="" <?= $ed['is_active'] ? '' : 'selected' ?>>Inactive (hidden)</option></select></div></div>
    <label>About the Community</label><textarea name="about" rows="4"><?= e($ed['about'] ?? '') ?></textarea>
    <label>Community Introduction</label><textarea name="intro" rows="5"><?= e($ed['intro'] ?? '') ?></textarea>
    <label>Community History</label><textarea name="history" rows="6"><?= e($ed['history'] ?? '') ?></textarea>
    <label>About page banner / image (optional)</label>
    <?php if (!empty($ed['about_banner'])): ?><div class="imgrow"><img class="thumb lg" src="<?= e($ed['about_banner']) ?>" alt=""><label class="chk"><input type="checkbox" name="remove_about_banner" value="1"> Remove</label></div><?php endif; ?>
    <input type="file" name="about_banner" accept="image/jpeg,image/png,image/webp">
    <h3 class="mt">Community Home</h3><small class="muted">Home content is pulled live from Matrimony, Jobs, Directory, Marketplace, Events, Support and Leadership for this community — nothing is entered twice.</small>
    <label>Home banner</label>
    <?php if (!empty($ed['banner'])): ?><div class="imgrow"><img class="thumb lg" src="<?= e($ed['banner']) ?>" alt=""><label class="chk"><input type="checkbox" name="remove_banner" value="1"> Remove</label></div><?php endif; ?>
    <input type="file" name="banner" accept="image/jpeg,image/png,image/webp">
    <label>Welcome text</label><textarea name="welcome_text" rows="3"><?= e($ed['welcome_text'] ?? '') ?></textarea>
    <label>Modules on the home page (tick to show, number = display order)</label>
    <?php $hm = array_filter(explode(',', (string)($ed['home_modules'] ?? ''))) ?: array_keys(PL_HOME_MODULES); ?>
    <div class="chips"><?php foreach (PL_HOME_MODULES as $mk => $ml): $pos = array_search($mk, $hm, true); ?>
      <label class="chk"><input type="checkbox" name="hm_on[<?= $mk ?>]" value="1" <?= $pos !== false ? 'checked' : '' ?>> <?= e($ml) ?> <input type="number" name="hm_order[<?= $mk ?>]" value="<?= $pos !== false ? $pos + 1 : count($hm) + 1 ?>" class="sel-sm" style="width:64px"></label><?php endforeach; ?></div>
    <div class="dlg-actions"><a class="btn btn-line" href="communities.php">Cancel</a><button class="btn btn-primary"><?= icon('fa-floppy-disk') ?> Save community</button></div>
  </form>
</div>
<?php else: ?>
<div class="stats anim">
  <div class="stat c-blue"><div class="ic"><?= icon('fa-people-group') ?></div><div class="n" data-count="<?= $total ?>">0</div><div class="l">Total communities</div></div>
  <div class="stat c-purple"><div class="ic"><?= icon('fa-circle-check') ?></div><div class="n" data-count="<?= $live ?>">0</div><div class="l">Live pages</div></div>
  <div class="stat c-orange"><div class="ic"><?= icon('fa-pen-to-square') ?></div><div class="n" data-count="<?= $filled ?>">0</div><div class="l">Content filled</div></div>
  <div class="stat c-red"><div class="ic"><?= icon('fa-hourglass-half') ?></div><div class="n" data-count="<?= max(0, $total - $filled) ?>">0</div><div class="l">Content pending</div></div>
</div>
<div class="card anim">
  <form class="toolbar" method="get"><input class="grow" name="q" value="<?= e($q) ?>" placeholder="Search community or slug"><button class="btn btn-primary"><?= icon('fa-magnifying-glass') ?> Search</button>
    <a class="btn btn-line" href="?edit=0"><?= icon('fa-plus') ?> New community</a><button type="button" class="btn btn-line" data-open="bulkDlg"><?= icon('fa-list') ?> Add many</button></form>
  <form class="inline" method="post" data-confirm="Import the 43 communities and their About / Introduction / History text? Existing text you already entered is not overwritten."><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="seed"><button class="btn btn-primary btn-sm mt"><?= icon('fa-file-import') ?> Import 43 communities</button></form>
  <?php if (!$list): ?><div class="empty"><?= icon('fa-people-group', 'big') ?>No communities found.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Community</th><th>Page address</th><th>Matrimony profiles</th><th>Content</th><th>Status</th><th>Actions</th></tr></thead><tbody>
  <?php foreach ($list as $r): $has = trim((string)$r['intro']) !== ''; ?><tr>
    <td data-label="Community"><div class="person"><div class="pi"><?= e(mb_substr($r['name'], 0, 1)) ?></div><div><b><?= e($r['name']) ?></b></div></div></td>
    <td data-label="Page address"><small><?= USE_SUBDOMAINS ? e($r['slug'] . '.' . BASE_DOMAIN) : 'community-page.php?c=' . e($r['slug']) ?></small></td>
    <td data-label="Profiles"><?= (int)$r['profiles'] ?></td>
    <td data-label="Content"><?= badge($has ? 'approved' : 'pending', $has ? 'filled' : 'default text') ?></td>
    <td data-label="Status"><?= badge($r['is_active'] ? 'active' : 'inactive') ?></td>
    <td data-label="Actions"><div class="actions"><a class="btn btn-sm btn-blue" href="?edit=<?= (int)$r['id'] ?>"><?= icon('fa-pen') ?> Edit</a>
      <a class="btn btn-sm btn-line" target="_blank" rel="noopener" href="<?= e(FRONTEND_URL . 'community-page.php?c=' . $r['slug']) ?>"><?= icon('fa-eye') ?> View</a>
      <form class="inline" method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
        <button class="btn btn-sm <?= $r['is_active'] ? 'btn-orange' : 'btn-line' ?>"><?= $r['is_active'] ? 'Deactivate' : 'Activate' ?></button></form></div></td></tr>
  <?php endforeach; ?></tbody></table></div><?php endif; ?>
</div>
<dialog id="bulkDlg"><h3>Add many communities</h3><small class="muted">One community name per line. Existing names are skipped.</small>
  <form method="post"><input type="hidden" name="csrf" value="<?= csrf_token() ?>"><input type="hidden" name="action" value="bulk">
    <label>Community names</label><textarea name="names" rows="10" required placeholder="Arya Vysya&#10;Reddy&#10;Kamma"></textarea>
    <div class="dlg-actions"><button type="button" class="btn btn-line" data-close>Cancel</button><button class="btn btn-primary">Add communities</button></div></form></dialog>
<?php endif;
render_footer();
