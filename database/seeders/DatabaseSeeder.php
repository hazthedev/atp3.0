<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            MeasureUnitSeeder::class,
            CounterRefSeeder::class,
            MroStatusObjectSeeder::class,
            PenaltySeeder::class,
            ItemSeeder::class,
            EquipmentSeeder::class,
            FunctionalLocationSeeder::class,

            // Phase 1 — SAP MRO reference tables
            VisitSeeder::class,
            TaskTypeSeeder::class,
            TaskActivityTypeSeeder::class,
            MelCategorySeeder::class,
            TechnicalLogTypeSeeder::class,
            WorkflowGroupSeeder::class,
            AircraftVariantSeeder::class,
            CategoryPartSeeder::class,
            UtilizationModelSeeder::class,

            // Phase 2 — SAP MRO transactional tables
            WorkOrderSeeder::class, // seed first so TechnicalLog FK resolves
            TechnicalLogSeeder::class,
        ]);
    }
}
