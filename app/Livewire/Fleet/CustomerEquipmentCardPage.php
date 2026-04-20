<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\Equipment;
use App\Support\EquipmentCatalog;
use Livewire\Component;

class CustomerEquipmentCardPage extends Component
{
    public ?int $recordId = null;

    public bool $emptyState = false;

    public function mount(?int $recordId = null, bool $emptyState = false): void
    {
        $this->recordId = $recordId;
        $this->emptyState = $emptyState || $recordId === null;
    }

    public function render()
    {
        $equipment = null;
        $record = null;

        if ($this->recordId !== null) {
            $equipment = Equipment::with(['item', 'counters.counterRef', 'calendarCounter'])->find($this->recordId);

            if ($equipment !== null) {
                $record = $this->recordFromEquipment($equipment);
            } else {
                $catalogRow = EquipmentCatalog::find($this->recordId);

                if ($catalogRow === null) {
                    abort(404);
                }

                $record = $catalogRow;
            }
        }

        return view('livewire.fleet.customer-equipment-card-page', [
            'record' => $record,
            'equipment' => $equipment,
            'counters' => $equipment?->counters
                ->sortBy(fn ($c) => $c->counterRef?->sort_order ?? 999)
                ->values() ?? collect(),
            'calendarCounter' => $equipment?->calendarCounter,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function recordFromEquipment(Equipment $equipment): array
    {
        return [
            'id' => (string) $equipment->id,
            'equipment_no' => (string) ($equipment->equipment_no ?? $equipment->id),
            'serial_number' => $equipment->serial_number,
            'item_no' => $equipment->item?->code ?? '',
            'item_name' => $equipment->item?->description ?? '',
            'item_description' => $equipment->item?->description ?? '',
            'category_part' => $equipment->category_part ?? '',
            'variant' => $equipment->variant ?? '',
            'status' => $equipment->status ?? '',
            'owner_code' => $equipment->owner_code ?? '',
            'owner_name' => $equipment->owner_name ?? '',
            'operator_code' => $equipment->operator_code ?? '',
            'operator_name' => $equipment->operator_name ?? '',
            'operator_name_display' => trim((string) ltrim((string) ($equipment->operator_name ?? ''), '*')),
            'maintenance_plan' => $equipment->maintenance_plan ?? '',
            'mel' => $equipment->mel ?? '',
        ];
    }
}
