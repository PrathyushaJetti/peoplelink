<?php include 'header.php'; ?>
 

<main class="pl-post-page">

    <!-- HERO -->
    <section class="pl-post-hero">
        <div class="pl-post-container">

            <div class="pl-post-hero-content">

                <span class="pl-post-eyebrow">
                    <i class="bi bi-megaphone"></i>
                    PeopleLink Publishing
                </span>

                <h1>
                    Publish Your Event,<br>
                    <span>Promotion or Announcement</span>
                </h1>

                <p>
                    Registered and authorised users can submit an Event or
                    Advertisement through PeopleLink for community-specific
                    or global visibility.
                </p>

                <div class="pl-post-hero-actions">
                    <button class="pl-post-btn pl-post-btn-primary"
                            onclick="selectPostType('Event')">
                        <i class="bi bi-calendar-event"></i>
                        Post Event
                    </button>

                    <button class="pl-post-btn pl-post-btn-light"
                            onclick="selectPostType('Advertisement')">
                        <i class="bi bi-megaphone"></i>
                        Post Advertisement
                    </button>
                </div>

                <div class="pl-post-trust">
                    <span>
                        <i class="bi bi-shield-check"></i>
                        Authorised Users
                    </span>

                    <span>
                        <i class="bi bi-check-circle"></i>
                        Admin Approval
                    </span>

                    <span>
                        <i class="bi bi-people"></i>
                        Community / Global
                    </span>
                </div>

            </div>

            <div class="pl-post-hero-visual">

                <div class="pl-post-visual-main">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&w=1000&q=85"
                         alt="PeopleLink event publishing">
                </div>

                <div class="pl-post-floating-card">
                    <span>
                        <i class="bi bi-check2-circle"></i>
                    </span>

                    <div>
                        <strong>Ready to Publish?</strong>
                        <small>Create • Preview • Submit</small>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- MAIN FORM AREA -->
    <section class="pl-post-main">
        <div class="pl-post-container">

            <div class="pl-post-layout">

                <!-- FORM -->
                <div class="pl-post-form-wrapper">

                    <form id="postContentForm"
                          enctype="multipart/form-data">


                        <!-- STEP 1 -->
                        <section class="pl-form-section">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">01</div>

                                <div>
                                    <span>CONTENT TYPE</span>
                                    <h2>Select Post Type</h2>
                                    <p>
                                        Choose what you want to publish.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-post-type-grid">

                                <label class="pl-post-type-option active"
                                       data-type="Event">

                                    <input type="radio"
                                           name="post_type"
                                           value="Event"
                                           checked>

                                    <div class="pl-post-type-icon event">
                                        <i class="bi bi-calendar-event"></i>
                                    </div>

                                    <div>
                                        <strong>Event</strong>
                                        <p>
                                            Community programs, cultural
                                            activities, meetings, celebrations
                                            and social initiatives.
                                        </p>
                                    </div>

                                    <span class="pl-radio-check">
                                        <i class="bi bi-check"></i>
                                    </span>

                                </label>


                                <label class="pl-post-type-option"
                                       data-type="Advertisement">

                                    <input type="radio"
                                           name="post_type"
                                           value="Advertisement">

                                    <div class="pl-post-type-icon advertisement">
                                        <i class="bi bi-megaphone"></i>
                                    </div>

                                    <div>
                                        <strong>Advertisement</strong>
                                        <p>
                                            Businesses, products, services,
                                            offers, launches and promotions.
                                        </p>
                                    </div>

                                    <span class="pl-radio-check">
                                        <i class="bi bi-check"></i>
                                    </span>

                                </label>

                            </div>

                        </section>


                        <!-- STEP 2 -->
                        <section class="pl-form-section">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">02</div>

                                <div>
                                    <span>BASIC INFORMATION</span>
                                    <h2>Basic Information</h2>
                                    <p>
                                        Add the main information visitors
                                        will see.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-form-grid">

                                <div class="pl-form-group full">
                                    <label>
                                        Title
                                        <em>*</em>
                                    </label>

                                    <input type="text"
                                           name="title"
                                           required
                                           placeholder="Enter event or advertisement title">
                                </div>


                                <div class="pl-form-group">
                                    <label>
                                        Category
                                        <em>*</em>
                                    </label>

                                    <select name="category"
                                            id="category"
                                            required>

                                        <option value="">
                                            Select Category
                                        </option>

                                        <option>Community Events</option>
                                        <option>Cultural Programs</option>
                                        <option>Festivals</option>
                                        <option>Meetings</option>
                                        <option>Weddings & Celebrations</option>
                                        <option>Business Promotions</option>
                                        <option>Product Launches</option>
                                        <option>Public Announcements</option>
                                        <option>Social Initiatives</option>
                                        <option>Other Approved Posts</option>

                                    </select>
                                </div>


                                <div class="pl-form-group">
                                    <label>
                                        Visibility
                                        <em>*</em>
                                    </label>

                                    <select name="visibility"
                                            id="visibility"
                                            required
                                            onchange="toggleVisibility()">

                                        <option value="Community">
                                            Community-Specific
                                        </option>

                                        <option value="Global">
                                            Global
                                        </option>

                                    </select>
                                </div>


                                <div class="pl-form-group"
                                     id="communityGroup">

                                    <label>
                                        Community
                                        <em>*</em>
                                    </label>

                                    <select name="community"
                                            id="community">

                                        <option value="">
                                            Select Community
                                        </option>

                                        <option>Arya Vysya</option>
                                        <option>Reddy</option>
                                        <option>Kamma</option>
                                        <option>Kapu</option>
                                        <option>Banjara</option>
                                        <option>Yadava</option>
                                        <option>Padmashali</option>
                                        <option>Goud</option>
                                        <option>Chakali</option>
                                        <option>Mudiraj</option>
                                        <option>Viswakarma</option>
                                        <option>Other Communities</option>

                                    </select>

                                    <small>
                                        Community-specific content will
                                        appear within the selected community.
                                    </small>

                                </div>


                                <div class="pl-form-group full">
                                    <label>
                                        Short Description
                                        <em>*</em>
                                    </label>

                                    <input type="text"
                                           name="short_description"
                                           maxlength="300"
                                           required
                                           placeholder="Write a short description">

                                    <small>
                                        Keep this concise for listing cards.
                                    </small>
                                </div>


                                <div class="pl-form-group full">
                                    <label>
                                        Detailed Description
                                        <em>*</em>
                                    </label>

                                    <textarea name="description"
                                              rows="7"
                                              required
                                              placeholder="Describe your event or advertisement in detail..."></textarea>
                                </div>

                            </div>

                        </section>


                        <!-- EVENT DETAILS -->
                        <section class="pl-form-section"
                                 id="eventDetailsSection">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">03</div>

                                <div>
                                    <span>EVENT INFORMATION</span>
                                    <h2>Event Details</h2>
                                    <p>
                                        Complete these details when posting
                                        an event.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-form-grid">

                                <div class="pl-form-group full">
                                    <label>Event Name</label>

                                    <input type="text"
                                           name="event_name"
                                           placeholder="Event name">
                                </div>


                                <div class="pl-form-group">
                                    <label>Event Category</label>

                                    <select name="event_category">

                                        <option value="">
                                            Select Event Category
                                        </option>

                                        <option>Community Event</option>
                                        <option>Cultural Program</option>
                                        <option>Festival</option>
                                        <option>Meeting</option>
                                        <option>Celebration</option>
                                        <option>Social Initiative</option>
                                        <option>Other</option>

                                    </select>
                                </div>


                                <div class="pl-form-group">
                                    <label>Date</label>

                                    <input type="date"
                                           name="event_date">
                                </div>


                                <div class="pl-form-group">
                                    <label>Start Time</label>

                                    <input type="time"
                                           name="start_time">
                                </div>


                                <div class="pl-form-group">
                                    <label>End Time</label>

                                    <input type="time"
                                           name="end_time">
                                </div>


                                <div class="pl-form-group">
                                    <label>Venue</label>

                                    <input type="text"
                                           name="venue"
                                           placeholder="Venue / Hall / Location">
                                </div>


                                <div class="pl-form-group">
                                    <label>City / Location</label>

                                    <input type="text"
                                           name="event_location"
                                           placeholder="City / Area">
                                </div>


                                <div class="pl-form-group">
                                    <label>Organiser Name</label>

                                    <input type="text"
                                           name="organiser_name"
                                           placeholder="Organiser name">
                                </div>


                                <div class="pl-form-group">
                                    <label>Contact Information</label>

                                    <input type="text"
                                           name="event_contact"
                                           placeholder="Phone / Email">
                                </div>


                                <div class="pl-form-group">
                                    <label>Entry Fee</label>

                                    <div class="pl-input-prefix">
                                        <span>₹</span>

                                        <input type="number"
                                               name="entry_fee"
                                               min="0"
                                               placeholder="0">
                                    </div>
                                </div>


                                <div class="pl-form-group">
                                    <label>Registration Required</label>

                                    <select name="registration_required"
                                            id="registrationRequired"
                                            onchange="toggleRegistrationClosing()">

                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>

                                    </select>
                                </div>


                                <div class="pl-form-group"
                                     id="registrationClosingGroup"
                                     style="display:none;">

                                    <label>
                                        Registration Closing Date
                                    </label>

                                    <input type="date"
                                           name="registration_closing">

                                </div>

                            </div>

                        </section>


                        <!-- ADVERTISEMENT DETAILS -->
                        <section class="pl-form-section"
                                 id="advertisementDetailsSection"
                                 style="display:none;">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">03</div>

                                <div>
                                    <span>ADVERTISEMENT INFORMATION</span>
                                    <h2>Advertisement Details</h2>
                                    <p>
                                        Complete these details when publishing
                                        an advertisement.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-form-grid">

                                <div class="pl-form-group full">
                                    <label>
                                        Business / Organisation Name
                                    </label>

                                    <input type="text"
                                           name="business_name"
                                           placeholder="Business or organisation name">
                                </div>


                                <div class="pl-form-group">
                                    <label>
                                        Advertisement Category
                                    </label>

                                    <select name="advertisement_category">

                                        <option value="">
                                            Select Category
                                        </option>

                                        <option>Business Promotion</option>
                                        <option>Product Launch</option>
                                        <option>Service Advertisement</option>
                                        <option>Public Announcement</option>
                                        <option>Offer / Promotion</option>
                                        <option>Other</option>

                                    </select>
                                </div>


                                <div class="pl-form-group">
                                    <label>Product / Service</label>

                                    <input type="text"
                                           name="product_service"
                                           placeholder="Product or service">
                                </div>


                                <div class="pl-form-group full">
                                    <label>Offer / Promotion</label>

                                    <input type="text"
                                           name="offer_promotion"
                                           placeholder="Offer or promotion details">
                                </div>


                                <div class="pl-form-group">
                                    <label>Validity From</label>

                                    <input type="date"
                                           name="validity_from">
                                </div>


                                <div class="pl-form-group">
                                    <label>Validity To</label>

                                    <input type="date"
                                           name="validity_to">
                                </div>


                                <div class="pl-form-group">
                                    <label>Location</label>

                                    <input type="text"
                                           name="ad_location"
                                           placeholder="City / Area">
                                </div>


                                <div class="pl-form-group">
                                    <label>Contact Information</label>

                                    <input type="text"
                                           name="ad_contact"
                                           placeholder="Phone / Email">
                                </div>


                                <div class="pl-form-group full">
                                    <label>Website</label>

                                    <input type="url"
                                           name="website"
                                           placeholder="https://example.com">
                                </div>

                            </div>

                        </section>


                        <!-- VISIBILITY -->
                        <section class="pl-form-section">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">04</div>

                                <div>
                                    <span>VISIBILITY</span>
                                    <h2>Select Visibility</h2>
                                    <p>
                                        Decide where your approved content
                                        can appear.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-visibility-options">

                                <label class="pl-visibility-option active">

                                    <input type="radio"
                                           name="visibility_option"
                                           value="Community"
                                           checked
                                           onchange="setVisibilityOption('Community')">

                                    <div class="pl-visibility-icon community">
                                        <i class="bi bi-people"></i>
                                    </div>

                                    <div>
                                        <strong>Community-Specific</strong>

                                        <p>
                                            Display the post only within
                                            the selected community.
                                        </p>

                                        <small>
                                            <i class="bi bi-check-circle-fill"></i>
                                            Community selection required
                                        </small>
                                    </div>

                                </label>


                                <label class="pl-visibility-option">

                                    <input type="radio"
                                           name="visibility_option"
                                           value="Global"
                                           onchange="setVisibilityOption('Global')">

                                    <div class="pl-visibility-icon global">
                                        <i class="bi bi-globe2"></i>
                                    </div>

                                    <div>
                                        <strong>Global</strong>

                                        <p>
                                            Display the approved content
                                            across eligible PeopleLink users.
                                        </p>

                                        <small>
                                            <i class="bi bi-info-circle"></i>
                                            Package may apply for advertisements
                                        </small>
                                    </div>

                                </label>

                            </div>

                        </section>


                        <!-- PACKAGE -->
                        <section class="pl-form-section"
                                 id="packageSection">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">05</div>

                                <div>
                                    <span>ADVERTISEMENT PACKAGE</span>
                                    <h2>Select Advertisement Package</h2>
                                    <p>
                                        Package selection can apply to paid
                                        advertisements where enabled.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-package-select-box">

                                <div class="pl-package-info">

                                    <div class="pl-package-info-icon">
                                        <i class="bi bi-megaphone"></i>
                                    </div>

                                    <div>
                                        <strong>Advertising Package</strong>

                                        <p>
                                            Select an available package based
                                            on visibility, validity, placement,
                                            featured position and number of posts.
                                        </p>
                                    </div>

                                </div>


                                <select name="advertisement_package"
                                        id="advertisementPackage">

                                    <option value="">
                                        No paid package / Not applicable
                                    </option>

                                    <option value="Community Basic">
                                        Community Advertisement - Basic
                                    </option>

                                    <option value="Community Featured">
                                        Community Advertisement - Featured
                                    </option>

                                    <option value="Global Basic">
                                        Global Advertisement - Basic
                                    </option>

                                    <option value="Global Featured">
                                        Global Advertisement - Featured
                                    </option>

                                </select>


                                <button type="button"
                                        class="pl-post-btn pl-post-btn-outline"
                                        onclick="openPackages()">
                                    <i class="bi bi-eye"></i>
                                    View Packages
                                </button>

                            </div>

                        </section>


                        <!-- MEDIA -->
                        <section class="pl-form-section">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">06</div>

                                <div>
                                    <span>MEDIA</span>
                                    <h2>Upload Media</h2>
                                    <p>
                                        Add approved promotional material
                                        for your post.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-upload-box">

                                <div class="pl-upload-icon">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </div>

                                <div class="pl-upload-content">

                                    <h3>Upload Event or Advertisement Media</h3>

                                    <p>
                                        Event posters, advertisement banners,
                                        product images, business images or
                                        supporting creatives.
                                    </p>

                                    <label class="pl-upload-btn">

                                        <i class="bi bi-folder2-open"></i>
                                        Choose Images

                                        <input type="file"
                                               name="media[]"
                                               id="mediaUpload"
                                               accept="image/*"
                                               multiple
                                               hidden>

                                    </label>

                                </div>

                            </div>


                            <div class="pl-upload-preview"
                                 id="uploadPreview">
                            </div>

                        </section>


                        <!-- LIVE LINK -->
                        <section class="pl-form-section"
                                 id="liveLinkSection">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">07</div>

                                <div>
                                    <span>EXTERNAL STREAM</span>
                                    <h2>External Live Link</h2>
                                    <p>
                                        Add a third-party live-stream URL
                                        when applicable.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-live-input-box">

                                <div class="pl-live-icon">
                                    <i class="bi bi-broadcast"></i>
                                </div>

                                <div class="pl-live-input">

                                    <label>Live Stream URL</label>

                                    <input type="url"
                                           name="live_url"
                                           placeholder="https://example.com/live-event">

                                    <small>
                                        PeopleLink only provides a field to
                                        add and display the external link.
                                        No independent live-streaming system
                                        is hosted.
                                    </small>

                                </div>

                            </div>

                        </section>


                        <!-- CONTACT OPTIONS -->
                        <section class="pl-form-section">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">08</div>

                                <div>
                                    <span>CONTACT</span>
                                    <h2>Contact & Enquiry Options</h2>
                                    <p>
                                        Choose which contact methods may be
                                        available to eligible users.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-contact-options">

                                <label>
                                    <input type="checkbox"
                                           name="contact_options[]"
                                           value="Phone"
                                           checked>

                                    <span>
                                        <i class="bi bi-telephone"></i>
                                        Phone
                                    </span>
                                </label>


                                <label>
                                    <input type="checkbox"
                                           name="contact_options[]"
                                           value="WhatsApp"
                                           checked>

                                    <span>
                                        <i class="bi bi-whatsapp"></i>
                                        WhatsApp
                                    </span>
                                </label>


                                <label>
                                    <input type="checkbox"
                                           name="contact_options[]"
                                           value="Email"
                                           checked>

                                    <span>
                                        <i class="bi bi-envelope"></i>
                                        Email
                                    </span>
                                </label>


                                <label>
                                    <input type="checkbox"
                                           name="contact_options[]"
                                           value="Enquiry Form"
                                           checked>

                                    <span>
                                        <i class="bi bi-send"></i>
                                        Enquiry Form
                                    </span>
                                </label>

                            </div>


                            <div class="pl-contact-note">
                                <i class="bi bi-shield-check"></i>

                                Only approved contact information will
                                be displayed according to configured
                                PeopleLink permissions.
                            </div>

                        </section>


                        <!-- PREVIEW -->
                        <section class="pl-form-section">

                            <div class="pl-form-heading">

                                <div class="pl-form-number">09</div>

                                <div>
                                    <span>REVIEW</span>
                                    <h2>Preview Before Submission</h2>
                                    <p>
                                        Review your post before sending it
                                        for approval.
                                    </p>
                                </div>

                            </div>


                            <div class="pl-preview-box">

                                <div class="pl-preview-image"
                                     id="previewImage">

                                    <div>
                                        <i class="bi bi-image"></i>
                                        <span>Featured Image</span>
                                    </div>

                                </div>

                                <div class="pl-preview-content">

                                    <div class="pl-preview-badges">

                                        <span id="previewType">
                                            Event
                                        </span>

                                        <span id="previewVisibility">
                                            Community
                                        </span>

                                    </div>

                                    <h3 id="previewTitle">
                                        Your post title will appear here
                                    </h3>

                                    <p id="previewDescription">
                                        Your short description will appear
                                        here.
                                    </p>

                                    <div class="pl-preview-meta">

                                        <span>
                                            <i class="bi bi-calendar3"></i>
                                            <strong id="previewDate">
                                                Date
                                            </strong>
                                        </span>

                                        <span>
                                            <i class="bi bi-geo-alt"></i>
                                            <strong id="previewLocation">
                                                Location
                                            </strong>
                                        </span>

                                    </div>

                                </div>

                            </div>


                            <button type="button"
                                    class="pl-post-btn pl-post-btn-outline pl-preview-button"
                                    onclick="openPreview()">

                                <i class="bi bi-eye"></i>
                                Preview Post

                            </button>

                        </section>


                        <!-- SUBMIT -->
                        <section class="pl-submit-section">

                            <div class="pl-submit-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>

                            <div class="pl-submit-content">

                                <span>FINAL STEP</span>

                                <h2>Submit for Approval</h2>

                                <p>
                                    Submitted content can be reviewed by the
                                    authorised Community Admin or Super Admin
                                    before publication.
                                </p>

                                <div class="pl-status-list">

                                    <span>
                                        <i class="bi bi-file-earmark"></i>
                                        Draft
                                    </span>

                                    <span>
                                        <i class="bi bi-hourglass-split"></i>
                                        Pending Approval
                                    </span>

                                    <span>
                                        <i class="bi bi-check-circle"></i>
                                        Approved
                                    </span>

                                    <span>
                                        <i class="bi bi-pencil"></i>
                                        Requires Changes
                                    </span>

                                    <span>
                                        <i class="bi bi-x-circle"></i>
                                        Rejected
                                    </span>

                                </div>

                            </div>

                            <button type="submit"
                                    class="pl-post-btn pl-post-btn-white">
                                <i class="bi bi-send"></i>
                                Submit for Approval
                            </button>

                        </section>

                    </form>

                </div>


                <!-- SIDEBAR -->
                <aside class="pl-post-sidebar">

                    <!-- PROGRESS -->
                    <div class="pl-sidebar-card">

                        <span class="pl-sidebar-label">
                            CREATE POST
                        </span>

                        <h3>Your Publishing Journey</h3>

                        <div class="pl-progress-list">

                            <div class="pl-progress-item active">
                                <span>01</span>
                                <div>
                                    <strong>Choose Type</strong>
                                    <small>Event or Advertisement</small>
                                </div>
                            </div>

                            <div class="pl-progress-item">
                                <span>02</span>
                                <div>
                                    <strong>Basic Information</strong>
                                    <small>Title and description</small>
                                </div>
                            </div>

                            <div class="pl-progress-item">
                                <span>03</span>
                                <div>
                                    <strong>Post Details</strong>
                                    <small>Event / Advertisement</small>
                                </div>
                            </div>

                            <div class="pl-progress-item">
                                <span>04</span>
                                <div>
                                    <strong>Visibility</strong>
                                    <small>Community or Global</small>
                                </div>
                            </div>

                            <div class="pl-progress-item">
                                <span>05</span>
                                <div>
                                    <strong>Media & Contact</strong>
                                    <small>Images and options</small>
                                </div>
                            </div>

                            <div class="pl-progress-item">
                                <span>06</span>
                                <div>
                                    <strong>Submit</strong>
                                    <small>Admin approval</small>
                                </div>
                            </div>

                        </div>

                    </div>


                    <!-- TIPS -->
                    <div class="pl-sidebar-card pl-tips-card">

                        <div class="pl-tips-icon">
                            <i class="bi bi-lightbulb"></i>
                        </div>

                        <h3>Publishing Tips</h3>

                        <ul>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Use a clear title.
                            </li>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Add accurate dates and locations.
                            </li>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Upload suitable approved images.
                            </li>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Select the correct visibility.
                            </li>

                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                Review before submitting.
                            </li>

                        </ul>

                    </div>


                    <!-- MY POSTS -->
                    <div class="pl-sidebar-card pl-my-posts-card">

                        <span class="pl-sidebar-label">
                            MANAGE
                        </span>

                        <h3>Manage My Posts</h3>

                        <p>
                            Access your submitted Events and Advertisements
                            and manage permitted details.
                        </p>

                        <div class="pl-my-post-actions">

                            <button onclick="openMyPosts()">
                                <i class="bi bi-grid"></i>
                                My Events & Ads
                            </button>

                            <button onclick="showPostToast('Post renewal will be available where permitted.')">
                                <i class="bi bi-arrow-repeat"></i>
                                Renew Advertisement
                            </button>

                        </div>

                    </div>

                </aside>

            </div>

        </div>
    </section>


    <!-- FINAL CTA -->
    <section class="pl-post-final-cta">

        <div class="pl-post-container">

            <div class="pl-post-final-content">

                <div>
                    <span>PEOPLELINK</span>

                    <h2>Promote. Connect. Engage.</h2>

                    <p>
                        Share approved events, announcements and business
                        promotions with the right audience through PeopleLink.
                    </p>
                </div>

                <div class="pl-post-final-buttons">

                    <button class="pl-post-btn pl-post-btn-white"
                            onclick="scrollToForm()">
                        <i class="bi bi-plus-circle"></i>
                        Create Post
                    </button>

                    <button class="pl-post-btn pl-post-btn-ghost"
                            onclick="openMyPosts()">
                        <i class="bi bi-grid"></i>
                        My Posts
                    </button>

                    <button class="pl-post-btn pl-post-btn-ghost"
                            onclick="openPackages()">
                        <i class="bi bi-megaphone"></i>
                        View Packages
                    </button>

                </div>

            </div>

        </div>

    </section>

