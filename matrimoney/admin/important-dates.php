<?php
// Upcoming birthdays and anniversaries of approved members and family members.
require __DIR__ . '/_boot.php';
$days = (int)($_GET['days'] ?? 30); if (!in_array($days, [7, 30, 90], true)) $days = 30;
$list = [];
foreach ([['member', 'members', 'full_name'], ['family_member', 'family_members', 'full_name']] as [$k, $t, $n])
    foreach (['dob' => 'Birthday', 'anniversary' => 'Anniversary'] as $col => $kind)
        foreach (rows("SELECT id, $n name, $col d FROM $t WHERE community_id=? AND status='approved' AND is_active=1 AND $col IS NOT NULL" . ($t === 'family_members' ? " AND COALESCE(life_status,'Living')='Living'" : ''), [$cid]) as $r) {
            $next = strtotime(date('Y') . substr($r['d'], 4));
            if ($next < strtotime('today')) $next = strtotime((date('Y') + 1) . substr($r['d'], 4));
            $in = (int)round(($next - strtotime('today')) / 86400);
            if ($in <= $days) $list[] = ['k' => $k, 'id' => $r['id'], 'name' => $r['name'], 'kind' => $kind, 'date' => $next, 'in' => $in, 'years' => (int)date('Y', $next) - (int)substr($r['d'], 0, 4)];
        }
usort($list, fn($a, $b) => $a['in'] <=> $b['in']);
render_header('Important Dates', 'auto', $user, $comm); ?>
<div class="tabs anim"><?php foreach ([7 => 'Next 7 days', 30 => 'Next 30 days', 90 => 'Next 90 days'] as $d => $l): ?><a class="<?= $days === $d ? 'on' : '' ?>" href="?days=<?= $d ?>"><?= $l ?></a><?php endforeach; ?></div>
<div class="card anim"><?php if (!$list): ?><div class="empty"><?= icon('fa-cake-candles', 'big') ?>No birthdays or anniversaries in this period.</div><?php else: ?>
  <div class="tw"><table class="rt"><thead><tr><th>Name</th><th>Occasion</th><th>Date</th><th>In</th><th>Years</th></tr></thead><tbody>
  <?php foreach ($list as $r): ?><tr><td data-label="Name"><a class="lnk" href="manage.php?e=<?= $r['k'] ?>&view=<?= (int)$r['id'] ?>"><?= e($r['name']) ?></a><br><small><?= $r['k'] === 'member' ? 'Member' : 'Family member' ?></small></td>
    <td data-label="Occasion"><?= icon($r['kind'] === 'Birthday' ? 'fa-cake-candles' : 'fa-ring') ?> <?= $r['kind'] ?></td><td data-label="Date"><?= date('d M', $r['date']) ?></td>
    <td data-label="In"><?= $r['in'] === 0 ? badge('approved', 'Today') : $r['in'] . ' days' ?></td><td data-label="Years"><?= $r['years'] > 0 ? $r['years'] : '—' ?></td></tr><?php endforeach; ?>
  </tbody></table></div><?php endif; ?></div>
<?php render_footer();
