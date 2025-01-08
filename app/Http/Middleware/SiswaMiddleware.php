<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Pastikan ini ada
use Symfony\Component\HttpFoundation\Response;

class SiswaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('siswas')->check()) {
            return $next($request);
        }

        return redirect('/loginsiswa')->with('error', 'Silakan login sebagai siswa.');
    }
}
