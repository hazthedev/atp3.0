<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\PendingInstalledBaseUpdatesCatalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class PendingInstalledBaseUpdatesPage extends Component
{
    public string $context = 'functional-location';

    public bool $displayOpenWorkOrders = true;

    /** @var array<string, bool> */
    public array $confirmed = [];

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function mount(string $context = 'functional-location'): void
    {
        $this->context = $context;

        foreach ($this->rows() as $row) {
            $this->confirmed[$row['code']] = false;
        }
    }

    public function confirmPreview(): void
    {
        $count = collect($this->confirmed)->filter()->count();

        $this->setStatus(
            $count > 0
                ? sprintf('Prepared %d installed-base update(s) for confirmation.', $count)
                : 'No rows selected yet. Tick one or more Confirm boxes first.',
            $count > 0 ? 'green' : 'amber',
        );
    }

    public function openFleetManagement(): void
    {
        $this->setStatus('Fleet Management drill-through is reserved for the backend integration phase.', 'blue');
    }

    public function render()
    {
        return view('livewire.fleet.pending-installed-base-updates-page', [
            'rows' => $this->visibleRows(),
            'cancelRoute' => $this->context === 'equipment'
                ? route('fleet.equipment.customer-equipment-card')
                : route('fleet.functional-location.customer'),
            'pageDescription' => $this->context === 'equipment'
                ? 'Review equipment work-order updates that are waiting for install-base confirmation.'
                : 'Review pending installed-base updates raised by work orders before confirming them into the aircraft structure.',
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, string|bool>>
     */
    private function visibleRows(): Collection
    {
        if (! $this->displayOpenWorkOrders) {
            return $this->rows();
        }

        return $this->rows()
            ->filter(static fn (array $row): bool => (bool) $row['display_open'])
            ->values();
    }

    /**
     * @return \Illuminate\Support\Collection<int, array<string, string|bool>>
     */
    private function rows(): Collection
    {
        return PendingInstalledBaseUpdatesCatalog::all();
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
