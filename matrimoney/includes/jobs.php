<?php
// Jobs module helpers, shared by the admin panel and the API. Loaded from modules.php - do not include directly.
// One backend for Community and Global jobs: jobs.visibility_type (community|global) + jobs.community_id.
// Registry entries: 'job' and 'job_application' in PL_ENTITIES. App API: includes/jobs_api.php.

const PL_RESUME_DIR = __DIR__ . '/../uploads/resumes/';
const PL_RESUME_TYPES = ['pdf' => 'application/pdf', 'doc' => 'application/msword', 'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];

pl_need_column('jobs', 'priority', 'INT DEFAULT 0');
pl_need_column('jobs', 'user_package_id', 'INT NULL');
pl_need_column('jobs_applications', 'resume_path', 'VARCHAR(255) NULL');
pl_need_column('jobs_applications', 'resume_name', 'VARCHAR(200) NULL');
pl_need_column('user_packages', 'posts_used', 'INT DEFAULT 0');
pl_need_table('job_resumes', 'CREATE TABLE IF NOT EXISTS job_resumes (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, path VARCHAR(255) NOT NULL, name VARCHAR(200) NULL,
    mime VARCHAR(100) NULL, size INT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user (user_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

/* ---------- resumes: private folder, served only through api.php?action=jobs_resume_download ---------- */

function pl_job_resume_dir(): bool {
    if (!is_dir(PL_RESUME_DIR) && !@mkdir(PL_RESUME_DIR, 0755, true)) return false;
    if (!is_file(PL_RESUME_DIR . '.htaccess')) @file_put_contents(PL_RESUME_DIR . '.htaccess', "<IfModule mod_authz_core.c>\n  Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n  Order allow,deny\n  Deny from all\n</IfModule>\n");
    if (!is_file(PL_RESUME_DIR . 'index.html')) @file_put_contents(PL_RESUME_DIR . 'index.html', '');
    return is_writable(PL_RESUME_DIR);
}

function pl_job_resume_valid(?string $path): bool { return $path !== null && (bool)preg_match('/^\d{8}-[a-f0-9]{24}\.(pdf|docx?)$/', $path); }

function pl_job_resume_store(array $f): array {
    $msg = 'Resume must be a PDF, DOC or DOCX file up to ' . pl_setting('max_upload_mb') . ' MB.';
    if (($f['error'] ?? 4) !== UPLOAD_ERR_OK || $f['size'] > max(1, pl_setting('max_upload_mb')) * 1048576 || !is_uploaded_file($f['tmp_name'])) return ['error' => $msg];
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $ext = strtolower(pathinfo((string)$f['name'], PATHINFO_EXTENSION));
    $type = array_search($mime, PL_RESUME_TYPES, true);
    // older libmagic reports DOCX as a zip and DOC as an OLE container
    if (!$type && $ext === 'docx' && in_array($mime, ['application/zip', 'application/octet-stream'], true) && file_get_contents($f['tmp_name'], false, null, 0, 4) === "PK\x03\x04") $type = 'docx';
    if (!$type && $ext === 'doc' && in_array($mime, ['application/CDFV2', 'application/x-ole-storage', 'application/vnd.ms-office'], true)) $type = 'doc';
    if (!$type) return ['error' => $msg];
    if (!pl_job_resume_dir()) return ['error' => 'Upload folder is not writable.'];
    $path = date('Ymd') . '-' . bin2hex(random_bytes(12)) . '.' . $type;
    if (!move_uploaded_file($f['tmp_name'], PL_RESUME_DIR . $path)) return ['error' => 'Could not save the resume.'];
    $name = mb_substr(preg_replace('/[^\w .()\-]/u', '', basename((string)$f['name'])) ?: 'resume.' . $type, 0, 200);
    return ['path' => $path, 'name' => $name, 'mime' => PL_RESUME_TYPES[$type], 'size' => (int)$f['size']];
}

/* applications keep their own copy, so replacing the saved resume never changes a sent application */
function pl_job_resume_copy(string $path): ?string {
    if (!pl_job_resume_valid($path) || !is_file(PL_RESUME_DIR . $path)) return null;
    $new = date('Ymd') . '-' . bin2hex(random_bytes(12)) . '.' . pathinfo($path, PATHINFO_EXTENSION);
    return @copy(PL_RESUME_DIR . $path, PL_RESUME_DIR . $new) ? $new : null;
}

function pl_job_resume_unlink(?string $path): void {
    if (pl_job_resume_valid($path) && is_file(PL_RESUME_DIR . $path)) @unlink(PL_RESUME_DIR . $path);
}

function pl_job_resume_send(string $path, ?string $name): void {
    if (!pl_job_resume_valid($path) || !is_file(PL_RESUME_DIR . $path)) { http_response_code(404); header('Content-Type: application/json'); echo json_encode(['ok' => false, 'code' => 'NOT_FOUND', 'error' => 'Resume file not found.']); exit; }
    $ext = pathinfo($path, PATHINFO_EXTENSION);
    $name = $name ?: 'resume.' . $ext;
    header('Content-Type: ' . PL_RESUME_TYPES[$ext]);
    header('Content-Length: ' . filesize(PL_RESUME_DIR . $path));
    header('Content-Disposition: ' . ($ext === 'pdf' ? 'inline' : 'attachment') . '; filename="' . str_replace('"', '', $name) . '"');
    header('X-Content-Type-Options: nosniff');
    header('Cache-Control: private, no-store');
    readfile(PL_RESUME_DIR . $path); exit;
}

function pl_job_resume_url(int $applicationId): string { return DASHBOARD_URL . 'api.php?action=jobs_resume_download&application_id=' . $applicationId; }

function pl_job_saved_resume(int $uid): ?array { return rows('SELECT * FROM job_resumes WHERE user_id=?', [$uid])[0] ?? null; }

function pl_job_saved_resume_out(?array $r): ?array {
    return $r ? ['name' => $r['name'], 'mime' => $r['mime'], 'size' => (int)$r['size'], 'updated_at' => $r['updated_at'] ?: $r['created_at'],
        'download_url' => DASHBOARD_URL . 'api.php?action=jobs_resume_download'] : null;
}

/* ---------- jobs ---------- */

/* null when the job takes applications, otherwise the reason */
function pl_job_closed_reason(array $r): ?string {
    if ($r['status'] !== 'approved' || !(int)$r['is_active']) return 'This job is not accepting applications.';
    if ($r['closing_date'] && $r['closing_date'] < date('Y-m-d')) return 'Applications for this job are closed.';
    if ($r['application_start_date'] && $r['application_start_date'] > date('Y-m-d')) return 'Applications open on ' . date('d M Y', strtotime($r['application_start_date'])) . '.';
    return null;
}

function pl_job_methods(array $r): array {
    $m = ['in_app'];
    if (in_array($r['apply_via'], ['email', 'both'], true) && $r['application_email']) $m[] = 'email';
    if (in_array($r['apply_via'], ['whatsapp', 'both'], true) && $r['whatsapp']) $m[] = 'whatsapp';
    return $m;
}

/* email / WhatsApp details for someone who applied (or the poster chose to show them) */
function pl_job_contact(array $r, ?array $user = null): array {
    $m = pl_job_methods($r);
    $subject = 'Application for ' . $r['job_title'];
    $text = 'Hello' . ($r['contact_person'] ? ' ' . $r['contact_person'] : '') . ', I would like to apply for "' . $r['job_title'] . '" posted on PeopleLink.' . ($user ? ' - ' . $user['name'] : '');
    $wa = preg_replace('/\D/', '', (string)$r['whatsapp']);
    if ($wa !== '' && strlen($wa) === 10) $wa = '91' . $wa;
    return [
        'contact_person' => $r['contact_person'],
        'email' => in_array('email', $m, true) ? $r['application_email'] : null,
        'mailto' => in_array('email', $m, true) ? 'mailto:' . $r['application_email'] . '?subject=' . rawurlencode($subject) . '&body=' . rawurlencode($text) : null,
        'whatsapp' => in_array('whatsapp', $m, true) ? $r['whatsapp'] : null,
        'whatsapp_link' => in_array('whatsapp', $m, true) ? 'https://wa.me/' . $wa . '?text=' . rawurlencode($text) : null,
        'whatsapp_masked' => false,
    ];
}

function pl_job_salary_text(array $r): ?string {
    $mn = $r['salary_min'] !== null ? (float)$r['salary_min'] : null; $mx = $r['salary_max'] !== null ? (float)$r['salary_max'] : null;
    if (!$mn && !$mx) return null;
    $f = fn($n) => '₹' . number_format($n);
    $per = ['month' => ' per month', 'year' => ' per year', 'day' => ' per day', 'hour' => ' per hour'][$r['salary_period'] ?? ''] ?? '';
    return ($mn && $mx ? ($mn == $mx ? $f($mn) : $f($mn) . ' - ' . $f($mx)) : ($mn ? 'From ' . $f($mn) : 'Up to ' . $f($mx))) . $per;
}

/* job for the app: registry output + apply / package information. $extra: saved, application (row of the viewer's application) */
function pl_job_out(array $r, ?int $uid, bool $full = false, array $extra = []): array {
    $E = pl_entity('job');
    $o = pl_ent_out($E, $r, $uid, $full);
    $app = $extra['application'] ?? null;
    // applicants see the contact details even when the poster keeps them hidden
    if ($app && !empty($o['contact_hidden'])) { foreach (['application_email', 'whatsapp'] as $c) $o[$c] = $r[$c]; unset($o['contact_hidden']); }
    $o['is_global'] = $r['visibility_type'] === 'global';
    $o['salary_text'] = pl_job_salary_text($r);
    $o['apply_methods'] = pl_job_methods($r);
    $reason = pl_job_closed_reason($r);
    $o['accepting_applications'] = $reason === null;
    if ($reason) $o['not_accepting_reason'] = $reason;
    $o['days_left'] = $r['closing_date'] ? (int)floor((strtotime($r['closing_date']) - strtotime('today')) / 86400) : null;
    if (array_key_exists('saved', $extra)) $o['saved'] = (bool)$extra['saved'];
    $o['applied'] = (bool)$app;
    $o['application_status'] = $app['status'] ?? null;
    if ($full && $app) $o['contact'] = pl_job_contact($r);
    if ($o['is_own']) {
        $o['applications_count'] = scalar('SELECT COUNT(*) FROM jobs_applications WHERE job_id=?', [$r['id']]);
        $o['new_applications'] = scalar("SELECT COUNT(*) FROM jobs_applications WHERE job_id=? AND status='applied'", [$r['id']]);
        $o['views'] = (int)$r['views'];
    }
    return $o;
}

function pl_job_app_out(array $a, ?array $job = null, bool $forPoster = false): array {
    $o = ['id' => (int)$a['id'], 'application_code' => $a['application_code'], 'job_id' => (int)$a['job_id'],
        'job_title' => $job['job_title'] ?? null, 'company_name' => $job['company_name'] ?? null, 'job_status' => $job['status'] ?? null,
        'applicant_name' => $a['applicant_name'], 'email' => $a['email'], 'phone' => $a['phone'], 'total_experience' => $a['total_experience'],
        'current_location' => $a['current_location'], 'cover_letter' => $a['cover_letter'], 'apply_method' => $a['apply_method'], 'status' => $a['status'],
        'has_resume' => (bool)$a['resume_path'], 'resume_name' => $a['resume_name'], 'resume_url' => $a['resume_path'] ? pl_job_resume_url((int)$a['id']) : null,
        'applied_at' => $a['created_at'], 'updated_at' => $a['updated_at']];
    if ($forPoster) $o['applicant_user_id'] = $a['user_id'] ? (int)$a['user_id'] : null;
    return $o;
}

/* application status change by the poster or the admin: audit + notify the applicant */
function pl_job_app_status_changed(array $app, string $new, bool $audit = true): void {
    if ($audit) pl_audit('status:' . $new, 'job_application', (int)$app['id'], $app['applicant_name'], $app['community_id'] ? (int)$app['community_id'] : null);
    if (!$app['user_id'] || !in_array($new, ['shortlisted', 'rejected', 'closed'], true)) return;
    $job = rows('SELECT job_title, company_name FROM jobs WHERE id=?', [$app['job_id']])[0] ?? null;
    $t = $job['job_title'] ?? 'a job';
    $msg = ['shortlisted' => "Good news! You have been shortlisted for \"$t\"" . ($job ? ' at ' . $job['company_name'] : '') . '. The employer will contact you.',
        'rejected' => "Your application for \"$t\" was not selected this time. Keep applying!",
        'closed' => "Your application for \"$t\" has been closed."][$new];
    pl_notify_user((int)$app['user_id'], $app['community_id'] ? (int)$app['community_id'] : null,
        ['shortlisted' => 'Application shortlisted', 'rejected' => 'Application update', 'closed' => 'Application closed'][$new], $msg, 'job_application', 'jobs_applications', (int)$app['id']);
}

/* ---------- Global Job Packages: quota of global job posts per purchased package ---------- */

function pl_job_package_out(array $p): array {
    return ['id' => (int)$p['id'], 'name' => $p['name'], 'price' => (float)$p['price'], 'validity_days' => (int)$p['validity_days'], 'job_posts' => (int)$p['job_posts'],
        'featured_listing' => (bool)$p['featured_listing'], 'priority_visibility' => (bool)$p['priority_visibility'], 'description' => $p['description'],
        'features' => array_values(array_filter(array_map('trim', preg_split('/\R/', (string)$p['features'])))), 'is_active' => (bool)$p['is_active']];
}

/* active jobs packages of a user, soonest expiry first, with remaining posts */
function pl_job_credits(int $uid): array {
    db()->prepare("UPDATE user_packages SET status='expired' WHERE user_id=? AND status='active' AND expires_at < NOW()")->execute([$uid]);
    return array_map(fn($r) => $r + ['remaining' => max(0, (int)$r['job_posts'] - (int)$r['posts_used'])],
        rows("SELECT up.id, up.package_id, up.starts_at, up.expires_at, up.posts_used, p.name, COALESCE(p.job_posts,0) job_posts, COALESCE(p.featured_listing,0) featured_listing,
            COALESCE(p.priority_visibility,0) priority_visibility FROM user_packages up JOIN packages p ON p.id=up.package_id
            WHERE up.user_id=? AND up.module_key='jobs' AND up.status='active' AND up.expires_at > NOW() ORDER BY up.expires_at, up.id", [$uid]));
}

function pl_job_remaining(int $uid): int { return array_sum(array_column(pl_job_credits($uid), 'remaining')); }

/* takes one post from the package that expires first; null when none is left */
function pl_job_use_credit(int $uid): ?array {
    foreach (pl_job_credits($uid) as $c) {
        if ($c['remaining'] < 1) continue;
        $st = db()->prepare('UPDATE user_packages SET posts_used=posts_used+1 WHERE id=? AND posts_used < ?');
        $st->execute([$c['id'], (int)$c['job_posts']]);
        if ($st->rowCount()) return $c;
    }
    return null;
}

/* called by pl_activate_package (payments.php) */
function pl_job_package_activated(array $t, array $pk, int $userPackageId, string $expires): void {
    $n = (int)($pk['job_posts'] ?? 0);
    pl_notify_user((int)$t['user_id'], $t['community_id'] ? (int)$t['community_id'] : null, 'Global job package activated',
        $pk['name'] . ' is active until ' . date('d M Y', strtotime($expires)) . '.' . ($n ? " You can post $n global job" . ($n === 1 ? '' : 's') . '.' : ''), 'job_package', 'user_packages', $userPackageId);
}

/* ---------- daily reminders (run by the first jobs request of the day; no cron needed) ---------- */

function pl_jobs_daily(): void {
    try {
        $today = date('Y-m-d');
        if ((string)pl_setting('jobs_daily_run') === $today) return;
        pl_setting_set('jobs_daily_run', $today);
        $days = max(1, pl_setting('jobs_closing_notice_days'));
        $sent = fn(int $uid, string $type, string $entity, int $id) => scalar('SELECT COUNT(*) FROM user_notifications WHERE user_id=? AND type=? AND entity=? AND entity_id=? AND created_at >= NOW() - INTERVAL ? DAY', [$uid, $type, $entity, $id, $days + 1]);
        foreach (rows("SELECT id, user_id, community_id, job_title, closing_date FROM jobs WHERE status='approved' AND is_active=1 AND user_id IS NOT NULL AND closing_date BETWEEN CURDATE() AND CURDATE() + INTERVAL ? DAY", [$days]) as $j)
            if (!$sent((int)$j['user_id'], 'job_closing', 'jobs', (int)$j['id']))
                pl_notify_user((int)$j['user_id'], $j['community_id'] ? (int)$j['community_id'] : null, 'Job closing soon', 'Your job "' . $j['job_title'] . '" closes on ' . date('d M Y', strtotime($j['closing_date'])) . '. Renew it from My Posted Jobs to keep receiving applications.', 'job_closing', 'jobs', (int)$j['id']);
        foreach (rows("SELECT up.id, up.user_id, up.community_id, up.expires_at, p.name FROM user_packages up JOIN packages p ON p.id=up.package_id WHERE up.module_key='jobs' AND up.status='active' AND up.expires_at BETWEEN NOW() AND NOW() + INTERVAL 3 DAY") as $p)
            if (!$sent((int)$p['user_id'], 'package_expiry', 'user_packages', (int)$p['id']))
                pl_notify_user((int)$p['user_id'], $p['community_id'] ? (int)$p['community_id'] : null, 'Package expiring soon', 'Your ' . $p['name'] . ' package expires on ' . date('d M Y', strtotime($p['expires_at'])) . '. Unused job posts expire with it.', 'package_expiry', 'user_packages', (int)$p['id']);
    } catch (Throwable $e) { error_log('PL jobs daily: ' . $e->getMessage()); }
}
