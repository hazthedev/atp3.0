<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'equipment_no',
        'serial_number',
        'item_id',
        'category_part',
        'variant',
        'status',
        'owner_code',
        'owner_name',
        'operator_code',
        'operator_name',
        'maintenance_plan',
        'mel',
        'chapter',
        'section',
        'subject',
        'sheet',
        'mark',
        'mel_item',
        'remark_text',
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
        return $this->hasMany(EquipmentCounter::class);
    }

    public function calendarCounter(): HasOne
    {
        return $this->hasOne(EquipmentCalendarCounter::class);
    }
}
