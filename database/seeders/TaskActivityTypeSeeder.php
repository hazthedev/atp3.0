<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\TaskActivityType;
use Illuminate\Database\Seeder;

/** Source: @MRO_OATY — 27 rows. */
class TaskActivityTypeSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => '00000000', 'name' => 'ON CONDITION'],
            ['code' => '00000001', 'name' => 'DISC'],
            ['code' => '00000002', 'name' => 'GV-INSP'],
            ['code' => '00000003', 'name' => 'D-INSP'],
            ['code' => '00000004', 'name' => 'OVH'],
            ['code' => '00000005', 'name' => 'TEST'],
            ['code' => '00000006', 'name' => 'INSP'],
            ['code' => '00000007', 'name' => 'SV'],
            ['code' => '00000008', 'name' => 'R-LIFE'],
            ['code' => '00000009', 'name' => 'SD-INSP'],
            ['code' => '0000000A', 'name' => 'BT'],
            ['code' => '0000000B', 'name' => 'FUNCTIONAL CHECK'],
            ['code' => '0000000C', 'name' => 'SERVICING'],
            ['code' => '0000000D', 'name' => 'TREATMENT'],
            ['code' => '0000000E', 'name' => 'DATABASE UPLOAD'],
            ['code' => '0000000F', 'name' => 'CLEANING'],
            ['code' => '0000000G', 'name' => 'DCU DOWNLOAD'],
            ['code' => '0000000H', 'name' => 'EXCEEDANCE INDICATION'],
            ['code' => '0000000I', 'name' => 'CONSISTENCY CHECK'],
            ['code' => '0000000J', 'name' => 'DUPLICATION INSPECTION'],
            ['code' => '0000000K', 'name' => 'PRELIMINARY REQ'],
            ['code' => '0000000L', 'name' => 'REMOVE'],
            ['code' => '0000000M', 'name' => 'INSTALLATION'],
            ['code' => '0000000N', 'name' => 'ASSEMBLE'],
            ['code' => '0000000O', 'name' => 'OPERATIONAL CHECK'],
            ['code' => '0000000P', 'name' => 'RENEWAL'],
            ['code' => '0000000Q', 'name' => 'O/C'],
        ];

        foreach ($rows as $r) {
            TaskActivityType::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
