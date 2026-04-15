<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\EquipmentCatalog;
use Livewire\Component;

class ChangeEquipmentCustomerInformationPage extends Component
{
    public string $equipmentId = '';

    public bool $recordLoaded = false;

    public string $serialNo = '';

    public string $itemNo = '';

    public string $itemDescription = '';

    public string $variant = '';

    public string $categoryPart = '';

    public string $ownerCode = '';

    public string $ownerName = '';

    public string $operatorCode = '';

    public string $operatorName = '';

    public bool $forceOwnerPropagation = true;

    public string $dateOfChange = '30.03.26';

    public string $comment = '';

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(): void
    {
        $requestedEquipment = trim((string) request()->query('equipment_id', ''));

        if ($requestedEquipment !== '') {
            $this->equipmentId = $requestedEquipment;
            $this->hydrateEquipment(false);
        }
    }

    public function loadEquipment(): void
    {
        $this->hydrateEquipment(true);
    }

    public function confirmPreview(): void
    {
        $id = trim($this->equipmentId) !== '' ? $this->equipmentId : 'selected equipment';

        $this->setStatus(sprintf('Customer information preview confirmed for equipment %s.', $id), 'green');
    }

    public function render()
    {
        return view('livewire.fleet.change-equipment-customer-information-page');
    }

    private function hydrateEquipment(bool $announce): void
    {
        $id = trim($this->equipmentId);
        $record = EquipmentCatalog::find($id);

        if ($record === null) {
            $this->recordLoaded = false;
            $this->serialNo = '';
            $this->itemNo = '';
            $this->itemDescription = '';
            $this->variant = '';
            $this->categoryPart = '';
            $this->ownerCode = '';
            $this->ownerName = '';
            $this->operatorCode = '';
            $this->operatorName = '';

            if ($announce) {
                $this->setStatus('No equipment matched that ID. Try 1, 4, or 15.', 'amber');
            }

            return;
        }

        $this->recordLoaded = true;
        $this->equipmentId = $record['id'];
        $this->serialNo = $record['serial_number'];
        $this->itemNo = $record['item_no'];
        $this->itemDescription = $record['item_description'];
        $this->variant = $record['variant'];
        $this->categoryPart = $record['category_part'];
        $this->ownerCode = $record['owner_code'];
        $this->ownerName = $record['owner_name'];
        $this->operatorCode = $record['operator_code'];
        $this->operatorName = $record['operator_name_display'];

        if ($announce) {
            $this->setStatus(sprintf('Loaded customer information for equipment %s.', $record['id']), 'blue');
        }
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
