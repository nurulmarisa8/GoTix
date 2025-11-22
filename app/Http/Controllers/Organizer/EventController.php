<?php
// app/Http/Controllers/Organizer/EventController.php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /** Tampilkan daftar acara milik Organizer saat ini[cite: 579]. */
    public function index() {
        $events = Event::where('organizer_id', Auth::id())->paginate(10);
        return view('organizer.events.index', compact('events'));
    }

    // ... create, store, edit, update methods ...
    
    /** Hapus acara. */
    public function destroy(Event $event) {
        // Organizer tidak dapat mengedit atau menghapus acara milik organizer lain [cite: 580]
        if ($event->organizer_id !== Auth::id()) {
            abort(403, 'Akses Ditolak.'); 
        }
        // Hapus tiket dan booking terkait
        $event->delete(); 
        return redirect()->route('organizer.events.index')->with('success', 'Acara berhasil dihapus.');
    }
}