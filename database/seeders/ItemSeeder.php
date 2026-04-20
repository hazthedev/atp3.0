<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CounterRef;
use App\Models\Item;
use App\Models\ItemCalendarCounter;
use App\Models\ItemCounter;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $rows = $this->rows();

        foreach ($rows as $row) {
            Item::updateOrCreate(['code' => $row['code']], $row);
        }

        $engine = Item::where('code', 'PT6C-67C')->first();

        if ($engine !== null) {
            $presets = [
                'TSN' => ['max_value_hhmm' => '0:00', 'status' => 'Validate'],
                'TSO' => ['max_value_hhmm' => '5000:00', 'status' => 'Validate'],
                'CSN' => ['status' => 'Validate'],
                'CSO' => ['status' => 'Validate'],
                'CC' => ['status' => 'No Valid'],
                'CTC' => ['status' => 'No Valid'],
                'CTCL' => ['status' => 'No Valid'],
                'PTC' => ['status' => 'No Valid'],
            ];

            foreach ($presets as $name => $attrs) {
                $ref = CounterRef::where('name', $name)->first();

                if ($ref === null) {
                    continue;
                }

                ItemCounter::updateOrCreate(
                    ['item_id' => $engine->id, 'counter_ref_id' => $ref->id],
                    array_merge([
                        'orange_light_percent' => 90,
                        'status' => 'Validate',
                    ], $attrs),
                );
            }

            ItemCalendarCounter::updateOrCreate(
                ['item_id' => $engine->id],
                [
                    'label' => 'Calendar Limit',
                    'limit_days' => null,
                    'orange_light_days' => 90,
                    'status' => 'Validate',
                ],
            );
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function rows(): array
    {
        $base = fn (array $attrs): array => array_merge([
            'in_stock' => 0,
            'manufacturer' => '- No Manufacturer -',
            'item_class' => null,
            'calibration' => null,
            'shelf_life' => null,
            'sales_item' => 'Yes',
            'manage_by_batch_serial' => 'Yes',
            'inventory_item' => 'Yes',
            'purchase_item' => 'Yes',
            'item_group' => 'CONSUMABLE',
            'uom_group' => 'Manual',
            'alternative_part' => null,
            'serial_no_management' => 'No',
            'item_type' => 'Items',
        ], $attrs);

        return [
            $base(['code' => 'PT6C-67C', 'description' => 'Engine', 'item_group' => 'AIRCRAFT SPARES', 'serial_no_management' => 'Yes']),
            $base(['code' => '00009M-03', 'description' => 'RETAINING RING', 'in_stock' => 5.00]),
            $base(['code' => '0001', 'description' => 'TEEPOL MULTIPURPOSE DETERGENT', 'in_stock' => 4.00]),
            $base(['code' => '0002', 'description' => 'TEEPOL MULTIPURPOSE DETERGENT', 'manufacturer' => 'TEEPOL', 'calibration' => 'NO', 'shelf_life' => 'YES', 'item_group' => 'INGREDIENTS']),
            $base(['code' => '00020', 'description' => 'AIRCONDITIONING SERVICE HOSE', 'calibration' => 'NO', 'shelf_life' => 'NO', 'item_group' => 'TOOLS AND GSE', 'alternative_part' => 'NO']),
            $base(['code' => '00026032', 'description' => 'AEROLITE 10 LIFERAFT', 'item_group' => 'SAFETY &SURVIVAL EQP', 'serial_no_management' => 'Yes']),
            $base(['code' => '00029020', 'description' => 'LIFERAFT ASSY TYPE 7R(H) MK2', 'calibration' => 'NO', 'shelf_life' => 'YES', 'manage_by_batch_serial' => 'No', 'item_group' => 'SAFETY &SURVIVAL EQP', 'alternative_part' => 'NO', 'serial_no_management' => 'Yes']),
            $base(['code' => '00029044', 'description' => 'LIFE RAFT AEROLITE 4F', 'calibration' => 'NO', 'shelf_life' => 'NO', 'manage_by_batch_serial' => 'No', 'item_group' => 'SAFETY &SURVIVAL EQP', 'alternative_part' => 'NO', 'serial_no_management' => 'Yes']),
            $base(['code' => '00029056', 'description' => 'LIFE RAFT 14RMK1 VAL 23MK3 SAR (H) CO', 'manufacturer' => 'RFD BEAUFORT', 'calibration' => 'NO', 'shelf_life' => 'NO', 'manage_by_batch_serial' => 'No', 'item_group' => 'SAFETY &SURVIVAL EQP', 'alternative_part' => 'NO', 'serial_no_management' => 'Yes']),
            $base(['code' => '00029061', 'description' => 'LIFE RAFT F14R VAL-23 MK2 SAR', 'in_stock' => 6.00, 'calibration' => 'NO', 'shelf_life' => 'YES', 'manage_by_batch_serial' => 'No', 'item_group' => 'SAFETY &SURVIVAL EQP', 'alternative_part' => 'NO', 'serial_no_management' => 'Yes']),
            $base(['code' => '00029065', 'description' => 'SAR F10R HELIRAFT', 'item_group' => 'SAFETY &SURVIVAL EQP', 'serial_no_management' => 'Yes']),
            $base(['code' => '000310', 'description' => 'MICROSOFT LICENSING', 'sales_item' => 'No', 'manage_by_batch_serial' => 'No', 'inventory_item' => 'No', 'purchase_item' => 'No', 'item_group' => 'Items']),
            $base(['code' => '00031010', 'description' => 'HALO LIFEJACKET PASSENGER DOUBLE CHAMBER EBS AU10', 'in_stock' => 7.00, 'item_group' => 'SAFETY &SURVIVAL EQP', 'serial_no_management' => 'Yes']),
            $base(['code' => '000AA', 'description' => 'FEELER GAUGE', 'calibration' => 'NO', 'shelf_life' => 'NO', 'item_group' => 'TOOLS AND GSE', 'alternative_part' => 'NO']),
            $base(['code' => '00110410002', 'description' => 'CONTACT MALE', 'in_stock' => 610.00, 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'NO']),
            $base(['code' => '00110420002', 'description' => 'CONTACT MALE', 'in_stock' => 130.00, 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'NO']),
            $base(['code' => '0011043', 'description' => 'EMERGENCY LIGHT,SPONSON', 'manufacturer' => 'AGUSTA WESTLAND ITALY', 'item_group' => 'AIRCRAFT SPARES']),
            $base(['code' => '00110430002', 'description' => 'CONTACT MALE', 'in_stock' => 534.00, 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'NO']),
            $base(['code' => '001115-101-02', 'description' => 'TERMINAL JUNCTION', 'in_stock' => 25.00]),
            $base(['code' => '001119-201-02', 'description' => 'IN-LINE JUNCTION (AMPHENOL)', 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'NO']),
            $base(['code' => '00111920202', 'description' => 'SPLICE', 'in_stock' => 327.00, 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'NO']),
            $base(['code' => '00111920302', 'description' => 'SPLICE', 'in_stock' => 125.00, 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'NO']),
            $base(['code' => '00111930102', 'description' => 'SPLICE', 'in_stock' => 165.00, 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'NO']),
            $base(['code' => '00116', 'description' => 'LPS-1', 'in_stock' => 109.00, 'calibration' => 'NO', 'shelf_life' => 'NO', 'item_group' => 'INGREDIENTS', 'alternative_part' => 'NO']),
            $base(['code' => '0012-049-001', 'description' => 'PIN', 'in_stock' => 7.00, 'item_group' => 'INGREDIENTS']),
            $base(['code' => '001755-105-02', 'description' => 'Engine', 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'YES']),
            $base(['code' => '001765 916 02', 'description' => 'TERMINAL BLOCK DIODE']),
            $base(['code' => '001987', 'description' => 'CLEANER AND DEGREASER', 'calibration' => 'NO', 'shelf_life' => 'NO', 'item_group' => 'INGREDIENTS', 'alternative_part' => 'NO']),
            $base(['code' => '002045', 'description' => 'POWERFUL PENETRATING OIL, CORROSION INHIBIT', 'calibration' => 'NO', 'shelf_life' => 'NO', 'item_group' => 'INGREDIENTS', 'alternative_part' => 'NO']),
            $base(['code' => '00216', 'description' => 'LPS2', 'in_stock' => 85.00, 'item_group' => 'INGREDIENTS']),
            $base(['code' => '00-23-1099', 'description' => 'DEPLOYMENT BATTERY ADELT', 'manufacturer' => 'CALEDONIAN AIRBONE SYSTEM', 'calibration' => 'NO', 'shelf_life' => 'NO', 'manage_by_batch_serial' => 'No', 'alternative_part' => 'NO', 'serial_no_management' => 'Yes']),
            $base(['code' => '0030R010BN4HC', 'description' => 'HYDAC FILTER ELEMENT', 'calibration' => 'NO', 'shelf_life' => 'NO', 'item_group' => 'INGREDIENTS', 'alternative_part' => 'NO']),
            $base(['code' => '00316', 'description' => 'LPS-3', 'in_stock' => 77.00, 'calibration' => 'NO', 'shelf_life' => 'NO', 'item_group' => 'INGREDIENTS', 'alternative_part' => 'NO']),
            $base(['code' => '00462', 'description' => 'BOX HOIST JUNCTION', 'item_group' => 'AIRCRAFT SPARES']),
            $base(['code' => '004675', 'description' => 'CORROSION INHIBITING COMPOUNDS REMOVER', 'calibration' => 'NO', 'shelf_life' => 'NO', 'item_group' => 'INGREDIENTS', 'alternative_part' => 'NO']),
            $base(['code' => '004NX-O', 'description' => 'OUTER RING', 'in_stock' => 10.00, 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'NO']),
            $base(['code' => '004-RLI-00U', 'description' => 'Base Station, Radio Polycon', 'manage_by_batch_serial' => 'No', 'inventory_item' => 'No', 'item_group' => 'TOOLS AND GSE', 'serial_no_management' => 'Yes']),
            $base(['code' => '004RLI-21U-1909', 'description' => 'POLYCON BASE STATION', 'in_stock' => 1.00, 'manage_by_batch_serial' => 'No', 'item_group' => 'AIRCRAFT SPARES', 'serial_no_management' => 'Yes']),
            $base(['code' => '006048', 'description' => 'GUM AND ADHESIVE REMOVER', 'item_group' => 'INGREDIENTS']),
            $base(['code' => '007669', 'description' => 'AVIONIC CORROSIVE PREVENTIVE COMPOUND', 'calibration' => 'NO', 'shelf_life' => 'YES', 'item_group' => 'INGREDIENTS', 'alternative_part' => 'NO']),
            $base(['code' => '007960', 'description' => 'CORROSION INHIBITING COMPOUNDS REMOVER', 'item_group' => 'INGREDIENTS']),
            $base(['code' => '009402', 'description' => 'CORROSION INHIBITOR', 'in_stock' => 11.00, 'calibration' => 'NO', 'shelf_life' => 'YES', 'item_group' => 'INGREDIENTS', 'alternative_part' => 'NO']),
            $base(['code' => '00950B8000A64C', 'description' => 'O-RING', 'calibration' => 'NO', 'shelf_life' => 'NO', 'alternative_part' => 'NO']),
            $base(['code' => '00MM25', 'description' => 'FEELER GAUGE', 'calibration' => 'NO', 'shelf_life' => 'NO', 'item_group' => 'TOOLS AND GSE', 'alternative_part' => 'NO']),
        ];
    }
}
