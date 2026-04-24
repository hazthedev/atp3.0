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
        // Dev-only test user. Idempotent so re-seeding never fails on the unique
        // email constraint, and skipped entirely in production.
        if (! app()->environment('production')) {
            User::firstOrCreate(
                ['email' => 'test@example.com'],
                [
                    'name' => 'Test User',
                    'password' => bcrypt('password'),
                ]
            );
        }

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

            // Phase 3 — User Management
            UserSeeder::class,
            UserGroupSeeder::class, // needs users for memberships
            PermissionSeeder::class, // needs user_groups for example read-only authorizations

            // Phase 4 — Stock Management reference data
            GlAccountSeeder::class,
            WarehouseSeeder::class,
            ItemGroupSeeder::class,
        ]);
    }
}
