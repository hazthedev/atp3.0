<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * work_orders ← @MRO_MOR2 → MORC (header + lines) summarised.
 *
 * SAP scatters Work Order data across MOR2, MOR3, MOR4, MOR8, MOR9,
 * MORA, MORB, MORC, plus the applied archives AMR4/AMR8. Here we
 * collapse just the fields surfaced by the Fleet Synthesis / MRO
 * list pages. Additional columns can be added incrementally.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('work_orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g. WO-23121
            $table->string('variant_code')->nullable(); // → aircraft_variants.code
            $table->string('aircraft_registration')->nullable();
            $table->string('status_code')->nullable(); // → mro_status_objects.code
            $table->string('work_package_code')->nullable(); // future work_packages.code
            $table->date('planned_date')->nullable();
            $table->date('released_date')->nullable();
            $table->date('closed_date')->nullable();
            $table->date('ric_date_in')->nullable(); // Date In from RIC, feeds Next Due
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('aircraft_registration');
            $table->index('status_code');
            $table->index('work_package_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('work_orders');
    }
};
