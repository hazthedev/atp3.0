<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\CounterRef;
use App\Models\Item;
use App\Models\ItemCalendarCounter;
use App\Models\ItemCounter;
use App\Models\MroStatusObject;
use Livewire\Attributes\On;
use Livewire\Component;

class ItemCountersManager extends Component
{
    public bool $open = false;

    public ?int $itemId = null;

    public string $itemNumber = '';

    public string $itemDescription = '';

    public string $tab = 'counters';

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

    public ?int $editingIndex = null;

    public bool $editingCalendar = false;

    /** @var array<int, array{code: string, name: string}> */
    public array $statusOptions = [];

    /** @var array<int, array{id: int, code: string, name: string}> */
    public array $counterRefOptions = [];

    #[On('open-item-counters')]
    public function openModal(int $itemId): void
    {
        $item = Item::find($itemId);

        if ($item === null) {
            return;
        }

        $this->itemId = $item->id;
        $this->itemNumber = $item->code;
        $this->itemDescription = $item->description;
        $this->loadOptions();
        $this->loadRows();
        $this->tab = 'counters';
        $this->open = true;
        $this->editingIndex = null;
        $this->editingCalendar = false;
        $this->statusMessage = null;
    }

    public function closeModal(): void
    {
        $this->open = false;
        $this->editingIndex = null;
        $this->editingCalendar = false;
    }

    public function addRow(): void
    {
        $this->rows[] = [
            'id' => null,
            'counter_ref_id' => null,
            'counter_name' => '',
            'max_value_dec' => '',
            'max_value_hhmm' => '',
            'tolerance_dec' => '',
            'tolerance_hhmm' => '',
            'orange_light_percent' => 90,
            'status' => 'Validate',
            'modif_ref' => '',
        ];

        $this->editingIndex = array_key_last($this->rows);
    }

    public function removeRow(int $index): void
    {
        if (! array_key_exists($index, $this->rows)) {
            return;
        }

        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);

        if ($this->editingIndex === $index) {
            $this->editingIndex = null;
        } elseif ($this->editingIndex !== null && $this->editingIndex > $index) {
            $this->editingIndex--;
        }
    }

    public function editRow(int $index): void
    {
        if (! array_key_exists($index, $this->rows)) {
            return;
        }

        $this->editingIndex = $this->editingIndex === $index ? null : $index;
    }

    public function editCalendar(): void
    {
        $this->editingCalendar = ! $this->editingCalendar;
    }

    public function save(): void
    {
        if ($this->itemId === null) {
            return;
        }

        $keptIds = array_filter(array_column($this->rows, 'id'));
        $originalIds = array_filter(array_column($this->originalRows, 'id'));
        $deletedIds = array_diff($originalIds, $keptIds);

        if ($deletedIds !== []) {
            ItemCounter::whereIn('id', $deletedIds)->delete();
        }

        foreach ($this->rows as $row) {
            $counterRefId = $row['counter_ref_id'] ?? null;

            if (! $counterRefId) {
                continue;
            }

            $payload = [
                'max_value_dec' => $this->nullIfBlank($row['max_value_dec'] ?? null),
                'max_value_hhmm' => $this->nullIfBlank($row['max_value_hhmm'] ?? null),
                'tolerance_dec' => $this->nullIfBlank($row['tolerance_dec'] ?? null),
                'tolerance_hhmm' => $this->nullIfBlank($row['tolerance_hhmm'] ?? null),
                'orange_light_percent' => (int) ($row['orange_light_percent'] ?? 90),
                'status' => trim((string) ($row['status'] ?? 'Validate')) ?: 'Validate',
                'modif_ref' => $this->nullIfBlank($row['modif_ref'] ?? null),
            ];

            if (! empty($row['id'])) {
                $model = ItemCounter::find($row['id']);

                if ($model !== null) {
                    $model->update(array_merge(['counter_ref_id' => (int) $counterRefId], $payload));
                }
            } else {
                ItemCounter::updateOrCreate(
                    ['item_id' => $this->itemId, 'counter_ref_id' => (int) $counterRefId],
                    $payload,
                );
            }
        }

        ItemCalendarCounter::updateOrCreate(
            ['item_id' => $this->itemId],
            [
                'label' => trim((string) ($this->calendar['label'] ?? 'Calendar Limit')) ?: 'Calendar Limit',
                'limit_days' => $this->toInt($this->calendar['limit_days'] ?? null),
                'orange_light_days' => (int) ($this->calendar['orange_light_days'] ?? 90),
                'status' => trim((string) ($this->calendar['status'] ?? 'Validate')) ?: 'Validate',
            ],
        );

        $this->loadRows();
        $this->editingIndex = null;
        $this->editingCalendar = false;
        $this->statusMessage = 'Item counters saved.';
        $this->statusTone = 'green';

        $this->dispatch('item-counters-updated');
    }

    public function isDirty(): bool
    {
        return $this->rows !== $this->originalRows || $this->calendar !== $this->originalCalendar;
    }

    private function loadOptions(): void
    {
        $this->statusOptions = MroStatusObject::whereIn('name', ['Validate', 'No Valid', 'Non Updatable'])
            ->orderBy('name')
            ->get(['code', 'name'])
            ->map(fn (MroStatusObject $status): array => ['code' => $status->code, 'name' => $status->name])
            ->all();

        $this->counterRefOptions = CounterRef::orderBy('code')
            ->get(['id', 'code', 'name'])
            ->map(fn (CounterRef $ref): array => ['id' => $ref->id, 'code' => $ref->code, 'name' => $ref->name])
            ->all();
    }

    private function loadRows(): void
    {
        $this->rows = ItemCounter::where('item_id', $this->itemId)
            ->with('counterRef')
            ->get()
            ->map(fn (ItemCounter $counter): array => [
                'id' => $counter->id,
                'counter_ref_id' => $counter->counter_ref_id,
                'counter_name' => $counter->counterRef?->name ?? '',
                'max_value_dec' => $counter->max_value_dec ?? '',
                'max_value_hhmm' => $counter->max_value_hhmm ?? '',
                'tolerance_dec' => $counter->tolerance_dec ?? '',
                'tolerance_hhmm' => $counter->tolerance_hhmm ?? '',
                'orange_light_percent' => $counter->orange_light_percent ?? 90,
                'status' => $counter->status ?? 'Validate',
                'modif_ref' => $counter->modif_ref ?? '',
            ])
            ->all();

        $this->originalRows = $this->rows;

        $calendar = ItemCalendarCounter::where('item_id', $this->itemId)->first();

        $this->calendar = [
            'id' => $calendar?->id,
            'label' => $calendar?->label ?? 'Calendar Limit',
            'limit_days' => $calendar?->limit_days,
            'orange_light_days' => $calendar?->orange_light_days ?? 90,
            'status' => $calendar?->status ?? 'Validate',
        ];

        $this->originalCalendar = $this->calendar;
    }

    private function toInt(mixed $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        return (int) $value;
    }

    private function nullIfBlank(mixed $value): ?string
    {
        $trimmed = trim((string) $value);

        return $trimmed === '' ? null : $trimmed;
    }

    public function render()
    {
        return view('livewire.fleet.item-counters-manager');
    }
}
