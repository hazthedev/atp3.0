<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PenaltyRule extends Model
{
    protected $fillable = [
        'penalty_id',
        'subject_type',
        'subject_id',
        'target_item_id',
        'monitoring_counter_ref_id',
        'rate_value',
        'rate_counter_ref_id',
        'static_value',
        'static_counter_ref_id',
        'is_active',
    ];

    protected $casts = [
        'penalty_id' => 'integer',
        'subject_id' => 'integer',
        'target_item_id' => 'integer',
        'monitoring_counter_ref_id' => 'integer',
        'rate_counter_ref_id' => 'integer',
        'static_counter_ref_id' => 'integer',
        'rate_value' => 'float',
        'static_value' => 'float',
        'is_active' => 'boolean',
    ];

    public function penalty(): BelongsTo
    {
        return $this->belongsTo(Penalty::class);
    }

    public function targetItem(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'target_item_id');
    }

    public function monitoringCounterRef(): BelongsTo
    {
        return $this->belongsTo(CounterRef::class, 'monitoring_counter_ref_id');
    }

    public function rateCounterRef(): BelongsTo
    {
        return $this->belongsTo(CounterRef::class, 'rate_counter_ref_id');
    }

    public function staticCounterRef(): BelongsTo
    {
        return $this->belongsTo(CounterRef::class, 'static_counter_ref_id');
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
