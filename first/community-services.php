<?php
// Shared "Community Services" block - edit ONLY this file; every page that includes it stays identical.
?>
<style>
#services a.pl-value-card,
#services a.pl-value-card:hover,
#services a.pl-value-card:visited { text-decoration: none; color: inherit; }
#services a.pl-value-card h3 { text-decoration: none; color: inherit; }
#services .pl-values-grid { grid-template-columns: repeat(4, 1fr); }
@media (max-width: 1024px) { #services .pl-values-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 400px) { #services .pl-values-grid { grid-template-columns: 1fr; } }
#services a.pl-value-card { display: flex; flex-direction: column; }
#services a.pl-value-card p { flex: 1; margin: 6px 0 14px; }
#services .pl-sv-go { font-weight: 700; font-size: 14px; color: #07579D; display: inline-flex; gap: 6px; align-items: center; }
#services a.pl-value-card:hover .pl-sv-go i { transform: translateX(4px); transition: transform .2s; }
</style>
<section class="pl-values-section" id="services">

        <div class="pl-about-container">

            <div class="pl-section-title">

                <span class="pl-eyebrow">
                    <i class="bi bi-grid-fill"></i>
                    COMMUNITY SERVICES
                </span>

                <h2>
                    Explore
                    <span>Our Services</span>
                </h2>

            </div>

            <div class="pl-values-grid">
                <?php
                $svQ = !empty($cm['slug']) ? '?c=' . urlencode($cm['slug']) : '';
                $services = [
                    ['Matrimony', '/peoplelink/module-4/Frontend/pages/index.php' . $svQ, 'bi-heart-fill', 'unity', 'Find suitable matches within the community.'],
                    ['Jobs', 'job/jobs-home.php' . $svQ, 'bi-briefcase-fill', 'growth', 'Jobs shared by community members and businesses.'],
                    ['Professional &amp; Business Directory', 'professional-and-business-directory.php' . $svQ, 'bi-building', 'trust', 'Doctors, lawyers, shops and services you can trust.'],
                    ['Member &amp; Family', 'm-f-registration/member-family-registration.php', 'bi-house-heart-fill', 'support', 'Register your family and its members.'],
                    ['Family Tree', 'family-tree.php' . $svQ, 'bi-diagram-3-fill', 'heritage', 'Build and preserve your family tree.'],
                    ['Marketplace', 'marketplace/marketplace-home.php' . $svQ, 'bi-shop', 'growth', 'Buy and sell property, vehicles and more.'],
                    ['Events &amp; Advertisements', 'events-ads.php' . $svQ, 'bi-calendar-event-fill', 'unity', 'Festivals, programs and community promotions.'],
                    ['Community Support', 'community/community-support.php' . $svQ, 'bi-life-preserver', 'support', 'Ask for or offer help for education and emergencies.'],
                ];
                foreach ($services as $sv): ?>
                <a class="pl-value-card" href="<?= htmlspecialchars($sv[1], ENT_QUOTES, 'UTF-8') ?>">
                    <div class="pl-value-icon <?= $sv[3] ?>"><i class="bi <?= $sv[2] ?>"></i></div>
                    <h3><?= $sv[0] ?></h3>
                    <p><?= $sv[4] ?></p>
                    <span class="pl-sv-go">Open <i class="bi bi-arrow-right"></i></span>
                </a>
                <?php endforeach; ?>
            </div>

        </div>

    </section>