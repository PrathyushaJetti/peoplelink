<?php
/* Module 4 - Matrimony backend. Loaded by matrimoney/includes/ext/matrimony.php, so every action is served by the shared
   router matrimoney/api.php (same session, CSRF, community lock and response format as the rest of PeopleLink). */

require_once __DIR__ . '/config/matrimony.php';
require_once __DIR__ . '/../../matrimoney/includes/payments.php';
require_once __DIR__ . '/helpers/mat_helpers.php';
require_once __DIR__ . '/services/NotificationService.php';
require_once __DIR__ . '/models/ProfileModel.php';
require_once __DIR__ . '/models/PackageModel.php';
require_once __DIR__ . '/models/ContactModel.php';

/* tables / columns created automatically on first request (same mechanism as the rest of the project) */
pl_need_table('matrimony_contact_requests', 'CREATE TABLE IF NOT EXISTS matrimony_contact_requests (id INT AUTO_INCREMENT PRIMARY KEY, community_id INT NOT NULL,
    requester_profile_id INT NOT NULL, target_profile_id INT NOT NULL, requester_user_id INT NOT NULL, user_package_id INT NULL, message VARCHAR(500) NULL,
    status VARCHAR(20) DEFAULT \'pending\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP, responded_at DATETIME NULL,
    UNIQUE KEY uq_pair (requester_profile_id, target_profile_id), KEY idx_target (target_profile_id, status)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
pl_need_table('matrimony_profile_views', 'CREATE TABLE IF NOT EXISTS matrimony_profile_views (id INT AUTO_INCREMENT PRIMARY KEY, viewer_profile_id INT NOT NULL,
    profile_id INT NOT NULL, viewed_on DATE NOT NULL, view_count INT DEFAULT 1, last_viewed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_view (viewer_profile_id, profile_id, viewed_on), KEY idx_profile (profile_id, viewed_on)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
pl_need_column('packages', 'contact_views', 'INT NULL');
pl_need_column('matrimony_reports', 'reporter_user_id', 'INT NULL');

require_once __DIR__ . '/controllers/ProfileController.php';
require_once __DIR__ . '/controllers/InterestContactController.php';
require_once __DIR__ . '/controllers/PackageNotificationController.php';
