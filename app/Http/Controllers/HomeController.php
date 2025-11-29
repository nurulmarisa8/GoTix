<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        // 1. Pencarian & Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        // 2. Filter Tanggal (Hanya event masa depan)
        $query->whereDate('event_date', '>=', now());

        // 3. LOGIKA SORTING (Favorit di Atas)
        if (Auth::check()) {
            // Hitung apakah user ini melike event tersebut (hasilnya 1 atau 0)
            $query->withCount(['favoritedBy as is_favorited' => function ($q) {
                $q->where('user_id', Auth::id());
            }]);

            // Urutkan: Yang dilike (1) duluan, baru tanggal
            $query->orderByDesc('is_favorited')->orderBy('event_date', 'asc');
        } else {
            $query->orderBy('event_date', 'asc');
        }

        $events = $query->get();

        return view('home', compact('events'));
    }

    public function detail($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        return view('event_detail', compact('event'));
    }

    public function toggleFavorite($id)
    {
        $event = Event::findOrFail($id);
        Auth::user()->favorites()->toggle($id);
        
        // Redirect kembali tanpa pesan flash agar tidak mengganggu UI
        return redirect()->back();
    }
}