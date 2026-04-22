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
        'tone',
        'propagate',
        'is_used',
    ];

    protected $casts = [
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
}
