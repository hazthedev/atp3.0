<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire\Fleet;

use App\Livewire\Fleet\EquipmentShowForm;
use App\Models\Equipment;
use App\Models\Item;
use Livewire\Livewire;
use Tests\TestCase;

class EquipmentShowFormTest extends TestCase
{
    public function test_mount_with_valid_equipment_id_hydrates_form_fields(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create([
            'item_id' => $item->id,
            'equipment_no' => 'EQ-TEST-001',
            'serial_number' => 'SN-TEST-001',
            'category_part' => 'CAT-1',
            'variant' => 'V1',
            'status' => 'On Aircraft',
            'owner_code' => 'OWN1',
            'owner_name' => 'Owner One',
            'operator_code' => 'OP1',
            'operator_name' => 'Operator One',
            'maintenance_plan' => 'MP1',
            'mel' => 'MEL1',
        ]);

        Livewire::test(EquipmentShowForm::class, ['equipmentId' => $eq->id])
            ->assertSet('equipment_no', 'EQ-TEST-001')
            ->assertSet('serial_number', 'SN-TEST-001')
            ->assertSet('category_part', 'CAT-1')
            ->assertSet('variant', 'V1')
            ->assertSet('status', 'On Aircraft')
            ->assertSet('owner_code', 'OWN1')
            ->assertSet('owner_name', 'Owner One')
            ->assertSet('operator_code', 'OP1')
            ->assertSet('operator_name', 'Operator One')
            ->assertSet('maintenance_plan', 'MP1')
            ->assertSet('mel', 'MEL1');
    }

    public function test_save_action_persists_changes_to_the_model(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create([
            'item_id' => $item->id,
            'serial_number' => 'SN-OLD-001',
            'owner_code' => 'OWN-OLD',
        ]);

        Livewire::test(EquipmentShowForm::class, ['equipmentId' => $eq->id])
            ->set('serial_number', 'SN-NEW-001')
            ->set('owner_code', 'OWN-NEW')
            ->set('owner_name', 'New Owner')
            ->call('save')
            ->assertDispatched('record-saved');

        $eq->refresh();
        $this->assertSame('SN-NEW-001', $eq->serial_number);
        $this->assertSame('OWN-NEW', $eq->owner_code);
        $this->assertSame('New Owner', $eq->owner_name);
    }

    public function test_cancel_action_restores_original_values(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create([
            'item_id' => $item->id,
            'serial_number' => 'SN-ORIGINAL',
            'owner_code' => 'OWN-ORIG',
        ]);

        Livewire::test(EquipmentShowForm::class, ['equipmentId' => $eq->id])
            ->set('serial_number', 'SN-DIRTY')
            ->set('owner_code', 'OWN-DIRTY')
            ->call('cancelEdit')
            ->assertSet('serial_number', 'SN-ORIGINAL')
            ->assertSet('owner_code', 'OWN-ORIG')
            ->assertDispatched('record-saved');

        // DB unchanged
        $eq->refresh();
        $this->assertSame('SN-ORIGINAL', $eq->serial_number);
        $this->assertSame('OWN-ORIG', $eq->owner_code);
    }

    public function test_mount_with_non_existent_id_leaves_fields_at_defaults(): void
    {
        // Component's loadFromDb early-returns when Equipment::find returns null,
        // leaving public string properties as their declared defaults ('').
        Livewire::test(EquipmentShowForm::class, ['equipmentId' => 999999])
            ->assertSet('equipmentId', 999999)
            ->assertSet('serial_number', '')
            ->assertSet('equipment_no', '')
            ->assertSet('status', '');
    }

    public function test_item_no_and_item_description_hydrate_from_related_item(): void
    {
        $item = Item::factory()->create([
            'code' => 'AW139',
            'description' => 'AW139 Helicopter',
        ]);
        $eq = Equipment::factory()->create(['item_id' => $item->id]);

        Livewire::test(EquipmentShowForm::class, ['equipmentId' => $eq->id])
            ->assertSet('item_no', 'AW139')
            ->assertSet('item_description', 'AW139 Helicopter');
    }

    public function test_render_applies_sap_variant_attributes_per_catalog(): void
    {
        $item = Item::factory()->create();
        $eq = Equipment::factory()->create(['item_id' => $item->id]);

        Livewire::test(EquipmentShowForm::class, ['equipmentId' => $eq->id])
            // Decision-tree rule 6 — green indicator on Equipment No. and MEL
            ->assertSeeHtmlInOrder([
                'wire:model="equipment_no"',
                'wire:model="mel"',
            ])
            // The Status select must replace the input — option list driven by
            // the STATUS_OPTIONS constant
            ->assertSeeHtml('<option value="On Aircraft">On Aircraft</option>')
            ->assertSeeHtml('<option value="Serviceable">Serviceable</option>');
    }
}
