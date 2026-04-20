<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\Equipment;
use App\Models\EquipmentCalendarCounter;
use App\Models\EquipmentCounter;
use Livewire\Attributes\On;
use Livewire\Component;

class EquipmentCountersManager extends Component
{
    public bool $open = false;

    public ?int $equipmentId = null;

    public string $itemNo = '';

    public string $itemDescription = '';

    public string $serialNumber = '';

    public string $variant = '';

    public string $categoryPart = '';

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

    #[On('open-equipment-counters')]
    public function openModal(int $equipmentId): void
    {
        $equipment = Equipment::with('item')->find($equipmentId);

        if ($equipment === null) {
            return;
        }

        $this->equipmentId = $equipment->id;
        $this->itemNo = $equipment->item?->code ?? '';
        $this->itemDescription = $equipment->item?->description ?? '';
        $this->serialNumber = $equipment->serial_number;
        $this->variant = $equipment->variant ?? '';
        $this->categoryPart = $equipment->category_part ?? '';

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
        if ($this->equipmentId === null) {
            return;
        }

        foreach ($this->rows as $row) {
            if (empty($row['id'])) {
                continue;
            }

            EquipmentCounter::where('id', $row['id'])->update([
                'propagate' => $this->deactivatePropagation ? false : (bool) ($row['propagate'] ?? true),
                'reading_date' => $this->nullIfBlank($row['reading_date'] ?? null),
                'reading_hour' => trim((string) ($row['reading_hour'] ?? '00:00')) ?: '00:00',
                'value_dec' => $this->toDecimal($row['value_dec'] ?? null),
                'value_hhmm' => $this->nullIfBlank($row['value_hhmm'] ?? null),
                'max_dec' => $this->toDecimal($row['max_dec'] ?? null),
                'max_hhmm' => $this->nullIfBlank($row['max_hhmm'] ?? null),
                'is_used' => ! empty($row['value_dec']) || ! empty($row['value_hhmm']),
            ]);
        }

        if (! empty($this->calendar['id'])) {
            EquipmentCalendarCounter::where('id', $this->calendar['id'])->update([
                'value_date' => $this->nullIfBlank($this->calendar['value_date'] ?? null),
                'limit' => $this->nullIfBlank($this->calendar['limit'] ?? null),
                'remaining' => $this->nullIfBlank($this->calendar['remaining'] ?? null),
                'residual' => $this->nullIfBlank($this->calendar['residual'] ?? null),
                'info_source' => $this->nullIfBlank($this->calendar['info_source'] ?? null),
                'reset_to_null' => (bool) ($this->calendar['reset_to_null'] ?? false),
                'is_used' => ! empty($this->calendar['limit']) || ! empty($this->calendar['value_date']),
            ]);
        }

        $this->loadRows();
        $this->statusMessage = 'Equipment counters updated.';
        $this->statusTone = 'green';

        $this->dispatch('equipment-counters-updated');
    }

    public function isDirty(): bool
    {
        return $this->rows !== $this->originalRows || $this->calendar !== $this->originalCalendar;
    }

    private function loadRows(): void
    {
        $this->rows = EquipmentCounter::where('equipment_id', $this->equipmentId)
            ->with('counterRef')
            ->get()
            ->sortBy(fn (EquipmentCounter $ec) => $ec->counterRef?->sort_order ?? 999)
            ->map(fn (EquipmentCounter $c): array => [
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

        $calendar = EquipmentCalendarCounter::where('equipment_id', $this->equipmentId)->first();

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
        return view('livewire.fleet.equipment-counters-manager');
    }
}
