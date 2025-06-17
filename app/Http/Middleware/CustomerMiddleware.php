<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('warning', 'Администраторам недоступен покупательский раздел');
        }

        return $next($request);
    }
}
