<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\CounterHistory;
use App\Models\CounterRef;
use App\Models\FunctionalLocation;
use App\Models\FunctionalLocationCalendarCounter;
use App\Models\FunctionalLocationCounter;
use App\Models\Item;
use App\Models\Penalty;
use App\Models\PenaltyRule;
use App\Services\PenaltyCascadeResult;
use App\Services\PenaltyEngine;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class FunctionalLocationCountersManager extends Component
{
    public bool $open = false;

    public ?int $flId = null;

    public string $code = '';

    public string $registration = '';

    public string $type = '';

    public string $tab = 'general';

    public bool $deactivatePropagation = false;

    /** @var array<int, array<string, mixed>> */
    public array $rows = [];

    /** @var array<int, array<string, mixed>> */
    public array $originalRows = [];

    /** @var array<string, mixed> */
    public array $calendar = [];

    /** @var array<string, mixed> */
    public array $originalCalendar = [];

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    /** @var array<int, array<string, mixed>> */
    public array $penaltyRows = [];

    /** @var array<int, array<string, mixed>> */
    public array $originalPenaltyRows = [];

    public ?int $editingPenaltyIndex = null;

    /** @var array<int, array{id: int, code: string, name: string}> */
    public array $penaltyOptions = [];

    /** @var array<int, array{id: int, code: string, name: string}> */
    public array $counterRefOptions = [];

    /** @var array<int, array{id: int, code: string, name: string}> */
    public array $targetItemOptions = [];

    #[On('open-fl-counters')]
    public function openModal(int $flId): void
    {
        $fl = FunctionalLocation::find($flId);

        if ($fl === null) {
            return;
        }

        $this->flId = $fl->id;
        $this->code = $fl->code;
        $this->registration = $fl->registration ?? '';
        $this->type = $fl->type ?? '';

        $this->loadRows();
        $this->loadPenaltyOptions();
        $this->loadPenaltyRows();
        $this->tab = 'general';
        $this->open = true;
        $this->statusMessage = null;
        $this->deactivatePropagation = false;
        $this->editingPenaltyIndex = null;
    }

    private function loadPenaltyOptions(): void
    {
        $this->penaltyOptions = Penalty::where('is_active', true)
            ->orderBy('code')
            ->get(['id', 'code', 'name'])
            ->map(fn (Penalty $p): array => ['id' => $p->id, 'code' => $p->code, 'name' => $p->name])
            ->all();

        $this->counterRefOptions = CounterRef::orderBy('name')
            ->get(['id', 'code', 'name'])
            ->map(fn (CounterRef $r): array => ['id' => $r->id, 'code' => $r->code, 'name' => $r->name])
            ->all();

        $this->targetItemOptions = Item::orderBy('code')
            ->get(['id', 'code', 'description'])
            ->map(fn (Item $i): array => ['id' => $i->id, 'code' => $i->code, 'name' => $i->description])
            ->all();
    }

    private function loadPenaltyRows(): void
    {
        $this->penaltyRows = PenaltyRule::where('subject_type', 'functional_location')
            ->where('subject_id', $this->flId)
            ->orderBy('id')
            ->get()
            ->map(fn (PenaltyRule $r): array => [
                'id' => $r->id,
                'penalty_id' => $r->penalty_id,
                'target_item_id' => $r->target_item_id,
                'monitoring_counter_ref_id' => $r->monitoring_counter_ref_id,
                'rate_value' => (string) $r->rate_value,
                'rate_counter_ref_id' => $r->rate_counter_ref_id,
                'static_value' => (string) $r->static_value,
                'static_counter_ref_id' => $r->static_counter_ref_id,
                'is_active' => (bool) $r->is_active,
            ])
            ->all();

        $this->originalPenaltyRows = $this->penaltyRows;
    }

    public function addPenaltyRow(): void
    {
        $this->penaltyRows[] = [
            'id' => null,
            'penalty_id' => null,
            'target_item_id' => null,
            'monitoring_counter_ref_id' => null,
            'rate_value' => '0',
            'rate_counter_ref_id' => null,
            'static_value' => '0',
            'static_counter_ref_id' => null,
            'is_active' => true,
        ];
        $this->editingPenaltyIndex = array_key_last($this->penaltyRows);
    }

    public function removePenaltyRow(int $index): void
    {
        if (! array_key_exists($index, $this->penaltyRows)) {
            return;
        }

        unset($this->penaltyRows[$index]);
        $this->penaltyRows = array_values($this->penaltyRows);

        if ($this->editingPenaltyIndex === $index) {
            $this->editingPenaltyIndex = null;
        } elseif ($this->editingPenaltyIndex !== null && $this->editingPenaltyIndex > $index) {
            $this->editingPenaltyIndex--;
        }
    }

    public function editPenaltyRow(int $index): void
    {
        if (! array_key_exists($index, $this->penaltyRows)) {
            return;
        }

        $this->editingPenaltyIndex = $this->editingPenaltyIndex === $index ? null : $index;
    }

    public function closeModal(): void
    {
        $this->open = false;
    }

    public function save(PenaltyEngine $engine): void
    {
        if ($this->flId === null) {
            return;
        }

        $cascadeSummary = new PenaltyCascadeResult();

        DB::transaction(function () use ($engine, $cascadeSummary): void {
            $userId = auth()->id();

            foreach ($this->rows as $row) {
                if (empty($row['id'])) {
                    continue;
                }

                $counter = FunctionalLocationCounter::with('counterRef')->find($row['id']);

                if ($counter === null) {
                    continue;
                }

                $prevValueDec = $counter->value_dec !== null ? (float) $counter->value_dec : null;
                $prevValueHhmm = $counter->value_hhmm;
                $prevReadingDate = optional($counter->reading_date)->format('Y-m-d');

                $newValueDec = $this->toDecimal($row['value_dec'] ?? null);
                $newValueHhmm = $this->nullIfBlank($row['value_hhmm'] ?? null);
                $newReadingDate = $this->nullIfBlank($row['reading_date'] ?? null);
                $newReadingHour = trim((string) ($row['reading_hour'] ?? '00:00')) ?: '00:00';

                $counter->update([
                    'propagate' => $this->deactivatePropagation ? false : (bool) ($row['propagate'] ?? true),
                    'reading_date' => $newReadingDate,
                    'reading_hour' => $newReadingHour,
                    'value_dec' => $newValueDec,
                    'value_hhmm' => $newValueHhmm,
                    'max_dec' => $this->toDecimal($row['max_dec'] ?? null),
                    'max_hhmm' => $this->nullIfBlank($row['max_hhmm'] ?? null),
                    'is_used' => ! empty($row['value_dec']) || ! empty($row['value_hhmm']),
                ]);

                $valueChanged = $prevValueDec !== $newValueDec || ($prevValueHhmm ?? '') !== ($newValueHhmm ?? '');
                $dateChanged = ($prevReadingDate ?? '') !== ($newReadingDate ?? '');
                $changed = $valueChanged || $dateChanged;

                // Don't audit an all-null row: if the counter never had a value and
                // still doesn't, a date-only change on empty isn't useful audit signal.
                $allNull = $prevValueDec === null && $newValueDec === null
                    && ($prevValueHhmm ?? '') === '' && ($newValueHhmm ?? '') === '';

                if ($changed && ! $allNull && $counter->counter_ref_id !== null) {
                    CounterHistory::create([
                        'counter_ref_id' => $counter->counter_ref_id,
                        'subject_type' => 'functional_location',
                        'subject_id' => $counter->functional_location_id,
                        'previous_value_dec' => $prevValueDec,
                        'previous_value_hhmm' => $prevValueHhmm,
                        'new_value_dec' => $newValueDec,
                        'new_value_hhmm' => $newValueHhmm,
                        'delta_dec' => $prevValueDec !== null && $newValueDec !== null
                            ? round($newValueDec - $prevValueDec, 4)
                            : null,
                        'reading_date' => $newReadingDate,
                        'reading_hour' => $newReadingHour,
                        'info_source' => $counter->info_source,
                        'source_type' => 'manual',
                        'source_ref' => 'fl_counters_manager',
                        'user_id' => $userId,
                    ]);
                }

                // Trigger penalty cascade on positive value delta only.
                if ($valueChanged
                    && $prevValueDec !== null
                    && $newValueDec !== null
                    && $counter->counter_ref_id !== null
                ) {
                    $delta = $newValueDec - $prevValueDec;
                    if ($delta > 0) {
                        $partial = $engine->cascade(
                            PenaltyEngine::SUBJECT_FL,
                            $counter->functional_location_id,
                            $counter->counter_ref_id,
                            $delta,
                            [],
                            'fl_counters_manager:' . $counter->id,
                        );
                        $this->mergeCascadeResult($cascadeSummary, $partial);
                    }
                }
            }

            if (! empty($this->calendar['id'])) {
                FunctionalLocationCalendarCounter::where('id', $this->calendar['id'])->update([
                    'value_date' => $this->nullIfBlank($this->calendar['value_date'] ?? null),
                    'limit' => $this->nullIfBlank($this->calendar['limit'] ?? null),
                    'remaining' => $this->nullIfBlank($this->calendar['remaining'] ?? null),
                    'residual' => $this->nullIfBlank($this->calendar['residual'] ?? null),
                    'info_source' => $this->nullIfBlank($this->calendar['info_source'] ?? null),
                    'reset_to_null' => (bool) ($this->calendar['reset_to_null'] ?? false),
                    'is_used' => ! empty($this->calendar['limit']) || ! empty($this->calendar['value_date']),
                ]);
            }

            $this->savePenaltyRows();
        });

        $this->loadRows();

        $message = 'Functional location counters updated.';
        if ($cascadeSummary->rulesFired !== []) {
            $message .= ' Penalty cascade: ' . $cascadeSummary->summary() . '.';
        }
        $this->statusMessage = $message;
        $this->statusTone = 'green';

        $this->dispatch('fl-counters-updated');
    }

    private function mergeCascadeResult(PenaltyCascadeResult $into, PenaltyCascadeResult $partial): void
    {
        $into->rulesFired = array_merge($into->rulesFired, $partial->rulesFired);
        $into->affectedTargets = array_merge($into->affectedTargets, $partial->affectedTargets);
        $into->historyRowsWritten += $partial->historyRowsWritten;
        $into->maxDepthReached = max($into->maxDepthReached, $partial->maxDepthReached);
        $into->depthLimitHit = $into->depthLimitHit || $partial->depthLimitHit;
        $into->warnings = array_merge($into->warnings, $partial->warnings);
    }

    public function isDirty(): bool
    {
        return $this->rows !== $this->originalRows || $this->calendar !== $this->originalCalendar;
    }

    private function loadRows(): void
    {
        $this->rows = FunctionalLocationCounter::where('functional_location_id', $this->flId)
            ->with('counterRef')
            ->get()
            ->sortBy(fn (FunctionalLocationCounter $c) => $c->counterRef?->sort_order ?? 999)
            ->map(fn (FunctionalLocationCounter $c): array => [
                'id' => $c->id,
                'counter_name' => $c->counterRef?->name ?? '',
                'propagate' => $c->propagate,
                'reading_date' => optional($c->reading_date)->format('Y-m-d'),
                'reading_hour' => $c->reading_hour ?? '00:00',
                'value_dec' => $c->value_dec,
                'value_hhmm' => $c->value_hhmm ?? '',
                'max_dec' => $c->max_dec,
                'max_hhmm' => $c->max_hhmm ?? '',
                'is_used' => $c->is_used,
            ])
            ->values()
            ->all();

        $this->originalRows = $this->rows;

        $calendar = FunctionalLocationCalendarCounter::where('functional_location_id', $this->flId)->first();

        $this->calendar = [
            'id' => $calendar?->id,
            'label' => $calendar?->label ?? 'Calendar Limit',
            'value_date' => optional($calendar?->value_date)->format('Y-m-d'),
            'limit' => $calendar?->limit ?? '',
            'remaining' => $calendar?->remaining ?? '',
            'residual' => $calendar?->residual ?? '',
            'info_source' => $calendar?->info_source ?? '',
            'is_used' => (bool) ($calendar?->is_used ?? false),
            'reset_to_null' => (bool) ($calendar?->reset_to_null ?? false),
        ];

        $this->originalCalendar = $this->calendar;
    }

    private function savePenaltyRows(): void
    {
        $keptIds = array_filter(array_column($this->penaltyRows, 'id'));
        $originalIds = array_filter(array_column($this->originalPenaltyRows, 'id'));
        $deletedIds = array_diff($originalIds, $keptIds);

        if ($deletedIds !== []) {
            PenaltyRule::whereIn('id', $deletedIds)->delete();
        }

        foreach ($this->penaltyRows as $row) {
            $penaltyId = $row['penalty_id'] ?? null;
            $monitoringId = $row['monitoring_counter_ref_id'] ?? null;

            if (! $penaltyId || ! $monitoringId) {
                continue;
            }

            $payload = [
                'penalty_id' => (int) $penaltyId,
                'subject_type' => 'functional_location',
                'subject_id' => $this->flId,
                'target_item_id' => $row['target_item_id'] ? (int) $row['target_item_id'] : null,
                'monitoring_counter_ref_id' => (int) $monitoringId,
                'rate_value' => (float) ($row['rate_value'] ?? 0),
                'rate_counter_ref_id' => $row['rate_counter_ref_id'] ? (int) $row['rate_counter_ref_id'] : null,
                'static_value' => (float) ($row['static_value'] ?? 0),
                'static_counter_ref_id' => $row['static_counter_ref_id'] ? (int) $row['static_counter_ref_id'] : null,
                'is_active' => (bool) ($row['is_active'] ?? true),
            ];

            if (! empty($row['id'])) {
                $rule = PenaltyRule::find($row['id']);
                if ($rule !== null) {
                    $rule->update($payload);
                }
            } else {
                PenaltyRule::create($payload);
            }
        }

        $this->loadPenaltyRows();
        $this->editingPenaltyIndex = null;
    }

    private function toDecimal(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (float) str_replace(',', '', (string) $value);
    }

    private function nullIfBlank(mixed $value): ?string
    {
        $trimmed = trim((string) $value);

        return $trimmed === '' ? null : $trimmed;
    }

    public function render()
    {
        return view('livewire.fleet.functional-location-counters-manager');
    }
}
