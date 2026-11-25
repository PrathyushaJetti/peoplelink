<?php
// My Directory Profiles (live: directory_my / directory_delete / directory_enquiries) — styled with the site theme (first/css/pl-live.css)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['do'] ?? '') === 'delete') web_post('directory_delete', 'my-directory-listings.php');
$_REQUEST['per'] = 50; $_REQUEST['page'] = 1;
$myItems = array_map('web_dir_card', web_call('directory_my', ['per' => 50])['items'] ?? []);
$myIds = array_map('intval', array_column($myItems, 'id'));
$myRows = $myIds ? array_column(rows('SELECT id, status, is_active, views, admin_notes FROM directory_profiles WHERE id IN (' . implode(',', $myIds) . ')'), null, 'id') : [];
$myEnq = web_call('directory_enquiries')['enquiries'] ?? [];
function mdl_status(array $row): array {
    $s = $row['status'] ?? 'pending';
    if ($s === 'approved' && empty($row['is_active'])) return ['is-closed', 'Deactivated by admin'];
    return [['approved' => 'is-active', 'pending' => 'is-pending', 'rejected' => 'is-rejected'][$s] ?? 'is-closed',
            ['approved' => 'Active', 'pending' => 'Pending Approval', 'rejected' => 'Rejected'][$s] ?? ucfirst($s)];
}
include 'header.php'; ?>
<link rel="stylesheet" href="/peoplelink/first/css/pl-live.css?v=1">
<main class="plv-page">
    <section class="plv-hero">
        <div class="plv-container plv-hero-inner">
            <div>
                <span class="plv-kicker"><i class="fa-solid fa-address-book"></i> PeopleLink Directory</span>
                <h1>My Directory Profiles</h1>
                <p>Manage your professional and business profiles, follow their approval status and reply to enquiries from community members.</p>
            </div>
            <div class="plv-hero-actions">
                <a class="plv-btn plv-btn-white" href="submit-professional-business-listing.php?type=Professional"><i class="fa-solid fa-user-plus"></i> Add Professional</a>
                <a class="plv-btn plv-btn-orange" href="submit-professional-business-listing.php?type=Business"><i class="fa-solid fa-building"></i> Add Business</a>
            </div>
        </div>
    </section>
    <?= web_flash_html() ?>

    <div class="plv-container">
        <section class="plv-card plv-section">
            <div class="plv-section-head">
                <span class="plv-section-icon"><i class="fa-solid fa-id-card"></i></span>
                <div><h2>Your Profiles</h2><p>View, edit or remove the profiles you have added to the directory.</p></div>
                <span class="plv-count"><?= count($myItems) ?> profile<?= count($myItems) === 1 ? '' : 's' ?></span>
            </div>
            <?php if (!$myItems): ?>
                <div class="plv-empty"><i class="fa-regular fa-address-card"></i><h3>No directory profile yet</h3><p>Add your professional or business profile so community members can find you.</p></div>
            <?php endif; ?>
            <?php foreach ($myItems as $d): $row = $myRows[$d['id']] ?? []; [$sc, $sl] = mdl_status($row); $enqN = count(array_filter($myEnq, fn($q) => (int)$q['item_id'] === (int)$d['id'])); ?>
            <article class="plv-item">
                <div class="plv-avatar"><?php if ($d['image']): ?><img src="<?= h($d['image']) ?>" alt=""><?php else: ?><?= h($d['initials']) ?><?php endif; ?></div>
                <div>
                    <div class="plv-item-top">
                        <div>
                            <span class="plv-eyebrow"><?= h($d['profile_type']) ?> · <?= h($d['category_text']) ?></span>
                            <h3><?= h($d['title']) ?></h3>
                        </div>
                        <span class="plv-status <?= $sc ?>"><?= h($sl) ?></span>
                    </div>
                    <?php if (($row['status'] ?? '') === 'rejected' && !empty($row['admin_notes'])): ?><p class="plv-note"><strong>Admin note:</strong> <?= h($row['admin_notes']) ?></p><?php endif; ?>
                    <div class="plv-meta">
                        <span><i class="fa-solid fa-location-dot"></i><?= h($d['location_text']) ?></span>
                        <span><i class="fa-regular fa-eye"></i><?= (int)($row['views'] ?? 0) ?> views</span>
                        <span><i class="fa-regular fa-envelope"></i><?= $enqN ?> enquir<?= $enqN === 1 ? 'y' : 'ies' ?></span>
                        <span><i class="fa-regular fa-calendar"></i>Added <?= h(date('d M Y', strtotime($d['created_at']))) ?></span>
                    </div>
                    <div class="plv-actions">
                        <a class="plv-btn plv-btn-outline plv-btn-sm" href="professional-business-profile-details.php?id=<?= (int)$d['id'] ?>"><i class="fa-regular fa-eye"></i> View</a>
                        <a class="plv-btn plv-btn-primary plv-btn-sm" href="submit-professional-business-listing.php?edit=<?= (int)$d['id'] ?>"><i class="fa-regular fa-pen-to-square"></i> <?= ($row['status'] ?? '') === 'rejected' ? 'Edit &amp; Resubmit' : 'Edit' ?></a>
                        <form method="post" onsubmit="return confirm('Delete this profile permanently?')"><?= web_csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= (int)$d['id'] ?>"><button type="submit" class="plv-btn plv-btn-danger plv-btn-sm"><i class="fa-regular fa-trash-can"></i> Delete</button></form>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>
        </section>

        <section class="plv-card plv-section">
            <div class="plv-section-head">
                <span class="plv-section-icon orange"><i class="fa-solid fa-envelope-open-text"></i></span>
                <div><h2>Enquiries Received</h2><p>Messages from members interested in your services.</p></div>
                <span class="plv-count"><?= count($myEnq) ?> enquir<?= count($myEnq) === 1 ? 'y' : 'ies' ?></span>
            </div>
            <?php if (!$myEnq): ?>
                <div class="plv-empty"><i class="fa-regular fa-comments"></i><h3>No enquiries yet</h3><p>When members contact you about a profile, their messages appear here.</p></div>
            <?php endif; ?>
            <?php foreach ($myEnq as $q): $tel = preg_replace('/[^\d+]/', '', (string)$q['phone']); $wa = preg_replace('/\D/', '', $tel); if (strlen($wa) === 10) $wa = '91' . $wa; ?>
            <article class="plv-enquiry">
                <div class="plv-enquiry-top"><strong><?= h($q['name'] ?: 'Member') ?></strong><small><?= h(date('d M Y, h:i A', strtotime($q['created_at']))) ?> · <a href="professional-business-profile-details.php?id=<?= (int)$q['item_id'] ?>"><?= h($q['item_title'] ?? 'Profile') ?></a></small></div>
                <?php if (trim((string)$q['message']) !== ''): ?><p><?= h($q['message']) ?></p><?php endif; ?>
                <div class="plv-enquiry-links">
                    <?php if ($tel): ?><a href="tel:<?= h($tel) ?>"><i class="fa-solid fa-phone"></i> <?= h($q['phone']) ?></a><a class="wa" href="https://wa.me/<?= h($wa) ?>" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><?php endif; ?>
                    <?php if ($q['email']): ?><a href="mailto:<?= h($q['email']) ?>"><i class="fa-regular fa-envelope"></i> <?= h($q['email']) ?></a><?php endif; ?>
                </div>
            </article>
            <?php endforeach; ?>
        </section>
    </div>
</main>
<?php include 'footer.php'; ?>
