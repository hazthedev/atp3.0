<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CounterHistory;
use App\Models\CounterRef;
use App\Models\FunctionalLocation;
use App\Models\FunctionalLocationCalendarCounter;
use App\Models\FunctionalLocationCounter;
use App\Models\Item;
use App\Models\ItemCalendarCounter;
use App\Models\ItemCounter;
use Illuminate\Database\Seeder;

class FunctionalLocationSeeder extends Seeder
{
    public function run(): void
    {
        $aircraftItem = Item::where('code', 'AW139')->first();

        // Seed the AW139 item counter template so Item Master Data Aero One shows them.
        if ($aircraftItem !== null) {
            $templateCounters = ['TSN', 'CSN', 'START', 'E#1CC', 'E#1CTC', 'E#1PTC', 'E#2CC', 'E#2CTC'];

            foreach ($templateCounters as $name) {
                $ref = CounterRef::where('name', $name)->first();

                if ($ref === null) {
                    continue;
                }

                ItemCounter::updateOrCreate(
                    ['item_id' => $aircraftItem->id, 'counter_ref_id' => $ref->id],
                    [
                        'orange_light_percent' => 90,
                        'status' => 'Validate',
                    ],
                );
            }

            ItemCalendarCounter::updateOrCreate(
                ['item_id' => $aircraftItem->id],
                [
                    'label' => 'Calendar Limit',
                    'limit_days' => null,
                    'orange_light_days' => 90,
                    'status' => 'Validate',
                ],
            );
        }

        $fl = FunctionalLocation::updateOrCreate(
            ['code' => '9M-WAA'],
            [
                'serial_no' => '31324',
                'registration' => 'M104-04',
                'type' => 'AW139',
                'mel' => null,
                'status' => 'Airworthy',
                'maintenance_plan' => 'AW139 AMP ISS 7 REV 4 / GOCOM',
                'owner_code' => '300028',
                'owner_name' => '*WESTSTAR',
                'operator_code' => '300028',
                'operator_name' => '*WESTSTAR',
                'item_id' => $aircraftItem?->id,
            ],
        );

        $readings = [
            'TSN'   => ['value_hhmm' => '13193:44', 'reading_date' => '2025-12-15', 'residual' => '142:01', 'tone' => 'amber', 'info_source' => 'Planning sheet'],
            'CSN'   => ['value_dec' => 20608, 'reading_date' => '2025-12-15', 'residual' => '11392', 'tone' => 'amber', 'info_source' => 'Planning sheet'],
            'START' => ['value_dec' => 3722, 'reading_date' => '2025-12-15', 'tone' => 'green', 'info_source' => 'Planning sheet'],
            'E#1CC'  => ['value_dec' => 12751.25, 'reading_date' => '2025-12-15', 'residual' => '7248.75', 'tone' => 'amber', 'info_source' => 'Engine import'],
            'E#1CTC' => ['value_dec' => 8607.21, 'reading_date' => '2025-12-15', 'residual' => '3392.79', 'tone' => 'amber', 'info_source' => 'Engine import'],
            'E#1PTC' => ['value_dec' => 10083.17, 'reading_date' => '2025-12-15', 'residual' => '1916.83', 'tone' => 'amber', 'info_source' => 'Engine import'],
        ];

        foreach ($readings as $name => $attrs) {
            $ref = CounterRef::where('name', $name)->first();

            if ($ref === null) {
                continue;
            }

            $counter = FunctionalLocationCounter::updateOrCreate(
                ['functional_location_id' => $fl->id, 'counter_ref_id' => $ref->id],
                array_merge([
                    'propagate' => true,
                    'reading_hour' => '00:00',
                    'is_used' => true,
                ], $attrs),
            );

            $newValueDec = $counter->value_dec !== null ? (float) $counter->value_dec : null;

            if ($newValueDec !== null || $counter->value_hhmm !== null) {
                CounterHistory::create([
                    'counter_ref_id' => $ref->id,
                    'subject_type' => 'functional_location',
                    'subject_id' => $fl->id,
                    'previous_value_dec' => null,
                    'previous_value_hhmm' => null,
                    'new_value_dec' => $newValueDec,
                    'new_value_hhmm' => $counter->value_hhmm,
                    'delta_dec' => $newValueDec,
                    'reading_date' => $counter->reading_date,
                    'reading_hour' => $counter->reading_hour ?? '00:00',
                    'info_source' => $counter->info_source,
                    'source_type' => 'seed',
                    'source_ref' => 'FunctionalLocationSeeder',
                ]);
            }
        }

        // Seed remaining template counters as available-but-not-used
        $notYetUsed = ['E#2CC', 'E#2CTC'];
        foreach ($notYetUsed as $name) {
            $ref = CounterRef::where('name', $name)->first();

            if ($ref === null) {
                continue;
            }

            FunctionalLocationCounter::updateOrCreate(
                ['functional_location_id' => $fl->id, 'counter_ref_id' => $ref->id],
                [
                    'propagate' => true,
                    'reading_hour' => '00:00',
                    'is_used' => false,
                    'tone' => 'grey',
                ],
            );
        }

        FunctionalLocationCalendarCounter::updateOrCreate(
            ['functional_location_id' => $fl->id],
            [
                'label' => 'Calendar Limit',
                'value_date' => null,
                'remaining' => '0.0000',
                'is_used' => false,
                'reset_to_null' => false,
            ],
        );
    }
}
