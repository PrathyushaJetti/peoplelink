<?php
/* Contact requests: a member asks to see another member's phone / email. Sending uses one package credit; a declined or cancelled request gives it back. */

function mat_contact_between(int $a, int $b): ?array {
    return rows('SELECT * FROM matrimony_contact_requests WHERE (requester_profile_id=? AND target_profile_id=?) OR (requester_profile_id=? AND target_profile_id=?) ORDER BY id DESC LIMIT 1', [$a, $b, $b, $a])[0] ?? null;
}

/* Contact is visible to the requester once approved (either direction), or after an accepted interest (existing rule). */
function mat_contact_unlocked(int $myProfileId, int $profileId): bool {
    return (bool)scalar("SELECT COUNT(*) FROM matrimony_contact_requests WHERE status='approved' AND ((requester_profile_id=? AND target_profile_id=?) OR (requester_profile_id=? AND target_profile_id=?))", [$myProfileId, $profileId, $profileId, $myProfileId]);
}

function mat_contact_request(int $uid, int $cid, int $profileId, string $message): array {
    $me = pl_my_profile($uid, $cid);
    if (!$me) return mat_err('Create your matrimony profile first.', 'PROFILE_REQUIRED');
    if ($me['status'] !== 'approved') return mat_err('Your profile must be approved before you can request contact details.', 'APPROVAL_PENDING', 403);
    $to = rows("SELECT * FROM matrimony_profiles WHERE id=? AND community_id=? AND status='approved' AND is_active=1", [$profileId, $cid])[0] ?? null;
    if (!$to) return mat_err('Profile not found.', 'PROFILE_NOT_FOUND', 404);
    if ($e = mat_can_reach($me, $to, $uid)) return $e;
    if (!pl_mat_privacy($to)['allowContactRequests']) return mat_err($to['full_name'] . ' is not accepting contact requests.', 'PRIVACY_RESTRICTED', 403);
    $old = rows('SELECT * FROM matrimony_contact_requests WHERE requester_profile_id=? AND target_profile_id=?', [$me['id'], $to['id']])[0] ?? null;
    if ($old && $old['status'] === 'pending') return mat_err('You already sent a contact request to this member.', 'ALREADY_REQUESTED', 409);
    if ($old && $old['status'] === 'approved') return mat_err('Contact details are already shared with you.', 'ALREADY_APPROVED', 409);
    if (!mat_entitlement($uid)['active']) return mat_err('Buy a matrimony package to request contact details.', 'PACKAGE_REQUIRED', 402);
    $credit = mat_use_credit($uid);
    if ($credit === null) return mat_err('You have used all contact requests in your package. Please upgrade.', 'PACKAGE_LIMIT_REACHED', 402);
    $msg = mb_substr(trim($message), 0, 500);
    try {
        if ($old) {
            $s = db()->prepare("UPDATE matrimony_contact_requests SET status='pending', message=?, user_package_id=?, created_at=NOW(), responded_at=NULL WHERE id=? AND status<>'pending'");
            $s->execute([$msg, $credit ?: null, $old['id']]);
            $saved = $s->rowCount() === 1;
        } else {
            // INSERT IGNORE + uq_pair: a double click creates one request, the second call gets its credit back
            $s = db()->prepare("INSERT IGNORE INTO matrimony_contact_requests (community_id, requester_profile_id, target_profile_id, requester_user_id, user_package_id, message, status) VALUES (?,?,?,?,?,?, 'pending')");
            $s->execute([$cid, $me['id'], $to['id'], $uid, $credit ?: null, $msg]);
            $saved = $s->rowCount() === 1;
        }
    } catch (Throwable $e) {
        mat_refund_credit($credit ?: null);
        throw $e;
    }
    if (!$saved) {
        mat_refund_credit($credit ?: null);
        return mat_err('You already sent a contact request to this member.', 'ALREADY_REQUESTED', 409);
    }
    mat_notify((int)$to['id'], $cid, 'New contact request', $me['full_name'] . ' (' . $me['profile_code'] . ') asked to see your contact details.', 'matrimony_contact_request', (int)$me['id']);
    return ['message' => 'Contact request sent. You will be notified when it is answered.', 'remaining' => mat_entitlement($uid)['remaining']];
}

