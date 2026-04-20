<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeasureUnit extends Model
{
    protected $fillable = [
        'code',
        'new_code',
        'designation',
    ];
}
