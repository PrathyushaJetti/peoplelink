<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/helpers.php';

const PL_UPLOAD_DIR = __DIR__ . '/../uploads/photos/';
const PL_UPLOAD_URL = DASHBOARD_URL . 'uploads/photos/';
const PL_MAX_PHOTOS = 6;
const PL_MAX_BYTES  = 5242880;

$GLOBALS['PL_SCHEMA'] = [
    'users' => ['community_id' => 'INT NULL'],
    'matrimony_profiles' => [
        'user_id' => 'INT NULL', 'dob' => 'DATE NULL', 'height' => 'VARCHAR(20) NULL', 'mother_tongue' => 'VARCHAR(60) NULL',
        'district' => 'VARCHAR(80) NULL', 'state' => 'VARCHAR(80) NULL', 'country' => 'VARCHAR(80) NULL', 'email' => 'VARCHAR(160) NULL',
        'about' => 'TEXT NULL', 'details' => 'LONGTEXT NULL',
    ],
    'communities' => ['about' => 'TEXT NULL', 'intro' => 'TEXT NULL', 'history' => 'TEXT NULL', 'values_text' => 'TEXT NULL', 'sort_order' => 'INT DEFAULT 0'],
    'matrimony_photos' => ['is_primary' => 'TINYINT DEFAULT 0'],
    'matrimony_interests' => ['message' => 'TEXT NULL'],
    'matrimony_preferences' => ['data' => 'LONGTEXT NULL'],
];
$GLOBALS['PL_TABLES'] = [
    'device_tokens' => 'CREATE TABLE IF NOT EXISTS device_tokens (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, platform VARCHAR(20) NULL,
        device_id VARCHAR(120) NULL, app_version VARCHAR(30) NULL, is_active TINYINT DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, UNIQUE KEY uq_token (token), KEY idx_user (user_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
    'matrimony_preferences' => 'CREATE TABLE IF NOT EXISTS matrimony_preferences (id INT AUTO_INCREMENT PRIMARY KEY, profile_id INT NOT NULL UNIQUE, age_min INT NULL, age_max INT NULL,
        location VARCHAR(120) NULL, education VARCHAR(80) NULL, profession VARCHAR(80) NULL, marital_status VARCHAR(30) NULL, other TEXT NULL, data LONGTEXT NULL,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
    'matrimony_saved' => 'CREATE TABLE IF NOT EXISTS matrimony_saved (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, profile_id INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uq_saved (user_id, profile_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
    'matrimony_blocks' => 'CREATE TABLE IF NOT EXISTS matrimony_blocks (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, profile_id INT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY uq_block (user_id, profile_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
    'matrimony_support' => 'CREATE TABLE IF NOT EXISTS matrimony_support (id INT AUTO_INCREMENT PRIMARY KEY, community_id INT NULL, user_id INT NOT NULL, title VARCHAR(200),
        category VARCHAR(80), assistance_type VARCHAR(80), contact_name VARCHAR(120), phone VARCHAR(30), email VARCHAR(160), location VARCHAR(160), required_by DATE NULL,
        visibility VARCHAR(40), description TEXT, data LONGTEXT NULL, status VARCHAR(20) DEFAULT \'open\', created_at DATETIME DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4',
];

function pl_need_column(string $table, string $col, string $type): void { $GLOBALS['PL_SCHEMA'][$table][$col] = $type; }
function pl_need_table(string $name, string $sql): void { $GLOBALS['PL_TABLES'][$name] = $sql; }

function pl_ensure_schema(): void {
    $sig = md5(json_encode([$GLOBALS['PL_SCHEMA'], array_keys($GLOBALS['PL_TABLES'])]));
    if (($_SESSION['pl_schema'] ?? '') === $sig) return;
    // one marker file per schema version, so new visitors do not re-check every table
    $mark = __DIR__ . '/../uploads/.schema-' . $sig;
    if (is_file($mark)) { $_SESSION['pl_schema'] = $sig; return; }
    foreach ($GLOBALS['PL_TABLES'] as $sql) db()->exec($sql);
    foreach ($GLOBALS['PL_SCHEMA'] as $table => $cols) {
        $have = array_column(rows("SHOW COLUMNS FROM $table"), 'Field');
        foreach ($cols as $col => $type) if (!in_array($col, $have, true)) db()->exec("ALTER TABLE $table ADD COLUMN $col $type");
    }
    $_SESSION['pl_schema'] = $sig;
    @touch($mark);
}

function pl_community_by(string $v): ?array {
    $v = trim($v);
    if ($v === '') return null;
    $slug = strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $v), '-'));
    $flat = str_replace('-', '', $slug); // "arya-vysya" and "aryavysya" are the same community
    return rows("SELECT * FROM communities WHERE is_active=1 AND (slug=? OR slug=? OR REPLACE(slug,'-','')=? OR LOWER(name)=LOWER(?)) LIMIT 1", [$v, $slug, $flat, $v])[0] ?? null;
}

function pl_resolve_community(?int $uid = null): ?array {
    // Community asked for in the request (navigation only - NOT trusted for members)
    $req = null;
    foreach ([$_POST['c'] ?? null, $_POST['community'] ?? null, $_GET['c'] ?? null, $_GET['community'] ?? null] as $v) {
        if ($v && is_scalar($v) && ($c = pl_community_by((string)$v))) { $req = $c; break; }
    }
    $sess = !empty($_SESSION['community_slug']) ? pl_community_by($_SESSION['community_slug']) : null;

    if ($uid) {
        $u = rows('SELECT role, community_id FROM users WHERE id=?', [$uid])[0] ?? null;
        if ($u && $u['role'] !== 'admin') {
            // Members are locked to ONE community, decided on the server.
            $own = null;
            if (!empty($u['community_id'])) $own = rows('SELECT * FROM communities WHERE id=?', [(int)$u['community_id']])[0] ?? null;
            if (!$own) $own = rows('SELECT c.* FROM matrimony_profiles p JOIN communities c ON c.id=p.community_id WHERE p.user_id=? ORDER BY p.id DESC LIMIT 1', [$uid])[0] ?? null;
            if (!$own) $own = $req ?: $sess;                       // first choice becomes the member's community
            if (!$own) return null;
            if (empty($u['community_id'])) db()->prepare('UPDATE users SET community_id=? WHERE id=?')->execute([(int)$own['id'], $uid]);
            if ($req && (int)$req['id'] !== (int)$own['id']) $GLOBALS['PL_COMMUNITY_MISMATCH'] = true;
            $_SESSION['community_slug'] = $own['slug'];
            return $own;
        }
    }

    // visitors (not logged in) and admins keep the free choice
    if ($req) { $_SESSION['community_slug'] = $req['slug']; return $req; }
    if ($sess) return $sess;
    if ($uid) {
        $r = rows('SELECT c.* FROM matrimony_profiles p JOIN communities c ON c.id=p.community_id WHERE p.user_id=? ORDER BY p.id DESC LIMIT 1', [$uid])[0] ?? null;
        if ($r) { $_SESSION['community_slug'] = $r['slug']; return $r; }
    }
    return null;
}

