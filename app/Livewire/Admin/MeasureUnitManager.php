<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\MeasureUnit;
use Livewire\Attributes\On;
use Livewire\Component;

class MeasureUnitManager extends Component
{
    public bool $open = false;

    /** @var array<int, array<string, mixed>> */
    public array $rows = [];

    /** @var array<int, array<string, mixed>> */
    public array $originalRows = [];

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public ?int $editingIndex = null;

    public function mount(): void
    {
        $this->loadRows();
    }

    #[On('open-measure-units')]
    public function openModal(): void
    {
        $this->loadRows();
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
        $this->rows[] = [
            'id' => null,
            'code' => '',
            'new_code' => '',
            'designation' => '',
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

    public function save(): void
    {
        $keptIds = array_filter(array_column($this->rows, 'id'));
        $originalIds = array_filter(array_column($this->originalRows, 'id'));
        $deletedIds = array_diff($originalIds, $keptIds);

        if ($deletedIds !== []) {
            MeasureUnit::whereIn('id', $deletedIds)->delete();
        }

        foreach ($this->rows as $row) {
            $code = trim((string) ($row['code'] ?? ''));
            $designation = trim((string) ($row['designation'] ?? ''));

            if ($code === '' || $designation === '') {
                continue;
            }

            if (! empty($row['id'])) {
                $model = MeasureUnit::find($row['id']);

                if ($model === null) {
                    continue;
                }

                $model->update([
                    'code' => $code,
                    'new_code' => trim((string) ($row['new_code'] ?? '')) ?: null,
                    'designation' => $designation,
                ]);
            } else {
                MeasureUnit::updateOrCreate(
                    ['code' => $code],
                    [
                        'new_code' => trim((string) ($row['new_code'] ?? '')) ?: null,
                        'designation' => $designation,
                    ],
                );
            }
        }

        $this->loadRows();
        $this->editingIndex = null;
        $this->statusMessage = 'Measure units saved.';
        $this->statusTone = 'green';

        $this->dispatch('measure-units-updated');
    }

    public function isDirty(): bool
    {
        return $this->rows !== $this->originalRows;
    }

    private function loadRows(): void
    {
        $this->rows = MeasureUnit::orderBy('designation')
            ->get()
            ->map(fn (MeasureUnit $unit): array => [
                'id' => $unit->id,
                'code' => $unit->code,
                'new_code' => $unit->new_code ?? '',
                'designation' => $unit->designation,
            ])
            ->all();

        $this->originalRows = $this->rows;
    }

    public function render()
    {
        return view('livewire.admin.measure-unit-manager');
    }
}
