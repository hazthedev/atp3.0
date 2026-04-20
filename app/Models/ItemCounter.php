<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemCounter extends Model
{
    protected $fillable = [
        'item_id',
        'counter_ref_id',
        'max_value_dec',
        'max_value_hhmm',
        'tolerance_dec',
        'tolerance_hhmm',
        'orange_light_percent',
        'status',
        'modif_ref',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function counterRef(): BelongsTo
    {
        return $this->belongsTo(CounterRef::class);
    }
}
