<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\FunctionalLocationCatalog;
use Livewire\Component;

class CustomerFunctionalLocationPage extends Component
{
    public ?int $recordId = null;

    public bool $emptyState = false;

    public function mount(?int $recordId = null, bool $emptyState = false): void
    {
        $this->recordId = $recordId;

        if ($recordId !== null && FunctionalLocationCatalog::find($recordId) === null) {
            abort(404);
        }

        $this->emptyState = $emptyState || $recordId === null;
    }

    public function render()
    {
        return view('livewire.fleet.customer-functional-location-page', [
            'record' => $this->recordId !== null ? FunctionalLocationCatalog::find($this->recordId) : null,
        ]);
    }
}
