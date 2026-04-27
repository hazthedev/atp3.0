<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\TaskType;
use Illuminate\Database\Seeder;

/**
 * Source: @MRO_OTAT in weststar_atp3_aish.sql — 60 task types.
 * Includes the 6 primary Fleet Dashboard matrix column types (AD/SB, EOAS, OOP, Kardex, Others, Checks).
 */
class TaskTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['code' => '00000000', 'name' => 'Checks'],
            ['code' => '00000001', 'name' => '300HRS'],
            ['code' => '00000002', 'name' => '600HRS'],
            ['code' => '00000003', 'name' => '1200HRS'],
            ['code' => '00000004', 'name' => 'RAD 1YE'],
            ['code' => '00000005', 'name' => '1YE'],
            ['code' => '00000006', 'name' => '2YE'],
            ['code' => '00000007', 'name' => '600H1Y'],
            ['code' => '00000008', 'name' => '300H1Y'],
            ['code' => '00000009', 'name' => '50HRS'],
            ['code' => '0000000A', 'name' => '4YE C'],
            ['code' => '0000000B', 'name' => '100HRS'],
            ['code' => '0000000C', 'name' => '150HRS'],
            ['code' => '0000000D', 'name' => '4YE A'],
            ['code' => '0000000E', 'name' => '1200H1Y'],
            ['code' => '0000000F', 'name' => '4YE B'],
            ['code' => '0000000G', 'name' => '200HRS'],
            ['code' => '0000000H', 'name' => '25HRS'],
            ['code' => '0000000I', 'name' => 'ENG 300HRS'],
            ['code' => '0000000J', 'name' => 'ENG 600HRS'],
            ['code' => '0000000K', 'name' => 'ENG 150HRS'],
            ['code' => '0000000L', 'name' => '8YE'],
            ['code' => '0000000M', 'name' => '6M'],
            ['code' => '0000000N', 'name' => '4YE'],
            ['code' => '0000000O', 'name' => '1600FH2Y'],
            ['code' => '0000000P', 'name' => '400FH'],
            ['code' => '0000000Q', 'name' => '400FH1Y'],
            ['code' => '0000000R', 'name' => '1600FH'],
            ['code' => '0000000S', 'name' => '3200FH4Y'],
            ['code' => '0000000T', 'name' => '3200HRS'],
            ['code' => '0000000U', 'name' => '800FH'],
            ['code' => '0000000V', 'name' => '1600FH4Y'],
            ['code' => '0000000W', 'name' => '50FH'],
            ['code' => '0000000X', 'name' => '300FH'],
            ['code' => '0000000Y', 'name' => '500FH'],
            ['code' => '0000000Z', 'name' => '100FH'],
            ['code' => '00000010', 'name' => '150FH'],
            ['code' => '00000011', 'name' => '200FH'],
            ['code' => '00000012', 'name' => '1000FH'],
            ['code' => '00000013', 'name' => 'OTHER'],
            ['code' => '00000014', 'name' => 'Kardex'],
            ['code' => '00000015', 'name' => 'OOP'],
            ['code' => '00000016', 'name' => 'WAS'],
            ['code' => '00000017', 'name' => 'Aircraft AD/SB'],
            ['code' => '00000018', 'name' => 'ENG 900HRS1YR'],
            ['code' => '00000019', 'name' => 'UNSCHEDULED'],
            ['code' => '0000001A', 'name' => 'EOAS'],
            ['code' => '0000001B', 'name' => 'EASA AD'],
            ['code' => '0000001C', 'name' => 'COMPONENT SCHEDULE'],
            ['code' => '0000001D', 'name' => 'AW189 ENG 150HRS'],
            ['code' => '0000001E', 'name' => 'AW189 ENG 200HRS'],
            ['code' => '0000001F', 'name' => 'AW189 ENG 400HRS'],
            ['code' => '0000001G', 'name' => 'AW189 ENG 800HRS/1Y'],
            ['code' => '0000001H', 'name' => 'AW189 ENG 1600HRS'],
            ['code' => '0000001I', 'name' => 'AW189 APU 200HRS'],
            ['code' => '0000001J', 'name' => 'APU SB'],
            ['code' => '0000001K', 'name' => '400HRS'],
            ['code' => '0000001L', 'name' => 'CERTIFICATE'],
            ['code' => '0000001M', 'name' => '6MO'],
            ['code' => '0000001N', 'name' => '3200FH'],
        ];

        foreach ($types as $t) {
            TaskType::updateOrCreate(['code' => $t['code']], $t);
        }
    }
}
