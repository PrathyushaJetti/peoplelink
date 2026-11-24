<?php
// Shared loader for the Family Tree pages. The tree is built from the registered family (Member & Family module):
// every family member's relationship to the family head decides the generation they appear in.
require_once dirname(__DIR__) . '/m-f-registration/_family.php'; // login, community, mf_family(), mf_bundle()

/* ?family=ID shows another family's tree only when that tree is approved and active (Family Tree admin approval) */
function ft_family(int $uid, int $cid, ?int $id): ?array {
    if ($id) {
        $f = rows('SELECT * FROM families WHERE id=? AND community_id=?', [$id, $cid])[0] ?? null;
        if (!$f) return null;
        if ((int)$f['user_id'] !== $uid && ($f['status'] !== 'approved' || !$f['is_active'] || $f['tree_status'] !== 'approved' || !$f['tree_active'])) return null;
        return $f;
    }
    return mf_family($uid, $cid, null);
}

const FT_GENERATIONS = [
    1 => ['Grandparents', ['Grandfather', 'Grandmother']],
    2 => ['Parents', ['Father', 'Mother', 'Uncle', 'Aunt']],
    3 => ['Self & Siblings', ['Self', 'Spouse', 'Brother', 'Sister', 'Other']],
    4 => ['Children', ['Son', 'Daughter']],
    5 => ['Grandchildren', ['Grandson', 'Granddaughter']],
];

function ft_initials(string $name): string {
    $p = preg_split('/\s+/', trim($name)); $r = '';
    foreach (array_slice($p, 0, 2) as $w) if ($w !== '') $r .= mb_strtoupper(mb_substr($w, 0, 1));
    return $r ?: 'PL';
}

/* one family member in the shape the tree designs use */
function ft_person(array $m, array $fam): array {
    $age = $m['dob'] ? (new DateTime($m['dob']))->diff(new DateTime())->y : null;
    $missing = [];
    if (!$m['dob']) $missing[] = 'date of birth';
    if (!$m['gender']) $missing[] = 'gender';
    if (!$m['occupation'] && ($age === null || $age >= 18)) $missing[] = 'profession';
    return ['id' => (int)$m['id'], 'name' => $m['full_name'], 'relationship' => (int)$m['is_head'] === 1 ? 'Self' : $m['relationship'],
        'age' => $age, 'profession' => $m['occupation'] ?: ($age !== null && $age < 18 ? 'Student' : ''), 'city' => $fam['city'] ?? '',
        'initials' => ft_initials($m['full_name']), 'photo' => $m['photo'] ?? '', 'missing' => $missing, 'status' => $m['status'],
        'head' => (int)$m['is_head'] === 1, 'gender' => $m['gender'] ?? ''];
}

/* [generation number => ['label' => ..., 'people' => [...]]], only generations that have people */
function ft_generations(array $members, array $fam): array {
    $out = [];
    foreach (FT_GENERATIONS as $n => [$label, $rels]) {
        $people = [];
        foreach ($members as $m) {
            $rel = (int)$m['is_head'] === 1 ? 'Self' : $m['relationship'];
            if (in_array($rel, $rels, true)) $people[] = ft_person($m, $fam);
        }
        // order inside a generation: head first, then the order of the relationship list
        usort($people, fn($a, $b) => [!$a['head'], array_search($a['relationship'], $rels)] <=> [!$b['head'], array_search($b['relationship'], $rels)]);
        if ($people) $out[$n] = ['label' => $label, 'people' => $people];
    }
    return $out;
}

/* tree status words + completion of the family details */
function ft_status(array $fam): string { return ['approved' => 'Approved', 'pending' => 'Under Review', 'rejected' => 'Needs Changes'][$fam['tree_status'] ?? ''] ?? 'Not Submitted'; }
function ft_completion(array $people): int {
    if (!$people) return 0;
    $have = 0; $all = 0;
    foreach ($people as $p) { $all += 3; $have += 3 - count($p['missing']); }
    return (int)round(100 * $have / $all);
}
