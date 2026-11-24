<?php include('header.php'); ?>
<?php
// real numbers for the logged-in member (sample values are shown to visitors)
$ftFamCode = 'PL-FAM-000124'; $ftMemCode = 'PL-M-00871'; $ftCount = 8; $ftCommName = 'Arya Vysya'; $ftMine = false;
if (!empty($_SESSION['uid'])) {
    try {
        $q = db()->prepare("SELECT f.id, f.status, c.name cname FROM users u LEFT JOIN communities c ON c.id=u.community_id LEFT JOIN families f ON f.user_id=u.id AND f.community_id=u.community_id WHERE u.id=? ORDER BY f.id DESC LIMIT 1");
        $q->execute([(int)$_SESSION['uid']]); $r = $q->fetch(PDO::FETCH_ASSOC);
        if ($r && $r['cname']) $ftCommName = $r['cname'];
        if ($r && $r['id']) {
            $ftMine = true; $ftFamCode = sprintf('PL-FAM-%06d', $r['id']);
            $c = db()->prepare("SELECT COUNT(*) FROM family_members WHERE family_id=? AND status<>'rejected'"); $c->execute([(int)$r['id']]); $ftCount = (int)$c->fetchColumn();
            $m = db()->prepare('SELECT id FROM members WHERE user_id=? ORDER BY id DESC LIMIT 1'); $m->execute([(int)$_SESSION['uid']]);
            $mid = (int)$m->fetchColumn(); $ftMemCode = $mid ? sprintf('PL-M-%05d', $mid) : 'Not registered';
        }
    } catch (Throwable $e) {}
}
$ftE = fn($v) => htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
?>


