<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('equipment_no')->nullable();
            $table->string('serial_number')->unique();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();
            $table->string('category_part')->nullable();
            $table->string('variant')->nullable();
            $table->string('status')->default('On Aircraft');
            $table->string('owner_code')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('operator_code')->nullable();
            $table->string('operator_name')->nullable();
            $table->string('maintenance_plan')->nullable();
            $table->string('mel')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
