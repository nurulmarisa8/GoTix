<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EventController extends Controller
{
    // --- 1. MENAMPILKAN DAFTAR EVENT ---
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $events = Event::latest()->get(); 
            return view('admin.events.index', compact('events')); 
        } else {
            $events = Event::where('organizer_id', $user->id)->latest()->get();
            return view('organizer.events.index', compact('events')); 
        }
    }

    // --- 2. FORM CREATE ---
    public function create()
    {
        if (Auth::user()->role === 'admin') {
            return view('admin.events.create');
        } else {
            return view('organizer.events.create'); 
        }
    }

    // --- 3. PROSES SIMPAN (STORE) ---
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            // Event Validation
            'name' => 'required|string|max:255|unique:events,name',
            'description' => 'required',
            'event_date' => 'required|date|after_or_equal:today',
            'event_time' => 'required',
            'location' => 'required|string',
            'category' => 'required',
            'image' => 'required|image|max:2048',
            
            // Ticket Validation (Array)
            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string',
            'tickets.*.price' => 'required|numeric|min:0',
            'tickets.*.quota' => 'required|integer|min:1',
        ], [
            'name.unique' => 'Nama event ini sudah digunakan. Mohon gunakan nama lain.',
            'event_date.after_or_equal' => 'Tanggal event tidak boleh di masa lalu.',
        ]);

        // 2. VALIDASI KHUSUS JAM (Cek jika tanggal hari ini, jam tidak boleh lewat)
        $eventDateTime = Carbon::parse($request->event_date . ' ' . $request->event_time);
        if ($eventDateTime->isPast()) {
            return back()
                ->withErrors(['event_time' => 'Waktu event sudah terlewat! Pilih jam di masa depan.'])
                ->withInput();
        
        }

        // 3. Upload Gambar
        $imagePath = $request->file('image')->store('event_images', 'public');

        // 4. Simpan Event
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

        // 5. Simpan Tiket (Looping Array)
        foreach ($request->tickets as $ticketData) {
            Ticket::create([
                'event_id' => $event->id,
                'name' => $ticketData['name'],
                'price' => $ticketData['price'],
                'quota' => $ticketData['quota'],
                'description' => $ticketData['description'] ?? null,
            ]);
        }

        // 6. Redirect
        if(Auth::user()->role == 'admin') {
            return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat!');
        }
        
        return redirect()->route('organizer.events.index')->with('success', 'Event berhasil dibuat!');
    }

    // --- 4. FORM EDIT ---
    public function edit(Event $event)
    {
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
        if (Auth::user()->role !== 'admin' && $event->organizer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|unique:events,name,' . $event->id, 
            'description' => 'required',
            'location' => 'required',
            'event_date' => 'required|date',
            'tickets' => 'nullable|array',
        ]);

        $data = $request->except(['tickets', 'image']); 

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            // Masukkan image ke array data yang akan diupdate
            $data['image'] = $request->file('image')->store('event_images', 'public');
        }

        // Update Event (Sekarang aman karena tidak ada data 'tickets' di dalamnya)
        $event->update($data);

        // Update Tiket (Looping terpisah)
        if ($request->has('tickets')) {
            foreach ($request->tickets as $ticketId => $ticketData) {
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

        if(Auth::user()->role == 'admin') {
            return redirect()->route('admin.events.index')->with('success', 'Event diperbarui!');
        }

        return redirect()->route('organizer.events.index')->with('success', 'Event diperbarui!');
    }
    // --- 6. HAPUS EVENT ---
    public function destroy(Event $event)
        {

            if ($event->organizer_id !== Auth::id()) {
                abort(403, 'Anda tidak memiliki izin menghapus event ini (Bukan milik Anda).');
            }

            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            
            $event->delete();
            
            return redirect()->back()->with('success', 'Event berhasil dihapus!');
        }
}