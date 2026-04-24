<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Non-enforcing morph map — aliases subjects to short strings without
        // forcing every polymorphic relation in the app to declare one.
        Relation::morphMap([
            'user' => User::class,
            'user_group' => UserGroup::class,
        ]);
    }
}
