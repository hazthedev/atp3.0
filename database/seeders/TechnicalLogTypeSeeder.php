<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\TechnicalLogType;
use Illuminate\Database\Seeder;

/** Source: @MRO_OTLT — 6 rows. */
class TechnicalLogTypeSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => '00000000', 'name' => 'On condition'],
            ['code' => '00000001', 'name' => 'Refer to'],
            ['code' => '00000002', 'name' => 'If needed'],
            ['code' => '00000003', 'name' => 'Post Modification'],
            ['code' => '00000004', 'name' => 'Induces as anterior'],
            ['code' => '00000005', 'name' => 'Induces as posterior'],
        ];

        foreach ($rows as $r) {
            TechnicalLogType::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
