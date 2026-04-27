<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Fleet;

use App\Livewire\Fleet\EquipmentRemarkForm;
use App\Models\Equipment;
use App\Models\Item;
use Livewire\Livewire;
use Tests\TestCase;

class EquipmentRemarkFormTest extends TestCase
{
    public function test_mount_hydrates_remark_text_from_equipment(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create([
            'item_id' => $item->id,
            'remark_text' => 'Existing remark.',
        ]);

        Livewire::test(EquipmentRemarkForm::class, ['equipmentId' => $eq->id])
            ->assertSet('remark_text', 'Existing remark.');
    }

    public function test_mount_with_null_remark_initialises_to_empty_string(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create(['item_id' => $item->id, 'remark_text' => null]);

        Livewire::test(EquipmentRemarkForm::class, ['equipmentId' => $eq->id])
            ->assertSet('remark_text', '');
    }

    public function test_save_persists_remark_to_equipment(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create(['item_id' => $item->id]);

        Livewire::test(EquipmentRemarkForm::class, ['equipmentId' => $eq->id])
            ->set('remark_text', 'New free-form remark.')
            ->call('save')
            ->assertDispatched('record-saved');

        $eq->refresh();
        $this->assertSame('New free-form remark.', $eq->remark_text);
    }

    public function test_save_with_empty_string_persists_null(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create([
            'item_id' => $item->id,
            'remark_text' => 'Was here.',
        ]);

        Livewire::test(EquipmentRemarkForm::class, ['equipmentId' => $eq->id])
            ->set('remark_text', '')
            ->call('save');

        $eq->refresh();
        $this->assertNull($eq->remark_text);
    }

    public function test_cancel_restores_original_value(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create([
            'item_id' => $item->id,
            'remark_text' => 'Original remark.',
        ]);

        Livewire::test(EquipmentRemarkForm::class, ['equipmentId' => $eq->id])
            ->set('remark_text', 'Dirty edit.')
            ->call('cancelEdit')
            ->assertSet('remark_text', 'Original remark.')
            ->assertDispatched('record-saved');

        // DB unchanged
        $eq->refresh();
        $this->assertSame('Original remark.', $eq->remark_text);
    }
}
