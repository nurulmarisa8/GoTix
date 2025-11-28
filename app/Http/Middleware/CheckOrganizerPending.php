<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganizerPending
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // If user is organizer and has pending status, redirect to pending page
            // Excluding the pending page itself to avoid redirect loops
            if ($user->role === 'organizer' && $user->organizer_status === 'pending' &&
                !$request->routeIs('pending')) {
                return redirect()->route('pending');
            }
        }

        return $next($request);
    }
}
