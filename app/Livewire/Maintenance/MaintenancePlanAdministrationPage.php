<?php

declare(strict_types=1);

namespace App\Livewire\Maintenance;

use App\Support\EquipmentCatalog;
use App\Support\FunctionalLocationCatalog;
use App\Support\MaintenanceProgramCatalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class MaintenancePlanAdministrationPage extends Component
{
    public string $scope = 'equipment';

    public ?string $selectedId = null;

    /** @var array<string, mixed> */
    public array $selectedRecord = [];

    public string $maintenanceProgram = '';

    public bool $lookupModalOpen = false;

    public string $search = '';

    public ?string $pendingSelectionId = null;

    public string $visitActive = '';

    public string $visitStatus = '';

    public string $visitInitialized = '';

    public string $taskActive = '';

    public string $taskStatus = '';

    public string $taskInitialized = '';

    public string $taskListRef = '';

    public string $taskKeyword = '';

    public string $taskSubEquipment = '';

    public string $taskEffectivity = '';

    public string $taskChapter = '';

    public string $taskSection = '';

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function updatedScope(): void
    {
        $this->resetSelection();
    }

    public function openLookupModal(): void
    {
        $this->lookupModalOpen = true;
        $this->search = '';
        $this->pendingSelectionId = $this->selectedId;
    }

    public function closeLookupModal(): void
    {
        $this->lookupModalOpen = false;
        $this->search = '';
        $this->pendingSelectionId = null;
    }

    public function selectLookupRow(string $id): void
    {
        $this->pendingSelectionId = $id;
    }

    public function chooseLookupRow(): void
    {
        if ($this->pendingSelectionId === null) {
            $this->setStatus('Select a row first.', 'amber');

            return;
        }

        $record = $this->currentResults()->firstWhere('id', $this->scope === 'functional-location' ? (int) $this->pendingSelectionId : $this->pendingSelectionId);

        if ($record === null) {
            $this->setStatus('The selected record could not be found.', 'red');

            return;
        }

        $this->selectedId = (string) ($record['id'] ?? '');
        $this->selectedRecord = $record;
        $this->maintenanceProgram = (string) (MaintenanceProgramCatalog::all()->first()['name'] ?? '');
        $this->closeLookupModal();

        $reference = $this->scope === 'equipment'
            ? ($record['equipment_no'] ?? $record['id'])
            : ($record['code'] ?? $record['id']);

        $this->setStatus('Loaded ' . $reference . ' into Maintenance Plan Administration.', 'blue');
    }

    public function checkOperationalStatus(): void
    {
        if ($this->selectedId === null) {
            $this->setStatus('Choose an equipment or functional location first.', 'amber');

            return;
        }

        $this->setStatus('Operational status preview refreshed for the selected object.', 'green');
    }

    public function refreshVisits(): void
    {
        $this->setStatus('Visit search filters refreshed.', 'blue');
    }

    public function refreshTaskLists(): void
    {
        $this->setStatus('Task list search filters refreshed.', 'blue');
    }

    public function updateVisitPreview(): void
    {
        $this->setStatus('Visit update preview opened for the selected context.', 'blue');
    }

    public function updateTaskListPreview(): void
    {
        $this->setStatus('Task list update preview opened for the selected context.', 'blue');
    }

    public function cancelPreview(): void
    {
        $this->resetSelection();
        $this->reset([
            'lookupModalOpen',
            'search',
            'pendingSelectionId',
            'visitActive',
            'visitStatus',
            'visitInitialized',
            'taskActive',
            'taskStatus',
            'taskInitialized',
            'taskListRef',
            'taskKeyword',
            'taskSubEquipment',
            'taskEffectivity',
            'taskChapter',
            'taskSection',
            'statusMessage',
        ]);

        $this->statusTone = 'blue';
    }

    public function render()
    {
        return view('livewire.maintenance.maintenance-plan-administration-page', [
            'lookupRows' => $this->currentResults(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function currentResults(): Collection
    {
        return $this->scope === 'functional-location'
            ? FunctionalLocationCatalog::search($this->search)
            : EquipmentCatalog::search($this->search);
    }

    private function resetSelection(): void
    {
        $this->selectedId = null;
        $this->selectedRecord = [];
        $this->maintenanceProgram = '';
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
