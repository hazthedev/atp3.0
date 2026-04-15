<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\FunctionalLocationCatalog;
use Livewire\Component;

class AttachEquipmentPage extends Component
{
    public string $functionalLocationCode = '';

    public bool $recordLoaded = false;

    /** @var array<string, mixed> */
    public array $functionalLocation = [];

    /** @var array<int, array<string, string>> */
    public array $installedEquipment = [];

    /** @var array<int, array<string, string>> */
    public array $availableEquipment = [];

    public ?string $selectedInstalledEquipmentId = null;

    public ?string $selectedAvailableEquipmentId = null;

    public string $uninstallationDate = '30.03.26';

    public string $uninstallationTime = '09:22';

    public bool $uninstallationScheduled = false;

    public string $detachComment = '';

    public bool $updateCountersOnFunctionalLocation = true;

    public string $returnReason1 = '';

    public string $returnReason2 = '';

    public string $returnReason3 = '';

    public string $installationDate = '30.03.26';

    public string $installationTime = '09:22';

    public string $attachComment = '';

    public bool $updateCountersOnEquipment = true;

    public bool $updateMaintenancePlan = false;

    public bool $synchronizeCounters = true;

    public bool $inheritsOwner = true;

    public bool $inheritsMaintCenter = true;

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
    }

    public function selectAvailableEquipment(string $equipmentId): void
    {
        $this->selectedAvailableEquipmentId = $equipmentId;
    }

    public function attachSelected(): void
    {
        if ($this->selectedAvailableEquipmentId === null) {
            $this->setStatus('Select an equipment row from the right pane before attaching.', 'amber');

            return;
        }

        $availableIndex = $this->findEquipmentIndex($this->availableEquipment, $this->selectedAvailableEquipmentId);

        if ($availableIndex === null) {
            $this->setStatus('The selected equipment could not be found in the available list.', 'red');

            return;
        }

        $equipment = $this->availableEquipment[$availableIndex];
        unset($this->availableEquipment[$availableIndex]);
        $this->availableEquipment = array_values($this->availableEquipment);

        $equipment['install_date'] = $this->installationDate;
        $this->installedEquipment[] = $equipment;

        $this->selectedInstalledEquipmentId = $equipment['equipment_id'];
        $this->selectedAvailableEquipmentId = $this->availableEquipment[0]['equipment_id'] ?? null;

        $this->setStatus(
            sprintf('Attached %s to functional location %s.', $equipment['designation'], $this->functionalLocation['code'] ?: 'workspace'),
            'green',
        );
    }

    public function detachSelected(): void
    {
        if ($this->selectedInstalledEquipmentId === null) {
            $this->setStatus('Select an installed equipment row from the left pane before detaching.', 'amber');

            return;
        }

        $installedIndex = $this->findEquipmentIndex($this->installedEquipment, $this->selectedInstalledEquipmentId);

        if ($installedIndex === null) {
            $this->setStatus('The selected installed equipment could not be found.', 'red');

            return;
        }

        $equipment = $this->installedEquipment[$installedIndex];
        unset($this->installedEquipment[$installedIndex]);
        $this->installedEquipment = array_values($this->installedEquipment);

        $equipment['install_date'] = '';
        $this->availableEquipment[] = $equipment;

        $this->selectedInstalledEquipmentId = $this->installedEquipment[0]['equipment_id'] ?? null;
        $this->selectedAvailableEquipmentId = $equipment['equipment_id'];

        $this->setStatus(
            sprintf('Detached %s from functional location %s.', $equipment['designation'], $this->functionalLocation['code'] ?: 'workspace'),
            'blue',
        );
    }

    public function swapSelected(): void
    {
        if ($this->selectedInstalledEquipmentId === null || $this->selectedAvailableEquipmentId === null) {
            $this->setStatus('Select one row on each side to perform a swap.', 'amber');

            return;
        }

        $installedIndex = $this->findEquipmentIndex($this->installedEquipment, $this->selectedInstalledEquipmentId);
        $availableIndex = $this->findEquipmentIndex($this->availableEquipment, $this->selectedAvailableEquipmentId);

        if ($installedIndex === null || $availableIndex === null) {
            $this->setStatus('The selected rows are no longer available to swap.', 'red');

            return;
        }

        $installedEquipment = $this->installedEquipment[$installedIndex];
        $availableEquipment = $this->availableEquipment[$availableIndex];

        $installedEquipment['install_date'] = '';
        $availableEquipment['install_date'] = $this->installationDate;

        $this->installedEquipment[$installedIndex] = $availableEquipment;
        $this->availableEquipment[$availableIndex] = $installedEquipment;

        $this->selectedInstalledEquipmentId = $availableEquipment['equipment_id'];
        $this->selectedAvailableEquipmentId = $installedEquipment['equipment_id'];

        $this->setStatus(
            sprintf('Swapped %s with %s.', $installedEquipment['designation'], $availableEquipment['designation']),
            'green',
        );
    }

    public function render()
    {
        return view('livewire.fleet.attach-equipment-page', [
            'selectedInstalledEquipment' => $this->findEquipment($this->installedEquipment, $this->selectedInstalledEquipmentId),
            'selectedAvailableEquipment' => $this->findEquipment($this->availableEquipment, $this->selectedAvailableEquipmentId),
        ]);
    }

    public function confirmPreview(): void
    {
        $selectedCode = $this->functionalLocation['code'] ?: 'selected workspace';
        $this->setStatus(sprintf('Preview confirmed for %s.', $selectedCode), 'green');
    }

    private function hydrateFunctionalLocationWorkspace(bool $announce): void
    {
        $code = strtoupper(trim($this->functionalLocationCode));
        $record = FunctionalLocationCatalog::all()->firstWhere('code', $code);

        if ($record === null) {
            $this->recordLoaded = false;
            $this->functionalLocation = $this->blankFunctionalLocation($code);
            $this->installedEquipment = [];
            $this->availableEquipment = $this->seedAvailableEquipment();
            $this->selectedInstalledEquipmentId = null;
            $this->selectedAvailableEquipmentId = $this->availableEquipment[0]['equipment_id'] ?? null;

            if ($announce) {
                $this->setStatus('No functional location matched that code. Try 9M-WAA, 9M-WAB, or 9M-WAV.', 'amber');
            }

            return;
        }

        $this->recordLoaded = true;
        $this->functionalLocationCode = $record['code'];
        $this->functionalLocation = $record;
        $this->installedEquipment = $this->seedInstalledEquipment($record);
        $this->availableEquipment = $this->seedAvailableEquipment();
        $this->selectedInstalledEquipmentId = $this->installedEquipment[0]['equipment_id'] ?? null;
        $this->selectedAvailableEquipmentId = $this->availableEquipment[0]['equipment_id'] ?? null;

        if ($announce) {
            $this->setStatus(sprintf('Loaded equipment tree for %s.', $record['code']), 'blue');
        }
    }

    /**
     * @param  array<int, array<string, string>>  $items
     */
    private function findEquipment(array $items, ?string $equipmentId): ?array
    {
        if ($equipmentId === null) {
            return null;
        }

        foreach ($items as $item) {
            if ($item['equipment_id'] === $equipmentId) {
                return $item;
            }
        }

        return null;
    }

    /**
     * @param  array<int, array<string, string>>  $items
     */
    private function findEquipmentIndex(array $items, string $equipmentId): ?int
    {
        foreach ($items as $index => $item) {
            if ($item['equipment_id'] === $equipmentId) {
                return $index;
            }
        }

        return null;
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
                'part_number' => 'AW139-FL-' . $record['serial_no'],
                'serial_no' => $record['serial_no'],
                'install_date' => '18.03.26',
                'item_no' => $record['type'],
                'category_part' => 'Airframe',
                'variant' => $record['type'],
            ],
            [
                'equipment_id' => '6108',
                'designation' => 'Engine 1',
                'part_number' => 'PT6C-67C',
                'serial_no' => 'PCE-6108',
                'install_date' => '09.01.26',
                'item_no' => 'ENG-01',
                'category_part' => 'Engine',
                'variant' => 'Baseline',
            ],
            [
                'equipment_id' => '6112',
                'designation' => 'Engine 2',
                'part_number' => 'PT6C-67C',
                'serial_no' => 'PCE-6112',
                'install_date' => '09.01.26',
                'item_no' => 'ENG-02',
                'category_part' => 'Engine',
                'variant' => 'Baseline',
            ],
        ];
    }

    /**
     * @return array<int, array<string, string>>
     */
    private function seedAvailableEquipment(): array
    {
        return [
            [
                'equipment_id' => '80514',
                'designation' => 'Hoist Assembly',
                'part_number' => 'AW139-HOIST-01',
                'serial_no' => 'HST-80514',
                'install_date' => '',
                'item_no' => 'HOIST-01',
                'category_part' => 'Mission Kit',
                'variant' => 'SAR',
            ],
            [
                'equipment_id' => '80331',
                'designation' => 'Medical Interior Kit',
                'part_number' => 'AW139-MED-08',
                'serial_no' => 'MED-80331',
                'install_date' => '',
                'item_no' => 'MED-08',
                'category_part' => 'Cabin Kit',
                'variant' => 'EMS',
            ],
            [
                'equipment_id' => '80477',
                'designation' => 'Rescue Basket Mount',
                'part_number' => 'AW139-RBM-02',
                'serial_no' => 'RBM-80477',
                'install_date' => '',
                'item_no' => 'RBM-02',
                'category_part' => 'Mission Kit',
                'variant' => 'Utility',
            ],
            [
                'equipment_id' => '80912',
                'designation' => 'Additional Cabin Console',
                'part_number' => 'AW139-ACC-11',
                'serial_no' => 'ACC-80912',
                'install_date' => '',
                'item_no' => 'ACC-11',
                'category_part' => 'Cabin Kit',
                'variant' => 'VIP',
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
            'mel' => '',
            'equipment_reference' => '',
            'owner_name' => '',
        ];
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
