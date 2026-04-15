<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\EquipmentCatalog;
use Livewire\Component;

class EquipmentReferenceEvolutionPage extends Component
{
    public int $step = 1;

    public ?string $equipmentId = null;

    /** @var array<string, string> */
    public array $equipment = [];

    public bool $searchModalOpen = false;

    public string $search = '';

    public ?string $pendingSelectionId = null;

    public bool $newItemNumber = true;

    public string $enteredItemNumber = '';

    public bool $newSerialNumber = false;

    public string $enteredSerialNumber = '';

    public string $date = '';

    public string $comment = '';

    /** @var array<string, string> */
    public array $currentAta = [];

    /** @var array<string, string> */
    public array $newAta = [];

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(): void
    {
        $this->date = now()->format('d.m.y');
        $this->currentAta = [
            'chapter' => 'AC',
            'section' => '00',
            'subject' => '00',
            'sheet' => '000',
            'mark' => '00',
        ];
        $this->newAta = [
            'chapter' => 'AC',
            'section' => '00',
            'subject' => '00',
            'sheet' => '000',
            'mark' => '00',
        ];

        $equipmentId = request()->query('equipment_id');
        $record = EquipmentCatalog::find($equipmentId);

        if ($record !== null) {
            $this->equipmentId = $record['id'];
            $this->equipment = $record;
        }
    }

    public function openSearchModal(): void
    {
        $this->searchModalOpen = true;
        $this->search = '';
        $this->pendingSelectionId = $this->equipmentId;
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

        $this->equipmentId = $record['id'];
        $this->equipment = $record;
        $this->closeSearchModal();
        $this->setStatus('Loaded equipment ' . $record['id'] . ' into the workspace.', 'blue');
    }

    public function nextStep(): void
    {
        if ($this->equipmentId === null) {
            $this->setStatus('Choose the equipment before continuing.', 'amber');

            return;
        }

        $this->step = 2;
    }

    public function previousStep(): void
    {
        $this->step = 1;
    }

    public function finishPreview(): void
    {
        if ($this->equipmentId === null) {
            $this->setStatus('Choose the equipment before finishing the workflow.', 'amber');

            return;
        }

        $this->setStatus(
            'Equipment reference evolution preview prepared for equipment ' . $this->equipmentId . '.',
            'green',
        );
    }

    public function render()
    {
        return view('livewire.fleet.equipment-reference-evolution-page', [
            'searchResults' => EquipmentCatalog::search($this->search),
            'selectedSearchRecord' => $this->pendingSelectionId !== null ? EquipmentCatalog::find($this->pendingSelectionId) : null,
        ]);
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
