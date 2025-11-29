<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan Halaman Home (Katalog Event)
     */
    public function index(Request $request)
    {
        // 1. Definisikan Logika Filter (Agar bisa dipakai untuk Query Favorit & Query Biasa)
        $applyFilter = function($query) use ($request) {
            // Filter Pencarian (Nama atau Lokasi)
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('location', 'like', '%' . $search . '%');
                });
            }

            // Filter Kategori
            if ($request->filled('category') && $request->category !== 'All') {
                $query->where('category', $request->category);
            }

            // Filter Tanggal (Hanya tampilkan event yang belum lewat)
            $query->whereDate('event_date', '>=', now());
        };

        // 2. Ambil Data FAVORIT (Hanya jika user login)
        $favorites = collect(); // Default koleksi kosong jika belum login
        
        if (Auth::check()) {
            $favQuery = Auth::user()->favorites(); // Ambil dari relasi favorites di Model User
            $applyFilter($favQuery); // Terapkan filter pencarian ke list favorit juga
            $favorites = $favQuery->orderBy('event_date', 'asc')->get();
        }

        // 3. Ambil Data UPCOMING (Event Sisanya)
        $eventQuery = Event::query();
        $applyFilter($eventQuery); // Terapkan filter yang sama
        
        // PENTING: Cegah Duplikasi
        // Jika user login, jangan ambil event yang ID-nya sudah ada di list favorites
        if (Auth::check()) {
            $eventQuery->whereNotIn('id', $favorites->pluck('id'));
        }
        
        $events = $eventQuery->orderBy('event_date', 'asc')->get();

        // Kirim dua variabel ke View: favorites dan events
        return view('home', compact('events', 'favorites'));
    }

    /**
     * Menampilkan Halaman Detail Event
     */
    public function detail($id)
    {
        // Ambil event beserta tiketnya
        $event = Event::with('tickets')->findOrFail($id);
        return view('event_detail', compact('event'));
    }

    /**
     * Fitur Like / Unlike Event
     */
    public function toggleFavorite($id)
    {
        $event = Event::findOrFail($id);
        
        // Fungsi toggle() otomatis menambah jika belum ada, menghapus jika sudah ada
        Auth::user()->favorites()->toggle($id);

        // Redirect back (biasanya ditambah anchor #section-favorit di form view)
        return redirect()->back();
    }
}