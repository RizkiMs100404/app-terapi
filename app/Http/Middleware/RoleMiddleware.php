<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // 1. Cek dulu apakah sudah login dan rolenya sesuai
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // 2. Lanjutkan permintaan
        $response = $next($request);

        // 3. Tambahkan Header Keamanan (Cegah Back Browser)
        // Ini yang bikin tombol panah kembali di atas gak bakal nampilin dashboard lagi setelah logout
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Sun, 02 Jan 1990 00:00:00 GMT');
    }
}
