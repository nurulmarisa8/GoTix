<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;



class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                
                // --- PERBAIKAN: Redirect Sesuai Role ---
                $user = Auth::user();

                if ($user->role === 'admin') {
                    return redirect()->route('admin.dashboard');
                } 
                elseif ($user->role === 'organizer') {
                    return redirect()->route('organizer.dashboard');
                } 
                else {
                    return redirect()->route('home');
                }
                // ---------------------------------------
            }
        }

        return $next($request);
}
}