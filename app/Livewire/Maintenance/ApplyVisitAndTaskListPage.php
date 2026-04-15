<?php

declare(strict_types=1);

namespace App\Livewire\Maintenance;

use App\Support\EquipmentCatalog;
use App\Support\FunctionalLocationCatalog;
use App\Support\MaintenanceProgramCatalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class ApplyVisitAndTaskListPage extends Component
{
    public string $initialTab = 'visit';

    public string $scope = 'equipment';

    public string $activeTab = 'visit';

    public ?string $selectedId = null;

    /** @var array<string, mixed> */
    public array $selectedRecord = [];

    public string $maintenancePlan = '';

    public string $operational = '';

    public string $mode = '';

    public string $applicationDate = '';

    public bool $lookupModalOpen = false;

    public string $search = '';

    public ?string $pendingSelectionId = null;

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(string $initialTab = 'visit'): void
    {
        $this->initialTab = in_array($initialTab, ['visit', 'task-list'], true) ? $initialTab : 'visit';
        $this->activeTab = $this->initialTab;
        $this->applicationDate = now()->format('d.m.y');
    }

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
        $this->maintenancePlan = (string) (MaintenanceProgramCatalog::all()->first()['name'] ?? '');
        $this->operational = 'Operational';
        $this->mode = '';
        $this->closeLookupModal();

        $reference = $this->scope === 'functional-location'
            ? ($record['code'] ?? $record['id'])
            : ($record['equipment_no'] ?? $record['id']);

        $this->setStatus('Loaded ' . $reference . ' into Apply Visits and Task Lists.', 'blue');
    }

    public function getCurrentValues(): void
    {
        if ($this->selectedId === null) {
            $this->setStatus('Choose an equipment or functional location first.', 'amber');

            return;
        }

        $this->setStatus('Current counter values refreshed for the selected object.', 'green');
    }

    public function applyAll(): void
    {
        $this->setStatus(($this->activeTab === 'visit' ? 'Visit' : 'Task list') . ' preview items marked for apply-all.', 'blue');
    }

    public function addVisit(): void
    {
        $this->setStatus('Visit add preview opened.', 'blue');
    }

    public function addTaskList(): void
    {
        $this->setStatus('Task-list add preview opened.', 'blue');
    }

    public function submitApply(): void
    {
        $this->setStatus('Apply preview submitted for review.', 'green');
    }

    public function cancelPreview(): void
    {
        $this->resetSelection();
        $this->lookupModalOpen = false;
        $this->search = '';
        $this->pendingSelectionId = null;
        $this->statusMessage = null;
        $this->statusTone = 'blue';
        $this->activeTab = $this->initialTab;
        $this->applicationDate = now()->format('d.m.y');
    }

    public function render()
    {
        return view('livewire.maintenance.apply-visit-and-task-list-page', [
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
        $this->maintenancePlan = '';
        $this->operational = '';
        $this->mode = '';
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
