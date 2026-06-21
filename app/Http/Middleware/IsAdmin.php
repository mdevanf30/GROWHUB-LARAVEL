<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        if (!$user->isAdmin()) {
            $activeRole = session()->get('active_role', 'Freelancer');
            $redirectRoute = $activeRole === 'UMKM' ? 'umkm.dashboard' : 'dashboard_freelance';
            return redirect()->route($redirectRoute)->with('error', 'Anda tidak memiliki hak akses ke halaman Admin.');
        }

        return $next($request);
    }
}
