<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MelCategory;
use Illuminate\Database\Seeder;

/** Source: @MRO_OCML — 5 rows (MEL A/B/C/D + CFD). */
class MelCategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => '00000000', 'name' => 'A',  'short_id' => 'A',  'description' => 'MEL A', 'duration_days' => 999, 'only_one' => false],
            ['code' => '00000001', 'name' => 'B',  'short_id' => 'B',  'description' => 'MEL B', 'duration_days' => 3,   'only_one' => false],
            ['code' => '00000002', 'name' => 'C',  'short_id' => 'C',  'description' => 'MEL C', 'duration_days' => 10,  'only_one' => false],
            ['code' => '00000003', 'name' => 'D',  'short_id' => 'D',  'description' => 'MEL D', 'duration_days' => 120, 'only_one' => false],
            ['code' => '00000005', 'name' => 'CF', 'short_id' => 'CF', 'description' => 'CFD',   'duration_days' => 30,  'only_one' => false],
        ];

        foreach ($rows as $r) {
            MelCategory::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
