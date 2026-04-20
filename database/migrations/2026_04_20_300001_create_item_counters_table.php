<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_counters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('counter_ref_id')->constrained()->cascadeOnDelete();
            $table->string('max_value_dec')->nullable();
            $table->string('max_value_hhmm')->nullable();
            $table->string('tolerance_dec')->nullable();
            $table->string('tolerance_hhmm')->nullable();
            $table->unsignedSmallInteger('orange_light_percent')->default(90);
            $table->string('status')->default('Validate');
            $table->string('modif_ref')->nullable();
            $table->timestamps();

            $table->unique(['item_id', 'counter_ref_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_counters');
    }
};
