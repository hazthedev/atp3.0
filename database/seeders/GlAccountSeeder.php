<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\GlAccount;
use Illuminate\Database\Seeder;

class GlAccountSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            ['code' => '11010001', 'name' => 'CASH ON HAND'],
            ['code' => '12010001', 'name' => 'INVENTORIES - RAW'],
            ['code' => '12010002', 'name' => 'INVENTORIES - WIP'],
            ['code' => '12010003', 'name' => 'INVENTORIES - FINISHED'],
            ['code' => '12010004', 'name' => 'INVENTORIES - EXOP'],
            ['code' => '41010001', 'name' => 'SALES - GOODS'],
            ['code' => '41010002', 'name' => 'SALES - SERVICES'],
            ['code' => '51010001', 'name' => 'COST OF GOODS SOLD'],
            ['code' => '52010001', 'name' => 'PRICE DIFFERENCE'],
            ['code' => '52010002', 'name' => 'EXCHANGE RATE DIFFERENCE'],
            ['code' => '53010001', 'name' => 'VARIANCE'],
            ['code' => '53010002', 'name' => 'ALLOCATION'],
            ['code' => '53010003', 'name' => 'GOODS CLEARING'],
            ['code' => '53010004', 'name' => 'EXPENSE CLEARING'],
            ['code' => '54010001', 'name' => 'SALES RETURNS'],
            ['code' => '54010002', 'name' => 'SALES CREDIT'],
            ['code' => '54010003', 'name' => 'PURCHASE CREDIT'],
            ['code' => '55010001', 'name' => 'INVENTORY OFFSET - DECREASE'],
            ['code' => '55010002', 'name' => 'INVENTORY OFFSET - INCREASE'],
            ['code' => '55010003', 'name' => 'INVENTORY OFFSET P&L'],
            ['code' => '55010004', 'name' => 'NEGATIVE INVENTORY ADJUSTMENT'],
            ['code' => '55010005', 'name' => 'G/L DECREASE'],
            ['code' => '55010006', 'name' => 'G/L INCREASE'],
            ['code' => '55010007', 'name' => 'STOCK IN TRANSIT'],
            ['code' => '55010008', 'name' => 'SHIPPED GOODS'],
        ];

        foreach ($accounts as $account) {
            GlAccount::updateOrCreate(['code' => $account['code']], $account);
        }
    }
}
