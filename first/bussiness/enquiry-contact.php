<?php include 'header.php'; ?>

  <main class="pl-page">
    <section class="pl-top-banner">
      <div class="banner-orb banner-orb-a"></div><div class="banner-orb banner-orb-b"></div>
      <div class="pl-container banner-inner">
        <nav class="pl-breadcrumb" aria-label="Breadcrumb"><a href="#"><i class="bi bi-house-door"></i> Home</a><i class="bi bi-chevron-right"></i><a href="professional-and-business-directory-search-results.html">Directory</a><i class="bi bi-chevron-right"></i><span>Contact listing</span></nav>
        <div class="banner-content">
          <div><span class="pl-eyebrow"><i class="bi bi-chat-square-heart"></i> START A CONVERSATION</span><h1>Connect with the right <span>people.</span></h1><p>Tell the professional or business what you need. A clear enquiry is the first step towards a useful connection.</p></div>
          <div class="banner-art" aria-hidden="true"><div class="art-circle"><i class="bi bi-chat-dots-fill"></i></div><span class="art-bubble bubble-one"><i class="bi bi-check-lg"></i></span><span class="art-bubble bubble-two"><i class="bi bi-send-fill"></i></span><span class="art-line line-one"></span><span class="art-line line-two"></span></div>
        </div>
      </div>
    </section>

    <section class="pl-container pl-content">
      <div class="pl-step-line"><span class="step-number"><i class="bi bi-pencil-square"></i></span><div><strong>Send an enquiry</strong><small>Share your requirement and preferred way to connect.</small></div><span class="secure-note"><i class="bi bi-shield-check"></i> Your details stay protected</span></div>
      <div class="pl-contact-grid">
        <aside class="listing-summary">
          <div class="summary-cover"><span class="cover-label"><i class="bi bi-patch-check-fill"></i> DIRECTORY LISTING</span><div class="cover-pattern"></div></div>
          <div class="summary-body">
            <div class="profile-row"><img id="listingPhoto" src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?auto=format&fit=crop&w=240&q=80" alt="Professional profile photo"><div class="profile-ident"><span class="listing-kind" id="listingKind">PROFESSIONAL</span><h2 id="listingName">Dr. Ananya Sharma</h2><span class="listing-category" id="listingCategory">Healthcare &amp; Wellness</span></div></div>
            <div class="summary-service"><span class="summary-icon"><i class="bi bi-stars"></i></span><div><small>Main service / specialization</small><strong id="listingService">Dentist · Cosmetic Dentistry</strong></div></div>
            <div class="summary-location"><i class="bi bi-geo-alt-fill"></i><span id="listingLocation">Rishikesh, Uttarakhand</span></div>
            <div class="summary-divider"></div>
            <div class="summary-help"><span class="help-icon"><i class="bi bi-lightbulb"></i></span><div><strong>Make your enquiry useful</strong><p>Explain what you need, include important details, and mention how you prefer to be contacted.</p></div></div>
            <a class="back-profile" id="backProfile" href="professional-and-business-profile-details.html"><i class="bi bi-arrow-left"></i> Back to profile</a>
          </div>
        </aside>

        <section class="enquiry-panel" id="enquiryPanel">
          <div class="panel-heading"><div><span class="pl-section-kicker">CONTACT DETAILS</span><h2>How can they help you?</h2><p>Review your details and describe your requirement below.</p></div><span class="required-note"><b>*</b> Required fields</span></div>
          <form id="enquiryForm" novalidate>
            <div class="form-section-title"><span>01</span><div><strong>Your details</strong><small>Use the details where the listing owner can reach you.</small></div></div>
            <div class="form-grid">
              <div class="form-field"><label for="fullName">Full name <b>*</b></label><input id="fullName" name="fullName" type="text" placeholder="Enter your full name" autocomplete="name" required><small class="field-error" data-error="fullName"></small></div>
              <div class="form-field"><label for="mobile">Mobile number <b>*</b></label><div class="input-with-prefix"><span>+91</span><input id="mobile" name="mobile" type="tel" inputmode="numeric" placeholder="10-digit mobile number" autocomplete="tel-national" maxlength="10" required></div><small class="field-error" data-error="mobile"></small></div>
              <div class="form-field full-field"><label for="email">Email address <b>*</b></label><input id="email" name="email" type="email" placeholder="you@example.com" autocomplete="email" required><small class="field-error" data-error="email"></small></div>
            </div>

            <div class="form-section-title section-spaced"><span>02</span><div><strong>Your enquiry</strong><small>Give the listing owner enough context to respond.</small></div></div>
            <div class="form-grid">
              <div class="form-field full-field"><label for="subject">Subject <b>*</b></label><input id="subject" name="subject" type="text" placeholder="e.g. Enquiry about your services" maxlength="120" required><small class="field-error" data-error="subject"></small></div>
              <div class="form-field full-field"><label for="message">Message / requirement <b>*</b></label><textarea id="message" name="message" rows="5" maxlength="2000" placeholder="Describe what you need, your timeline, or any important details..." required></textarea><div class="textarea-foot"><small class="field-error" data-error="message"></small><small><span id="messageCount">0</span>/2000</small></div></div>
              <div class="form-field full-field"><label>Preferred contact method <span class="optional">(Optional)</span></label><div class="contact-methods" role="group" aria-label="Preferred contact method"><label class="method-option"><input type="radio" name="preferredMethod" value="Call"><span><i class="bi bi-telephone"></i> Call</span></label><label class="method-option"><input type="radio" name="preferredMethod" value="WhatsApp"><span><i class="bi bi-whatsapp"></i> WhatsApp</span></label><label class="method-option"><input type="radio" name="preferredMethod" value="Email" checked><span><i class="bi bi-envelope"></i> Email</span></label></div></div>
            </div>
            <div class="direct-contact" id="directContact">
              <div class="direct-copy"><span class="direct-icon"><i class="bi bi-lightning-charge-fill"></i></span><div><strong>Prefer to contact them directly?</strong><small>Direct contact options are available for this listing.</small></div></div>
              <div class="direct-actions"><a href="#" id="callNow" class="direct-btn call-btn"><i class="bi bi-telephone-fill"></i> Call Now</a><a href="#" id="whatsApp" class="direct-btn whatsapp-btn" target="_blank" rel="noopener"><i class="bi bi-whatsapp"></i> WhatsApp</a><a href="#" id="emailOwner" class="direct-btn email-btn"><i class="bi bi-envelope-fill"></i> Email</a></div>
            </div>
            <div class="restricted-note" id="restrictedNote" hidden><i class="bi bi-shield-lock"></i><span><strong>Contact through PeopleLink</strong><small>This listing uses protected contact. Send an enquiry and the owner can respond through the platform.</small></span></div>
            <div class="form-bottom"><span><i class="bi bi-lock-fill"></i> Your information is only used to respond to this enquiry.</span><button type="submit" class="pl-submit" id="submitEnquiry">Send Enquiry <i class="bi bi-arrow-right"></i></button></div>
            <p class="form-error-summary" id="formErrorSummary" role="alert" hidden>Please check the highlighted fields and try again.</p>
          </form>
        </section>

        <section class="success-panel" id="successPanel" hidden aria-live="polite">
          <div class="success-visual"><div class="success-check"><i class="bi bi-check-lg"></i></div><span class="success-orbit orbit-a"></span><span class="success-orbit orbit-b"></span></div>
          <span class="success-kicker"><i class="bi bi-patch-check-fill"></i> ENQUIRY SUBMITTED</span>
          <h2>Enquiry Sent <span>Successfully!</span></h2>
          <p>Your enquiry has been recorded in this demo. Keep the details below for your reference.</p>
          <div class="success-details"><div><span>Enquiry ID</span><strong id="confirmationId">PL-ENQ-000001</strong><button id="copyEnquiryId" class="copy-id" type="button" aria-label="Copy enquiry ID"><i class="bi bi-copy"></i></button></div><div><span>Date</span><strong id="confirmationDate">12 October 2026</strong></div><div><span>Professional / Business</span><strong id="confirmationListing">Dr. Ananya Sharma</strong></div></div>
          <div class="success-actions"><a href="professional-and-business-profile-details.html" class="pl-btn pl-btn-primary" id="successBackProfile"><i class="bi bi-person-vcard"></i> Back to Profile</a><a href="professional-and-business-directory-search-results.html" class="pl-btn pl-btn-secondary"><i class="bi bi-search"></i> Browse More Listings</a></div>
          <small class="demo-disclaimer"><i class="bi bi-info-circle"></i> Demo confirmation only. Connect the form to your server to create and deliver real enquiries.</small>
        </section>
      </div>
      <footer class="pl-footer-note"><span><i class="bi bi-people-fill"></i> Better connections start with a conversation.</span><span>PeopleLink <i class="bi bi-dot"></i> Community &amp; Business Directory</span></footer>
    </section>
  </main>
  <div class="pl-toast" id="toast" role="status" aria-live="polite"><i class="bi bi-check-circle-fill"></i><span id="toastText">Copied successfully.</span></div>


<?php include 'footer.php'; ?>