<?php
/* Interests (existing logic + member notifications) and contact requests (new). */

$__send = $GLOBALS['PL_ACTIONS']['send_interest']['fn'];
pl_action('send_interest', function ($x) use ($__send) {
    $r = $__send($x);
    if (empty($r['error'])) {
        $me = pl_my_profile($x['uid'], $x['cid']);
        mat_notify((int)($_POST['profile_id'] ?? 0), $x['cid'], 'New interest received', $me['full_name'] . ' (' . $me['profile_code'] . ') is interested in your profile.', 'matrimony_new_interest', (int)$me['id']);
    }
    return $r;
});

$__respond = $GLOBALS['PL_ACTIONS']['respond_interest']['fn'];
pl_action('respond_interest', function ($x) use ($__respond) {
    $i = rows('SELECT * FROM matrimony_interests WHERE id=?', [(int)($_POST['interest_id'] ?? 0)])[0] ?? null;
    // only a pending interest can be answered (the UI shows Accept/Decline only for these); stops flipping an accepted one and repeat notices
    $me = pl_my_profile($x['uid'], $x['cid']);
    if ($i && $me && (int)$i['receiver_id'] === (int)$me['id'] && $i['status'] !== 'sent')
        return mat_err('You have already ' . ($i['status'] === 'accepted' ? 'accepted' : 'declined') . ' this interest.', 'ALREADY_ANSWERED', 409);
    $r = $__respond($x);
    if (empty($r['error']) && $i) {
        $me = pl_my_profile($x['uid'], $x['cid']);
        $ok = ($_POST['decision'] ?? '') === 'accepted';
        mat_notify((int)$i['sender_id'], $x['cid'], $ok ? 'Interest accepted' : 'Interest declined',
            $me['full_name'] . ($ok ? ' accepted your interest. You can now see each other\'s contact details.' : ' declined your interest.'),
            $ok ? 'matrimony_interest_accepted' : 'matrimony_interest_declined', (int)$me['id']);
    }
    return $r;
});
unset($__send, $__respond);

pl_action('contact_request', fn($x) => mat_contact_request($x['uid'], $x['cid'], (int)($_POST['profile_id'] ?? 0), (string)($_POST['message'] ?? '')));
pl_action('contact_respond', fn($x) => mat_contact_respond($x['uid'], $x['cid'], (int)($_POST['request_id'] ?? 0), (string)($_POST['decision'] ?? '')));
pl_action('contact_cancel', fn($x) => mat_contact_cancel($x['uid'], $x['cid'], (int)($_POST['request_id'] ?? 0)));
pl_action('contact_requests', fn($x) => mat_contact_list($x['uid'], $x['cid']), false, false);
