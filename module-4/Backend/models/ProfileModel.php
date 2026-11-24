<?php
/* Profile extras: completion %, match %, visitors, filter values, dashboard counts. */

/* Profile completion: each filled item adds its weight (total 100). */
function mat_completion(array $p): array {
    $d = pl_details($p);
    $photos = scalar("SELECT COUNT(*) FROM matrimony_photos WHERE profile_id=? AND status<>'rejected'", [$p['id']]);
    $prefs = scalar('SELECT COUNT(*) FROM matrimony_preferences WHERE profile_id=?', [$p['id']]);
    $checks = [
        'Basic details'      => [15, !empty($p['full_name']) && !empty($p['gender']) && !empty($p['dob'])],
        'Height & marital status' => [10, !empty($p['height']) && !empty($p['marital_status'])],
        'Mother tongue'      => [5,  !empty($p['mother_tongue'])],
        'Location'           => [10, !empty($p['city']) && !empty($p['state'])],
        'Education'          => [10, !empty($p['education'])],
        'Profession'         => [10, !empty($p['profession'])],
        'Family details'     => [10, !empty($d['father_name']) || !empty($d['mother_name']) || !empty($p['family_details'])],
        'About me'           => [10, mb_strlen(trim((string)$p['about'])) >= 20],
        'Photo'              => [10, $photos > 0],
        'Partner preferences'=> [10, $prefs > 0],
    ];
    $score = 0; $missing = [];
    foreach ($checks as $label => [$w, $ok]) { if ($ok) $score += $w; else $missing[] = $label; }
    return ['percent' => $score, 'missing' => $missing];
}

/* Rule-based match %: how many of the viewer's partner preferences the card satisfies. Null when the viewer has no preferences. */
function mat_match(?array $prefs, array $card): ?int {
    if (!$prefs) return null;
    $total = 0; $hit = 0;
    $has = fn($v) => $v !== null && trim((string)$v) !== '' && strtolower(trim((string)$v)) !== 'any';
    $like = function (string $want, ?string $have): bool {
        $have = strtolower((string)$have);
        foreach (preg_split('/\s*[,\/]\s*/', strtolower($want)) as $w) if ($w !== '' && $have !== '' && (str_contains($have, $w) || str_contains($w, $have))) return true;
        return false;
    };
    if ($has($prefs['age_min'] ?? null) || $has($prefs['age_max'] ?? null)) {
        $total++; $a = (int)$card['age'];
        if ($a && $a >= (int)($prefs['age_min'] ?: 0) && $a <= (int)($prefs['age_max'] ?: 99)) $hit++;
    }
    if ($has($prefs['location'] ?? null)) { $total++; if ($like($prefs['location'], $card['city'] . ' ' . $card['district'] . ' ' . $card['state'] . ' ' . $card['country'])) $hit++; }
    foreach (['education' => 'education', 'profession' => 'profession', 'marital_status' => 'marital'] as $pk => $ck) {
        if ($has($prefs[$pk] ?? null)) { $total++; if ($like($prefs[$pk], $card[$ck] ?? '')) $hit++; }
    }
    $mt = $prefs['data']['partner_mother_tongue'] ?? null;
    if ($has($mt)) { $total++; if ($like($mt, $card['mother_tongue'] ?? '')) $hit++; }
    return $total ? (int)round($hit * 100 / $total) : null;
}

