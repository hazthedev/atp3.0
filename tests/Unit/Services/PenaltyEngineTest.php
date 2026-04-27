<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\Models\CounterHistory;
use App\Models\CounterRef;
use App\Models\Equipment;
use App\Models\EquipmentCounter;
use App\Models\Item;
use App\Models\Penalty;
use App\Models\PenaltyRule;
use App\Services\PenaltyCascadeResult;
use App\Services\PenaltyEngine;
use Tests\Fixtures\PenaltyEngineFixtures;
use Tests\TestCase;

class PenaltyEngineTest extends TestCase
{
    private PenaltyEngine $engine;

    protected function setUp(): void
    {
        parent::setUp();
        $this->engine = new PenaltyEngine();
    }

    public function test_returns_penalty_cascade_result_dto(): void
    {
        $scenario = PenaltyEngineFixtures::createCascadeScenario();

        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $scenario['sourceEquipment']->id,
            $scenario['monitoringCounter']->id,
            1.0,
        );

        $this->assertInstanceOf(PenaltyCascadeResult::class, $result);
    }

    public function test_no_matching_rules_returns_empty_result_with_no_warnings(): void
    {
        // Make a scenario with subjects but no rules
        $item = Item::factory()->create();
        $equipment = Equipment::factory()->create(['item_id' => $item->id]);
        $counter = CounterRef::factory()->create();

        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $equipment->id,
            $counter->id,
            5.0,
        );

        $this->assertSame([], $result->rulesFired);
        $this->assertSame([], $result->affectedTargets);
        $this->assertSame([], $result->warnings);
        $this->assertSame(0, $result->historyRowsWritten);
    }

    public function test_zero_delta_short_circuits_with_no_penalties(): void
    {
        $scenario = PenaltyEngineFixtures::createCascadeScenario();

        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $scenario['sourceEquipment']->id,
            $scenario['monitoringCounter']->id,
            0.0,
        );

        $this->assertSame([], $result->rulesFired);
        $this->assertSame(0, $result->historyRowsWritten);
        $this->assertSame(0, CounterHistory::count());
    }

    public function test_single_rule_rate_cascade_applies_to_target_counter(): void
    {
        $scenario = PenaltyEngineFixtures::createCascadeScenario();

        // rate_value = 1.0 already; delta=3 means rate increment = 3
        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $scenario['sourceEquipment']->id,
            $scenario['monitoringCounter']->id,
            3.0,
        );

        $this->assertSame([$scenario['rule']->id], $result->rulesFired);

        $counter = EquipmentCounter::where('equipment_id', $scenario['sourceEquipment']->id)
            ->where('counter_ref_id', $scenario['rateCounter']->id)
            ->first();

        $this->assertNotNull($counter);
        $this->assertEqualsWithDelta(3.0, (float) $counter->value_dec, 0.0001);
    }

    public function test_single_rule_static_cascade_applies(): void
    {
        $scenario = PenaltyEngineFixtures::createCascadeScenario();
        $staticCounter = CounterRef::factory()->create();

        // Override rule to be static-only
        $scenario['rule']->update([
            'rate_value' => 0,
            'rate_counter_ref_id' => null,
            'static_value' => 7.5,
            'static_counter_ref_id' => $staticCounter->id,
        ]);

        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $scenario['sourceEquipment']->id,
            $scenario['monitoringCounter']->id,
            2.0,
        );

        $this->assertSame([$scenario['rule']->id], $result->rulesFired);

        $counter = EquipmentCounter::where('equipment_id', $scenario['sourceEquipment']->id)
            ->where('counter_ref_id', $staticCounter->id)
            ->first();

        $this->assertNotNull($counter);
        // Static increment is applied once regardless of delta size
        $this->assertEqualsWithDelta(7.5, (float) $counter->value_dec, 0.0001);
    }

    public function test_inactive_rule_is_skipped(): void
    {
        $scenario = PenaltyEngineFixtures::createCascadeScenario();
        $scenario['rule']->update(['is_active' => false]);

        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $scenario['sourceEquipment']->id,
            $scenario['monitoringCounter']->id,
            5.0,
        );

        $this->assertSame([], $result->rulesFired);
        $this->assertSame(0, $result->historyRowsWritten);
    }

    public function test_selected_only_mode_filters_to_chosen_penalty_ids(): void
    {
        $scenario = PenaltyEngineFixtures::createCascadeScenario();
        $otherPenalty = Penalty::factory()->create();
        PenaltyRule::factory()->create([
            'penalty_id' => $otherPenalty->id,
            'subject_type' => 'item',
            'subject_id' => $scenario['sourceItem']->id,
            'monitoring_counter_ref_id' => $scenario['monitoringCounter']->id,
            'rate_value' => 1.0,
            'rate_counter_ref_id' => $scenario['rateCounter']->id,
            'is_active' => true,
        ]);

        // Only pick the original penalty
        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $scenario['sourceEquipment']->id,
            $scenario['monitoringCounter']->id,
            1.0,
            [$scenario['penalty']->id],
        );

        $this->assertCount(1, $result->rulesFired);
        $this->assertSame($scenario['rule']->id, $result->rulesFired[0]);
    }

    public function test_multi_level_cascade_tracks_depth_correctly(): void
    {
        // Source eq (item A) — rule fires on counter1 → increments counter2 on same eq
        // Then a second rule on item A: monitoring counter2 → increments counter3
        $itemA = Item::factory()->create();
        $eq = Equipment::factory()->create(['item_id' => $itemA->id]);
        $counter1 = CounterRef::factory()->create();
        $counter2 = CounterRef::factory()->create();
        $counter3 = CounterRef::factory()->create();
        $penalty = Penalty::factory()->create();

        PenaltyRule::factory()->create([
            'penalty_id' => $penalty->id,
            'subject_type' => 'item',
            'subject_id' => $itemA->id,
            'monitoring_counter_ref_id' => $counter1->id,
            'rate_value' => 1.0,
            'rate_counter_ref_id' => $counter2->id,
            'is_active' => true,
        ]);

        PenaltyRule::factory()->create([
            'penalty_id' => $penalty->id,
            'subject_type' => 'item',
            'subject_id' => $itemA->id,
            'monitoring_counter_ref_id' => $counter2->id,
            'rate_value' => 2.0,
            'rate_counter_ref_id' => $counter3->id,
            'is_active' => true,
        ]);

        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $eq->id,
            $counter1->id,
            5.0,
        );

        $this->assertGreaterThanOrEqual(2, $result->maxDepthReached);

        $c2 = EquipmentCounter::where('equipment_id', $eq->id)
            ->where('counter_ref_id', $counter2->id)
            ->first();
        $c3 = EquipmentCounter::where('equipment_id', $eq->id)
            ->where('counter_ref_id', $counter3->id)
            ->first();

        $this->assertEqualsWithDelta(5.0, (float) $c2->value_dec, 0.0001);
        $this->assertEqualsWithDelta(10.0, (float) $c3->value_dec, 0.0001);
    }

    public function test_depth_limit_produces_warning_no_infinite_recursion(): void
    {
        // Self-cascading rule: monitoring=rate, so each fire triggers another fire
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create(['item_id' => $item->id]);
        $counter = CounterRef::factory()->create();
        $penalty = Penalty::factory()->create();

        PenaltyRule::factory()->create([
            'penalty_id' => $penalty->id,
            'subject_type' => 'item',
            'subject_id' => $item->id,
            'monitoring_counter_ref_id' => $counter->id,
            'rate_value' => 1.0,
            'rate_counter_ref_id' => $counter->id,
            'is_active' => true,
        ]);

        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $eq->id,
            $counter->id,
            1.0,
        );

        $this->assertTrue($result->depthLimitHit);
        $this->assertGreaterThan(0, count($result->warnings));
        $this->assertGreaterThan(PenaltyEngine::MAX_DEPTH, $result->maxDepthReached);
    }

    public function test_equipment_target_via_installed_base_resolves_to_equipment_with_matching_item(): void
    {
        // FL subject + rule with target_item_id → should locate Equipment via owner + on-aircraft + item.
        $fl = \App\Models\FunctionalLocation::factory()->create([
            'owner_code' => 'OWNER-X',
        ]);

        $targetItem = Item::factory()->create();
        $targetEquipment = Equipment::factory()->create([
            'item_id' => $targetItem->id,
            'owner_code' => 'OWNER-X',
            'status' => 'On Aircraft',
        ]);

        $monitoringCounter = CounterRef::factory()->create();
        $rateCounter = CounterRef::factory()->create();
        $penalty = Penalty::factory()->create();

        PenaltyRule::factory()->create([
            'penalty_id' => $penalty->id,
            'subject_type' => PenaltyEngine::SUBJECT_FL,
            'subject_id' => $fl->id,
            'target_item_id' => $targetItem->id,
            'monitoring_counter_ref_id' => $monitoringCounter->id,
            'rate_value' => 1.0,
            'rate_counter_ref_id' => $rateCounter->id,
            'is_active' => true,
        ]);

        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_FL,
            $fl->id,
            $monitoringCounter->id,
            2.0,
        );

        $this->assertCount(1, $result->affectedTargets);
        $this->assertSame(PenaltyEngine::SUBJECT_EQUIPMENT, $result->affectedTargets[0]['type']);
        $this->assertSame($targetEquipment->id, $result->affectedTargets[0]['id']);
    }

    public function test_counter_history_row_is_created_for_every_applied_penalty(): void
    {
        $scenario = PenaltyEngineFixtures::createCascadeScenario();

        $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $scenario['sourceEquipment']->id,
            $scenario['monitoringCounter']->id,
            4.0,
        );

        $rows = CounterHistory::all();
        $this->assertCount(1, $rows);

        $row = $rows->first();
        $this->assertSame('penalty_cascade', $row->source_type);
        $this->assertSame(PenaltyEngine::SUBJECT_EQUIPMENT, $row->subject_type);
        $this->assertSame((float) 4.0, (float) $row->delta_dec);
    }

    public function test_first_or_create_for_missing_target_counter_does_not_crash(): void
    {
        $scenario = PenaltyEngineFixtures::createCascadeScenario();

        // Pre-condition: no EquipmentCounter exists yet for the rate counter
        $this->assertSame(0, EquipmentCounter::where('counter_ref_id', $scenario['rateCounter']->id)->count());

        $result = $this->engine->cascade(
            PenaltyEngine::SUBJECT_EQUIPMENT,
            $scenario['sourceEquipment']->id,
            $scenario['monitoringCounter']->id,
            1.0,
        );

        $this->assertCount(1, $result->rulesFired);
        $counter = EquipmentCounter::where('counter_ref_id', $scenario['rateCounter']->id)->first();
        $this->assertNotNull($counter);
        $this->assertTrue((bool) $counter->propagate);
        $this->assertTrue((bool) $counter->is_used);
        $this->assertSame('00:00', $counter->reading_hour);
    }
}
