<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\MroStatusObject;
use Livewire\Attributes\On;
use Livewire\Component;

class MroStatusObjectManager extends Component
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

    #[On('open-mro-status-objects')]
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
            'name' => '',
            'description' => '',
            'locked' => false,
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
            MroStatusObject::whereIn('id', $deletedIds)->delete();
        }

        foreach ($this->rows as $row) {
            $code = trim((string) ($row['code'] ?? ''));
            $name = trim((string) ($row['name'] ?? ''));

            if ($code === '' || $name === '') {
                continue;
            }

            $payload = [
                'name' => $name,
                'description' => trim((string) ($row['description'] ?? '')) ?: null,
                'locked' => (bool) ($row['locked'] ?? false),
            ];

            if (! empty($row['id'])) {
                $model = MroStatusObject::find($row['id']);

                if ($model === null) {
                    continue;
                }

                $model->update(array_merge(['code' => $code], $payload));
            } else {
                MroStatusObject::updateOrCreate(['code' => $code], $payload);
            }
        }

        $this->loadRows();
        $this->editingIndex = null;
        $this->statusMessage = 'Status objects saved.';
        $this->statusTone = 'green';

        $this->dispatch('mro-status-objects-updated');
    }

    public function isDirty(): bool
    {
        return $this->rows !== $this->originalRows;
    }

    private function loadRows(): void
    {
        $this->rows = MroStatusObject::orderBy('code')
            ->get()
            ->map(fn (MroStatusObject $status): array => [
                'id' => $status->id,
                'code' => $status->code,
                'name' => $status->name,
                'description' => $status->description ?? '',
                'locked' => (bool) $status->locked,
            ])
            ->all();

        $this->originalRows = $this->rows;
    }

    public function render()
    {
        return view('livewire.admin.mro-status-object-manager');
    }
}
