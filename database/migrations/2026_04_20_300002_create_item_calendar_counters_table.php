<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_calendar_counters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('label')->default('Calendar Limit');
            $table->unsignedSmallInteger('limit_days')->nullable();
            $table->unsignedSmallInteger('orange_light_days')->default(90);
            $table->string('status')->default('Validate');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_calendar_counters');
    }
};
