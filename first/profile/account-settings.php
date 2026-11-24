<?php
// Account & Privacy Settings: real saved preferences of the logged-in user; saves, deactivates, logs out other devices.
require_once __DIR__ . '/_account.php';

$pageTitle = "Account & Privacy Settings";
$asFlash = $_SESSION['as_flash'] ?? null; unset($_SESSION['as_flash']);
$asError = null;
$visMap = ['visible' => 'public', 'limited' => 'members', 'hidden' => 'private'];
$asFlags = ['show_mobile', 'show_email', 'show_city', 'show_address', 'show_professional', 'show_family', 'show_matrimony', 'show_marketplace_contact',
    'app_notifications', 'sms_notifications', 'email_notifications', 'community_updates', 'payment_updates'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $op = (string)($_POST['op'] ?? 'settings');
    if (!hash_equals((string)($_SESSION['csrf'] ?? ''), (string)($_POST['csrf'] ?? ''))) $asError = 'Your session expired. Please try again.';
    elseif ($op === 'settings') {
        $p = $acPrefs;
        foreach ($asFlags as $k) $p[$k] = !empty($_POST[$k]);
        // the same keys the app API uses (account_settings / privacy_settings)
        $p['push_enabled'] = $p['app_notifications']; $p['sms_enabled'] = $p['sms_notifications']; $p['email_enabled'] = $p['email_notifications'];
        $p['mobile_visibility'] = $p['show_mobile'] ? 'members' : 'private'; $p['email_visibility'] = $p['show_email'] ? 'members' : 'private';
        $vis = $visMap[$_POST['profile_visibility'] ?? ''] ?? 'members'; $p['profile_visibility'] = $vis;
        db()->prepare('UPDATE users SET prefs=? WHERE id=?')->execute([json_encode($p), $acUid]);
        if (!$p['push_enabled']) db()->prepare('UPDATE device_tokens SET is_active=0 WHERE user_id=?')->execute([$acUid]);
        if ($acMember) pl_entity_update(pl_entity('member'), (int)$acMember['id'], ['profile_visibility' => $vis,
            'contact_visibility' => ($p['show_mobile'] || $p['show_email']) ? 'members' : 'private', 'family_visibility' => $p['show_family'] ? 'members' : 'private']);
        $_SESSION['as_flash'] = 'Your settings have been saved.';
        header('Location: account-settings.php'); exit;
    } elseif ($op === 'logout_others') {
        $n = pl_revoke_all_sessions($acUid, true);
        $_SESSION['as_flash'] = $n ? "Logged out of $n other device(s)." : 'No other devices were logged in.';
        header('Location: account-settings.php'); exit;
    } elseif ($op === 'deactivate') {
        if (!password_verify((string)($_POST['password'] ?? ''), (string)$acUser['password_hash'])) $asError = 'The password is wrong. Your account was not deactivated.';
        else {
            db()->prepare("UPDATE users SET status='deactivated' WHERE id=?")->execute([$acUid]);
            pl_audit('user:deactivated', null, $acUid, 'by user (website)');
            pl_revoke_all_sessions($acUid); pl_session_logout();
            header('Location: ' . DASHBOARD_URL . 'login.php'); exit;
        }
    }
}

$settings = [];
foreach ($asFlags as $k) $settings[$k] = $acPrefs[$k] ?? (in_array($k, ['show_mobile', 'show_email', 'show_address', 'show_family', 'sms_notifications'], true) ? false : true);
foreach (['app_notifications' => 'push_enabled', 'sms_notifications' => 'sms_enabled', 'email_notifications' => 'email_enabled'] as $k => $api) if (isset($acPrefs[$api]) && !isset($acPrefs[$k])) $settings[$k] = (bool)$acPrefs[$api];
$settings['profile_visibility'] = array_flip($visMap)[$acMember['profile_visibility'] ?? ($acPrefs['profile_visibility'] ?? 'members')] ?? 'limited';

include 'header.php';

function settingChecked($settings, $key) {
    return !empty($settings[$key]) ? 'checked' : '';
}
?>

 

