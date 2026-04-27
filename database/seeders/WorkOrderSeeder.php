<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\WorkOrder;
use Illuminate\Database\Seeder;

/**
 * Source: @MRO_MOR2 + mocked-up lifecycle states.
 * SAP's WO data is spread across MOR2 → MORC + AMR4/AMR8 archives. Here we seed a
 * representative spread of lifecycle states that match the Fleet Dashboard Details
 * "Next Due WO" column and Work Order list pages.
 */
class WorkOrderSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => 'WO-24247', 'variant_code' => '00000000', 'aircraft_registration' => '9M-WAD',
             'status_code' => '-0000001', // Planned
             'work_package_code' => '000008L2',
             'planned_date' => '2026-04-28', 'title' => 'AW139 CPI ADDITIONAL 1 — 9M-WAD'],
            ['code' => 'WO-24246', 'variant_code' => '00000000', 'aircraft_registration' => '9M-WAD',
             'status_code' => '-0000001',
             'work_package_code' => '000008L2',
             'planned_date' => '2026-04-28', 'title' => 'AW139 CPI ADDITIONAL 2 — 9M-WAD'],
            ['code' => 'WO-23292', 'variant_code' => '00000000', 'aircraft_registration' => '9M-WAD',
             'status_code' => '-0000002', // Released
             'work_package_code' => '0000072M',
             'planned_date' => '2026-04-15', 'released_date' => '2026-04-20', 'ric_date_in' => '2020-07-30',
             'title' => 'EOAS AW139/EOAS/369'],
            ['code' => 'WO-23210', 'variant_code' => '00000000', 'aircraft_registration' => '9M-WAD',
             'status_code' => '-0000002',
             'work_package_code' => '000007XI',
             'released_date' => '2026-04-10', 'ric_date_in' => '2020-07-23',
             'title' => 'SB139-642 Part I — Tail rotor head inspection'],
            ['code' => 'WO-20861', 'variant_code' => '00000001', 'aircraft_registration' => '9M-WSV',
             'status_code' => '00000003', // Closed
             'closed_date' => '2020-05-06',
             'title' => 'AW189 200FH — 9M-WSV'],
            ['code' => 'WO-20862', 'variant_code' => '00000001', 'aircraft_registration' => '9M-WSV',
             'status_code' => '00000003',
             'closed_date' => '2020-05-06',
             'title' => 'AW189 ENG 200HRS — 9M-WSV'],
            ['code' => 'WO-21814', 'variant_code' => '00000000', 'aircraft_registration' => '9M-WAD',
             'status_code' => '00000003',
             'closed_date' => '2020-06-20',
             'title' => 'AW139 DUKANE TM beacon — 9M-WAD'],
            ['code' => 'WO-23121', 'variant_code' => '00000000', 'aircraft_registration' => '9M-WAD',
             'status_code' => '00000003',
             'closed_date' => '2020-08-13',
             'title' => 'AW139 CPI ADDITIONAL 1 — closed'],
            ['code' => 'WO-23120', 'variant_code' => '00000000', 'aircraft_registration' => '9M-WAD',
             'status_code' => '00000003',
             'closed_date' => '2020-08-13',
             'title' => 'AW139 CPI ADDITIONAL 2 — closed'],
            // Postponed / open examples
            ['code' => 'WO-24400', 'variant_code' => '00000000', 'aircraft_registration' => '9M-WBB',
             'status_code' => '-0000019', // Postponed
             'title' => 'AW139 SB 139-594 PART II — awaiting parts'],
            ['code' => 'WO-24411', 'variant_code' => '00000001', 'aircraft_registration' => '9M-WSU',
             'status_code' => '-0000002',
             'title' => 'AW189 LH ENG 200HRS — scheduled'],
            ['code' => 'WO-24412', 'variant_code' => '00000001', 'aircraft_registration' => '9M-WSU',
             'status_code' => '-0000002',
             'title' => 'AW189 RH ENG 200HRS — scheduled'],
        ];

        foreach ($rows as $r) {
            WorkOrder::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
