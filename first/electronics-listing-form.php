<?php include 'header.php'; ?>



<div class="pl-electronics-page">

    <!-- HERO -->
    <section class="pl-electronics-hero">
        <div class="pl-electronics-hero-content">
            <div class="pl-electronics-hero-icon">
                <i class="bi bi-cpu-fill"></i>
            </div>

            <div>
                <span class="pl-electronics-eyebrow">PEOPLELINK MARKETPLACE</span>
                <h1>Post Your Electronic Item</h1>
                <p>
                    Create a detailed electronics listing and connect with
                    buyers across your community and the wider PeopleLink network.
                </p>
            </div>
        </div>

        <div class="pl-electronics-hero-image">
            <img src="https://images.unsplash.com/photo-1468495244123-6c6c332eeece?auto=format&fit=crop&w=1100&q=85"
                 alt="Electronics">
        </div>
    </section>


    <!-- FORM -->
    <section class="pl-electronics-form-section">

        <form id="electronicsListingForm"
              class="pl-electronics-form"
              enctype="multipart/form-data">

            <!-- BASIC PRODUCT INFORMATION -->
            <div class="pl-electronics-block">

                <div class="pl-electronics-block-title">
                    <div class="pl-electronics-block-icon">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>

                    <div>
                        <h2>Product Information</h2>
                        <p>Enter the basic details of your electronic item.</p>
                    </div>
                </div>

                <div class="pl-electronics-grid">

                    <div class="pl-electronics-field">
                        <label>Product Name <span>*</span></label>
                        <input type="text"
                               name="product_name"
                               placeholder="e.g. iPhone 15 Pro"
                               required>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Category <span>*</span></label>
                        <select name="category" required>
                            <option value="">Select Category</option>
                            <option>Mobile Phones</option>
                            <option>Laptops</option>
                            <option>Tablets</option>
                            <option>Televisions</option>
                            <option>Cameras</option>
                            <option>Home Appliances</option>
                            <option>Computer Accessories</option>
                            <option>Audio Devices</option>
                            <option>Gaming Devices</option>
                            <option>Smart Devices</option>
                            <option>Other Electronics</option>
                        </select>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Brand <span>*</span></label>
                        <input type="text"
                               name="brand"
                               placeholder="e.g. Apple"
                               required>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Model</label>
                        <input type="text"
                               name="model"
                               placeholder="e.g. A3108">
                    </div>

                    <div class="pl-electronics-field">
                        <label>Purchase Year</label>
                        <select name="purchase_year">
                            <option value="">Select Year</option>
                            <?php
                            for ($year = date('Y'); $year >= 1990; $year--) {
                                echo '<option value="' . $year . '">' . $year . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Warranty Status</label>
                        <select name="warranty">
                            <option value="">Select Status</option>
                            <option>Active Warranty</option>
                            <option>Extended Warranty</option>
                            <option>Warranty Expired</option>
                            <option>No Warranty</option>
                            <option>Not Known</option>
                        </select>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Accessories Included</label>
                        <input type="text"
                               name="accessories"
                               placeholder="Charger, box, cable, remote...">
                    </div>

                    <div class="pl-electronics-field">
                        <label>Usage Details</label>
                        <input type="text"
                               name="usage_details"
                               placeholder="e.g. Light home use">
                    </div>

                </div>
            </div>


            <!-- CONDITION -->
            <div class="pl-electronics-block">

                <div class="pl-electronics-block-title">
                    <div class="pl-electronics-block-icon">
                        <i class="bi bi-stars"></i>
                    </div>

                    <div>
                        <h2>Product Condition</h2>
                        <p>Select the current condition of the electronic item.</p>
                    </div>
                </div>

                <div class="pl-electronics-condition-grid">

                    <label class="pl-electronics-condition-option">
                        <input type="radio"
                               name="condition"
                               value="New"
                               required>

                        <div class="pl-electronics-condition-icon">
                            <i class="bi bi-box2-heart"></i>
                        </div>

                        <strong>New</strong>
                        <span>Unused product</span>
                    </label>


                    <label class="pl-electronics-condition-option">
                        <input type="radio"
                               name="condition"
                               value="Like New">

                        <div class="pl-electronics-condition-icon">
                            <i class="bi bi-hand-thumbs-up-fill"></i>
                        </div>

                        <strong>Like New</strong>
                        <span>Almost unused</span>
                    </label>


                    <label class="pl-electronics-condition-option">
                        <input type="radio"
                               name="condition"
                               value="Excellent">

                        <div class="pl-electronics-condition-icon">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>

                        <strong>Excellent</strong>
                        <span>Very well maintained</span>
                    </label>


                    <label class="pl-electronics-condition-option">
                        <input type="radio"
                               name="condition"
                               value="Good">

                        <div class="pl-electronics-condition-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <strong>Good</strong>
                        <span>Normal working condition</span>
                    </label>


                    <label class="pl-electronics-condition-option">
                        <input type="radio"
                               name="condition"
                               value="Used">

                        <div class="pl-electronics-condition-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <strong>Used</strong>
                        <span>Previously used</span>
                    </label>


                    <label class="pl-electronics-condition-option">
                        <input type="radio"
                               name="condition"
                               value="Refurbished">

                        <div class="pl-electronics-condition-icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>

                        <strong>Refurbished</strong>
                        <span>Restored product</span>
                    </label>

                </div>

                <div class="pl-electronics-grid pl-electronics-condition-notes">

                    <div class="pl-electronics-field pl-electronics-field-full">
                        <label>Condition Notes</label>

                        <textarea name="condition_notes"
                                  placeholder="Mention scratches, repairs, dents, screen condition, battery condition or any other known issue..."></textarea>
                    </div>

                </div>

            </div>


            <!-- PRICE & LOCATION -->
            <div class="pl-electronics-block">

                <div class="pl-electronics-block-title">
                    <div class="pl-electronics-block-icon">
                        <i class="bi bi-currency-rupee"></i>
                    </div>

                    <div>
                        <h2>Price & Location</h2>
                        <p>Set your expected price and listing location.</p>
                    </div>
                </div>

                <div class="pl-electronics-grid">

                    <div class="pl-electronics-field">
                        <label>Expected Price <span>*</span></label>

                        <div class="pl-electronics-input-prefix">
                            <span>₹</span>
                            <input type="number"
                                   name="price"
                                   id="electronicsPrice"
                                   placeholder="Enter price"
                                   required>
                        </div>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Price Type</label>
                        <select name="price_type">
                            <option>Negotiable</option>
                            <option>Fixed</option>
                        </select>
                    </div>

                    <div class="pl-electronics-field">
                        <label>State <span>*</span></label>
                        <input type="text"
                               name="state"
                               placeholder="State"
                               required>
                    </div>

                    <div class="pl-electronics-field">
                        <label>District</label>
                        <input type="text"
                               name="district"
                               placeholder="District">
                    </div>

                    <div class="pl-electronics-field">
                        <label>City <span>*</span></label>
                        <input type="text"
                               name="city"
                               placeholder="City"
                               required>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Area</label>
                        <input type="text"
                               name="area"
                               placeholder="Area / Locality">
                    </div>

                    <div class="pl-electronics-field pl-electronics-field-full">
                        <label>Landmark</label>
                        <input type="text"
                               name="landmark"
                               placeholder="Nearby landmark">
                    </div>

                </div>

            </div>


            <!-- PRODUCT DETAILS -->
            <div class="pl-electronics-block">

                <div class="pl-electronics-block-title">
                    <div class="pl-electronics-block-icon">
                        <i class="bi bi-card-checklist"></i>
                    </div>

                    <div>
                        <h2>Additional Product Details</h2>
                        <p>Add important information buyers should know.</p>
                    </div>
                </div>

                <div class="pl-electronics-grid">

                    <div class="pl-electronics-field">
                        <label>Serial / IMEI Availability</label>
                        <select name="serial_status">
                            <option value="">Select</option>
                            <option>Available</option>
                            <option>Not Available</option>
                            <option>Not Applicable</option>
                        </select>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Original Invoice</label>
                        <select name="invoice">
                            <option value="">Select</option>
                            <option>Available</option>
                            <option>Not Available</option>
                        </select>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Warranty Proof</label>
                        <select name="warranty_proof">
                            <option value="">Select</option>
                            <option>Available</option>
                            <option>Not Available</option>
                            <option>Not Applicable</option>
                        </select>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Product Status</label>
                        <select name="product_status">
                            <option>Fully Working</option>
                            <option>Partially Working</option>
                            <option>Needs Repair</option>
                            <option>For Parts</option>
                        </select>
                    </div>

                    <div class="pl-electronics-field pl-electronics-field-full">
                        <label>Other Important Information</label>

                        <textarea name="other_information"
                                  placeholder="Mention specifications, upgrades, repairs, accessories, defects or anything else relevant to the buyer..."></textarea>
                    </div>

                </div>

            </div>


            <!-- IMAGES -->
            <div class="pl-electronics-block">

                <div class="pl-electronics-block-title">
                    <div class="pl-electronics-block-icon">
                        <i class="bi bi-images"></i>
                    </div>

                    <div>
                        <h2>Product Images</h2>
                        <p>Add clear images of the electronic item.</p>
                    </div>
                </div>

                <div class="pl-electronics-upload-info">
                    <span><i class="bi bi-check-circle-fill"></i> Front</span>
                    <span><i class="bi bi-check-circle-fill"></i> Back</span>
                    <span><i class="bi bi-check-circle-fill"></i> Side</span>
                    <span><i class="bi bi-check-circle-fill"></i> Screen</span>
                    <span><i class="bi bi-check-circle-fill"></i> Accessories</span>
                    <span><i class="bi bi-check-circle-fill"></i> Packaging</span>
                    <span><i class="bi bi-check-circle-fill"></i> Invoice / Warranty</span>
                </div>

                <label class="pl-electronics-upload"
                       id="electronicsDropZone">

                    <input type="file"
                           id="electronicsImages"
                           name="electronics_images[]"
                           accept="image/*"
                           multiple>

                    <div class="pl-electronics-upload-icon">
                        <i class="bi bi-cloud-arrow-up-fill"></i>
                    </div>

                    <strong>Upload Product Images</strong>

                    <span>
                        Drag & drop images here or click to browse
                    </span>

                    <small>
                        JPG, JPEG, PNG · Multiple images allowed
                    </small>

                </label>

                <div id="electronicsImagePreview"
                     class="pl-electronics-image-preview"></div>

            </div>


            <!-- SELLER -->
            <div class="pl-electronics-block">

                <div class="pl-electronics-block-title">
                    <div class="pl-electronics-block-icon">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>

                    <div>
                        <h2>Seller Information</h2>
                        <p>Provide approved contact information for buyers.</p>
                    </div>
                </div>

                <div class="pl-electronics-grid">

                    <div class="pl-electronics-field">
                        <label>Seller Name <span>*</span></label>
                        <input type="text"
                               name="seller_name"
                               placeholder="Your name"
                               required>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Seller Type</label>
                        <select name="seller_type">
                            <option>Individual</option>
                            <option>Business</option>
                        </select>
                    </div>

                    <div class="pl-electronics-field">
                        <label>Mobile Number <span>*</span></label>
                        <input type="tel"
                               name="mobile"
                               placeholder="+91 XXXXX XXXXX"
                               required>
                    </div>

                    <div class="pl-electronics-field">
                        <label>WhatsApp Number</label>
                        <input type="tel"
                               name="whatsapp"
                               placeholder="+91 XXXXX XXXXX">
                    </div>

                    <div class="pl-electronics-field">
                        <label>Email Address</label>
                        <input type="email"
                               name="email"
                               placeholder="you@example.com">
                    </div>

                    <div class="pl-electronics-field">
                        <label>Community</label>
                        <input type="text"
                               name="community"
                               placeholder="Your community">
                    </div>

                </div>

                <div class="pl-electronics-privacy-note">
                    <i class="bi bi-shield-check"></i>
                    <span>
                        Personal contact details should be displayed according
                        to your PeopleLink privacy settings.
                    </span>
                </div>

            </div>


            <!-- DESCRIPTION -->
            <div class="pl-electronics-block">

                <div class="pl-electronics-block-title">
                    <div class="pl-electronics-block-icon">
                        <i class="bi bi-card-text"></i>
                    </div>

                    <div>
                        <h2>Product Description</h2>
                        <p>Give buyers a clear overview of your item.</p>
                    </div>
                </div>

                <div class="pl-electronics-field">

                    <textarea id="electronicsDescription"
                              name="description"
                              maxlength="1500"
                              placeholder="Describe the product, usage, condition, specifications, accessories, reason for selling and other useful information..."
                              required></textarea>

                    <div class="pl-electronics-counter">
                        <span id="electronicsDescriptionCount">0</span>
                        / 1500 characters
                    </div>

                </div>

            </div>


            <!-- VISIBILITY -->
            <div class="pl-electronics-block">

                <div class="pl-electronics-block-title">
                    <div class="pl-electronics-block-icon">
                        <i class="bi bi-globe2"></i>
                    </div>

                    <div>
                        <h2>Listing Visibility</h2>
                        <p>Choose who can discover your electronic item.</p>
                    </div>
                </div>

                <div class="pl-electronics-visibility">

                    <label class="pl-electronics-visibility-option active">

                        <input type="radio"
                               name="visibility"
                               value="community"
                               checked>

                        <div class="pl-electronics-visibility-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div>
                            <strong>Community-Specific</strong>
                            <span>
                                Show the listing within your selected community.
                            </span>
                        </div>

                    </label>


                    <label class="pl-electronics-visibility-option">

                        <input type="radio"
                               name="visibility"
                               value="global">

                        <div class="pl-electronics-visibility-icon">
                            <i class="bi bi-globe-americas"></i>
                        </div>

                        <div>
                            <strong>Global</strong>
                            <span>
                                Make the listing visible across eligible
                                PeopleLink users.
                            </span>
                        </div>

                    </label>

                </div>

            </div>


            <!-- CONFIRMATION -->
            <div class="pl-electronics-submit-box">

                <label class="pl-electronics-agreement">

                    <input type="checkbox"
                           id="electronicsAgreement"
                           required>

                    <span>
                        I confirm that the information provided is accurate
                        and I agree to PeopleLink's marketplace and community
                        guidelines.
                    </span>

                </label>


                <div class="pl-electronics-submit-actions">

                    <button type="button"
                            class="pl-electronics-btn secondary"
                            id="saveElectronicsDraft">

                        <i class="bi bi-save2"></i>
                        Save Draft

                    </button>


                    <button type="button"
                            class="pl-electronics-btn outline"
                            id="previewElectronics">

                        <i class="bi bi-eye"></i>
                        Preview

                    </button>


                    <button type="submit"
                            class="pl-electronics-btn primary">

                        <i class="bi bi-send-fill"></i>
                        Submit Item

                    </button>

                </div>


                <div class="pl-electronics-approval">

                    <span>
                        <i class="bi bi-hourglass-split"></i>
                        Pending Approval
                    </span>

                    <small>
                        Your listing may be reviewed before becoming visible.
                    </small>

                </div>

            </div>

        </form>

    </section>

</div>


<!-- PREVIEW MODAL -->
<div class="pl-electronics-modal"
     id="electronicsPreviewModal">

    <div class="pl-electronics-modal-box">

        <button type="button"
                class="pl-electronics-modal-close"
                id="closeElectronicsPreview">

            <i class="bi bi-x-lg"></i>

        </button>


        <div class="pl-electronics-modal-head">

            <div class="pl-electronics-modal-icon">
                <i class="bi bi-cpu-fill"></i>
            </div>

            <div>
                <span>LISTING PREVIEW</span>
                <h3 id="previewElectronicsTitle">
                    Electronic Item
                </h3>
            </div>

        </div>


        <div class="pl-electronics-preview-image"
             id="previewElectronicsImage">

            <i class="bi bi-image"></i>

        </div>


        <div class="pl-electronics-preview-grid">

            <div>
                <small>Product</small>
                <strong id="previewProductName">—</strong>
            </div>

            <div>
                <small>Brand / Model</small>
                <strong id="previewBrandModel">—</strong>
            </div>

            <div>
                <small>Condition</small>
                <strong id="previewCondition">—</strong>
            </div>

            <div>
                <small>Price</small>
                <strong id="previewPrice">—</strong>
            </div>

            <div>
                <small>Category</small>
                <strong id="previewCategory">—</strong>
            </div>

            <div>
                <small>Location</small>
                <strong id="previewLocation">—</strong>
            </div>

        </div>


        <div class="pl-electronics-preview-description">

            <small>Description</small>

            <p id="previewDescription">—</p>

        </div>

    </div>

</div>


<!-- TOAST -->
<div class="pl-electronics-toast"
     id="electronicsToast">

    <i class="bi bi-check-circle-fill"></i>

    <span>
        Electronics listing saved successfully.
    </span>

</div>




<?php include 'footer.php'; ?>