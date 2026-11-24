<?php
// Post / Edit Marketplace Listing (live: marketplace_create / marketplace_update, photos uploaded to the listing gallery)
require_once dirname(__DIR__) . '/_web.php';
web_require_login();
web_require_community();
$E = pl_entity('mp_listing');
$pmEditId = (int)($_GET['edit'] ?? $_POST['edit_id'] ?? 0);
$pmEdit = $pmEditId ? pl_api_own($E, $pmEditId, $webUid) : null;
if ($pmEditId && !$pmEdit) { flash('Listing not found.', 'error'); header('Location: my-marketplace-listings.php'); exit; }

/* design names -> marketplace categories in the database */
function pm_category_id(string $name): int {
    $alias = ['Furniture' => 'Furniture/Home', 'Products' => 'Other'];
    $n = $alias[$name] ?? $name;
    return (int)scalar("SELECT id FROM categories WHERE module='marketplace' AND parent_id IS NULL AND LOWER(name)=LOWER(?) LIMIT 1", [$n]);
}
function pm_sub_id(int $parent, string $name): int {
    if ($name === '' || !$parent) return 0;
    return (int)scalar("SELECT id FROM categories WHERE module='marketplace' AND parent_id=? AND (LOWER(name)=LOWER(?) OR LOWER(name) LIKE LOWER(?)) LIMIT 1", [$parent, $name, '%' . $name . '%']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) { echo json_encode(['ok' => false, 'error' => 'Your session expired. Please refresh the page and try again.']); exit; }
    $in = $_POST;
    $catId = pm_category_id((string)($in['category'] ?? ''));
    if (!$catId) { echo json_encode(['ok' => false, 'error' => 'Please choose a category.']); exit; }
    $cond = ['Like New' => 'Like new', 'Not Applicable' => 'Not applicable', 'Refurbished' => 'Used'][$in['condition'] ?? ''] ?? ($in['condition'] ?? '');
    $desc = trim(trim((string)($in['short_description'] ?? '')) . "\n\n" . trim((string)($in['description'] ?? '')));
    $map = [
        'category_id' => $catId, 'subcategory_id' => pm_sub_id($catId, (string)($in['subcategory'] ?? '')) ?: '',
        'title' => $in['title'] ?? '', 'description' => $desc,
        'listing_type' => ($in['category'] ?? '') === 'Services' ? 'Service' : 'Sell',
        'price' => preg_replace('/[^\d.]/', '', (string)($in['price'] ?? '')), 'price_negotiable' => ($in['price_type'] ?? '') === 'Negotiable' ? 1 : 0,
        'item_condition' => in_array($cond, ['New', 'Like new', 'Used', 'Not applicable'], true) ? $cond : '',
        'location' => $in['locality'] ?? '', 'city' => $in['city'] ?? '',
        'contact_name' => $in['seller_name'] ?? '', 'phone' => $in['mobile'] ?? '', 'whatsapp' => $in['whatsapp'] ?? '', 'email' => $in['email'] ?? '',
        'visibility_type' => ($in['visibility'] ?? '') === 'Public' ? 'global' : 'community',
    ];
    // everything else in the form (category-specific specs, address, map link, contact methods) is kept as listing details
    $skip = array_flip(['csrf', 'category', 'subcategory', 'condition', 'price', 'price_type', 'short_description', 'description', 'title', 'locality', 'city', 'seller_name', 'mobile', 'whatsapp', 'email', 'visibility', 'edit_id']);
    foreach ($in as $k => $v) if (!isset($skip[$k]) && !isset($map[$k]) && (is_array($v) ? $v : trim((string)$v) !== '')) $map[$k] = is_array($v) ? implode(', ', $v) : trim((string)$v);
    if ($pmEdit) $map['id'] = $pmEditId;
    $_POST = ['csrf' => $in['csrf']]; // only the mapped fields go to the backend
    $r = web_call($pmEdit ? 'marketplace_update' : 'marketplace_create', $map + ['csrf' => $_POST['csrf']], true);
    if (!empty($r['error'])) { echo json_encode(['ok' => false, 'error' => $r['error']]); exit; }
    $id = (int)($r['id'] ?? $r['item']['id'] ?? $pmEditId);
    // new photos on edit (create uploads them itself)
    if ($pmEdit && pl_files_list(pl_api_files($E))) pl_media_add($E, $id, pl_api_files($E), $webUid);
    echo json_encode(['ok' => true, 'id' => $id, 'message' => $r['message'] ?? 'Saved.', 'upload_error' => $r['upload_error'] ?? null]); exit;
}

