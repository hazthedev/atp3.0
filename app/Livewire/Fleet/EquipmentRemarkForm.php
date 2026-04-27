<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\Equipment;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Livewire-bound free-form remark workspace for the Customer Equipment Card
 * Remark tab. Lives separately from EquipmentShowForm and
 * EquipmentGeneralMetaForm because it renders inside a different tab DOM
 * region. Shares the same Edit Record toggle dispatch via the
 * 'save-edit-form' / 'cancel-edit-form' events.
 */
class EquipmentRemarkForm extends Component
{
    public int $equipmentId;

    public string $remark_text = '';

    public function mount(int $equipmentId): void
    {
        $this->equipmentId = $equipmentId;
        $this->loadFromDb();
    }

    private function loadFromDb(): void
    {
        $eq = Equipment::find($this->equipmentId);

        if ($eq === null) {
            return;
        }

        $this->remark_text = $eq->remark_text ?? '';
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        $eq = Equipment::find($this->equipmentId);

        if ($eq === null) {
            return;
        }

        $eq->update([
            'remark_text' => $this->remark_text ?: null,
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
        return view('livewire.fleet.equipment-remark-form');
    }
}
