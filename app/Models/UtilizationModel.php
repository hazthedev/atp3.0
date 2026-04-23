<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UtilizationModel extends Model
{
    protected $fillable = [
        'code',
        'registration',
    ];

    public function rates(): HasMany
    {
        return $this->hasMany(UtilizationModelRate::class, 'utilization_model_code', 'code');
    }
}
