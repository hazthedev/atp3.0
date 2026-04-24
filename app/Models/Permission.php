<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Permission extends Model
{
    protected $fillable = [
        'code',
        'name',
        'parent_id',
        'sort_order',
    ];

    protected $casts = [
        'parent_id' => 'integer',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Permission::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    public function descendantsAndSelf(): \Illuminate\Support\Collection
    {
        $collected = collect([$this]);

        foreach ($this->children as $child) {
            $collected = $collected->merge($child->descendantsAndSelf());
        }

        return $collected;
    }
}
