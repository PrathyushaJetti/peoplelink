<?php
require __DIR__ . '/../components/init.php';
if (!$cid) { header('Location: ' . $F . 'community-page.php?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/peoplelink/module-4/Frontend/pages/index.php')); exit; }
$pageTitle = 'Packages'; $active = 'packages'; $scripts = ['packages.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap">
  <div class="mat-head"><div><span class="mat-eyebrow">Membership</span><h1>Matrimony packages</h1><p>A package lets you request contact details of members you like. Payments are processed securely by Razorpay.</p></div></div>
  <?php if ($user): ?><div class="mat-panel" id="myPkg" style="margin-bottom:20px"><h2><i class="fa-solid fa-crown"></i> My package</h2><div id="myPkgBody">Loading…</div></div><?php endif; ?>
  <div class="mat-plans" id="plans"></div>
  <?php if ($user): ?>
  <div class="mat-panel" style="margin-top:22px"><h2><i class="fa-solid fa-receipt"></i> Payment history</h2><div id="history">Loading…</div></div>
  <?php endif; ?>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js" defer></script>
<?php include __DIR__ . '/../components/footer.php'; ?>
