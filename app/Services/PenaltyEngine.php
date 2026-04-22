<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\CounterHistory;
use App\Models\Equipment;
use App\Models\EquipmentCounter;
use App\Models\FunctionalLocation;
use App\Models\FunctionalLocationCounter;
use App\Models\PenaltyRule;

class PenaltyEngine
{
    public const MAX_DEPTH = 5;

    public const SUBJECT_FL = 'functional_location';

    public const SUBJECT_EQUIPMENT = 'equipment';

    /**
     * Apply all active penalties triggered by a counter change.
     *
     * @param  string  $subjectType  'functional_location' or 'equipment'
     * @param  array<int>  $selectedPenaltyIds  If non-empty, only apply rules with these penalty_ids.
     */
    public function cascade(
        string $subjectType,
        int $subjectId,
        int $monitoringCounterRefId,
        float $deltaDec,
        array $selectedPenaltyIds = [],
        string $sourceRef = '',
    ): PenaltyCascadeResult {
        $result = new PenaltyCascadeResult();

        if ($deltaDec <= 0) {
            return $result;
        }

        $this->cascadeAtDepth(
            $subjectType,
            $subjectId,
            $monitoringCounterRefId,
            $deltaDec,
            $selectedPenaltyIds,
            $sourceRef,
            1,
            $result,
        );

        return $result;
    }

    /**
     * @param  array<int>  $selectedPenaltyIds
     */
    private function cascadeAtDepth(
        string $subjectType,
        int $subjectId,
        int $monitoringCounterRefId,
        float $deltaDec,
        array $selectedPenaltyIds,
        string $sourceRef,
        int $depth,
        PenaltyCascadeResult $result,
    ): void {
        $subjectId = (int) $subjectId;
        $monitoringCounterRefId = (int) $monitoringCounterRefId;

        $result->maxDepthReached = max($result->maxDepthReached, $depth);

        if ($depth > self::MAX_DEPTH) {
            $result->depthLimitHit = true;
            $result->warnings[] = "Depth limit {$depth} exceeded for cascade on {$subjectType}:{$subjectId}";

            return;
        }

        // Rule subject_type is 'functional_location' or 'item' — translate equipment → item.
        // The recursion after incrementTargetCounter passes the filter [] so downstream
        // rules always run without the caller's per-flight penalty selection.
        $ruleSubjectType = $subjectType;
        $ruleSubjectId = $subjectId;

        if ($subjectType === self::SUBJECT_EQUIPMENT) {
            $equipment = Equipment::find($subjectId);

            if ($equipment === null || $equipment->item_id === null) {
                return;
            }

            $ruleSubjectType = 'item';
            $ruleSubjectId = (int) $equipment->item_id;
        }

        $query = PenaltyRule::query()
            ->where('is_active', true)
            ->where('subject_type', $ruleSubjectType)
            ->where('subject_id', $ruleSubjectId)
            ->where('monitoring_counter_ref_id', $monitoringCounterRefId);

        if ($selectedPenaltyIds !== []) {
            $query->whereIn('penalty_id', $selectedPenaltyIds);
        }

        $rules = $query->with('penalty')->get();

        foreach ($rules as $rule) {
            $this->applyRule($rule, $subjectType, $subjectId, $deltaDec, $sourceRef, $depth, $result);
        }
    }

    private function applyRule(
        PenaltyRule $rule,
        string $subjectType,
        int $subjectId,
        float $deltaDec,
        string $sourceRef,
        int $depth,
        PenaltyCascadeResult $result,
    ): void {
        $target = $this->resolveTarget($rule, $subjectType, $subjectId, $result);

        if ($target === null) {
            return;
        }

        $result->rulesFired[] = $rule->id;

        $penaltyCode = $rule->penalty?->code ?? 'penalty_' . $rule->penalty_id;
        $cascadeRef = $sourceRef !== '' ? $sourceRef . '|penalty:' . $penaltyCode : 'penalty:' . $penaltyCode;

        // Rate increment (applied per delta unit)
        if ($rule->rate_counter_ref_id !== null) {
            $rateIncrement = $deltaDec * (float) $rule->rate_value;
            if ($rateIncrement !== 0.0) {
                $this->incrementTargetCounter(
                    $target,
                    (int) $rule->rate_counter_ref_id,
                    $rateIncrement,
                    'penalty_cascade',
                    $cascadeRef,
                    $result,
                    $depth,
                );
            }
        }

        // Static increment (applied once per cascade event)
        if ($rule->static_counter_ref_id !== null) {
            $staticIncrement = (float) $rule->static_value;
            if ($staticIncrement !== 0.0) {
                $this->incrementTargetCounter(
                    $target,
                    (int) $rule->static_counter_ref_id,
                    $staticIncrement,
                    'penalty_cascade',
                    $cascadeRef,
                    $result,
                    $depth,
                );
            }
        }
    }

