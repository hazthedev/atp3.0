<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('functional_location_counters', function (Blueprint $table) {
            $table->dropColumn('tone');
        });
    }

    public function down(): void
    {
        Schema::table('functional_location_counters', function (Blueprint $table) {
            $table->string('tone')->default('green')->after('info_source');
        });
    }
};
