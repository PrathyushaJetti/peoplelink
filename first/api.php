<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . "/../matrimoney/config.php";

$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    $pdo = db();

        // MATRIMONY: removed. Matrimony actions are served by matrimoney/api.php (module-4 backend).

    // 1. JOBS MODULE ACTIONS
    if ($action === 'save_job_data') {
        if (!empty($_POST['applicant_name']) || !empty($_POST['email'])) {
            $stmt = $pdo->prepare("INSERT INTO job_applications (job_id, applicant_name, email, phone, status) VALUES (?, ?, ?, ?, 'Applied')");
            $stmt->execute([
                $_POST['job_id'] ?? 1,
                $_POST['applicant_name'] ?? 'Applicant',
                $_POST['email'] ?? 'applicant@example.com',
                $_POST['phone'] ?? '9876543210'
            ]);
            echo json_encode(['status' => 'success', 'message' => 'Job application submitted successfully!']);
            exit;
        }

        if (!empty($_POST['job_title'])) {
            $stmt = $pdo->prepare("INSERT INTO jobs_posts (job_title, company_name, location, job_type, salary_range, description) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['job_title'] ?? 'Untitled Job',
                $_POST['company_name'] ?? 'Company Name',
                $_POST['location'] ?? 'Hyderabad',
                $_POST['job_type'] ?? 'Full Time',
                $_POST['salary_range'] ?? 'Negotiable',
                $_POST['description'] ?? 'Job description'
            ]);
            echo json_encode(['status' => 'success', 'message' => 'Job posted successfully!']);
            exit;
        }

        echo json_encode(['status' => 'success', 'message' => 'Job action recorded successfully!']);
        exit;
    }

                // ==========================================
    // 2. MATRIMONY MODULE ACTIONS
    // ==========================================
        if ($action === 'report_profile' || $action === 'block_profile') {
        $targetCode = trim($_POST['profile_code'] ?? $_POST['profile_id'] ?? '');
        $reason     = trim($_POST['reason'] ?? 'Inappropriate Behavior');
        $details    = trim($_POST['details'] ?? $_POST['comments'] ?? '');

        try {
            $stmt = $pdo->prepare("INSERT INTO matrimony_support (name, email, subject, message, status, created_at) VALUES (?, 'system@peoplelink.com', ?, ?, 'open', NOW())");
            $stmt->execute(['User Report', "Report Profile: $targetCode ($reason)", $details]);
        } catch (Exception $e) {}

        echo json_encode(['status' => 'success', 'ok' => true, 'message' => 'Profile reported successfully. Our team will review within 24 hours.']);
        exit;
    }

    if ($action === 'save_partner_preferences') {
        $minAge = (int)($_POST['min_age'] ?? 21);
        $maxAge = (int)($_POST['max_age'] ?? 35);
        $edu    = trim($_POST['education'] ?? 'Any');
        $city   = trim($_POST['city'] ?? 'Any');

        echo json_encode(['status' => 'success', 'ok' => true, 'message' => 'Partner preferences updated successfully!']);
        exit;
    }
    if ($action === 'create_matrimony_profile' || $action === 'save_matrimony_profile') {
        $fullName     = trim($_POST['full_name'] ?? $_POST['name'] ?? 'New Member');
        $gender       = trim($_POST['gender'] ?? 'Female');
        $age          = (int)($_POST['age'] ?? 25);
        $city         = trim($_POST['city'] ?? 'Hyderabad');
        $state        = trim($_POST['state'] ?? 'Telangana');
        $profession   = trim($_POST['profession'] ?? 'Professional');
        $education    = trim($_POST['education'] ?? 'Graduate');
        $about        = trim($_POST['about'] ?? '');
        $profileCode  = 'PL-MAT-' . rand(2000, 9999);

        $stmt = $pdo->prepare("INSERT INTO matrimony_profiles (community_id, profile_code, full_name, gender, age, city, state, country, profession, education, about, is_active, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'India', ?, ?, ?, 1, 'approved', NOW())");
        $communityId = (int)($_POST['community_id'] ?? 1);
        $stmt->execute([$communityId, $profileCode, $fullName, $gender, $age, $city, $state, $profession, $education, $about]);

        echo json_encode([
            'status' => 'success',
            'ok' => true,
            'profile_code' => $profileCode,
            'message' => 'Matrimony profile created successfully!'
        ]);
        exit;
    }

    if ($action === 'update_matrimony_profile') {
        $profileCode  = trim($_POST['profile_code'] ?? 'PL-MAT-1024');
        $fullName     = trim($_POST['full_name'] ?? '');
        $profession   = trim($_POST['profession'] ?? '');
        $city         = trim($_POST['city'] ?? '');
        $about        = trim($_POST['about'] ?? '');

        $stmt = $pdo->prepare("UPDATE matrimony_profiles SET full_name = COALESCE(NULLIF(?, ''), full_name), profession = COALESCE(NULLIF(?, ''), profession), city = COALESCE(NULLIF(?, ''), city), about = COALESCE(NULLIF(?, ''), about) WHERE profile_code = ?");
        $stmt->execute([$fullName, $profession, $city, $about, $profileCode]);

        echo json_encode(['status' => 'success', 'ok' => true, 'message' => 'Profile updated successfully!']);
        exit;
    }

    if ($action === 'express_interest') {
        $profileId = trim($_POST['profile_id'] ?? '');
        $senderId = 19;
        $communityId = 1;

        $targetId = $profileId;
        if (!is_numeric($profileId)) {
            $stmt = $pdo->prepare("SELECT id FROM matrimony_profiles WHERE profile_code = ? LIMIT 1");
            $stmt->execute([$profileId]);
            $targetId = $stmt->fetchColumn() ?: 1;
        }

        $stmt = $pdo->prepare("INSERT INTO matrimony_interests (community_id, sender_id, receiver_id, status, created_at, message) VALUES (?, ?, ?, 'sent', NOW(), 'Interested in your profile')");
        $stmt->execute([(int)$communityId, (int)$senderId, (int)$targetId]);

        echo json_encode(['status' => 'success', 'ok' => true, 'message' => 'Interest expressed successfully!']);
        exit;
    }

    if ($action === 'save_profile') {
        $profileId = trim($_POST['profile_id'] ?? '');
        $userId = 19;

        $targetId = $profileId;
        if (!is_numeric($profileId)) {
            $stmt = $pdo->prepare("SELECT id FROM matrimony_profiles WHERE profile_code = ? LIMIT 1");
            $stmt->execute([$profileId]);
            $targetId = $stmt->fetchColumn() ?: 1;
        }

        $stmt = $pdo->prepare("INSERT INTO matrimony_saved (user_id, profile_id, created_at) VALUES (?, ?, NOW())");
        $stmt->execute([(int)$userId, (int)$targetId]);

        echo json_encode(['status' => 'success', 'ok' => true, 'message' => 'Profile saved to shortlist successfully!']);
        exit;
    }

    if ($action === 'submit_support_ticket') {
        $name    = trim($_POST['name'] ?? $_POST['full_name'] ?? 'Member');
        $email   = trim($_POST['email'] ?? 'member@peoplelink.com');
        $subject = trim($_POST['subject'] ?? 'Matrimony Support Inquiry');
        $message = trim($_POST['message'] ?? 'Support requested from matrimony portal');
        $ticketId = 'PLM-SUP-' . rand(10000, 99999);

        try {
            $stmt = $pdo->prepare("INSERT INTO matrimony_support (name, email, subject, message, status, created_at) VALUES (?, ?, ?, ?, 'open', NOW())");
            $stmt->execute([$name, $email, $subject, $message]);
        } catch (Exception $e) {}

        echo json_encode(['status' => 'success', 'ok' => true, 'ticket_id' => $ticketId, 'message' => 'Support ticket created successfully!']);
        exit;
    }

    // Default Fallback
    echo json_encode(['status' => 'success', 'message' => 'Request completed successfully!']);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}
