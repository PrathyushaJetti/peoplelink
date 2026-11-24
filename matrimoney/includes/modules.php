<?php
// PeopleLink modules: Marketplace, Members & Family, Family Tree, Directory, Near Me, Events & Ads,
// Community Support, Leadership, Packages. One registry (PL_ENTITIES) drives the tables, the admin pages and the API.
// Loaded from bridge.php - do not include directly.

const PL_FILES_DIR = __DIR__ . '/../uploads/files/';
const PL_FILES_URL = DASHBOARD_URL . 'uploads/files/';
foreach (['RAZORPAY_KEY_ID', 'RAZORPAY_KEY_SECRET', 'RAZORPAY_WEBHOOK_SECRET', 'FCM_SERVICE_ACCOUNT_FILE', 'SMS_API_URL'] as $__k) if (!defined($__k)) define($__k, '');

const PL_GENDERS = ['Male', 'Female', 'Other'];
const PL_MARITAL = ['Single', 'Married', 'Divorced', 'Widowed'];
const PL_RELATIONS = ['Self', 'Spouse', 'Father', 'Mother', 'Son', 'Daughter', 'Brother', 'Sister', 'Grandfather', 'Grandmother', 'Grandson', 'Granddaughter', 'Uncle', 'Aunt', 'Other'];
const PL_TREE_RELATIONS = ['Father', 'Mother', 'Spouse', 'Son', 'Daughter', 'Brother', 'Sister', 'Grandfather', 'Grandmother', 'Other'];
const PL_VISIBILITY = ['members' => 'Community members', 'public' => 'Everyone', 'private' => 'Only me'];
const PL_CONTACT_VIS = ['members' => 'Community members', 'private' => 'Only me'];
const PL_HOME_MODULES = ['matrimony' => 'Matrimony', 'jobs' => 'Jobs', 'directory' => 'Directory', 'marketplace' => 'Marketplace', 'events' => 'Events',
    'ads' => 'Advertisements', 'support' => 'Community Support', 'leadership' => 'Leadership'];
const PL_PACKAGE_MODULES = ['marketplace' => 'Marketplace', 'directory' => 'Directory', 'events' => 'Events', 'ads' => 'Advertisements',
    'support' => 'Community Support', 'matrimony' => 'Matrimony', 'jobs' => 'Jobs', 'general' => 'General'];
const PL_JOB_EXPERIENCE = ['Fresher', '0-1 years', '1-3 years', '3-5 years', '5-10 years', '10+ years'];
const PL_JOB_EMPLOYMENT = ['Full Time', 'Part Time', 'Contract', 'Internship', 'Freelance', 'Temporary'];
const PL_JOB_APP_STATUSES = ['applied', 'viewed', 'shortlisted', 'rejected', 'closed'];

/* Field: col => [label, type, options]. Types: text textarea select money int bool date time datetime email phone url image lat lng
   category subcategory parent ref hidden. Options: req, filter, private (hidden from visitors), admin (only admin edits), opts, default, help. */
