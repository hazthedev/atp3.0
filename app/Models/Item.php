<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    protected $fillable = ['code', 'description'];

    public function counters(): HasMany
    {
        return $this->hasMany(ItemCounter::class);
    }

    public function calendarCounter(): HasOne
    {
        return $this->hasOne(ItemCalendarCounter::class);
    }
}
