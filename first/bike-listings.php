<?php include 'header.php'; ?>



<div class="pl-bike-page">

    <!-- HERO -->
    <section class="pl-bike-hero">
        <div class="pl-bike-hero-content">
            <div class="pl-bike-hero-icon">
                <i class="bi bi-bicycle"></i>
            </div>
            <div>
                <span class="pl-bike-eyebrow">PEOPLELINK MARKETPLACE</span>
                <h1>Post Your Bike</h1>
                <p>
                    Create a detailed bike listing and connect directly with
                    buyers across your community and the wider PeopleLink network.
                </p>
            </div>
        </div>

        <div class="pl-bike-hero-image">
            <img src="https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=1100&q=85"
                 alt="Bike">
        </div>
    </section>


    <!-- FORM -->
    <section class="pl-bike-form-section">

        <form id="bikeListingForm" class="pl-bike-form" enctype="multipart/form-data">

            <!-- BASIC INFORMATION -->
            <div class="pl-bike-block">
                <div class="pl-bike-block-title">
                    <div class="pl-bike-block-icon">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <div>
                        <h2>Basic Bike Information</h2>
                        <p>Enter the main details of your bike.</p>
                    </div>
                </div>

                <div class="pl-bike-grid">

                    <div class="pl-bike-field">
                        <label>Brand <span>*</span></label>
                        <select name="brand" required>
                            <option value="">Select Brand</option>
                            <option>Royal Enfield</option>
                            <option>Hero</option>
                            <option>Honda</option>
                            <option>Bajaj</option>
                            <option>TVS</option>
                            <option>Yamaha</option>
                            <option>Suzuki</option>
                            <option>KTM</option>
                            <option>Jawa</option>
                            <option>Mahindra</option>
                            <option>BMW</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>Model <span>*</span></label>
                        <input type="text" name="model" placeholder="e.g. Classic 350" required>
                    </div>

                    <div class="pl-bike-field">
                        <label>Variant</label>
                        <input type="text" name="variant" placeholder="e.g. Signals ABS">
                    </div>

                    <div class="pl-bike-field">
                        <label>Manufacturing Year <span>*</span></label>
                        <select name="manufacturing_year" required>
                            <option value="">Select Year</option>
                            <?php
                            for ($year = date('Y'); $year >= 1990; $year--) {
                                echo '<option value="' . $year . '">' . $year . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>Registration Year</label>
                        <select name="registration_year">
                            <option value="">Select Year</option>
                            <?php
                            for ($year = date('Y'); $year >= 1990; $year--) {
                                echo '<option value="' . $year . '">' . $year . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>Registration State</label>
                        <input type="text" name="registration_state" placeholder="e.g. Uttar Pradesh">
                    </div>

                    <div class="pl-bike-field">
                        <label>Colour</label>
                        <input type="text" name="colour" placeholder="e.g. Black">
                    </div>

                    <div class="pl-bike-field">
                        <label>Engine CC</label>
                        <input type="number" name="engine_cc" placeholder="e.g. 350">
                    </div>

                </div>
            </div>


            <!-- SPECIFICATIONS -->
            <div class="pl-bike-block">
                <div class="pl-bike-block-title">
                    <div class="pl-bike-block-icon">
                        <i class="bi bi-speedometer2"></i>
                    </div>
                    <div>
                        <h2>Bike Specifications</h2>
                        <p>Provide important technical information.</p>
                    </div>
                </div>

                <div class="pl-bike-grid">

                    <div class="pl-bike-field">
                        <label>Fuel Type <span>*</span></label>
                        <select name="fuel_type" required>
                            <option value="">Select Fuel Type</option>
                            <option>Petrol</option>
                            <option>Electric</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>Kilometres Driven <span>*</span></label>
                        <input type="number" name="kilometres" placeholder="e.g. 28000" required>
                    </div>

                    <div class="pl-bike-field">
                        <label>Number of Owners</label>
                        <select name="owners">
                            <option value="">Select</option>
                            <option>1st Owner</option>
                            <option>2nd Owner</option>
                            <option>3rd Owner</option>
                            <option>4+ Owners</option>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>Overall Condition <span>*</span></label>
                        <select name="condition" required>
                            <option value="">Select Condition</option>
                            <option>Excellent</option>
                            <option>Very Good</option>
                            <option>Good</option>
                            <option>Fair</option>
                            <option>Needs Repair</option>
                        </select>
                    </div>

                </div>
            </div>


            <!-- PRICE & LOCATION -->
            <div class="pl-bike-block">
                <div class="pl-bike-block-title">
                    <div class="pl-bike-block-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <h2>Price & Location</h2>
                        <p>Help buyers understand your expected price and location.</p>
                    </div>
                </div>

                <div class="pl-bike-grid">

                    <div class="pl-bike-field">
                        <label>Expected Price <span>*</span></label>
                        <div class="pl-bike-input-prefix">
                            <span>₹</span>
                            <input type="number" name="price" id="bikePrice"
                                   placeholder="Enter expected price" required>
                        </div>
                    </div>

                    <div class="pl-bike-field">
                        <label>Price Type</label>
                        <select name="price_type">
                            <option>Negotiable</option>
                            <option>Fixed</option>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>State <span>*</span></label>
                        <input type="text" name="state" placeholder="State" required>
                    </div>

                    <div class="pl-bike-field">
                        <label>District</label>
                        <input type="text" name="district" placeholder="District">
                    </div>

                    <div class="pl-bike-field">
                        <label>City <span>*</span></label>
                        <input type="text" name="city" placeholder="City" required>
                    </div>

                    <div class="pl-bike-field">
                        <label>Area</label>
                        <input type="text" name="area" placeholder="Area / Locality">
                    </div>

                    <div class="pl-bike-field pl-bike-field-full">
                        <label>Landmark</label>
                        <input type="text" name="landmark" placeholder="Nearby landmark">
                    </div>

                </div>
            </div>


            <!-- CONDITION & HISTORY -->
            <div class="pl-bike-block">
                <div class="pl-bike-block-title">
                    <div class="pl-bike-block-icon">
                        <i class="bi bi-tools"></i>
                    </div>
                    <div>
                        <h2>Bike Condition & History</h2>
                        <p>Add useful information about the bike's history.</p>
                    </div>
                </div>

                <div class="pl-bike-grid">

                    <div class="pl-bike-field">
                        <label>Service History</label>
                        <select name="service_history">
                            <option value="">Select</option>
                            <option>Full Service History</option>
                            <option>Partial Service History</option>
                            <option>No Service Records</option>
                            <option>Not Available</option>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>Insurance Status</label>
                        <select name="insurance">
                            <option value="">Select</option>
                            <option>Valid</option>
                            <option>Expired</option>
                            <option>Not Available</option>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>Accident History</label>
                        <select name="accident_history">
                            <option value="">Select</option>
                            <option>No Accident Declared</option>
                            <option>Minor Accident</option>
                            <option>Major Accident</option>
                            <option>Not Known</option>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>Tyre Condition</label>
                        <select name="tyre_condition">
                            <option value="">Select</option>
                            <option>Excellent</option>
                            <option>Good</option>
                            <option>Average</option>
                            <option>Needs Replacement</option>
                        </select>
                    </div>

                    <div class="pl-bike-field pl-bike-field-full">
                        <label>Other Important Information</label>
                        <textarea name="history_notes"
                                  placeholder="Mention any important details, repairs, modifications or accessories..."></textarea>
                    </div>

                </div>
            </div>


            <!-- IMAGES -->
            <div class="pl-bike-block">
                <div class="pl-bike-block-title">
                    <div class="pl-bike-block-icon">
                        <i class="bi bi-images"></i>
                    </div>
                    <div>
                        <h2>Bike Images</h2>
                        <p>Add clear images from different angles.</p>
                    </div>
                </div>

                <div class="pl-bike-upload-info">
                    <span><i class="bi bi-check-circle-fill"></i> Front</span>
                    <span><i class="bi bi-check-circle-fill"></i> Rear</span>
                    <span><i class="bi bi-check-circle-fill"></i> Side</span>
                    <span><i class="bi bi-check-circle-fill"></i> Dashboard</span>
                    <span><i class="bi bi-check-circle-fill"></i> Tyres</span>
                    <span><i class="bi bi-check-circle-fill"></i> Engine</span>
                </div>

                <label class="pl-bike-upload" id="bikeDropZone">
                    <input type="file"
                           id="bikeImages"
                           name="bike_images[]"
                           accept="image/*"
                           multiple>

                    <div class="pl-bike-upload-icon">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>

                    <strong>Upload Bike Images</strong>
                    <span>Drag & drop images here or click to browse</span>
                    <small>JPG, JPEG, PNG · Multiple images allowed</small>
                </label>

                <div id="bikeImagePreview" class="pl-bike-image-preview"></div>
            </div>


            <!-- SELLER INFORMATION -->
            <div class="pl-bike-block">
                <div class="pl-bike-block-title">
                    <div class="pl-bike-block-icon">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>
                    <div>
                        <h2>Seller Information</h2>
                        <p>Provide contact details for interested buyers.</p>
                    </div>
                </div>

                <div class="pl-bike-grid">

                    <div class="pl-bike-field">
                        <label>Seller Name <span>*</span></label>
                        <input type="text" name="seller_name" placeholder="Your name" required>
                    </div>

                    <div class="pl-bike-field">
                        <label>Seller Type</label>
                        <select name="seller_type">
                            <option>Owner</option>
                            <option>Dealer</option>
                            <option>Business</option>
                        </select>
                    </div>

                    <div class="pl-bike-field">
                        <label>Mobile Number <span>*</span></label>
                        <input type="tel" name="mobile" placeholder="+91 XXXXX XXXXX" required>
                    </div>

                    <div class="pl-bike-field">
                        <label>WhatsApp Number</label>
                        <input type="tel" name="whatsapp" placeholder="+91 XXXXX XXXXX">
                    </div>

                    <div class="pl-bike-field">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="you@example.com">
                    </div>

                    <div class="pl-bike-field">
                        <label>Community</label>
                        <input type="text" name="community" placeholder="Your community">
                    </div>

                </div>
            </div>


            <!-- DESCRIPTION -->
            <div class="pl-bike-block">
                <div class="pl-bike-block-title">
                    <div class="pl-bike-block-icon">
                        <i class="bi bi-card-text"></i>
                    </div>
                    <div>
                        <h2>Bike Description</h2>
                        <p>Give buyers a clear description of the bike.</p>
                    </div>
                </div>

                <div class="pl-bike-field">
                    <textarea
                        id="bikeDescription"
                        name="description"
                        maxlength="1200"
                        placeholder="Describe the bike, ownership, usage, condition, accessories, reason for selling and other useful information..."
                        required></textarea>

                    <div class="pl-bike-counter">
                        <span id="bikeDescriptionCount">0</span> / 1200 characters
                    </div>
                </div>
            </div>


            <!-- VISIBILITY -->
            <div class="pl-bike-block">
                <div class="pl-bike-block-title">
                    <div class="pl-bike-block-icon">
                        <i class="bi bi-globe2"></i>
                    </div>
                    <div>
                        <h2>Listing Visibility</h2>
                        <p>Choose who can discover your bike listing.</p>
                    </div>
                </div>

                <div class="pl-bike-visibility">

                    <label class="pl-bike-visibility-option active">
                        <input type="radio"
                               name="visibility"
                               value="community"
                               checked>

                        <div class="pl-bike-visibility-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div>
                            <strong>Community-Specific</strong>
                            <span>Show the listing within your selected community.</span>
                        </div>
                    </label>

                    <label class="pl-bike-visibility-option">
                        <input type="radio"
                               name="visibility"
                               value="global">

                        <div class="pl-bike-visibility-icon">
                            <i class="bi bi-globe-americas"></i>
                        </div>

                        <div>
                            <strong>Global</strong>
                            <span>Make the listing visible across PeopleLink.</span>
                        </div>
                    </label>

                </div>
            </div>


            <!-- CONFIRMATION -->
            <div class="pl-bike-submit-box">

                <label class="pl-bike-agreement">
                    <input type="checkbox" id="bikeAgreement" required>
                    <span>
                        I confirm that the information provided is accurate and
                        I agree to PeopleLink's listing and community guidelines.
                    </span>
                </label>

                <div class="pl-bike-submit-actions">
                    <button type="button" class="pl-bike-btn secondary" id="saveBikeDraft">
                        <i class="bi bi-save2"></i>
                        Save Draft
                    </button>

                    <button type="button" class="pl-bike-btn outline" id="previewBike">
                        <i class="bi bi-eye"></i>
                        Preview
                    </button>

                    <button type="submit" class="pl-bike-btn primary">
                        <i class="bi bi-send-fill"></i>
                        Submit Bike Listing
                    </button>
                </div>

                <div class="pl-bike-approval">
                    <span><i class="bi bi-hourglass-split"></i> Pending Approval</span>
                    <small>Your listing may be reviewed before becoming visible.</small>
                </div>

            </div>

        </form>

    </section>

</div>


<!-- PREVIEW MODAL -->
<div class="pl-bike-modal" id="bikePreviewModal">
    <div class="pl-bike-modal-box">

        <button type="button" class="pl-bike-modal-close" id="closeBikePreview">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-bike-modal-head">
            <div class="pl-bike-modal-icon">
                <i class="bi bi-bicycle"></i>
            </div>

            <div>
                <span>LISTING PREVIEW</span>
                <h3 id="previewBikeTitle">Bike Listing</h3>
            </div>
        </div>

        <div class="pl-bike-preview-image" id="previewBikeImage">
            <i class="bi bi-image"></i>
        </div>

        <div class="pl-bike-preview-grid">
            <div>
                <small>Brand & Model</small>
                <strong id="previewBrandModel">—</strong>
            </div>

            <div>
                <small>Price</small>
                <strong id="previewPrice">—</strong>
            </div>

            <div>
                <small>Year</small>
                <strong id="previewYear">—</strong>
            </div>

            <div>
                <small>Kilometres</small>
                <strong id="previewKm">—</strong>
            </div>

            <div>
                <small>Fuel</small>
                <strong id="previewFuel">—</strong>
            </div>

            <div>
                <small>Location</small>
                <strong id="previewLocation">—</strong>
            </div>
        </div>

        <div class="pl-bike-preview-description">
            <small>Description</small>
            <p id="previewDescription">—</p>
        </div>

    </div>
</div>


<!-- TOAST -->
<div class="pl-bike-toast" id="bikeToast">
    <i class="bi bi-check-circle-fill"></i>
    <span>Bike listing saved successfully.</span>
</div>


 

<?php include 'footer.php'; ?>