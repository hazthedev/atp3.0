<?php

declare(strict_types=1);

use App\Models\Equipment;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Equipment counters
        Schema::table('equipment_counters', function (Blueprint $table) {
            $table->foreignId('linked_equipment_id')
                ->nullable()
                ->after('residual')
                ->constrained('equipments')
                ->nullOnDelete();
        });

        $this->migrateValues('equipment_counters');

        Schema::table('equipment_counters', function (Blueprint $table) {
            $table->dropColumn('linked_equi_id');
        });

        // Functional location counters
        Schema::table('functional_location_counters', function (Blueprint $table) {
            $table->foreignId('linked_equipment_id')
                ->nullable()
                ->after('residual')
                ->constrained('equipments')
                ->nullOnDelete();
        });

        $this->migrateValues('functional_location_counters');

        Schema::table('functional_location_counters', function (Blueprint $table) {
            $table->dropColumn('linked_equi_id');
        });
    }

    public function down(): void
    {
        Schema::table('equipment_counters', function (Blueprint $table) {
            $table->string('linked_equi_id')->nullable()->after('residual');
            $table->dropForeign(['linked_equipment_id']);
            $table->dropColumn('linked_equipment_id');
        });

        Schema::table('functional_location_counters', function (Blueprint $table) {
            $table->string('linked_equi_id')->nullable()->after('residual');
            $table->dropForeign(['linked_equipment_id']);
            $table->dropColumn('linked_equipment_id');
        });
    }

    private function migrateValues(string $table): void
    {
        $rows = DB::table($table)
            ->whereNotNull('linked_equi_id')
            ->where('linked_equi_id', '!=', '')
            ->get();

        $matched = 0;
        $unmatched = [];

        foreach ($rows as $row) {
            $equipment = Equipment::where('equipment_no', $row->linked_equi_id)
                ->orWhere('serial_number', $row->linked_equi_id)
                ->first();

            if ($equipment !== null) {
                DB::table($table)
                    ->where('id', $row->id)
                    ->update(['linked_equipment_id' => $equipment->id]);
                $matched++;
            } else {
                $unmatched[] = $row->linked_equi_id;
            }
        }

        echo "[{$table}] migrated: {$matched} matched, " . count($unmatched) . " unmatched" . PHP_EOL;

        if ($unmatched !== []) {
            echo "[{$table}] UNMATCHED linked_equi_id values (left null): " . implode(', ', array_unique($unmatched)) . PHP_EOL;
        }
    }
};