    /**
     * Resolve the concrete target (FL or Equipment) for a rule.
     *
     * @return array{type: string, id: int}|null
     */
    private function resolveTarget(
        PenaltyRule $rule,
        string $subjectType,
        int $subjectId,
        PenaltyCascadeResult $result,
    ): ?array {
        if ($rule->target_item_id === null) {
            return ['type' => $subjectType, 'id' => $subjectId];
        }

        if ($subjectType === self::SUBJECT_FL) {
            $fl = FunctionalLocation::find($subjectId);

            if ($fl === null) {
                return null;
            }

            // Naive installed-base lookup: match owner + On Aircraft + target item.
            // TODO: replace with proper installed-base tree when that exists.
            $equipment = Equipment::query()
                ->where('item_id', $rule->target_item_id)
                ->where('status', 'On Aircraft')
                ->when($fl->owner_code !== null, fn ($q) => $q->where('owner_code', $fl->owner_code))
                ->first();

            if ($equipment === null) {
                $result->warnings[] = "Rule {$rule->id}: no Equipment found with item_id={$rule->target_item_id} installed on FL {$subjectId}";

                return null;
            }

            return ['type' => self::SUBJECT_EQUIPMENT, 'id' => (int) $equipment->id];
        }

        if ($subjectType === self::SUBJECT_EQUIPMENT) {
            // Sub-equipment targeting would require a hierarchy table we don't have yet.
            $result->warnings[] = "Rule {$rule->id}: sub-equipment targeting not supported (no installed-base hierarchy)";

            return null;
        }

        return null;
    }

    /**
     * @param  array{type: string, id: int}  $target
     */
    private function incrementTargetCounter(
        array $target,
        int $counterRefId,
        float $increment,
        string $sourceType,
        string $sourceRef,
        PenaltyCascadeResult $result,
        int $depth,
    ): void {
        if ($target['type'] === self::SUBJECT_EQUIPMENT) {
            $counter = EquipmentCounter::firstOrCreate(
                ['equipment_id' => $target['id'], 'counter_ref_id' => $counterRefId],
                ['propagate' => true, 'reading_hour' => '00:00', 'is_used' => true],
            );
            $subjectType = self::SUBJECT_EQUIPMENT;
            $subjectId = $target['id'];
        } elseif ($target['type'] === self::SUBJECT_FL) {
            $counter = FunctionalLocationCounter::firstOrCreate(
                ['functional_location_id' => $target['id'], 'counter_ref_id' => $counterRefId],
                ['propagate' => true, 'reading_hour' => '00:00', 'is_used' => true],
            );
            $subjectType = self::SUBJECT_FL;
            $subjectId = $target['id'];
        } else {
            return;
        }

        $prevValueDec = $counter->value_dec !== null ? (float) $counter->value_dec : null;
        $newValueDec = ($prevValueDec ?? 0.0) + $increment;

        $counter->value_dec = $newValueDec;
        $counter->is_used = true;
        $counter->save();

        CounterHistory::create([
            'counter_ref_id' => $counterRefId,
            'subject_type' => $subjectType,
            'subject_id' => $subjectId,
            'previous_value_dec' => $prevValueDec,
            'new_value_dec' => $newValueDec,
            'delta_dec' => $increment,
            'source_type' => $sourceType,
            'source_ref' => $sourceRef,
            'note' => 'Penalty cascade (depth ' . $depth . ')',
        ]);

        $result->affectedTargets[] = ['type' => $subjectType, 'id' => $subjectId];
        $result->historyRowsWritten++;

        // Recurse: this increment may itself trigger further penalties
        $this->cascadeAtDepth(
            $subjectType,
            $subjectId,
            $counterRefId,
            $increment,
            [],
            $sourceRef,
            $depth + 1,
            $result,
        );
    }
}
