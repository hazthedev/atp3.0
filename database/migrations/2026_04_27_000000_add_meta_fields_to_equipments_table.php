<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipments', function (Blueprint $table): void {
            $table->string('chapter', 8)->nullable()->after('mel');
            $table->string('section', 8)->nullable()->after('chapter');
            $table->string('subject', 8)->nullable()->after('section');
            $table->string('sheet', 8)->nullable()->after('subject');
            $table->string('mark', 8)->nullable()->after('sheet');
            $table->string('mel_item', 32)->nullable()->after('mark');
        });
    }

    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table): void {
            $table->dropColumn(['chapter', 'section', 'subject', 'sheet', 'mark', 'mel_item']);
        });
    }
};