function pl_reserved(): array { return ['csrf', 'action', 'c', 'redirect', 'next', 'profile_photos', 'photos', 'photo', 'supporting_document']; }

function pl_collect(array $in): array {
    $out = [];
    foreach ($in as $k => $v) {
        if (in_array($k, pl_reserved(), true) || !is_string($k) || !preg_match('/^[A-Za-z0-9_\-]{1,60}$/', $k)) continue;
        if (is_array($v)) $out[$k] = array_values(array_map(fn($x) => mb_substr(trim((string)$x), 0, 200), array_filter($v, 'is_scalar')));
        elseif (is_scalar($v)) $out[$k] = mb_substr(trim((string)$v), 0, 3000);
    }
    return $out;
}

function pl_pick(array $d, array $keys): ?string {
    foreach ($keys as $k) if (isset($d[$k]) && !is_array($d[$k]) && $d[$k] !== '') return (string)$d[$k];
    return null;
}

function pl_columns(array $d): array {
    $c = [];
    $map = ['full_name' => ['full_name', 'name'], 'gender' => ['gender'], 'marital_status' => ['marital_status'], 'height' => ['height'],
        'mother_tongue' => ['mother_tongue'], 'education' => ['qualification', 'education'], 'profession' => ['profession'], 'city' => ['city'],
        'district' => ['district'], 'state' => ['state'], 'country' => ['country'], 'phone' => ['mobile', 'phone'], 'email' => ['email'],
        'about' => ['about_me', 'about']];
    foreach ($map as $col => $keys) { $v = pl_pick($d, $keys); if ($v !== null) $c[$col] = mb_substr($v, 0, $col === 'about' ? 3000 : 120); }
    if (isset($c['gender'])) { $g = strtolower($c['gender'][0]); $c['gender'] = $g === 'f' ? 'Female' : ($g === 'm' ? 'Male' : ''); }
    if (isset($c['email']) && !filter_var($c['email'], FILTER_VALIDATE_EMAIL)) $c['email'] = '';
    $dob = pl_pick($d, ['date_of_birth', 'dob']);
    if ($dob !== null) {
        try { $c['dob'] = (new DateTime($dob))->format('Y-m-d'); $c['age'] = (new DateTime($dob))->diff(new DateTime())->y; } catch (Exception $e) {}
    }
    if (!isset($c['age']) && ($a = pl_pick($d, ['age'])) !== null) $c['age'] = (int)$a;
    return $c;
}

function pl_details(array $row): array { return json_decode($row['details'] ?? '', true) ?: []; }

