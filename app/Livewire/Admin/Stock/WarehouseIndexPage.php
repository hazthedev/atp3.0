<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Stock;

use App\Models\Warehouse;
use Livewire\Component;

class WarehouseIndexPage extends Component
{
    public function render()
    {
        $warehouses = Warehouse::query()
            ->orderBy('code')
            ->get();

        return view('livewire.admin.stock.warehouse-index-page', [
            'warehouses' => $warehouses,
        ]);
    }
}
