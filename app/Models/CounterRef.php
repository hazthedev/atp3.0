<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterRef extends Model
{
    protected $fillable = [
        'code',
        'name',
        'status',
        'measure_unit',
        'incr_decr',
        'allow_incr_decr',
        'min_value',
        'max_value',
        'initial_value',
        'propagation_flag',
        'used_for_residual_calc',
        'allow_auto_incrementation',
        'orange_light_limit',
        'sort_order',
        'log_instance',
        'linked_counter',
        'propagation_on_linked_counter',
    ];
}
