<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penalty_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penalty_id')->constrained()->cascadeOnDelete();
            $table->string('subject_type');
            $table->unsignedBigInteger('subject_id');
            $table->foreignId('target_item_id')->nullable()->constrained('items')->cascadeOnDelete();
            $table->foreignId('monitoring_counter_ref_id')->constrained('counter_refs')->cascadeOnDelete();
            $table->decimal('rate_value', 15, 4)->default(0);
            $table->foreignId('rate_counter_ref_id')->nullable()->constrained('counter_refs')->nullOnDelete();
            $table->decimal('static_value', 15, 4)->default(0);
            $table->foreignId('static_counter_ref_id')->nullable()->constrained('counter_refs')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['subject_type', 'subject_id'], 'penalty_rules_subject_idx');
            $table->index('monitoring_counter_ref_id', 'penalty_rules_monitor_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penalty_rules');
    }
};
