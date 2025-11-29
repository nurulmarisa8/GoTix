<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // --- LOGIKA DIPERKETAT ---
        if ($user->role === 'organizer') {
            
            // 1. Jika Ditolak -> Halaman Rejected
            if ($user->organizer_status === 'rejected') {
                return redirect()->route('organizer.rejected');
            }

            // 2. Jika BUKAN Approved (Berarti Pending, Null, atau Error) -> Halaman Pending
            if ($user->organizer_status !== 'approved') {
                return redirect()->route('organizer.pending');
            }
        }
        // -------------------------

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        return abort(403, 'Unauthorized');
    }
}