<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\FunctionalLocationCatalog;
use Livewire\Component;

class FunctionalLocationSearchPage extends Component
{
    public function render()
    {
        $records = FunctionalLocationCatalog::all()->values();

        return view('livewire.fleet.functional-location-search-page', [
            'records' => $records,
        ]);
    }
}