<main class="pl-settings-page">
    <div class="pl-settings-container">

        <!-- Page Heading -->
        <section class="pl-settings-hero">
            <div class="pl-settings-hero-icon">
                <i class="bi bi-shield-lock"></i>
            </div>

            <div class="pl-settings-hero-content">
                <span class="pl-eyebrow">YOUR ACCOUNT CONTROL CENTER</span>
                <h1>Account &amp; Privacy Settings</h1>
                <p>
                    Manage your security, personal information, profile visibility
                    and communication preferences in one place.
                </p>
            </div>

            <a href="my-profile.php" class="pl-back-profile">
                <i class="bi bi-arrow-left"></i>
                Back to Profile
            </a>
        </section>

        <!-- Quick Navigation -->
        <nav class="pl-settings-nav" aria-label="Settings sections">
            <a href="#security"><i class="bi bi-shield-check"></i> Security</a>
            <a href="#privacy"><i class="bi bi-eye"></i> Privacy</a>
            <a href="#notifications"><i class="bi bi-bell"></i> Notifications</a>
            <a href="#visibility"><i class="bi bi-person-lines-fill"></i> Visibility</a>
            <a href="#account-management"><i class="bi bi-person-gear"></i> Account</a>
        </nav>

        <form id="accountSettingsForm"
              action="account-settings.php"
              method="POST">

            <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>"><input type="hidden" name="op" value="settings">
