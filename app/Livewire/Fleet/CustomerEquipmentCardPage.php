<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\EquipmentCatalog;
use Livewire\Component;

class CustomerEquipmentCardPage extends Component
{
    public ?int $recordId = null;

    public bool $emptyState = false;

    public function mount(?int $recordId = null, bool $emptyState = false): void
    {
        $this->recordId = $recordId;

        if ($recordId !== null && EquipmentCatalog::find($recordId) === null) {
            abort(404);
        }

        $this->emptyState = $emptyState || $recordId === null;
    }

    public function render()
    {
        return view('livewire.fleet.customer-equipment-card-page', [
            'record' => $this->recordId !== null ? EquipmentCatalog::find($this->recordId) : null,
        ]);
    }
}
