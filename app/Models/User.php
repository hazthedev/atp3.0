<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_code',
        'name',
        'email',
        'role',
        'password',
        'defaults',
        'is_superuser',
        'is_mobile_user',
        'is_group',
        'ms_windows_account',
        'employee',
        'mobile_phone',
        'mobile_device_id',
        'fax',
        'branch',
        'department',
        'password_never_expires',
        'change_password_next_logon',
        'is_locked',
        'enable_integration_packages',
        'services',
        'display',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_superuser' => 'boolean',
            'is_mobile_user' => 'boolean',
            'is_group' => 'boolean',
            'password_never_expires' => 'boolean',
            'change_password_next_logon' => 'boolean',
            'is_locked' => 'boolean',
            'enable_integration_packages' => 'boolean',
            'services' => 'array',
            'display' => 'array',
            'last_login_at' => 'datetime',
        ];
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(UserGroup::class, 'user_group_user')
            ->withPivot(['from_date', 'to_date'])
            ->withTimestamps();
    }

    public function authorizations()
    {
        return $this->morphMany(Authorization::class, 'subject');
    }
}
