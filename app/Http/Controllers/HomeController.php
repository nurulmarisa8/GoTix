<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        // Fitur Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        // Ambil event terbaru
        $events = $query->orderBy('event_date', 'asc')->get();

        return view('home', compact('events'));
    }

    public function detail($id)
    {
        // Tampilkan detail event beserta tiket yang tersedia
        $event = Event::with('tickets')->findOrFail($id);
        return view('event_detail', compact('event'));
    }

    // Di HomeController atau UserControler
    public function destroy(Request $request) {
        $user = Auth::user();
        Auth::logout();
        $user->delete();
        return redirect('/')->with('success', 'Akun berhasil dihapus');
    }
}