<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MeasureUnit;
use Illuminate\Database\Seeder;

class MeasureUnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['code' => '-0000010', 'designation' => 'Calendar limit'],
            ['code' => '00000007', 'designation' => 'Cycle'],
            ['code' => '00000003', 'designation' => 'Days'],
            ['code' => '-0000014', 'designation' => 'Gallon'],
            ['code' => '00000002', 'designation' => 'Hours'],
            ['code' => '0000000A', 'designation' => 'kilogram'],
            ['code' => '-0000015', 'designation' => 'Litre'],
            ['code' => '00000001', 'designation' => 'Min'],
            ['code' => '00000005', 'designation' => 'Month'],
            ['code' => '-0000012', 'designation' => 'Nb of landings'],
            ['code' => '00000008', 'designation' => 'Nb of Repair'],
            ['code' => '-0000011', 'designation' => 'Nb of startings up'],
            ['code' => '-0000016', 'designation' => 'Nb of Take Offs'],
            ['code' => '0000000B', 'designation' => 'pound'],
            ['code' => '00000009', 'designation' => 'Quantity'],
            ['code' => '00000000', 'designation' => 'Sec'],
            ['code' => '00000004', 'designation' => 'Week'],
            ['code' => '00000006', 'designation' => 'Year'],
        ];

        foreach ($units as $unit) {
            MeasureUnit::updateOrCreate(['code' => $unit['code']], $unit);
        }
    }
}
