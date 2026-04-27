<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use App\Models\CounterRef;
use App\Models\Equipment;
use App\Models\Item;
use App\Models\Penalty;
use App\Models\PenaltyRule;
use App\Services\PenaltyCascadeResult;
use PHPUnit\Framework\Assert;

class PenaltyEngineFixtures
{
    /**
     * Build a baseline equipment-targeted cascade scenario:
     * - source Equipment (item A) with monitoring counter
     * - target Equipment (item B) with rate counter wired in via PenaltyRule
     *
     * @return array{
     *   sourceItem: Item, targetItem: Item,
     *   sourceEquipment: Equipment, targetEquipment: Equipment,
     *   monitoringCounter: CounterRef, rateCounter: CounterRef,
     *   penalty: Penalty, rule: PenaltyRule
     * }
     */
    public static function createCascadeScenario(): array
    {
        $sourceItem = Item::factory()->create();
        $targetItem = Item::factory()->create();

        $sourceEquipment = Equipment::factory()->create([
            'item_id' => $sourceItem->id,
            'owner_code' => 'OWNER1',
            'status' => 'On Aircraft',
        ]);

        $targetEquipment = Equipment::factory()->create([
            'item_id' => $targetItem->id,
            'owner_code' => 'OWNER1',
            'status' => 'On Aircraft',
        ]);

        $monitoringCounter = CounterRef::factory()->create();
        $rateCounter = CounterRef::factory()->create();

        $penalty = Penalty::factory()->create();
        $rule = PenaltyRule::factory()->create([
            'penalty_id' => $penalty->id,
            'subject_type' => 'item',
            'subject_id' => $sourceItem->id,
            'target_item_id' => null,
            'monitoring_counter_ref_id' => $monitoringCounter->id,
            'rate_value' => 1.0,
            'rate_counter_ref_id' => $rateCounter->id,
            'is_active' => true,
        ]);

        return compact(
            'sourceItem', 'targetItem',
            'sourceEquipment', 'targetEquipment',
            'monitoringCounter', 'rateCounter',
            'penalty', 'rule',
        );
    }

    public static function assertPenaltyApplied(
        PenaltyCascadeResult $result,
        int $expectedRuleCount,
        int $expectedTargetCount,
    ): void {
        Assert::assertCount($expectedRuleCount, $result->rulesFired,
            "Expected {$expectedRuleCount} rules fired, got " . count($result->rulesFired));
        Assert::assertCount($expectedTargetCount, $result->affectedTargets,
            "Expected {$expectedTargetCount} affected targets, got " . count($result->affectedTargets));
    }
}