// Edit: values for the form (design field names)
$pmFill = [];
if ($pmEdit) {
    $d = json_decode((string)($pmEdit['details'] ?? ''), true) ?: [];
    $cat = (string)(rows('SELECT name FROM categories WHERE id=?', [(int)$pmEdit['category_id']])[0]['name'] ?? '');
    $sub = $pmEdit['subcategory_id'] ? (string)(rows('SELECT name FROM categories WHERE id=?', [(int)$pmEdit['subcategory_id']])[0]['name'] ?? '') : '';
    $parts = preg_split('/\n\s*\n/', (string)$pmEdit['description'], 2);
    $pmFill = $d + [
        'category' => ['Furniture/Home' => 'Furniture'][$cat] ?? $cat, 'subcategory' => $sub, 'title' => $pmEdit['title'],
        'short_description' => $parts[0] ?? '', 'description' => $parts[1] ?? '',
        'price' => $pmEdit['price'] !== null ? (string)(int)$pmEdit['price'] : '', 'price_type' => $pmEdit['price_negotiable'] ? 'Negotiable' : 'Fixed',
        'condition' => ['Like new' => 'Like New', 'Not applicable' => 'Not Applicable'][$pmEdit['item_condition'] ?? ''] ?? ($pmEdit['item_condition'] ?? ''),
        'locality' => $pmEdit['location'], 'city' => $pmEdit['city'], 'seller_name' => $pmEdit['contact_name'], 'mobile' => $pmEdit['phone'],
        'whatsapp' => $pmEdit['whatsapp'], 'email' => $pmEdit['email'], 'visibility' => $pmEdit['visibility_type'] === 'global' ? 'Public' : 'Community',
    ];
    if (isset($d['contact_methods'])) $pmFill['contact_methods'] = array_map('trim', explode(',', (string)$d['contact_methods']));
} else {
    $pmFill = ['seller_name' => $webUser['name'] ?? '', 'mobile' => $webUser['phone'] ?? '', 'email' => $webUser['email'] ?? ''];
}
include 'header.php'; ?>



