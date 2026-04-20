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
        $this->seedPrimaryEquipment();
        $this->seedFleetEquipment();
    }

    private function seedPrimaryEquipment(): void
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

    private function seedFleetEquipment(): void
    {
        $records = [
            ['item_no' => 'AW139', 'item_name' => 'AW139', 'serial_number' => '31324', 'category_part' => '', 'variant' => 'AW139', 'status' => 'On Aircraft'],
            ['item_no' => '4G1860F00113', 'item_name' => 'Kit MVA Assy', 'serial_number' => 'R94', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft'],
            ['item_no' => '4G1860F00113A1', 'item_name' => 'VIBRATION ABS DAT0011', 'serial_number' => '4G1860F00113A1-0001', 'category_part' => 'H/T LLP', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '3G2140V0252', 'item_name' => 'Heating Control', 'serial_number' => '00590', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft'],
            ['item_no' => '3G2140V01451', 'item_name' => 'Shut Off Valve', 'serial_number' => '00134', 'category_part' => 'H/T TCC', 'variant' => 'AW139', 'status' => 'On Aircraft'],
            ['item_no' => '3G2140V01451', 'item_name' => 'Shut Off Valve', 'serial_number' => '00135', 'category_part' => 'H/T TCC', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '3G2150V00252', 'item_name' => 'Air Cont. Control', 'serial_number' => '00864', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft'],
            ['item_no' => '3G2150V00252', 'item_name' => 'Air Cont. Control', 'serial_number' => '00872', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft'],
            ['item_no' => '3G2150V00353', 'item_name' => 'ECS CONTROL P', 'serial_number' => '000317', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '3G2150V1653', 'item_name' => 'COMPRESSOR P', 'serial_number' => '1768-0050', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '1768-60', 'item_name' => 'BELT', 'serial_number' => 'WA5/KB/266', 'category_part' => 'H/T LLP', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '1768-60', 'item_name' => 'BELT', 'serial_number' => 'WA5/KB/262', 'category_part' => 'H/T LLP', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '3788', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '3821', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '1-8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '3918', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft'],
            ['item_no' => '1-8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '5024', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '2-8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '3559', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed'],
            ['item_no' => '2-8486-3', 'item_name' => 'ACTUATOR,SMA', 'serial_number' => '1862', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'On Aircraft'],
            ['item_no' => '7011702-948', 'item_name' => 'Guidance Control', 'serial_number' => '14052573', 'category_part' => 'O/C', 'variant' => 'AW139', 'status' => 'Removed'],
        ];

        foreach ($records as $record) {
            $item = Item::firstOrCreate(
                ['code' => $record['item_no']],
                ['description' => $record['item_name']],
            );

            Equipment::updateOrCreate(
                ['serial_number' => $record['serial_number']],
                [
                    'equipment_no' => $record['serial_number'],
                    'item_id' => $item->id,
                    'category_part' => $record['category_part'] ?: null,
                    'variant' => $record['variant'],
                    'status' => $record['status'],
                    'owner_code' => '300028',
                    'owner_name' => '*WESTSTAR',
                    'operator_code' => '300028',
                    'operator_name' => 'Weststar',
                ],
            );
        }
    }
}
