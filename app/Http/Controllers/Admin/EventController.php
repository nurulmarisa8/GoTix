<?php
// app/Http/Controllers/Admin/EventController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
// use App\Models\Ticket;

class EventController extends Controller
{
    /** Tampilkan daftar semua acara. */
    public function index() {
        $events = Event::with('organizer')->paginate(15);
        return view('admin.events.index', compact('events'));
    }
    
    /** Tampilkan form untuk membuat acara. */
    public function create() {
        return view('admin.events.create');
    }

    /** Simpan acara baru. */
    public function store(Request $request) {
        // Logika validasi dan penyimpanan Event dan Tiket
        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil dibuat.');
    }

    /** Tampilkan detail acara. */
    public function show(Event $event) {
        return view('admin.events.show', compact('event'));
    }

    /** Tampilkan form untuk mengedit acara. */
    public function edit(Event $event) {
        return view('admin.events.edit', compact('event'));
    }

    /** Perbarui acara. */
    public function update(Request $request, Event $event) {
        // Logika validasi dan pembaruan Event dan Tiket
        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil diperbarui.');
    }

    /** Hapus acara. */
    public function destroy(Event $event) {
        // Hapus tiket dan booking terkait
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil dihapus.');
    }
}