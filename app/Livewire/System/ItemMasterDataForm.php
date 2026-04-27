<?php

declare(strict_types=1);

namespace App\Livewire\System;

use App\Models\Item;
use Livewire\Attributes\On;
use Livewire\Component;

class ItemMasterDataForm extends Component
{
    public int $itemId;

    public string $code = '';
    public string $description = '';
    public string $manufacturer = '';
    public string $item_group = '';
    public string $item_class = '';

    public function mount(int $itemId): void
    {
        $this->itemId = $itemId;
        $this->loadFromDb();
    }

    private function loadFromDb(): void
    {
        $item = Item::find($this->itemId);

        if ($item === null) {
            return;
        }

        $this->code = $item->code ?? '';
        $this->description = $item->description ?? '';
        $this->manufacturer = $item->manufacturer ?? '';
        $this->item_group = $item->item_group ?? '';
        $this->item_class = $item->item_class ?? '';
    }

    #[On('save-edit-form')]
    public function save(): void
    {
        $item = Item::find($this->itemId);

        if ($item === null) {
            return;
        }

        $item->update([
            'code' => $this->code,
            'description' => $this->description,
            'manufacturer' => $this->manufacturer ?: null,
            'item_group' => $this->item_group ?: null,
            'item_class' => $this->item_class ?: null,
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
        return view('livewire.system.item-master-data-form');
    }
}
