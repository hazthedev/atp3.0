<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CounterRef;
use App\Models\Equipment;
use App\Models\EquipmentCalendarCounter;
use App\Models\EquipmentCounter;
use App\Models\Item;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $engineItem = Item::where('code', 'PT6C-67C')->first();

        if ($engineItem === null) {
            return;
        }

        $equipment = Equipment::updateOrCreate(
            ['serial_number' => 'PCE-KB0798'],
            [
                'equipment_no' => '548',
                'item_id' => $engineItem->id,
                'category_part' => 'Engine L',
                'variant' => 'AW139',
                'status' => 'On Aircraft',
                'owner_code' => '300028',
                'owner_name' => '*WESTSTAR',
                'operator_code' => '300028',
                'operator_name' => 'Weststar',
            ],
        );

        $readings = [
            'TSN' => ['value_dec' => 754402.0000, 'value_hhmm' => '12573:22', 'reading_date' => '2025-12-15', 'remaining' => '412:32', 'linked_equi_id' => '51791', 'is_used' => true],
            'TSO' => ['value_dec' => 170977.0000, 'value_hhmm' => '2849:37', 'max_dec' => 300000.0000, 'max_hhmm' => '5000:00', 'reading_date' => '2025-12-15', 'remaining' => '2150:23', 'residual' => '600:00', 'linked_equi_id' => '16775', 'is_used' => true],
            'CSN' => ['value_dec' => 20624.0000, 'reading_date' => '2025-12-15', 'is_used' => true],
            'CSO' => ['value_dec' => 12596.0000, 'reading_date' => '2025-12-15', 'is_used' => true],
            'START' => ['value_dec' => 7757.0000, 'reading_date' => '2025-12-15', 'is_used' => true],
            'START[O]' => ['value_dec' => 2124.0000, 'reading_date' => '2025-12-15', 'is_used' => true],
            // Others seeded but not used; user enters a value to activate them
            'CC' => ['is_used' => false],
            'CTC' => ['is_used' => false],
            'CTCL' => ['is_used' => false],
            'PTC' => ['is_used' => false],
        ];

        foreach ($readings as $name => $attrs) {
            $ref = CounterRef::where('name', $name)->first();

            if ($ref === null) {
                continue;
            }

            EquipmentCounter::updateOrCreate(
                ['equipment_id' => $equipment->id, 'counter_ref_id' => $ref->id],
                array_merge([
                    'propagate' => true,
                    'reading_hour' => '00:00',
                ], $attrs),
            );
        }

        EquipmentCalendarCounter::updateOrCreate(
            ['equipment_id' => $equipment->id],
            [
                'label' => 'Calendar Limit',
                'value_date' => '2026-04-20',
                'is_used' => false,
                'reset_to_null' => false,
            ],
        );
    }
}
