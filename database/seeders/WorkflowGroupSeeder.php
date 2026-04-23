<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\WorkflowGroup;
use Illuminate\Database\Seeder;

/** Source: @MRO_OWFG — 1 row. */
class WorkflowGroupSeeder extends Seeder
{
    public function run(): void
    {
        WorkflowGroup::updateOrCreate(
            ['code' => '-0000001'],
            ['name' => 'Standard']
        );
    }
}