/* One row per viewer, profile and day. */
function mat_log_visit(int $viewerProfileId, int $profileId): void {
    if ($viewerProfileId === $profileId) return;
    db()->prepare('INSERT INTO matrimony_profile_views (viewer_profile_id, profile_id, viewed_on, view_count) VALUES (?,?,CURDATE(),1)
        ON DUPLICATE KEY UPDATE view_count=view_count+1, last_viewed_at=NOW()')->execute([$viewerProfileId, $profileId]);
}

function mat_visitors(int $profileId): array {
    $list = rows('SELECT v.viewer_profile_id, MAX(v.last_viewed_at) last_viewed_at, SUM(v.view_count) views, ' . PL_CARD_SQL . '
        FROM matrimony_profile_views v JOIN matrimony_profiles p ON p.id=v.viewer_profile_id JOIN communities c ON c.id=p.community_id
        WHERE v.profile_id=? AND p.status=\'approved\' AND p.is_active=1 GROUP BY v.viewer_profile_id ORDER BY last_viewed_at DESC LIMIT 200', [$profileId]);
    return array_map(function ($r) { $c = pl_card($r); $c['last_viewed_at'] = $r['last_viewed_at']; $c['views'] = (int)$r['views']; return $c; }, $list);
}

/* Real values for search dropdowns, taken from approved profiles of the community. */
function mat_filters(int $cid, ?string $onlyGender = null): array {
    $out = [];
    foreach (['education', 'profession', 'city', 'state', 'country', 'marital_status', 'mother_tongue'] as $col) {
        $out[$col] = array_column(rows("SELECT DISTINCT TRIM($col) v FROM matrimony_profiles WHERE status='approved' AND is_active=1" . ($cid ? ' AND community_id=?' : '') . " AND TRIM(COALESCE($col,''))<>'' ORDER BY v", $cid ? [$cid] : []), 'v');
    }
    // cities per state (search: City follows the chosen State) and how many profiles each state has
    $w = "status='approved' AND is_active=1" . ($cid ? ' AND community_id=?' : '') . " AND TRIM(COALESCE(state,''))<>''" . ($onlyGender ? ' AND gender=?' : '');
    $out['city_by_state'] = []; $out['state_counts'] = [];
    foreach (rows("SELECT TRIM(state) st, TRIM(city) ct, COUNT(*) n FROM matrimony_profiles WHERE $w GROUP BY LOWER(TRIM(state)), LOWER(TRIM(city)) ORDER BY ct", array_merge($cid ? [$cid] : [], $onlyGender ? [$onlyGender] : [])) as $r) {
        $k = mb_strtolower($r['st']);
        $out['state_counts'][$k] = ($out['state_counts'][$k] ?? 0) + (int)$r['n'];
        if ($r['ct'] !== '' && $r['ct'] !== null) $out['city_by_state'][$k][] = $r['ct'];
    }
    $out['age_range'] = rows("SELECT MIN(age) min_age, MAX(age) max_age FROM matrimony_profiles WHERE status='approved' AND is_active=1" . ($cid ? ' AND community_id=?' : ''), $cid ? [$cid] : [])[0];
    $out['sort'] = ['recent' => 'Newest first', 'age-asc' => 'Age: low to high', 'age-desc' => 'Age: high to low', 'location' => 'Location', 'education' => 'Education', 'profession' => 'Profession'];
    return $out;
}

function mat_dashboard(int $uid, int $cid, array $me): array {
    $pid = (int)$me['id'];
    return [
        'interests_received_pending' => scalar("SELECT COUNT(*) FROM matrimony_interests WHERE receiver_id=? AND status='sent'", [$pid]),
        'interests_received' => scalar('SELECT COUNT(*) FROM matrimony_interests WHERE receiver_id=?', [$pid]),
        'interests_sent'     => scalar('SELECT COUNT(*) FROM matrimony_interests WHERE sender_id=?', [$pid]),
        'interests_accepted' => scalar("SELECT COUNT(*) FROM matrimony_interests WHERE (sender_id=? OR receiver_id=?) AND status='accepted'", [$pid, $pid]),
        'saved'              => scalar("SELECT COUNT(*) FROM matrimony_saved s JOIN matrimony_profiles p ON p.id=s.profile_id WHERE s.user_id=? AND p.status='approved' AND p.is_active=1", [$uid]),
        'visitors_30d'       => scalar('SELECT COUNT(DISTINCT viewer_profile_id) FROM matrimony_profile_views WHERE profile_id=? AND viewed_on >= CURDATE() - INTERVAL 30 DAY', [$pid]),
        'contact_requests_pending' => scalar("SELECT COUNT(*) FROM matrimony_contact_requests WHERE target_profile_id=? AND status='pending'", [$pid]),
        'notifications_unread' => scalar('SELECT COUNT(*) FROM user_notifications WHERE user_id=? AND is_read=0 AND type=?', [$uid, MAT_NOTIFY_TYPE]),
    ];
}
