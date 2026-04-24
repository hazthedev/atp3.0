<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->foreignId('parent_id')->nullable()->constrained('permissions')->nullOnDelete();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('parent_id');
        });

        Schema::create('authorizations', function (Blueprint $table) {
            $table->id();
            // polymorphic subject — 'user' or 'user_group'
            $table->string('subject_type');
            $table->unsignedBigInteger('subject_id');
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            // 'full' | 'read_only' | 'none'
            $table->string('level')->default('none');
            $table->timestamps();

            $table->unique(['subject_type', 'subject_id', 'permission_id'], 'auth_subject_perm_unique');
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authorizations');
        Schema::dropIfExists('permissions');
    }
};
