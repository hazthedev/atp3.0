<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counter_refs', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('status')->default('Validate');
            $table->string('measure_unit')->nullable();
            $table->unsignedSmallInteger('incr_decr')->nullable();
            $table->unsignedSmallInteger('allow_incr_decr')->nullable();
            $table->string('min_value')->nullable();
            $table->string('max_value')->nullable();
            $table->string('initial_value')->nullable();
            $table->unsignedSmallInteger('propagation_flag')->nullable();
            $table->unsignedSmallInteger('used_for_residual_calc')->nullable();
            $table->unsignedSmallInteger('allow_auto_incrementation')->nullable();
            $table->unsignedSmallInteger('orange_light_limit')->default(90);
            $table->unsignedSmallInteger('sort_order')->nullable();
            $table->unsignedSmallInteger('log_instance')->nullable();
            $table->string('linked_counter')->nullable();
            $table->unsignedSmallInteger('propagation_on_linked_counter')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counter_refs');
    }
};
