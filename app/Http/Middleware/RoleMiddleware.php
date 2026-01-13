<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
   public function handle(Request $request, Closure $next, ...$roles): Response
{
    // Cek apakah user sudah login dan apakah rolenya ada di daftar yang diizinkan
    if (Auth::check() && in_array(Auth::user()->role, $roles)) {
        return $next($request);
    }
    
    // Jika tidak punya akses, lempar ke homepage dengan pesan error
    return redirect('/')->with('error', 'ngapain?');
}
}