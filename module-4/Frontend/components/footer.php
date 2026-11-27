</main>
<div class="mat-toast" id="matToast" role="status" aria-live="polite"></div>
<div class="mat-modal" id="matModal" hidden>
  <div class="mat-modal-box" role="dialog" aria-modal="true" aria-labelledby="matModalTitle">
    <button type="button" class="mat-modal-x" data-close aria-label="Close">&times;</button>
    <h3 id="matModalTitle"></h3>
    <div id="matModalBody"></div>
  </div>
</div>
<?php include __DIR__ . '/site-footer.php'; ?>
<script src="<?= $F ?>header.js"></script>
<script src="../js/mat-api.js?v=12"></script>
<script src="../js/mat-login.js?v=3"></script>
<script src="../js/mat-signup.js?v=1"></script>
<?php foreach (($scripts ?? []) as $s): ?><script src="../js/<?= e($s) ?>?v=16"></script>
<?php endforeach; ?>
</body>
</html>
