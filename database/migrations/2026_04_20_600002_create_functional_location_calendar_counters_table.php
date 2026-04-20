<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('functional_location_calendar_counters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('functional_location_id');
            $table->string('label')->default('Calendar Limit');
            $table->date('value_date')->nullable();
            $table->string('limit')->nullable();
            $table->string('remaining')->nullable();
            $table->string('residual')->nullable();
            $table->string('info_source')->nullable();
            $table->boolean('is_used')->default(false);
            $table->boolean('reset_to_null')->default(false);
            $table->timestamps();

            $table->unique('functional_location_id', 'fl_cal_counter_fl_id_unique');
            $table->foreign('functional_location_id', 'fl_cal_counter_fl_id_fk')
                ->references('id')
                ->on('functional_locations')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('functional_location_calendar_counters');
    }
};
