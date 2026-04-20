<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\CounterRef;
use App\Models\MeasureUnit;
use App\Models\MroStatusObject;
use Livewire\Attributes\On;
use Livewire\Component;

class CounterRefManager extends Component
{
    public bool $open = false;

    /** @var array<int, array<string, mixed>> */
    public array $rows = [];

    /** @var array<int, array<string, mixed>> */
    public array $originalRows = [];

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public ?int $editingIndex = null;

    /** @var array<int, array{code: string, name: string}> */
    public array $statusOptions = [];

    /** @var array<int, string> */
    public array $measureUnitOptions = [];

    /** @var array<int, array{code: string, name: string}> */
    public array $linkedCounterOptions = [];

    public function mount(): void
    {
        $this->loadRows();
        $this->loadOptions();
    }

    #[On('open-counter-refs')]
    public function openModal(): void
    {
        $this->loadRows();
        $this->loadOptions();
        $this->open = true;
        $this->statusMessage = null;
        $this->editingIndex = null;
    }

    public function closeModal(): void
    {
        $this->open = false;
        $this->editingIndex = null;
    }

    public function addRow(): void
    {
        $this->rows[] = $this->blankRow();
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

    public function save(): void
    {
        $keptIds = array_filter(array_column($this->rows, 'id'));
        $originalIds = array_filter(array_column($this->originalRows, 'id'));
        $deletedIds = array_diff($originalIds, $keptIds);

        if ($deletedIds !== []) {
            CounterRef::whereIn('id', $deletedIds)->delete();
        }

        foreach ($this->rows as $row) {
            $code = trim((string) ($row['code'] ?? ''));
            $name = trim((string) ($row['name'] ?? ''));

            if ($code === '' || $name === '') {
                continue;
            }

            $payload = [
                'name' => $name,
                'status' => trim((string) ($row['status'] ?? 'Validate')) ?: 'Validate',
                'measure_unit' => $this->nullIfBlank($row['measure_unit'] ?? null),
                'incr_decr' => $this->toInt($row['incr_decr'] ?? null),
                'allow_incr_decr' => $this->toInt($row['allow_incr_decr'] ?? null),
                'min_value' => $this->nullIfBlank($row['min_value'] ?? null),
                'max_value' => $this->nullIfBlank($row['max_value'] ?? null),
                'initial_value' => $this->nullIfBlank($row['initial_value'] ?? null),
                'propagation_flag' => $this->toInt($row['propagation_flag'] ?? null),
                'used_for_residual_calc' => $this->toInt($row['used_for_residual_calc'] ?? null),
                'allow_auto_incrementation' => $this->toInt($row['allow_auto_incrementation'] ?? null),
                'orange_light_limit' => $this->toInt($row['orange_light_limit'] ?? 90) ?? 90,
                'sort_order' => $this->toInt($row['sort_order'] ?? null),
                'log_instance' => $this->toInt($row['log_instance'] ?? null),
                'linked_counter' => $this->nullIfBlank($row['linked_counter'] ?? null),
                'propagation_on_linked_counter' => $this->toInt($row['propagation_on_linked_counter'] ?? null),
            ];

            if (! empty($row['id'])) {
                $model = CounterRef::find($row['id']);

                if ($model === null) {
                    continue;
                }

                $model->update(array_merge(['code' => $code], $payload));
            } else {
                CounterRef::updateOrCreate(['code' => $code], $payload);
            }
        }

        $this->loadRows();
        $this->editingIndex = null;
        $this->statusMessage = 'Counter references saved.';
        $this->statusTone = 'green';

        $this->dispatch('counter-refs-updated');
    }

    public function isDirty(): bool
    {
        return $this->rows !== $this->originalRows;
    }

    private function loadOptions(): void
    {
        $this->measureUnitOptions = MeasureUnit::orderBy('designation')->pluck('designation')->all();

        $this->linkedCounterOptions = CounterRef::orderBy('code')
            ->get(['code', 'name'])
            ->map(fn (CounterRef $ref): array => ['code' => $ref->code, 'name' => $ref->name])
            ->all();

        $this->statusOptions = MroStatusObject::orderBy('code')
            ->get(['code', 'name'])
            ->map(fn (MroStatusObject $status): array => ['code' => $status->code, 'name' => $status->name])
            ->all();
    }

    private function loadRows(): void
    {
        $this->rows = CounterRef::orderBy('code')
            ->get()
            ->map(fn (CounterRef $ref): array => [
                'id' => $ref->id,
                'code' => $ref->code,
                'name' => $ref->name,
                'status' => $ref->status ?? 'Validate',
                'measure_unit' => $ref->measure_unit ?? '',
                'incr_decr' => $ref->incr_decr,
                'allow_incr_decr' => $ref->allow_incr_decr,
                'min_value' => $ref->min_value ?? '',
                'max_value' => $ref->max_value ?? '',
                'initial_value' => $ref->initial_value ?? '',
                'propagation_flag' => $ref->propagation_flag,
                'used_for_residual_calc' => $ref->used_for_residual_calc,
                'allow_auto_incrementation' => $ref->allow_auto_incrementation,
                'orange_light_limit' => $ref->orange_light_limit ?? 90,
                'sort_order' => $ref->sort_order,
                'log_instance' => $ref->log_instance,
                'linked_counter' => $ref->linked_counter ?? '',
                'propagation_on_linked_counter' => $ref->propagation_on_linked_counter,
            ])
            ->all();

        $this->originalRows = $this->rows;
    }

    /** @return array<string, mixed> */
    private function blankRow(): array
    {
        return [
            'id' => null,
            'code' => '',
            'name' => '',
            'status' => 'Validate',
            'measure_unit' => '',
            'incr_decr' => null,
            'allow_incr_decr' => null,
            'min_value' => '',
            'max_value' => '',
            'initial_value' => '',
            'propagation_flag' => null,
            'used_for_residual_calc' => null,
            'allow_auto_incrementation' => null,
            'orange_light_limit' => 90,
            'sort_order' => null,
            'log_instance' => null,
            'linked_counter' => '',
            'propagation_on_linked_counter' => null,
        ];
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
        return view('livewire.admin.counter-ref-manager');
    }
}
