<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measure_units', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('new_code')->nullable();
            $table->string('designation');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measure_units');
    }
};
