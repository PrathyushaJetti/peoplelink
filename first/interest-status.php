<?php
// Matrimony moved to /module-4 (Frontend/pages/interests.php). This old address redirects so existing links keep working.
$q = $_GET;
if (isset($q['profile_id']) && !isset($q['id'])) $q['id'] = $q['profile_id'];
$qs = http_build_query($q);
header('Location: ../module-4/Frontend/pages/interests.php' . ($qs !== '' ? '?' . $qs : '') . '#sent', true, 301);
exit;
