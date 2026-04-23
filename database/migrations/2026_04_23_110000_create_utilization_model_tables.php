<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * utilization_models           ← @MRO_OUTM (22 A/C registrations: 9M-WAA, 9M-WAD, 9M-WSV…)
 * utilization_model_rates      ← @MRO_UTM2 (per-A/C × measure-unit × month values)
 *
 * The rates table drives the Fleet Synthesis "Due Date" calculation
 * (hours/cycles → date conversion, spec Notes 4.1–4.3).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilization_models', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('registration'); // e.g. 9M-WAA — same as Name in SAP
            $table->timestamps();
        });

        Schema::create('utilization_model_rates', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('utilization_model_code'); // FK → utilization_models.code
            $table->string('measure_unit_code'); // FK → measure_units.code
            $table->unsignedInteger('jan')->default(0);
            $table->unsignedInteger('feb')->default(0);
            $table->unsignedInteger('mar')->default(0);
            $table->unsignedInteger('apr')->default(0);
            $table->unsignedInteger('may')->default(0);
            $table->unsignedInteger('jun')->default(0);
            $table->unsignedInteger('jul')->default(0);
            $table->unsignedInteger('aug')->default(0);
            $table->unsignedInteger('sep')->default(0);
            $table->unsignedInteger('oct')->default(0);
            $table->unsignedInteger('nov')->default(0);
            $table->unsignedInteger('dec')->default(0);
            $table->timestamps();

            $table->index('utilization_model_code');
            $table->index('measure_unit_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilization_model_rates');
        Schema::dropIfExists('utilization_models');
    }
};
