<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in first.');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'You do not have access to this page.');
        }
        

        return $next($request);
    }
}

// Daftarkan di bootstrap/app.php:
// ->withMiddleware(function (Middleware $middleware) {
//     $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);
// })
