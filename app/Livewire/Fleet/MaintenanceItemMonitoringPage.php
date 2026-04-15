<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\MaintenanceItemMonitoringCatalog;
use Illuminate\Support\Collection;
use Livewire\Component;

class MaintenanceItemMonitoringPage extends Component
{
    public string $manageItemBy = 'serial-number';

    public ?string $statusMessage = null;

    public string $statusTone = 'blue';

    public function confirmPreview(): void
    {
        $this->setStatus('Maintenance item monitoring preview confirmed.', 'green');
    }

    public function cancelPreview(): void
    {
        $this->setStatus('Maintenance item monitoring preview reset.', 'blue');
    }

    public function render()
    {
        return view('livewire.fleet.maintenance-item-monitoring-page', [
            'rows' => MaintenanceItemMonitoringCatalog::all(),
            'manageByOptions' => [
                '' => '0  -  All',
                'none' => '1  -  None',
                'serial-number' => '2  -  Serial number',
                'batch-number' => '3  -  Batch Number',
            ],
        ]);
    }

    private function setStatus(string $message, string $tone): void
    {
        $this->statusMessage = $message;
        $this->statusTone = $tone;
    }
}
