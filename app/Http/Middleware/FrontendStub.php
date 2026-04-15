<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendStub
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (! $request->routeIs('login', 'register') && ! Auth::check()) {
            $fake = new User([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'role' => 'admin',
            ]);

            $fake->id = 1;

            Auth::setUser($fake);
        }

        return $next($request);
    }
}