<div class="plft-page">

    <!-- =========================================
         PREMIUM HERO
    ========================================== -->
    <section class="plft-hero">

        <div class="plft-hero-glow glow-one"></div>
        <div class="plft-hero-glow glow-two"></div>

        <div class="plft-container">

            <div class="plft-hero-grid">

                <div class="plft-hero-content">

                    <div class="plft-eyebrow">
                        <span class="plft-eyebrow-dot"></span>
                        PEOPLELINK FAMILY NETWORK
                    </div>

                    <h1>
                        Build Your Family.
                        <span>Preserve Your Legacy.</span>
                    </h1>

                    <p class="plft-hero-lead">
                        Create a meaningful digital family network where
                        relationships, generations and family connections
                        remain beautifully organized within your community.
                    </p>

                    <div class="plft-hero-actions">

                        <a href="family-tree/family-tree.php"
                           class="plft-btn plft-btn-primary">
                            <i class="bi bi-diagram-3-fill"></i>
                            Create Family Tree
                        </a>

                        <a href="family-tree/view-family-tree.php"
                           class="plft-btn plft-btn-glass">
                            <i class="bi bi-eye"></i>
                            View Family Tree
                        </a>

                    </div>

                    <div class="plft-hero-trust">

                        <div>
                            <i class="bi bi-shield-check"></i>
                            <span>Privacy Controlled</span>
                        </div>

                        <div>
                            <i class="bi bi-people"></i>
                            <span>Community Connected</span>
                        </div>

                        <div>
                            <i class="bi bi-diagram-3"></i>
                            <span>Family Structured</span>
                        </div>

                    </div>

                </div>


                <!-- HERO FAMILY VISUAL -->
                <div class="plft-family-visual">

                    <div class="plft-visual-card">

                        <div class="plft-visual-top">
                            <span>MY FAMILY NETWORK</span>

                            <i class="bi bi-three-dots"></i>
                        </div>

                        <div class="plft-family-orbit">

                            <div class="plft-orbit-ring ring-one"></div>
                            <div class="plft-orbit-ring ring-two"></div>

                            <div class="plft-family-center">

                                <div class="plft-avatar-main">
                                    <i class="bi bi-person-fill"></i>
                                </div>

                                <strong>Family</strong>
                                <small>Primary Member</small>

                            </div>


                            <div class="plft-mini-person person-one">
                                <div class="plft-mini-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <span>Parent</span>
                            </div>

                            <div class="plft-mini-person person-two">
                                <div class="plft-mini-avatar">
                                    <i class="bi bi-heart-fill"></i>
                                </div>
                                <span>Spouse</span>
                            </div>

                            <div class="plft-mini-person person-three">
                                <div class="plft-mini-avatar">
                                    <i class="bi bi-person-hearts"></i>
                                </div>
                                <span>Child</span>
                            </div>

                            <div class="plft-mini-person person-four">
                                <div class="plft-mini-avatar">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <span>Family</span>
                            </div>

                        </div>


                        <div class="plft-visual-bottom">

                            <div>
                                <small>FAMILY ID</small>
                                <strong><?= $ftE($ftFamCode) ?></strong>
                            </div>

                            <div class="plft-status">
                                <span></span>
                                Connected
                            </div>

                        </div>

                    </div>


                    <div class="plft-floating-card floating-top">

                        <i class="bi bi-shield-check"></i>

                        <div>
                            <strong>Protected</strong>
                            <small>Family Data</small>
                        </div>

                    </div>


                    <div class="plft-floating-card floating-bottom">

                        <i class="bi bi-people-fill"></i>

                        <div>
                            <strong><?= (int)$ftCount ?> Member<?= $ftCount == 1 ? '' : 's' ?></strong>
                            <small>Connected</small>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>


    <!-- =========================================
         INTRO
    ========================================== -->
    <section class="plft-section">

        <div class="plft-container">

            <div class="plft-heading center">

                <span class="plft-section-label">
                    <i class="bi bi-stars"></i>
                    FAMILY CONNECTION
                </span>

                <h2>
                    One Family.
                    <span>Many Generations.</span>
                </h2>

                <p>
                    PeopleLink helps organize family relationships into
                    a structured digital network that can be maintained
                    and preserved over time.
                </p>

            </div>


            <div class="plft-feature-grid">

                <article class="plft-feature-card">

                    <div class="plft-feature-number">01</div>

                    <div class="plft-feature-icon blue">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>

                    <h3>Structured Family Tree</h3>

                    <p>
                        Connect family members through clearly defined
                        relationships and generations.
                    </p>

                    <span class="plft-feature-link">
                        Family Structure
                        <i class="bi bi-arrow-up-right"></i>
                    </span>

                </article>


                <article class="plft-feature-card">

                    <div class="plft-feature-number">02</div>

                    <div class="plft-feature-icon green">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>

                    <h3>Private Family Data</h3>

                    <p>
                        Family information remains subject to configured
                        community and privacy permissions.
                    </p>

                    <span class="plft-feature-link">
                        Privacy Controlled
                        <i class="bi bi-arrow-up-right"></i>
                    </span>

                </article>


                <article class="plft-feature-card">

                    <div class="plft-feature-number">03</div>

                    <div class="plft-feature-icon orange">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>

                    <h3>Maintain Over Time</h3>

                    <p>
                        Keep permitted family information updated as
                        your family network grows.
                    </p>

                    <span class="plft-feature-link">
                        Always Connected
                        <i class="bi bi-arrow-up-right"></i>
                    </span>

                </article>

            </div>

        </div>

    </section>


    <!-- =========================================
         IMAGE STORY
    ========================================== -->
    <section class="plft-story">

        <img src="https://images.unsplash.com/photo-1511895426328-dc8714191300?auto=format&fit=crop&w=1800&q=90"
             alt="Family together">

        <div class="plft-story-overlay"></div>

        <div class="plft-container">

            <div class="plft-story-content">

                <span class="plft-section-label light">
                    <i class="bi bi-heart-fill"></i>
                    PRESERVE FAMILY CONNECTIONS
                </span>

                <h2>
                    Every Family Has
                    <span>A Story Worth Preserving.</span>
                </h2>

                <p>
                    Organize relationships, connect generations and
                    create a family network that reflects the people
                    who matter most.
                </p>

            </div>

        </div>

    </section>


    <!-- =========================================
         FAMILY STRUCTURE
    ========================================== -->
    <section class="plft-section" id="create-family-tree">

        <div class="plft-container">

            <div class="plft-heading">

                <span class="plft-section-label">
                    <i class="bi bi-diagram-3"></i>
                    FAMILY STRUCTURE
                </span>

                <h2>
                    Start With The
                    <span>Head Of Family.</span>
                </h2>

                <p>
                    Build your family network step by step by connecting
                    members according to their relationships.
                </p>

            </div>


            <div class="plft-family-flow">

                <div class="plft-flow-line"></div>

                <div class="plft-flow-item active">

                    <div class="plft-flow-icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>

                    <strong>Head of Family</strong>
                    <small>Primary Member</small>

                </div>


                <div class="plft-flow-item">

                    <div class="plft-flow-icon">
                        <i class="bi bi-heart-fill"></i>
                    </div>

                    <strong>Spouse</strong>
                    <small>Partner</small>

                </div>


                <div class="plft-flow-item">

                    <div class="plft-flow-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <strong>Parents</strong>
                    <small>Family Lineage</small>

                </div>


                <div class="plft-flow-item">

                    <div class="plft-flow-icon">
                        <i class="bi bi-person-hearts"></i>
                    </div>

                    <strong>Children</strong>
                    <small>Next Generation</small>

                </div>


                <div class="plft-flow-item">

                    <div class="plft-flow-icon">
                        <i class="bi bi-people"></i>
                    </div>

                    <strong>Other Members</strong>
                    <small>Extended Family</small>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         ADD MEMBERS
    ========================================== -->
    <section class="plft-section plft-soft">

        <div class="plft-container">

            <div class="plft-heading center">

                <span class="plft-section-label">
                    <i class="bi bi-person-plus"></i>
                    FAMILY MEMBERS
                </span>

                <h2>
                    Add The People
                    <span>Who Make Your Family.</span>
                </h2>

                <p>
                    Add permitted family members and define their
                    relationship with the primary member.
                </p>

            </div>


            <div class="plft-member-grid">

                <div class="plft-member-card">
                    <i class="bi bi-person"></i>
                    <span>Father</span>
                </div>

                <div class="plft-member-card">
                    <i class="bi bi-person"></i>
                    <span>Mother</span>
                </div>

                <div class="plft-member-card">
                    <i class="bi bi-heart"></i>
                    <span>Spouse</span>
                </div>

                <div class="plft-member-card">
                    <i class="bi bi-person"></i>
                    <span>Son</span>
                </div>

                <div class="plft-member-card">
                    <i class="bi bi-person"></i>
                    <span>Daughter</span>
                </div>

                <div class="plft-member-card">
                    <i class="bi bi-people"></i>
                    <span>Brother</span>
                </div>

                <div class="plft-member-card">
                    <i class="bi bi-people"></i>
                    <span>Sister</span>
                </div>

                <div class="plft-member-card">
                    <i class="bi bi-person-plus"></i>
                    <span>Other</span>
                </div>

            </div>


            <div class="plft-center-button">

                <a href="m-f-registration/member-family-registration.php#familyMembersContainer" class="plft-btn plft-btn-primary">
                    <i class="bi bi-person-plus-fill"></i>
                    Add Family Member
                </a>

            </div>

        </div>

    </section>


    <!-- =========================================
         MEMBER INFORMATION
    ========================================== -->
    <section class="plft-section">

        <div class="plft-container">

            <div class="plft-split">

                <div class="plft-split-content">

                    <span class="plft-section-label">
                        <i class="bi bi-card-list"></i>
                        MEMBER INFORMATION
                    </span>

                    <h2>
                        Every Member Has
                        <span>A Place In The Story.</span>
                    </h2>

                    <p>
                        The Family Tree can include approved information
                        configured for the PeopleLink platform.
                    </p>

                    <div class="plft-mini-note">
                        <i class="bi bi-info-circle"></i>
                        Only approved fields will be included.
                    </div>

                </div>


                <div class="plft-info-grid">

                    <div>
                        <i class="bi bi-person"></i>
                        <span>Name</span>
                    </div>

                    <div>
                        <i class="bi bi-diagram-3"></i>
                        <span>Relationship</span>
                    </div>

                    <div>
                        <i class="bi bi-calendar3"></i>
                        <span>Date of Birth</span>
                    </div>

                    <div>
                        <i class="bi bi-mortarboard"></i>
                        <span>Education</span>
                    </div>

                    <div>
                        <i class="bi bi-briefcase"></i>
                        <span>Profession</span>
                    </div>

                    <div>
                        <i class="bi bi-geo-alt"></i>
                        <span>Location</span>
                    </div>

                    <div>
                        <i class="bi bi-telephone"></i>
                        <span>Contact</span>
                    </div>

                    <div>
                        <i class="bi bi-three-dots"></i>
                        <span>Other Details</span>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         TREE VIEW
    ========================================== -->
    <section class="plft-tree-section" id="family-tree-view">

        <div class="plft-container">

            <div class="plft-heading center light-heading">

                <span class="plft-section-label light">
                    <i class="bi bi-diagram-3"></i>
                    FAMILY TREE VIEW
                </span>

                <h2>
                    See Your Family
                    <span>Come Together.</span>
                </h2>

                <p>
                    A structured graphical representation can connect
                    family members through their relationships.
                </p>

            </div>


            <div class="plft-tree-card">

                <div class="plft-tree-parent">

                    <div class="plft-tree-avatar">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>

                    <strong>Head of Family</strong>
                    <small>Primary Member</small>

                </div>


                <div class="plft-tree-connector"></div>


                <div class="plft-tree-children">

                    <div class="plft-tree-child">

                        <div>
                            <i class="bi bi-heart-fill"></i>
                        </div>

                        <strong>Spouse</strong>
                        <small>Partner</small>

                    </div>


                    <div class="plft-tree-child">

                        <div>
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <strong>Parents</strong>
                        <small>Family Lineage</small>

                    </div>


                    <div class="plft-tree-child">

                        <div>
                            <i class="bi bi-person-hearts"></i>
                        </div>

                        <strong>Children</strong>
                        <small>Next Generation</small>

                    </div>

                </div>

            </div>


            <div class="plft-tree-features">

                <div>
                    <i class="bi bi-eye"></i>
                    <strong>View Members</strong>
                    <span>Based on permissions</span>
                </div>

                <div>
                    <i class="bi bi-person-plus"></i>
                    <strong>Add Members</strong>
                    <span>Connect relationships</span>
                </div>

                <div>
                    <i class="bi bi-pencil-square"></i>
                    <strong>Update Details</strong>
                    <span>Maintain information</span>
                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         DIGITAL IDS
    ========================================== -->
    <section class="plft-section">

        <div class="plft-container">

            <div class="plft-heading center">

                <span class="plft-section-label">
                    <i class="bi bi-upc-scan"></i>
                    DIGITAL IDENTIFICATION
                </span>

                <h2>
                    Your Family.
                    <span>Your Digital Identity.</span>
                </h2>

                <p>
                    Registered families can be linked to unique Family
                    and Member identifiers.
                </p>

            </div>


            <div class="plft-id-grid">

                <div class="plft-id-card">

                    <div class="plft-id-icon">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>

                    <div>
                        <small>UNIQUE FAMILY IDENTIFIER</small>
                        <strong><?= $ftE($ftFamCode) ?></strong>
                    </div>

                    <i class="bi bi-qr-code"></i>

                </div>


                <div class="plft-id-card green">

                    <div class="plft-id-icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>

                    <div>
                        <small>REGISTERED MEMBER IDENTIFIER</small>
                        <strong><?= $ftE($ftMemCode) ?></strong>
                    </div>

                    <i class="bi bi-qr-code"></i>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         IMAGE BREAK
    ========================================== -->
    <section class="plft-story plft-story-two">

        <img src="https://images.unsplash.com/photo-1543332164-6e82f355badc?auto=format&fit=crop&w=1800&q=90"
             alt="Connected family">

        <div class="plft-story-overlay"></div>

        <div class="plft-container">

            <div class="plft-story-content">

                <span class="plft-section-label light">
                    <i class="bi bi-people-fill"></i>
                    CONNECTED COMMUNITY
                </span>

                <h2>
                    Keep Your Family
                    <span>Connected Across Generations.</span>
                </h2>

                <p>
                    Organize family relationships while keeping
                    community information structured and protected.
                </p>

            </div>

        </div>

    </section>


    <!-- =========================================
         ENQUIRY
    ========================================== -->
    <section class="plft-section">

        <div class="plft-container">

            <div class="plft-enquiry">

                <div class="plft-enquiry-image">

                    <img src="/peoplelink/first/images/in/family-1.jpg?auto=format&fit=crop&w=1000&q=90"
                         alt="Family discussion">

                    <div class="plft-image-badge">
                        <i class="bi bi-chat-heart-fill"></i>
                        Family Support
                    </div>

                </div>


                <div class="plft-enquiry-content">

                    <span class="plft-section-label">
                        <i class="bi bi-chat-square-text"></i>
                        NEED ASSISTANCE?
                    </span>

                    <h2>
                        Family Tree
                        <span>Enquiry Form.</span>
                    </h2>

                    <p>
                        Submit an enquiry if you need assistance or
                        want to provide additional information related
                        to your family record.
                    </p>

                    <p>
                        Submitted enquiries can be reviewed by
                        authorised administrators.
                    </p>

                    <a href="family-tree/family-tree-enquiry.php" class="plft-btn plft-btn-primary">
                        <i class="bi bi-send"></i>
                        Submit Family Enquiry
                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         COMMUNITY DATA
    ========================================== -->
    <section class="plft-section plft-soft">

        <div class="plft-container">

            <div class="plft-heading center">

                <span class="plft-section-label">
                    <i class="bi bi-shield-check"></i>
                    COMMUNITY DATA PROTECTION
                </span>

                <h2>
                    Your Community.
                    <span>Your Family Network.</span>
                </h2>

                <p>
                    Family Tree information remains restricted to the
                    selected community. Data from different communities
                    will not be mixed.
                </p>

            </div>


            <div class="plft-community-grid">

                <div class="plft-community-card">

                    <div class="plft-community-logo blue">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div>
                        <small>COMMUNITY FAMILY TREE</small>
                        <strong><?= $ftE($ftCommName) ?></strong>
                        <span><?= $ftE($ftCommName) ?> family data only</span>
                    </div>

                    <i class="bi bi-lock-fill"></i>

                </div>


                <div class="plft-community-card">

                    <div class="plft-community-logo orange">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <div>
                        <small>COMMUNITY FAMILY TREE</small>
                        <strong>Other communities</strong>
                        <span>Cannot see your family data</span>
                    </div>

                    <i class="bi bi-lock-fill"></i>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         PRIVACY
    ========================================== -->
    <section class="plft-security">

        <div class="plft-container">

            <div class="plft-security-grid">

                <div>

                    <span class="plft-section-label light">
                        <i class="bi bi-lock-fill"></i>
                        PRIVACY & ACCESS CONTROL
                    </span>

                    <h2>
                        Your Family Data.
                        <span>Your Choice.</span>
                    </h2>

                    <p>
                        Family information may contain personal details.
                        Access can therefore be controlled according to
                        configured permissions and privacy settings.
                    </p>

                    <div class="plft-security-list">

                        <div>
                            <i class="bi bi-person-check"></i>
                            <span>User Login</span>
                        </div>

                        <div>
                            <i class="bi bi-diagram-3"></i>
                            <span>Family Relationship</span>
                        </div>

                        <div>
                            <i class="bi bi-shield-check"></i>
                            <span>Community Access</span>
                        </div>

                        <div>
                            <i class="bi bi-person-lock"></i>
                            <span>Admin Permissions</span>
                        </div>

                        <div>
                            <i class="bi bi-sliders"></i>
                            <span>Privacy Settings</span>
                        </div>

                    </div>

                </div>


                <div class="plft-security-visual">

                    <div class="plft-security-ring ring-a"></div>
                    <div class="plft-security-ring ring-b"></div>

                    <div class="plft-security-core">
                        <i class="bi bi-shield-lock-fill"></i>
                        <strong>Protected</strong>
                        <small>Family Network</small>
                    </div>

                </div>

            </div>

        </div>

    </section>


    <!-- =========================================
         FINAL CTA
    ========================================== -->
    <section class="plft-final">

        <div class="plft-container">

            <div class="plft-final-inner">

                <span class="plft-section-label light">
                    <i class="bi bi-arrow-repeat"></i>
                    KEEP YOUR FAMILY UPDATED
                </span>

                <h2>
                    Your Family Story
                    <span>Continues.</span>
                </h2>

                <p>
                    Registered users can update permitted family
                    information whenever required, subject to
                    administrator approval rules.
                </p>


                <div class="plft-final-actions">

                    <a href="family-tree/view-family-tree.php"
                       class="plft-btn plft-btn-white">
                        <i class="bi bi-diagram-3"></i>
                        View Family Tree
                    </a>

                    <a href="m-f-registration/member-family-registration.php#familyMembersContainer"
                       class="plft-btn plft-btn-outline-white">
                        <i class="bi bi-person-plus"></i>
                        Add Member
                    </a>

                    <a href="family-tree/family-tree-enquiry.php"
                       class="plft-btn plft-btn-outline-white">
                        <i class="bi bi-pencil-square"></i>
                        Update Details
                    </a>

                </div>

            </div>

        </div>

    </section>

</div>


 

<?php include('footer.php'); ?>