function pl_my_profile(int $uid, ?int $cid = null): ?array {
    if ($cid) return rows('SELECT * FROM matrimony_profiles WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [$uid, $cid])[0] ?? null;
    return rows('SELECT * FROM matrimony_profiles WHERE user_id=? ORDER BY id DESC LIMIT 1', [$uid])[0] ?? null;
}

function pl_create_profile(int $uid, int $cid, array $in): array {
    if (pl_my_profile($uid, $cid)) return ['error' => 'You already have a profile in this community.'];
    $d = pl_collect($in); $c = pl_columns($d);
    if (($c['full_name'] ?? '') === '') return ['error' => 'Full name is required.'];
    if (($c['gender'] ?? '') === '') return ['error' => 'Please select gender.'];
    if (($c['age'] ?? 0) < 18 || $c['age'] > 80) return ['error' => 'Age must be between 18 and 80.'];
    $cols = array_merge(['community_id', 'user_id', 'profile_code', 'status', 'is_active', 'details'], array_keys($c));
    $vals = array_merge([$cid, $uid, 'PL-TMP', 'pending', 1, json_encode($d, JSON_UNESCAPED_UNICODE)], array_values($c));
    db()->prepare('INSERT INTO matrimony_profiles (' . implode(',', $cols) . ') VALUES (' . implode(',', array_fill(0, count($cols), '?')) . ')')->execute($vals);
    $id = (int)db()->lastInsertId();
    db()->prepare('UPDATE matrimony_profiles SET profile_code=? WHERE id=?')->execute(['PL-MAT-' . (1000 + $id), $id]);
    notify($cid, 'Profile submitted', $c['full_name'] . ' — your matrimony profile is submitted and waiting for approval.', 'approval', 'profile:' . $id);
    if (!empty($in['partner_age_min']) || !empty($in['partner_education']) || !empty($in['partner_location']) || !empty($in['other_preferences'])) pl_save_prefs($uid, $cid, $in);
    return ['id' => $id, 'profile_code' => 'PL-MAT-' . (1000 + $id), 'message' => 'Profile submitted for approval.'];
}

function pl_update_profile(int $uid, int $cid, array $in): array {
    $p = pl_my_profile($uid, $cid);
    if (!$p) return ['error' => 'Create your profile first.'];
    $d = pl_collect($in); $c = pl_columns($d);
    if (isset($c['full_name']) && $c['full_name'] === '') return ['error' => 'Full name is required.'];
    if (isset($c['age']) && ($c['age'] < 18 || $c['age'] > 80)) return ['error' => 'Age must be between 18 and 80.'];
    if (!$d) return ['error' => 'Nothing to update.'];
    $c['details'] = json_encode(array_merge(pl_details($p), $d), JSON_UNESCAPED_UNICODE);
    $set = implode(',', array_map(fn($k) => "$k=?", array_keys($c)));
    $status = $p['status'] === 'approved' ? ", status='pending'" : '';
    db()->prepare("UPDATE matrimony_profiles SET $set$status WHERE id=?")->execute(array_merge(array_values($c), [$p['id']]));
    if (!empty($in['partner_age_min']) || !empty($in['partner_education']) || !empty($in['partner_location']) || !empty($in['other_preferences'])) pl_save_prefs($uid, $cid, $in);
    return ['id' => (int)$p['id'], 'message' => $status ? 'Profile updated and sent for re-approval.' : 'Profile updated.'];
}

function pl_prefs(int $profileId): array {
    $r = rows('SELECT * FROM matrimony_preferences WHERE profile_id=?', [$profileId])[0] ?? null;
    if (!$r) return [];
    $r['data'] = json_decode($r['data'] ?? '', true) ?: [];
    return $r;
}

function pl_save_prefs(int $uid, int $cid, array $in): array {
    $p = pl_my_profile($uid, $cid);
    if (!$p) return ['error' => 'Create your profile first.'];
    $d = pl_collect($in);
    $g = fn(array $k) => pl_pick($d, $k);
    $min = (int)($g(['min_age', 'age_min', 'partner_age_min']) ?? 0) ?: null; $max = (int)($g(['max_age', 'age_max', 'partner_age_max']) ?? 0) ?: null;
    $first = fn($k) => is_array($d[$k] ?? null) ? implode(', ', $d[$k]) : ($d[$k] ?? '');
    $loc = $g(['partner_location']) ?? trim(implode(', ', array_filter([$d['city'] ?? '', $d['state'] ?? '', $d['country'] ?? ''])));
    $v = [$min, $max, mb_substr($loc, 0, 120), mb_substr($first('education') ?: $first('partner_education'), 0, 80), mb_substr($first('profession') ?: $first('partner_profession'), 0, 80),
          mb_substr($first('marital_status') ?: $first('partner_marital_status'), 0, 30), mb_substr($g(['other_preferences', 'other']) ?? '', 0, 2000), json_encode($d, JSON_UNESCAPED_UNICODE)];
    db()->prepare('INSERT INTO matrimony_preferences (profile_id,age_min,age_max,location,education,profession,marital_status,other,data) VALUES (?,?,?,?,?,?,?,?,?)
        ON DUPLICATE KEY UPDATE age_min=VALUES(age_min),age_max=VALUES(age_max),location=VALUES(location),education=VALUES(education),profession=VALUES(profession),marital_status=VALUES(marital_status),other=VALUES(other),data=VALUES(data)')
        ->execute(array_merge([$p['id']], $v));
    return ['message' => 'Partner preferences saved.'];
}

function pl_photo_out(array $r): array {
    $full = (string)$r['image_url'];
    $cut = strrpos($full, '/');
    $thumbName = 'th_' . basename($full);
    $thumb = ($cut !== false && is_file(PL_UPLOAD_DIR . $thumbName)) ? substr($full, 0, $cut + 1) . $thumbName : $full;
    return array_merge($r, [
        'photo_id' => (int)$r['id'], 'thumbnail_url' => $thumb, 'full_url' => $full,
        'is_primary' => (int)$r['is_primary'], 'approval_status' => (string)$r['status'],
    ]);
}

function pl_photos(int $profileId, bool $approvedOnly = true): array {
    $list = rows('SELECT id,image_url,status,is_primary FROM matrimony_photos WHERE profile_id=?' . ($approvedOnly ? " AND status='approved'" : '') . ' ORDER BY is_primary DESC, id', [$profileId]);
    return array_map('pl_photo_out', $list);
}

/* Resize + compress an uploaded image (GD). Returns false if GD cannot handle it. */
function pl_save_image(string $tmp, string $mime, string $dest, string $thumbDest): bool {
    if (!function_exists('imagecreatetruecolor')) return false;
    $src = $mime === 'image/png' ? @imagecreatefrompng($tmp) : ($mime === 'image/webp' ? (function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($tmp) : false) : @imagecreatefromjpeg($tmp));
    if (!$src) return false;
    if ($mime === 'image/jpeg' && function_exists('exif_read_data')) {
        $ex = @exif_read_data($tmp);
        $o = $ex['Orientation'] ?? 1;
        $rot = [3 => 180, 6 => -90, 8 => 90][$o] ?? 0;
        if ($rot) { $r = imagerotate($src, $rot, 0); if ($r) { imagedestroy($src); $src = $r; } }
    }
    $w = imagesx($src); $h = imagesy($src);
    $make = function (int $max) use ($src, $w, $h) {
        $k = min(1, $max / max($w, $h));
        $nw = max(1, (int)round($w * $k)); $nh = max(1, (int)round($h * $k));
        $im = imagecreatetruecolor($nw, $nh);
        imagealphablending($im, false); imagesavealpha($im, true);
        imagefill($im, 0, 0, imagecolorallocatealpha($im, 255, 255, 255, 0));
        imagecopyresampled($im, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        return $im;
    };
    $save = function ($im, string $path) use ($mime): bool {
        if ($mime === 'image/png') return imagepng($im, $path, 7);
        if ($mime === 'image/webp') return imagewebp($im, $path, 82);
        return imagejpeg($im, $path, 82);
    };
    $full = $make(1600); $ok = $save($full, $dest); imagedestroy($full);
    $th = $make(400); $save($th, $thumbDest); imagedestroy($th);
    imagedestroy($src);
    return $ok;
}

function pl_add_photos(int $uid, int $cid, array $files): array {
    $p = pl_my_profile($uid, $cid);
    if (!$p) return ['error' => 'Create your profile first.'];
    $list = [];
    foreach ($files as $f) {
        if (!isset($f['name'])) continue;
        if (is_array($f['name'])) { foreach (array_keys($f['name']) as $i) $list[] = ['name' => $f['name'][$i], 'tmp_name' => $f['tmp_name'][$i], 'size' => $f['size'][$i], 'error' => $f['error'][$i]]; }
        else $list[] = $f;
    }
    $list = array_values(array_filter($list, fn($f) => ($f['error'] ?? 4) !== UPLOAD_ERR_NO_FILE));
    if (!$list) return ['error' => 'Choose a photo to upload.'];
    $count = scalar('SELECT COUNT(*) FROM matrimony_photos WHERE profile_id=?', [$p['id']]);
    $types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $added = 0;
    foreach ($list as $f) {
        if ($count + $added >= PL_MAX_PHOTOS) return ['error' => 'Maximum ' . PL_MAX_PHOTOS . ' photos allowed.', 'added' => $added];
        if ($f['error'] !== UPLOAD_ERR_OK || $f['size'] > PL_MAX_BYTES || !is_uploaded_file($f['tmp_name'])) return ['error' => 'Photo must be JPG, PNG or WEBP up to 5 MB.', 'added' => $added];
        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
        if (!isset($types[$mime]) || !@getimagesize($f['tmp_name'])) return ['error' => 'Photo must be JPG, PNG or WEBP up to 5 MB.', 'added' => $added];
        $name = $p['id'] . '-' . bin2hex(random_bytes(8)) . '.' . $types[$mime];
        if (!pl_save_image($f['tmp_name'], $mime, PL_UPLOAD_DIR . $name, PL_UPLOAD_DIR . 'th_' . $name) && !move_uploaded_file($f['tmp_name'], PL_UPLOAD_DIR . $name)) return ['error' => 'Could not save the photo.', 'added' => $added];
        // the same picture twice on one profile is refused (saved files are re-encoded the same way, so equal pictures give equal files)
        $hash = @md5_file(PL_UPLOAD_DIR . $name);
        foreach (rows('SELECT image_url FROM matrimony_photos WHERE profile_id=?', [$p['id']]) as $old) {
            $oldFile = PL_UPLOAD_DIR . basename((string)$old['image_url']);
            if ($hash && is_file($oldFile) && md5_file($oldFile) === $hash) {
                @unlink(PL_UPLOAD_DIR . $name); @unlink(PL_UPLOAD_DIR . 'th_' . $name);
                if (count($list) === 1) return ['error' => 'This photo is already in your profile.', 'code' => 'DUPLICATE_PHOTO', 'added' => $added];
                continue 2;
            }
        }
        $primary = ($count + $added === 0) ? 1 : 0;
        db()->prepare("INSERT INTO matrimony_photos (profile_id,image_url,status,is_primary) VALUES (?,?, 'pending', ?)")->execute([$p['id'], PL_UPLOAD_URL . $name, $primary]);
        $added++;
    }
    return ['message' => $added . ' photo' . ($added === 1 ? '' : 's') . ' uploaded for approval.', 'added' => $added, 'photos' => pl_photos((int)$p['id'], false)];
}

function pl_delete_photo(int $uid, int $cid, int $photoId): array {
    $p = pl_my_profile($uid, $cid);
    if (!$p) return ['error' => 'Create your profile first.'];
    $ph = rows('SELECT * FROM matrimony_photos WHERE id=? AND profile_id=?', [$photoId, $p['id']])[0] ?? null;
    if (!$ph) return ['error' => 'Photo not found.'];
    db()->prepare('DELETE FROM matrimony_photos WHERE id=?')->execute([$photoId]);
    $file = PL_UPLOAD_DIR . basename($ph['image_url']);
    if (is_file($file)) @unlink($file);
    $th = PL_UPLOAD_DIR . 'th_' . basename($ph['image_url']);
    if (is_file($th)) @unlink($th);
    if ($ph['is_primary']) db()->prepare('UPDATE matrimony_photos SET is_primary=1 WHERE id=(SELECT id FROM (SELECT id FROM matrimony_photos WHERE profile_id=? ORDER BY id LIMIT 1) t)')->execute([$p['id']]);
    return ['message' => 'Photo removed.', 'photos' => pl_photos((int)$p['id'], false)];
}

function pl_set_primary(int $uid, int $cid, int $photoId): array {
    $p = pl_my_profile($uid, $cid);
    if (!$p || !scalar('SELECT COUNT(*) FROM matrimony_photos WHERE id=? AND profile_id=?', [$photoId, $p['id']])) return ['error' => 'Photo not found.'];
    db()->prepare('UPDATE matrimony_photos SET is_primary=0 WHERE profile_id=?')->execute([$p['id']]);
    db()->prepare('UPDATE matrimony_photos SET is_primary=1 WHERE id=?')->execute([$photoId]);
    return ['message' => 'Primary photo updated.', 'photos' => pl_photos((int)$p['id'], false)];
}

function pl_age_range(string $v): array {
    if (preg_match('/^(\d+)\s*-\s*(\d+)$/', $v, $m)) return [(int)$m[1], (int)$m[2]];
    if (preg_match('/^(\d+)\s*\+$/', $v, $m)) return [(int)$m[1], 99];
    return [null, null];
}

function pl_card(array $r, bool $withContact = false): array {
    $d = pl_details($r);
    $card = [
        'id' => (int)$r['id'], 'code' => $r['profile_code'], 'name' => $r['full_name'], 'age' => (int)$r['age'], 'gender' => $r['gender'],
        'height' => $r['height'], 'marital' => $r['marital_status'], 'education' => $r['education'], 'profession' => $r['profession'],
        'city' => $r['city'], 'district' => $r['district'] ?? '', 'state' => $r['state'] ?? '', 'country' => $r['country'] ?? '',
        'community' => $r['community_name'] ?? ($d['community'] ?? ''), 'sub_community' => $d['sub_community'] ?? '', 'mother_tongue' => $r['mother_tongue'] ?? '',
        // a card shows the photo only when the member lets everyone eligible see it
        'intro' => $r['about'] ?? '', 'photo' => (($d['privacy']['photoPrivacy'] ?? 'eligible') === 'eligible') ? ($r['photo'] ?? null) : null, 'created_at' => $r['created_at'], 'status' => $r['status'],
    ];
    if ($withContact) { $card['phone'] = $r['phone'] ?? ''; $card['email'] = $r['email'] ?? ''; }
    return $card;
}

const PL_CARD_SQL = "p.*, c.name community_name,
    (SELECT image_url FROM matrimony_photos ph WHERE ph.profile_id=p.id AND ph.status='approved' ORDER BY ph.is_primary DESC, ph.id LIMIT 1) photo";

function pl_search(int $cid, array $f = [], int $page = 1, int $per = 12, ?int $viewerUid = null): array {
    $w = "p.status='approved' AND p.is_active=1"; $a = [];
    if ($cid) { $w .= ' AND p.community_id=?'; $a[] = $cid; }
    [$min, $max] = pl_age_range(trim((string)($f['age'] ?? '')));
    $min = $min ?? ((int)($f['min_age'] ?? $f['age_min'] ?? 0) ?: null); $max = $max ?? ((int)($f['max_age'] ?? $f['age_max'] ?? 0) ?: null);
    if ($min) { $w .= ' AND p.age>=?'; $a[] = $min; }
    if ($max) { $w .= ' AND p.age<=?'; $a[] = $max; }
    if (($h = (float)($f['min_height'] ?? 0)) > 0) { $w .= ' AND CAST(p.height AS DECIMAL(5,2))>=?'; $a[] = $h; }
    if (($h = (float)($f['max_height'] ?? 0)) > 0) { $w .= ' AND CAST(p.height AS DECIMAL(5,2))<=?'; $a[] = $h; }
    $g = strtolower(substr(trim((string)($f['gender'] ?? '')), 0, 1));
    // Logged-in member with a profile: always show the OPPOSITE gender only
    if ($viewerUid && ($vp = pl_my_profile($viewerUid, $cid ?: null)) && !empty($vp['gender'])) {
        $g = strtolower($vp['gender'][0]) === 'f' ? 'm' : 'f';
    }
    if ($g === 'm' || $g === 'f') { $w .= ' AND p.gender=?'; $a[] = $g === 'f' ? 'Female' : 'Male'; }
    // A value that exists in the column (every dropdown option) matches exactly, so "Graduate" does not also return
    // "Post Graduate" and "Married" does not return "Never Married". Typed text that matches no value still finds partial matches.
    $f['marital_status'] = $f['marital'] ?? $f['marital_status'] ?? '';
    foreach (['marital_status', 'education', 'profession', 'country', 'state', 'district', 'city'] as $k) {
        $v = trim((string)($f[$k] ?? ''));
        if ($v === '' || strtolower($v) === 'any') continue;
        // marital status is a fixed list of choices, so it is always exact
        if ($k === 'marital_status' || scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE TRIM($k)=?", [$v])) { $w .= " AND TRIM(p.$k)=?"; $a[] = $v; }
        else { $w .= " AND p.$k LIKE ?"; $a[] = "%$v%"; }
    }
    $q = trim((string)($f['q'] ?? $f['keyword'] ?? $f['profile_id'] ?? ''));
    if ($q !== '') { $w .= ' AND (p.full_name LIKE ? OR p.profile_code LIKE ?)'; array_push($a, "%$q%", "%$q%"); }
    if ($viewerUid) { $w .= ' AND (p.user_id IS NULL OR p.user_id<>?) AND p.id NOT IN (SELECT profile_id FROM matrimony_blocks WHERE user_id=?)'; array_push($a, $viewerUid, $viewerUid); }
    $order = ['recent' => 'p.id DESC', 'age-asc' => 'p.age ASC', 'age-desc' => 'p.age DESC', 'location' => 'p.city ASC', 'education' => 'p.education ASC', 'profession' => 'p.profession ASC'][$f['sort'] ?? 'recent'] ?? 'p.id DESC';
    $total = scalar("SELECT COUNT(*) FROM matrimony_profiles p WHERE $w", $a);
    $per = max(1, min(100, $per)); $off = (max(1, $page) - 1) * $per;
    $list = rows('SELECT ' . PL_CARD_SQL . " FROM matrimony_profiles p JOIN communities c ON c.id=p.community_id WHERE $w ORDER BY $order LIMIT $per OFFSET $off", $a);
    $saved = $viewerUid ? array_column(rows('SELECT profile_id FROM matrimony_saved WHERE user_id=?', [$viewerUid]), 'profile_id') : [];
    $cards = array_map(function ($r) use ($saved) { $c = pl_card($r); $c['saved'] = in_array($r['id'], $saved); return $c; }, $list);
    return ['total' => (int)$total, 'page' => max(1, $page), 'per' => $per, 'total_pages' => (int)ceil($total / $per), 'pages' => (int)ceil($total / $per), 'profiles' => $cards];
}

function pl_get_profile(int $id, ?int $cid = null, ?int $viewerUid = null): ?array {
    $p = rows('SELECT ' . PL_CARD_SQL . ' FROM matrimony_profiles p JOIN communities c ON c.id=p.community_id WHERE p.id=?' . ($cid ? ' AND p.community_id=?' : ''), $cid ? [$id, $cid] : [$id])[0] ?? null;
    if (!$p) return null;
    $own = $viewerUid && (int)$p['user_id'] === $viewerUid;
    if (!$own && ($p['status'] !== 'approved' || !$p['is_active'])) return null;
    $mine = $viewerUid ? pl_my_profile($viewerUid, (int)$p['community_id']) : null;
    $interest = null;
    if ($mine && !$own) $interest = rows('SELECT * FROM matrimony_interests WHERE (sender_id=? AND receiver_id=?) OR (sender_id=? AND receiver_id=?) ORDER BY id DESC LIMIT 1', [$mine['id'], $id, $id, $mine['id']])[0] ?? null;
    $visible = $own || (($interest['status'] ?? '') === 'accepted');
    $out = pl_card($p, $visible);
    $out['details'] = pl_details($p);
    if (!$visible) unset($out['details']['mobile'], $out['details']['phone'], $out['details']['email']);
    $out['dob'] = $own ? $p['dob'] : null;
    $out['is_own'] = $own;
    $out['interest'] = $interest ? ['id' => (int)$interest['id'], 'status' => $interest['status'], 'direction' => $mine && (int)$interest['sender_id'] === (int)$mine['id'] ? 'sent' : 'received', 'message' => $interest['message'] ?? ''] : null;
    $out['contact_visible'] = $visible;
    $pp = pl_mat_privacy($p)['photoPrivacy'];
    $showPhotos = $own || $pp === 'eligible' || ($pp === 'interest' && $interest) || ($pp === 'contact' && $visible);
    $out['photo'] = $showPhotos ? ($p['photo'] ?? null) : null;
    $out['photos'] = $showPhotos ? pl_photos($id, !$own) : [];
    if (!$own) unset($out['details']['privacy']);
    $out['preferences'] = pl_prefs($id);
    $out['saved'] = $viewerUid ? (bool)scalar('SELECT COUNT(*) FROM matrimony_saved WHERE user_id=? AND profile_id=?', [$viewerUid, $id]) : false;
    $out['blocked'] = $viewerUid && !$own ? pl_is_blocked($viewerUid, $id) : false;
    return $out;
}

function pl_me(int $uid, ?int $cid = null): ?array {
    $p = pl_my_profile($uid, $cid);
    if (!$p) return null;
    $out = pl_get_profile((int)$p['id'], null, $uid);
    $out['phone'] = $p['phone']; $out['email'] = $p['email']; $out['details'] = pl_details($p); $out['dob'] = $p['dob'];
    return $out;
}

function pl_send_interest(int $uid, int $cid, int $receiverId, string $message = ''): array {
    $me = pl_my_profile($uid, $cid);
    if (!$me) return ['error' => 'Create your profile first.'];
    if ($me['status'] !== 'approved') return ['error' => 'Your profile must be approved before sending interests.'];
    $to = rows("SELECT id,full_name,gender FROM matrimony_profiles WHERE id=? AND community_id=? AND status='approved' AND is_active=1", [$receiverId, $cid])[0] ?? null;
    if (!$to || (int)$to['id'] === (int)$me['id']) return ['error' => 'Profile not available.'];
    if (!empty($me['gender']) && !empty($to['gender']) && strcasecmp($me['gender'], $to['gender']) === 0) return ['error' => 'You can send interest only to profiles of the opposite gender.'];
    if (pl_is_blocked($uid, (int)$to['id'])) return ['error' => 'You have blocked this profile. Unblock it to send an interest.'];
    $toUser = (int)scalar('SELECT user_id FROM matrimony_profiles WHERE id=?', [$to['id']]);
    if ($toUser && pl_is_blocked($toUser, (int)$me['id'])) return ['error' => 'Profile not available.'];
    $toRow = rows('SELECT details FROM matrimony_profiles WHERE id=?', [$to['id']])[0];
    if (!pl_mat_privacy($toRow)['receiveInterests']) return ['error' => $to['full_name'] . ' is not accepting new interests right now.'];
    if (scalar('SELECT COUNT(*) FROM matrimony_interests WHERE sender_id=? AND receiver_id=?', [$me['id'], $to['id']])) return ['error' => 'Interest already sent.'];
    db()->prepare("INSERT INTO matrimony_interests (community_id,sender_id,receiver_id,status,message) VALUES (?,?,?, 'sent', ?)")->execute([$cid, $me['id'], $to['id'], mb_substr(trim($message), 0, 1000)]);
    notify($cid, 'New interest received', $me['full_name'] . ' has shown interest in your profile.', 'general', 'profile:' . $to['id']);
    return ['message' => 'Interest sent.'];
}

function pl_respond_interest(int $uid, int $cid, int $interestId, string $decision): array {
    $me = pl_my_profile($uid, $cid);
    if (!$me || !in_array($decision, ['accepted', 'rejected'], true)) return ['error' => 'Invalid request.'];
    $i = rows('SELECT * FROM matrimony_interests WHERE id=? AND receiver_id=? AND community_id=?', [$interestId, $me['id'], $cid])[0] ?? null;
    if (!$i) return ['error' => 'Interest not found.'];
    db()->prepare('UPDATE matrimony_interests SET status=? WHERE id=?')->execute([$decision, $interestId]);
    notify($cid, 'Interest ' . $decision, $me['full_name'] . ' has ' . ($decision === 'accepted' ? 'accepted' : 'declined') . ' your interest.', 'general', 'profile:' . $i['sender_id']);
    return ['message' => 'Interest ' . $decision . '.'];
}

function pl_withdraw_interest(int $uid, int $cid, int $interestId): array {
    $me = pl_my_profile($uid, $cid);
    if (!$me) return ['error' => 'Create your profile first.'];
    $i = rows("SELECT * FROM matrimony_interests WHERE id=? AND sender_id=? AND status='sent'", [$interestId, $me['id']])[0] ?? null;
    if (!$i) return ['error' => 'Interest not found or already answered.'];
    db()->prepare('DELETE FROM matrimony_interests WHERE id=?')->execute([$interestId]);
    return ['message' => 'Interest withdrawn.'];
}

function pl_interests(int $uid, ?int $cid = null): array {
    $me = pl_my_profile($uid, $cid);
    if (!$me) return ['received' => [], 'sent' => []];
    $sel = 'SELECT i.id interest_id,i.status interest_status,i.message,i.created_at interest_at,' . PL_CARD_SQL . ' FROM matrimony_interests i JOIN matrimony_profiles p ON p.id=';
    $fmt = function ($r) { $c = pl_card($r); $c['interest_id'] = (int)$r['interest_id']; $c['interest_status'] = $r['interest_status']; $c['message'] = $r['message'] ?? ''; $c['interest_at'] = $r['interest_at']; return $c; };
    $join = ' JOIN communities c ON c.id=p.community_id';
    return [
        'received' => array_map($fmt, rows($sel . 'i.sender_id' . $join . ' WHERE i.receiver_id=? ORDER BY i.id DESC', [$me['id']])),
        'sent'     => array_map($fmt, rows($sel . 'i.receiver_id' . $join . ' WHERE i.sender_id=? ORDER BY i.id DESC', [$me['id']])),
    ];
}

function pl_toggle_save(int $uid, int $profileId, int $cid = 0): array {
    if (!scalar("SELECT COUNT(*) FROM matrimony_profiles WHERE id=? AND status='approved' AND is_active=1" . ($cid ? ' AND community_id=?' : ''), $cid ? [$profileId, $cid] : [$profileId])) return ['error' => 'Profile not found.', 'code' => 'PROFILE_NOT_FOUND', '_code' => 404];
    if (scalar('SELECT COUNT(*) FROM matrimony_saved WHERE user_id=? AND profile_id=?', [$uid, $profileId])) {
        db()->prepare('DELETE FROM matrimony_saved WHERE user_id=? AND profile_id=?')->execute([$uid, $profileId]);
        return ['saved' => false, 'message' => 'Removed from saved profiles.'];
    }
    db()->prepare('INSERT INTO matrimony_saved (user_id,profile_id) VALUES (?,?)')->execute([$uid, $profileId]);
    return ['saved' => true, 'message' => 'Profile saved.'];
}

function pl_saved(int $uid, ?int $cid = null): array {
    $w = "s.user_id=? AND p.status='approved' AND p.is_active=1" . ($cid ? ' AND p.community_id=?' : '');
    $list = rows('SELECT ' . PL_CARD_SQL . ', s.created_at saved_at FROM matrimony_saved s JOIN matrimony_profiles p ON p.id=s.profile_id JOIN communities c ON c.id=p.community_id WHERE ' . $w . ' ORDER BY s.id DESC', $cid ? [$uid, $cid] : [$uid]);
    return array_map(function ($r) { $c = pl_card($r); $c['saved'] = true; $c['saved_at'] = $r['saved_at']; return $c; }, $list);
}

function pl_report(array $user, int $cid, int $profileId, string $reason): array {
    $reason = mb_substr(trim($reason), 0, 255);
    if ($reason === '') return ['error' => 'Please enter a reason.'];
    if (!scalar('SELECT COUNT(*) FROM matrimony_profiles WHERE id=? AND community_id=?', [$profileId, $cid])) return ['error' => 'Profile not found.'];
    db()->prepare('INSERT INTO matrimony_reports (community_id,reported_profile_id,reporter_name,reason) VALUES (?,?,?,?)')->execute([$cid, $profileId, $user['name'], $reason]);
    return ['message' => 'Report submitted. Our team will review it.'];
}

function pl_packages(int $cid): array {
    return rows('SELECT id,name,price,validity_days FROM matrimony_packages WHERE community_id=? AND is_active=1 ORDER BY price', [$cid]);
}

function pl_order_package(int $uid, int $cid, int $packageId): array {
    $me = pl_my_profile($uid, $cid);
    if (!$me) return ['error' => 'Create your profile first.'];
    $pk = rows('SELECT * FROM matrimony_packages WHERE id=? AND community_id=? AND is_active=1', [$packageId, $cid])[0] ?? null;
    if (!$pk) return ['error' => 'Package not available.'];
    db()->prepare("INSERT INTO matrimony_payments (community_id,profile_id,package_id,amount,status) VALUES (?,?,?,?, 'pending')")->execute([$cid, $me['id'], $pk['id'], $pk['price']]);
    return ['message' => 'Package request received. Our team will confirm your payment.', 'order_id' => (int)db()->lastInsertId()];
}

/* matrimony privacy, kept in the profile's details under "privacy" */
const PL_MAT_PRIVACY = ['profileVisibility' => 'visible', 'photoPrivacy' => 'eligible', 'receiveInterests' => true, 'allowContactRequests' => true,
    'profileRecommendations' => true, 'notifyInterests' => true, 'notifyContacts' => true, 'notifyPackages' => true, 'notifyProfile' => true];

function pl_mat_privacy(array $profileRow): array {
    return array_merge(PL_MAT_PRIVACY, array_intersect_key((array)(pl_details($profileRow)['privacy'] ?? []), PL_MAT_PRIVACY));
}

function pl_save_mat_privacy(int $uid, int $cid, array $in): array {
    $p = pl_my_profile($uid, $cid);
    if (!$p) return ['error' => 'Create your profile first.'];
    $vis = in_array($in['profile_visibility'] ?? '', ['visible', 'hidden', 'deactivated'], true) ? $in['profile_visibility'] : 'visible';
    $photo = in_array($in['photo_privacy'] ?? '', ['eligible', 'interest', 'contact', 'private'], true) ? $in['photo_privacy'] : 'eligible';
    $priv = ['profileVisibility' => $vis, 'photoPrivacy' => $photo];
    foreach (['receiveInterests' => 'receive_interests', 'allowContactRequests' => 'allow_contact_requests', 'profileRecommendations' => 'profile_recommendations',
        'notifyInterests' => 'notify_interests', 'notifyContacts' => 'notify_contacts', 'notifyPackages' => 'notify_packages', 'notifyProfile' => 'notify_profile'] as $k => $f) $priv[$k] = !empty($in[$f]);
    $d = pl_details($p); $d['privacy'] = $priv;
    db()->prepare('UPDATE matrimony_profiles SET details=?, is_active=? WHERE id=?')->execute([json_encode($d, JSON_UNESCAPED_UNICODE), $vis === 'visible' ? 1 : 0, $p['id']]);
    return ['message' => 'Privacy settings saved.' . ($vis === 'visible' ? '' : ' Your profile is now hidden from other members.'), 'privacy' => $priv];
}

function pl_blocked_profiles(int $uid): array {
    return array_map(fn($r) => ['id' => (int)$r['id'], 'code' => $r['profile_code'], 'name' => $r['full_name'], 'blocked_at' => $r['created_at']],
        rows('SELECT p.id, p.profile_code, p.full_name, b.created_at FROM matrimony_blocks b JOIN matrimony_profiles p ON p.id=b.profile_id WHERE b.user_id=? ORDER BY b.id DESC', [$uid]));
}

function pl_is_blocked(int $uid, int $profileId): bool {
    return (bool)scalar('SELECT COUNT(*) FROM matrimony_blocks WHERE user_id=? AND profile_id=?', [$uid, $profileId]);
}

/* block: the profile leaves my search, cannot send me interests (nor I to it), and its pending interest to me is declined */
function pl_block_profile(int $uid, int $cid, int $profileId, bool $block): array {
    $p = rows('SELECT id,user_id FROM matrimony_profiles WHERE id=? AND community_id=?', [$profileId, $cid])[0] ?? null;
    if (!$p || (int)$p['user_id'] === $uid) return ['error' => 'Profile not found.'];
    if (!$block) {
        db()->prepare('DELETE FROM matrimony_blocks WHERE user_id=? AND profile_id=?')->execute([$uid, $profileId]);
        return ['message' => 'Profile unblocked.', 'blocked' => false];
    }
    db()->prepare('INSERT IGNORE INTO matrimony_blocks (user_id, profile_id) VALUES (?,?)')->execute([$uid, $profileId]);
    db()->prepare('DELETE FROM matrimony_saved WHERE user_id=? AND profile_id=?')->execute([$uid, $profileId]);
    if ($me = pl_my_profile($uid, $cid)) db()->prepare("UPDATE matrimony_interests SET status='rejected' WHERE sender_id=? AND receiver_id=? AND status='sent'")->execute([$profileId, $me['id']]);
    return ['message' => 'Profile blocked. You will not see each other in search or receive interests from this member.', 'blocked' => true];
}

/* the member hides (deactivates) or shows their own matrimony profile; admin approval is not touched */
function pl_set_profile_active(int $uid, int $cid, bool $active): array {
    $me = pl_my_profile($uid, $cid);
    if (!$me) return ['error' => 'Create your profile first.'];
    db()->prepare('UPDATE matrimony_profiles SET is_active=? WHERE id=?')->execute([$active ? 1 : 0, $me['id']]);
    return ['message' => $active ? 'Your profile is visible again.' : 'Your profile is hidden. Reactivate it any time from My Profile.', 'is_active' => $active];
}

/* the member's package orders; "active" = the latest paid one that has not expired */
function pl_my_packages(int $uid, int $cid): array {
    $me = pl_my_profile($uid, $cid);
    if (!$me) return ['active' => null, 'orders' => []];
    $orders = array_map(function ($r) {
        $exp = $r['validity_days'] ? date('Y-m-d H:i:s', strtotime($r['purchased_at'] . ' +' . (int)$r['validity_days'] . ' days')) : null;
        return ['id' => (int)$r['id'], 'package_id' => (int)$r['package_id'], 'name' => $r['name'], 'amount' => (int)$r['amount'], 'status' => $r['status'],
            'purchased_at' => $r['purchased_at'], 'validity_days' => (int)$r['validity_days'], 'expires_at' => $exp];
    }, rows('SELECT py.*, pk.name, pk.validity_days FROM matrimony_payments py LEFT JOIN matrimony_packages pk ON pk.id=py.package_id WHERE py.profile_id=? ORDER BY py.id DESC', [$me['id']]));
    $active = null;
    foreach ($orders as $o) if ($o['status'] === 'paid' && (!$o['expires_at'] || $o['expires_at'] >= date('Y-m-d H:i:s'))) { $active = $o; break; }
    return ['active' => $active, 'orders' => $orders];
}

function pl_support_request(array $user, ?int $cid, array $in): array {
    $d = pl_collect($in);
    $title = mb_substr($d['request_title'] ?? '', 0, 200); $desc = $d['description'] ?? '';
    if ($title === '' || $desc === '') return ['error' => 'Title and description are required.'];
    $req = $d['required_by'] ?? ''; $req = preg_match('/^\d{4}-\d{2}-\d{2}$/', $req) ? $req : null;
    db()->prepare('INSERT INTO matrimony_support (community_id,user_id,title,category,assistance_type,contact_name,phone,email,location,required_by,visibility,description,data) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)')
        ->execute([$cid, $user['id'], $title, $d['support_category'] ?? '', $d['assistance_type'] ?? '', $d['contact_name'] ?? $user['name'], $d['phone'] ?? '', $d['email'] ?? '', $d['location'] ?? '', $req, $d['visibility'] ?? '', $desc, json_encode($d, JSON_UNESCAPED_UNICODE)]);
    $id = (int)db()->lastInsertId();
    return ['message' => 'Support request submitted. Your ticket number is PLM-SUP-' . (10000 + $id) . '.', 'request_id' => $id, 'ticket' => 'PLM-SUP-' . (10000 + $id)];
}

/* the member's own help-desk tickets */
function pl_my_support_requests(int $uid): array {
    return array_map(fn($r) => ['id' => (int)$r['id'], 'ticket' => 'PLM-SUP-' . (10000 + (int)$r['id']), 'title' => $r['title'], 'category' => $r['category'],
        'status' => $r['status'], 'description' => $r['description'], 'created_at' => $r['created_at']],
        rows('SELECT * FROM matrimony_support WHERE user_id=? ORDER BY id DESC LIMIT 50', [$uid]));
}

function pl_slugify(string $s): string { return strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $s), '-')); }

function pl_slug_from_request(): string {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    if (USE_SUBDOMAINS && str_ends_with($host, BASE_DOMAIN) && $host !== BASE_DOMAIN && $host !== 'www.' . BASE_DOMAIN) return explode('.', $host)[0];
    return (string)($_GET['c'] ?? '');
}

function pl_paras(?string $t): array {
    return array_values(array_filter(array_map('trim', preg_split('/\R{2,}/', (string)$t))));
}

function pl_community_page(string $slug): ?array {
    $c = pl_community_by($slug);
    if (!$c) return null;
    $c['about_paras'] = pl_paras($c['about'] ?? '');
    $c['intro_paras'] = pl_paras($c['intro'] ?? '');
    $c['history_paras'] = pl_paras($c['history'] ?? '');
    $c['values_paras'] = pl_paras($c['values_text'] ?? '');
    return $c;
}

function pl_seed_communities(): array {
    $items = json_decode((string)@file_get_contents(__DIR__ . '/communities-seed.json'), true) ?: [];
    $added = 0; $filled = 0;
    foreach ($items as $it) {
        $first = trim(explode('/', $it['title'])[0]); $slug = pl_slugify($first);
        $row = rows('SELECT * FROM communities WHERE slug=? OR LOWER(name)=LOWER(?) LIMIT 1', [$slug, $first])[0] ?? null;
        if (!$row) {
            db()->prepare('INSERT INTO communities (name,slug,is_active) VALUES (?,?,1)')->execute([mb_substr($it['title'], 0, 80), $slug]);
            $row = rows('SELECT * FROM communities WHERE slug=?', [$slug])[0]; $added++;
        }
        foreach (['about', 'intro', 'history'] as $f) {
            if (trim((string)($row[$f] ?? '')) === '' && !empty($it[$f])) { db()->prepare("UPDATE communities SET $f=? WHERE id=?")->execute([$it[$f], $row['id']]); $filled++; }
        }
    }
    return ['total' => count($items), 'added' => $added, 'filled' => $filled];
}

function pl_save_device_token(int $uid, string $token, string $platform, string $deviceId, string $appVersion): array {
    $token = trim($token);
    if ($token === '' || strlen($token) > 255) return ['error' => 'A valid device token is required.', 'code' => 'VALIDATION_ERROR'];
    $platform = in_array(strtolower($platform), ['android', 'ios', 'web'], true) ? strtolower($platform) : 'android';
    db()->prepare('INSERT INTO device_tokens (user_id, token, platform, device_id, app_version, is_active) VALUES (?,?,?,?,?,1)
        ON DUPLICATE KEY UPDATE user_id=VALUES(user_id), platform=VALUES(platform), device_id=VALUES(device_id), app_version=VALUES(app_version), is_active=1')
        ->execute([$uid, $token, $platform, substr($deviceId, 0, 120), substr($appVersion, 0, 30)]);
    return ['message' => 'Device registered for notifications.'];
}

function pl_remove_device_token(int $uid, string $token): array {
    db()->prepare('UPDATE device_tokens SET is_active=0 WHERE user_id=? AND token=?')->execute([$uid, trim($token)]);
    return ['message' => 'Device removed.'];
}

require_once __DIR__ . '/modules.php';