<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\EquipmentCatalog;
use Livewire\Component;

class EquipmentDetachPage extends Component
{
    public ?string $equipmentId = null;

    /** @var array<string, string> */
    public array $equipmentToDetach = [];

    /** @var array<string, string> */
    public array $fatherEquipment = [];

    public bool $searchModalOpen = false;

    public string $search = '';

    public ?string $pendingSelectionId = null;

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

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
        $this->equipmentToDetach = $record;
        $this->fatherEquipment = $this->resolveFatherEquipment($record);

        $this->setStatus('Selected equipment ' . $record['id'] . ' for detach preview.', 'blue');
        $this->closeSearchModal();
    }

    public function detachPreview(): void
    {
        if ($this->equipmentId === null) {
            $this->setStatus('Choose the equipment to detach first.', 'amber');

            return;
        }

        $fatherCode = $this->fatherEquipment['equipment_no'] ?? '';

        $this->setStatus(
            $fatherCode !== ''
                ? sprintf('Detach preview ready: equipment %s from father equipment %s.', $this->equipmentId, $fatherCode)
                : sprintf('Detach preview ready: equipment %s with no father equipment resolved.', $this->equipmentId),
            'green',
        );
    }

    public function render()
    {
        return view('livewire.fleet.equipment-detach-page', [
            'searchResults' => EquipmentCatalog::search($this->search),
            'selectedSearchRecord' => $this->pendingSelectionId !== null ? EquipmentCatalog::find($this->pendingSelectionId) : null,
        ]);
    }

    /**
     * @param  array<string, string>  $equipment
     * @return array<string, string>
     */
    private function resolveFatherEquipment(array $equipment): array
    {
        if (($equipment['id'] ?? '') === '1') {
            return [];
        }

        return EquipmentCatalog::find('1') ?? [];
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
