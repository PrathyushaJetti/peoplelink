<?php include 'header.php'; ?>
 

<main class="support-submit-page">
    <!-- Hero -->
    <section class="pl-submit-hero">
        <div class="pl-support-container pl-submit-hero-inner">
            <div class="pl-submit-hero-copy">
                <a href="community-support.php" class="pl-back-link">← Community Support</a>
                <span class="pl-eyebrow"><span class="pl-eyebrow-dot"></span> PEOPLELINK COMMUNITY CARE</span>
                <h1>Ask for support.<br><span>Let your community show up.</span></h1>
                <p>Tell us what you need. We’ll help you share your request thoughtfully, with privacy and dignity at the centre.</p>
                <div class="pl-submit-benefits"><span>✓ One simple form</span><span>✓ Privacy choices</span><span>✓ Community review</span></div>
            </div>
            <div class="pl-submit-hero-card">
                <div class="pl-hero-card-symbol">♡</div><span>YOU ARE NOT ALONE</span><h2>Asking for help<br>is a strong first step.</h2><p>Share only the details needed to explain your request. Sensitive information should remain private.</p>
                <div class="pl-mini-progress"><span></span><span></span><span></span><span></span></div><small>Request · Review · Connection · Support</small>
            </div>
        </div>
    </section>

    <section class="pl-submit-content">
        <div class="pl-support-container pl-submit-layout">
            <aside class="pl-submit-sidebar">
                <div class="pl-sidebar-card">
                    <span class="pl-section-kicker">YOUR REQUEST JOURNEY</span>
                    <h3>Simple steps. Real connection.</h3>
                    <ol class="pl-step-list">
                        <li class="pl-step-active"><span>1</span><div><strong>Tell us what you need</strong><small>Choose a category and describe your request.</small></div></li>
                        <li><span>2</span><div><strong>Review your details</strong><small>Check what you want to share.</small></div></li>
                        <li><span>3</span><div><strong>Submit for review</strong><small>Our process may require approval.</small></div></li>
                    </ol>
                </div>
                <div class="pl-sidebar-help"><span class="pl-sidebar-help-icon">i</span><div><strong>Need urgent help?</strong><p>For immediate danger or a medical emergency, contact local emergency services. This form is not an emergency response service.</p></div></div>
                <div class="pl-sidebar-privacy"><span>♧</span><div><strong>Your privacy matters</strong><p>Do not include passwords, identity numbers or unnecessary sensitive details.</p></div></div>
            </aside>

            <div class="pl-form-column">
                <div class="pl-form-topline"><div><span class="pl-section-kicker">SUPPORT REQUEST FORM</span><h2>Request community support</h2><p>Fields marked with <b>*</b> are required.</p></div><span class="pl-form-secure">✓ Private by design</span></div>

                <form action="submit-support-request.php" method="POST" enctype="multipart/form-data" id="supportRequestForm" class="pl-premium-form">
                    <!-- Section 1 -->
                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-step">01</span><div><h3>What kind of support do you need?</h3><p>Choose the category that best matches your situation.</p></div></div>
                        <div class="pl-field"><label for="support_type">Support category <b>*</b></label><select name="support_type" id="support_type" required><option value="">Select a support category</option><option>Education Support</option><option>Medical / Emergency Help</option><option>Blood Requirement</option><option>Financial Assistance</option><option>Student Support</option><option>Women Support</option><option>Senior Citizen Support</option><option>Employment Guidance</option><option>General Assistance</option><option>Other Support</option></select></div>
                    </section>

                    <!-- Section 2 -->
                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-step">02</span><div><h3>Tell us about your request</h3><p>Clear information helps members understand how they can help.</p></div></div>
                        <div class="pl-field"><label for="request_title">Request title <b>*</b></label><input type="text" name="request_title" id="request_title" maxlength="200" placeholder="A short, clear title" required></div>
                        <div class="pl-field"><label for="short_description">Short description <b>*</b></label><textarea name="short_description" id="short_description" rows="3" maxlength="500" placeholder="Summarise what support you need in a few sentences" required></textarea><div class="pl-field-foot"><small>Keep it clear and avoid unnecessary personal details.</small><small><span id="shortDescriptionCount">0</span>/500</small></div></div>
                        <div class="pl-field"><label for="detailed_requirement">Detailed requirement <b>*</b></label><textarea name="detailed_requirement" id="detailed_requirement" rows="5" placeholder="Explain the need, relevant context and what kind of help would make a difference" required></textarea></div>
                        <div class="pl-form-grid-two">
                            <div class="pl-field"><label for="amount_required">Amount required <span>(if applicable)</span></label><div class="pl-input-prefix"><span>₹</span><input type="number" name="amount_required" id="amount_required" min="0" step="0.01" placeholder="0.00"></div></div>
                            <div class="pl-field"><label for="people_affected">People affected <span>(if applicable)</span></label><input type="number" name="people_affected" id="people_affected" min="1" placeholder="Number of people"></div>
                        </div>
                        <div class="pl-field"><label>Urgency level <b>*</b></label><div class="pl-urgency-options"><label class="pl-urgency-option"><input type="radio" name="urgency_level" value="Normal" checked><span class="pl-urgency-choice"><i class="pl-urgency-dot pl-dot-normal"></i><strong>Normal</strong><small>General request</small></span></label><label class="pl-urgency-option"><input type="radio" name="urgency_level" value="Important"><span class="pl-urgency-choice"><i class="pl-urgency-dot pl-dot-important"></i><strong>Important</strong><small>Needs attention</small></span></label><label class="pl-urgency-option"><input type="radio" name="urgency_level" value="Urgent"><span class="pl-urgency-choice"><i class="pl-urgency-dot pl-dot-urgent"></i><strong>Urgent</strong><small>Time-sensitive</small></span></label></div></div>
                    </section>

                    <!-- Section 3 -->
                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-step">03</span><div><h3>Where is support needed?</h3><p>Share a general location so relevant members can find your request.</p></div></div>
                        <div class="pl-form-grid-two"><div class="pl-field"><label for="city">City <b>*</b></label><input type="text" name="city" id="city" placeholder="Your city" required></div><div class="pl-field"><label for="locality">Area / locality</label><input type="text" name="locality" id="locality" placeholder="Area or neighbourhood"></div></div>
                        <div class="pl-field"><label for="address">Address <span>(only if required)</span></label><textarea name="address" id="address" rows="2" placeholder="Avoid entering a private home address unless necessary"></textarea></div>
                    </section>

                    <!-- Section 4 -->
                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-step">04</span><div><h3>Supporting documents</h3><p>Optional: upload relevant proof to help reviewers assess the request.</p></div></div>
                        <label for="support_documents" class="pl-upload-zone"><span class="pl-upload-icon">↑</span><strong>Choose files to upload</strong><span>Images or PDF · Multiple files allowed</span><small>Only upload documents you are comfortable sharing with authorised reviewers.</small><input type="file" name="support_documents[]" id="support_documents" accept=".jpg,.jpeg,.png,.webp,.pdf" multiple></label>
                        <div id="selectedSupportFiles" class="pl-selected-files" aria-live="polite">No files selected</div>
                    </section>

                    <!-- Section 5 -->
                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-step">05</span><div><h3>Your contact details</h3><p>Use your account details where possible. The server should verify member identity.</p></div></div>
                        <div class="pl-field"><label for="full_name">Full name <b>*</b></label><input type="text" name="full_name" id="full_name" maxlength="150" placeholder="Your full name" autocomplete="name" required></div>
                        <div class="pl-form-grid-two"><div class="pl-field"><label for="mobile">Mobile number <b>*</b></label><input type="tel" name="mobile" id="mobile" maxlength="20" placeholder="Mobile number" autocomplete="tel" required></div><div class="pl-field"><label for="email">Email address</label><input type="email" name="email" id="email" maxlength="190" placeholder="you@example.com" autocomplete="email"></div></div>
                        <div class="pl-field"><label for="community_name">Community <b>*</b></label><input type="text" name="community_name" id="community_name" placeholder="Selected from your PeopleLink account" required><small class="pl-help-text">For production, populate and validate the community from the signed-in account on the server.</small></div>
                    </section>

                    <!-- Section 6 -->
                    <section class="pl-form-section">
                        <div class="pl-form-section-heading"><span class="pl-form-step">06</span><div><h3>Privacy &amp; permissions</h3><p>Choose how your name and contact options should be handled.</p></div></div>
                        <div class="pl-privacy-choice"><div><strong>Show my name</strong><small>Display your name with the request.</small></div><label class="pl-switch"><input type="checkbox" name="show_name" value="1" checked><span></span></label></div>
                        <div class="pl-privacy-choice"><div><strong>Hide my contact details</strong><small>Keep your phone and email hidden from members.</small></div><label class="pl-switch"><input type="checkbox" name="hide_contact_details" id="hide_contact_details" value="1" checked><span></span></label></div>
                        <div class="pl-privacy-choice"><div><strong>Allow members to contact me through PeopleLink</strong><small>Members can respond through an approved contact method.</small></div><label class="pl-switch"><input type="checkbox" name="allow_member_contact" value="1" checked><span></span></label></div>
                        <div class="pl-privacy-choice"><div><strong>Allow an administrator to contact me</strong><small>Let the PeopleLink team follow up about this request.</small></div><label class="pl-switch"><input type="checkbox" name="allow_admin_contact" value="1" checked><span></span></label></div>
                        <label class="pl-consent"><input type="checkbox" name="agree_guidelines" value="1" required><span>I confirm that the information is accurate and agree to the community support guidelines. <b>*</b></span></label>
                    </section>

                    <!-- Preview & submit -->
                    <section class="pl-form-submit-section">
                        <div class="pl-submit-reminder"><span>✓</span><div><strong>One final check</strong><p>Review your request before submitting. Your request may need administrator approval before becoming visible.</p></div></div>
                        <div class="pl-submit-actions"><button type="button" id="previewSupportRequest" class="pl-btn pl-btn-soft">Preview request</button><button type="submit" name="action" value="draft" class="pl-btn pl-btn-outline-blue">Save draft</button><button type="submit" name="action" value="submit" class="pl-btn pl-btn-blue">Submit request <span>↗</span></button></div>
                    </section>
                </form>
            </div>
        </div>
    </section>

    <!-- Preview modal -->
    <div class="pl-preview-modal" id="supportPreviewModal" aria-hidden="true">
        <div class="pl-preview-backdrop" data-close-preview></div>
        <div class="pl-preview-dialog" role="dialog" aria-modal="true" aria-labelledby="previewModalTitle">
            <button type="button" class="pl-preview-close" id="closeSupportPreview" aria-label="Close preview">×</button>
            <span class="pl-section-kicker">BEFORE YOU SUBMIT</span><h2 id="previewModalTitle">Review your request</h2>
            <p class="pl-preview-intro">This is a local preview of the information you entered. It has not been submitted.</p>
            <div id="supportRequestPreviewContent" class="pl-preview-content"></div>
            <div class="pl-preview-modal-actions"><button type="button" class="pl-btn pl-btn-soft" data-close-preview>Continue editing</button><button type="button" class="pl-btn pl-btn-blue" id="previewSubmitRequest">Looks good — continue</button></div>
        </div>
    </div>
</main>

 
<?php include 'footer.php'; ?>
