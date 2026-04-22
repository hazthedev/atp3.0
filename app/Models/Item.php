<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    protected $fillable = [
        'code',
        'description',
        'in_stock',
        'manufacturer',
        'item_class',
        'calibration',
        'shelf_life',
        'sales_item',
        'manage_by_batch_serial',
        'inventory_item',
        'purchase_item',
        'item_group',
        'uom_group',
        'alternative_part',
        'serial_no_management',
        'item_type',
    ];

    protected $casts = [
        'in_stock' => 'float',
    ];

    public function counters(): HasMany
    {
        return $this->hasMany(ItemCounter::class);
    }

    public function calendarCounter(): HasOne
    {
        return $this->hasOne(ItemCalendarCounter::class);
    }
}
