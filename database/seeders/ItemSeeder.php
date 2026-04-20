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
        $items = [
            ['code' => 'PT6C-67C', 'description' => 'Engine'],
            ['code' => '00009M-03', 'description' => 'RETAINING RING'],
            ['code' => '0001', 'description' => 'TEEPOL MULTIPURPOSE DETERGENT'],
            ['code' => '0002', 'description' => 'TEEPOL MULTIPURPOSE DETERGENT'],
            ['code' => '00020', 'description' => 'AIRCONDITIONING SERVICE HOSE'],
            ['code' => '00026032', 'description' => 'AEROLITE 10 LIFERAFT'],
            ['code' => '00029020', 'description' => 'LIFERAFT ASSY TYPE 7R(H) MK2'],
            ['code' => '00029044', 'description' => 'LIFE RAFT AEROLITE 4F'],
            ['code' => '00029056', 'description' => 'LIFE RAFT 14RMK1 VAL 23MK3 SAR (H) CO'],
            ['code' => '00029061', 'description' => 'LIFE RAFT F14R VAL-23 MK2 SAR'],
            ['code' => '00029065', 'description' => 'SAR F10R HELIRAFT'],
            ['code' => '000310', 'description' => 'MICROSOFT LICENSING'],
            ['code' => '00031010', 'description' => 'HALO LIFEJACKET PASSENGER DOUBLE CHAMBER EBS AU10'],
            ['code' => '000AA', 'description' => 'FEELER GAUGE'],
            ['code' => '00110410002', 'description' => 'CONTACT MALE'],
            ['code' => '00110420002', 'description' => 'CONTACT MALE'],
            ['code' => '0011043', 'description' => 'EMERGENCY LIGHT,SPONSON'],
            ['code' => '00110430002', 'description' => 'CONTACT MALE'],
            ['code' => '001115-101-02', 'description' => 'TERMINAL JUNCTION'],
            ['code' => '001119-201-02', 'description' => 'IN-LINE JUNCTION (AMPHENOL)'],
            ['code' => '00111920202', 'description' => 'SPLICE'],
            ['code' => '00111920302', 'description' => 'SPLICE'],
            ['code' => '00111930102', 'description' => 'SPLICE'],
            ['code' => '00116', 'description' => 'LPS-1'],
            ['code' => '0012-049-001', 'description' => 'PIN'],
            ['code' => '001755-105-02', 'description' => 'Engine'],
            ['code' => '001765 916 02', 'description' => 'TERMINAL BLOCK DIODE'],
            ['code' => '001987', 'description' => 'CLEANER AND DEGREASER'],
            ['code' => '002045', 'description' => 'POWERFUL PENETRATING OIL, CORROSION INHIBIT'],
            ['code' => '00216', 'description' => 'LPS2'],
            ['code' => '00-23-1099', 'description' => 'DEPLOYMENT BATTERY ADELT'],
            ['code' => '0030R010BN4HC', 'description' => 'HYDAC FILTER ELEMENT'],
            ['code' => '00316', 'description' => 'LPS-3'],
            ['code' => '00462', 'description' => 'BOX HOIST JUNCTION'],
            ['code' => '004675', 'description' => 'CORROSION INHIBITING COMPOUNDS REMOVER'],
            ['code' => '004NX-O', 'description' => 'OUTER RING'],
            ['code' => '004-RLI-00U', 'description' => 'Base Station, Radio Polycon'],
            ['code' => '004RLI-21U-1909', 'description' => 'POLYCON BASE STATION'],
            ['code' => '006048', 'description' => 'GUM AND ADHESIVE REMOVER'],
            ['code' => '007669', 'description' => 'AVIONIC CORROSIVE PREVENTIVE COMPOUND'],
            ['code' => '007960', 'description' => 'CORROSION INHIBITING COMPOUNDS REMOVER'],
            ['code' => '009402', 'description' => 'CORROSION INHIBITOR'],
            ['code' => '00950B8000A64C', 'description' => 'O-RING'],
            ['code' => '00MM25', 'description' => 'FEELER GAUGE'],
        ];

        $firstItem = null;

        foreach ($items as $row) {
            $item = Item::updateOrCreate(['code' => $row['code']], $row);
            $firstItem = $firstItem ?? $item;
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
}