</main>


<!-- PREVIEW MODAL -->
<div class="pl-post-modal"
     id="previewModal">

    <div class="pl-post-modal-overlay"
         onclick="closePostModal('previewModal')"></div>

    <div class="pl-post-modal-box pl-preview-modal">

        <button class="pl-post-modal-close"
                onclick="closePostModal('previewModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-modal-heading">

            <span>
                <i class="bi bi-eye"></i>
            </span>

            <div>
                <small>PREVIEW</small>
                <h3>Your Post Preview</h3>
            </div>

        </div>

        <div class="pl-preview-live">

            <div class="pl-preview-live-image"
                 id="modalPreviewImage">

                <i class="bi bi-image"></i>

            </div>

            <div class="pl-preview-live-content">

                <div class="pl-preview-badges">

                    <span id="modalPreviewType">
                        Event
                    </span>

                    <span id="modalPreviewVisibility">
                        Community
                    </span>

                </div>

                <h2 id="modalPreviewTitle">
                    Your post title
                </h2>

                <p id="modalPreviewDescription">
                    Your description will appear here.
                </p>

                <div class="pl-modal-preview-info">

                    <span>
                        <i class="bi bi-calendar3"></i>
                        <strong id="modalPreviewDate">
                            Date
                        </strong>
                    </span>

                    <span>
                        <i class="bi bi-geo-alt"></i>
                        <strong id="modalPreviewLocation">
                            Location
                        </strong>
                    </span>

                </div>

            </div>

        </div>

        <div class="pl-preview-warning">
            <i class="bi bi-info-circle"></i>
            This is a preview. Your post will still require approval
            before it becomes visible to users.
        </div>

        <button class="pl-post-btn pl-post-btn-primary"
                onclick="closePostModal('previewModal')">
            <i class="bi bi-check"></i>
            Continue Editing
        </button>

    </div>

