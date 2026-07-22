<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah session is_admin ada dan true
        if (session('is_admin') === true) {
            return $next($request);
        }
        return redirect('/login')->withErrors(['email' => 'Anda tidak memiliki akses admin!']);
    }
}