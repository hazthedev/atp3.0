<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\FunctionalLocationCatalog;
use Livewire\Component;

class FunctionalLocationSearchPage extends Component
{
    public function render()
    {
        // Keep this page aligned to the SAP sample rows without changing
        // the broader shared FL catalog used by other screens.
        $records = FunctionalLocationCatalog::all()
            ->whereIn('code', ['9M-WAA', '9M-WAB', '9M-WAD'])
            ->values();

        return view('livewire.fleet.functional-location-search-page', [
            'records' => $records,
        ]);
    }
}
