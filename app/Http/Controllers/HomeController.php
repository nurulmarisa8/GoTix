<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query
        $query = Event::query();

        // 2. Logika Pencarian (Berdasarkan Nama Event atau Lokasi)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');
            });
        }

        // 3. Logika Filter Kategori
        if ($request->filled('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        // 4. Ambil Data (Urutkan dari yang paling dekat tanggalnya)
        // Kita filter juga agar event yang sudah lewat tanggalnya tidak muncul
        $events = $query->whereDate('event_date', '>=', now())
                        ->orderBy('event_date', 'asc')
                        ->get();

        return view('home', compact('events'));
    }

    public function detail($id)
    {
        $event = Event::with('tickets')->findOrFail($id);
        return view('event_detail', compact('event'));
    }
}