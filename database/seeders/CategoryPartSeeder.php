<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CategoryPart;
use Illuminate\Database\Seeder;

/** Source: @MRO_OCAT — 16 rows. */
class CategoryPartSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => '00000000', 'name' => 'O/C'],
            ['code' => '00000001', 'name' => 'H/T LLP'],
            ['code' => '00000002', 'name' => 'H/T TCC'],
            ['code' => '00000003', 'name' => 'Engine L'],
            ['code' => '00000004', 'name' => 'Engine R'],
            ['code' => '00000005', 'name' => 'NA'],
            ['code' => '00000006', 'name' => 'H/T LLP Left'],
            ['code' => '00000007', 'name' => 'H/T LLP Right'],
            ['code' => '00000008', 'name' => 'H/T TCC Left'],
            ['code' => '00000009', 'name' => 'H/T TCC Right'],
            ['code' => '0000000A', 'name' => 'APU'],
            ['code' => '0000000B', 'name' => 'O/C Right'],
            ['code' => '0000000C', 'name' => 'O/C Left'],
            ['code' => '0000000D', 'name' => 'COPLT PFD'],
            ['code' => '0000000E', 'name' => 'CO-PLT MFD'],
            ['code' => '0000000F', 'name' => 'PILOT MFD'],
            ['code' => '0000000G', 'name' => 'PILOT PFD'],
        ];

        foreach ($rows as $r) {
            CategoryPart::updateOrCreate(['code' => $r['code']], $r);
        }
    }
}
