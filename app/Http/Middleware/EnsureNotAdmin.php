<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureNotAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            // Разрешаем доступ к страницам профиля
            if ($request->routeIs('profile.*')) {
                return $next($request);
            }
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}
