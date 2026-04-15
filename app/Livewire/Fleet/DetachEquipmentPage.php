<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\FunctionalLocationCatalog;
use Livewire\Component;

class DetachEquipmentPage extends Component
{
    public string $functionalLocationCode = '';

    public bool $recordLoaded = false;

    public string $equipmentCode = '';

    /** @var array<string, mixed> */
    public array $functionalLocation = [];

    /** @var array<int, array<string, string>> */
    public array $installedEquipment = [];

    public ?string $selectedInstalledEquipmentId = null;

    public bool $updateCounters = true;

    public bool $scheduled = false;

    public string $uninstallationDate = '30.03.26';

    public string $uninstallationTime = '09:42';

    public string $comment = '';

    public string $returnReason1 = '';

    public string $returnReason2 = '';

    public string $returnReason3 = '';

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(): void
    {
        $this->hydrateFunctionalLocationWorkspace(false);
    }

    public function updatedFunctionalLocationCode(): void
    {
        $this->hydrateFunctionalLocationWorkspace(true);
    }

    public function loadFunctionalLocation(): void
    {
        $this->hydrateFunctionalLocationWorkspace(true);
    }

    public function selectInstalledEquipment(string $equipmentId): void
    {
        $this->selectedInstalledEquipmentId = $equipmentId;
        $this->equipmentCode = $equipmentId;
    }

    public function searchViaEquipment(): void
    {
        $equipmentCode = trim($this->equipmentCode);

        if ($equipmentCode === '') {
            $this->setStatus('Enter an equipment code before searching.', 'amber');

            return;
        }

        foreach (FunctionalLocationCatalog::all() as $record) {
            $equipmentRows = $this->seedInstalledEquipment($record);

            foreach ($equipmentRows as $row) {
                if ($row['equipment_id'] !== $equipmentCode) {
                    continue;
                }

                $this->recordLoaded = true;
                $this->functionalLocation = $record;
                $this->functionalLocationCode = $record['code'];
                $this->installedEquipment = $equipmentRows;
                $this->selectedInstalledEquipmentId = $row['equipment_id'];

                $this->setStatus(sprintf('Loaded %s via equipment code %s.', $record['code'], $equipmentCode), 'blue');

                return;
            }
        }

        $this->setStatus('No functional location matched that equipment code.', 'amber');
    }

    public function detachSelected(): void
    {
        if ($this->selectedInstalledEquipmentId === null) {
            $this->setStatus('Select an installed equipment row before detaching.', 'amber');

            return;
        }

        foreach ($this->installedEquipment as $index => $row) {
            if ($row['equipment_id'] !== $this->selectedInstalledEquipmentId) {
                continue;
            }

            $removedEquipment = $row;
            unset($this->installedEquipment[$index]);
            $this->installedEquipment = array_values($this->installedEquipment);
            $this->selectedInstalledEquipmentId = $this->installedEquipment[0]['equipment_id'] ?? null;

            $this->setStatus(
                sprintf('Detached %s from functional location %s.', $removedEquipment['designation'], $this->functionalLocation['code'] ?: 'workspace'),
                'green',
            );

            return;
        }

        $this->setStatus('The selected equipment is no longer available in the detachment list.', 'red');
    }

    public function confirmPreview(): void
    {
        $this->setStatus(
            sprintf('Detachment preview confirmed for %s.', $this->functionalLocation['code'] ?: 'selected workspace'),
            'green',
        );
    }

    public function render()
    {
        return view('livewire.fleet.detach-equipment-page');
    }

    private function hydrateFunctionalLocationWorkspace(bool $announce): void
    {
        $code = strtoupper(trim($this->functionalLocationCode));
        $record = FunctionalLocationCatalog::all()->firstWhere('code', $code);

        if ($record === null) {
            $this->recordLoaded = false;
            $this->functionalLocation = $this->blankFunctionalLocation($code);
            $this->installedEquipment = [];
            $this->selectedInstalledEquipmentId = null;
            $this->equipmentCode = '';

            if ($announce) {
                $this->setStatus('No functional location matched that code. Try 9M-WAA, 9M-WAB, or 9M-WAV.', 'amber');
            }

            return;
        }

        $this->recordLoaded = true;
        $this->functionalLocation = $record;
        $this->functionalLocationCode = $record['code'];
        $this->installedEquipment = $this->seedInstalledEquipment($record);
        $this->selectedInstalledEquipmentId = $this->installedEquipment[0]['equipment_id'] ?? null;
        $this->equipmentCode = $this->selectedInstalledEquipmentId ?? '';

        if ($announce) {
            $this->setStatus(sprintf('Loaded functional location %s.', $record['code']), 'blue');
        }
    }

    /**
     * @param  array<string, mixed>  $record
     * @return array<int, array<string, string>>
     */
    private function seedInstalledEquipment(array $record): array
    {
        return [
            [
                'equipment_id' => '47899',
                'designation' => 'Airframe',
                'item_code' => $record['type'],
                'serial_number' => $record['serial_no'],
                'install_date' => '18.03.26',
            ],
            [
                'equipment_id' => '6108',
                'designation' => 'Engine 1',
                'item_code' => 'ENG-01',
                'serial_number' => 'PCE-6108',
                'install_date' => '09.01.26',
            ],
            [
                'equipment_id' => '6112',
                'designation' => 'Engine 2',
                'item_code' => 'ENG-02',
                'serial_number' => 'PCE-6112',
                'install_date' => '09.01.26',
            ],
            [
                'equipment_id' => '7310',
                'designation' => 'Main Gearbox',
                'item_code' => 'MGB-01',
                'serial_number' => 'MGB-7310',
                'install_date' => '12.02.26',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    private function blankFunctionalLocation(string $code = ''): array
    {
        return [
            'id' => '',
            'code' => $code,
            'serial_no' => '',
            'registration' => '',
            'type' => '',
        ];
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
