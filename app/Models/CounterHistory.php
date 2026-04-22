<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CounterHistory extends Model
{
    protected $table = 'counter_history';

    protected $fillable = [
        'counter_ref_id',
        'subject_type',
        'subject_id',
        'previous_value_dec',
        'previous_value_hhmm',
        'new_value_dec',
        'new_value_hhmm',
        'delta_dec',
        'reading_date',
        'reading_hour',
        'info_source',
        'counter_info_source_id',
        'source_type',
        'source_ref',
        'user_id',
        'note',
    ];

    protected $casts = [
        'counter_ref_id' => 'integer',
        'subject_id' => 'integer',
        'counter_info_source_id' => 'integer',
        'user_id' => 'integer',
        'reading_date' => 'date',
        'previous_value_dec' => 'float',
        'new_value_dec' => 'float',
        'delta_dec' => 'float',
    ];

    public function counterRef(): BelongsTo
    {
        return $this->belongsTo(CounterRef::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
