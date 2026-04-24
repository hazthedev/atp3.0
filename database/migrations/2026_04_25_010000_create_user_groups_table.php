<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('group_type')->default('Authorization');
            $table->date('active_from')->nullable();
            $table->date('active_to')->nullable();
            $table->timestamps();

            $table->unique(['name', 'group_type'], 'user_groups_name_type_unique');
            $table->index('group_type');
        });

        Schema::create('user_group_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->timestamps();

            $table->unique(['user_group_id', 'user_id'], 'ugu_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_group_user');
        Schema::dropIfExists('user_groups');
    }
};