<main class="pl-post-page">

    <!-- Page Header -->
    <section class="pl-post-hero">
        <div class="pl-post-container">
            <div class="pl-post-breadcrumb">
                <a href="marketplace-home.php">Marketplace</a>
                <i class="fas fa-chevron-right"></i>
                <span>Post a Listing</span>
            </div>

            <div class="pl-post-hero-content">
                <div>
                    <span class="pl-post-eyebrow">PEOPLELINK MARKETPLACE</span>
                    <h1>Post a Marketplace Listing</h1>
                    <p>Share your products, property, vehicles and services with your community.</p>
                </div>

                <div class="pl-post-hero-icon">
                    <i class="fas fa-store"></i>
                </div>
            </div>

            <div class="pl-post-progress">
                <span class="pl-post-progress-step active">
                    <i class="fas fa-edit"></i> Listing Details
                </span>
                <span class="pl-post-progress-line"></span>
                <span class="pl-post-progress-step">
                    <i class="fas fa-image"></i> Photos
                </span>
                <span class="pl-post-progress-line"></span>
                <span class="pl-post-progress-step">
                    <i class="fas fa-check-circle"></i> Submit
                </span>
            </div>
        </div>
    </section>

    <section class="pl-post-main">
        <div class="pl-post-container">

            <form id="plPostForm" enctype="multipart/form-data" novalidate>

                <div class="pl-post-layout">

                    <!-- Main Form -->
                    <div class="pl-post-main-column">

                        <!-- Category -->
                        <section class="pl-post-card">
                            <div class="pl-post-section-heading">
                                <span class="pl-post-section-icon">
                                    <i class="fas fa-th-large"></i>
                                </span>
                                <div>
                                    <h2>Choose Listing Category</h2>
                                    <p>Select the category that best describes your listing.</p>
                                </div>
                            </div>

                            <div class="pl-post-category-grid">
                                <label class="pl-post-category-option">
                                    <input type="radio" name="category"
                                           value="Property" required>
                                    <span class="pl-post-category-box">
                                        <i class="fas fa-home"></i>
                                        <strong>Property</strong>
                                    </span>
                                </label>

                                <label class="pl-post-category-option">
                                    <input type="radio" name="category" value="Cars">
                                    <span class="pl-post-category-box">
                                        <i class="fas fa-car"></i>
                                        <strong>Cars</strong>
                                    </span>
                                </label>

                                <label class="pl-post-category-option">
                                    <input type="radio" name="category" value="Bikes">
                                    <span class="pl-post-category-box">
                                        <i class="fas fa-motorcycle"></i>
                                        <strong>Bikes</strong>
                                    </span>
                                </label>

                                <label class="pl-post-category-option">
                                    <input type="radio" name="category" value="Electronics">
                                    <span class="pl-post-category-box">
                                        <i class="fas fa-laptop"></i>
                                        <strong>Electronics</strong>
                                    </span>
                                </label>

                                <label class="pl-post-category-option">
                                    <input type="radio" name="category" value="Furniture">
                                    <span class="pl-post-category-box">
                                        <i class="fas fa-couch"></i>
                                        <strong>Furniture</strong>
                                    </span>
                                </label>

                                <label class="pl-post-category-option">
                                    <input type="radio" name="category" value="Products">
                                    <span class="pl-post-category-box">
                                        <i class="fas fa-shopping-bag"></i>
                                        <strong>Products</strong>
                                    </span>
                                </label>

                                <label class="pl-post-category-option">
                                    <input type="radio" name="category" value="Services">
                                    <span class="pl-post-category-box">
                                        <i class="fas fa-tools"></i>
                                        <strong>Services</strong>
                                    </span>
                                </label>

                                <label class="pl-post-category-option">
                                    <input type="radio" name="category" value="Other">
                                    <span class="pl-post-category-box">
                                        <i class="fas fa-ellipsis-h"></i>
                                        <strong>Other</strong>
                                    </span>
                                </label>
                            </div>
                        </section>

                        <!-- Basic Information -->
                        <section class="pl-post-card">
                            <div class="pl-post-section-heading">
                                <span class="pl-post-section-icon">
                                    <i class="fas fa-file-alt"></i>
                                </span>
                                <div>
                                    <h2>Basic Listing Information</h2>
                                    <p>Provide a clear title, price and description.</p>
                                </div>
                            </div>

                            <div class="pl-post-form-grid">

                                <div class="pl-post-field pl-post-full">
                                    <label for="plPostTitle">Listing Title <span>*</span></label>
                                    <input type="text" id="plPostTitle" name="title"
                                           placeholder="Example: Samsung Galaxy Smartphone"
                                           maxlength="150" required>
                                    <small>Use a clear title that helps people find your listing.</small>
                                </div>

                                <div class="pl-post-field">
                                    <label for="plPostSubcategory">Subcategory <span>*</span></label>
                                    <select id="plPostSubcategory" name="subcategory" required>
                                        <option value="">Select subcategory</option>
                                    </select>
                                </div>

                                <div class="pl-post-field">
                                    <label for="plPostCondition">Condition <span>*</span></label>
                                    <select id="plPostCondition" name="condition" required>
                                        <option value="">Select condition</option>
                                        <option value="New">New</option>
                                        <option value="Like New">Like New</option>
                                        <option value="Used">Used</option>
                                        <option value="Refurbished">Refurbished</option>
                                        <option value="Not Applicable">Not Applicable</option>
                                    </select>
                                </div>

                                <div class="pl-post-field">
                                    <label for="plPostPrice">Price (₹) <span>*</span></label>
                                    <div class="pl-post-price-input">
                                        <span>₹</span>
                                        <input type="number" id="plPostPrice" name="price"
                                               min="0" step="0.01"
                                               placeholder="Enter price" required>
                                    </div>
                                </div>

                                <div class="pl-post-field">
                                    <label>Price Type <span>*</span></label>
                                    <div class="pl-post-radio-row">
                                        <label>
                                            <input type="radio" name="price_type"
                                                   value="Negotiable" checked>
                                            <span>Negotiable</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="price_type"
                                                   value="Fixed">
                                            <span>Fixed Price</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="pl-post-field pl-post-full">
                                    <label for="plPostShortDescription">
                                        Short Description <span>*</span>
                                    </label>
                                    <textarea id="plPostShortDescription"
                                              name="short_description" rows="2"
                                              maxlength="250"
                                              placeholder="Write a short summary of your listing"
                                              required></textarea>
                                    <small><span id="plPostShortCount">0</span>/250 characters</small>
                                </div>

                                <div class="pl-post-field pl-post-full">
                                    <label for="plPostDescription">
                                        Detailed Description <span>*</span>
                                    </label>
                                    <textarea id="plPostDescription"
                                              name="description" rows="6"
                                              maxlength="5000"
                                              placeholder="Describe the item, features, condition, benefits and other important details"
                                              required></textarea>
                                    <small><span id="plPostDescriptionCount">0</span>/5000 characters</small>
                                </div>
                            </div>
                        </section>

                        <!-- Dynamic Category Fields -->
                        <section class="pl-post-card" id="plPostCategoryDetails" hidden>
                            <div class="pl-post-section-heading">
                                <span class="pl-post-section-icon">
                                    <i class="fas fa-list-ul"></i>
                                </span>
                                <div>
                                    <h2 id="plPostDynamicTitle">Additional Details</h2>
                                    <p>Provide details relevant to your selected category.</p>
                                </div>
                            </div>

                            <!-- Property Fields -->
                            <div class="pl-post-dynamic-group" data-category="Property" hidden>
                                <div class="pl-post-form-grid">
                                    <div class="pl-post-field">
                                        <label for="plPostPropertyType">Property Type</label>
                                        <select id="plPostPropertyType" name="property_type">
                                            <option value="">Select property type</option>
                                            <option>Apartment / Flat</option>
                                            <option>Independent House</option>
                                            <option>Villa</option>
                                            <option>Residential Plot</option>
                                            <option>Commercial Property</option>
                                            <option>Shop / Office</option>
                                            <option>Land</option>
                                            <option>Other</option>
                                        </select>
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostAreaSize">Area / Size</label>
                                        <input type="number" id="plPostAreaSize"
                                               name="area_size" min="0"
                                               placeholder="Enter area">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostAreaUnit">Area Unit</label>
                                        <select id="plPostAreaUnit" name="area_unit">
                                            <option value="sqft">Square Feet</option>
                                            <option value="sqm">Square Metres</option>
                                            <option value="sqyd">Square Yards</option>
                                            <option value="acre">Acres</option>
                                            <option value="bigha">Bigha</option>
                                        </select>
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostBedrooms">Bedrooms</label>
                                        <input type="number" id="plPostBedrooms"
                                               name="bedrooms" min="0" placeholder="Number of bedrooms">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostBathrooms">Bathrooms</label>
                                        <input type="number" id="plPostBathrooms"
                                               name="bathrooms" min="0" placeholder="Number of bathrooms">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostFurnishing">Furnishing</label>
                                        <select id="plPostFurnishing" name="furnishing">
                                            <option value="">Select furnishing</option>
                                            <option>Furnished</option>
                                            <option>Semi-Furnished</option>
                                            <option>Unfurnished</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Cars and Bikes -->
                            <div class="pl-post-dynamic-group" data-category="Cars,Bikes" hidden>
                                <div class="pl-post-form-grid">
                                    <div class="pl-post-field">
                                        <label for="plPostVehicleBrand">Brand</label>
                                        <input type="text" id="plPostVehicleBrand"
                                               name="vehicle_brand" placeholder="Example: Honda">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostVehicleModel">Model</label>
                                        <input type="text" id="plPostVehicleModel"
                                               name="vehicle_model" placeholder="Enter model">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostVehicleYear">Manufacturing Year</label>
                                        <input type="number" id="plPostVehicleYear"
                                               name="vehicle_year" min="1950" max="2100"
                                               placeholder="Example: 2023">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostKilometres">Kilometres Driven</label>
                                        <input type="number" id="plPostKilometres"
                                               name="kilometres_driven" min="0"
                                               placeholder="Example: 25000">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostFuelType">Fuel Type</label>
                                        <select id="plPostFuelType" name="fuel_type">
                                            <option value="">Select fuel type</option>
                                            <option>Petrol</option>
                                            <option>Diesel</option>
                                            <option>Electric</option>
                                            <option>Hybrid</option>
                                            <option>CNG</option>
                                            <option>Other</option>
                                        </select>
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostOwnership">Ownership</label>
                                        <select id="plPostOwnership" name="ownership">
                                            <option value="">Select ownership</option>
                                            <option>First Owner</option>
                                            <option>Second Owner</option>
                                            <option>Third Owner</option>
                                            <option>Fourth or More Owner</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Electronics -->
                            <div class="pl-post-dynamic-group" data-category="Electronics" hidden>
                                <div class="pl-post-form-grid">
                                    <div class="pl-post-field">
                                        <label for="plPostElectronicBrand">Brand</label>
                                        <input type="text" id="plPostElectronicBrand"
                                               name="electronic_brand" placeholder="Enter brand">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostElectronicModel">Model</label>
                                        <input type="text" id="plPostElectronicModel"
                                               name="electronic_model" placeholder="Enter model">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostPurchaseYear">Purchase Year</label>
                                        <input type="number" id="plPostPurchaseYear"
                                               name="purchase_year" min="1950" max="2100"
                                               placeholder="Example: 2025">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostWarranty">Warranty</label>
                                        <select id="plPostWarranty" name="warranty">
                                            <option value="">Select warranty status</option>
                                            <option>Under Warranty</option>
                                            <option>Warranty Expired</option>
                                            <option>No Warranty</option>
                                            <option>Not Sure</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Furniture -->
                            <div class="pl-post-dynamic-group" data-category="Furniture" hidden>
                                <div class="pl-post-form-grid">
                                    <div class="pl-post-field">
                                        <label for="plPostFurnitureType">Furniture Type</label>
                                        <input type="text" id="plPostFurnitureType"
                                               name="furniture_type"
                                               placeholder="Example: Sofa, Bed, Table">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostMaterial">Material</label>
                                        <input type="text" id="plPostMaterial"
                                               name="material"
                                               placeholder="Example: Wood, Metal">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostDimensions">Dimensions</label>
                                        <input type="text" id="plPostDimensions"
                                               name="dimensions"
                                               placeholder="Length × Width × Height">
                                    </div>
                                </div>
                            </div>

                            <!-- Products -->
                            <div class="pl-post-dynamic-group" data-category="Products" hidden>
                                <div class="pl-post-form-grid">
                                    <div class="pl-post-field">
                                        <label for="plPostProductBrand">Brand (Optional)</label>
                                        <input type="text" id="plPostProductBrand"
                                               name="product_brand" placeholder="Enter brand">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostStock">Available Quantity</label>
                                        <input type="number" id="plPostStock"
                                               name="stock_quantity" min="1"
                                               placeholder="Enter quantity">
                                    </div>
                                </div>
                            </div>

                            <!-- Services -->
                            <div class="pl-post-dynamic-group" data-category="Services" hidden>
                                <div class="pl-post-form-grid">
                                    <div class="pl-post-field">
                                        <label for="plPostServiceType">Service Type</label>
                                        <input type="text" id="plPostServiceType"
                                               name="service_type"
                                               placeholder="Example: Home Painting">
                                    </div>

                                    <div class="pl-post-field">
                                        <label for="plPostServiceCharge">Pricing Basis</label>
                                        <select id="plPostServiceCharge" name="service_pricing">
                                            <option value="">Select pricing basis</option>
                                            <option>Fixed Price</option>
                                            <option>Starting From</option>
                                            <option>Per Hour</option>
                                            <option>Per Day</option>
                                            <option>Per Item</option>
                                            <option>Request a Quote</option>
                                        </select>
                                    </div>

                                    <div class="pl-post-field pl-post-full">
                                        <label for="plPostServiceCoverage">Service Area</label>
                                        <input type="text" id="plPostServiceCoverage"
                                               name="service_area"
                                               placeholder="Where do you provide this service?">
                                    </div>
                                </div>
                            </div>

                            <!-- Other -->
                            <div class="pl-post-dynamic-group" data-category="Other" hidden>
                                <div class="pl-post-form-grid">
                                    <div class="pl-post-field pl-post-full">
                                        <label for="plPostOtherType">Item Type</label>
                                        <input type="text" id="plPostOtherType"
                                               name="other_type"
                                               placeholder="Describe the item or listing type">
                                    </div>
                                </div>
                            </div>
                        </section>

                        <!-- Images -->
                        <section class="pl-post-card">
                            <div class="pl-post-section-heading">
                                <span class="pl-post-section-icon">
                                    <i class="fas fa-images"></i>
                                </span>
                                <div>
                                    <h2>Listing Images</h2>
                                    <p>Upload clear photos to help people understand your listing.</p>
                                </div>
                            </div>

                            <div class="pl-post-image-upload">
                                <label for="plPostMainImage" class="pl-post-upload-box pl-post-main-upload">
                                    <input type="file" id="plPostMainImage"
                                           name="main_image" accept="image/*"<?= $pmEdit ? '' : ' required' ?>>
                                    <span class="pl-post-upload-icon">
                                        <i class="fas fa-camera"></i>
                                    </span>
                                    <strong>Main Image <span>*</span></strong>
                                    <small>Choose your cover photo</small>
                                    <span class="pl-post-upload-action">Choose Image</span>
                                </label>

                                <label for="plPostAdditionalImages" class="pl-post-upload-box">
                                    <input type="file" id="plPostAdditionalImages"
                                           name="additional_images[]"
                                           accept="image/*" multiple>
                                    <span class="pl-post-upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </span>
                                    <strong>Additional Images</strong>
                                    <small>Select multiple photos</small>
                                    <span class="pl-post-upload-action">Add Photos</span>
                                </label>
                            </div>

                            <div class="pl-post-image-guidelines">
                                <i class="fas fa-info-circle"></i>
                                Use JPG, PNG or WebP images. Recommended: maximum
                                5 MB per image. Server-side upload limits must also be configured.
                            </div>

                            <div class="pl-post-image-preview" id="plPostImagePreview"></div>
                        </section>

                        <!-- Location -->
                        <section class="pl-post-card">
                            <div class="pl-post-section-heading">
                                <span class="pl-post-section-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <div>
                                    <h2>Listing Location</h2>
                                    <p>Help interested members find your listing.</p>
                                </div>
                            </div>

                            <div class="pl-post-form-grid">
                                <div class="pl-post-field">
                                    <label for="plPostCity">City <span>*</span></label>
                                    <input type="text" id="plPostCity" name="city"
                                           placeholder="Enter city" required>
                                </div>

                                <div class="pl-post-field">
                                    <label for="plPostLocality">Area / Locality <span>*</span></label>
                                    <input type="text" id="plPostLocality" name="locality"
                                           placeholder="Enter area or locality" required>
                                </div>

                                <div class="pl-post-field pl-post-full">
                                    <label for="plPostAddress">Address (Optional)</label>
                                    <textarea id="plPostAddress" name="address"
                                              rows="2"
                                              placeholder="Enter a general address; avoid sharing private details publicly"></textarea>
                                </div>

                                <div class="pl-post-field pl-post-full">
                                    <label for="plPostMapLink">Map Link (Optional)</label>
                                    <input type="url" id="plPostMapLink" name="map_link"
                                           placeholder="https://maps.google.com/...">
                                    <small>Share a map link if appropriate. Do not publish a private home address.</small>
                                </div>
                            </div>
                        </section>

                        <!-- Seller Contact -->
                        <section class="pl-post-card">
                            <div class="pl-post-section-heading">
                                <span class="pl-post-section-icon">
                                    <i class="fas fa-user"></i>
                                </span>
                                <div>
                                    <h2>Seller Contact Information</h2>
                                    <p>Choose how interested members can contact you.</p>
                                </div>
                            </div>

                            <div class="pl-post-form-grid">
                                <div class="pl-post-field">
                                    <label for="plPostSellerName">Seller Name <span>*</span></label>
                                    <input type="text" id="plPostSellerName"
                                           name="seller_name" placeholder="Enter your name" required>
                                </div>

                                <div class="pl-post-field">
                                    <label for="plPostMobile">Mobile Number <span>*</span></label>
                                    <input type="tel" id="plPostMobile" name="mobile"
                                           placeholder="Enter mobile number"
                                           autocomplete="tel" required>
                                </div>

                                <div class="pl-post-field">
                                    <label for="plPostWhatsApp">WhatsApp Number</label>
                                    <input type="tel" id="plPostWhatsApp" name="whatsapp"
                                           placeholder="Enter WhatsApp number">
                                </div>

                                <div class="pl-post-field">
                                    <label for="plPostEmail">Email Address</label>
                                    <input type="email" id="plPostEmail" name="email"
                                           placeholder="Enter email address">
                                </div>
                            </div>

                            <div class="pl-post-contact-preferences">
                                <strong>Allow contact through</strong>

                                <label>
                                    <input type="checkbox" name="contact_methods[]"
                                           value="Call" checked>
                                    <span><i class="fas fa-phone-alt"></i> Phone Call</span>
                                </label>

                                <label>
                                    <input type="checkbox" name="contact_methods[]"
                                           value="WhatsApp">
                                    <span><i class="fab fa-whatsapp"></i> WhatsApp</span>
                                </label>

                                <label>
                                    <input type="checkbox" name="contact_methods[]"
                                           value="Email" checked>
                                    <span><i class="fas fa-envelope"></i> Email</span>
                                </label>

                                <label>
                                    <input type="checkbox" name="contact_methods[]"
                                           value="Enquiry" checked>
                                    <span><i class="fas fa-comment-alt"></i> Platform Enquiry</span>
                                </label>
                            </div>

                            <p class="pl-post-privacy-note">
                                <i class="fas fa-shield-alt"></i>
                                Contact visibility should follow your account privacy settings.
                                Only show contact details that you have chosen to share.
                            </p>
                        </section>

                        <!-- Visibility -->
                        <section class="pl-post-card">
                            <div class="pl-post-section-heading">
                                <span class="pl-post-section-icon">
                                    <i class="fas fa-eye"></i>
                                </span>
                                <div>
                                    <h2>Listing Visibility</h2>
                                    <p>Choose the intended audience for your listing.</p>
                                </div>
                            </div>

                            <div class="pl-post-visibility-options">
                                <label class="pl-post-visibility-option">
                                    <input type="radio" name="visibility"
                                           value="Community" checked>
                                    <span class="pl-post-visibility-box">
                                        <i class="fas fa-users"></i>
                                        <strong>Community</strong>
                                        <small>Share according to community access rules.</small>
                                    </span>
                                </label>

                                <label class="pl-post-visibility-option">
                                    <input type="radio" name="visibility"
                                           value="Public">
                                    <span class="pl-post-visibility-box">
                                        <i class="fas fa-globe"></i>
                                        <strong>Public</strong>
                                        <small>Allow broader marketplace discovery, subject to platform rules.</small>
                                    </span>
                                </label>
                            </div>

                            <label class="pl-post-agreement">
                                <input type="checkbox" id="plPostAgreement" required>
                                <span>
                                    I confirm that the listing information is accurate
                                    and that I am allowed to publish this item or service.
                                </span>
                            </label>
                        </section>

                    </div>

                    <!-- Sidebar -->
                    <aside class="pl-post-sidebar">

                        <div class="pl-post-sidebar-card pl-post-tips-card">
                            <div class="pl-post-sidebar-title">
                                <span><i class="fas fa-lightbulb"></i></span>
                                <h3>Tips for a Better Listing</h3>
                            </div>

                            <ul>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Use a clear, descriptive title.</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Upload bright, genuine photos.</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Set a reasonable price.</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Describe the condition honestly.</span>
                                </li>
                                <li>
                                    <i class="fas fa-check-circle"></i>
                                    <span>Protect your personal information.</span>
                                </li>
                            </ul>
                        </div>

                        <div class="pl-post-sidebar-card pl-post-review-card">
                            <div class="pl-post-sidebar-title">
                                <span><i class="fas fa-clipboard-check"></i></span>
                                <h3>Before You Submit</h3>
                            </div>

                            <div class="pl-post-check-row">
                                <i class="fas fa-check"></i>
                                <span>Correct category selected</span>
                            </div>
                            <div class="pl-post-check-row">
                                <i class="fas fa-check"></i>
                                <span>Price and description added</span>
                            </div>
                            <div class="pl-post-check-row">
                                <i class="fas fa-check"></i>
                                <span>Main image uploaded</span>
                            </div>
                            <div class="pl-post-check-row">
                                <i class="fas fa-check"></i>
                                <span>Contact details reviewed</span>
                            </div>
                        </div>

                        <div class="pl-post-sidebar-card pl-post-help-card">
                            <i class="fas fa-headset"></i>
                            <h3>Need Help?</h3>
                            <p>Check the marketplace guidelines before publishing your listing.</p>
                            <a href="marketplace-guidelines.php">
                                Marketplace Guidelines
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>

                    </aside>
                </div>

                <!-- Sticky Action Bar -->
                <div class="pl-post-action-bar">
                    <div class="pl-post-action-info">
                        <i class="fas fa-shield-alt"></i>
                        <span>Your listing may be reviewed before publication.</span>
                    </div>

                    <div class="pl-post-action-buttons">
                        <button type="button" class="pl-post-btn pl-post-preview-btn"
                                id="plPostPreview">
                            <i class="fas fa-eye"></i> Preview Listing
                        </button>

                        <button type="button" class="pl-post-btn pl-post-draft-btn"
                                id="plPostSaveDraft">
                            <i class="far fa-save"></i> Save Draft
                        </button>

                        <button type="submit" class="pl-post-btn pl-post-submit-btn"
                                id="plPostSubmit">
                            <i class="fas fa-paper-plane"></i> Submit Listing
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </section>

    <!-- Preview Modal -->
    <div class="pl-post-modal" id="plPostPreviewModal" aria-hidden="true">
        <div class="pl-post-modal-backdrop" data-post-close></div>

        <div class="pl-post-modal-dialog" role="dialog" aria-modal="true"
             aria-labelledby="plPostPreviewTitle">

            <button type="button" class="pl-post-modal-close"
                    data-post-close aria-label="Close preview">
                <i class="fas fa-times"></i>
            </button>

            <span class="pl-post-eyebrow">LISTING PREVIEW</span>
            <h2 id="plPostPreviewTitle">Review Your Listing</h2>
            <p class="pl-post-preview-subtitle">
                Check the details below before submitting your listing.
            </p>

            <div class="pl-post-preview-content" id="plPostPreviewContent"></div>

            <div class="pl-post-preview-actions">
                <button type="button" class="pl-post-btn pl-post-draft-btn"
                        data-post-close>
                    Continue Editing
                </button>
                <button type="button" class="pl-post-btn pl-post-submit-btn"
                        id="plPostPreviewSubmit">
                    Submit Listing
                </button>
            </div>
        </div>
    </div>

    <!-- Feedback Modal -->
    <div class="pl-post-modal" id="plPostFeedbackModal" aria-hidden="true">
        <div class="pl-post-modal-backdrop" data-post-close></div>

        <div class="pl-post-modal-dialog pl-post-feedback-dialog"
             role="dialog" aria-modal="true"
             aria-labelledby="plPostFeedbackTitle">

            <div class="pl-post-feedback-icon">
                <i class="fas fa-check"></i>
            </div>

            <h2 id="plPostFeedbackTitle">Listing Submitted Successfully</h2>

            <p id="plPostFeedbackMessage">
                Your listing is under review and will be published after approval.
            </p>

            <button type="button" class="pl-post-btn pl-post-submit-btn"
                    id="plPostFeedbackClose">
                Continue
            </button>
        </div>
    </div>

    <div class="pl-post-toast" id="plPostToast"
         role="status" aria-live="polite"></div>

</main>


<script>window.PM_EDIT_ID=<?= (int)($pmEdit['id'] ?? 0) ?>;window.PM_FILL=<?= json_encode($pmFill, JSON_HEX_TAG | JSON_HEX_AMP) ?>;</script>
<?php include 'footer.php'; ?>
