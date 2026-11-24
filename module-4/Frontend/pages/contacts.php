<?php
require __DIR__ . '/../components/init.php';
mat_need_profile();
$pageTitle = 'Contact requests'; $active = 'contacts'; $scripts = ['lists.js'];
include __DIR__ . '/../components/header.php';
?>
<div class="mat-wrap" id="listPage" data-kind="contacts">
  <div class="mat-head"><div><span class="mat-eyebrow">Contact access</span><h1>Contact requests</h1><p>Members ask to see your mobile and email. Sending a request uses one package credit; declined requests return it.</p></div></div>
  <div class="mat-tabs" role="tablist"><button data-tab="received">Received <span class="n" id="nRecv">0</span></button><button data-tab="sent">Sent <span class="n" id="nSent">0</span></button></div>
  <section data-pane="received"><div class="mat-rows"><div class="mat-row mat-skel"><i></i><i></i></div></div></section>
  <section data-pane="sent" hidden></section>
</div>
<?php include __DIR__ . '/../components/footer.php'; ?>
