<?php
// Shared loader for the account pages (My Profile, Edit Profile, Account Settings).
// Requires a logged-in user and gives: $acUser, $acMember, $acComm, $acPrefs, and helpers.
require_once dirname(__DIR__, 2) . '/matrimoney/includes/bridge.php';
pl_ensure_schema();

$acUser = current_user();
if (!$acUser) {
    header('Location: ' . DASHBOARD_URL . 'login.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/first/profile/my-profile.php'));
    exit;
}
$acUid = (int)$acUser['id'];
$acComm = pl_resolve_community($acUid);
$acCid = $acComm ? (int)$acComm['id'] : 0;
$acMember = $acCid ? (rows('SELECT * FROM members WHERE user_id=? AND community_id=? ORDER BY id DESC LIMIT 1', [$acUid, $acCid])[0] ?? null) : null;
$acPrefs = json_decode($acUser['prefs'] ?? '', true) ?: [];
$acMat = rows('SELECT id, profile_code, status FROM matrimony_profiles WHERE user_id=? ORDER BY id DESC LIMIT 1', [$acUid])[0] ?? null;

function ac_e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function ac_or($v, string $empty = 'Not added'): string { $v = trim((string)$v); return $v === '' ? $empty : $v; }
function ac_date(?string $d): string { return $d && ($t = strtotime($d)) ? date('d F Y', $t) : ''; }
/* a value from the member profile first, then the account */
function ac_val(string $k) { global $acMember, $acUser; $v = $acMember[$k] ?? null; return ($v !== null && $v !== '') ? $v : ($acUser[$k] ?? null); }
function ac_count(string $sql, array $a): int { try { return (int)scalar($sql, $a); } catch (Throwable $e) { return 0; } }
