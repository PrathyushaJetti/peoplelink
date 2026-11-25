<?php
// My Marketplace Listings (live: marketplace_my / marketplace_close / marketplace_delete / marketplace_enquiries)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $do = ['close' => 'marketplace_close', 'sold' => 'marketplace_close', 'delete' => 'marketplace_delete'][$_POST['do'] ?? ''] ?? null;
    if ($do) web_post($do, 'my-marketplace-listings.php');
}
$_REQUEST['per'] = 50; $_REQUEST['page'] = 1;
$mmItems = array_map('web_mp_card', web_call('marketplace_my', ['per' => 50])['items'] ?? []);
$mmIds = array_map('intval', array_column($mmItems, 'id'));
$mmRows = $mmIds ? array_column(rows('SELECT id, status, views FROM mp_listings WHERE id IN (' . implode(',', $mmIds) . ')'), null, 'id') : [];
$mmEnq = $mmIds ? array_column(rows("SELECT entity_id, COUNT(*) n FROM enquiries WHERE entity='mp_listings' AND entity_id IN (" . implode(',', $mmIds) . ') GROUP BY entity_id'), 'n', 'entity_id') : [];
$mmSav = $mmIds ? array_column(rows("SELECT entity_id, COUNT(*) n FROM favourites WHERE entity='mp_listings' AND entity_id IN (" . implode(',', $mmIds) . ') GROUP BY entity_id'), 'n', 'entity_id') : [];
$mmEnquiries = web_call('marketplace_enquiries')['enquiries'] ?? [];
function mm_status(array $m, array $row): array {
    $s = $row['status'] ?? 'pending';
    if ($s === 'approved' && !empty($m['expired'])) return ['closed', 'Expired'];
    return [['approved' => 'active', 'pending' => 'pending', 'rejected' => 'rejected', 'closed' => 'closed'][$s] ?? 'draft',
            ['approved' => 'Active', 'pending' => 'Pending Approval', 'rejected' => 'Rejected', 'closed' => 'Closed'][$s] ?? ucfirst($s)];
}
$mmCounts = ['all' => count($mmItems)]; foreach ($mmItems as $__m) { $__k = mm_status($__m, $mmRows[$__m['id']] ?? [])[0]; $mmCounts[$__k] = ($mmCounts[$__k] ?? 0) + 1; }
include 'header.php'; ?>

 

