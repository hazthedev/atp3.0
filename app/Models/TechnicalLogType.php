<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalLogType extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];
}
