<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterInfoSource extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
    ];
}
