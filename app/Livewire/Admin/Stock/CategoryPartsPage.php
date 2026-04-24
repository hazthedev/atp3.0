<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Stock;

use App\Models\CategoryPart;
use Livewire\Component;

class CategoryPartsPage extends Component
{
    /** @var array<int, array<string, mixed>> */
    public array $rows = [];

    /** @var array<int, array<string, mixed>> */
    public array $originalRows = [];

    public ?int $editingIndex = null;

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(): void
    {
        $this->loadRows();
    }

    public function addRow(): void
    {
        $this->rows[] = [
            'id' => null,
            'code' => '',
            'new_code' => '',
            'name' => '',
        ];

        $this->editingIndex = array_key_last($this->rows);
        $this->statusMessage = null;
    }

    public function editRow(int $index): void
    {
        if (! array_key_exists($index, $this->rows)) {
            return;
        }

        $this->editingIndex = $this->editingIndex === $index ? null : $index;
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

    public function save(): void
    {
        $keptIds = array_filter(array_column($this->rows, 'id'));
        $originalIds = array_filter(array_column($this->originalRows, 'id'));
        $deletedIds = array_diff($originalIds, $keptIds);

        if ($deletedIds !== []) {
            CategoryPart::whereIn('id', $deletedIds)->delete();
        }

        foreach ($this->rows as $row) {
            $code = trim((string) ($row['code'] ?? ''));
            $name = trim((string) ($row['name'] ?? ''));

            if ($code === '' || $name === '') {
                continue;
            }

            $payload = [
                'new_code' => trim((string) ($row['new_code'] ?? '')) ?: null,
                'name' => $name,
            ];

            if (! empty($row['id'])) {
                $model = CategoryPart::find($row['id']);
                if ($model === null) {
                    continue;
                }
                $model->update(array_merge(['code' => $code], $payload));
            } else {
                CategoryPart::updateOrCreate(['code' => $code], $payload);
            }
        }

        $this->loadRows();
        $this->editingIndex = null;
        $this->statusMessage = 'Category parts saved.';
        $this->statusTone = 'green';
    }

    public function cancel(): void
    {
        $this->loadRows();
        $this->editingIndex = null;
        $this->statusMessage = null;
    }

    public function isDirty(): bool
    {
        return $this->rows !== $this->originalRows;
    }

    private function loadRows(): void
    {
        $this->rows = CategoryPart::orderBy('code')
            ->get()
            ->map(fn (CategoryPart $p): array => [
                'id' => $p->id,
                'code' => $p->code,
                'new_code' => $p->new_code ?? '',
                'name' => $p->name,
            ])
            ->all();

        $this->originalRows = $this->rows;
    }

    public function render()
    {
        return view('livewire.admin.stock.category-parts-page');
    }
}
