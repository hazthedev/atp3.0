<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\CounterHistory;
use App\Models\FunctionalLocation;
use App\Models\FunctionalLocationCalendarCounter;
use App\Models\FunctionalLocationCounter;
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
        $this->tab = 'general';
        $this->open = true;
        $this->statusMessage = null;
        $this->deactivatePropagation = false;
    }

    public function closeModal(): void
    {
        $this->open = false;
    }

    public function save(): void
    {
        if ($this->flId === null) {
            return;
        }

        DB::transaction(function (): void {
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

                $changed = $prevValueDec !== $newValueDec || ($prevValueHhmm ?? '') !== ($newValueHhmm ?? '');

                if ($changed && $counter->counter_ref_id !== null) {
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
        });

        $this->loadRows();
        $this->statusMessage = 'Functional location counters updated.';
        $this->statusTone = 'green';

        $this->dispatch('fl-counters-updated');
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
