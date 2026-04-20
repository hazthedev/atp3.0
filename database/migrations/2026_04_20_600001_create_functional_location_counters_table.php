<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('functional_location_counters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('functional_location_id')->constrained()->cascadeOnDelete();
            $table->foreignId('counter_ref_id')->constrained()->cascadeOnDelete();
            $table->decimal('value_dec', 15, 4)->nullable();
            $table->string('value_hhmm')->nullable();
            $table->date('reading_date')->nullable();
            $table->string('reading_hour')->default('00:00');
            $table->decimal('max_dec', 15, 4)->nullable();
            $table->string('max_hhmm')->nullable();
            $table->string('remaining')->nullable();
            $table->string('residual')->nullable();
            $table->string('linked_equi_id')->nullable();
            $table->string('info_source')->nullable();
            $table->string('tone')->default('green');
            $table->boolean('propagate')->default(true);
            $table->boolean('is_used')->default(true);
            $table->timestamps();

            $table->unique(['functional_location_id', 'counter_ref_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('functional_location_counters');
    }
};
