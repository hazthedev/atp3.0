<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Stock;

use App\Models\ItemGroup;
use Livewire\Component;

class ItemGroupIndexPage extends Component
{
    public function render()
    {
        $groups = ItemGroup::query()
            ->orderBy('name')
            ->get();

        return view('livewire.admin.stock.item-group-index-page', [
            'groups' => $groups,
        ]);
    }
}
