<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Penalty;
use Illuminate\Database\Seeder;

class PenaltySeeder extends Seeder
{
    public function run(): void
    {
        $penalties = [
            ['code' => 'PENALTY_1', 'name' => 'Penalty 1'],
            ['code' => 'PENALTY_2', 'name' => 'Penalty 2'],
            ['code' => 'PENALTY_3', 'name' => 'Penalty 3'],
            ['code' => 'PENALTY_4', 'name' => 'Penalty 4'],
            ['code' => 'PENALTY_5', 'name' => 'Penalty 5'],
            ['code' => 'PENALTY_6', 'name' => 'Penalty 6'],
        ];

        foreach ($penalties as $penalty) {
            Penalty::updateOrCreate(['code' => $penalty['code']], $penalty);
        }
    }
}
