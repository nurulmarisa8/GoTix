<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // 1. TAMPILKAN FORM & LIST TIKET
    public function create($eventId)
    {
        // Load event beserta tiket-tiketnya
        $event = Event::with('tickets')->findOrFail($eventId);

        // Security Check
        if (Auth::user()->role === 'organizer' && $event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Pisahkan View Admin & Organizer
        if (Auth::user()->role === 'admin') {
            return view('admin.tickets.create', compact('event'));
        } else {
            // Ini view yang akan kita update di langkah 3
            return view('organizer.tickets.create', compact('event')); 
        }
    }

    // 2. SIMPAN TIKET BARU
    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        Ticket::create([
            'event_id' => $eventId,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quota' => $request->quota,
        ]);

        // Redirect Balik agar bisa tambah lagi
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.events.tickets.create', $eventId)->with('success', 'Tiket berhasil ditambahkan!');
        }

        // Tetap di halaman create agar bisa tambah lagi
        return redirect()->route('organizer.events.tickets.create', $eventId)->with('success', 'Tiket berhasil ditambahkan!');
    }

    // 3. HAPUS TIKET
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Security Check
        if (Auth::user()->role === 'organizer' && $ticket->event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $ticket->delete();

        return redirect()->back()->with('success', 'Tiket berhasil dihapus!');
    }

    // --- EDIT TIKET (TAMPILKAN FORM) ---
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Security: Pastikan tiket ini milik event si organizer
        if (Auth::user()->role === 'organizer' && $ticket->event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('organizer.tickets.edit', compact('ticket'));
    }

    // --- UPDATE TIKET (SIMPAN PERUBAHAN) ---
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        // Security Check
        if (Auth::user()->role === 'organizer' && $ticket->event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'description' => 'nullable|string'
        ]);

        $ticket->update([
            'name' => $request->name,
            'price' => $request->price,
            'quota' => $request->quota,
            'description' => $request->description,
        ]);

        // Redirect kembali ke halaman "Kelola Tiket" agar alurnya enak
        return redirect()->route('organizer.events.tickets.create', $ticket->event_id)
                         ->with('success', 'Tiket berhasil diperbarui!');
    }
}