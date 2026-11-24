<?php
// Use the shared logout so the device session is also closed (device limit stays correct).
header('Location: ../matrimoney/logout.php?next=' . urlencode('/peoplelink/first/index.php'), true, 302);
exit;
