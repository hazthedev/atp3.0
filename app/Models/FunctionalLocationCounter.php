<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FunctionalLocationCounter extends Model
{
    protected $fillable = [
        'functional_location_id',
        'counter_ref_id',
        'value_dec',
        'value_hhmm',
        'reading_date',
        'reading_hour',
        'max_dec',
        'max_hhmm',
        'remaining',
        'residual',
        'linked_equipment_id',
        'info_source',
        'counter_info_source_id',
        'propagate',
        'is_used',
    ];

    protected $casts = [
        'functional_location_id' => 'integer',
        'counter_ref_id' => 'integer',
        'linked_equipment_id' => 'integer',
        'counter_info_source_id' => 'integer',
        'value_dec' => 'float',
        'max_dec' => 'float',
        'reading_date' => 'date',
        'propagate' => 'boolean',
        'is_used' => 'boolean',
    ];

    public function functionalLocation(): BelongsTo
    {
        return $this->belongsTo(FunctionalLocation::class);
    }

    public function counterRef(): BelongsTo
    {
        return $this->belongsTo(CounterRef::class);
    }

    public function getToneAttribute(): string
    {
        if (! $this->is_used) {
            return 'grey';
        }

        $value = $this->value_dec !== null ? (float) $this->value_dec : null;
        $max = $this->max_dec !== null ? (float) $this->max_dec : null;

        if ($value === null || $max === null || $max <= 0) {
            return 'green';
        }

        if ($value > $max) {
            return 'red';
        }

        $orangePercent = (int) ($this->counterRef?->orange_light_limit ?? 90);
        $orangeThreshold = $max * $orangePercent / 100;

        return $value > $orangeThreshold ? 'amber' : 'green';
    }
}
