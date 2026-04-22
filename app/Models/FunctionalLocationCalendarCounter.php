<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FunctionalLocationCalendarCounter extends Model
{
    protected $fillable = [
        'functional_location_id',
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
        'functional_location_id' => 'integer',
        'value_date' => 'date',
        'is_used' => 'boolean',
        'reset_to_null' => 'boolean',
    ];

    public function functionalLocation(): BelongsTo
    {
        return $this->belongsTo(FunctionalLocation::class);
    }
}
