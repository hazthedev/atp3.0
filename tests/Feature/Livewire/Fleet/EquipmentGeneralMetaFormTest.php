<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Fleet;

use App\Livewire\Fleet\EquipmentGeneralMetaForm;
use App\Models\Equipment;
use App\Models\Item;
use Livewire\Livewire;
use Tests\TestCase;

class EquipmentGeneralMetaFormTest extends TestCase
{
    public function test_mount_hydrates_meta_fields_from_equipment(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create([
            'item_id' => $item->id,
            'chapter' => 'AC',
            'section' => '00',
            'subject' => '00',
            'sheet' => '000',
            'mark' => '000',
            'mel_item' => 'MEL-1',
        ]);

        Livewire::test(EquipmentGeneralMetaForm::class, ['equipmentId' => $eq->id])
            ->assertSet('chapter', 'AC')
            ->assertSet('section', '00')
            ->assertSet('subject', '00')
            ->assertSet('sheet', '000')
            ->assertSet('mark', '000')
            ->assertSet('mel_item', 'MEL-1');
    }

    public function test_save_persists_changes_to_equipment(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create(['item_id' => $item->id]);

        Livewire::test(EquipmentGeneralMetaForm::class, ['equipmentId' => $eq->id])
            ->set('chapter', 'AC')
            ->set('section', '21')
            ->set('mel_item', 'NEW-MEL')
            ->call('save')
            ->assertDispatched('record-saved');

        $eq->refresh();
        $this->assertSame('AC', $eq->chapter);
        $this->assertSame('21', $eq->section);
        $this->assertSame('NEW-MEL', $eq->mel_item);
    }

    public function test_cancel_restores_original_values(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create([
            'item_id' => $item->id,
            'chapter' => 'AC',
            'mark' => '000',
        ]);

        Livewire::test(EquipmentGeneralMetaForm::class, ['equipmentId' => $eq->id])
            ->set('chapter', 'DIRTY')
            ->set('mark', 'DIRTY')
            ->call('cancelEdit')
            ->assertSet('chapter', 'AC')
            ->assertSet('mark', '000')
            ->assertDispatched('record-saved');

        // DB unchanged
        $eq->refresh();
        $this->assertSame('AC', $eq->chapter);
        $this->assertSame('000', $eq->mark);
    }

    public function test_render_applies_sap_variants_per_catalog(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create(['item_id' => $item->id]);

        Livewire::test(EquipmentGeneralMetaForm::class, ['equipmentId' => $eq->id])
            ->assertSeeHtmlInOrder([
                'wire:model="chapter"',
                'wire:model="section"',
                'wire:model="subject"',
                'wire:model="sheet"',
                'wire:model="mark"',
                'wire:model="mel_item"',
            ]);
    }
}