$__leaderFields = [
    'leader_scope' => ['Scope', 'hidden'],
    'name' => ['Name', 'text', ['req' => 1]],
    'photo' => ['Profile photo', 'image'],
    'leadership_role' => ['Leadership role', 'text', ['req' => 1, 'filter' => 1]],
    'designation' => ['Designation', 'text'],
    'region' => ['Region / Location', 'text', ['filter' => 1]],
    'city' => ['City', 'text', ['filter' => 1]],
    'short_profile' => ['Short profile / introduction', 'textarea'],
    'phone' => ['Phone', 'phone', ['private' => 1]],
    'email' => ['Email', 'email', ['private' => 1]],
    'show_contact' => ['Show contact in app', 'bool'],
    'term_period' => ['Term / Period', 'text'],
];
$__familyFields = [
    'family_name' => ['Family name', 'text', ['req' => 1]],
    'head_name' => ['Family head', 'text', ['req' => 1]],
    'address' => ['Address', 'textarea'],
    'area' => ['Area', 'text'],
    'city' => ['City', 'text', ['filter' => 1]],
    'state' => ['State', 'text'],
    'country' => ['Country', 'text'],
    'pincode' => ['Pincode', 'text'],
    'native_place' => ['Native place', 'text'],
    'latitude' => ['Latitude', 'lat'],
    'longitude' => ['Longitude', 'lng'],
    'about' => ['About the family', 'textarea'],
    'tree_status' => ['Family tree status', 'select', ['opts' => ['none' => 'Not submitted', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'], 'admin' => 1, 'default' => 'none']],
    'tree_active' => ['Family tree visible', 'bool', ['admin' => 1, 'default' => 1]],
];

$GLOBALS['PL_ENTITIES'] = [
    'mp_listing' => [
        'table' => 'mp_listings', 'module' => 'marketplace', 'label' => 'Listing', 'plural' => 'Listings', 'icon' => 'fa-store',
        'scope' => 'mixed', 'approval' => true, 'featured' => true, 'closable' => true, 'expires' => 'expires_at', 'expiry_setting' => 'listing_expiry_days',
        'cat' => 'marketplace', 'gallery' => 10, 'extras' => true, 'api' => 'marketplace', 'user_post' => true, 'save' => true, 'enquiry' => true, 'report' => true,
        'title' => 'title', 'sub' => 'city', 'list' => ['category_id', 'price', 'listing_type', 'contact_name'],
        'search' => ['title', 'description', 'city', 'location', 'contact_name'],
        'fields' => [
            'category_id' => ['Category', 'category', ['req' => 1, 'filter' => 1]],
            'subcategory_id' => ['Subcategory', 'subcategory', ['filter' => 1]],
            'title' => ['Title', 'text', ['req' => 1]],
            'description' => ['Description', 'textarea'],
            'listing_type' => ['Listing type', 'select', ['opts' => ['Sell', 'Rent', 'Lease', 'Service', 'Wanted'], 'filter' => 1]],
            'price' => ['Price (₹)', 'money', ['filter' => 1]],
            'price_negotiable' => ['Price negotiable', 'bool'],
            'item_condition' => ['Condition', 'select', ['opts' => ['New', 'Like new', 'Used', 'Not applicable'], 'filter' => 1]],
            'location' => ['Location / Area', 'text', ['filter' => 1]],
            'city' => ['City', 'text', ['filter' => 1]],
            'state' => ['State', 'text', ['filter' => 1]],
            'pincode' => ['Pincode', 'text'],
            'contact_name' => ['Seller name', 'text'],
            'phone' => ['Seller phone', 'phone', ['private' => 1]],
            'whatsapp' => ['WhatsApp', 'phone', ['private' => 1]],
            'email' => ['Seller email', 'email', ['private' => 1]],
            'expires_at' => ['Expires on', 'datetime', ['admin' => 1, 'help' => 'Filled automatically when approved.']],
        ],
    ],
    'member' => [
        'table' => 'members', 'module' => 'members', 'label' => 'Member', 'plural' => 'Members', 'icon' => 'fa-id-card',
        'scope' => 'community', 'approval' => true, 'extras' => true, 'title' => 'full_name', 'sub' => 'city', 'thumb' => 'photo',
        'list' => ['gender', 'phone', 'occupation'], 'search' => ['full_name', 'phone', 'email', 'city', 'occupation'],
        'children' => [['family', 'user_id', 'user_id']],
        'fields' => [
            'full_name' => ['Full name', 'text', ['req' => 1]],
            'gender' => ['Gender', 'select', ['opts' => PL_GENDERS, 'filter' => 1]],
            'dob' => ['Date of birth', 'date'],
            'anniversary' => ['Wedding anniversary', 'date'],
            'marital_status' => ['Marital status', 'select', ['opts' => PL_MARITAL, 'filter' => 1]],
            'phone' => ['Mobile', 'phone', ['private' => 1]],
            'email' => ['Email', 'email', ['private' => 1]],
            'education' => ['Education', 'text', ['filter' => 1]],
            'occupation' => ['Occupation', 'text', ['filter' => 1]],
            'address' => ['Address', 'textarea', ['private' => 1]],
            'area' => ['Area', 'text'],
            'city' => ['City', 'text', ['filter' => 1]],
            'state' => ['State', 'text', ['filter' => 1]],
            'country' => ['Country', 'text'],
            'pincode' => ['Pincode', 'text'],
            'photo' => ['Photo', 'image'],
            'profile_visibility' => ['Profile visibility', 'select', ['opts' => PL_VISIBILITY, 'default' => 'members']],
            'contact_visibility' => ['Contact visibility', 'select', ['opts' => PL_CONTACT_VIS, 'default' => 'members']],
            'family_visibility' => ['Family information visibility', 'select', ['opts' => PL_CONTACT_VIS, 'default' => 'members']],
        ],
    ],
    'family' => [
        'table' => 'families', 'module' => 'members', 'label' => 'Family', 'plural' => 'Families', 'icon' => 'fa-people-roof',
        'scope' => 'community', 'approval' => true, 'extras' => true, 'title' => 'family_name', 'sub' => 'city', 'list' => ['head_name', 'native_place', 'tree_status'],
        'search' => ['family_name', 'head_name', 'city', 'native_place'], 'children' => [['family_member', 'family_id'], ['tree_relation', 'family_id']],
        'fields' => $__familyFields,
    ],
    'family_tree' => [
        'table' => 'families', 'module' => 'family_tree', 'label' => 'Family Tree', 'plural' => 'Family Trees', 'icon' => 'fa-sitemap',
        'scope' => 'community', 'statuses' => ['pending', 'approved', 'rejected'], 'status_col' => 'tree_status', 'active_col' => 'tree_active',
        'base_where' => "t.tree_status IN ('pending','approved','rejected')", 'no_create' => true, 'enquiry' => true, 'empty_hint' => 'A family tree appears here after the family sends it for review (Family Tree page > Submit Details). Registered families are under Members & Family > Families.',
        'title' => 'family_name', 'sub' => 'city', 'list' => ['head_name', 'native_place'], 'search' => ['family_name', 'head_name', 'city', 'native_place'],
        'children' => [['family_member', 'family_id'], ['tree_relation', 'family_id']], 'fields' => $__familyFields,
    ],
    'family_member' => [
        'table' => 'family_members', 'module' => 'members', 'label' => 'Family Member', 'plural' => 'Family Members', 'icon' => 'fa-user-group',
        'scope' => 'community', 'approval' => true, 'extras' => true, 'parent' => ['family', 'family_id'], 'title' => 'full_name', 'sub' => 'relationship', 'thumb' => 'photo',
        'list' => ['family_id', 'relationship', 'gender', 'life_status'], 'search' => ['full_name', 'phone', 'occupation'],
        'fields' => [
            'family_id' => ['Family', 'parent', ['req' => 1]],
            'full_name' => ['Full name', 'text', ['req' => 1]],
            'relationship' => ['Relationship to family head', 'select', ['opts' => PL_RELATIONS, 'req' => 1, 'filter' => 1]],
            'gender' => ['Gender', 'select', ['opts' => PL_GENDERS]],
            'dob' => ['Date of birth', 'date'],
            'anniversary' => ['Wedding anniversary', 'date'],
            'marital_status' => ['Marital status', 'select', ['opts' => PL_MARITAL]],
            'education' => ['Education', 'text'],
            'occupation' => ['Occupation', 'text'],
            'phone' => ['Mobile', 'phone', ['private' => 1]],
            'email' => ['Email', 'email', ['private' => 1]],
            'photo' => ['Photo', 'image'],
            'is_head' => ['Family head', 'bool'],
            'life_status' => ['Member status', 'select', ['opts' => ['Living', 'Deceased'], 'default' => 'Living']],
        ],
    ],
    'tree_relation' => [
        'table' => 'family_tree_relations', 'module' => 'family_tree', 'label' => 'Relation', 'plural' => 'Relations', 'icon' => 'fa-diagram-project',
        'scope' => 'community', 'approval' => true, 'parent' => ['family', 'family_id'], 'extras' => true, 'files' => 3,
        'title' => 'related_name', 'sub' => 'relation', 'list' => ['family_id', 'person_name', 'relation'], 'search' => ['person_name', 'related_name'],
        'fields' => [
            'family_id' => ['Family', 'parent', ['req' => 1]],
            'person_member_id' => ['Person (family member ID)', 'ref'],
            'person_name' => ['Person', 'text', ['req' => 1]],
            'relation' => ['Relation', 'select', ['opts' => PL_TREE_RELATIONS, 'req' => 1, 'filter' => 1]],
            'related_member_id' => ['Related family member ID', 'ref'],
            'related_name' => ['Related person name', 'text', ['req' => 1]],
            'related_gender' => ['Related person gender', 'select', ['opts' => PL_GENDERS]],
            'birth_year' => ['Birth year', 'int'],
            'notes' => ['Notes', 'textarea'],
        ],
    ],
    'directory' => [
        'table' => 'directory_profiles', 'module' => 'directory', 'label' => 'Profile', 'plural' => 'Directory Profiles', 'icon' => 'fa-address-book',
        'scope' => 'community', 'approval' => true, 'featured' => true, 'cat' => 'directory', 'gallery' => 8, 'extras' => true,
        'api' => 'directory', 'user_post' => true, 'save' => true, 'enquiry' => true, 'report' => true,
        'title' => 'name', 'sub' => 'business_name', 'thumb' => 'logo', 'list' => ['profile_type', 'category_id', 'city', 'phone'],
        'search' => ['name', 'business_name', 'description', 'services', 'city', 'area'],
        'fields' => [
            'profile_type' => ['Profile type', 'select', ['opts' => ['Professional', 'Business'], 'req' => 1, 'filter' => 1]],
            'name' => ['Name', 'text', ['req' => 1]],
            'business_name' => ['Professional / Business name', 'text'],
            'category_id' => ['Category', 'category', ['req' => 1, 'filter' => 1]],
            'subcategory_id' => ['Subcategory', 'subcategory', ['filter' => 1]],
            'description' => ['Description', 'textarea'],
            'experience_years' => ['Experience (years)', 'int'],
            'qualification' => ['Qualification', 'text'],
            'services' => ['Services', 'textarea'],
            'address' => ['Address', 'textarea'],
            'area' => ['Area', 'text', ['filter' => 1]],
            'city' => ['City', 'text', ['filter' => 1]],
            'state' => ['State', 'text', ['filter' => 1]],
            'pincode' => ['Pincode', 'text'],
            'latitude' => ['Latitude', 'lat'],
            'longitude' => ['Longitude', 'lng'],
            'service_radius_km' => ['Service radius (km)', 'int'],
            'near_me_visible' => ['Show in Near Me', 'bool', ['admin' => 1, 'default' => 1]],
            'phone' => ['Phone', 'phone', ['private' => 1]],
            'whatsapp' => ['WhatsApp', 'phone', ['private' => 1]],
            'email' => ['Email', 'email', ['private' => 1]],
            'website' => ['Website', 'url'],
            'logo' => ['Logo / Photo', 'image'],
        ],
    ],
    'event' => [
        'table' => 'events', 'module' => 'events', 'label' => 'Event', 'plural' => 'Events', 'icon' => 'fa-calendar-days',
        'scope' => 'mixed', 'approval' => true, 'featured' => true, 'cat' => 'events', 'gallery' => 6, 'extras' => true,
        'api' => 'events', 'user_post' => true, 'save' => true, 'enquiry' => true, 'report' => true,
        'title' => 'title', 'sub' => 'venue', 'thumb' => 'image', 'list' => ['event_date', 'start_time', 'city', 'organizer'],
        'search' => ['title', 'description', 'venue', 'city', 'organizer'], 'public_order' => 't.event_date ASC, t.start_time ASC',
        'tabs' => ['upcoming' => ['Upcoming', 't.event_date >= CURDATE()'], 'completed' => ['Completed', 't.event_date < CURDATE()']],
        'fields' => [
            'title' => ['Event title', 'text', ['req' => 1]],
            'category_id' => ['Category', 'category', ['filter' => 1]],
            'description' => ['Description', 'textarea'],
            'event_date' => ['Event date', 'date', ['req' => 1, 'filter' => 1]],
            'end_date' => ['End date', 'date'],
            'start_time' => ['Start time', 'time'],
            'end_time' => ['End time', 'time'],
            'venue' => ['Venue', 'text'],
            'address' => ['Address', 'textarea'],
            'city' => ['City', 'text', ['filter' => 1]],
            'state' => ['State', 'text'],
            'organizer' => ['Organizer', 'text'],
            'contact_phone' => ['Contact phone', 'phone', ['private' => 1]],
            'contact_email' => ['Contact email', 'email', ['private' => 1]],
            'registration_link' => ['Registration link', 'url'],
            'registration_details' => ['Registration details', 'textarea'],
            'live_link' => ['External live program link', 'url'],
            'max_registrations' => ['Maximum registrations', 'int'],
            'image' => ['Event banner', 'image'],
        ],
    ],
    'ad' => [
        'table' => 'advertisements', 'module' => 'events', 'label' => 'Advertisement', 'plural' => 'Advertisements', 'icon' => 'fa-rectangle-ad',
        'scope' => 'mixed', 'approval' => true, 'expires' => 'end_date', 'live_where' => '(t.start_date IS NULL OR t.start_date <= CURDATE())',
        'api' => 'ads', 'user_post' => true, 'report' => true, 'extras' => true,
        'title' => 'title', 'sub' => 'advertiser', 'thumb' => 'banner', 'list' => ['advertiser', 'start_date', 'end_date', 'payment_status'],
        'search' => ['title', 'advertiser', 'description'],
        'fields' => [
            'title' => ['Title', 'text', ['req' => 1]],
            'advertiser' => ['Advertiser', 'text', ['req' => 1]],
            'description' => ['Description', 'textarea'],
            'banner' => ['Banner / Image', 'image', ['req' => 1]],
            'link' => ['Link', 'url'],
            'placement' => ['Placement', 'select', ['opts' => ['Home banner', 'Module banner', 'Listing sidebar', 'Popup'], 'filter' => 1]],
            'start_date' => ['Start date', 'date'],
            'end_date' => ['End date', 'date'],
            'contact_phone' => ['Contact phone', 'phone', ['private' => 1]],
            'contact_email' => ['Contact email', 'email', ['private' => 1]],
            'package_id' => ['Package', 'ref'],
            'payment_status' => ['Payment', 'select', ['opts' => ['not_required' => 'Not required', 'pending' => 'Pending', 'paid' => 'Paid'], 'admin' => 1, 'default' => 'not_required']],
        ],
    ],
    // Jobs: ONE table for Community and Global jobs (visibility_type = community | global, community_id = the posting community).
    'job' => [
        'table' => 'jobs', 'module' => 'jobs', 'label' => 'Job', 'plural' => 'Jobs', 'icon' => 'fa-briefcase',
        'scope' => 'mixed', 'approval' => true, 'featured' => true, 'closable' => true, 'expires' => 'closing_date',
        'cat' => 'jobs', 'api' => 'jobs', 'user_post' => true, 'save' => true, 'report' => true, 'contact_rule' => ['show_contact', 1], 'extras' => true,
        'title' => 'job_title', 'sub' => 'company_name', 'thumb' => 'company_logo', 'list' => ['category_id', 'employment_type', 'location', 'closing_date'],
        'search' => ['job_title', 'company_name', 'description', 'required_skills', 'qualification', 'location', 'city'], 'public_order' => 't.priority DESC, t.id DESC',
        'tabs' => ['closing_soon' => ['Closing in 7 days', "t.status='approved' AND t.closing_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY"]],
        'children' => [['job_application', 'job_id']],
        'fields' => [
            'job_title' => ['Job title', 'text', ['req' => 1, 'filter' => 1]],
            'company_name' => ['Company / Organisation', 'text', ['req' => 1, 'filter' => 1]],
            'category_id' => ['Category', 'category', ['req' => 1, 'filter' => 1]],
            'description' => ['Job description', 'textarea', ['req' => 1]],
            'responsibilities' => ['Responsibilities', 'textarea'],
            'required_skills' => ['Required skills', 'textarea'],
            'qualification' => ['Qualification', 'text', ['filter' => 1]],
            'experience' => ['Experience', 'select', ['opts' => PL_JOB_EXPERIENCE, 'filter' => 1]],
            'openings' => ['Number of openings', 'int', ['default' => 1]],
            'salary_min' => ['Salary from (₹)', 'money'],
            'salary_max' => ['Salary up to (₹)', 'money'],
            'salary_period' => ['Salary period', 'select', ['opts' => ['month' => 'Per month', 'year' => 'Per year (CTC)', 'day' => 'Per day', 'hour' => 'Per hour'], 'default' => 'month']],
            'employment_type' => ['Employment type', 'select', ['opts' => PL_JOB_EMPLOYMENT, 'req' => 1, 'filter' => 1, 'default' => 'Full Time']],
            'work_mode' => ['Work mode', 'select', ['opts' => ['On-site', 'Remote', 'Hybrid'], 'filter' => 1, 'default' => 'On-site']],
            'location' => ['Location / Area', 'text'],
            'city' => ['City', 'text', ['filter' => 1]],
            'state' => ['State', 'text'],
            'joining' => ['Joining availability', 'select', ['opts' => ['Immediate', 'Within 15 days', 'Within 30 days', 'Within 60 days', 'Flexible']]],
            'application_start_date' => ['Applications open from', 'date'],
            'closing_date' => ['Closing date', 'date', ['help' => 'The job is hidden from the app after this date.']],
            'contact_person' => ['Contact person', 'text'],
            'application_email' => ['Application email', 'email', ['private' => 1]],
            'whatsapp' => ['WhatsApp number', 'phone', ['private' => 1]],
            'apply_via' => ['Also receive applications by', 'select', ['opts' => ['in_app' => 'In-app only', 'email' => 'Email', 'whatsapp' => 'WhatsApp', 'both' => 'Email and WhatsApp'], 'default' => 'in_app',
                'help' => 'In-app applications (with resume) are always on. A WhatsApp link shows the number to the applicant.']],
            'show_contact' => ['Show email / WhatsApp on the job page', 'bool', ['help' => 'Off: shown only to members after they apply.']],
            'company_logo' => ['Company logo', 'image'],
        ],
    ],
    'job_application' => [
        'table' => 'jobs_applications', 'module' => 'jobs', 'label' => 'Application', 'plural' => 'Job Applications', 'icon' => 'fa-file-signature',
        'scope' => 'community', 'statuses' => PL_JOB_APP_STATUSES, 'parent' => ['job', 'job_id'], 'code' => ['application_code', 'PL-JOB-'],
        'title' => 'applicant_name', 'sub' => 'application_code', 'list' => ['job_id', 'apply_method', 'phone', 'email'],
        'search' => ['applicant_name', 'email', 'phone', 'current_location'],
        'fields' => [
            'application_code' => ['Application ID', 'hidden'],
            'job_id' => ['Job', 'parent', ['req' => 1]],
            'applicant_name' => ['Applicant name', 'text', ['req' => 1]],
            'email' => ['Email', 'email', ['private' => 1]],
            'phone' => ['Phone', 'phone', ['private' => 1]],
            'total_experience' => ['Experience', 'text'],
            'current_location' => ['Current location', 'text'],
            'cover_letter' => ['Cover letter / message', 'textarea'],
            'apply_method' => ['Application method', 'select', ['opts' => ['in_app' => 'In-app', 'email' => 'Email', 'whatsapp' => 'WhatsApp'], 'filter' => 1, 'default' => 'in_app']],
            'resume_url' => ['Resume', 'url', ['admin' => 1, 'help' => 'Filled automatically when the applicant attaches a resume.']],
        ],
    ],
    'support' => [
        'table' => 'support_requests', 'module' => 'support', 'label' => 'Support Request', 'plural' => 'Support Requests', 'icon' => 'fa-hand-holding-heart',
        'scope' => 'community', 'statuses' => ['pending', 'approved', 'in_progress', 'resolved', 'rejected', 'closed'], 'public_statuses' => ['approved', 'in_progress'],
        'cat' => 'support', 'files' => 5, 'code' => ['request_code', 'PL-SUP-'], 'api' => 'support', 'user_post' => true, 'contact_rule' => ['contact_visibility', 'public'], 'extras' => true,
        'title' => 'title', 'sub' => 'request_code', 'list' => ['category_id', 'urgency', 'required_by', 'contact_name'],
        'search' => ['title', 'description', 'request_code', 'contact_name', 'city'], 'children' => [['support_offer', 'request_id']],
        'fields' => [
            'request_code' => ['Request ID', 'hidden'],
            'category_id' => ['Assistance type', 'category', ['req' => 1, 'filter' => 1]],
            'subcategory_id' => ['Assistance subtype', 'subcategory', ['filter' => 1]],
            'title' => ['Title', 'text', ['req' => 1]],
            'description' => ['Description', 'textarea', ['req' => 1]],
            'urgency' => ['Urgency', 'select', ['opts' => ['Low', 'Medium', 'High', 'Critical'], 'filter' => 1, 'default' => 'Medium']],
            'amount_required' => ['Amount required (₹, if financial)', 'money'],
            'required_by' => ['Required by', 'date'],
            'contact_name' => ['Contact name', 'text'],
            'phone' => ['Contact phone', 'phone', ['private' => 1]],
            'email' => ['Contact email', 'email', ['private' => 1]],
            'city' => ['City', 'text', ['filter' => 1]],
            'location' => ['Location', 'text'],
            'contact_visibility' => ['Who can see contact details', 'select', ['opts' => ['admin' => 'Admin only (admin connects helpers)', 'public' => 'Community members'], 'default' => 'admin']],
            'assigned_to' => ['Assigned to', 'text', ['admin' => 1]],
        ],
    ],
    'support_offer' => [
        'table' => 'support_offers', 'module' => 'support', 'label' => 'Help Offer', 'plural' => 'Help Offers', 'icon' => 'fa-handshake-angle',
        'scope' => 'community', 'statuses' => ['offered', 'connected', 'closed'], 'public_statuses' => ['offered', 'connected'], 'parent' => ['support', 'request_id'],
        'title' => 'name', 'sub' => 'offer_type', 'list' => ['request_id', 'offer_type', 'phone', 'email'], 'search' => ['name', 'phone', 'email', 'message'],
        'fields' => [
            'request_id' => ['Support request', 'parent', ['req' => 1]],
            'name' => ['Name', 'text', ['req' => 1]],
            'phone' => ['Phone', 'phone', ['private' => 1]],
            'email' => ['Email', 'email', ['private' => 1]],
            'offer_type' => ['Type of help', 'select', ['opts' => ['Financial', 'Volunteer', 'Guidance', 'Material / Supplies', 'Medical', 'Other']]],
            'message' => ['Message', 'textarea'],
        ],
    ],
    'community_leader' => [
        'table' => 'leaders', 'module' => 'leadership', 'label' => 'Leader', 'plural' => 'Community Leaders', 'icon' => 'fa-user-tie',
        'scope' => 'community', 'fixed' => ['leader_scope' => 'community'], 'ordered' => true, 'api' => 'leaders', 'contact_rule' => ['show_contact', 1],
        'title' => 'name', 'sub' => 'leadership_role', 'thumb' => 'photo', 'list' => ['designation', 'city', 'term_period'],
        'search' => ['name', 'leadership_role', 'designation', 'region', 'city'], 'fields' => $__leaderFields,
    ],
    'global_leader' => [
        'table' => 'leaders', 'module' => 'global_leadership', 'label' => 'Global Leader', 'plural' => 'Global Leaders', 'icon' => 'fa-globe',
        'scope' => 'global', 'fixed' => ['leader_scope' => 'global'], 'ordered' => true, 'api' => 'global_leaders', 'contact_rule' => ['show_contact', 1],
        'title' => 'name', 'sub' => 'leadership_role', 'thumb' => 'photo', 'list' => ['designation', 'region'],
        'search' => ['name', 'leadership_role', 'designation', 'region'],
        'fields' => array_diff_key($__leaderFields, ['city' => 1, 'term_period' => 1]),
    ],
    'package' => [
        'table' => 'packages', 'module' => 'payments', 'label' => 'Package', 'plural' => 'Packages', 'icon' => 'fa-gift',
        'scope' => 'mixed', 'ordered' => true, 'title' => 'name', 'sub' => 'module_key', 'list' => ['module_key', 'price', 'validity_days'], 'search' => ['name', 'description'],
        'fields' => [
            'module_key' => ['Module', 'select', ['opts' => PL_PACKAGE_MODULES, 'req' => 1, 'filter' => 1]],
            'name' => ['Package name', 'text', ['req' => 1]],
            'price' => ['Price (₹)', 'money', ['req' => 1]],
            'validity_days' => ['Validity (days)', 'int', ['req' => 1]],
            'description' => ['Description', 'textarea'],
            'features' => ['Features (one per line)', 'textarea'],
            'job_posts' => ['Jobs: number of global job posts', 'int', ['help' => 'Jobs packages only. Each global job a member posts uses one.']],
            'featured_listing' => ['Jobs: featured listing', 'bool', ['help' => 'Jobs posted with this package are marked featured.']],
            'priority_visibility' => ['Jobs: priority visibility', 'bool', ['help' => 'Jobs posted with this package are listed above normal jobs.']],
            'contact_views' => ['Matrimony: contact requests allowed', 'int', ['help' => 'Matrimony packages only. Leave empty for unlimited.']],
        ],
    ],
];
unset($__leaderFields, $__familyFields);

$GLOBALS['PL_CAT_SEED'] = [
    'marketplace' => [
        'Property' => ['Apartment / Flat', 'Independent House / Villa', 'Plot / Land', 'Commercial Space', 'PG / Hostel'],
        'Cars' => ['Hatchback', 'Sedan', 'SUV / MUV', 'Luxury', 'Commercial Vehicle'],
        'Bikes' => ['Motorcycle', 'Scooter', 'Electric', 'Bicycle'],
        'Electronics' => ['Mobiles', 'Laptops & Computers', 'TV & Audio', 'Cameras', 'Home Appliances'],
        'Furniture/Home' => ['Sofa & Seating', 'Beds & Wardrobes', 'Dining', 'Home Decor', 'Kitchen'],
        'Fashion' => ['Men', 'Women', 'Kids', 'Jewellery & Accessories'],
        'Books' => ['Academic', 'Competitive Exams', 'Fiction', 'Non-fiction'],
        'Sports/Hobbies' => ['Fitness', 'Sports Equipment', 'Musical Instruments', 'Hobbies & Collectibles'],
        'Services' => ['Home Services', 'Tuition & Classes', 'Repairs', 'Events & Catering'],
        'Other' => [],
    ],
    'directory' => [
        'Healthcare' => ['Doctor', 'Dentist', 'Physiotherapist', 'Hospital / Clinic', 'Pharmacy', 'Diagnostics'],
        'Legal' => ['Advocate', 'Notary', 'Legal Consultant'],
        'Finance / CA' => ['Chartered Accountant', 'Tax Consultant', 'Insurance', 'Financial Planner'],
        'IT & Technology' => ['Software Development', 'Web & App Design', 'IT Support', 'Digital Services'],
        'Education' => ['Tutor', 'Coaching Centre', 'School', 'Training Institute'],
        'Interior Design' => [], 'Real Estate' => [], 'Manufacturing' => [], 'Consulting' => [], 'Marketing' => [], 'Construction' => [],
        'Beauty & Wellness' => [], 'Event Services' => [], 'Home Services' => [], 'Retail' => [], 'Other' => [],
    ],
    'events' => ['Community Meet' => [], 'Cultural' => [], 'Educational' => [], 'Sports' => [], 'Business & Networking' => [], 'Health Camp' => [],
        'Charity' => [], 'Celebration' => [], 'Live Program' => [], 'Other' => []],
    'support' => [
        'Education' => ['Tuition fees', 'Books & supplies', 'Scholarship guidance'],
        'Emergency' => ['Accident', 'Natural disaster', 'Blood requirement'],
        'Medical' => ['Surgery', 'Treatment', 'Medicines'],
        'Financial Assistance' => ['Livelihood', 'Housing', 'Other financial need'],
        'General Assistance' => ['Guidance', 'Volunteers needed', 'Other'],
    ],
    'jobs' => ['IT & Software' => [], 'Sales & Marketing' => [], 'Banking & Finance' => [], 'Healthcare' => [], 'Education' => [], 'Engineering' => [], 'HR' => [],
        'Administration' => [], 'Hospitality' => [], 'Government' => [], 'Work From Home' => [], 'Internship' => [], 'Other' => []],
];

$GLOBALS['PL_SETTINGS'] = [
    'device_limit' => ['Maximum active devices per account', 3, 'int'],
    'listing_expiry_days' => ['Marketplace listing validity after approval (days)', 60, 'int'],
    'near_me_enabled' => ['Near Me enabled in the app', 1, 'bool'],
    'near_me_default_radius' => ['Near Me default radius (km)', 10, 'int'],
    'near_me_max_radius' => ['Near Me maximum radius (km)', 50, 'int'],
    'near_me_categories' => ['Near Me categories (none ticked = all categories)', '', 'cats:directory'],
    'max_upload_mb' => ['Maximum upload size (MB)', 5, 'int'],
    'ads_require_payment' => ['Advertisements need a paid package before approval', 0, 'bool'],
    'sms_enabled' => ['Send SMS for major account / support changes', 0, 'bool'],
    'jobs_global_requires_package' => ['Jobs: members need a Global Job Package to post a global job', 1, 'bool'],
    'jobs_default_validity_days' => ['Jobs: validity when no closing date is given (days)', 30, 'int'],
    'jobs_max_validity_days' => ['Jobs: latest closing date a member can set (days from today)', 90, 'int'],
    'jobs_resume_required' => ['Jobs: resume is required for in-app applications', 1, 'bool'],
    'jobs_closing_notice_days' => ['Jobs: remind the poster this many days before closing', 2, 'int'],
];

/* API actions that also work before a community is chosen (used by includes/ext/*.php) */
function pl_action_nocomm(string $name): void { if (isset($GLOBALS['PL_ACTIONS'][$name])) $GLOBALS['PL_ACTIONS'][$name]['nocomm'] = true; }

/* ---------- registry access ---------- */

function pl_entity(string $key): ?array {
    static $cache = [];
    if (isset($cache[$key])) return $cache[$key];
    $E = $GLOBALS['PL_ENTITIES'][$key] ?? null;
    if (!$E) return null;
    $E['key'] = $key;
    $E += ['scope' => 'community', 'approval' => false, 'featured' => false, 'closable' => false, 'expires' => null, 'cat' => null, 'gallery' => 0, 'files' => 0,
        'extras' => false, 'api' => null, 'user_post' => false, 'save' => false, 'enquiry' => false, 'report' => false, 'ordered' => false, 'fixed' => [],
        'children' => [], 'parent' => null, 'thumb' => null, 'sub' => null, 'list' => [], 'search' => [], 'tabs' => [], 'code' => null,
        'status_col' => 'status', 'active_col' => 'is_active', 'contact_rule' => null, 'no_create' => false];
    if (empty($E['statuses'])) $E['statuses'] = $E['approval'] ? array_merge(['pending', 'approved', 'rejected'], $E['closable'] ? ['closed'] : []) : [];
    $E['public_statuses'] = $E['public_statuses'] ?? ($E['statuses'] ? ['approved'] : []);
    $fields = [];
    foreach ($E['fields'] as $col => $f) $fields[$col] = ['label' => $f[0], 'type' => $f[1]] + ($f[2] ?? []);
    $E['fields'] = $fields;
    return $cache[$key] = $E;
}

function pl_entity_keys(?string $module = null): array {
    return array_values(array_filter(array_keys($GLOBALS['PL_ENTITIES']), fn($k) => $module === null || $GLOBALS['PL_ENTITIES'][$k]['module'] === $module));
}

function pl_status_label(string $s): string { return ucwords(str_replace('_', ' ', $s)); }

function pl_opts(array $f): array {
    $o = $f['opts'] ?? [];
    return array_keys($o) === range(0, count($o) - 1) ? array_combine($o, $o) : $o;
}

/* ---------- schema ---------- */

function pl_field_sql(string $type): string {
    return [
        'text' => 'VARCHAR(255) NULL', 'textarea' => 'TEXT NULL', 'select' => 'VARCHAR(60) NULL', 'money' => 'DECIMAL(12,2) NULL', 'int' => 'INT NULL',
        'bool' => 'TINYINT DEFAULT 0', 'date' => 'DATE NULL', 'time' => 'TIME NULL', 'datetime' => 'DATETIME NULL', 'email' => 'VARCHAR(160) NULL',
        'phone' => 'VARCHAR(30) NULL', 'url' => 'VARCHAR(500) NULL', 'image' => 'VARCHAR(500) NULL', 'lat' => 'DECIMAL(10,7) NULL', 'lng' => 'DECIMAL(10,7) NULL',
        'category' => 'INT NULL', 'subcategory' => 'INT NULL', 'parent' => 'INT NULL', 'ref' => 'INT NULL', 'hidden' => 'VARCHAR(60) NULL',
    ][$type] ?? 'VARCHAR(255) NULL';
}

function pl_register_module_schema(): void {
    $tables = [];
    foreach (array_keys($GLOBALS['PL_ENTITIES']) as $k) {
        $E = pl_entity($k);
        $tables[$E['table']] = ($tables[$E['table']] ?? []) + array_map(fn($f) => pl_field_sql($f['type']), $E['fields']);
        foreach ($E['fields'] as $col => $f) if ($f['type'] === 'bool' && isset($f['default'])) $tables[$E['table']][$col] = 'TINYINT DEFAULT ' . (int)$f['default'];
        if ($E['status_col'] !== 'status') unset($tables[$E['table']][$E['status_col']]);
        if ($E['active_col'] !== 'is_active') unset($tables[$E['table']][$E['active_col']]);
    }
    $tables['families']['tree_status'] = "VARCHAR(20) DEFAULT 'none'";
    $tables['families']['tree_active'] = 'TINYINT DEFAULT 1';
    foreach ($tables as $t => $cols) {
        $common = ['community_id' => 'INT NULL', 'visibility_type' => "VARCHAR(20) DEFAULT 'community'", 'user_id' => 'INT NULL', 'status' => "VARCHAR(20) DEFAULT 'pending'",
            'is_active' => 'TINYINT DEFAULT 1', 'is_featured' => 'TINYINT DEFAULT 0', 'sort_order' => 'INT DEFAULT 0', 'views' => 'INT DEFAULT 0', 'details' => 'LONGTEXT NULL',
            'admin_notes' => 'TEXT NULL', 'created_by' => 'INT NULL', 'approved_by' => 'INT NULL', 'approved_at' => 'DATETIME NULL', 'closed_at' => 'DATETIME NULL'];
        $all = $common + $cols;
        $sql = "CREATE TABLE IF NOT EXISTS $t (id INT AUTO_INCREMENT PRIMARY KEY";
        foreach ($all as $c => $type) $sql .= ", $c $type";
        $sql .= ', created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,'
            . ' KEY idx_comm (community_id, status), KEY idx_user (user_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';
        pl_need_table($t, $sql);
        foreach ($all as $c => $type) pl_need_column($t, $c, $type);
    }
    $common = ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4';
    pl_need_table('categories', 'CREATE TABLE IF NOT EXISTS categories (id INT AUTO_INCREMENT PRIMARY KEY, module VARCHAR(40) NOT NULL, parent_id INT NULL, name VARCHAR(120) NOT NULL,
        slug VARCHAR(140) NULL, icon VARCHAR(60) NULL, sort_order INT DEFAULT 0, is_active TINYINT DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, KEY idx_mod (module, parent_id))' . $common);
    pl_need_table('media', 'CREATE TABLE IF NOT EXISTS media (id INT AUTO_INCREMENT PRIMARY KEY, entity VARCHAR(60) NOT NULL, entity_id INT NOT NULL, kind VARCHAR(10) DEFAULT \'image\',
        url VARCHAR(500) NOT NULL, name VARCHAR(200) NULL, is_primary TINYINT DEFAULT 0, sort_order INT DEFAULT 0, user_id INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        KEY idx_ent (entity, entity_id))' . $common);
    pl_need_table('favourites', 'CREATE TABLE IF NOT EXISTS favourites (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, entity VARCHAR(60) NOT NULL, entity_id INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uq_fav (user_id, entity, entity_id), KEY idx_ent (entity, entity_id))' . $common);
    pl_need_table('enquiries', 'CREATE TABLE IF NOT EXISTS enquiries (id INT AUTO_INCREMENT PRIMARY KEY, entity VARCHAR(60) NOT NULL, entity_id INT NOT NULL, community_id INT NULL,
        user_id INT NULL, owner_user_id INT NULL, kind VARCHAR(20) DEFAULT \'enquiry\', name VARCHAR(120) NULL, phone VARCHAR(30) NULL, email VARCHAR(160) NULL, message TEXT NULL,
        status VARCHAR(20) DEFAULT \'new\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP, KEY idx_ent (entity, entity_id), KEY idx_owner (owner_user_id))' . $common);
    pl_need_table('content_reports', 'CREATE TABLE IF NOT EXISTS content_reports (id INT AUTO_INCREMENT PRIMARY KEY, entity VARCHAR(60) NOT NULL, entity_id INT NOT NULL, community_id INT NULL,
        user_id INT NULL, reason VARCHAR(255) NULL, details TEXT NULL, action_type VARCHAR(20) DEFAULT \'report\', status VARCHAR(20) DEFAULT \'open\', admin_notes TEXT NULL,
        reviewed_by INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, KEY idx_ent (entity, entity_id), KEY idx_status (status))' . $common);
    pl_need_table('audit_log', 'CREATE TABLE IF NOT EXISTS audit_log (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NULL, community_id INT NULL, action VARCHAR(40) NOT NULL,
        entity VARCHAR(60) NULL, entity_id INT NULL, details TEXT NULL, ip VARCHAR(45) NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, KEY idx_ent (entity, entity_id), KEY idx_created (created_at))' . $common);
    pl_need_table('settings', 'CREATE TABLE IF NOT EXISTS settings (k VARCHAR(80) PRIMARY KEY, v TEXT NULL, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)' . $common);
    pl_need_table('user_notifications', 'CREATE TABLE IF NOT EXISTS user_notifications (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NULL, community_id INT NULL, title VARCHAR(160) NOT NULL,
        message TEXT NULL, type VARCHAR(30) DEFAULT \'general\', entity VARCHAR(60) NULL, entity_id INT NULL, is_read TINYINT DEFAULT 0, pushed INT DEFAULT 0, created_by INT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP, KEY idx_user (user_id, is_read), KEY idx_comm (community_id))' . $common);
    pl_need_table('transactions', 'CREATE TABLE IF NOT EXISTS transactions (id INT AUTO_INCREMENT PRIMARY KEY, txn_code VARCHAR(30) NULL, user_id INT NOT NULL, community_id INT NULL,
        module_key VARCHAR(30) NULL, package_id INT NULL, package_name VARCHAR(120) NULL, ref_entity VARCHAR(60) NULL, ref_id INT NULL, amount DECIMAL(12,2) NOT NULL,
        currency VARCHAR(3) DEFAULT \'INR\', status VARCHAR(20) DEFAULT \'created\', razorpay_order_id VARCHAR(60) NULL, razorpay_payment_id VARCHAR(60) NULL,
        razorpay_signature VARCHAR(160) NULL, method VARCHAR(30) NULL, refund_status VARCHAR(20) NULL, refund_amount DECIMAL(12,2) NULL, error_text VARCHAR(255) NULL,
        raw LONGTEXT NULL, paid_at DATETIME NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        UNIQUE KEY uq_order (razorpay_order_id), KEY idx_user (user_id), KEY idx_status (status))' . $common);
    pl_need_table('user_packages', 'CREATE TABLE IF NOT EXISTS user_packages (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, community_id INT NULL, package_id INT NOT NULL,
        module_key VARCHAR(30) NULL, transaction_id INT NULL, starts_at DATETIME NOT NULL, expires_at DATETIME NOT NULL, status VARCHAR(20) DEFAULT \'active\',
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uq_txn (transaction_id), KEY idx_user (user_id, module_key))' . $common);
    foreach (['status' => "VARCHAR(20) DEFAULT 'active'", 'status_reason' => 'VARCHAR(255) NULL', 'phone_verified' => 'TINYINT DEFAULT 0', 'email_verified' => 'TINYINT DEFAULT 0',
        'last_login_at' => 'DATETIME NULL', 'delete_requested_at' => 'DATETIME NULL', 'delete_reason' => 'VARCHAR(255) NULL', 'prefs' => 'LONGTEXT NULL',
        'gender' => 'VARCHAR(20) NULL', 'dob' => 'DATE NULL', 'city' => 'VARCHAR(80) NULL', 'state' => 'VARCHAR(80) NULL', 'country' => 'VARCHAR(80) NULL',
        'about' => 'TEXT NULL', 'photo' => 'VARCHAR(500) NULL'] as $c => $t) pl_need_column('users', $c, $t);
    foreach (['banner' => 'VARCHAR(500) NULL', 'welcome_text' => 'TEXT NULL', 'home_modules' => 'TEXT NULL', 'about_banner' => 'VARCHAR(500) NULL'] as $c => $t) pl_need_column('communities', $c, $t);
}
pl_register_module_schema();

/* ---------- settings, audit, community names ---------- */

function pl_setting(string $k) {
    static $all = null;
    if ($all === null) { try { $all = array_column(rows('SELECT k, v FROM settings'), 'v', 'k'); } catch (Throwable $e) { $all = []; } }
    $def = $GLOBALS['PL_SETTINGS'][$k] ?? [null, null, 'text'];
    $v = $all[$k] ?? $def[1];
    return in_array($def[2], ['int', 'bool'], true) ? (int)$v : $v;
}

function pl_setting_set(string $k, $v): void {
    db()->prepare('INSERT INTO settings (k, v) VALUES (?,?) ON DUPLICATE KEY UPDATE v=VALUES(v)')->execute([$k, (string)$v]);
}

function pl_audit(string $action, ?string $entity = null, ?int $id = null, $details = null, ?int $cid = null): void {
    try {
        db()->prepare('INSERT INTO audit_log (user_id, community_id, action, entity, entity_id, details, ip) VALUES (?,?,?,?,?,?,?)')->execute([
            $_SESSION['uid'] ?? null, $cid, $action, $entity, $id, is_string($details) || $details === null ? $details : json_encode($details, JSON_UNESCAPED_UNICODE),
            $_SERVER['REMOTE_ADDR'] ?? null]);
    } catch (Throwable $e) { error_log('PL audit: ' . $e->getMessage()); }
}

function pl_community_names(): array {
    static $m = null;
    return $m ?? ($m = array_column(rows('SELECT id, name FROM communities'), 'name', 'id'));
}

/* ---------- categories ---------- */

function pl_seed_categories(string $module): void {
    if (pl_setting('cat_seeded_' . $module) || scalar('SELECT COUNT(*) FROM categories WHERE module=?', [$module])) return;
    $i = 0;
    foreach ($GLOBALS['PL_CAT_SEED'][$module] ?? [] as $name => $subs) {
        db()->prepare('INSERT INTO categories (module, name, slug, sort_order) VALUES (?,?,?,?)')->execute([$module, $name, pl_slugify($name), $i++]);
        $pid = (int)db()->lastInsertId(); $j = 0;
        foreach ($subs as $s) db()->prepare('INSERT INTO categories (module, parent_id, name, slug, sort_order) VALUES (?,?,?,?,?)')->execute([$module, $pid, $s, pl_slugify($s), $j++]);
    }
    pl_setting_set('cat_seeded_' . $module, 1);
}

function pl_categories(string $module, bool $activeOnly = true): array {
    pl_seed_categories($module);
    $list = rows('SELECT id, parent_id, name, slug, icon, sort_order, is_active FROM categories WHERE module=?' . ($activeOnly ? ' AND is_active=1' : '') . ' ORDER BY sort_order, name', [$module]);
    $top = [];
    foreach ($list as $c) if (!$c['parent_id']) $top[$c['id']] = $c + ['subcategories' => []];
    foreach ($list as $c) if ($c['parent_id'] && isset($top[$c['parent_id']])) $top[$c['parent_id']]['subcategories'][] = $c;
    return array_values($top);
}

function pl_cat_names(): array {
    static $m = null;
    return $m ?? ($m = array_column(rows('SELECT id, name FROM categories'), 'name', 'id'));
}

function pl_cat_id(string $module, $v, ?int $parent = null): ?int {
    if ($v === null || $v === '') return null;
    pl_seed_categories($module);
    if (ctype_digit((string)$v)) $id = scalar('SELECT id FROM categories WHERE id=? AND module=?' . ($parent === null ? ' AND parent_id IS NULL' : ' AND parent_id=?'), $parent === null ? [(int)$v, $module] : [(int)$v, $module, $parent]);
    else $id = scalar('SELECT id FROM categories WHERE module=? AND (slug=? OR LOWER(name)=LOWER(?))' . ($parent === null ? ' AND parent_id IS NULL' : ' AND parent_id=?'), $parent === null ? [$module, pl_slugify((string)$v), (string)$v] : [$module, pl_slugify((string)$v), (string)$v, $parent]);
    return $id ?: null;
}

/* ---------- uploads + media ---------- */

function pl_files_list(array $files): array {
    $list = [];
    foreach ($files as $f) {
        if (!isset($f['name'])) continue;
        if (is_array($f['name'])) { foreach (array_keys($f['name']) as $i) $list[] = ['name' => $f['name'][$i], 'tmp_name' => $f['tmp_name'][$i], 'size' => $f['size'][$i], 'error' => $f['error'][$i]]; }
        else $list[] = $f;
    }
    return array_values(array_filter($list, fn($f) => ($f['error'] ?? 4) !== UPLOAD_ERR_NO_FILE));
}

function pl_store_upload(array $f, string $sub, bool $docs = false): array {
    $max = max(1, pl_setting('max_upload_mb')) * 1048576;
    $types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'] + ($docs ? ['application/pdf' => 'pdf'] : []);
    $msg = ($docs ? 'File must be JPG, PNG, WEBP or PDF' : 'Image must be JPG, PNG or WEBP') . ' up to ' . pl_setting('max_upload_mb') . ' MB.';
    if (($f['error'] ?? 4) !== UPLOAD_ERR_OK || $f['size'] > $max || !is_uploaded_file($f['tmp_name'])) return ['error' => $msg];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    if (!isset($types[$mime]) || ($mime !== 'application/pdf' && !@getimagesize($f['tmp_name']))) return ['error' => $msg];
    $sub = preg_replace('/[^a-z0-9_]/', '', strtolower($sub)) ?: 'misc';
    $dir = PL_FILES_DIR . $sub . '/';
    if (!is_dir($dir) && !@mkdir($dir, 0755, true)) return ['error' => 'Upload folder is not writable.'];
    $name = date('Ymd') . '-' . bin2hex(random_bytes(8)) . '.' . $types[$mime];
    $ok = $mime !== 'application/pdf' && pl_save_image($f['tmp_name'], $mime, $dir . $name, $dir . 'th_' . $name);
    if (!$ok && !move_uploaded_file($f['tmp_name'], $dir . $name)) return ['error' => 'Could not save the file.'];
    return ['url' => PL_FILES_URL . $sub . '/' . $name, 'kind' => $mime === 'application/pdf' ? 'file' : 'image', 'name' => mb_substr((string)$f['name'], 0, 200)];
}

function pl_delete_file(?string $url): void {
    if (!$url || !str_starts_with($url, PL_FILES_URL)) return;
    $rel = substr($url, strlen(PL_FILES_URL));
    if (!preg_match('#^[a-z0-9_]+/[A-Za-z0-9\-]+\.(jpg|png|webp|pdf)$#', $rel)) return;
    foreach ([PL_FILES_DIR . $rel, PL_FILES_DIR . dirname($rel) . '/th_' . basename($rel)] as $p) if (is_file($p)) @unlink($p);
}

function pl_thumb(?string $url): ?string {
    if (!$url || !str_starts_with($url, PL_FILES_URL)) return $url;
    $rel = substr($url, strlen(PL_FILES_URL));
    return is_file(PL_FILES_DIR . dirname($rel) . '/th_' . basename($rel)) ? PL_FILES_URL . dirname($rel) . '/th_' . basename($rel) : $url;
}

function pl_media(array $E, int $id, ?string $kind = null): array {
    $list = rows('SELECT id, kind, url, name, is_primary FROM media WHERE entity=? AND entity_id=?' . ($kind ? ' AND kind=?' : '') . ' ORDER BY is_primary DESC, sort_order, id', $kind ? [$E['table'], $id, $kind] : [$E['table'], $id]);
    return array_map(fn($m) => ['id' => (int)$m['id'], 'kind' => $m['kind'], 'url' => $m['url'], 'thumbnail_url' => pl_thumb($m['url']), 'name' => $m['name'], 'is_primary' => (int)$m['is_primary']], $list);
}

function pl_media_add(array $E, int $id, array $files, ?int $uid): array {
    $list = pl_files_list($files);
    if (!$list) return ['error' => 'Choose a file to upload.'];
    $docs = $E['files'] > 0; $limit = $docs ? $E['files'] : $E['gallery'];
    if (!$limit) return ['error' => 'Uploads are not available here.'];
    $count = scalar('SELECT COUNT(*) FROM media WHERE entity=? AND entity_id=?', [$E['table'], $id]);
    $added = 0;
    foreach ($list as $f) {
        if ($count + $added >= $limit) return ['error' => 'Maximum ' . $limit . ' files allowed.', 'added' => $added];
        $r = pl_store_upload($f, $E['table'], $docs);
        if (!empty($r['error'])) return $r + ['added' => $added];
        db()->prepare('INSERT INTO media (entity, entity_id, kind, url, name, is_primary, sort_order, user_id) VALUES (?,?,?,?,?,?,?,?)')
            ->execute([$E['table'], $id, $r['kind'], $r['url'], $r['name'], $count + $added === 0 ? 1 : 0, $count + $added, $uid]);
        $added++;
    }
    return ['message' => $added . ' file' . ($added === 1 ? '' : 's') . ' uploaded.', 'added' => $added, 'media' => pl_media($E, $id)];
}

function pl_media_delete(array $E, int $id, int $mediaId): bool {
    $m = rows('SELECT * FROM media WHERE id=? AND entity=? AND entity_id=?', [$mediaId, $E['table'], $id])[0] ?? null;
    if (!$m) return false;
    db()->prepare('DELETE FROM media WHERE id=?')->execute([$mediaId]);
    pl_delete_file($m['url']);
    if ($m['is_primary']) db()->prepare('UPDATE media SET is_primary=1 WHERE id=(SELECT id FROM (SELECT id FROM media WHERE entity=? AND entity_id=? ORDER BY sort_order, id LIMIT 1) t)')->execute([$E['table'], $id]);
    return true;
}

function pl_media_primary(array $E, int $id, int $mediaId): bool {
    if (!scalar('SELECT COUNT(*) FROM media WHERE id=? AND entity=? AND entity_id=?', [$mediaId, $E['table'], $id])) return false;
    db()->prepare('UPDATE media SET is_primary=(id=?) WHERE entity=? AND entity_id=?')->execute([$mediaId, $E['table'], $id]);
    return true;
}

/* ---------- input validation (shared by admin forms and API) ---------- */

function pl_entity_input(array $E, array $in, array $files, bool $admin, ?array $old = null, bool $full = true): array {
    $c = []; $err = null;
    foreach ($E['fields'] as $col => $f) {
        $t = $f['type'];
        if ($t === 'hidden' || (!empty($f['admin']) && !$admin)) continue;
        if ($t === 'parent' && $old && !$admin) continue;
        if ($t === 'image') {
            $file = $files[$col] ?? null;
            if ($file && !is_array($file['name']) && ($file['error'] ?? 4) !== UPLOAD_ERR_NO_FILE) {
                $r = pl_store_upload($file, $E['table']);
                if (!empty($r['error'])) return [null, $f['label'] . ': ' . $r['error']];
                $c[$col] = $r['url'];
            } elseif (!empty($in['remove_' . $col])) $c[$col] = null;
            continue;
        }
        if ($t === 'bool') {
            if (array_key_exists($col, $in)) $c[$col] = in_array(strtolower(trim((string)(is_array($in[$col]) ? '' : $in[$col]))), ['1', 'true', 'yes', 'on'], true) ? 1 : 0;
            elseif ($admin && $full) $c[$col] = 0;
            elseif (!$old && isset($f['default'])) $c[$col] = (int)$f['default'];
            continue;
        }
        if (!array_key_exists($col, $in)) { if (!$old && isset($f['default'])) $c[$col] = $f['default']; continue; }
        $v = $in[$col];
        $v = trim(is_array($v) ? implode(', ', array_filter(array_map(fn($x) => is_scalar($x) ? (string)$x : '', $v), 'strlen')) : (string)$v);
        $L = $f['label'];
        switch ($t) {
            case 'money': $v = str_replace([',', '₹', ' '], '', $v); if ($v === '') $v = null; elseif (!is_numeric($v) || $v < 0) $err = "$L must be a valid amount."; else $v = round((float)$v, 2); break;
            case 'int': case 'parent': case 'ref': if ($v === '') $v = null; elseif (!preg_match('/^\d{1,9}$/', $v)) $err = "$L must be a number."; else $v = (int)$v; break;
            case 'lat': case 'lng': $lim = $t === 'lat' ? 90 : 180; if ($v === '') $v = null; elseif (!is_numeric($v) || abs((float)$v) > $lim) $err = "$L is not valid."; else $v = round((float)$v, 7); break;
            case 'date': if ($v === '') $v = null; elseif (($ts = strtotime($v)) === false) $err = "$L is not a valid date."; else $v = date('Y-m-d', $ts); break;
            case 'time': if ($v === '') $v = null; elseif (!preg_match('/^([01]?\d|2[0-3]):[0-5]\d(:[0-5]\d)?$/', $v) && ($ts = strtotime($v)) === false) $err = "$L is not a valid time."; else $v = date('H:i:s', strtotime($v)); break;
            case 'datetime': if ($v === '') $v = null; elseif (($ts = strtotime($v)) === false) $err = "$L is not valid."; else $v = date('Y-m-d H:i:s', $ts); break;
            case 'email': if ($v !== '' && !filter_var($v, FILTER_VALIDATE_EMAIL)) $err = "$L is not a valid email."; $v = mb_substr($v, 0, 160); break;
            case 'url': if ($v !== '' && (!preg_match('#^https?://#i', $v) || !filter_var($v, FILTER_VALIDATE_URL))) $err = "$L must start with http:// or https://"; $v = mb_substr($v, 0, 500); break;
            case 'phone': $v = preg_replace('/[^\d+]/', '', $v); if ($v !== '' && !preg_match('/^\+?\d{6,15}$/', $v)) $err = "$L is not a valid number."; break;
            case 'select': if ($v !== '') { $o = pl_opts($f); $k = array_search(strtolower($v), array_map('strtolower', array_keys($o)), true); if ($k === false) $k = array_search(strtolower($v), array_map('strtolower', array_values($o)), true); if ($k === false) $err = "Choose a valid $L."; else $v = array_keys($o)[$k]; } break;
            case 'category': $v = $v === '' ? null : pl_cat_id($E['cat'], $v); if (($in[$col] ?? '') !== '' && !$v) $err = "Choose a valid $L."; break;
            case 'subcategory': break; // checked below, needs the category
            case 'textarea': $v = mb_substr($v, 0, 5000); break;
            default: $v = mb_substr($v, 0, 255);
        }
        if ($err) return [null, $err];
        $c[$col] = $v;
    }
    foreach ($E['fields'] as $col => $f) {
        if ($f['type'] !== 'subcategory' || !array_key_exists($col, $in)) continue;
        $catCol = array_key_first(array_filter($E['fields'], fn($x) => $x['type'] === 'category'));
        $catId = $c[$catCol] ?? ($old[$catCol] ?? null);
        $raw = trim((string)$in[$col]);
        $c[$col] = $raw === '' || !$catId ? null : pl_cat_id($E['cat'], $raw, (int)$catId);
        if ($raw !== '' && !$c[$col]) return [null, 'Choose a valid ' . $f['label'] . '.'];
    }
    foreach ($E['fields'] as $col => $f) {
        if (empty($f['req']) || (!empty($f['admin']) && !$admin) || $f['type'] === 'hidden') continue;
        $val = array_key_exists($col, $c) ? $c[$col] : ($old[$col] ?? null);
        if ($val === null || $val === '') { if ($full || array_key_exists($col, $c)) return [null, $f['label'] . ' is required.']; }
    }
    if ($E['extras'] && !$admin) {
        $skip = '/^(csrf|action|c|community|redirect|next|id|ids|page|per|q|sort|visibility_type|community_id|status|is_active|is_featured|sort_order|admin_notes|details|user_id|remove_.*|back_.*|logout_oldest|device_.*)$/';
        $extra = [];
        foreach (pl_collect($in) as $k => $v) if (!isset($E['fields'][$k]) && !preg_match($skip, $k)) $extra[$k] = $v;
        if ($extra) $c['details'] = json_encode(array_merge(json_decode($old['details'] ?? '', true) ?: [], $extra), JSON_UNESCAPED_UNICODE);
    }
    return [$c, null];
}

/* ---------- rows ---------- */

function pl_entity_row(array $E, int $id): ?array {
    $a = [$id]; $w = 't.id=?';
    foreach ($E['fixed'] as $k => $v) { $w .= " AND t.$k=?"; $a[] = $v; }
    return rows("SELECT t.* FROM {$E['table']} t WHERE $w", $a)[0] ?? null;
}

function pl_entity_insert(array $E, array $cols, array $meta): int {
    $cols = $cols + $E['fixed'] + $meta;
    db()->prepare("INSERT INTO {$E['table']} (" . implode(',', array_keys($cols)) . ') VALUES (' . implode(',', array_fill(0, count($cols), '?')) . ')')->execute(array_values($cols));
    $id = (int)db()->lastInsertId();
    if ($E['code']) db()->prepare("UPDATE {$E['table']} SET {$E['code'][0]}=? WHERE id=?")->execute([$E['code'][1] . (1000 + $id), $id]);
    return $id;
}

function pl_entity_update(array $E, int $id, array $cols): void {
    if (!$cols) return;
    db()->prepare("UPDATE {$E['table']} SET " . implode(',', array_map(fn($k) => "$k=?", array_keys($cols))) . ' WHERE id=?')->execute(array_merge(array_values($cols), [$id]));
}

function pl_entity_delete(array $E, int $id): void {
    foreach ($E['children'] as [$ck, $fk]) {
        $CE = pl_entity($ck);
        if ($CE['table'] === $E['table'] || $fk === 'user_id') continue;
        foreach (rows("SELECT id FROM {$CE['table']} WHERE $fk=?", [$id]) as $r) pl_entity_delete($CE, (int)$r['id']);
    }
    $row = rows("SELECT * FROM {$E['table']} WHERE id=?", [$id])[0] ?? null;
    if (!$row) return;
    foreach ($E['fields'] as $col => $f) if ($f['type'] === 'image') pl_delete_file($row[$col] ?? null);
    if ($E['key'] === 'job_application') pl_job_resume_unlink($row['resume_path'] ?? null);
    foreach (rows('SELECT url FROM media WHERE entity=? AND entity_id=?', [$E['table'], $id]) as $m) pl_delete_file($m['url']);
    db()->prepare('DELETE FROM media WHERE entity=? AND entity_id=?')->execute([$E['table'], $id]);
    db()->prepare('DELETE FROM favourites WHERE entity=? AND entity_id=?')->execute([$E['table'], $id]);
    db()->prepare("DELETE FROM {$E['table']} WHERE id=?")->execute([$id]);
}

function pl_entity_title(array $E, array $r): string { return (string)($r[$E['title']] ?? ('#' . $r['id'])); }

/* ---------- public listing / output (API) ---------- */

function pl_ent_where(array $E, int $cid, array &$a, string $t = 't'): string {
    $w = [];
    foreach ($E['fixed'] as $k => $v) { $w[] = "$t.$k=?"; $a[] = $v; }
    if ($E['statuses']) { $w[] = "$t.{$E['status_col']} IN (" . implode(',', array_fill(0, count($E['public_statuses']), '?')) . ')'; array_push($a, ...$E['public_statuses']); }
    $w[] = "$t.{$E['active_col']}=1";
    if ($E['scope'] === 'community') { $w[] = "$t.community_id=?"; $a[] = $cid; }
    elseif ($E['scope'] === 'mixed') { $w[] = "($t.visibility_type='global' OR $t.community_id=?)"; $a[] = $cid; }
    if ($E['expires']) $w[] = "($t.{$E['expires']} IS NULL OR $t.{$E['expires']} >= " . ($E['fields'][$E['expires']]['type'] === 'date' ? 'CURDATE()' : 'NOW()') . ')';
    foreach (['live_where', 'base_where'] as $x) if (!empty($E[$x])) $w[] = str_replace('t.', "$t.", $E[$x]);
    return implode(' AND ', $w);
}

function pl_ent_filters(array $E, array $f, array &$a, string $t = 't'): string {
    $w = [];
    foreach ($E['fields'] as $col => $d) {
        if (empty($d['filter'])) continue;
        $v = $f[$col] ?? null;
        if ($d['type'] === 'category' && $v === null) $v = $f['category'] ?? null;
        if ($d['type'] === 'subcategory' && $v === null) $v = $f['subcategory'] ?? null;
        if ($d['type'] === 'money') {
            $min = $f[$col . '_min'] ?? $f['min_' . $col] ?? null; $max = $f[$col . '_max'] ?? $f['max_' . $col] ?? null;
            if (is_numeric($min)) { $w[] = "$t.$col>=?"; $a[] = (float)$min; }
            if (is_numeric($max)) { $w[] = "$t.$col<=?"; $a[] = (float)$max; }
            continue;
        }
        if ($d['type'] === 'date') {
            foreach (['_from' => '>=', '_to' => '<='] as $sfx => $op) if (!empty($f[$col . $sfx]) && strtotime((string)$f[$col . $sfx])) { $w[] = "$t.$col$op?"; $a[] = date('Y-m-d', strtotime((string)$f[$col . $sfx])); }
        }
        if ($v === null || is_array($v) || trim((string)$v) === '' || strtolower(trim((string)$v)) === 'any' || strtolower(trim((string)$v)) === 'all') continue;
        $v = trim((string)$v);
        if ($d['type'] === 'category' || $d['type'] === 'subcategory') {
            $id = ctype_digit($v) ? (int)$v : scalar('SELECT id FROM categories WHERE module=? AND (slug=? OR LOWER(name)=LOWER(?)) LIMIT 1', [$E['cat'], pl_slugify($v), $v]);
            $w[] = "$t.$col=?"; $a[] = $id ?: -1;
        } elseif (in_array($d['type'], ['select', 'int', 'bool', 'date'], true)) { $w[] = "$t.$col=?"; $a[] = $v; }
        else { $w[] = "$t.$col LIKE ?"; $a[] = "%$v%"; }
    }
    $q = trim((string)($f['q'] ?? $f['keyword'] ?? $f['search'] ?? ''));
    if ($q !== '' && $E['search']) { $w[] = '(' . implode(' OR ', array_map(fn($c) => "$t.$c LIKE ?", $E['search'])) . ')'; foreach ($E['search'] as $_) $a[] = "%$q%"; }
    return $w ? ' AND ' . implode(' AND ', $w) : '';
}

function pl_ent_covers(array $E, array $ids): array {
    if (!$ids || !$E['gallery']) return [];
    $out = [];
    foreach (rows('SELECT entity_id, url FROM media WHERE entity=? AND kind=\'image\' AND entity_id IN (' . implode(',', array_map('intval', $ids)) . ') ORDER BY is_primary DESC, sort_order, id', [$E['table']]) as $m)
        if (!isset($out[$m['entity_id']])) $out[$m['entity_id']] = $m['url'];
    return $out;
}

function pl_ent_out(array $E, array $r, ?int $viewer, bool $full = false, bool $admin = false): array {
    $own = $viewer && (int)($r['user_id'] ?? 0) === $viewer;
    $cats = pl_cat_names();
    $showContact = $own || $admin || ($viewer && (!$E['contact_rule'] || (string)($r[$E['contact_rule'][0]] ?? '') === (string)$E['contact_rule'][1]));
    $o = ['id' => (int)$r['id']];
    foreach ($E['fields'] as $col => $f) {
        $v = $r[$col] ?? null;
        switch ($f['type']) {
            case 'money': case 'lat': case 'lng': $v = $v === null ? null : (float)$v; break;
            case 'int': case 'parent': case 'ref': $v = $v === null ? null : (int)$v; break;
            case 'bool': $v = (bool)$v; break;
            case 'time': $v = $v ? substr($v, 0, 5) : null; break;
            case 'category': case 'subcategory': $o[preg_replace('/_id$/', '', $col) . '_name'] = $v ? ($cats[$v] ?? null) : null; $v = $v === null ? null : (int)$v; break;
            case 'image': $o[$col . '_thumbnail'] = pl_thumb($v); break;
        }
        if (!empty($f['private']) && !$showContact) $v = null;
        $o[$col] = $v;
    }
    if (!$showContact) $o['contact_hidden'] = true;
    if ($E['scope'] !== 'global') { $o['community_id'] = $r['community_id'] === null ? null : (int)$r['community_id']; $o['community_name'] = pl_community_names()[$r['community_id']] ?? null; }
    if ($E['scope'] === 'mixed') $o['visibility_type'] = $r['visibility_type'];
    if ($E['featured']) $o['is_featured'] = (bool)$r['is_featured'];
    if ($E['statuses'] && ($own || $admin || $E['key'] === 'support')) $o['status'] = $r[$E['status_col']];
    if ($own || $admin) { $o['is_active'] = (bool)$r[$E['active_col']]; if ($E['closable']) $o['closed_at'] = $r['closed_at']; }
    if ($E['expires']) $o['expired'] = $r[$E['expires']] !== null && strtotime((string)$r[$E['expires']]) < strtotime($E['fields'][$E['expires']]['type'] === 'date' ? 'today' : 'now');
    $o['is_own'] = $own;
    $o['created_at'] = $r['created_at']; $o['updated_at'] = $r['updated_at'];
    if ($E['gallery']) $o['cover'] = $r['_cover'] ?? (pl_media($E, (int)$r['id'], 'image')[0]['url'] ?? null);
    if ($full) {
        if ($E['gallery']) $o['images'] = pl_media($E, (int)$r['id'], 'image');
        if ($E['files'] && ($own || $admin)) $o['documents'] = pl_media($E, (int)$r['id']);
        $o['details'] = json_decode($r['details'] ?? '', true) ?: new stdClass();
    }
    return $o;
}

function pl_ent_list(array $E, int $cid, array $f, ?int $uid, int $page = 1, int $per = 20, ?string $extraWhere = null, array $extraArgs = []): array {
    $a = []; $w = pl_ent_where($E, $cid, $a) . pl_ent_filters($E, $f, $a);
    if ($extraWhere) { $w .= " AND $extraWhere"; array_push($a, ...$extraArgs); }
    $sorts = ['recent' => 't.id DESC', 'oldest' => 't.id ASC'];
    if (isset($E['fields']['price'])) $sorts += ['price_asc' => 't.price ASC', 'price_desc' => 't.price DESC', 'price-low' => 't.price ASC', 'price-high' => 't.price DESC'];
    if (isset($E['fields']['event_date'])) $sorts += ['date' => 't.event_date ASC', 'date_desc' => 't.event_date DESC'];
    if (isset($E['fields']['name'])) $sorts['name'] = 't.name ASC';
    $default = $E['ordered'] ? 't.sort_order ASC, t.id ASC' : (($E['featured'] ? 't.is_featured DESC, ' : '') . ($E['public_order'] ?? 't.id DESC'));
    $order = $sorts[$f['sort'] ?? ''] ?? $default;
    $per = max(1, min(50, $per)); $page = max(1, $page);
    $total = scalar("SELECT COUNT(*) FROM {$E['table']} t WHERE $w", $a);
    $list = rows("SELECT t.* FROM {$E['table']} t WHERE $w ORDER BY $order LIMIT $per OFFSET " . (($page - 1) * $per), $a);
    $covers = pl_ent_covers($E, array_column($list, 'id'));
    $saved = $uid && $E['save'] && $list ? array_column(rows('SELECT entity_id FROM favourites WHERE user_id=? AND entity=?', [$uid, $E['table']]), 'entity_id') : [];
    $items = array_map(function ($r) use ($E, $uid, $covers, $saved) {
        $r['_cover'] = $covers[$r['id']] ?? null;
        $o = pl_ent_out($E, $r, $uid);
        if ($E['save']) $o['saved'] = in_array($r['id'], $saved);
        return $o;
    }, $list);
    return ['total' => $total, 'page' => $page, 'per' => $per, 'total_pages' => (int)ceil($total / $per), 'items' => $items];
}

/* ---------- notifications: in-app + FCM push + SMS ---------- */

/* address -> [lat, lng] with OpenStreetMap Nominatim (free, no key; their policy: max 1 request/second, identify the app).
   Tries the most precise address first. Returns null when nothing is found or the server has no internet. */
function pl_geocode(array $parts): ?array {
    $parts = array_values(array_filter(array_map(fn($p) => trim((string)$p), $parts), 'strlen'));
    $tries = [];
    for ($i = 0; $i < count($parts) - 1; $i++) $tries[] = implode(', ', array_slice($parts, $i)) . ', India';
    if (!$tries && $parts) $tries[] = $parts[0] . ', India';
    static $last = 0.0;
    foreach (array_unique($tries) as $q) {
        if (($wait = 1.05 - (microtime(true) - $last)) > 0) usleep((int)($wait * 1e6));
        $last = microtime(true);
        $ch = curl_init('https://nominatim.openstreetmap.org/search?' . http_build_query(['q' => $q, 'format' => 'json', 'limit' => 1, 'countrycodes' => 'in']));
        curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 6, CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_HTTPHEADER => ['User-Agent: PeopleLink/1.0 (' . DASHBOARD_URL . ')', 'Accept-Language: en']]);
        $res = json_decode((string)curl_exec($ch), true);
        if (curl_errno($ch)) return null; // offline: do not keep trying
        if (!empty($res[0]['lat'])) return [round((float)$res[0]['lat'], 7), round((float)$res[0]['lon'], 7)];
    }
    return null;
}

/* fills latitude / longitude of a saved row that has an address but no coordinates (directory listings, families) */
function pl_geo_fill(array $E, int $id): bool {
    if (!isset($E['fields']['latitude'], $E['fields']['longitude'])) return false;
    $r = pl_entity_row($E, $id);
    if (!$r || ($r['latitude'] !== null && $r['longitude'] !== null)) return false;
    $ll = pl_geocode([$r['address'] ?? '', $r['area'] ?? '', $r['city'] ?? '', $r['state'] ?? '', $r['pincode'] ?? '']);
    if (!$ll) return false;
    db()->prepare("UPDATE {$E['table']} SET latitude=?, longitude=?, updated_at=updated_at WHERE id=?")->execute([$ll[0], $ll[1], $id]);
    return true;
}

function pl_notify_user(?int $uid, ?int $cid, string $title, string $msg, string $type = 'general', ?string $entity = null, ?int $entityId = null, bool $push = true): void {
    if (!$uid) return;
    try {
        db()->prepare('INSERT INTO user_notifications (user_id, community_id, title, message, type, entity, entity_id, created_by) VALUES (?,?,?,?,?,?,?,?)')
            ->execute([$uid, $cid, mb_substr($title, 0, 160), $msg, $type, $entity, $entityId, $_SESSION['uid'] ?? null]);
        if ($push) pl_push_users([$uid], $title, $msg, ['type' => $type, 'entity' => (string)$entity, 'id' => (string)$entityId]);
    } catch (Throwable $e) { error_log('PL notify: ' . $e->getMessage()); }
}

function pl_fcm_token(): ?array {
    if (FCM_SERVICE_ACCOUNT_FILE === '' || !is_file(FCM_SERVICE_ACCOUNT_FILE)) return null;
    $sa = json_decode((string)file_get_contents(FCM_SERVICE_ACCOUNT_FILE), true);
    if (empty($sa['client_email']) || empty($sa['private_key']) || empty($sa['project_id'])) return null;
    $cache = sys_get_temp_dir() . '/pl_fcm_' . md5($sa['client_email']) . '.json';
    $c = is_file($cache) ? json_decode((string)file_get_contents($cache), true) : null;
    if ($c && $c['exp'] > time() + 60) return [$c['token'], $sa['project_id']];
    $b64 = fn($s) => rtrim(strtr(base64_encode($s), '+/', '-_'), '=');
    $now = time();
    $jwt = $b64(json_encode(['alg' => 'RS256', 'typ' => 'JWT'])) . '.' . $b64(json_encode(['iss' => $sa['client_email'], 'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        'aud' => 'https://oauth2.googleapis.com/token', 'iat' => $now, 'exp' => $now + 3600]));
    if (!openssl_sign($jwt, $sig, $sa['private_key'], 'sha256WithRSAEncryption')) return null;
    $ch = curl_init('https://oauth2.googleapis.com/token');
    curl_setopt_array($ch, [CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 10,
        CURLOPT_POSTFIELDS => http_build_query(['grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'assertion' => $jwt . '.' . $b64($sig)])]);
    $r = json_decode((string)curl_exec($ch), true); curl_close($ch);
    if (empty($r['access_token'])) return null;
    @file_put_contents($cache, json_encode(['token' => $r['access_token'], 'exp' => $now + (int)($r['expires_in'] ?? 3600)]));
    return [$r['access_token'], $sa['project_id']];
}

function pl_push_tokens(array $tokens, string $title, string $body, array $data = []): int {
    $auth = $tokens ? pl_fcm_token() : null;
    if (!$auth) return 0;
    [$token, $project] = $auth; $sent = 0;
    @set_time_limit(120);
    foreach (array_slice(array_unique($tokens), 0, 1000) as $t) {
        $ch = curl_init("https://fcm.googleapis.com/v1/projects/$project/messages:send");
        curl_setopt_array($ch, [CURLOPT_POST => true, CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 8,
            CURLOPT_HTTPHEADER => ['Authorization: Bearer ' . $token, 'Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode(['message' => ['token' => $t, 'notification' => ['title' => $title, 'body' => mb_strimwidth($body, 0, 240, '…')],
                'data' => array_map('strval', $data)]])]);
        $res = curl_exec($ch); $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); curl_close($ch);
        if ($code === 200) $sent++;
        elseif ($code === 404 || ($code === 400 && str_contains((string)$res, 'INVALID_ARGUMENT'))) db()->prepare('UPDATE device_tokens SET is_active=0 WHERE token=?')->execute([$t]);
    }
    return $sent;
}

function pl_push_users(array $uids, string $title, string $body, array $data = []): int {
    $uids = array_values(array_filter(array_map('intval', $uids)));
    if (!$uids || FCM_SERVICE_ACCOUNT_FILE === '') return 0;
    $tokens = array_column(rows('SELECT token FROM device_tokens WHERE is_active=1 AND user_id IN (' . implode(',', $uids) . ')'), 'token');
    return pl_push_tokens($tokens, $title, $body, $data);
}

function pl_sms(?string $phone, string $msg): bool {
    $phone = preg_replace('/[^\d+]/', '', (string)$phone);
    if (SMS_API_URL === '' || $phone === '' || !pl_setting('sms_enabled')) return false;
    $url = str_replace(['{phone}', '{message}'], [rawurlencode($phone), rawurlencode($msg)], SMS_API_URL);
    $ch = curl_init($url); curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 8]);
    curl_exec($ch); $ok = curl_getinfo($ch, CURLINFO_HTTP_CODE) < 400; curl_close($ch);
    return $ok;
}

require_once __DIR__ . '/jobs.php';
