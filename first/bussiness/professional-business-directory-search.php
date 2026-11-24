<?php
$pageTitle = "Search Professionals & Businesses | PeopleLink";
?>
<?php include 'header.php'; ?>

 

<main class="pl-directory-search-page">
    <section class="pl-directory-hero">
        <div class="pl-directory-hero__content">
            <span class="pl-directory-eyebrow"><i class="bi bi-compass"></i> PEOPLELINK DIRECTORY</span>
            <h1>Find the right people.<br><span>Discover trusted businesses.</span></h1>
            <p>Search professionals and businesses across your community and nearby locations.</p>
            <div class="pl-directory-hero__trust">
                <span><i class="bi bi-person-check"></i> Professionals</span>
                <span><i class="bi bi-buildings"></i> Local businesses</span>
                <span><i class="bi bi-geo-alt"></i> Nearby discovery</span>
            </div>
        </div>
        <div class="pl-directory-hero__art" aria-hidden="true">
            <div class="pl-directory-orbit pl-directory-orbit--one"></div>
            <div class="pl-directory-orbit pl-directory-orbit--two"></div>
            <div class="pl-directory-art-card pl-directory-art-card--main">
                <div class="pl-directory-art-icon"><i class="bi bi-search"></i></div>
                <div class="pl-directory-art-lines"><b></b><span></span><span></span></div>
                <div class="pl-directory-art-tags"><i></i><i></i><i></i></div>
            </div>
            <div class="pl-directory-art-card pl-directory-art-card--person"><i class="bi bi-person-badge"></i><span>Professionals</span></div>
            <div class="pl-directory-art-card pl-directory-art-card--business"><i class="bi bi-shop-window"></i><span>Businesses</span></div>
            <div class="pl-directory-art-pin"><i class="bi bi-geo-alt-fill"></i></div>
        </div>
    </section>

    <section class="pl-directory-main">
        <div class="pl-directory-section-heading">
            <div>
                <span class="pl-directory-kicker">DIRECTORY SEARCH</span>
                <h2>What are you looking for?</h2>
                <p>Use the filters below to narrow down your search.</p>
            </div>
            <span class="pl-directory-step"><span>02</span> Search &amp; Filters</span>
        </div>

        <form id="directorySearchForm" class="pl-directory-filter-card" action="professional-and-business-directory-search-results.php" method="get">
            <div class="pl-directory-form-grid">
                <div class="pl-directory-field">
                    <label for="directoryKeyword">Professional / Business Name</label>
                    <div class="pl-directory-input-wrap"><i class="bi bi-search"></i><input type="text" id="directoryKeyword" name="name" placeholder="e.g. Sharma Dental Clinic"></div>
                </div>
                <div class="pl-directory-field">
                    <label for="directoryCategory">Category</label>
                    <div class="pl-directory-select-wrap"><i class="bi bi-grid"></i><select id="directoryCategory" name="category">
                        <option value="">All categories</option><option>Doctors</option><option>Lawyers</option><option>Chartered Accountants</option><option>Consultants</option><option>IT Services</option><option>Real Estate</option><option>Education</option><option>Healthcare</option><option>Construction</option><option>Finance</option><option>Retail</option><option>Restaurants</option><option>Event Services</option><option>Home Services</option><option>Travel</option><option>Other Businesses</option>
                    </select></div>
                </div>
                <div class="pl-directory-field">
                    <label for="directorySpecialization">Service / Specialization</label>
                    <div class="pl-directory-input-wrap"><i class="bi bi-briefcase"></i><input type="text" id="directorySpecialization" name="specialization" placeholder="e.g. Tax consultant"></div>
                </div>
                <div class="pl-directory-field">
                    <label for="directoryCity">City</label>
                    <div class="pl-directory-input-wrap"><i class="bi bi-buildings"></i><input type="text" id="directoryCity" name="city" placeholder="Enter city"></div>
                </div>
                <div class="pl-directory-field">
                    <label for="directoryArea">Area / Locality</label>
                    <div class="pl-directory-input-wrap"><i class="bi bi-geo"></i><input type="text" id="directoryArea" name="area" placeholder="e.g. Indirapuram"></div>
                </div>
                <div class="pl-directory-field">
                    <label for="directoryKeywordText">Keyword</label>
                    <div class="pl-directory-input-wrap"><i class="bi bi-tags"></i><input type="text" id="directoryKeywordText" name="keyword" placeholder="Service, skill or keyword"></div>
                </div>
            </div>

            <div class="pl-directory-divider"></div>

            <div class="pl-directory-filter-row">
                <div class="pl-directory-filter-block">
                    <span class="pl-directory-label">Listing type</span>
                    <div class="pl-directory-choice-group" role="radiogroup" aria-label="Listing type">
                        <label class="pl-directory-choice"><input type="radio" name="listing_type" value="both" checked><span><i class="bi bi-people"></i> Both</span></label>
                        <label class="pl-directory-choice"><input type="radio" name="listing_type" value="professional"><span><i class="bi bi-person-vcard"></i> Professional</span></label>
                        <label class="pl-directory-choice"><input type="radio" name="listing_type" value="business"><span><i class="bi bi-building"></i> Business</span></label>
                    </div>
                </div>
                <div class="pl-directory-filter-block pl-directory-experience">
                    <label class="pl-directory-label" for="directoryExperience">Experience / Business age</label>
                    <div class="pl-directory-select-wrap"><i class="bi bi-award"></i><select id="directoryExperience" name="experience">
                        <option value="">Any experience / age</option><option value="lt1">Less than 1 year</option><option value="1-3">1–3 years</option><option value="3-5">3–5 years</option><option value="5-10">5–10 years</option><option value="10plus">10+ years</option>
                    </select></div>
                </div>
            </div>

            <div class="pl-directory-location-panel">
                <div class="pl-directory-location-copy">
                    <span class="pl-directory-location-icon"><i class="bi bi-crosshair"></i></span>
                    <div><strong>Discover nearby listings</strong><small>Use your location to find professionals and businesses around you.</small></div>
                </div>
                <button type="button" id="useDirectoryLocation" class="pl-directory-location-btn"><i class="bi bi-geo-alt"></i> Use My Location</button>
                <input type="hidden" id="directoryLatitude" name="latitude"><input type="hidden" id="directoryLongitude" name="longitude"><input type="hidden" id="directoryNearby" name="nearby" value="0">
            </div>
            <p id="directoryLocationStatus" class="pl-directory-location-status" aria-live="polite"></p>

            <div class="pl-directory-bottom-row">
                <div class="pl-directory-sort">
                    <label class="pl-directory-label" for="directorySort">Sort by</label>
                    <div class="pl-directory-select-wrap"><i class="bi bi-sort-down"></i><select id="directorySort" name="sort">
                        <option value="relevant">Most Relevant</option><option value="recent">Recently Added</option><option value="name">Name A–Z</option><option value="nearest">Nearest (location enabled)</option>
                    </select></div>
                </div>
                <div class="pl-directory-form-actions">
                    <button type="reset" id="resetDirectoryFilters" class="pl-directory-reset-btn"><i class="bi bi-arrow-counterclockwise"></i> Reset Filters</button>
                    <button type="submit" class="pl-directory-submit-btn">Apply Filters <i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </form>
    </section>

    <section class="pl-directory-quick-section">
        <div class="pl-directory-section-heading pl-directory-section-heading--compact">
            <div><span class="pl-directory-kicker">QUICK DISCOVERY</span><h2>Explore in one click</h2></div>
            <span class="pl-directory-quick-note"><i class="bi bi-lightning-charge"></i> Quick filters</span>
        </div>
        <div class="pl-directory-quick-grid">
            <button type="button" class="pl-directory-quick-card" data-quick-filter="professionals-near-me"><span class="pl-directory-quick-icon pl-directory-quick-icon--blue"><i class="bi bi-person-walking"></i></span><span><strong>Professionals Near Me</strong><small>Find experts around you</small></span><i class="bi bi-arrow-up-right pl-directory-quick-arrow"></i></button>
            <button type="button" class="pl-directory-quick-card" data-quick-filter="businesses-near-me"><span class="pl-directory-quick-icon pl-directory-quick-icon--green"><i class="bi bi-shop"></i></span><span><strong>Businesses Near Me</strong><small>Discover local services</small></span><i class="bi bi-arrow-up-right pl-directory-quick-arrow"></i></button>
            <button type="button" class="pl-directory-quick-card" data-quick-filter="recent"><span class="pl-directory-quick-icon pl-directory-quick-icon--orange"><i class="bi bi-clock-history"></i></span><span><strong>Recently Added</strong><small>See the newest listings</small></span><i class="bi bi-arrow-up-right pl-directory-quick-arrow"></i></button>
            <button type="button" class="pl-directory-quick-card" data-quick-filter="categories"><span class="pl-directory-quick-icon pl-directory-quick-icon--purple"><i class="bi bi-grid-1x2"></i></span><span><strong>Popular Categories</strong><small>Browse by area of work</small></span><i class="bi bi-arrow-up-right pl-directory-quick-arrow"></i></button>
        </div>
    </section>

    <section class="pl-directory-category-section" id="popularDirectoryCategories">
        <div class="pl-directory-section-heading pl-directory-section-heading--compact">
            <div><span class="pl-directory-kicker">BROWSE BY CATEGORY</span><h2>Popular categories</h2></div>
            <span class="pl-directory-category-count">16 categories</span>
        </div>
        <div class="pl-directory-category-grid">
            <button type="button" class="pl-directory-category-chip" data-category="Doctors"><i class="bi bi-heart-pulse"></i> Doctors</button>
            <button type="button" class="pl-directory-category-chip" data-category="Lawyers"><i class="bi bi-bank"></i> Lawyers</button>
            <button type="button" class="pl-directory-category-chip" data-category="Chartered Accountants"><i class="bi bi-calculator"></i> Chartered Accountants</button>
            <button type="button" class="pl-directory-category-chip" data-category="Consultants"><i class="bi bi-chat-square-text"></i> Consultants</button>
            <button type="button" class="pl-directory-category-chip" data-category="IT Services"><i class="bi bi-code-slash"></i> IT Services</button>
            <button type="button" class="pl-directory-category-chip" data-category="Real Estate"><i class="bi bi-house-door"></i> Real Estate</button>
            <button type="button" class="pl-directory-category-chip" data-category="Education"><i class="bi bi-mortarboard"></i> Education</button>
            <button type="button" class="pl-directory-category-chip" data-category="Healthcare"><i class="bi bi-hospital"></i> Healthcare</button>
            <button type="button" class="pl-directory-category-chip" data-category="Construction"><i class="bi bi-bricks"></i> Construction</button>
            <button type="button" class="pl-directory-category-chip" data-category="Finance"><i class="bi bi-cash-coin"></i> Finance</button>
            <button type="button" class="pl-directory-category-chip" data-category="Retail"><i class="bi bi-bag"></i> Retail</button>
            <button type="button" class="pl-directory-category-chip" data-category="Restaurants"><i class="bi bi-cup-hot"></i> Restaurants</button>
            <button type="button" class="pl-directory-category-chip" data-category="Event Services"><i class="bi bi-calendar-event"></i> Event Services</button>
            <button type="button" class="pl-directory-category-chip" data-category="Home Services"><i class="bi bi-tools"></i> Home Services</button>
            <button type="button" class="pl-directory-category-chip" data-category="Travel"><i class="bi bi-airplane"></i> Travel</button>
            <button type="button" class="pl-directory-category-chip" data-category="Other Businesses"><i class="bi bi-three-dots"></i> Other Businesses</button>
        </div>
    </section>

    <section class="pl-directory-bottom-cta">
        <div class="pl-directory-cta-icon"><i class="bi bi-megaphone"></i></div>
        <div><h2>Are you a professional or business owner?</h2><p>Make it easier for your community to discover your services.</p></div>
        <a href="add-business-profile.php" class="pl-directory-cta-btn">Create Your Listing <i class="bi bi-arrow-up-right"></i></a>
    </section>
</main>
 
<?php include 'footer.php'; ?>