<?php if ($asFlash): ?><div class="pl-as-alert ok" role="status"><i class="bi bi-check-circle"></i> <?= htmlspecialchars($asFlash, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
<?php if ($asError): ?><div class="pl-as-alert err" role="alert"><i class="bi bi-exclamation-circle"></i> <?= htmlspecialchars($asError, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>

            <!-- SECURITY -->
            <section class="pl-settings-card" id="security">
                <div class="pl-section-heading">
                    <div class="pl-section-icon blue">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <h2>Account Security</h2>
                        <p>Keep your account details and sign-in sessions secure.</p>
                    </div>
                </div>

                <div class="pl-action-list">
                    <a href="change-password.php" class="pl-action-row">
                        <div class="pl-action-icon">
                            <i class="bi bi-key"></i>
                        </div>
                        <div class="pl-action-text">
                            <strong>Change Password</strong>
                            <span>Update your password to protect your account.</span>
                        </div>
                        <i class="bi bi-chevron-right pl-action-arrow"></i>
                    </a>

                    <a href="edit-profile.php#mobile" class="pl-action-row">
                        <div class="pl-action-icon">
                            <i class="bi bi-phone"></i>
                        </div>
                        <div class="pl-action-text">
                            <strong>Update Mobile Number</strong>
                            <span>Change your number with secure verification.</span>
                        </div>
                        <i class="bi bi-chevron-right pl-action-arrow"></i>
                    </a>

                    <a href="edit-profile.php#email" class="pl-action-row">
                        <div class="pl-action-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="pl-action-text">
                            <strong>Update Email ID</strong>
                            <span>Manage the email address associated with your account.</span>
                        </div>
                        <i class="bi bi-chevron-right pl-action-arrow"></i>
                    </a>

                    <a href="login-devices.php" class="pl-action-row">
                        <div class="pl-action-icon">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <div class="pl-action-text">
                            <strong>Manage Login Devices</strong>
                            <span>Review devices and active login sessions.</span>
                        </div>
                        <i class="bi bi-chevron-right pl-action-arrow"></i>
                    </a>

                    <div class="pl-action-row pl-action-row-button">
                        <div class="pl-action-icon">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                        <div class="pl-action-text">
                            <strong>Logout from Other Devices</strong>
                            <span>End sessions on other devices while keeping this session active.</span>
                        </div>
                        <button type="button"
                                class="pl-outline-button"
                                id="logoutOtherDevices">
                            Logout Other Devices
                        </button>
                    </div>
                </div>
            </section>

            <!-- PRIVACY -->
            <section class="pl-settings-card" id="privacy">
                <div class="pl-section-heading">
                    <div class="pl-section-icon green">
                        <i class="bi bi-eye"></i>
                    </div>
                    <div>
                        <h2>Privacy Settings</h2>
                        <p>Choose which information other members can see.</p>
                    </div>
                </div>

                <div class="pl-privacy-notice">
                    <i class="bi bi-info-circle"></i>
                    <span>
                        These preferences should control visibility throughout PeopleLink.
                        Information required for account security or legal obligations may
                        still be processed as described in the applicable policies.
                    </span>
                </div>

                <div class="pl-toggle-list">
                    <?php
                    $privacyOptions = [
                        ['show_mobile', 'Mobile Number', 'Allow other members to see your mobile number', 'bi-phone'],
                        ['show_email', 'Email Address', 'Allow other members to see your email address', 'bi-envelope'],
                        ['show_city', 'Current City', 'Show your city on your profile', 'bi-geo-alt'],
                        ['show_address', 'Address', 'Allow your saved address to be displayed', 'bi-house'],
                        ['show_professional', 'Professional Details', 'Show your profession and work details', 'bi-briefcase'],
                        ['show_family', 'Family Details', 'Show family-related information', 'bi-people'],
                        ['show_matrimony', 'Matrimony Profile', 'Allow your matrimony profile to be discoverable', 'bi-heart'],
                        ['show_marketplace_contact', 'Marketplace Contact Details', 'Show contact details on your marketplace listings', 'bi-shop'],
                    ];

                    foreach ($privacyOptions as $option):
                        [$key, $title, $description, $icon] = $option;
                    ?>
                        <div class="pl-toggle-row">
                            <div class="pl-toggle-info">
                                <div class="pl-small-icon">
                                    <i class="bi <?= htmlspecialchars($icon, ENT_QUOTES, 'UTF-8') ?>"></i>
                                </div>
                                <div>
                                    <strong><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></strong>
                                    <span><?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            </div>

                            <label class="pl-switch">
                                <input type="checkbox"
                                       name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                                       value="1"
                                       <?= settingChecked($settings, $key) ?>>
                                <span class="pl-switch-slider"></span>
                                <span class="pl-sr-only">
                                    Enable <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?> visibility
                                </span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- COMMUNICATION -->
            <section class="pl-settings-card" id="notifications">
                <div class="pl-section-heading">
                    <div class="pl-section-icon purple">
                        <i class="bi bi-bell"></i>
                    </div>
                    <div>
                        <h2>Communication Preferences</h2>
                        <p>Choose which notifications and updates you want to receive.</p>
                    </div>
                </div>

                <div class="pl-toggle-list">
                    <?php
                    $communicationOptions = [
                        ['app_notifications', 'App Notifications', 'Receive notifications inside PeopleLink'],
                        ['sms_notifications', 'SMS Notifications', 'Receive eligible updates by SMS'],
                        ['email_notifications', 'Email Notifications', 'Receive updates by email'],
                        ['community_updates', 'Important Community Updates', 'Hear about important community announcements'],
                        ['payment_updates', 'Package & Payment Updates', 'Receive package, transaction and payment status updates'],
                    ];

                    foreach ($communicationOptions as $option):
                        [$key, $title, $description] = $option;
                    ?>
                        <div class="pl-toggle-row">
                            <div class="pl-toggle-info">
                                <div class="pl-small-icon">
                                    <i class="bi bi-check2-circle"></i>
                                </div>
                                <div>
                                    <strong><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></strong>
                                    <span><?= htmlspecialchars($description, ENT_QUOTES, 'UTF-8') ?></span>
                                </div>
                            </div>

                            <label class="pl-switch">
                                <input type="checkbox"
                                       name="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                                       value="1"
                                       <?= settingChecked($settings, $key) ?>>
                                <span class="pl-switch-slider"></span>
                                <span class="pl-sr-only">
                                    Enable <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>
                                </span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <p class="pl-small-note">
                    Essential security, account and transaction messages may still be sent
                    when necessary to provide the service.
                </p>
            </section>

            <!-- PROFILE VISIBILITY -->
            <section class="pl-settings-card" id="visibility">
                <div class="pl-section-heading">
                    <div class="pl-section-icon orange">
                        <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <div>
                        <h2>Profile Visibility</h2>
                        <p>Choose how discoverable your profile should be.</p>
                    </div>
                </div>

                <div class="pl-visibility-options">
                    <label class="pl-visibility-option">
                        <input type="radio"
                               name="profile_visibility"
                               value="visible"
                               <?= $settings['profile_visibility'] === 'visible' ? 'checked' : '' ?>>
                        <span class="pl-visibility-content">
                            <span class="pl-visibility-icon visible">
                                <i class="bi bi-globe2"></i>
                            </span>
                            <strong>Visible</strong>
                            <small>Your profile can appear in eligible searches and directories.</small>
                        </span>
                    </label>

                    <label class="pl-visibility-option">
                        <input type="radio"
                               name="profile_visibility"
                               value="limited"
                               <?= $settings['profile_visibility'] === 'limited' ? 'checked' : '' ?>>
                        <span class="pl-visibility-content">
                            <span class="pl-visibility-icon limited">
                                <i class="bi bi-shield-check"></i>
                            </span>
                            <strong>Limited Visibility</strong>
                            <small>Restrict profile discovery and show only permitted information.</small>
                        </span>
                    </label>

                    <label class="pl-visibility-option">
                        <input type="radio"
                               name="profile_visibility"
                               value="hidden"
                               <?= $settings['profile_visibility'] === 'hidden' ? 'checked' : '' ?>>
                        <span class="pl-visibility-content">
                            <span class="pl-visibility-icon hidden">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                            <strong>Hidden</strong>
                            <small>Hide your profile from general discovery where supported.</small>
                        </span>
                    </label>
                </div>
            </section>

            <!-- SAVE SETTINGS -->
            <div class="pl-settings-savebar">
                <div>
                    <strong>Keep your preferences up to date</strong>
                    <span>Your changes take effect after they are saved successfully.</span>
                </div>
                <div class="pl-save-actions">
                    <a href="my-profile.php" class="pl-cancel-button">Cancel</a>
                    <button type="submit" class="pl-save-button" id="saveSettingsButton">
                        <i class="bi bi-check2-circle"></i>
                        Save Settings
                    </button>
                </div>
            </div>
        </form>

        <!-- ACCOUNT MANAGEMENT -->
        <section class="pl-settings-card" id="account-management">
            <div class="pl-section-heading">
                <div class="pl-section-icon blue">
                    <i class="bi bi-person-gear"></i>
                </div>
                <div>
                    <h2>Account Management</h2>
                    <p>Manage blocked profiles, deactivation and deletion requests.</p>
                </div>
            </div>

            <div class="pl-action-list">
                <a href="/peoplelink/module-4/Frontend/pages/privacy.php" class="pl-action-row">
                    <div class="pl-action-icon">
                        <i class="bi bi-person-slash"></i>
                    </div>
                    <div class="pl-action-text">
                        <strong>Blocked Users / Profiles</strong>
                        <span>View and manage profiles you have blocked.</span>
                    </div>
                    <span class="pl-link-label">View Blocked Users <i class="bi bi-arrow-right"></i></span>
                </a>

                <div class="pl-action-row pl-danger-row">
                    <div class="pl-action-icon danger-icon">
                        <i class="bi bi-pause-circle"></i>
                    </div>
                    <div class="pl-action-text">
                        <strong>Deactivate Account</strong>
                        <span>Temporarily disable your account, subject to the account policy.</span>
                    </div>
                    <button type="button" class="pl-danger-outline-button" id="openDeactivateModal">
                        Deactivate Account
                    </button>
                </div>

                <a href="/peoplelink/new/account-deletion.php" class="pl-action-row pl-danger-row">
                    <div class="pl-action-icon danger-icon">
                        <i class="bi bi-trash3"></i>
                    </div>
                    <div class="pl-action-text">
                        <strong>Request Account Deletion</strong>
                        <span>Review the deletion process, consequences and applicable policy.</span>
                    </div>
                    <span class="pl-link-label danger-text">Request Deletion <i class="bi bi-arrow-right"></i></span>
                </a>
            </div>
        </section>

        <!-- POLICIES -->
        <section class="pl-settings-card pl-policy-card">
            <div class="pl-section-heading">
                <div class="pl-section-icon green">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <div>
                    <h2>Terms &amp; Policies</h2>
                    <p>Read the policies that explain your rights and responsibilities.</p>
                </div>
            </div>

            <div class="pl-policy-links">
                <a href="/peoplelink/new/privacy-policy.php">
                    <i class="bi bi-shield-check"></i>
                    <span>Privacy Policy</span>
                    <i class="bi bi-arrow-up-right"></i>
                </a>
                <a href="/peoplelink/new/terms-conditions.php">
                    <i class="bi bi-file-text"></i>
                    <span>Terms &amp; Conditions</span>
                    <i class="bi bi-arrow-up-right"></i>
                </a>
                <a href="/peoplelink/new/community-guidelines.php">
                    <i class="bi bi-people"></i>
                    <span>Community Guidelines</span>
                    <i class="bi bi-arrow-up-right"></i>
                </a>
                <a href="/peoplelink/new/refund-cancellation-policy.php">
                    <i class="bi bi-credit-card"></i>
                    <span>Refund / Cancellation Policy</span>
                    <i class="bi bi-arrow-up-right"></i>
                </a>
            </div>
        </section>

    </div>
</main>
<style>.pl-as-alert{border-radius:12px;padding:14px 18px;margin:0 0 18px;font-weight:600}.pl-as-alert.ok{background:#e9f8ee;color:#17663a;border:1px solid #b9e6c8}.pl-as-alert.err{background:#fdecee;color:#9b1c2c;border:1px solid #f5c2c9}</style>

<!-- Deactivation Confirmation Modal -->
<div class="pl-modal-backdrop" id="deactivateModal" aria-hidden="true">
    <div class="pl-confirm-modal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="deactivateModalTitle">

        <div class="pl-confirm-icon">
            <i class="bi bi-exclamation-triangle"></i>
        </div>

        <button type="button" class="pl-modal-close" id="closeDeactivateModal"
                aria-label="Close dialog">
            <i class="bi bi-x-lg"></i>
        </button>

        <h2 id="deactivateModalTitle">Deactivate your account?</h2>
        <p>
            You may lose access to PeopleLink features while your account is deactivated.
            Review the account policy before continuing.
        </p>

        <form action="account-settings.php" method="POST" id="deactivateAccountForm">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>"><input type="hidden" name="op" value="deactivate">
            <label for="deactivatePassword" style="display:block;font-weight:600;margin:0 0 6px">Enter your password to confirm</label>
            <input type="password" id="deactivatePassword" name="password" required autocomplete="current-password" style="width:100%;padding:11px 14px;border:1px solid #d6dbe3;border-radius:10px;margin-bottom:14px">
            <label class="pl-confirm-checkbox">
                <input type="checkbox" id="confirmDeactivation" required>
                <span>I understand that my account will be deactivated.</span>
            </label>

            <div class="pl-modal-actions">
                <button type="button" class="pl-cancel-button" id="cancelDeactivate">
                    Cancel
                </button>
                <button type="submit" class="pl-danger-button" id="confirmDeactivateButton" disabled>
                    Confirm Deactivation
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Confirmation for logging out other devices -->
<div class="pl-modal-backdrop" id="logoutModal" aria-hidden="true">
    <div class="pl-confirm-modal" role="dialog" aria-modal="true"
         aria-labelledby="logoutModalTitle">
        <button type="button" class="pl-modal-close" id="closeLogoutModal"
                aria-label="Close dialog">
            <i class="bi bi-x-lg"></i>
        </button>

        <div class="pl-confirm-icon">
            <i class="bi bi-laptop"></i>
        </div>

        <h2 id="logoutModalTitle">Logout from other devices?</h2>
        <p>
            Other active sessions will be ended. You will remain signed in on this device.
        </p>

        <form action="account-settings.php" method="POST">
            <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>"><input type="hidden" name="op" value="logout_others">
            <div class="pl-modal-actions">
                <button type="button" class="pl-cancel-button" id="cancelLogout">
                    Cancel
                </button>
                <button type="submit" class="pl-danger-button">
                    Logout Other Devices
                </button>
            </div>
        </form>
    </div>
</div>

<div class="pl-settings-toast" id="settingsToast" role="status" aria-live="polite"></div>

 

<?php include 'footer.php'; ?>
