<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counter_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counter_ref_id')->constrained()->cascadeOnDelete();
            $table->string('subject_type');
            $table->unsignedBigInteger('subject_id');
            $table->decimal('previous_value_dec', 15, 4)->nullable();
            $table->string('previous_value_hhmm')->nullable();
            $table->decimal('new_value_dec', 15, 4)->nullable();
            $table->string('new_value_hhmm')->nullable();
            $table->decimal('delta_dec', 15, 4)->nullable();
            $table->date('reading_date')->nullable();
            $table->string('reading_hour')->default('00:00');
            $table->string('info_source')->nullable();
            $table->string('source_type');
            $table->string('source_ref')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(
                ['subject_type', 'subject_id', 'counter_ref_id', 'created_at'],
                'counter_hist_subject_ref_time_idx',
            );
            $table->index('created_at', 'counter_hist_created_at_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counter_history');
    }
};