</div>


<!-- PACKAGE MODAL -->
<div class="pl-post-modal"
     id="packageModal">

    <div class="pl-post-modal-overlay"
         onclick="closePostModal('packageModal')"></div>

    <div class="pl-post-modal-box">

        <button class="pl-post-modal-close"
                onclick="closePostModal('packageModal')">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-modal-heading">

            <span>
                <i class="bi bi-megaphone"></i>
            </span>

            <div>
                <small>ADVERTISEMENT</small>
                <h3>Advertisement Packages</h3>
            </div>

        </div>

        <p class="pl-package-modal-intro">
            Available packages can vary according to visibility,
            validity, placement, featured position and number of posts.
        </p>

        <div class="pl-modal-packages">

            <div>
                <i class="bi bi-people"></i>
                <strong>Community Basic</strong>
                <small>Community visibility</small>
            </div>

            <div>
                <i class="bi bi-star"></i>
                <strong>Community Featured</strong>
                <small>Featured community position</small>
            </div>

            <div>
                <i class="bi bi-globe2"></i>
                <strong>Global Basic</strong>
                <small>Global visibility</small>
            </div>

            <div>
                <i class="bi bi-award"></i>
                <strong>Global Featured</strong>
                <small>Featured global position</small>
            </div>

        </div>

        <button class="pl-post-btn pl-post-btn-primary"
                onclick="selectPackageFromModal()">
            <i class="bi bi-check-circle"></i>
            Select Package
        </button>

    </div>

</div>


<!-- TOAST -->
<div class="pl-post-toast"
     id="postToast">

    <i class="bi bi-check-circle-fill"></i>

    <span id="postToastMessage">
        Done
    </span>

</div>


 

<?php include 'footer.php'; ?>