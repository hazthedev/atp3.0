<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\Equipment;
use Livewire\Attributes\On;
use Livewire\Component;

class EquipmentShowForm extends Component
{
    public const STATUS_OPTIONS = [
        'Ghost',
        'In Repair',
        'On Aircraft',
        'Quarantine',
        'Removed',
        'Scrap',
        'Serviceable',
    ];

    public int $equipmentId;

    public string $equipment_no = '';
    public string $serial_number = '';
    public string $item_no = '';
    public string $item_description = '';
    public string $category_part = '';
    public string $variant = '';
    public string $status = '';
    public string $owner_code = '';
    public string $owner_name = '';
    public string $operator_code = '';
    public string $operator_name = '';
    public string $maintenance_plan = '';
    public string $mel = '';

    public function mount(int $equipmentId): void
    {
        $this->equipmentId = $equipmentId;
        $this->loadFromDb();
    }

    private function loadFromDb(): void
    {
        $eq = Equipment::with('item')->find($this->equipmentId);

        if ($eq === null) {
            return;
        }

        $this->equipment_no = (string) ($eq->equipment_no ?? '');
        $this->serial_number = $eq->serial_number ?? '';
        $this->item_no = $eq->item->code ?? '';
        $this->item_description = $eq->item->description ?? '';
        $this->category_part = $eq->category_part ?? '';
        $this->variant = $eq->variant ?? '';
        $this->status = $eq->status ?? '';
        $this->owner_code = $eq->owner_code ?? '';
        $this->owner_name = $eq->owner_name ?? '';
        $this->operator_code = $eq->operator_code ?? '';
        $this->operator_name = $eq->operator_name ?? '';
        $this->maintenance_plan = $eq->maintenance_plan ?? '';
        $this->mel = $eq->mel ?? '';
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        $eq = Equipment::find($this->equipmentId);

        if ($eq === null) {
            return;
        }

        $eq->update([
            'equipment_no' => $this->equipment_no ?: null,
            'serial_number' => $this->serial_number,
            'category_part' => $this->category_part ?: null,
            'variant' => $this->variant ?: null,
            'status' => $this->status ?: 'On Aircraft',
            'owner_code' => $this->owner_code ?: null,
            'owner_name' => $this->owner_name ?: null,
            'operator_code' => $this->operator_code ?: null,
            'operator_name' => $this->operator_name ?: null,
            'maintenance_plan' => $this->maintenance_plan ?: null,
            'mel' => $this->mel ?: null,
        ]);

        $this->dispatch('record-saved');
    }

    #[On('cancel-edit-form')]
    public function cancelEdit(): void
    {
        $this->loadFromDb();
        $this->dispatch('record-saved');
    }

    public function render()
    {
        return view('livewire.fleet.equipment-show-form');
    }
}
