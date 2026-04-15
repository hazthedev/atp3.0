<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\GenerateEquipmentCardCatalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class GenerateEquipmentCardPage extends Component
{
    public string $mode = 'standard';

    public string $inStockFilter = '';

    public string $itemGroupFilter = '';

    /** @var array<int, string> */
    public array $selectedIds = [];

    /** @var array<string, string> */
    public array $rowStatuses = [];

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(string $mode = 'standard'): void
    {
        $this->mode = $mode;

        foreach (GenerateEquipmentCardCatalog::all() as $row) {
            $this->rowStatuses[$row['id']] = (string) $row['status'];
        }
    }

    public function checkAllVisible(): void
    {
        $this->selectedIds = $this->filteredRows()->pluck('id')->map(fn ($id) => (string) $id)->all();
        $this->setStatus('Selected all visible equipment rows for generation.', 'blue');
    }

    public function uncheckAll(): void
    {
        $this->selectedIds = [];
        $this->setStatus('Cleared all equipment-card selections.', 'blue');
    }

    public function generatePreview(): void
    {
        $count = count($this->selectedIds);

        if ($count === 0) {
            $this->setStatus('Choose at least one equipment row before generating cards.', 'amber');

            return;
        }

        $label = $this->mode === 'customer' ? 'customer equipment card' : 'equipment card';
        $this->setStatus(sprintf('Generation preview ready for %d %s%s.', $count, $label, $count === 1 ? '' : 's'), 'green');
    }

    public function cancelSelection(): void
    {
        $this->selectedIds = [];
        $this->setStatus('Generation workspace reset. Filters and row statuses remain available.', 'blue');
    }

    public function render()
    {
        $rows = $this->filteredRows();
        $title = $this->mode === 'customer' ? 'Generate Customer Equipment Card' : 'Generate Equipment Card';
        $description = $this->mode === 'customer'
            ? 'Review equipment rows, filter by stock and item group, then stage customer-card generation.'
            : 'Review equipment rows, filter by stock and item group, then stage equipment-card generation.';

        return view('livewire.fleet.generate-equipment-card-page', [
            'pageTitle' => $title,
            'pageDescription' => $description,
            'rows' => $rows,
            'inStockOptions' => [
                'Yes' => 'Yes',
                'No' => 'No',
            ],
            'itemGroupOptions' => [
                '120' => '120  -  AIRCRAFT SPARES',
                '121' => '121  -  CONSUMABLE',
                '129' => '129  -  FIXED ASSETS',
                '122' => '122  -  INGREDIENTS',
                '123' => '123  -  SAFETY & SURVIVAL EQP',
                '124' => '124  -  TOOLS AND GSE',
            ],
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, string|bool>>
     */
    private function filteredRows(): Collection
    {
        return GenerateEquipmentCardCatalog::all()
            ->filter(function (array $row): bool {
                if ($this->inStockFilter !== '' && $row['in_stock'] !== $this->inStockFilter) {
                    return false;
                }

                if ($this->itemGroupFilter !== '' && ($row['item_group_code'] ?? '') !== $this->itemGroupFilter) {
                    return false;
                }

                return true;
            })
            ->values();
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
