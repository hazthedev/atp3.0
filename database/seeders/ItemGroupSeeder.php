<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\ItemGroup;
use Illuminate\Database\Seeder;

class ItemGroupSeeder extends Seeder
{
    public function run(): void
    {
        $groups = [
            ['name' => 'Consumables', 'lead_time_days' => 14, 'default_valuation_method' => 'FIFO'],
            ['name' => 'Rotables', 'lead_time_days' => 30, 'default_valuation_method' => 'Moving Average'],
            ['name' => 'Tools', 'lead_time_days' => 7, 'default_valuation_method' => 'FIFO'],
            ['name' => 'Chemicals', 'lead_time_days' => 21, 'default_valuation_method' => 'FIFO'],
        ];

        foreach ($groups as $group) {
            ItemGroup::updateOrCreate(['name' => $group['name']], $group);
        }
    }
}
