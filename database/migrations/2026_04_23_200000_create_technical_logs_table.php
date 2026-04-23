<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * technical_logs ← @MRO_OTLG (Technical Log / MEL / CFD)
 *
 * Drives the Fleet Synthesis MEL/CFD column:
 * rows with status = Deferred (@MRO_OSTA code '-0000021') + future deadline.
 *
 * Only a curated subset of the 60+ SAP columns is mapped — the ones the
 * Fleet Synthesis Details screen actually displays.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('technical_logs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('log_number'); // U_C_OFTR — the visible reference
            $table->string('aircraft_registration')->nullable(); // U_C_OFLC (e.g. 9M-WAA)
            $table->string('status_code')->nullable(); // → mro_status_objects.code
            $table->string('mel_category_code')->nullable(); // → mel_categories.code
            $table->string('mel_item_ref')->nullable();
            $table->string('ata_chapter')->nullable();
            $table->date('discovery_date')->nullable(); // U_DefDate
            $table->date('deadline_date')->nullable(); // U_DeadLine — Fleet Synthesis alarm driver
            $table->date('closure_date')->nullable(); // U_CDate
            $table->boolean('is_deferral')->default(false);
            $table->text('discovery_description')->nullable(); // U_Desc
            $table->text('workaround_description')->nullable(); // U_WDesc
            $table->text('corrective_description')->nullable(); // U_CDesc
            $table->string('work_order_code')->nullable(); // task list workaround link
            $table->string('serial_number')->nullable();
            $table->timestamps();

            $table->index('aircraft_registration');
            $table->index('status_code');
            $table->index('deadline_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('technical_logs');
    }
};