<main class="pl-my-market" id="plMyMarket">

    <!-- Page Header -->
    <section class="pl-mm-hero">
        <div class="pl-mm-container pl-mm-hero-inner">
            <div>
                <span class="pl-mm-eyebrow">PEOPLELINK MARKETPLACE</span>
                <h1>My Marketplace Listings</h1>
                <p>Manage your listings, track enquiries and keep your marketplace updated.</p>
            </div>

            <a href="post-marketplace-listing.php" class="pl-mm-btn pl-mm-btn-primary">
                <i class="fa-solid fa-plus"></i> Post New Listing
            </a>
        </div>
    </section>

    <div class="pl-mm-container pl-mm-content">

        <!-- Listing Summary -->
        <section class="pl-mm-stats" aria-label="Listing summary">

            <article class="pl-mm-stat-card">
                <div class="pl-mm-stat-icon pl-mm-blue">
                    <i class="fa-solid fa-eye"></i>
                </div>
                <div>
                    <span>Total Views</span>
                    <strong id="plMmViews"><?= number_format(array_sum(array_map(fn($r) => (int)$r['views'], $mmRows))) ?></strong>
                    <small>Across your listings</small>
                </div>
            </article>

            <article class="pl-mm-stat-card">
                <div class="pl-mm-stat-icon pl-mm-orange">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <span>Enquiries Received</span>
                    <strong id="plMmEnquiries"><?= array_sum($mmEnq) ?></strong>
                    <small>People interested in your listings</small>
                </div>
            </article>

            <article class="pl-mm-stat-card">
                <div class="pl-mm-stat-icon pl-mm-purple">
                    <i class="fa-solid fa-heart"></i>
                </div>
                <div>
                    <span>Saved by Users</span>
                    <strong id="plMmSaved"><?= array_sum($mmSav) ?></strong>
                    <small>Total favourites</small>
                </div>
            </article>

            <article class="pl-mm-stat-card">
                <div class="pl-mm-stat-icon pl-mm-green">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <span>Total Listings</span>
                    <strong id="plMmTotal"><?= count($mmItems) ?></strong>
                    <small>All listing statuses</small>
                </div>
            </article>

        </section>

        <!-- Listing Management -->
        <section class="pl-mm-panel">

            <div class="pl-mm-panel-heading">
                <div>
                    <h2>Manage Your Listings</h2>
                    <p>Review and update your marketplace posts.</p>
                </div>
                <span class="pl-mm-total-badge" id="plMmResultCount"><?= count($mmItems) ?> listings</span>
            </div>

            <!-- Status Tabs -->
            <div class="pl-mm-tabs" role="tablist" aria-label="Filter listings by status">

                <button class="pl-mm-tab is-active" type="button"
                        data-status="all" role="tab" aria-selected="true">
                    All Listings <span data-tab-count="all"><?= (int)($mmCounts['all'] ?? 0) ?></span>
                </button>

                <button class="pl-mm-tab" type="button"
                        data-status="active" role="tab" aria-selected="false">
                    Active <span data-tab-count="active"><?= (int)($mmCounts['active'] ?? 0) ?></span>
                </button>

                <button class="pl-mm-tab" type="button"
                        data-status="pending" role="tab" aria-selected="false">
                    Pending Approval <span data-tab-count="pending"><?= (int)($mmCounts['pending'] ?? 0) ?></span>
                </button>

                <button class="pl-mm-tab" type="button"
                        data-status="closed" role="tab" aria-selected="false">
                    Sold / Closed <span data-tab-count="closed"><?= (int)($mmCounts['closed'] ?? 0) ?></span>
                </button>

                <button class="pl-mm-tab" type="button"
                        data-status="rejected" role="tab" aria-selected="false">
                    Rejected <span data-tab-count="rejected"><?= (int)($mmCounts['rejected'] ?? 0) ?></span>
                </button>

            </div>

            <!-- Filters -->
            <div class="pl-mm-filters">

                <div class="pl-mm-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="search" id="plMmSearch"
                           placeholder="Search your listings..."
                           aria-label="Search listings">
                </div>

                <select id="plMmCategory" aria-label="Filter by category">
                    <option value="all">All Categories</option>
                    <option value="Property">Property</option>
                    <option value="Cars">Cars</option>
                    <option value="Bikes">Bikes</option>
                    <option value="Electronics">Electronics</option>
                    <option value="Furniture">Furniture</option>
                    <option value="Products">Products</option>
                    <option value="Services">Services</option>
                    <option value="Other">Other</option>
                </select>

                <select id="plMmStatus" aria-label="Filter by status">
                    <option value="all">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="pending">Pending Approval</option>
                    <option value="draft">Draft</option>
                    <option value="sold">Sold</option>
                    <option value="closed">Closed</option>
                    <option value="rejected">Rejected</option>
                </select>

                <button class="pl-mm-btn pl-mm-btn-outline" id="plMmReset" type="button">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </button>

            </div>

            <!-- Listing Cards -->
            <div class="pl-mm-listings" id="plMmListings">

                <!-- Listing 1 -->
                <?php foreach ($mmItems as $m): $row = $mmRows[$m['id']] ?? []; [$sk, $sl] = mm_status($m, $row); ?>
                <article class="pl-mm-listing" data-id="<?= (int)$m['id'] ?>" data-category="<?= h($m['category_name']) ?>" data-status="<?= $sk ?>" data-title="<?= h($m['title']) ?>" data-price="<?= (int)$m['price'] ?>" data-views="<?= (int)($row['views'] ?? 0) ?>" data-enquiries="<?= (int)($mmEnq[$m['id']] ?? 0) ?>" data-saved="<?= (int)($mmSav[$m['id']] ?? 0) ?>" data-location="<?= h($m['location_text']) ?>" data-date="<?= h(date('d F Y', strtotime($m['created_at']))) ?>" data-image="<?= h($m['image'] ?: 'images/no-photo.svg') ?>">
                    <div class="pl-mm-listing-image"><img src="<?= h($m['image'] ?: 'images/no-photo.svg') ?>" alt="<?= h($m['title']) ?>" loading="lazy"><span class="pl-mm-status status-<?= $sk ?>"><?= h($sl) ?></span></div>
                    <div class="pl-mm-listing-body">
                        <div class="pl-mm-listing-top"><div><span class="pl-mm-category"><?= h($m['category_text']) ?></span><h3><?= h($m['title']) ?></h3><div class="pl-mm-location"><i class="fa-solid fa-location-dot"></i> <?= h($m['location_text']) ?></div></div><strong class="pl-mm-price"><?= h($m['price_text']) ?></strong></div>
                        <div class="pl-mm-listing-meta"><span><i class="fa-regular fa-calendar"></i> <?= h(date('d M Y', strtotime($m['created_at']))) ?></span><span><i class="fa-solid fa-eye"></i> <?= (int)($row['views'] ?? 0) ?> views</span><span><i class="fa-regular fa-envelope"></i> <?= (int)($mmEnq[$m['id']] ?? 0) ?> enquiries</span><span><i class="fa-regular fa-heart"></i> <?= (int)($mmSav[$m['id']] ?? 0) ?> saved</span></div>
                        <div class="pl-mm-listing-actions">
                            <a href="marketplace-listing-details.php?id=<?= (int)$m['id'] ?>" class="pl-mm-action action-view"><i class="fa-regular fa-eye"></i> View</a>
                            <?php if ($sk !== 'closed'): ?><a href="post-marketplace-listing.php?edit=<?= (int)$m['id'] ?>" class="pl-mm-action"><i class="fa-regular fa-pen-to-square"></i> <?= $sk === 'rejected' ? 'Edit &amp; Resubmit' : 'Edit' ?></a><?php endif; ?>
                            <?php if ($sk === 'active'): ?>
                            <form method="post" style="display:inline" onsubmit="return confirm('Mark this listing as sold? It will be closed.')"><?= web_csrf_field() ?><input type="hidden" name="do" value="sold"><input type="hidden" name="id" value="<?= (int)$m['id'] ?>"><button type="submit" class="pl-mm-action action-sold"><i class="fa-solid fa-check"></i> Mark as Sold</button></form>
                            <?php endif; ?>
                            <?php if ($sk === 'active' || $sk === 'pending'): ?>
                            <form method="post" style="display:inline" onsubmit="return confirm('Close this listing?')"><?= web_csrf_field() ?><input type="hidden" name="do" value="close"><input type="hidden" name="id" value="<?= (int)$m['id'] ?>"><button type="submit" class="pl-mm-action action-close"><i class="fa-solid fa-lock"></i> Close Listing</button></form>
                            <?php endif; ?>
                            <form method="post" style="display:inline" onsubmit="return confirm('Delete this listing permanently?')"><?= web_csrf_field() ?><input type="hidden" name="do" value="delete"><input type="hidden" name="id" value="<?= (int)$m['id'] ?>"><button type="submit" class="pl-mm-action action-delete"><i class="fa-regular fa-trash-can"></i> Delete</button></form>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>

            </div>

            <!-- Empty State -->
            <div class="pl-mm-empty" id="plMmEmpty" hidden>
                <div class="pl-mm-empty-icon">
                    <i class="fa-solid fa-store"></i>
                </div>
                <h3 id="plMmEmptyTitle">No listings found</h3>
                <p id="plMmEmptyText">
                    Try changing your filters or post your first marketplace listing.
                </p>
                <a href="post-marketplace-listing.php" class="pl-mm-btn pl-mm-btn-primary">
                    <i class="fa-solid fa-plus"></i> Post a Listing
                </a>
            </div>

        </section>

        <!-- Help Section -->
        <section class="pl-mm-help">
            <div class="pl-mm-help-icon">
                <i class="fa-solid fa-lightbulb"></i>
            </div>

            <div>
                <h3>Get more attention for your listings</h3>
                <p>
                    Use clear photos, accurate prices and complete descriptions
                    to help people make informed decisions.
                </p>
            </div>

            <a href="marketplace-guidelines.php">
                Marketplace Guidelines <i class="fa-solid fa-arrow-right"></i>
            </a>
        </section>

    </div>
