<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket; // <--- PENTING: Import Model Ticket
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // --- 1. MENAMPILKAN DAFTAR EVENT ---
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            // Admin melihat semua event
            $events = Event::latest()->get(); 
            return view('admin.events.index', compact('events')); 
        } else {
            // Organizer hanya melihat event miliknya
            $events = Event::where('organizer_id', $user->id)->latest()->get();
            // Pastikan mengarah ke view organizer
            return view('organizer.events.index', compact('events')); 
        }
    }

    // --- 2. FORM CREATE ---
    public function create()
    {
        // Pisahkan view agar form action-nya benar (admin vs organizer)
        if (Auth::user()->role === 'admin') {
            return view('admin.events.create');
        } else {
            return view('organizer.events.create'); 
        }
    }

    // --- 3. PROSES SIMPAN (EVENT + TIKET OTOMATIS) ---
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            // Event
            'name' => 'required|string|max:255',
            'description' => 'required',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'location' => 'required',
            'category' => 'required',
            'image' => 'required|image|max:2048',
            
            // Tiket (Perhatikan tanda bintang *)
            'tickets' => 'required|array|min:1', // Wajib ada minimal 1 tiket
            'tickets.*.name' => 'required|string',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quota' => 'required|integer|min:1',
        ]);

        // 2. Upload Gambar
        $imagePath = $request->file('image')->store('event_images', 'public');

        // 3. Simpan Event
        $event = Event::create([
            'organizer_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'event_date' => $request->event_date,
            'event_time' => $request->event_time,
            'location' => $request->location,
            'category' => $request->category,
            'image' => $imagePath,
        ]);

        // 4. LOOPING Simpan Banyak Tiket
        foreach ($request->tickets as $ticketData) {
            Ticket::create([
                'event_id' => $event->id,
                'name' => $ticketData['name'],
                'price' => $ticketData['price'],
                'quota' => $ticketData['quota'],
                'description' => $ticketData['description'] ?? null,
            ]);
        }

        // 5. Redirect
        if(Auth::user()->role == 'admin') {
            return redirect()->route('admin.events.index')->with('success', 'Event dan Tiket berhasil dibuat!');
        }
        
        return redirect()->route('organizer.events.index')->with('success', 'Event dan Tiket berhasil dibuat!');
    }
    
    // --- 4. FORM EDIT ---
    public function edit(Event $event)
    {
        // Security Check: Organizer tidak boleh edit punya orang lain
        if (Auth::user()->role !== 'admin' && $event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (Auth::user()->role === 'admin') {
            return view('admin.events.edit', compact('event'));
        } else {
            return view('organizer.events.edit', compact('event'));
        }
    }

    // --- 5. PROSES UPDATE ---
    public function update(Request $request, Event $event)
    {
        // A. Security Check
        if (Auth::user()->role !== 'admin' && $event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // B. Validasi
        $request->validate([
            // Validasi Event
            'name' => 'required',
            'description' => 'required',
            'location' => 'required',
            
            // Validasi Array Tiket (Optional, jika ada yang diedit)
            'tickets' => 'nullable|array',
            'tickets.*.name' => 'required|string',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quota' => 'required|integer|min:0',
        ]);

        $data = $request->all();

        // C. Update Gambar Event (Jika ada)
        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            $data['image'] = $request->file('image')->store('event_images', 'public');
        }

        // D. Update Data Event
        $event->update($data);

        // E. Update Data Tiket (LOOPING)
        if ($request->has('tickets')) {
            foreach ($request->tickets as $ticketId => $ticketData) {
                // Cari tiket berdasarkan ID dan pastikan milik event ini (Security)
                $ticket = Ticket::where('id', $ticketId)->where('event_id', $event->id)->first();
                
                if ($ticket) {
                    $ticket->update([
                        'name' => $ticketData['name'],
                        'price' => $ticketData['price'],
                        'quota' => $ticketData['quota'],
                        'description' => $ticketData['description'] ?? null,
                    ]);
                }
            }
        }

        // F. Redirect
        if(Auth::user()->role == 'admin') {
            return redirect()->route('admin.events.index')->with('success', 'Event dan Tiket berhasil diperbarui!');
        }

        return redirect()->route('organizer.events.index')->with('success', 'Event dan Tiket berhasil diperbarui!');
    }

    // --- 6. HAPUS EVENT ---
    public function destroy(Event $event)
    {
        // Security Check
        if (Auth::user()->role !== 'admin' && $event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }
        
        $event->delete();
        
        return redirect()->back()->with('success', 'Event dihapus!');
    }
}