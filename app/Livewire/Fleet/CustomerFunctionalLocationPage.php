<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\FunctionalLocationCatalog;
use Livewire\Component;

class CustomerFunctionalLocationPage extends Component
{
    public function render()
    {
        return view('livewire.fleet.customer-functional-location-page', [
            'records' => FunctionalLocationCatalog::all()->values(),
        ]);
    }
}
