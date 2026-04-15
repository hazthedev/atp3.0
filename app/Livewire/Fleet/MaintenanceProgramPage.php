<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\MaintenanceProgramCatalog;
use Livewire\Component;

class MaintenanceProgramPage extends Component
{
    public ?string $programId = null;

    /** @var array<string, mixed> */
    public array $program = [];

    public bool $lookupModalOpen = false;

    public string $search = '';

    public ?string $pendingProgramId = null;

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function openLookupModal(): void
    {
        $this->lookupModalOpen = true;
        $this->search = '';
        $this->pendingProgramId = $this->programId;
    }

    public function closeLookupModal(): void
    {
        $this->lookupModalOpen = false;
        $this->search = '';
        $this->pendingProgramId = null;
    }

    public function selectLookupRow(string $programId): void
    {
        $this->pendingProgramId = $programId;
    }

    public function chooseLookupRow(): void
    {
        if ($this->pendingProgramId === null) {
            $this->setStatus('Select a maintenance program row first.', 'amber');

            return;
        }

        $record = MaintenanceProgramCatalog::find($this->pendingProgramId);

        if ($record === null) {
            $this->setStatus('The selected maintenance program could not be found.', 'red');

            return;
        }

        $this->programId = $record['id'];
        $this->program = $record;
        $this->closeLookupModal();
        $this->setStatus('Loaded maintenance program ' . $record['code'] . '.', 'blue');
    }

    public function cancelPreview(): void
    {
        $this->reset([
            'programId',
            'program',
            'lookupModalOpen',
            'search',
            'pendingProgramId',
            'statusMessage',
        ]);

        $this->statusTone = 'blue';
    }

    public function render()
    {
        return view('livewire.fleet.maintenance-program-page', [
            'lookupRows' => MaintenanceProgramCatalog::search($this->search),
        ]);
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
