<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\Equipment;
use Livewire\Component;

class EquipmentIndexPage extends Component
{
    public function render()
    {
        $rows = Equipment::with('item')
            ->orderBy('id')
            ->get()
            ->whereIn('id', [1, 2, 3])
            ->map(fn (Equipment $e): array => [
                'id' => $e->id,
                'item_no' => $e->item?->code ?? '',
                'item_name' => $e->item?->description ?? '',
                'serial_number' => $e->serial_number,
                'old' => '',
                'category_part' => $e->category_part ?? '',
                'variant' => $e->variant ?? '',
                'status' => $e->status ?? '',
                'father_object_type' => $e->status === 'On Aircraft' ? 'Functional Location' : '',
                'father_reference' => $e->status === 'On Aircraft' ? 'AW139 / M104-04' : '',
                'operator_name' => $e->operator_name ?? '',
                'owner_name' => $e->owner_name ?? '',
            ])
            ->values();

        return view('livewire.fleet.equipment-index-page', [
            'rows' => $rows,
        ]);
    }
}
