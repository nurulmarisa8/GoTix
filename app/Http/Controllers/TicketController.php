<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // --- 1. FORM TAMBAH TIKET (Hanya untuk Organizer) ---
    public function create($eventId)
    {
        $event = Event::with('tickets')->findOrFail($eventId);

        // Security Check: Organizer
        if (Auth::user()->role === 'organizer' && $event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Jika Admin tidak sengaja masuk sini, lempar ke Edit Event saja
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.events.edit', $eventId);
        }

        // Tampilkan View Khusus Organizer
        return view('organizer.tickets.create', compact('event')); 
    }

    // --- 2. PROSES SIMPAN TIKET (STORE) ---
    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        // Validasi
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1',
            'description' => 'nullable|string'
        ]);

        // Simpan ke Database
        Ticket::create([
            'event_id' => $eventId,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'quota' => $request->quota,
        ]);

        // --- REDIRECT (PERBAIKAN PENTING DISINI) ---
        
        // A. Jika ADMIN: Kembali ke halaman Edit Event (Karena halaman create ticket admin sudah dihapus)
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.events.edit', $eventId)->with('success', 'Tiket berhasil ditambahkan!');
        }

        // B. Jika ORGANIZER: Tetap di halaman Create Ticket (agar bisa tambah lagi dengan cepat)
        return redirect()->route('organizer.events.tickets.create', $eventId)->with('success', 'Tiket berhasil ditambahkan!');
    }

    // --- 3. FORM EDIT TIKET SPESIFIK (Organizer) ---
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Security Check
        if (Auth::user()->role === 'organizer' && $ticket->event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('organizer.tickets.edit', compact('ticket'));
    }

    // --- 4. PROSES UPDATE TIKET SPESIFIK ---
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

        // Redirect kembali ke halaman list tiket di "Create Ticket" page
        return redirect()->route('organizer.events.tickets.create', $ticket->event_id)
                         ->with('success', 'Tiket berhasil diperbarui!');
    }

    // --- 5. HAPUS TIKET ---
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $event = $ticket->event; // Simpan data event sebelum hapus tiket untuk redirect (jika perlu)

        // Security Check
        if (Auth::user()->role === 'organizer' && $event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $ticket->delete();

        return redirect()->back()->with('success', 'Tiket berhasil dihapus!');
    }
}