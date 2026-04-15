<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Support\EquipmentCatalog;
use Livewire\Component;

class EquipmentIndexPage extends Component
{
    public function render()
    {
        $rows = EquipmentCatalog::all()->values();

        return view('livewire.fleet.equipment-index-page', [
            'rows' => $rows,
        ]);
    }
}
