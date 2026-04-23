<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AircraftVariant;
use Illuminate\Database\Seeder;

/** Source: @MRO_OVAR — 2 rows. */
class AircraftVariantSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => '00000000', 'name' => 'AW139', 'interface_code' => '00000000', 'ipc_code' => '00000000'],
            ['code' => '00000001', 'name' => 'AW189', 'interface_code' => '00000001', 'ipc_code' => '00000001'],
        ];

        foreach ($rows as $r) {
            AircraftVariant::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
