<?php include 'header.php'; ?>

 

<div class="pl-other-page">

    <!-- HERO -->
    <section class="pl-other-hero">

        <div class="pl-other-hero-content">

            <div class="pl-other-hero-icon">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>

            <div>
                <span class="pl-other-eyebrow">PEOPLELINK MARKETPLACE</span>

                <h1>Post Your Marketplace Item</h1>

                <p>
                    List furniture, machinery, tools, business products,
                    lifestyle items and other approved products within
                    the PeopleLink network.
                </p>
            </div>

        </div>

        <div class="pl-other-hero-image">
            <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=1100&q=85"
                 alt="Marketplace Products">
        </div>

    </section>


    <!-- FORM -->
    <section class="pl-other-form-section">

        <form id="otherMarketplaceForm"
              class="pl-other-form"
              enctype="multipart/form-data">


            <!-- PRODUCT INFORMATION -->
            <div class="pl-other-block">

                <div class="pl-other-block-title">

                    <div class="pl-other-block-icon">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>

                    <div>
                        <h2>Product Information</h2>
                        <p>Enter the basic details of your marketplace item.</p>
                    </div>

                </div>


                <div class="pl-other-grid">

                    <div class="pl-other-field">
                        <label>Product / Item Name <span>*</span></label>

                        <input type="text"
                               name="product_name"
                               placeholder="e.g. Office Chair"
                               required>
                    </div>


                    <div class="pl-other-field">

                        <label>Category <span>*</span></label>

                        <select name="category" required>

                            <option value="">Select Category</option>

                            <option>Furniture</option>
                            <option>Home Appliances</option>
                            <option>Machinery</option>
                            <option>Tools & Equipment</option>
                            <option>Office Equipment</option>
                            <option>Business Products</option>
                            <option>Agricultural Equipment</option>
                            <option>Home & Lifestyle Products</option>
                            <option>Books</option>
                            <option>Other Approved Items</option>

                        </select>

                    </div>


                    <div class="pl-other-field">

                        <label>Brand</label>

                        <input type="text"
                               name="brand"
                               placeholder="Brand, if applicable">

                    </div>


                    <div class="pl-other-field">

                        <label>Model</label>

                        <input type="text"
                               name="model"
                               placeholder="Model, if applicable">

                    </div>


                    <div class="pl-other-field">

                        <label>Product Age</label>

                        <input type="text"
                               name="product_age"
                               placeholder="e.g. 2 years">

                    </div>


                    <div class="pl-other-field">

                        <label>Quantity <span>*</span></label>

                        <input type="number"
                               name="quantity"
                               min="1"
                               value="1"
                               placeholder="Quantity"
                               required>

                    </div>


                    <div class="pl-other-field">

                        <label>Usage Details</label>

                        <input type="text"
                               name="usage_details"
                               placeholder="e.g. Lightly used">

                    </div>


                    <div class="pl-other-field">

                        <label>Product Status</label>

                        <select name="product_status">

                            <option>Fully Working</option>
                            <option>Partially Working</option>
                            <option>Needs Repair</option>
                            <option>For Parts</option>
                            <option>Not Applicable</option>

                        </select>

                    </div>

                </div>

            </div>


            <!-- CONDITION -->
            <div class="pl-other-block">

                <div class="pl-other-block-title">

                    <div class="pl-other-block-icon">
                        <i class="bi bi-stars"></i>
                    </div>

                    <div>
                        <h2>Product Condition</h2>
                        <p>Select the condition that best describes the item.</p>
                    </div>

                </div>


                <div class="pl-other-condition-grid">

                    <label class="pl-other-condition-option">

                        <input type="radio"
                               name="condition"
                               value="New"
                               required>

                        <div class="pl-other-condition-icon">
                            <i class="bi bi-box2-heart"></i>
                        </div>

                        <strong>New</strong>
                        <span>Unused item</span>

                    </label>


                    <label class="pl-other-condition-option">

                        <input type="radio"
                               name="condition"
                               value="Like New">

                        <div class="pl-other-condition-icon">
                            <i class="bi bi-hand-thumbs-up-fill"></i>
                        </div>

                        <strong>Like New</strong>
                        <span>Almost unused</span>

                    </label>


                    <label class="pl-other-condition-option">

                        <input type="radio"
                               name="condition"
                               value="Excellent">

                        <div class="pl-other-condition-icon">
                            <i class="bi bi-patch-check-fill"></i>
                        </div>

                        <strong>Excellent</strong>
                        <span>Very well maintained</span>

                    </label>


                    <label class="pl-other-condition-option">

                        <input type="radio"
                               name="condition"
                               value="Good">

                        <div class="pl-other-condition-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>

                        <strong>Good</strong>
                        <span>Normal condition</span>

                    </label>


                    <label class="pl-other-condition-option">

                        <input type="radio"
                               name="condition"
                               value="Used">

                        <div class="pl-other-condition-icon">
                            <i class="bi bi-clock-history"></i>
                        </div>

                        <strong>Used</strong>
                        <span>Previously used</span>

                    </label>


                    <label class="pl-other-condition-option">

                        <input type="radio"
                               name="condition"
                               value="Refurbished">

                        <div class="pl-other-condition-icon">
                            <i class="bi bi-arrow-repeat"></i>
                        </div>

                        <strong>Refurbished</strong>
                        <span>Restored item</span>

                    </label>

                </div>


                <div class="pl-other-grid pl-other-condition-notes">

                    <div class="pl-other-field pl-other-field-full">

                        <label>Condition Notes</label>

                        <textarea name="condition_notes"
                                  placeholder="Mention wear, scratches, repairs, modifications or other known conditions..."></textarea>

                    </div>

                </div>

            </div>


            <!-- PRICE -->
            <div class="pl-other-block">

                <div class="pl-other-block-title">

                    <div class="pl-other-block-icon">
                        <i class="bi bi-currency-rupee"></i>
                    </div>

                    <div>
                        <h2>Price & Quantity Details</h2>
                        <p>Set your expected selling price.</p>
                    </div>

                </div>


                <div class="pl-other-grid">

                    <div class="pl-other-field">

                        <label>Expected Price <span>*</span></label>

                        <div class="pl-other-input-prefix">

                            <span>₹</span>

                            <input type="number"
                                   name="price"
                                   id="otherPrice"
                                   placeholder="Enter price"
                                   required>

                        </div>

                    </div>


                    <div class="pl-other-field">

                        <label>Price Type</label>

                        <select name="price_type">

                            <option>Negotiable</option>
                            <option>Fixed</option>

                        </select>

                    </div>


                    <div class="pl-other-field">

                        <label>Pricing Basis</label>

                        <select name="pricing_basis">

                            <option>Total Price</option>
                            <option>Price Per Item</option>
                            <option>Price Per Unit</option>
                            <option>Bulk / Quantity Based</option>

                        </select>

                    </div>


                    <div class="pl-other-field">

                        <label>Minimum Quantity</label>

                        <input type="number"
                               name="minimum_quantity"
                               min="1"
                               placeholder="For bulk sales">

                    </div>

                </div>


                <div class="pl-other-bulk-note">

                    <i class="bi bi-info-circle-fill"></i>

                    <span>
                        For business or bulk products, mention quantity-based
                        pricing and minimum order quantity where applicable.
                    </span>

                </div>

            </div>


            <!-- LOCATION -->
            <div class="pl-other-block">

                <div class="pl-other-block-title">

                    <div class="pl-other-block-icon">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>

                    <div>
                        <h2>Location</h2>
                        <p>Tell buyers where the item is available.</p>
                    </div>

                </div>


                <div class="pl-other-grid">

                    <div class="pl-other-field">

                        <label>State <span>*</span></label>

                        <input type="text"
                               name="state"
                               placeholder="State"
                               required>

                    </div>


                    <div class="pl-other-field">

                        <label>District</label>

                        <input type="text"
                               name="district"
                               placeholder="District">

                    </div>


                    <div class="pl-other-field">

                        <label>City <span>*</span></label>

                        <input type="text"
                               name="city"
                               placeholder="City"
                               required>

                    </div>


                    <div class="pl-other-field">

                        <label>Area</label>

                        <input type="text"
                               name="area"
                               placeholder="Area / Locality">

                    </div>


                    <div class="pl-other-field pl-other-field-full">

                        <label>Landmark</label>

                        <input type="text"
                               name="landmark"
                               placeholder="Nearby landmark">

                    </div>

                </div>

            </div>


            <!-- IMAGES -->
            <div class="pl-other-block">

                <div class="pl-other-block-title">

                    <div class="pl-other-block-icon">
                        <i class="bi bi-images"></i>
                    </div>

                    <div>
                        <h2>Product Images</h2>
                        <p>Add clear images from different angles.</p>
                    </div>

                </div>


                <div class="pl-other-upload-info">

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Front
                    </span>

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Back
                    </span>

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Side
                    </span>

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Details
                    </span>

                    <span>
                        <i class="bi bi-check-circle-fill"></i>
                        Accessories
                    </span>

                </div>


                <label class="pl-other-upload"
                       id="otherDropZone">

                    <input type="file"
                           id="otherImages"
                           name="product_images[]"
                           accept="image/*"
                           multiple>

                    <div class="pl-other-upload-icon">
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


                <div id="otherImagePreview"
                     class="pl-other-image-preview"></div>

            </div>


            <!-- SELLER -->
            <div class="pl-other-block">

                <div class="pl-other-block-title">

                    <div class="pl-other-block-icon">
                        <i class="bi bi-person-vcard-fill"></i>
                    </div>

                    <div>
                        <h2>Seller Information</h2>
                        <p>Provide permitted contact details for buyers.</p>
                    </div>

                </div>


                <div class="pl-other-grid">

                    <div class="pl-other-field">

                        <label>Seller / Business Name <span>*</span></label>

                        <input type="text"
                               name="seller_name"
                               placeholder="Name"
                               required>

                    </div>


                    <div class="pl-other-field">

                        <label>Seller Type</label>

                        <select name="seller_type">

                            <option>Individual</option>
                            <option>Business</option>

                        </select>

                    </div>


                    <div class="pl-other-field">

                        <label>Mobile Number <span>*</span></label>

                        <input type="tel"
                               name="mobile"
                               placeholder="+91 XXXXX XXXXX"
                               required>

                    </div>


                    <div class="pl-other-field">

                        <label>WhatsApp Number</label>

                        <input type="tel"
                               name="whatsapp"
                               placeholder="+91 XXXXX XXXXX">

                    </div>


                    <div class="pl-other-field">

                        <label>Email Address</label>

                        <input type="email"
                               name="email"
                               placeholder="you@example.com">

                    </div>


                    <div class="pl-other-field">

                        <label>Community</label>

                        <input type="text"
                               name="community"
                               placeholder="Your community">

                    </div>

                </div>


                <div class="pl-other-privacy-note">

                    <i class="bi bi-shield-check"></i>

                    <span>
                        Personal contact information should remain protected
                        according to your PeopleLink privacy settings.
                    </span>

                </div>

            </div>


            <!-- DESCRIPTION -->
            <div class="pl-other-block">

                <div class="pl-other-block-title">

                    <div class="pl-other-block-icon">
                        <i class="bi bi-card-text"></i>
                    </div>

                    <div>
                        <h2>Product Description</h2>
                        <p>Give buyers a clear overview of the item.</p>
                    </div>

                </div>


                <div class="pl-other-field">

                    <textarea id="otherDescription"
                              name="description"
                              maxlength="1500"
                              placeholder="Describe the item, usage, condition, specifications, accessories, reason for selling and other useful information..."
                              required></textarea>

                    <div class="pl-other-counter">

                        <span id="otherDescriptionCount">0</span>
                        / 1500 characters

                    </div>

                </div>

            </div>


            <!-- VISIBILITY -->
            <div class="pl-other-block">

                <div class="pl-other-block-title">

                    <div class="pl-other-block-icon">
                        <i class="bi bi-globe2"></i>
                    </div>

                    <div>
                        <h2>Listing Visibility</h2>
                        <p>Choose who can discover your marketplace item.</p>
                    </div>

                </div>


                <div class="pl-other-visibility">

                    <label class="pl-other-visibility-option active">

                        <input type="radio"
                               name="visibility"
                               value="community"
                               checked>

                        <div class="pl-other-visibility-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>

                        <div>
                            <strong>Community-Specific</strong>

                            <span>
                                Show the listing within your selected community.
                            </span>
                        </div>

                    </label>


                    <label class="pl-other-visibility-option">

                        <input type="radio"
                               name="visibility"
                               value="global">

                        <div class="pl-other-visibility-icon">
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
            <div class="pl-other-submit-box">

                <label class="pl-other-agreement">

                    <input type="checkbox"
                           id="otherAgreement"
                           required>

                    <span>
                        I confirm that the information provided is accurate
                        and I agree to PeopleLink's marketplace and community
                        guidelines.
                    </span>

                </label>


                <div class="pl-other-submit-actions">

                    <button type="button"
                            class="pl-other-btn secondary"
                            id="saveOtherDraft">

                        <i class="bi bi-save2"></i>
                        Save Draft

                    </button>


                    <button type="button"
                            class="pl-other-btn outline"
                            id="previewOther">

                        <i class="bi bi-eye"></i>
                        Preview

                    </button>


                    <button type="submit"
                            class="pl-other-btn primary">

                        <i class="bi bi-send-fill"></i>
                        Submit Item

                    </button>

                </div>


                <div class="pl-other-approval">

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
<div class="pl-other-modal"
     id="otherPreviewModal">

    <div class="pl-other-modal-box">

        <button type="button"
                class="pl-other-modal-close"
                id="closeOtherPreview">

            <i class="bi bi-x-lg"></i>

        </button>


        <div class="pl-other-modal-head">

            <div class="pl-other-modal-icon">
                <i class="bi bi-grid-3x3-gap-fill"></i>
            </div>

            <div>

                <span>LISTING PREVIEW</span>

                <h3 id="previewOtherTitle">
                    Marketplace Item
                </h3>

            </div>

        </div>


        <div class="pl-other-preview-image"
             id="previewOtherImage">

            <i class="bi bi-image"></i>

        </div>


        <div class="pl-other-preview-grid">

            <div>
                <small>Product</small>
                <strong id="previewOtherProduct">—</strong>
            </div>

            <div>
                <small>Category</small>
                <strong id="previewOtherCategory">—</strong>
            </div>

            <div>
                <small>Condition</small>
                <strong id="previewOtherCondition">—</strong>
            </div>

            <div>
                <small>Price</small>
                <strong id="previewOtherPrice">—</strong>
            </div>

            <div>
                <small>Quantity</small>
                <strong id="previewOtherQuantity">—</strong>
            </div>

            <div>
                <small>Location</small>
                <strong id="previewOtherLocation">—</strong>
            </div>

        </div>


        <div class="pl-other-preview-description">

            <small>Description</small>

            <p id="previewOtherDescription">—</p>

        </div>

    </div>

</div>


<!-- TOAST -->
<div class="pl-other-toast"
     id="otherToast">

    <i class="bi bi-check-circle-fill"></i>

    <span>
        Marketplace listing saved successfully.
    </span>

</div>


 

<?php include 'footer.php'; ?>