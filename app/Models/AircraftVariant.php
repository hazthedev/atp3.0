<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AircraftVariant extends Model
{
    protected $fillable = [
        'code',
        'name',
        'interface_code',
        'ipc_code',
        'hierarchy',
        'is_inactive',
    ];

    protected $casts = [
        'hierarchy' => 'integer',
        'is_inactive' => 'boolean',
    ];
}
