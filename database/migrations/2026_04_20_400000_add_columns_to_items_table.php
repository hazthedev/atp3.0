<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('in_stock', 12, 2)->default(0)->after('description');
            $table->string('manufacturer')->nullable()->after('in_stock');
            $table->string('item_class')->nullable()->after('manufacturer');
            $table->string('calibration')->nullable()->after('item_class');
            $table->string('shelf_life')->nullable()->after('calibration');
            $table->string('sales_item')->default('Yes')->after('shelf_life');
            $table->string('manage_by_batch_serial')->default('Yes')->after('sales_item');
            $table->string('inventory_item')->default('Yes')->after('manage_by_batch_serial');
            $table->string('purchase_item')->default('Yes')->after('inventory_item');
            $table->string('item_group')->nullable()->after('purchase_item');
            $table->string('uom_group')->default('Manual')->after('item_group');
            $table->string('alternative_part')->nullable()->after('uom_group');
            $table->string('serial_no_management')->default('No')->after('alternative_part');
            $table->string('item_type')->default('Items')->after('serial_no_management');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn([
                'in_stock', 'manufacturer', 'item_class', 'calibration', 'shelf_life',
                'sales_item', 'manage_by_batch_serial', 'inventory_item', 'purchase_item',
                'item_group', 'uom_group', 'alternative_part', 'serial_no_management', 'item_type',
            ]);
        });
    }
};
