<?php include 'header.php'; ?>

<link rel="stylesheet" href="car-listing-form.css">

<div class="pl-car-form-page">

    <!-- HERO -->
    <section class="pl-car-form-hero">
        <div class="pl-car-form-container">
            <div class="pl-car-hero-content">
                <span class="pl-car-kicker">
                    <i class="bi bi-car-front-fill"></i>
                    PeopleLink Marketplace
                </span>

                <h1>Post Your Car</h1>

                <p>
                    Create a detailed car listing and connect with interested buyers
                    across the PeopleLink community.
                </p>

                <div class="pl-car-hero-points">
                    <span><i class="bi bi-check-circle-fill"></i> Easy Listing</span>
                    <span><i class="bi bi-check-circle-fill"></i> Community Visibility</span>
                    <span><i class="bi bi-check-circle-fill"></i> Admin Approved</span>
                </div>
            </div>

            <div class="pl-car-hero-image">
                <img
                    src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?auto=format&fit=crop&w=1000&q=85"
                    alt="Car">
            </div>
        </div>
    </section>


    <!-- FORM AREA -->
    <section class="pl-car-form-section">
        <div class="pl-car-form-container">

            <form id="carListingForm" class="pl-car-form" enctype="multipart/form-data">

                <!-- BASIC INFORMATION -->
                <div class="pl-car-form-block">
                    <div class="pl-car-block-heading">
                        <div class="pl-car-heading-icon">
                            <i class="bi bi-car-front-fill"></i>
                        </div>
                        <div>
                            <h2>Basic Car Information</h2>
                            <p>Enter the main details of your car.</p>
                        </div>
                    </div>

                    <div class="pl-car-grid">

                        <div class="pl-car-field">
                            <label>Brand <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-building"></i>
                                <input type="text" name="brand" placeholder="e.g. Toyota" required>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Model <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-car-front"></i>
                                <input type="text" name="model" placeholder="e.g. Fortuner" required>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Variant</label>
                            <div class="pl-car-input">
                                <i class="bi bi-diagram-3"></i>
                                <input type="text" name="variant" placeholder="e.g. 4x4 Diesel">
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Manufacturing Year <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-calendar3"></i>
                                <select name="manufacturing_year" required>
                                    <option value="">Select Year</option>
                                    <?php for ($year = date('Y'); $year >= 1990; $year--): ?>
                                        <option value="<?php echo $year; ?>">
                                            <?php echo $year; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Registration Year</label>
                            <div class="pl-car-input">
                                <i class="bi bi-calendar-check"></i>
                                <select name="registration_year">
                                    <option value="">Select Year</option>
                                    <?php for ($year = date('Y'); $year >= 1990; $year--): ?>
                                        <option value="<?php echo $year; ?>">
                                            <?php echo $year; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Registration State</label>
                            <div class="pl-car-input">
                                <i class="bi bi-card-text"></i>
                                <input type="text" name="registration_state" placeholder="e.g. Uttar Pradesh">
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Colour</label>
                            <div class="pl-car-input">
                                <i class="bi bi-palette"></i>
                                <input type="text" name="colour" placeholder="e.g. White">
                            </div>
                        </div>

                    </div>
                </div>


                <!-- SPECIFICATIONS -->
                <div class="pl-car-form-block">
                    <div class="pl-car-block-heading">
                        <div class="pl-car-heading-icon">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <div>
                            <h2>Car Specifications</h2>
                            <p>Provide important technical details.</p>
                        </div>
                    </div>

                    <div class="pl-car-grid">

                        <div class="pl-car-field">
                            <label>Fuel Type <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-fuel-pump"></i>
                                <select name="fuel_type" required>
                                    <option value="">Select Fuel</option>
                                    <option>Petrol</option>
                                    <option>Diesel</option>
                                    <option>CNG</option>
                                    <option>Electric</option>
                                    <option>Hybrid</option>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Transmission <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-gear"></i>
                                <select name="transmission" required>
                                    <option value="">Select Transmission</option>
                                    <option>Manual</option>
                                    <option>Automatic</option>
                                    <option>AMT</option>
                                    <option>CVT</option>
                                    <option>DCT</option>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Kilometres Driven <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-speedometer"></i>
                                <input type="number" name="kilometres" min="0" placeholder="e.g. 45000" required>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Number of Owners</label>
                            <div class="pl-car-input">
                                <i class="bi bi-people"></i>
                                <select name="owners">
                                    <option value="">Select</option>
                                    <option>1st Owner</option>
                                    <option>2nd Owner</option>
                                    <option>3rd Owner</option>
                                    <option>4+ Owners</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- PRICE & LOCATION -->
                <div class="pl-car-form-block">
                    <div class="pl-car-block-heading">
                        <div class="pl-car-heading-icon">
                            <i class="bi bi-currency-rupee"></i>
                        </div>
                        <div>
                            <h2>Price & Location</h2>
                            <p>Tell buyers where the car is located and your expected price.</p>
                        </div>
                    </div>

                    <div class="pl-car-grid">

                        <div class="pl-car-field">
                            <label>Expected Price <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-currency-rupee"></i>
                                <input type="number" id="carPrice" name="price" min="0" placeholder="e.g. 850000" required>
                            </div>
                            <small id="pricePreview"></small>
                        </div>

                        <div class="pl-car-field">
                            <label>Price Type <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-tags"></i>
                                <select name="price_type" required>
                                    <option value="">Select Price Type</option>
                                    <option>Negotiable</option>
                                    <option>Fixed Price</option>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>State <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-geo-alt"></i>
                                <input type="text" name="state" placeholder="State" required>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>District</label>
                            <div class="pl-car-input">
                                <i class="bi bi-map"></i>
                                <input type="text" name="district" placeholder="District">
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>City <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-buildings"></i>
                                <input type="text" name="city" placeholder="City" required>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Area / Locality</label>
                            <div class="pl-car-input">
                                <i class="bi bi-pin-map"></i>
                                <input type="text" name="area" placeholder="Area or locality">
                            </div>
                        </div>

                        <div class="pl-car-field pl-car-full">
                            <label>Landmark</label>
                            <div class="pl-car-input">
                                <i class="bi bi-signpost-2"></i>
                                <input type="text" name="landmark" placeholder="Nearby landmark">
                            </div>
                        </div>

                    </div>
                </div>


                <!-- CONDITION -->
                <div class="pl-car-form-block">
                    <div class="pl-car-block-heading">
                        <div class="pl-car-heading-icon">
                            <i class="bi bi-clipboard2-check"></i>
                        </div>
                        <div>
                            <h2>Car Condition & History</h2>
                            <p>Give buyers a clear understanding of the vehicle condition.</p>
                        </div>
                    </div>

                    <div class="pl-car-grid">

                        <div class="pl-car-field">
                            <label>Overall Condition</label>
                            <div class="pl-car-input">
                                <i class="bi bi-stars"></i>
                                <select name="condition">
                                    <option value="">Select Condition</option>
                                    <option>Excellent</option>
                                    <option>Very Good</option>
                                    <option>Good</option>
                                    <option>Fair</option>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Insurance Status</label>
                            <div class="pl-car-input">
                                <i class="bi bi-shield-check"></i>
                                <select name="insurance">
                                    <option value="">Select Status</option>
                                    <option>Valid</option>
                                    <option>Expired</option>
                                    <option>Not Available</option>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Service History</label>
                            <div class="pl-car-input">
                                <i class="bi bi-tools"></i>
                                <select name="service_history">
                                    <option value="">Select</option>
                                    <option>Full Service History</option>
                                    <option>Partial Service History</option>
                                    <option>No Service History</option>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Tyre Condition</label>
                            <div class="pl-car-input">
                                <i class="bi bi-circle"></i>
                                <select name="tyre_condition">
                                    <option value="">Select</option>
                                    <option>Excellent</option>
                                    <option>Good</option>
                                    <option>Average</option>
                                    <option>Needs Replacement</option>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Accident History</label>
                            <div class="pl-car-input">
                                <i class="bi bi-exclamation-triangle"></i>
                                <select name="accident_history">
                                    <option value="">Select</option>
                                    <option>No Accident Declared</option>
                                    <option>Minor Accident</option>
                                    <option>Major Accident</option>
                                    <option>Not Disclosed</option>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field pl-car-full">
                            <label>Other Relevant Information</label>
                            <textarea name="condition_notes" placeholder="Mention any important condition details, repairs, upgrades or other information..."></textarea>
                        </div>

                    </div>
                </div>


                <!-- IMAGES -->
                <div class="pl-car-form-block">
                    <div class="pl-car-block-heading">
                        <div class="pl-car-heading-icon">
                            <i class="bi bi-images"></i>
                        </div>
                        <div>
                            <h2>Car Images</h2>
                            <p>Add clear photos to help buyers understand the vehicle.</p>
                        </div>
                    </div>

                    <div class="pl-car-upload-area" id="uploadArea">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <h3>Upload Car Photos</h3>
                        <p>Drag & drop images here or click to browse</p>
                        <span>JPG, JPEG or PNG • Multiple images allowed</span>

                        <input
                            type="file"
                            id="carImages"
                            name="car_images[]"
                            accept="image/jpeg,image/png,image/webp"
                            multiple
                            hidden
                        >

                        <button type="button" class="pl-car-upload-btn" id="browseImages">
                            <i class="bi bi-plus-circle"></i>
                            Choose Images
                        </button>
                    </div>

                    <div id="imagePreview" class="pl-car-image-preview"></div>
                </div>


                <!-- SELLER -->
                <div class="pl-car-form-block">
                    <div class="pl-car-block-heading">
                        <div class="pl-car-heading-icon">
                            <i class="bi bi-person-vcard"></i>
                        </div>
                        <div>
                            <h2>Seller Information</h2>
                            <p>Provide contact details for interested buyers.</p>
                        </div>
                    </div>

                    <div class="pl-car-grid">

                        <div class="pl-car-field">
                            <label>Seller Name <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-person"></i>
                                <input type="text" name="seller_name" placeholder="Full name" required>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Seller Type <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-person-badge"></i>
                                <select name="seller_type" required>
                                    <option value="">Select Type</option>
                                    <option>Owner</option>
                                    <option>Dealer</option>
                                    <option>Business</option>
                                </select>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Mobile Number <span>*</span></label>
                            <div class="pl-car-input">
                                <i class="bi bi-phone"></i>
                                <input type="tel" name="mobile" placeholder="+91 98765 43210" required>
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>WhatsApp Number</label>
                            <div class="pl-car-input">
                                <i class="bi bi-whatsapp"></i>
                                <input type="tel" name="whatsapp" placeholder="WhatsApp number">
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Email Address</label>
                            <div class="pl-car-input">
                                <i class="bi bi-envelope"></i>
                                <input type="email" name="email" placeholder="you@example.com">
                            </div>
                        </div>

                        <div class="pl-car-field">
                            <label>Community</label>
                            <div class="pl-car-input">
                                <i class="bi bi-people"></i>
                                <select name="community">
                                    <option value="">Select Community</option>
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
                                    <option>Other Community</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>


                <!-- DESCRIPTION -->
                <div class="pl-car-form-block">
                    <div class="pl-car-block-heading">
                        <div class="pl-car-heading-icon">
                            <i class="bi bi-text-paragraph"></i>
                        </div>
                        <div>
                            <h2>Car Description</h2>
                            <p>Add additional information that buyers should know.</p>
                        </div>
                    </div>

                    <div class="pl-car-field">
                        <label>Description <span>*</span></label>
                        <textarea
                            name="description"
                            id="carDescription"
                            maxlength="1500"
                            placeholder="Describe the car, its condition, features, maintenance, reason for selling and other useful information..."
                            required
                        ></textarea>

                        <div class="pl-car-character-count">
                            <span id="descriptionCount">0</span> / 1500
                        </div>
                    </div>
                </div>


                <!-- VISIBILITY -->
                <div class="pl-car-form-block">
                    <div class="pl-car-block-heading">
                        <div class="pl-car-heading-icon">
                            <i class="bi bi-globe2"></i>
                        </div>
                        <div>
                            <h2>Listing Visibility</h2>
                            <p>Choose who can see your car listing.</p>
                        </div>
                    </div>

                    <div class="pl-car-visibility-grid">

                        <label class="pl-car-visibility-option active">
                            <input type="radio" name="visibility" value="community" checked>
                            <div class="pl-car-visibility-icon">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <strong>Community-Specific</strong>
                                <span>Show the listing within your selected community network.</span>
                            </div>
                            <i class="bi bi-check-circle-fill pl-car-option-check"></i>
                        </label>

                        <label class="pl-car-visibility-option">
                            <input type="radio" name="visibility" value="global">
                            <div class="pl-car-visibility-icon">
                                <i class="bi bi-globe"></i>
                            </div>
                            <div>
                                <strong>Global</strong>
                                <span>Make the listing visible across the PeopleLink network.</span>
                            </div>
                            <i class="bi bi-check-circle-fill pl-car-option-check"></i>
                        </label>

                    </div>
                </div>


                <!-- AGREEMENT -->
                <div class="pl-car-form-block pl-car-submit-block">

                    <label class="pl-car-checkbox">
                        <input type="checkbox" id="listingAgreement" required>
                        <span>
                            I confirm that the information provided is accurate and I agree
                            that the listing may be reviewed by PeopleLink before approval.
                        </span>
                    </label>

                    <div class="pl-car-submit-actions">

                        <button type="button" class="pl-car-secondary-btn" id="saveDraft">
                            <i class="bi bi-file-earmark"></i>
                            Save Draft
                        </button>

                        <button type="button" class="pl-car-preview-btn" id="previewListing">
                            <i class="bi bi-eye"></i>
                            Preview
                        </button>

                        <button type="submit" class="pl-car-submit-btn">
                            <i class="bi bi-send-fill"></i>
                            Submit Car Listing
                        </button>

                    </div>

                    <div class="pl-car-submit-note">
                        <i class="bi bi-shield-check"></i>
                        Your listing will be submitted for admin approval before becoming visible.
                    </div>

                </div>

            </form>

        </div>
    </section>


    <!-- PREVIEW MODAL -->
    <div class="pl-car-modal" id="previewModal">

        <div class="pl-car-modal-box">

            <button type="button" class="pl-car-modal-close" id="closePreview">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="pl-car-modal-head">
                <span>
                    <i class="bi bi-eye"></i>
                    Listing Preview
                </span>
                <small>PeopleLink Marketplace</small>
            </div>

            <div class="pl-car-preview-content">

                <div class="pl-car-preview-image" id="previewImage">
                    <i class="bi bi-car-front"></i>
                </div>

                <div class="pl-car-preview-main">

                    <span class="pl-car-preview-badge">
                        <i class="bi bi-clock"></i>
                        Pending Approval
                    </span>

                    <h3 id="previewTitle">Your Car</h3>

                    <div class="pl-car-preview-price" id="previewPrice">
                        ₹0
                    </div>

                    <div class="pl-car-preview-details">
                        <span><i class="bi bi-calendar3"></i> <b id="previewYear">-</b></span>
                        <span><i class="bi bi-speedometer2"></i> <b id="previewKm">-</b> km</span>
                        <span><i class="bi bi-fuel-pump"></i> <b id="previewFuel">-</b></span>
                        <span><i class="bi bi-gear"></i> <b id="previewTransmission">-</b></span>
                    </div>

                    <div class="pl-car-preview-location">
                        <i class="bi bi-geo-alt-fill"></i>
                        <span id="previewLocation">Location not provided</span>
                    </div>

                    <p id="previewDescription">
                        Your car description will appear here.
                    </p>

                </div>

            </div>

        </div>

    </div>


    <!-- TOAST -->
    <div class="pl-car-toast" id="carToast">
        <div class="pl-car-toast-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        <div>
            <strong id="toastTitle">Success</strong>
            <span id="toastMessage">Action completed successfully.</span>
        </div>
        <button type="button" id="closeToast">
            <i class="bi bi-x"></i>
        </button>
    </div>

</div>

<script src="car-listing-form.js"></script>

<?php include 'footer.php'; ?>