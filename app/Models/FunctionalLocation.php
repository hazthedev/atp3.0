<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FunctionalLocation extends Model
{
    protected $fillable = [
        'code',
        'serial_no',
        'registration',
        'type',
        'mel',
        'status',
        'maintenance_plan',
        'owner_code',
        'owner_name',
        'operator_code',
        'operator_name',
        'item_id',
    ];

    protected $casts = [
        'item_id' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    public function counters(): HasMany
    {
        return $this->hasMany(FunctionalLocationCounter::class);
    }

    public function calendarCounter(): HasOne
    {
        return $this->hasOne(FunctionalLocationCalendarCounter::class);
    }
}
