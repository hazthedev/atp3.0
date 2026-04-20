<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentCounter extends Model
{
    protected $fillable = [
        'equipment_id',
        'counter_ref_id',
        'value_dec',
        'value_hhmm',
        'reading_date',
        'reading_hour',
        'max_dec',
        'max_hhmm',
        'remaining',
        'residual',
        'linked_equi_id',
        'info_source',
        'propagate',
        'is_used',
    ];

    protected $casts = [
        'reading_date' => 'date',
        'propagate' => 'boolean',
        'is_used' => 'boolean',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function counterRef(): BelongsTo
    {
        return $this->belongsTo(CounterRef::class);
    }
}
