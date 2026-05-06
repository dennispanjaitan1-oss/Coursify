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
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!in_array(auth()->user()->role, $roles)) {
            abort(403, 'Kamu tidak memiliki akses ke halaman ini.');
        } 
        

        return $next($request);
    }
}

// Daftarkan di bootstrap/app.php:
// ->withMiddleware(function (Middleware $middleware) {
//     $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);
// })