function mat_contact_respond(int $uid, int $cid, int $requestId, string $decision): array {
    if (!in_array($decision, ['approved', 'declined'], true)) return mat_err('Choose approve or decline.');
    $me = pl_my_profile($uid, $cid);
    if (!$me) return mat_err('Create your matrimony profile first.', 'PROFILE_REQUIRED');
    $r = rows("SELECT * FROM matrimony_contact_requests WHERE id=? AND target_profile_id=? AND status='pending'", [$requestId, $me['id']])[0] ?? null;
    if (!$r) return mat_err('Request not found or already answered.', 'NOT_FOUND', 404);
    // status='pending' in the WHERE: a double click cannot answer twice or refund the credit twice
    $s = db()->prepare("UPDATE matrimony_contact_requests SET status=?, responded_at=NOW() WHERE id=? AND status='pending'");
    $s->execute([$decision, $requestId]);
    if ($s->rowCount() !== 1) return mat_err('Request not found or already answered.', 'NOT_FOUND', 404);
    if ($decision === 'declined') mat_refund_credit($r['user_package_id'] ? (int)$r['user_package_id'] : null);
    mat_notify((int)$r['requester_profile_id'], $cid, $decision === 'approved' ? 'Contact details shared' : 'Contact request declined',
        $me['full_name'] . ($decision === 'approved' ? ' shared contact details with you.' : ' declined your contact request. Your credit was returned.'),
        $decision === 'approved' ? 'matrimony_contact_approved' : 'matrimony_contact_declined', (int)$me['id']);
    return ['message' => $decision === 'approved' ? 'Contact details shared.' : 'Request declined.'];
}

function mat_contact_cancel(int $uid, int $cid, int $requestId): array {
    $me = pl_my_profile($uid, $cid);
    $r = $me ? rows("SELECT * FROM matrimony_contact_requests WHERE id=? AND requester_profile_id=? AND status='pending'", [$requestId, $me['id']])[0] ?? null : null;
    if (!$r) return mat_err('Request not found or already answered.', 'NOT_FOUND', 404);
    $s = db()->prepare("UPDATE matrimony_contact_requests SET status='cancelled', responded_at=NOW() WHERE id=? AND status='pending'");
    $s->execute([$requestId]);
    if ($s->rowCount() !== 1) return mat_err('Request not found or already answered.', 'NOT_FOUND', 404);
    mat_refund_credit($r['user_package_id'] ? (int)$r['user_package_id'] : null);
    return ['message' => 'Request cancelled and credit returned.'];
}

function mat_contact_list(int $uid, int $cid): array {
    $me = pl_my_profile($uid, $cid);
    if (!$me) return ['received' => [], 'sent' => []];
    $sel = 'SELECT r.id request_id, r.status request_status, r.message, r.created_at requested_at, r.responded_at, ' . PL_CARD_SQL . ' FROM matrimony_contact_requests r JOIN matrimony_profiles p ON p.id=';
    $join = ' JOIN communities c ON c.id=p.community_id';
    $fmt = function ($r, bool $showContact) {
        $c = pl_card($r, $showContact);
        return $c + ['request_id' => (int)$r['request_id'], 'request_status' => $r['request_status'], 'message' => $r['message'] ?? '', 'requested_at' => $r['requested_at'], 'responded_at' => $r['responded_at']];
    };
    return [
        'received' => array_map(fn($r) => $fmt($r, false), rows($sel . 'r.requester_profile_id' . $join . ' WHERE r.target_profile_id=? ORDER BY r.id DESC', [$me['id']])),
        'sent'     => array_map(fn($r) => $fmt($r, $r['request_status'] === 'approved'), rows($sel . 'r.target_profile_id' . $join . ' WHERE r.requester_profile_id=? ORDER BY r.id DESC', [$me['id']])),
    ];
}
