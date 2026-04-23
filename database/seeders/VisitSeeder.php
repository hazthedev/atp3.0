<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Visit;
use Illuminate\Database\Seeder;

/**
 * Source: @MRO_OVST in weststar_atp3_aish.sql — 88 visit templates for AW139/AW189.
 */
class VisitSeeder extends Seeder
{
    public function run(): void
    {
        $visits = [
            ['code' => '00000000', 'name' => 'AW139 1200HRS'],
            ['code' => '00000001', 'name' => 'AW139 2YE'],
            ['code' => '00000002', 'name' => 'AW139 4YE A'],
            ['code' => '00000003', 'name' => 'AW139 4YE B'],
            ['code' => '00000004', 'name' => 'AW139 4YE C'],
            ['code' => '00000005', 'name' => 'AW139 1YEAR'],
            ['code' => '00000006', 'name' => 'AW139 600HRS'],
            ['code' => '00000007', 'name' => 'AW139 ENG 600HRS'],
            ['code' => '00000008', 'name' => 'AW139 RAD 1YE'],
            ['code' => '00000009', 'name' => 'AW139 300HRS'],
            ['code' => '0000000A', 'name' => 'AW139 ENG 300HRS'],
            ['code' => '0000000B', 'name' => 'AW139 200HRS'],
            ['code' => '0000000C', 'name' => 'AW139 150HRS'],
            ['code' => '0000000D', 'name' => 'AW139 ENG 150HRS'],
            ['code' => '0000000E', 'name' => 'AW139 100HRS'],
            ['code' => '0000000F', 'name' => 'AW139 50HRS'],
            ['code' => '0000000G', 'name' => 'AW139 25HRS'],
            ['code' => '0000000H', 'name' => 'AW139 1200H1Y'],
            ['code' => '0000000I', 'name' => 'AW139 300H1Y'],
            ['code' => '0000000J', 'name' => 'AW139 600H1Y'],
            ['code' => '0000000K', 'name' => 'AW139 ENG 900HRS1YR'],
            ['code' => '0000000L', 'name' => 'AW189 8YE'],
            ['code' => '0000000M', 'name' => 'AW189 4YE'],
            ['code' => '0000000N', 'name' => 'AW189 2YEAR'],
            ['code' => '0000000O', 'name' => 'AW189 1YE'],
            ['code' => '0000000P', 'name' => 'AW189 6MO'],
            ['code' => '0000000Q', 'name' => 'AW189 3200FH4Y'],
            ['code' => '0000000R', 'name' => 'AW189 3200FH'],
            ['code' => '0000000S', 'name' => 'AW189 1600FH4Y'],
            ['code' => '0000000T', 'name' => 'AW189 1600FH2Y'],
            ['code' => '0000000U', 'name' => 'AW189 1600FH'],
            ['code' => '0000000V', 'name' => 'AW189 1000FH'],
            ['code' => '0000000W', 'name' => 'AW189 800FH'],
            ['code' => '0000000X', 'name' => 'AW189 500FH'],
            ['code' => '0000000Y', 'name' => 'AW189 400FH1Y'],
            ['code' => '0000000Z', 'name' => 'AW189 400FH'],
            ['code' => '00000010', 'name' => 'AW189 300FH'],
            ['code' => '00000011', 'name' => 'AW189 200FH'],
            ['code' => '00000012', 'name' => 'AW189 150FH'],
            ['code' => '00000013', 'name' => 'AW189 50FH'],
            ['code' => '00000014', 'name' => 'AW189 25HRS'],
            ['code' => '00000015', 'name' => 'AW189 RAD 1YE'],
            ['code' => '00000016', 'name' => 'AW189 ENG 150HRS'],
            ['code' => '00000017', 'name' => 'AW189 ENG 200HRS'],
            ['code' => '00000018', 'name' => 'AW189 ENG 400HRS'],
            ['code' => '00000019', 'name' => 'AW189 ENG 800H1Y'],
            ['code' => '0000001A', 'name' => 'AW189 ENG 1600HRS'],
            ['code' => '0000001B', 'name' => 'AW189 APU 200HRS'],
            ['code' => '0000001C', 'name' => 'AW189 COMPASS SWING 2YE'],
            ['code' => '0000001D', 'name' => 'AW139 1YE'],
            ['code' => '0000001E', 'name' => 'AW189 2YE'],
            ['code' => '0000001F', 'name' => 'AW139 25HRS/7D'],
            ['code' => '0000001G', 'name' => 'AW139 ACCP 1WEEK'],
            ['code' => '0000001H', 'name' => 'AW139 ACCP 1MTH'],
            ['code' => '0000001I', 'name' => 'AW139 ACCP 3MTH'],
            ['code' => '0000001J', 'name' => 'AW139 ACCP 6MTH'],
            ['code' => '0000001K', 'name' => 'AW139 ACCP 1YE'],
            ['code' => '0000001L', 'name' => 'AW139 ACCP 2YE'],
            ['code' => '0000001M', 'name' => 'AW189 ACCP 1WEEK'],
            ['code' => '0000001N', 'name' => 'AW189 ACCP 2WEEK'],
            ['code' => '0000001O', 'name' => 'AW189 ACCP 1MTH'],
            ['code' => '0000001P', 'name' => 'AW189 ACCP 3MTHS'],
            ['code' => '0000001Q', 'name' => 'AW189 ACCP 6MTHS'],
            ['code' => '0000001R', 'name' => 'AW139 ACCP 2WEEK (MODERATE)'],
            ['code' => '0000001S', 'name' => 'AW139 ACCP 3MTH (MODERATE)'],
            ['code' => '0000001T', 'name' => 'AW139 ACCP 6MTH (MODERATE)'],
            ['code' => '0000001U', 'name' => 'AW139 ACCP 1YE (MODERATE)'],
            ['code' => '0000001V', 'name' => 'AW139 ACCP 2YE (MODERATE & MILD)'],
            ['code' => '0000001W', 'name' => 'AW139 ACCP 4YE (MODERATE & MILD)'],
            ['code' => '0000001X', 'name' => 'AW139 ACCP 1MTH (MILD)'],
            ['code' => '0000001Y', 'name' => 'AW139 ACCP 6MTH (MILD)'],
            ['code' => '0000001Z', 'name' => 'AW139 ACCP 1YE (MILD)'],
            ['code' => '00000020', 'name' => 'AW139 4YE'],
            ['code' => '00000021', 'name' => 'AW139 8YE'],
            ['code' => '00000022', 'name' => 'AW139 2400HRS'],
            ['code' => '00000023', 'name' => 'AW139 4800HRS'],
            ['code' => '00000024', 'name' => 'AW189 LH ENG 150HRS'],
            ['code' => '00000025', 'name' => 'AW189 LH ENG 200HRS'],
            ['code' => '00000026', 'name' => 'AW189 LH ENG 400HRS'],
            ['code' => '00000027', 'name' => 'AW189 LH ENG 800H1Y'],
            ['code' => '00000028', 'name' => 'AW189 LH ENG 1600HRS'],
            ['code' => '00000029', 'name' => 'AW189 RH ENG 150HRS'],
            ['code' => '0000002A', 'name' => 'AW189 RH ENG 200HRS'],
            ['code' => '0000002B', 'name' => 'AW189 RH ENG 400HRS'],
            ['code' => '0000002C', 'name' => 'AW189 RH ENG 800H1Y'],
            ['code' => '0000002D', 'name' => 'AW189 RH ENG 1600HRS'],
            ['code' => '0000002E', 'name' => 'AW139 ACCP 2WEEK'],
            ['code' => '0000002F', 'name' => 'AW139 Md Nur Checks 100HR'],
        ];

        foreach ($visits as $i => $v) {
            Visit::updateOrCreate(
                ['code' => $v['code']],
                ['name' => $v['name'], 'sort_order' => $i]
            );
        }
    }
}
