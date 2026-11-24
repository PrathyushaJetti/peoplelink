<?php
// Directory Search Results (live: directory backend with the filters from the search pages)
require_once dirname(__DIR__) . '/_web.php';
$g = fn($k) => trim((string)($_GET[$k] ?? ''));
$drType = ucfirst(strtolower($g('type') ?: $g('listing_type')));
$drLoc = $g('location') ?: $g('city');
$drFilters = array_filter([
    'q' => trim($g('keyword') . ' ' . $g('name') . ' ' . $g('specialization')), 'category' => $g('category'),
    'profile_type' => in_array($drType, ['Professional', 'Business'], true) ? $drType : '', 'area' => $g('area'),
    'sort' => ['recent' => 'recent', 'name' => 'name'][$g('sort')] ?? '',
], fn($v) => $v !== '');
$drExtra = null; $drArgs = [];
if ($drLoc !== '') { $drExtra = '(t.city LIKE ? OR t.area LIKE ? OR t.state LIKE ? OR t.pincode LIKE ?)'; $drArgs = array_fill(0, 4, "%$drLoc%"); }
if ((int)$g('experience') > 0) { $drExtra = ($drExtra ? "$drExtra AND " : '') . 't.experience_years >= ?'; $drArgs[] = (int)$g('experience'); }
$drRes = pl_ent_list(pl_entity('directory'), $webCid, $drFilters, $webUid, 1, 50, $drExtra, $drArgs);
$drItems = array_map('web_dir_card', $drRes['items']);
include 'header.php'; ?>

