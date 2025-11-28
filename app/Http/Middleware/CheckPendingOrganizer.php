<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPendingOrganizer
{

    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Only organizers with pending status can access this page
        if ($user->role !== 'organizer' || $user->organizer_status !== 'pending') {
            // If user is organizer but approved, redirect to dashboard
            if ($user->role === 'organizer' && $user->organizer_status === 'approved') {
                return redirect()->route('events.index');
            }
            // If user is organizer but rejected, redirect to home
            if ($user->role === 'organizer' && $user->organizer_status === 'rejected') {
                return redirect()->route('home');
            }
            // For all other users, redirect to home
            return redirect()->route('home');
        }

        return $next($request);
    }
}
