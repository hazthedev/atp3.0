<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counter_info_sources', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        $seed = [
            ['code' => 'PLANNING_SHEET', 'name' => 'Planning sheet', 'description' => 'Value imported from the planning sheet workflow.'],
            ['code' => 'ENGINE_IMPORT',  'name' => 'Engine import',  'description' => 'Value imported from engine-specific batch import.'],
            ['code' => 'OFP',            'name' => 'OFP',            'description' => 'Value sourced from Operational Flight Plan.'],
            ['code' => 'MANUAL',         'name' => 'Manual',         'description' => 'Manually entered by a user via the edit modal.'],
            ['code' => 'DFL',            'name' => 'Daily Flight Log', 'description' => 'Value propagated from a Daily Flight Log.'],
            ['code' => 'DAILY_UPDATE',   'name' => 'Daily Update',   'description' => 'Value from a Daily Update batch job.'],
        ];

        $now = now();
        foreach ($seed as $row) {
            DB::table('counter_info_sources')->insert(array_merge($row, [
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }

        Schema::table('equipment_counters', function (Blueprint $table) {
            $table->foreignId('counter_info_source_id')
                ->nullable()
                ->after('info_source')
                ->constrained('counter_info_sources')
                ->nullOnDelete();
        });

        Schema::table('functional_location_counters', function (Blueprint $table) {
            $table->foreignId('counter_info_source_id')
                ->nullable()
                ->after('info_source')
                ->constrained('counter_info_sources')
                ->nullOnDelete();
        });

        Schema::table('counter_history', function (Blueprint $table) {
            $table->foreignId('counter_info_source_id')
                ->nullable()
                ->after('info_source')
                ->constrained('counter_info_sources')
                ->nullOnDelete();
        });

        $this->backfill('equipment_counters');
        $this->backfill('functional_location_counters');
        $this->backfill('counter_history');
    }

    public function down(): void
    {
        foreach (['equipment_counters', 'functional_location_counters', 'counter_history'] as $table) {
            Schema::table($table, function (Blueprint $t) use ($table) {
                $t->dropForeign([$table . '_counter_info_source_id_foreign']);
                $t->dropColumn('counter_info_source_id');
            });
        }

        Schema::dropIfExists('counter_info_sources');
    }

    private function backfill(string $table): void
    {
        $sources = DB::table('counter_info_sources')->pluck('id', 'name');

        $rows = DB::table($table)
            ->whereNotNull('info_source')
            ->where('info_source', '!=', '')
            ->get();

        $matched = 0;
        $unmatched = [];

        foreach ($rows as $row) {
            $sourceId = $sources->get($row->info_source);

            if ($sourceId !== null) {
                DB::table($table)
                    ->where('id', $row->id)
                    ->update(['counter_info_source_id' => $sourceId]);
                $matched++;
            } else {
                $unmatched[] = $row->info_source;
            }
        }

        echo "[{$table}] info_source backfill: {$matched} matched, " . count($unmatched) . ' unmatched' . PHP_EOL;

        if ($unmatched !== []) {
            echo "[{$table}] unmatched info_source values: " . implode(', ', array_unique($unmatched)) . PHP_EOL;
        }
    }
};
