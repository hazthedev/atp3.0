<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            ['code' => 'BWH CNM', 'name' => 'BWH CONSIGNMENT', 'location' => 'Subang'],
            ['code' => 'CTR BON', 'name' => 'CENTRAL BONDED', 'location' => 'Subang'],
            ['code' => 'DIL BOND', 'name' => 'DILI BOND', 'location' => 'Dili'],
            ['code' => 'DIL CNMT', 'name' => 'DILI CONSIGNMENT', 'location' => 'Dili'],
            ['code' => 'DIL TOOL', 'name' => 'DILI TOOLS', 'location' => 'Dili'],
            ['code' => 'FYLZ BON', 'name' => 'NAMIBIA BONDED', 'location' => 'Namibia'],
        ];

        foreach ($warehouses as $warehouse) {
            Warehouse::updateOrCreate(
                ['code' => $warehouse['code']],
                array_merge($warehouse, [
                    'nettable' => true,
                    'inactive' => false,
                    'drop_ship' => false,
                    'issue_part_for_maintenance' => false,
                    'enable_bin_locations' => false,
                ])
            );
        }
    }
}
