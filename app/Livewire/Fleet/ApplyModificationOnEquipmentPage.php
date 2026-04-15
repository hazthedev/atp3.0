<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\EquipmentCatalog;
use App\Support\ModificationCatalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class ApplyModificationOnEquipmentPage extends Component
{
    public ?string $equipmentId = null;

    /** @var array<string, string> */
    public array $equipment = [];

    public string $status = 'Applicable';

    public string $action = 'Apply';

    public string $dateForAction = '';

    public string $comment = '';

    /** @var array<int, array<string, string>> */
    public array $selectedModifications = [];

    public bool $equipmentModalOpen = false;

    public string $equipmentSearch = '';

    public ?string $pendingEquipmentId = null;

    public bool $modificationModalOpen = false;

    public string $modificationSearch = '';

    public ?string $pendingModificationId = null;

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(): void
    {
        $this->dateForAction = now()->format('d.m.y');

        $equipmentId = request()->query('equipment_id');
        $record = EquipmentCatalog::find($equipmentId);

        if ($record !== null) {
            $this->equipmentId = $record['id'];
            $this->equipment = $record;
        }
    }

    public function openEquipmentModal(): void
    {
        $this->equipmentModalOpen = true;
        $this->equipmentSearch = '';
        $this->pendingEquipmentId = $this->equipmentId;
    }

    public function closeEquipmentModal(): void
    {
        $this->equipmentModalOpen = false;
        $this->equipmentSearch = '';
        $this->pendingEquipmentId = null;
    }

    public function selectEquipmentResult(string $equipmentId): void
    {
        $this->pendingEquipmentId = $equipmentId;
    }

    public function chooseEquipmentResult(): void
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

        $this->equipmentId = $record['id'];
        $this->equipment = $record;
        $this->closeEquipmentModal();
        $this->setStatus('Loaded equipment ' . $record['id'] . ' into the workspace.', 'blue');
    }

    public function openModificationModal(): void
    {
        $this->modificationModalOpen = true;
        $this->modificationSearch = '';
        $this->pendingModificationId = null;
    }

    public function closeModificationModal(): void
    {
        $this->modificationModalOpen = false;
        $this->modificationSearch = '';
        $this->pendingModificationId = null;
    }

    public function selectModificationResult(string $modificationId): void
    {
        $this->pendingModificationId = $modificationId;
    }

    public function chooseModificationResult(): void
    {
        if ($this->pendingModificationId === null) {
            $this->setStatus('Select a modification row first.', 'amber');

            return;
        }

        $record = ModificationCatalog::find($this->pendingModificationId);

        if ($record === null) {
            $this->setStatus('The selected modification record could not be found.', 'red');

            return;
        }

        $exists = collect($this->selectedModifications)
            ->contains(static fn (array $row): bool => $row['id'] === $record['id']);

        if (! $exists) {
            $this->selectedModifications[] = $record;
            $this->setStatus('Added modification ' . $record['unique_ref'] . ' to the staged list.', 'blue');
        } else {
            $this->setStatus('Modification ' . $record['unique_ref'] . ' is already in the staged list.', 'amber');
        }

        $this->closeModificationModal();
    }

    public function clearModifications(): void
    {
        $this->selectedModifications = [];
        $this->setStatus('Cleared the staged modification list.', 'blue');
    }

    public function initializePreview(): void
    {
        if ($this->equipmentId === null) {
            $this->setStatus('Choose an equipment record before initializing the action.', 'amber');

            return;
        }

        if (count($this->selectedModifications) === 0) {
            $this->setStatus('Add at least one modification before initializing the action.', 'amber');

            return;
        }

        $this->setStatus(
            sprintf(
                'Initialized %s action for equipment %s with %d staged modification%s.',
                strtolower($this->action),
                $this->equipmentId,
                count($this->selectedModifications),
                count($this->selectedModifications) === 1 ? '' : 's',
            ),
            'green',
        );
    }

    public function submitPreview(): void
    {
        if ($this->equipmentId === null) {
            $this->setStatus('Choose an equipment record before completing the workflow.', 'amber');

            return;
        }

        $this->setStatus(
            sprintf(
                'Apply modification preview saved for equipment %s with %d staged modification%s.',
                $this->equipmentId,
                count($this->selectedModifications),
                count($this->selectedModifications) === 1 ? '' : 's',
            ),
            'green',
        );
    }

    public function cancelPreview(): void
    {
        $this->reset([
            'equipmentId',
            'equipment',
            'comment',
            'selectedModifications',
            'equipmentModalOpen',
            'equipmentSearch',
            'pendingEquipmentId',
            'modificationModalOpen',
            'modificationSearch',
            'pendingModificationId',
            'statusMessage',
        ]);

        $this->status = 'Applicable';
        $this->action = 'Apply';
        $this->statusTone = 'blue';
        $this->dateForAction = now()->format('d.m.y');
    }

    public function render()
    {
        return view('livewire.fleet.apply-modification-on-equipment-page', [
            'equipmentSearchResults' => EquipmentCatalog::search($this->equipmentSearch),
            'selectedEquipmentSearchRecord' => $this->pendingEquipmentId !== null
                ? EquipmentCatalog::find($this->pendingEquipmentId)
                : null,
            'modificationSearchResults' => $this->filteredModifications($this->modificationSearch),
            'selectedModificationSearchRecord' => $this->pendingModificationId !== null
                ? ModificationCatalog::find($this->pendingModificationId)
                : null,
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    private function filteredModifications(string $search): Collection
    {
        $needle = mb_strtolower(trim($search));

        if ($needle === '') {
            return ModificationCatalog::all()->values();
        }

        return ModificationCatalog::all()
            ->filter(function (array $row) use ($needle): bool {
                $haystack = implode(' ', [
                    $row['type'],
                    $row['unique_ref'],
                    $row['reference'],
                    $row['revision'],
                    $row['title'],
                ]);

                return mb_stripos($haystack, $needle) !== false;
            })
            ->values();
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
