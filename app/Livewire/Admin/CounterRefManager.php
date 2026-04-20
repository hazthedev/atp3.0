<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\CounterRef;
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

    public function mount(): void
    {
        $this->loadRows();
    }

    #[On('open-counter-refs')]
    public function openModal(): void
    {
        $this->loadRows();
        $this->open = true;
        $this->statusMessage = null;
    }

    public function closeModal(): void
    {
        $this->open = false;
    }

    public function addRow(): void
    {
        $this->rows[] = [
            'id' => null,
            'code' => '',
            'name' => '',
            'status' => 'Validate',
            'measure_unit' => '',
        ];
    }

    public function removeRow(int $index): void
    {
        if (! array_key_exists($index, $this->rows)) {
            return;
        }

        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
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
                'measure_unit' => trim((string) ($row['measure_unit'] ?? '')) ?: null,
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
        $this->statusMessage = 'Counter references saved.';
        $this->statusTone = 'green';

        $this->dispatch('counter-refs-updated');
    }

    public function isDirty(): bool
    {
        return $this->rows !== $this->originalRows;
    }

    private function loadRows(): void
    {
        $this->rows = CounterRef::orderBy('code')
            ->get()
            ->map(fn (CounterRef $ref): array => [
                'id' => $ref->id,
                'code' => $ref->code,
                'name' => $ref->name,
                'status' => $ref->status,
                'measure_unit' => $ref->measure_unit ?? '',
            ])
            ->all();

        $this->originalRows = $this->rows;
    }

    public function render()
    {
        return view('livewire.admin.counter-ref-manager');
    }
}
