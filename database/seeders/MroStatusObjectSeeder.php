<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\MroStatusObject;
use Illuminate\Database\Seeder;

class MroStatusObjectSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['code' => '00000001', 'name' => 'Opened', 'description' => 'Opened'],
            ['code' => '00000002', 'name' => 'Pending', 'description' => 'Pending'],
            ['code' => '00000003', 'name' => 'Closed', 'description' => 'Closed'],
            ['code' => '00000004', 'name' => 'Serviceable', 'description' => 'Serviceable'],
            ['code' => '00000005', 'name' => 'Scrap', 'description' => 'Scrap'],
            ['code' => '00000006', 'name' => 'Validate', 'description' => 'Validate'],
            ['code' => '00000007', 'name' => 'No Valid', 'description' => 'No Valid'],
            ['code' => '00000008', 'name' => 'Applicable', 'description' => 'Applicable'],
            ['code' => '00000009', 'name' => 'Non applicable', 'description' => 'Non applicable'],
            ['code' => '0000000A', 'name' => 'Removed', 'description' => null],
            ['code' => '0000000B', 'name' => 'Quarantine', 'description' => null],
            ['code' => '0000000E', 'name' => 'On Aircraft', 'description' => null],
            ['code' => '-0000001', 'name' => 'Planned', 'description' => 'Planned'],
            ['code' => '-0000002', 'name' => 'Released', 'description' => 'Released'],
            ['code' => '-0000003', 'name' => 'Cancelled', 'description' => 'Cancelled'],
            ['code' => '-0000004', 'name' => 'Non Updatable', 'description' => 'Non Updatable'],
            ['code' => '-0000005', 'name' => 'On Hold', 'description' => 'On Hold'],
            ['code' => '-0000006', 'name' => 'Not Defined', 'description' => 'Not Defined'],
            ['code' => '-0000007', 'name' => 'Airworthy', 'description' => 'Airworthy'],
            ['code' => '-0000008', 'name' => 'In Repair', 'description' => 'In Repair'],
            ['code' => '-0000009', 'name' => 'Applied', 'description' => 'Applied'],
            ['code' => '-0000012', 'name' => 'Approved', 'description' => 'Approved'],
            ['code' => '-0000013', 'name' => 'Confirmed', 'description' => 'Confirmed'],
            ['code' => '-0000014', 'name' => 'Draft', 'description' => 'Draft'],
            ['code' => '-0000015', 'name' => 'Scheduled', 'description' => 'Scheduled'],
            ['code' => '-0000016', 'name' => 'Delayed', 'description' => 'Delayed'],
            ['code' => '-0000017', 'name' => 'Arrived', 'description' => 'Arrived'],
            ['code' => '-0000018', 'name' => 'Completed', 'description' => 'Completed'],
            ['code' => '-0000019', 'name' => 'Postponed', 'description' => 'Postponed'],
            ['code' => '-0000020', 'name' => 'Refused', 'description' => 'Refused'],
            ['code' => '-0000021', 'name' => 'Deferred', 'description' => 'Deferred'],
            ['code' => '-0000022', 'name' => 'In Review', 'description' => 'In Review'],
            ['code' => '-0000023', 'name' => 'Ghost', 'description' => 'Operational Inputs'],
            ['code' => '-0000024', 'name' => 'Checked', 'description' => 'Checked'],
            ['code' => 'OTS', 'name' => 'Out of Service', 'description' => null],
        ];

        foreach ($statuses as $status) {
            MroStatusObject::updateOrCreate(['code' => $status['code']], $status);
        }
    }
}
