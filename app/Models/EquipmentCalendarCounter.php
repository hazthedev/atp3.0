<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EquipmentCalendarCounter extends Model
{
    protected $fillable = [
        'equipment_id',
        'label',
        'value_date',
        'limit',
        'remaining',
        'residual',
        'info_source',
        'is_used',
        'reset_to_null',
    ];

    protected $casts = [
        'value_date' => 'date',
        'is_used' => 'boolean',
        'reset_to_null' => 'boolean',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
