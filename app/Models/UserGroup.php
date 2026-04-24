<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserGroup extends Model
{
    public const TYPE_AUTHORIZATION = 'Authorization';

    public const TYPE_ALERTS = 'Alerts';

    public const TYPE_FORM_SETTINGS = 'Form Settings';

    public const TYPE_UI_CONFIG = 'UI Configuration Templates';

    public const GROUP_TYPES = [
        self::TYPE_AUTHORIZATION,
        self::TYPE_ALERTS,
        self::TYPE_FORM_SETTINGS,
        self::TYPE_UI_CONFIG,
    ];

    protected $fillable = [
        'name',
        'description',
        'group_type',
        'active_from',
        'active_to',
    ];

    protected $casts = [
        'active_from' => 'date',
        'active_to' => 'date',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_group_user')
            ->withPivot(['from_date', 'to_date'])
            ->withTimestamps();
    }

    public function authorizations()
    {
        return $this->morphMany(Authorization::class, 'subject');
    }
}
