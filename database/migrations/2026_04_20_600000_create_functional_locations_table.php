<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('functional_locations', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('serial_no')->nullable();
            $table->string('registration')->nullable();
            $table->string('type')->nullable();
            $table->string('mel')->nullable();
            $table->string('status')->default('Airworthy');
            $table->string('maintenance_plan')->nullable();
            $table->string('owner_code')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('operator_code')->nullable();
            $table->string('operator_name')->nullable();
            $table->foreignId('item_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('functional_locations');
    }
};
