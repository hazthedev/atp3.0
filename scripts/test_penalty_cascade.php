<?php

/**
 * Manual cascade smoke test. Run with:
 *   php artisan tinker --execute="require base_path('scripts/test_penalty_cascade.php');"
 *
 * Exercises the penalty engine end-to-end on seeded data and rolls back
 * so the database is unchanged afterwards.
 */

declare(strict_types=1);

use App\Models\CounterHistory;
use App\Models\CounterRef;
use App\Models\Equipment;
use App\Models\EquipmentCounter;
use App\Models\FunctionalLocation;
use App\Models\FunctionalLocationCounter;
use App\Services\PenaltyEngine;
use Illuminate\Support\Facades\DB;

$engine = app(PenaltyEngine::class);

$fl = FunctionalLocation::where('code', '9M-WAA')->first();
if ($fl === null) {
    echo "ERROR: 9M-WAA not seeded.\n";
    return;
}

$tsnRef = CounterRef::where('name', 'TSN')->first();
$e1ccRef = CounterRef::where('name', 'E#1CC')->first();

$engineItem = \App\Models\Item::where('code', 'PT6C-67C')->first();
$engine_eq = Equipment::where('item_id', $engineItem->id)->where('status', 'On Aircraft')->first();

echo "=== Pre-cascade state ===\n";
$flTsn = FunctionalLocationCounter::where('functional_location_id', $fl->id)->where('counter_ref_id', $tsnRef->id)->first();
echo 'FL TSN value_dec: ' . ($flTsn->value_dec ?? 'null') . "\n";

$eqE1cc = $engine_eq
    ? EquipmentCounter::where('equipment_id', $engine_eq->id)->where('counter_ref_id', $e1ccRef->id)->first()
    : null;
echo 'Engine E#1CC value_dec: ' . ($eqE1cc->value_dec ?? 'null (counter row may not exist yet)') . "\n";

$historyBefore = CounterHistory::count();
echo "counter_history rows before: $historyBefore\n";

DB::beginTransaction();

try {
    echo "\n=== Running cascade: +1.0 on TSN for FL 9M-WAA ===\n";
    $result = $engine->cascade(
        PenaltyEngine::SUBJECT_FL,
        $fl->id,
        $tsnRef->id,
        1.0,
        [],
        'test_script',
    );

    echo 'rules_fired: ' . count($result->rulesFired) . ' (' . implode(',', $result->rulesFired) . ")\n";
    echo 'affectedTargets: ' . count($result->affectedTargets) . "\n";
    foreach ($result->affectedTargets as $t) {
        echo "  - {$t['type']}:{$t['id']}\n";
    }
    echo "historyRowsWritten: {$result->historyRowsWritten}\n";
    echo "maxDepthReached: {$result->maxDepthReached}\n";
    echo 'depthLimitHit: ' . ($result->depthLimitHit ? 'true' : 'false') . "\n";
    if ($result->warnings !== []) {
        echo "WARNINGS:\n";
        foreach ($result->warnings as $w) {
            echo "  - $w\n";
        }
    }

    echo "\n=== Post-cascade state (before rollback) ===\n";
    $eqE1ccAfter = $engine_eq
        ? EquipmentCounter::where('equipment_id', $engine_eq->id)->where('counter_ref_id', $e1ccRef->id)->first()
        : null;
    echo 'Engine E#1CC value_dec: ' . ($eqE1ccAfter->value_dec ?? 'null') . "\n";

    $newHistory = CounterHistory::where('created_at', '>=', now()->subMinute())->orderBy('id', 'desc')->get();
    echo "\nCounterHistory rows written during cascade:\n";
    foreach ($newHistory as $h) {
        echo '  id=' . $h->id
            . " source={$h->source_type}"
            . " subject={$h->subject_type}:{$h->subject_id}"
            . " counter_ref={$h->counter_ref_id}"
            . ' prev=' . ($h->previous_value_dec ?? 'null')
            . ' new=' . ($h->new_value_dec ?? 'null')
            . ' delta=' . ($h->delta_dec ?? 'null')
            . " ref={$h->source_ref}\n";
    }
} finally {
    DB::rollBack();
    echo "\n=== Rolled back. DB restored to pre-test state. ===\n";
    $historyAfter = CounterHistory::count();
    echo "counter_history rows after rollback: $historyAfter (expected: $historyBefore)\n";
}
