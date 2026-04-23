<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TechnicalLog extends Model
{
    protected $fillable = [
        'code',
        'log_number',
        'aircraft_registration',
        'status_code',
        'mel_category_code',
        'mel_item_ref',
        'ata_chapter',
        'discovery_date',
        'deadline_date',
        'closure_date',
        'is_deferral',
        'discovery_description',
        'workaround_description',
        'corrective_description',
        'work_order_code',
        'serial_number',
    ];

    protected $casts = [
        'discovery_date' => 'date',
        'deadline_date' => 'date',
        'closure_date' => 'date',
        'is_deferral' => 'boolean',
    ];

    public function status(): BelongsTo
    {
        return $this->belongsTo(MroStatusObject::class, 'status_code', 'code');
    }

    public function melCategory(): BelongsTo
    {
        return $this->belongsTo(MelCategory::class, 'mel_category_code', 'code');
    }

    public function workOrder(): BelongsTo
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_code', 'code');
    }

    public function isDeferred(): bool
    {
        return $this->status_code === '-0000021';
    }

    public function isClosed(): bool
    {
        return $this->status_code === '00000003';
    }
}
