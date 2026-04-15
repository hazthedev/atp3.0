<?php

declare(strict_types=1);

namespace App\Livewire\Maintenance;

use App\Support\WorkPackageCatalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class WorkPackagePage extends Component
{
    public ?string $selectedId = null;

    /** @var array<string, mixed> */
    public array $selectedRecord = [];

    /** @var array<int, array<string, mixed>> */
    public array $linkedEquipment = [];

    public string $days = '';

    public string $orDate = '';

    public string $hoursIncrement = '';

    public string $cyclesIncrement = '0.0000';

    public bool $calculateFromUtilizationModel = false;

    public bool $lookupModalOpen = false;

    public string $search = '';

    public ?string $pendingSelectionId = null;

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

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
            $this->setStatus('Select a work package row first.', 'amber');

            return;
        }

        $record = WorkPackageCatalog::find($this->pendingSelectionId);

        if ($record === null) {
            $this->setStatus('The selected work package could not be found.', 'red');

            return;
        }

        $this->selectedId = (string) $record['id'];
        $this->selectedRecord = $record;
        $this->linkedEquipment = $record['linked_equipment'] ?? [];
        $this->days = (string) ($record['days'] ?? '');
        $this->orDate = (string) ($record['or_date'] ?? '');
        $this->hoursIncrement = (string) ($record['hours_increment'] ?? '');
        $this->cyclesIncrement = (string) ($record['cycles_increment'] ?? '0.0000');
        $this->calculateFromUtilizationModel = (bool) ($record['calculate_from_utilization_model'] ?? false);
        $this->closeLookupModal();

        $this->setStatus('Loaded work package ' . $record['code'] . '.', 'blue');
    }

    public function clearSimulationList(): void
    {
        $this->linkedEquipment = [];
        $this->setStatus('Linked equipment list cleared.', 'amber');
    }

    public function searchAddVisitTaskList(): void
    {
        $this->setStatus('Search/Add Visit/Task List preview opened.', 'blue');
    }

    public function selectAllVisit(): void
    {
        $this->setStatus('All visit rows selected in preview.', 'blue');
    }

    public function unselectAllVisit(): void
    {
        $this->setStatus('Visit row selection cleared.', 'amber');
    }

    public function selectRemainingVisit(): void
    {
        $this->setStatus('Remaining visit rows selected in preview.', 'blue');
    }

    public function clearVisitList(): void
    {
        $this->setStatus('Visit list cleared in preview.', 'amber');
    }

    public function selectAllTaskList(): void
    {
        $this->setStatus('All task-list rows selected in preview.', 'blue');
    }

    public function unselectAllTaskList(): void
    {
        $this->setStatus('Task-list row selection cleared.', 'amber');
    }

    public function selectRemainingTaskList(): void
    {
        $this->setStatus('Remaining task-list rows selected in preview.', 'blue');
    }

    public function clearTaskList(): void
    {
        $this->setStatus('Task-list preview cleared.', 'amber');
    }

    public function selectAllPostponedOperations(): void
    {
        $this->setStatus('All postponed operations selected in preview.', 'blue');
    }

    public function unselectAllPostponedOperations(): void
    {
        $this->setStatus('Postponed operations selection cleared.', 'amber');
    }

    public function clearPostponedOperations(): void
    {
        $this->setStatus('Postponed operations preview cleared.', 'amber');
    }

    public function selectAllDeferredDefects(): void
    {
        $this->setStatus('All deferred defects selected in preview.', 'blue');
    }

    public function unselectAllDeferredDefects(): void
    {
        $this->setStatus('Deferred defects selection cleared.', 'amber');
    }

    public function clearDeferredDefects(): void
    {
        $this->setStatus('Deferred defects preview cleared.', 'amber');
    }

    public function cancelPreview(): void
    {
        $this->selectedId = null;
        $this->selectedRecord = [];
        $this->linkedEquipment = [];
        $this->days = '';
        $this->orDate = '';
        $this->hoursIncrement = '';
        $this->cyclesIncrement = '0.0000';
        $this->calculateFromUtilizationModel = false;
        $this->lookupModalOpen = false;
        $this->search = '';
        $this->pendingSelectionId = null;
        $this->statusMessage = null;
        $this->statusTone = 'blue';
    }

    public function render()
    {
        return view('livewire.maintenance.work-package-page', [
            'lookupRows' => $this->lookupRows(),
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, mixed>>
     */
    private function lookupRows(): Collection
    {
        return WorkPackageCatalog::search($this->search);
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
