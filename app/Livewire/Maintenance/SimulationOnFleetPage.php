<?php

declare(strict_types=1);

namespace App\Livewire\Maintenance;

use App\Support\EquipmentCatalog;
use App\Support\FunctionalLocationCatalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class SimulationOnFleetPage extends Component
{
    public string $days = '';

    public string $date = '';

    /** @var array<int, array<string, mixed>> */
    public array $functionalLocations = [];

    /** @var array<int, array<string, mixed>> */
    public array $equipments = [];

    public bool $includeSubEquipmentWithMaintenancePlan = false;

    public bool $includeTaskList = false;

    public bool $includeCountersWithPotential = false;

    public string $groupBy = 'none';

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(): void
    {
        $this->date = now()->format('d.m.y');
    }

    public function loadFunctionalLocationList(): void
    {
        $this->functionalLocations = FunctionalLocationCatalog::all()
            ->map(fn (array $row): array => [
                'code' => $row['code'],
                'type' => $row['type'],
                'serial_number' => $row['serial_no'],
                'registration' => $row['registration'],
            ])
            ->all();

        $this->setStatus('Functional location list loaded.', 'green');
    }

    public function loadEquipmentList(): void
    {
        $this->equipments = EquipmentCatalog::all()
            ->map(fn (array $row): array => [
                'code' => $row['equipment_no'] !== '' ? $row['equipment_no'] : $row['id'],
                'part_number' => $row['item_no'],
                'part_number_name' => $row['item_name'],
                'serial_number' => $row['serial_number'],
                'variant' => $row['variant'],
            ])
            ->all();

        $this->setStatus('Equipment list loaded.', 'green');
    }

    public function startSimulation(): void
    {
        $groupLabel = match ($this->groupBy) {
            'chapter' => 'Chapter',
            'chapter-section' => 'Chapter - Section',
            default => 'None',
        };

        $this->setStatus('Simulation preview started with group by: ' . $groupLabel . '.', 'blue');
    }

    public function cancelSimulation(): void
    {
        $this->days = '';
        $this->date = now()->format('d.m.y');
        $this->functionalLocations = [];
        $this->equipments = [];
        $this->includeSubEquipmentWithMaintenancePlan = false;
        $this->includeTaskList = false;
        $this->includeCountersWithPotential = false;
        $this->groupBy = 'none';
        $this->statusMessage = null;
        $this->statusTone = 'blue';
    }

    public function render()
    {
        return view('livewire.maintenance.simulation-on-fleet-page', [
            'blankRows' => range(1, 6),
        ]);
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
