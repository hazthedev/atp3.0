<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FrontendStub
{
    private static ?User $stub = null;

    public function handle(Request $request, Closure $next): mixed
    {
        if (! $request->routeIs('login', 'register') && ! Auth::check()) {
            if (self::$stub === null) {
                self::$stub = User::firstOrCreate(
                    ['email' => 'test@example.com'],
                    [
                        'name' => 'Test User',
                        'role' => 'admin',
                        'password' => Hash::make(Str::random(40)),
                    ],
                );
                self::$stub->role = 'admin';
            }

            Auth::setUser(self::$stub);
        }

        return $next($request);
    }
}
