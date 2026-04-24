<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Authorization extends Model
{
    public const LEVEL_FULL = 'full';

    public const LEVEL_READ_ONLY = 'read_only';

    public const LEVEL_NONE = 'none';

    public const LEVELS = [
        self::LEVEL_FULL,
        self::LEVEL_READ_ONLY,
        self::LEVEL_NONE,
    ];

    protected $fillable = [
        'subject_type',
        'subject_id',
        'permission_id',
        'level',
    ];

    protected $casts = [
        'subject_id' => 'integer',
        'permission_id' => 'integer',
    ];

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class);
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }
}
