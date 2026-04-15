<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\ModificationCatalog;
use Livewire\Component;

class ModificationSearchPage extends Component
{
    public function render()
    {
        return view('livewire.fleet.modification-search-page', [
            'rows' => ModificationCatalog::all(),
        ]);
    }
}