<div class="pl-mm-container">
        <!-- Enquiries received (live) -->
        <section class="plv-card plv-section" id="enquiries">
            <div class="plv-section-head">
                <span class="plv-section-icon orange"><i class="fa-solid fa-envelope-open-text"></i></span>
                <div><h2>Enquiries Received</h2><p>Messages from members interested in your listings.</p></div>
                <span class="plv-count"><?= count($mmEnquiries) ?> enquir<?= count($mmEnquiries) === 1 ? 'y' : 'ies' ?></span>
            </div>
            <?php if (!$mmEnquiries): ?><div class="plv-empty"><i class="fa-regular fa-comments"></i><h3>No enquiries yet</h3><p>When members contact you about a listing, their messages appear here.</p></div><?php endif; ?>
            <?php foreach ($mmEnquiries as $q): $tel = preg_replace('/[^\d+]/', '', (string)$q['phone']); $wa = preg_replace('/\D/', '', $tel); if (strlen($wa) === 10) $wa = '91' . $wa; ?>
            <article class="plv-enquiry">
                <div class="plv-enquiry-top"><strong><?= h($q['name'] ?: 'Member') ?></strong><small><?= h(date('d M Y, h:i A', strtotime($q['created_at']))) ?> · <a href="marketplace-listing-details.php?id=<?= (int)$q['item_id'] ?>"><?= h($q['item_title'] ?? 'Listing') ?></a></small></div>
                <?php if (trim((string)$q['message']) !== ''): ?><p><?= h($q['message']) ?></p><?php endif; ?>
                <div class="plv-enquiry-links"><?php if ($tel): ?><a href="tel:<?= h($tel) ?>"><i class="fa-solid fa-phone"></i> <?= h($q['phone']) ?></a><a class="wa" href="https://wa.me/<?= h($wa) ?>" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a><?php endif; ?><?php if ($q['email']): ?><a href="mailto:<?= h($q['email']) ?>"><i class="fa-regular fa-envelope"></i> <?= h($q['email']) ?></a><?php endif; ?></div>
            </article>
            <?php endforeach; ?>
        </section>
</div>
</main>

 

<?php include 'footer.php'; ?>
