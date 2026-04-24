<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class ItemGroup extends Model
{
    public const VALUATION_FIFO = 'FIFO';

    public const VALUATION_MOVING_AVERAGE = 'Moving Average';

    public const VALUATION_STANDARD = 'Standard';

    /** @var array<int, string> */
    public const VALUATION_METHODS = [
        self::VALUATION_FIFO,
        self::VALUATION_MOVING_AVERAGE,
        self::VALUATION_STANDARD,
    ];

    protected $fillable = [
        'name',
        'default_uom_group',
        'lead_time_days',
        'default_valuation_method',
    ];

    protected $casts = [
        'lead_time_days' => 'integer',
    ];

    public function warehouseDefaults(): BelongsToMany
    {
        return $this->belongsToMany(Warehouse::class, 'item_group_warehouse_defaults')
            ->withPivot(['default_bin_location', 'enforce_default_bin_location'])
            ->withTimestamps();
    }

    public function glAccountAssignments(): MorphMany
    {
        return $this->morphMany(GlAccountAssignment::class, 'assignable');
    }
}
