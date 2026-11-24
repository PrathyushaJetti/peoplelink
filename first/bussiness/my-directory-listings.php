<?php
// My Directory Profiles (live: directory_my / directory_delete / directory_enquiries)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['do'] ?? '') === 'delete') web_post('directory_delete', 'my-directory-listings.php');
$_REQUEST['per'] = 50; $_REQUEST['page'] = 1;
$myItems = array_map('web_dir_card', web_call('directory_my', ['per' => 50])['items'] ?? []);
$myIds = array_map('intval', array_column($myItems, 'id'));
$myRows = $myIds ? array_column(rows('SELECT id, status, is_active, views, admin_notes FROM directory_profiles WHERE id IN (' . implode(',', $myIds) . ')'), null, 'id') : [];
$myEnq = web_call('directory_enquiries')['enquiries'] ?? [];
$stLabel = ['approved' => ['Active', '#067647', '#ecfdf3'], 'pending' => ['Pending Approval', '#b54708', '#fffaeb'], 'rejected' => ['Rejected', '#b42318', '#fef3f2']];
$pageTitle = 'My Directory Profiles';
include 'header.php'; ?>
<main style="background:#f5f8fc;padding:32px 0 64px;min-height:60vh">
  <div style="max-width:1100px;margin:0 auto;padding:0 18px">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:18px">
      <div><span style="font-size:.78rem;font-weight:800;letter-spacing:.08em;color:#f7941d">PEOPLELINK DIRECTORY</span><h1 style="margin:4px 0 6px;color:#0b2545">My Directory Profiles</h1><p style="margin:0;color:#5b6b7f">Your professional and business profiles, their approval status and the enquiries you receive.</p></div>
      <div style="display:flex;gap:10px;flex-wrap:wrap"><a href="submit-professional-business-listing.php?type=Professional" style="background:#0b4f8c;color:#fff;padding:10px 16px;border-radius:10px;text-decoration:none;font-weight:700"><i class="bi bi-person-plus"></i> Add Professional</a><a href="submit-professional-business-listing.php?type=Business" style="background:#f7941d;color:#fff;padding:10px 16px;border-radius:10px;text-decoration:none;font-weight:700"><i class="bi bi-building-add"></i> Add Business</a></div>
    </div>
    <?= web_flash_html() ?>
    <?php if (!$myItems): ?><div style="background:#fff;border-radius:16px;padding:28px;text-align:center;color:#5b6b7f">You have not added a directory profile yet.</div><?php endif; ?>
    <div style="display:grid;gap:14px">
    <?php foreach ($myItems as $d): $row = $myRows[$d['id']] ?? []; [$sl, $sc, $sb] = $stLabel[$row['status'] ?? 'pending'] ?? [ucfirst((string)($row['status'] ?? '')), '#475467', '#f2f4f7']; if (($row['status'] ?? '') === 'approved' && empty($row['is_active'])) [$sl, $sc, $sb] = ['Deactivated by admin', '#475467', '#f2f4f7']; ?>
      <article style="background:#fff;border:1px solid #e4e9f2;border-radius:16px;padding:16px;display:grid;grid-template-columns:72px 1fr;gap:16px;align-items:start">
        <div style="width:72px;height:72px;border-radius:14px;background:#e8f1fb;display:grid;place-items:center;overflow:hidden;font-weight:800;color:#0b4f8c"><?php if ($d['image']): ?><img src="<?= h($d['image']) ?>" alt="" style="width:100%;height:100%;object-fit:cover"><?php else: ?><?= h($d['initials']) ?><?php endif; ?></div>
        <div>
          <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap"><div><small style="color:#5b6b7f;font-weight:700"><?= h(strtoupper($d['profile_type'])) ?> · <?= h($d['category_text']) ?></small><h3 style="margin:2px 0;color:#0b2545"><?= h($d['title']) ?></h3><div style="color:#5b6b7f;font-size:.92rem"><i class="bi bi-geo-alt"></i> <?= h($d['location_text']) ?></div></div>
            <span style="align-self:flex-start;padding:5px 12px;border-radius:999px;font-weight:700;font-size:.82rem;color:<?= $sc ?>;background:<?= $sb ?>"><?= h($sl) ?></span></div>
          <?php if (($row['status'] ?? '') === 'rejected' && !empty($row['admin_notes'])): ?><p style="margin:8px 0 0;color:#b42318"><strong>Admin note:</strong> <?= h($row['admin_notes']) ?></p><?php endif; ?>
          <div style="display:flex;gap:16px;flex-wrap:wrap;margin:10px 0;color:#475467;font-size:.9rem"><span><i class="bi bi-eye"></i> <?= (int)($row['views'] ?? 0) ?> views</span><span><i class="bi bi-envelope"></i> <?= count(array_filter($myEnq, fn($q) => (int)$q['item_id'] === (int)$d['id'])) ?> enquiries</span><span><i class="bi bi-calendar3"></i> Added <?= h(date('d M Y', strtotime($d['created_at']))) ?></span></div>
          <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="professional-business-profile-details.php?id=<?= (int)$d['id'] ?>" style="padding:8px 14px;border:1px solid #cbd5e1;border-radius:9px;text-decoration:none;color:#0b2545;font-weight:600"><i class="bi bi-eye"></i> View</a>
            <a href="submit-professional-business-listing.php?edit=<?= (int)$d['id'] ?>" style="padding:8px 14px;border:1px solid #cbd5e1;border-radius:9px;text-decoration:none;color:#0b2545;font-weight:600"><i class="bi bi-pencil"></i> <?= ($row['status'] ?? '') === 'rejected' ? 'Edit &amp; Resubmit' : 'Edit' ?></a>
            <form method="post" onsubmit="return confirm('Delete this profile permanently?')" style="margin:0"><?= web_csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= (int)$d['id'] ?>"><button type="submit" style="padding:8px 14px;border:1px solid #fecdca;background:#fef3f2;color:#b42318;border-radius:9px;font-weight:600;cursor:pointer"><i class="bi bi-trash"></i> Delete</button></form>
          </div>
        </div>
      </article>
    <?php endforeach; ?>
    </div>

    <h2 style="margin:34px 0 12px;color:#0b2545">Enquiries Received <small style="color:#5b6b7f;font-weight:600">(<?= count($myEnq) ?>)</small></h2>
    <?php if (!$myEnq): ?><div style="background:#fff;border-radius:16px;padding:20px;color:#5b6b7f">No enquiries yet. Members' messages about your profiles appear here.</div><?php endif; ?>
    <div style="display:grid;gap:12px">
    <?php foreach ($myEnq as $q): $tel = preg_replace('/[^\d+]/', '', (string)$q['phone']); $wa = preg_replace('/\D/', '', $tel); if (strlen($wa) === 10) $wa = '91' . $wa; ?>
      <article style="background:#fff;border:1px solid #e4e9f2;border-radius:14px;padding:14px 16px">
        <div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap"><strong><?= h($q['name'] ?: 'Member') ?></strong><small style="color:#64748b"><?= h(date('d M Y, h:i A', strtotime($q['created_at']))) ?> · <a href="professional-business-profile-details.php?id=<?= (int)$q['item_id'] ?>"><?= h($q['item_title'] ?? 'Profile') ?></a></small></div>
        <?php if (trim((string)$q['message']) !== ''): ?><p style="margin:8px 0;white-space:pre-line"><?= h($q['message']) ?></p><?php endif; ?>
        <div style="display:flex;gap:14px;flex-wrap:wrap;font-size:.92rem"><?php if ($tel): ?><a href="tel:<?= h($tel) ?>"><i class="bi bi-telephone"></i> <?= h($q['phone']) ?></a><a href="https://wa.me/<?= h($wa) ?>" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i> WhatsApp</a><?php endif; ?><?php if ($q['email']): ?><a href="mailto:<?= h($q['email']) ?>"><i class="bi bi-envelope"></i> <?= h($q['email']) ?></a><?php endif; ?></div>
      </article>
    <?php endforeach; ?>
    </div>
  </div>
</main>
<?php include 'footer.php'; ?>
