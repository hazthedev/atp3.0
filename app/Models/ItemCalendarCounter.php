<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemCalendarCounter extends Model
{
    protected $fillable = [
        'item_id',
        'label',
        'limit_days',
        'orange_light_days',
        'status',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
