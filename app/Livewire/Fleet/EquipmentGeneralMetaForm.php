<?php

declare(strict_types=1);

namespace App\Livewire\Fleet;

use App\Models\Equipment;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Livewire-bound 6-field meta row for the Customer Equipment Card General tab.
 *
 * Lives separately from EquipmentShowForm because it renders inside the
 * General tab (a sibling DOM region), not the top summary card. Both
 * components share the same Edit Record toggle dispatch via the
 * 'save-edit-form' / 'cancel-edit-form' events emitted by the page-level
 * Alpine wrapper.
 */
class EquipmentGeneralMetaForm extends Component
{
    public int $equipmentId;

    public string $chapter = '';
    public string $section = '';
    public string $subject = '';
    public string $sheet = '';
    public string $mark = '';
    public string $mel_item = '';

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

        $this->chapter = $eq->chapter ?? '';
        $this->section = $eq->section ?? '';
        $this->subject = $eq->subject ?? '';
        $this->sheet = $eq->sheet ?? '';
        $this->mark = $eq->mark ?? '';
        $this->mel_item = $eq->mel_item ?? '';
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        $eq = Equipment::find($this->equipmentId);

        if ($eq === null) {
            return;
        }

        $eq->update([
            'chapter' => $this->chapter ?: null,
            'section' => $this->section ?: null,
            'subject' => $this->subject ?: null,
            'sheet' => $this->sheet ?: null,
            'mark' => $this->mark ?: null,
            'mel_item' => $this->mel_item ?: null,
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
        return view('livewire.fleet.equipment-general-meta-form');
    }
}
