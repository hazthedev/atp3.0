<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\AircraftCardCatalog;
use Livewire\Attributes\Computed;
use Livewire\Component;

class AircraftCardPage extends Component
{
    public string $registration = 'A6-ATP';

    public string $activeTab = 'overview';

    public bool $editMode = false;

    /** @var array<string, mixed> */
    public array $form = [];

    public const TABS = [
        'overview'                => 'Overview',
        'general'                 => 'General',
        'configuration'           => 'Configuration',
        'counters'                => 'Counters',
        'maintenance'             => 'Maintenance',
        'technical-publications'  => 'Technical Publications',
        'defects'                 => 'Defects',
        'work-package'            => 'Work Package / Work Order',
        'journey-logs'            => 'Journey Logs',
        'events'                  => 'Events',
    ];

    public function mount(?string $registration = null): void
    {
        $resolved = $registration !== null && AircraftCardCatalog::exists($registration)
            ? $registration
            : AircraftCardCatalog::default();

        $this->registration = $resolved;
        $this->loadForm();
    }

    public function switchAircraft(string $registration): void
    {
        if (! AircraftCardCatalog::exists($registration)) {
            return;
        }

        $this->registration = $registration;
        $this->editMode = false;
        $this->loadForm();
    }

    public function setTab(string $tab): void
    {
        if (! array_key_exists($tab, self::TABS)) {
            return;
        }

        $this->activeTab = $tab;
    }

    public function enableEdit(): void
    {
        $this->editMode = true;
    }

    public function cancelEdit(): void
    {
        $this->loadForm();
        $this->editMode = false;
    }

    public function save(): void
    {
        // Mock-only — no DB write. Real implementation would persist $this->form.
        $this->editMode = false;
        $this->dispatch('aircraft-card-saved', message: 'Changes saved (mock)');
    }

    /**
     * @return array<string, mixed>
     */
    #[Computed]
    public function aircraft(): array
    {
        return AircraftCardCatalog::find($this->registration);
    }

    /**
     * @return array<int, array{registration: string, msn: string, type: string, status: string}>
     */
    #[Computed]
    public function aircraftList(): array
    {
        return AircraftCardCatalog::all();
    }

    private function loadForm(): void
    {
        $aircraft = AircraftCardCatalog::find($this->registration);
        $g = $aircraft['general'];

        $this->form = [
            'lifecycle'      => $g['lifecycle'],
            'operator_org'   => $g['operator_org'],
            'mass_limits'    => $g['mass_limits'],
            'registration'   => $g['registration'],
            'manufacturer'   => $g['manufacturer'],
            'powerplant'     => $g['powerplant'],
            'owner_address'  => $g['owner_address'],
            'commercial'     => $g['commercial'],
        ];
    }

    public function render()
    {
        return view('livewire.fleet.aircraft-card-page');
    }
}
