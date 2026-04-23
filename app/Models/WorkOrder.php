<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WorkOrder extends Model
{
    protected $fillable = [
        'code',
        'variant_code',
        'aircraft_registration',
        'status_code',
        'work_package_code',
        'planned_date',
        'released_date',
        'closed_date',
        'ric_date_in',
        'title',
        'description',
    ];

    protected $casts = [
        'planned_date' => 'date',
        'released_date' => 'date',
        'closed_date' => 'date',
        'ric_date_in' => 'date',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(MroStatusObject::class, 'status_code', 'code');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(AircraftVariant::class, 'variant_code', 'code');
    }

    public function technicalLogs(): HasMany
    {
        return $this->hasMany(TechnicalLog::class, 'work_order_code', 'code');
    }

    public function isClosed(): bool
    {
        return $this->status_code === '00000003';
    }

    public function isCancelled(): bool
    {
        return $this->status_code === '-0000003';
    }
}
