<?php
include 'header.php';
?>
 
<main class="pl-post-page">
  <section class="pl-post-hero"><div class="pl-wrap pl-hero-inner">
    <div><span class="pl-eyebrow"><i class="fa-solid fa-calendar-check"></i> PEOPLELINK COMMUNITY</span>
      <h1>Bring your <span>event</span> or offer to the community.</h1>
      <p>Create an event announcement or share a business offer with the right audience. Submit your details for review and keep your community informed.</p>
      <div class="pl-hero-points"><span><i class="fa-solid fa-circle-check"></i> Easy submission</span><span><i class="fa-solid fa-shield-halved"></i> Approval-ready</span><span><i class="fa-solid fa-people-group"></i> Community-first</span></div>
    </div>
    <div class="pl-hero-art"><div class="pl-art-back"><i class="fa-solid fa-bullhorn"></i> Share an offer</div><div class="pl-art-front"><div class="pl-art-icon"><i class="fa-solid fa-calendar-days"></i></div><strong>Make it happen.</strong><small>Events • People • Community</small><div class="pl-art-dots"><b></b><b></b><b></b><b></b></div></div></div>
  </div></section>
  <section class="pl-wrap pl-main">
    <div class="pl-intro"><div><span class="pl-kicker">CREATE A NEW POST</span><h2>Post Event / Advertisement</h2><p>Choose a type, complete the relevant details, and preview before submitting.</p></div><div class="pl-step"><b>01</b><span><strong>One simple form</strong><small>Only relevant fields are shown</small></span></div></div>
    <form id="plPostForm" enctype="multipart/form-data" novalidate>
      <section class="pl-card">
        <div class="pl-card-title"><span class="pl-title-icon"><i class="fa-solid fa-layer-group"></i></span><div><h3>What would you like to post?</h3><p>Select a post type to display the right fields.</p></div></div>
        <div class="pl-type-grid">
          <label class="pl-type-option is-selected"><input type="radio" name="post_type" value="event" checked><span class="pl-type-icon"><i class="fa-solid fa-calendar-days"></i></span><span><strong>Event</strong><small>Meetups, functions, programs and community gatherings</small></span><b class="pl-check"><i class="fa-solid fa-check"></i></b></label>
          <label class="pl-type-option"><input type="radio" name="post_type" value="advertisement"><span class="pl-type-icon pl-ad-icon"><i class="fa-solid fa-bullhorn"></i></span><span><strong>Advertisement</strong><small>Promote a business, product, service or special offer</small></span><b class="pl-check"><i class="fa-solid fa-check"></i></b></label>
        </div>
      </section>
      <div class="pl-layout"><div>
        <section class="pl-card pl-section" data-section="event">
          <div class="pl-card-title"><span class="pl-title-icon"><i class="fa-solid fa-calendar-plus"></i></span><div><h3>Basic event information</h3><p>Introduce your event and organiser.</p></div></div>
          <div class="pl-grid">
            <div class="pl-field full"><label>Event name *</label><input name="event_name" data-required placeholder="e.g. Annual Community Celebration"><small class="pl-error"></small></div>
            <div class="pl-field"><label>Event category *</label><select name="event_category" data-required><option value="">Select category</option><option>Community Gathering</option><option>Cultural Program</option><option>Festival / Celebration</option><option>Business & Networking</option><option>Education / Workshop</option><option>Health & Wellness</option><option>Sports</option><option>Charity / Social Service</option><option>Other</option></select><small class="pl-error"></small></div>
            <div class="pl-field"><label>Organiser name *</label><input name="organiser_name" data-required placeholder="Organisation or organiser"><small class="pl-error"></small></div>
            <div class="pl-field"><label>Community name <i>Optional</i></label><input name="community_name" placeholder="e.g. Arya Vysya"></div>
            <div class="pl-field full"><label>Short description *</label><textarea name="event_short_description" rows="2" maxlength="220" data-required placeholder="Quick introduction (max 220 characters)"></textarea><small class="pl-error"></small></div>
            <div class="pl-field full"><label>Detailed description *</label><textarea name="event_description" rows="4" data-required placeholder="Purpose, activities, audience and important instructions"></textarea><small class="pl-error"></small></div>
            <div class="pl-field full"><label>Event image / banner <i>Optional</i></label><label class="pl-upload"><input type="file" name="event_image" accept="image/*" data-image="event"><i class="fa-solid fa-cloud-arrow-up"></i><span><strong>Upload event banner</strong><small>JPG, PNG or WebP. Recommended landscape image.</small><em data-filename="event">Choose file</em></span></label><div class="pl-image-preview" data-preview-image="event"></div></div>
          </div>
        </section>
        <section class="pl-card pl-section" data-section="event">
          <div class="pl-card-title"><span class="pl-title-icon"><i class="fa-regular fa-clock"></i></span><div><h3>Event schedule & venue</h3><p>Help attendees know when and where to join.</p></div></div>
          <div class="pl-grid">
            <div class="pl-field"><label>Event date *</label><input type="date" name="event_date" data-required><small class="pl-error"></small></div>
            <div class="pl-field"><label>Registration closing date</label><input type="date" name="registration_closing_date"></div>
            <div class="pl-field"><label>Start time *</label><input type="time" name="start_time" data-required><small class="pl-error"></small></div>
            <div class="pl-field"><label>End time</label><input type="time" name="end_time"></div>
            <div class="pl-field"><label>Venue name *</label><input name="venue_name" data-required placeholder="Hall, centre or venue"><small class="pl-error"></small></div>
            <div class="pl-field"><label>City / location *</label><input name="event_city" data-required placeholder="City or town"><small class="pl-error"></small></div>
            <div class="pl-field full"><label>Address</label><textarea name="event_address" rows="2" placeholder="Street, landmark and directions"></textarea></div>
          </div>
        </section>
        <section class="pl-card pl-section" data-section="event">
          <div class="pl-card-title"><span class="pl-title-icon"><i class="fa-solid fa-ticket"></i></span><div><h3>Registration details</h3><p>Set entry and participant limits if needed.</p></div></div>
          <div class="pl-grid">
            <div class="pl-field"><label>Registration required?</label><div class="pl-radio"><label><input type="radio" name="registration_required" value="yes" checked> Yes</label><label><input type="radio" name="registration_required" value="no"> No</label></div></div>
            <div class="pl-field"><label>Entry type</label><div class="pl-radio"><label><input type="radio" name="entry_type" value="free" checked> Free</label><label><input type="radio" name="entry_type" value="paid"> Paid</label></div></div>
            <div class="pl-field pl-paid" hidden><label>Entry fee (₹)</label><input type="number" min="0" step=".01" name="entry_fee" placeholder="e.g. 250"></div>
            <div class="pl-field"><label>Maximum participants <i>Optional</i></label><input type="number" min="1" name="max_participants" placeholder="No limit"></div>
          </div>
        </section>
        <section class="pl-card pl-section" data-section="advertisement" hidden>
          <div class="pl-card-title"><span class="pl-title-icon pl-orange"><i class="fa-solid fa-bullhorn"></i></span><div><h3>Advertisement information</h3><p>Describe the offer and what you want to promote.</p></div></div>
          <div class="pl-grid">
            <div class="pl-field full"><label>Advertisement title *</label><input name="ad_title" data-required placeholder="e.g. Special Festival Offer"><small class="pl-error"></small></div>
            <div class="pl-field"><label>Category *</label><select name="ad_category" data-required><option value="">Select category</option><option>Retail & Shopping</option><option>Food & Catering</option><option>Professional Services</option><option>Education & Training</option><option>Health & Wellness</option><option>Home & Lifestyle</option><option>Real Estate</option><option>Jobs & Careers</option><option>Community Announcement</option><option>Other</option></select><small class="pl-error"></small></div>
            <div class="pl-field"><label>Advertiser / business name *</label><input name="advertiser_name" data-required placeholder="Business or advertiser"><small class="pl-error"></small></div>
            <div class="pl-field full"><label>Short description *</label><textarea name="ad_short_description" rows="2" maxlength="220" data-required placeholder="Summarise the product, service or offer"></textarea><small class="pl-error"></small></div>
            <div class="pl-field full"><label>Detailed description *</label><textarea name="ad_description" rows="4" data-required placeholder="Features, terms, benefits and how people can respond"></textarea><small class="pl-error"></small></div>
            <div class="pl-field"><label>Product / service name *</label><input name="product_service_name" data-required placeholder="Product or service"><small class="pl-error"></small></div>
            <div class="pl-field"><label>Price (₹) <i>Optional</i></label><input type="number" min="0" step=".01" name="ad_price" placeholder="If applicable"></div>
            <div class="pl-field full"><label>Offer details <i>Optional</i></label><textarea name="offer_details" rows="2" placeholder="Discount, coupon code, terms or expiry"></textarea></div>
            <div class="pl-field full"><label>Banner / image <i>Optional</i></label><label class="pl-upload"><input type="file" name="ad_image" accept="image/*" data-image="ad"><i class="fa-solid fa-image"></i><span><strong>Upload advertisement image</strong><small>JPG, PNG or WebP. Use a clear promotional image.</small><em data-filename="ad">Choose file</em></span></label><div class="pl-image-preview" data-preview-image="ad"></div></div>
          </div>
        </section>
        <section class="pl-card pl-section" data-section="advertisement" hidden>
          <div class="pl-card-title"><span class="pl-title-icon pl-orange"><i class="fa-regular fa-calendar"></i></span><div><h3>Advertisement validity & location</h3><p>Choose when the promotion is active and where it applies.</p></div></div>
          <div class="pl-grid">
            <div class="pl-field"><label>Start date *</label><input type="date" name="ad_start_date" data-required><small class="pl-error"></small></div>
            <div class="pl-field"><label>End date *</label><input type="date" name="ad_end_date" data-required><small class="pl-error"></small></div>
            <div class="pl-field"><label>City *</label><input name="ad_city" data-required placeholder="City or town"><small class="pl-error"></small></div>
            <div class="pl-field"><label>Area / locality</label><input name="ad_area" placeholder="Neighbourhood or locality"></div>
            <div class="pl-field full"><label>Address <i>Optional</i></label><textarea name="ad_address" rows="2" placeholder="Business address or service area"></textarea></div>
          </div>
        </section>
        <section class="pl-card pl-section" data-section="event advertisement">
          <div class="pl-card-title"><span class="pl-title-icon"><i class="fa-solid fa-address-card"></i></span><div><h3>Contact details</h3><p>Let interested people reach the right person.</p></div></div>
          <div class="pl-grid">
            <div class="pl-field"><label>Contact person *</label><input name="contact_person" data-required placeholder="Full name"><small class="pl-error"></small></div>
            <div class="pl-field"><label>Mobile number *</label><input type="tel" name="mobile_number" data-required placeholder="Mobile number"><small class="pl-error"></small></div>
            <div class="pl-field"><label>WhatsApp number</label><input type="tel" name="whatsapp_number" placeholder="If different from mobile"></div>
            <div class="pl-field"><label>Email ID *</label><input type="email" name="email" data-required placeholder="name@example.com"><small class="pl-error"></small></div>
            <div class="pl-field full" data-event-live><label>Live program link <i>Optional</i></label><input type="url" name="live_link" placeholder="https://youtube.com/..."><small class="pl-help">YouTube, Facebook or another external link. PeopleLink does not host the stream.</small></div>
            <div class="pl-field full" data-ad-website hidden><label>Website / external link <i>Optional</i></label><input type="url" name="ad_website" placeholder="https://example.com"></div>
          </div>
        </section>
        <section class="pl-card">
          <div class="pl-card-title"><span class="pl-title-icon"><i class="fa-solid fa-earth-asia"></i></span><div><h3>Visibility & publishing</h3><p>Choose who should discover this post.</p></div></div>
          <div class="pl-grid">
            <div class="pl-field full"><label>Visibility *</label><select name="visibility" id="plVisibility"><option value="community">Community-specific</option><option value="global">Global (if allowed)</option></select><small class="pl-help">Global publishing depends on account permissions and admin settings.</small></div>
            <div class="pl-field full" id="plCommunityField"><label>Target community *</label><input name="target_community" id="plCommunity" placeholder="Choose or enter the community name"><small class="pl-error"></small></div>
          </div>
          <div class="pl-policy"><i class="fa-solid fa-circle-info"></i><span>Submissions may be reviewed by an administrator before publication. Ensure your information and images are accurate and appropriate.</span></div>
        </section>
        <div class="pl-actions"><button type="button" class="pl-btn pl-outline" id="plPreviewBtn"><i class="fa-regular fa-eye"></i> Preview</button><button type="button" class="pl-btn pl-light" id="plDraftBtn"><i class="fa-regular fa-floppy-disk"></i> Save Draft</button><button type="submit" class="pl-btn pl-primary"><i class="fa-solid fa-paper-plane"></i> Submit for Approval</button></div>
        <p class="pl-demo-note"><i class="fa-solid fa-circle-info"></i> Demo form: draft and submission actions show local confirmation only. Connect a secure PHP endpoint and database to save posts permanently.</p>
      </div>
      <aside class="pl-sidebar">
        <div class="pl-side-card"><span class="pl-side-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></span><h3>Make your post stand out</h3><ul><li>Use a clear, descriptive title.</li><li>Add a good-quality banner.</li><li>Include accurate dates and contacts.</li><li>Keep instructions and offer terms clear.</li></ul></div>
        <div class="pl-side-card pl-review-card"><span class="pl-review-kicker"><i class="fa-solid fa-shield-halved"></i> COMMUNITY STANDARDS</span><h3>Review before publishing</h3><p>Your post may remain under review until an authorised administrator approves it.</p><div class="pl-status"><b></b><span><strong>Approval workflow</strong><small>Ready to submit for review</small></span></div></div>
        <div class="pl-side-card pl-help-card"><i class="fa-regular fa-lightbulb"></i><div><strong>Need help?</strong><p>Preview your post and check the details before submission.</p></div></div>
      </aside></div>
    </form>
  </section>
</main>
<div class="pl-modal" id="plPreviewModal" aria-hidden="true" role="dialog" aria-modal="true"><div class="pl-modal-shade" data-close></div><div class="pl-modal-box"><header><div><span class="pl-kicker">PREVIEW YOUR POST</span><h2>Check before you submit</h2></div><button type="button" data-close aria-label="Close"><i class="fa-solid fa-xmark"></i></button></header><div id="plPreviewContent" class="pl-preview-content"></div><footer><button type="button" class="pl-btn pl-outline" data-close>Keep editing</button><button type="button" class="pl-btn pl-primary" id="plPreviewSubmit">Submit for Approval <i class="fa-solid fa-arrow-right"></i></button></footer></div></div>
<div class="pl-toast" id="plToast" role="status" aria-live="polite"><i class="fa-solid fa-circle-check"></i><span><strong id="plToastTitle">Submission successful</strong><small id="plToastMessage"></small></span><button id="plToastClose" type="button" aria-label="Dismiss"><i class="fa-solid fa-xmark"></i></button></div>


<?php include 'footer.php'; ?>
