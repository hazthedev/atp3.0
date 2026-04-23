<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Phase 1 — reference / master tables from the Weststar SAP B1 / 2MoRO MRO schema.
 * Source tables:
 *   visits                   ← @MRO_OVST (88 rows)
 *   task_types               ← @MRO_OTAT (60 rows — AD/SB, EOAS, OOP, Kardex, Others, Checks…)
 *   task_activity_types      ← @MRO_OATY (27 rows — OVH, INSP, REMOVE…)
 *   mel_categories           ← @MRO_OCML (5 rows — MEL A/B/C/D, CFD)
 *   technical_log_types      ← @MRO_OTLT (6 rows)
 *   workflow_groups          ← @MRO_OWFG (1 row)
 *   aircraft_variants        ← @MRO_OVAR (2 rows — AW139, AW189)
 *   category_parts           ← @MRO_OCAT (16 rows — H/T LLP, Engine L/R, APU, PFD/MFD)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('task_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('task_activity_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('mel_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('short_id', 4)->nullable();
            $table->string('description', 100)->nullable();
            $table->unsignedInteger('duration_days')->default(0);
            $table->boolean('only_one')->default(false);
            $table->timestamps();
        });

        Schema::create('technical_log_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('workflow_groups', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('aircraft_variants', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('interface_code')->nullable();
            $table->string('ipc_code')->nullable();
            $table->unsignedSmallInteger('hierarchy')->default(1);
            $table->boolean('is_inactive')->default(false);
            $table->timestamps();
        });

        Schema::create('category_parts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->boolean('work_scope')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_parts');
        Schema::dropIfExists('aircraft_variants');
        Schema::dropIfExists('workflow_groups');
        Schema::dropIfExists('technical_log_types');
        Schema::dropIfExists('mel_categories');
        Schema::dropIfExists('task_activity_types');
        Schema::dropIfExists('task_types');
        Schema::dropIfExists('visits');
    }
};