<main class="pl-directory-results-page">
    <!-- Hero / Search -->
    <section class="pl-results-hero">
        <div class="pl-results-container">
            <div class="pl-results-hero-copy">
                <span class="pl-results-eyebrow">
                    <i class="bi bi-people-fill" aria-hidden="true"></i>
                    PEOPLELINK DIRECTORY
                </span>
                <h1>Find the right people. <span>Build meaningful connections.</span></h1>
                <p>Discover trusted professionals and businesses across your community and beyond.</p>
            </div>

            <form class="pl-results-search" action="professional-and-business-directory-search-results.php" method="get">
                <label class="pl-results-search-field">
                    <i class="bi bi-search" aria-hidden="true"></i>
                    <span class="visually-hidden">Search keyword</span>
                    <input type="search" name="keyword" placeholder="Name, service or keyword">
                </label>

                <label class="pl-results-search-field">
                    <i class="bi bi-grid" aria-hidden="true"></i>
                    <span class="visually-hidden">Category</span>
                    <input type="text" name="category" placeholder="Category">
                </label>

                <label class="pl-results-search-field">
                    <i class="bi bi-geo-alt" aria-hidden="true"></i>
                    <span class="visually-hidden">Location</span>
                    <input type="text" name="location" placeholder="City or location">
                </label>

                <button class="pl-results-search-button" type="submit">
                    <i class="bi bi-search" aria-hidden="true"></i> Search
                </button>
            </form>
        </div>
    </section>

    <!-- Results -->
    <section class="pl-results-content">
        <div class="pl-results-container">
            <div class="pl-results-heading-row">
                <div>
                    <div class="pl-results-breadcrumb">
                        <a href="../community-home.php">Home</a>
                        <i class="bi bi-chevron-right" aria-hidden="true"></i>
                        <span>Directory Listings</span>
                    </div>
                    <h2>Directory Listings</h2>
                    <p class="pl-results-subtitle">Explore professionals and businesses in the PeopleLink network.</p>
                </div>

                <a class="pl-results-edit-button" href="professional-and-business-directory-search.php">
                    <i class="bi bi-sliders" aria-hidden="true"></i> Edit Filters
                </a>
            </div>

            <div class="pl-results-summary">
                <div class="pl-results-count">
                    <span class="pl-results-count-icon"><i class="bi bi-card-list" aria-hidden="true"></i></span>
                    <div>
                        <strong><span id="plResultsCount"><?= count($drItems) ?></span> Listings Found</strong>
                        <span>Browse listings matching your interests and location.</span>
                    </div>
                </div>

                <label class="pl-results-sort">
                    <span>Sort by</span>
                    <select id="plResultsSort" aria-label="Sort listings">
                        <option value="relevant">Most Relevant</option>
                        <option value="recent">Recently Added</option>
                        <option value="name">Name A–Z</option>
                        <option value="nearest">Nearest</option>
                    </select>
                </label>
            </div>

            <div class="pl-results-layout">
                <!-- Sidebar Filters -->
                <aside class="pl-results-sidebar" aria-label="Directory filters">
                    <div class="pl-results-filter-card">
                        <div class="pl-results-filter-title">
                            <span class="pl-results-filter-icon"><i class="bi bi-funnel" aria-hidden="true"></i></span>
                            <div>
                                <h3>Refine Results</h3>
                                <p>Find a better match</p>
                            </div>
                        </div>

                        <form id="plResultsFilterForm">
                            <div class="pl-results-filter-group">
                                <span class="pl-results-filter-label">Listing Type</span>
                                <label class="pl-results-radio"><input type="radio" name="type" value="all" checked><span>All listings</span></label>
                                <label class="pl-results-radio"><input type="radio" name="type" value="professional"><span>Professionals</span></label>
                                <label class="pl-results-radio"><input type="radio" name="type" value="business"><span>Businesses</span></label>
                            </div>

                            <div class="pl-results-filter-group">
                                <label class="pl-results-filter-label" for="plFilterCategory">Category</label>
                                <input class="pl-results-input" id="plFilterCategory" type="text" placeholder="e.g. Web Development">
                            </div>

                            <div class="pl-results-filter-group">
                                <label class="pl-results-filter-label" for="plFilterLocation">Location</label>
                                <input class="pl-results-input" id="plFilterLocation" type="text" placeholder="Enter city or state">
                            </div>

                            <div class="pl-results-filter-group">
                                <label class="pl-results-filter-label" for="plFilterCommunity">Community <span>(optional)</span></label>
                                <input class="pl-results-input" id="plFilterCommunity" type="text" placeholder="Community name">
                            </div>

                            <button class="pl-results-apply-filter" type="submit">Apply Filters <i class="bi bi-arrow-right" aria-hidden="true"></i></button>
                            <button class="pl-results-reset-filter" id="plResultsReset" type="reset">Reset all filters</button>
                        </form>
                    </div>

                    <div class="pl-results-help-card">
                        <span class="pl-results-help-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
                        <h3>Grow your network</h3>
                        <p>Help your community discover your professional skills or business.</p>
                        <a href="professional-business-profile.php">Create a Listing <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a>
                    </div>
                </aside>

                <!-- Listing Results -->
                <div class="pl-results-main">
                    <div class="pl-results-type-tabs" role="group" aria-label="Filter listing type">
                        <button class="is-active" type="button" data-type="all">All Listings <span>6</span></button>
                        <button type="button" data-type="professional">Professionals</button>
                        <button type="button" data-type="business">Businesses</button>
                    </div>

                    <div class="pl-results-list" id="plResultsList">
            <?php foreach ($drItems as $d): ?>
            <article class="pl-directory-card" data-type="<?= $d['is_business'] ? 'business' : 'professional' ?>" data-category="<?= h($d['category_name']) ?>" data-location="<?= h($d['location_text']) ?>" data-community="<?= h($d['community_name'] ?? '') ?>" data-name="<?= h($d['title']) ?>" data-date="<?= h(substr($d['created_at'], 0, 10)) ?>" data-distance="">
                <div class="pl-directory-card-avatar<?= $d['is_business'] ? ' is-business' : '' ?>"><span><?php if ($d['image']): ?><img src="<?= h($d['image']) ?>" alt="" style="width:100%;height:100%;object-fit:cover;border-radius:inherit"><?php elseif ($d['is_business']): ?><i class="bi bi-building" aria-hidden="true"></i><?php else: ?><?= h($d['initials']) ?><?php endif; ?></span><span class="pl-directory-type-mark"><i class="bi <?= $d['is_business'] ? 'bi-building' : 'bi-person-badge' ?>" aria-hidden="true"></i></span></div>
                <div class="pl-directory-card-body">
                    <div class="pl-directory-card-topline"><span class="pl-directory-category"><?= h($d['category_text']) ?></span><button class="pl-directory-save" type="button" data-live="1" data-save-id="<?= (int)$d['id'] ?>" data-saved="<?= !empty($d['saved']) ? '1' : '0' ?>" aria-pressed="<?= !empty($d['saved']) ? 'true' : 'false' ?>"><i class="bi <?= !empty($d['saved']) ? 'bi-bookmark-check-fill' : 'bi-bookmark' ?>" aria-hidden="true"></i><span><?= !empty($d['saved']) ? 'Saved' : 'Save' ?></span></button></div>
                    <h3><?= h($d['title']) ?></h3>
                    <p class="pl-directory-specialization"><?= h(implode(', ', array_slice($d['services_list'], 0, 3)) ?: ($d['qualification'] ?? '')) ?></p>
                    <div class="pl-directory-meta"><span><i class="bi bi-geo-alt" aria-hidden="true"></i><?= h($d['location_text']) ?></span><?php if (!empty($d['experience_years'])): ?><span><i class="bi bi-award" aria-hidden="true"></i><?= (int)$d['experience_years'] ?> years <?= $d['is_business'] ? 'in business' : 'of experience' ?></span><?php endif; ?></div>
                    <p class="pl-directory-description"><?= h(mb_strimwidth((string)$d['description'], 0, 150, '…')) ?></p>
                    <?php if (!empty($d['community_name'])): ?><div class="pl-directory-community"><i class="bi bi-people" aria-hidden="true"></i> <?= h($d['community_name']) ?> Community</div><?php endif; ?>
                    <div class="pl-directory-card-actions"><a class="pl-directory-view" href="professional-business-profile-details.php?id=<?= (int)$d['id'] ?>">View Profile <i class="bi bi-arrow-up-right" aria-hidden="true"></i></a><a class="pl-directory-contact" href="enquiry-contact.php?id=<?= (int)$d['id'] ?>"><i class="bi bi-chat-dots" aria-hidden="true"></i> Contact / Enquire</a></div>
                </div>
            </article>
            <?php endforeach; ?>
                    </div>

                    <div class="pl-results-empty" id="plResultsEmpty" hidden>
                        <span class="pl-results-empty-icon"><i class="bi bi-search" aria-hidden="true"></i></span>
                        <h3>No matching professionals or businesses found.</h3>
                        <p>Try changing your keyword, category or location, or clear your filters to explore all listings.</p>
                        <div class="pl-results-empty-actions">
                            <button class="pl-directory-view" id="plModifyFilters" type="button"><i class="bi bi-sliders" aria-hidden="true"></i> Modify Filters</button>
                            <button class="pl-directory-contact" id="plViewAll" type="button">View All Listings</button>
                        </div>
                    </div>

                    <div class="pl-results-load-more-wrap" id="plLoadMoreWrap">
                        <button class="pl-results-load-more" id="plResultsLoadMore" type="button">Load More Listings <i class="bi bi-arrow-down-circle" aria-hidden="true"></i></button>
                        <p class="pl-results-load-note" id="plResultsLoadNote">Showing 6 matching listings.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>
