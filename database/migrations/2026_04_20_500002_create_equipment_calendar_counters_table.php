<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_calendar_counters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('label')->default('Calendar Limit');
            $table->date('value_date')->nullable();
            $table->string('limit')->nullable();
            $table->string('remaining')->nullable();
            $table->string('residual')->nullable();
            $table->string('info_source')->nullable();
            $table->boolean('is_used')->default(false);
            $table->boolean('reset_to_null')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_calendar_counters');
    }
};
