<?php

declare(strict_types=1);

namespace App\Livewire\Reports;

use App\Support\EquipmentCatalog;
use App\Support\ModificationCatalog;
use Livewire\Component;

class HistoricalEquipmentHierarchyPage extends Component
{
    public string $reportDate = '01.04.26';

    public string $reportTime = '00:00';

    public string $viewMode = 'sons';

    public bool $searchModalOpen = false;

    public string $equipmentSearch = '';

    public ?string $pendingEquipmentId = null;

    public ?string $selectedEquipmentId = null;

    public ?string $selectedHierarchyEquipmentId = null;

    /** @var array<string, string> */
    public array $equipment = [];

    /** @var array<int, array<string, string>> */
    public array $hierarchyRows = [];

    /** @var array<int, array<string, string>> */
    public array $appliedModifications = [];

    /** @var array<int, array<string, string>> */
    public array $eventRows = [];

    /** @var array<int, array<string, string>> */
    public array $counterRows = [];

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
        $this->equipment = $this->mapEquipment($record);
        $this->selectedHierarchyEquipmentId = null;
        $this->hierarchyRows = [];
        $this->appliedModifications = [];
        $this->eventRows = [];
        $this->counterRows = [];

        $this->closeSearchModal();
        $this->setStatus('Equipment ' . $record['id'] . ' selected. Click Result to load the historical hierarchy.', 'blue');
    }

    public function resultPreview(): void
    {
        if ($this->selectedEquipmentId === null) {
            $this->setStatus('Choose an equipment before requesting the report result.', 'amber');

            return;
        }

        $this->hierarchyRows = $this->buildHierarchyRows($this->selectedEquipmentId, $this->viewMode);

        if ($this->hierarchyRows === []) {
            $this->selectedHierarchyEquipmentId = null;
            $this->appliedModifications = [];
            $this->eventRows = [];
            $this->counterRows = [];
            $this->setStatus('No hierarchy rows are available for the selected equipment.', 'amber');

            return;
        }

        $this->selectHierarchyRow($this->hierarchyRows[0]['id']);

        $this->setStatus(
            $this->viewMode === 'all'
                ? 'Historical hierarchy loaded for the full equipment tree.'
                : 'Historical hierarchy loaded for son equipments only.',
            'green',
        );
    }

    public function selectHierarchyRow(string $equipmentId): void
    {
        $record = EquipmentCatalog::find($equipmentId);

        if ($record === null) {
            return;
        }

        $this->selectedHierarchyEquipmentId = $equipmentId;
        $this->appliedModifications = $this->buildAppliedModifications($record);
        $this->eventRows = $this->buildEventRows($record);
        $this->counterRows = $this->buildCounterRows($record);
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
            'appliedModifications',
            'eventRows',
            'counterRows',
            'statusMessage',
        ]);

        $this->reportDate = '01.04.26';
        $this->reportTime = '00:00';
        $this->viewMode = 'sons';
        $this->statusTone = 'blue';
        $this->searchModalOpen = false;
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
        return view('livewire.reports.historical-equipment-hierarchy-page', [
            'searchResults' => EquipmentCatalog::search($this->equipmentSearch),
            'selectedSearchRecord' => $this->pendingEquipmentId !== null ? EquipmentCatalog::find($this->pendingEquipmentId) : null,
        ]);
    }

    /**
     * @param  array<string, string>  $record
     * @return array<string, string>
     */
    private function mapEquipment(array $record): array
    {
        return [
            'equipment_no' => $record['id'],
            'serial_number' => $record['serial_number'],
            'item_code' => $record['item_no'],
            'part_description' => $record['item_name'],
            'engine_variant' => $record['variant'],
            'category_part' => $record['category_part'],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function buildHierarchyRows(string $selectedEquipmentId, string $viewMode): array
    {
        $selected = EquipmentCatalog::find($selectedEquipmentId);

        if ($selected === null) {
            return [];
        }

        $rows = EquipmentCatalog::all()
            ->filter(function (array $row) use ($selected, $viewMode): bool {
                if ($viewMode === 'all') {
                    return $row['variant'] === $selected['variant']
                        && ($row['id'] === $selected['id'] || $row['father_reference'] !== '');
                }

                return $row['variant'] === $selected['variant']
                    && $row['id'] !== $selected['id']
                    && $row['father_reference'] !== '';
            })
            ->take($viewMode === 'all' ? 8 : 6)
            ->values();

        if ($rows->isEmpty()) {
            $rows = collect([$selected]);
        }

        return $rows
            ->map(function (array $row) use ($selectedEquipmentId): array {
                $designation = $row['id'] === $selectedEquipmentId
                    ? 'Selected equipment'
                    : $row['item_name'];

                return [
                    'id' => $row['id'],
                    'designation' => $designation,
                    'item_code' => $row['item_no'],
                    'serial_number' => $row['serial_number'],
                ];
            })
            ->all();
    }

    /**
     * @param  array<string, string>  $record
     * @return array<int, array<string, string>>
     */
    private function buildAppliedModifications(array $record): array
    {
        return ModificationCatalog::all()
            ->take(4)
            ->values()
            ->map(function (array $row, int $index) use ($record): array {
                return [
                    'label' => $row['unique_ref'],
                    'meta' => $index === 0
                        ? 'Applied to equipment ' . $record['id']
                        : 'Revision ' . ($row['revision'] !== '' ? $row['revision'] : 'Base'),
                ];
            })
            ->all();
    }

    /**
     * @param  array<string, string>  $record
     * @return array<int, array<string, string>>
     */
    private function buildEventRows(array $record): array
    {
        return [
            ['label' => 'Attach on FL', 'meta' => '11.10.10 · ' . ($record['father_reference'] !== '' ? $record['father_reference'] : 'Standalone equipment')],
            ['label' => 'Status Sync', 'meta' => '15.12.25 · ' . $record['status']],
            ['label' => 'Maintenance Review', 'meta' => '20.02.26 · Operator ' . $record['operator_code']],
        ];
    }

    /**
     * @param  array<string, string>  $record
     * @return array<int, array<string, string>>
     */
    private function buildCounterRows(array $record): array
    {
        $base = (int) $record['id'];

        return [
            ['label' => 'TSN', 'meta' => (string) (1350 + $base) . ':44'],
            ['label' => 'CSN', 'meta' => (string) (20500 + ($base * 3))],
            ['label' => 'E1TCC', 'meta' => number_format(12700 + ($base * 2.75), 2)],
        ];
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
