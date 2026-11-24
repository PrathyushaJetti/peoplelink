<?php
function scalar(string $sql, array $p = []) { $s = db()->prepare($sql); $s->execute($p); return (int)$s->fetchColumn(); }
function rows(string $sql, array $p = []): array { $s = db()->prepare($sql); $s->execute($p); return $s->fetchAll(); }
function money($n): string { return '₹' . number_format((float)$n); }
function badge(string $s, ?string $label = null): string { return '<span class="badge b-' . e($s) . '">' . e($label ?? $s) . '</span>'; }
function dshort($d): string { return date('d M Y', strtotime($d)); }
function icon(string $c, string $extra = ''): string { return '<i class="fa-solid ' . e($c) . ($extra ? ' ' . e($extra) : '') . '" aria-hidden="true"></i>'; }
function notify(int $cid, string $title, string $msg, string $type = 'general', string $aud = 'all'): void {
    db()->prepare('INSERT INTO matrimony_notifications (community_id,title,message,type,audience) VALUES (?,?,?,?,?)')->execute([$cid, $title, $msg, $type, $aud]);
}
function back(string $qs = ''): void { header('Location: ' . basename($_SERVER['SCRIPT_NAME']) . ($qs ? '?' . $qs : '')); exit; }
