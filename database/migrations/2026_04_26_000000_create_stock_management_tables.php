<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gl_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('item_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('default_uom_group')->nullable();
            $table->unsignedInteger('lead_time_days')->nullable();
            $table->string('default_valuation_method', 32)->default('FIFO');
            $table->timestamps();
        });

        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->boolean('inactive')->default(false);
            $table->boolean('drop_ship')->default(false);
            $table->string('location')->nullable();
            $table->boolean('nettable')->default(true);
            $table->boolean('issue_part_for_maintenance')->default(false);
            $table->boolean('enable_bin_locations')->default(false);
            $table->string('street_po_box')->nullable();
            $table->string('street_no')->nullable();
            $table->string('block')->nullable();
            $table->string('building_floor_room')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('city')->nullable();
            $table->string('county')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('federal_tax_id')->nullable();
            $table->string('gln')->nullable();
            $table->string('tax_office')->nullable();
            $table->string('address_name_2')->nullable();
            $table->string('address_name_3')->nullable();
            $table->timestamps();
        });

        Schema::create('item_group_warehouse_defaults', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained()->cascadeOnDelete();
            $table->string('default_bin_location')->nullable();
            $table->boolean('enforce_default_bin_location')->default(false);
            $table->timestamps();

            $table->unique(['item_group_id', 'warehouse_id'], 'igwd_unique');
        });

        Schema::create('gl_account_assignments', function (Blueprint $table) {
            $table->id();
            $table->morphs('assignable');
            $table->string('account_type_key', 64);
            $table->foreignId('gl_account_id')->nullable()->constrained('gl_accounts')->nullOnDelete();
            $table->timestamps();

            $table->unique(['assignable_type', 'assignable_id', 'account_type_key'], 'gl_assignments_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gl_account_assignments');
        Schema::dropIfExists('item_group_warehouse_defaults');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('item_groups');
        Schema::dropIfExists('gl_accounts');
    }
};
