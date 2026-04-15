<?php

declare(strict_types=1);

namespace App\Livewire\Reports;

use App\Support\EquipmentCatalog;
use App\Support\ModificationCatalog;
use Livewire\Component;

class ViewModificationOnEquipmentPage extends Component
{
    public bool $searchModalOpen = false;

    public string $equipmentSearch = '';

    public ?string $pendingEquipmentId = null;

    public ?string $selectedEquipmentId = null;

    public ?string $selectedHierarchyEquipmentId = null;

    public bool $includeSubLevels = false;

    /** @var array<string, string> */
    public array $equipment = [];

    /** @var array<int, array<string, string>> */
    public array $hierarchyRows = [];

    /** @var array<int, array<string, string>> */
    public array $modificationRows = [];

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function openSearchModal(): void
    {
        $this->searchModalOpen = true;
        $this->equipmentSearch = '';
        $this->pendingEquipmentId = $this->selectedEquipmentId;
    }

    public function closeSearchModal(): void
    {
        $this->searchModalOpen = false;
        $this->equipmentSearch = '';
        $this->pendingEquipmentId = null;
    }

    public function selectSearchResult(string $equipmentId): void
    {
        $this->pendingEquipmentId = $equipmentId;
    }

    public function chooseSearchResult(): void
    {
        if ($this->pendingEquipmentId === null) {
            $this->setStatus('Select an equipment row first.', 'amber');

            return;
        }

        $record = EquipmentCatalog::find($this->pendingEquipmentId);

        if ($record === null) {
            $this->setStatus('The selected equipment record could not be found.', 'red');

            return;
        }

        $this->selectedEquipmentId = $record['id'];
        $this->equipment = [
            'equipment_no' => $record['id'],
        ];
        $this->hierarchyRows = $this->buildHierarchyRows($record);
        $this->selectedHierarchyEquipmentId = null;
        $this->modificationRows = [];

        if ($this->hierarchyRows !== []) {
            $this->selectHierarchyRow($this->hierarchyRows[0]['id']);
        }

        $this->closeSearchModal();
        $this->setStatus('Equipment ' . $record['id'] . ' selected. Review the hierarchy and embodied modifications.', 'green');
    }

    public function updatedIncludeSubLevels(): void
    {
        if ($this->selectedHierarchyEquipmentId !== null) {
            $this->refreshModificationRows();
        }
    }

    public function selectHierarchyRow(string $equipmentId): void
    {
        $record = EquipmentCatalog::find($equipmentId);

        if ($record === null) {
            return;
        }

        $this->selectedHierarchyEquipmentId = $equipmentId;
        $this->refreshModificationRows();
    }

    public function cancelPreview(): void
    {
        $this->reset([
            'equipmentSearch',
            'pendingEquipmentId',
            'selectedEquipmentId',
            'selectedHierarchyEquipmentId',
            'equipment',
            'hierarchyRows',
            'modificationRows',
            'statusMessage',
        ]);

        $this->includeSubLevels = false;
        $this->searchModalOpen = false;
        $this->statusTone = 'blue';
    }

    public function viewSelectedEquipment()
    {
        if ($this->selectedHierarchyEquipmentId === null) {
            $this->setStatus('Select a hierarchy row before opening the equipment card.', 'amber');

            return null;
        }

        return redirect()->route('fleet.equipment.show', ['id' => $this->selectedHierarchyEquipmentId]);
    }

    public function render()
    {
        return view('livewire.reports.view-modification-on-equipment-page', [
            'searchResults' => EquipmentCatalog::search($this->equipmentSearch),
            'selectedSearchRecord' => $this->pendingEquipmentId !== null ? EquipmentCatalog::find($this->pendingEquipmentId) : null,
        ]);
    }

    /**
     * @param  array<string, string>  $selected
     * @return array<int, array<string, string>>
     */
    private function buildHierarchyRows(array $selected): array
    {
        $rows = EquipmentCatalog::all()
            ->filter(static fn (array $row): bool => $row['variant'] === $selected['variant'])
            ->filter(function (array $row) use ($selected): bool {
                return $row['id'] === $selected['id'] || $row['father_reference'] !== '';
            })
            ->take(8)
            ->values();

        if ($rows->isEmpty()) {
            $rows = collect([$selected]);
        }

        return $rows
            ->map(function (array $row) use ($selected): array {
                return [
                    'id' => $row['id'],
                    'designation' => $row['id'] === $selected['id'] ? 'Selected equipment' : $row['item_name'],
                    'item_code' => $row['item_no'],
                    'serial_number' => $row['serial_number'],
                ];
            })
            ->all();
    }

    private function refreshModificationRows(): void
    {
        if ($this->selectedHierarchyEquipmentId === null) {
            $this->modificationRows = [];

            return;
        }

        $baseId = (int) $this->selectedHierarchyEquipmentId;
        $count = $this->includeSubLevels ? 5 : 3;

        $rows = ModificationCatalog::all()
            ->take($count)
            ->values()
            ->map(function (array $row, int $index) use ($baseId): array {
                return [
                    'reference' => $row['unique_ref'],
                    'title' => $row['title'],
                    'meta' => $this->includeSubLevels
                        ? 'Hierarchy level ' . ($index + 1) . ' · Embodied on branch #' . $baseId
                        : 'Embodied on equipment #' . $baseId,
                ];
            });

        $this->modificationRows = $rows->all();
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
