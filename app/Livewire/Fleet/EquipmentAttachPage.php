<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\EquipmentCatalog;
use Livewire\Component;

class EquipmentAttachPage extends Component
{
    public int $step = 1;

    public ?string $equipmentToAttachId = null;

    /** @var array<string, string> */
    public array $equipmentToAttach = [];

    public ?string $fatherEquipmentId = null;

    /** @var array<string, string> */
    public array $fatherEquipment = [];

    public bool $searchModalOpen = false;

    public string $searchTarget = 'attach';

    public string $search = '';

    public ?string $pendingSelectionId = null;

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function openSearchModal(string $target): void
    {
        $this->searchTarget = $target;
        $this->searchModalOpen = true;
        $this->search = '';
        $this->pendingSelectionId = $target === 'attach'
            ? $this->equipmentToAttachId
            : $this->fatherEquipmentId;
    }

    public function closeSearchModal(): void
    {
        $this->searchModalOpen = false;
        $this->search = '';
        $this->pendingSelectionId = null;
    }

    public function selectSearchResult(string $equipmentId): void
    {
        $this->pendingSelectionId = $equipmentId;
    }

    public function chooseSearchResult(): void
    {
        if ($this->pendingSelectionId === null) {
            $this->setStatus('Select an equipment row first.', 'amber');

            return;
        }

        $record = EquipmentCatalog::find($this->pendingSelectionId);

        if ($record === null) {
            $this->setStatus('The selected equipment record could not be found.', 'red');

            return;
        }

        if ($this->searchTarget === 'attach') {
            $this->equipmentToAttachId = $record['id'];
            $this->equipmentToAttach = $record;

            if ($this->fatherEquipmentId === $this->equipmentToAttachId) {
                $this->fatherEquipmentId = null;
                $this->fatherEquipment = [];
            }

            $this->setStatus('Selected equipment ' . $record['id'] . ' to attach.', 'blue');
        } else {
            $this->fatherEquipmentId = $record['id'];
            $this->fatherEquipment = $record;
            $this->setStatus('Selected father equipment ' . $record['id'] . '.', 'blue');
        }

        $this->closeSearchModal();
    }

    public function nextStep(): void
    {
        if ($this->equipmentToAttachId === null) {
            $this->setStatus('Choose the equipment to attach before continuing.', 'amber');

            return;
        }

        $this->step = 2;
    }

    public function previousStep(): void
    {
        $this->step = 1;
    }

    public function attachPreview(): void
    {
        if ($this->equipmentToAttachId === null || $this->fatherEquipmentId === null) {
            $this->setStatus('Choose both the equipment to attach and the father equipment before attaching.', 'amber');

            return;
        }

        $this->setStatus(
            sprintf('Attach preview ready: equipment %s under father equipment %s.', $this->equipmentToAttachId, $this->fatherEquipmentId),
            'green',
        );
    }

    public function render()
    {
        $searchResults = EquipmentCatalog::search($this->search)
            ->when(
                $this->searchTarget === 'father' && $this->equipmentToAttachId !== null,
                static fn ($rows) => $rows->reject(fn (array $row): bool => $row['id'] === $this->equipmentToAttachId)->values(),
            );

        return view('livewire.fleet.equipment-attach-page', [
            'searchResults' => $searchResults,
            'selectedSearchRecord' => $this->pendingSelectionId !== null ? EquipmentCatalog::find($this->pendingSelectionId) : null,
        ]);
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
