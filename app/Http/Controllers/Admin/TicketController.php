<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller {
    public function __construct() {
        $this->middleware('can:manage-users');
    }

    public function create(Event $event) {
        return view('admin.tickets.create', compact('event'));
    }

    public function store(Request $request, Event $event) {
        $validated = $request->validate([
            'ticket_name' => 'required|string|max:255',
            'ticket_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1'
        ]);

        $validated['event_id'] = $event->id;
        $validated['available_quota'] = $validated['quota'];

        Ticket::create($validated);

        return redirect()->route('admin.events.show', $event)->with('success', 'Ticket type created successfully');
    }

    public function edit(Ticket $ticket) {
        return view('admin.tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket) {
        $validated = $request->validate([
            'ticket_name' => 'required|string|max:255',
            'ticket_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1'
        ]);

        // If quota is updated, adjust the available quota accordingly
        if ($validated['quota'] != $ticket->quota) {
            $difference = $validated['quota'] - $ticket->quota;
            $ticket->available_quota += $difference;
        }

        $ticket->update($validated);

        return redirect()->route('admin.events.show', $ticket->event)->with('success', 'Ticket type updated successfully');
    }

    public function destroy(Ticket $ticket) {
        $event = $ticket->event;
        $ticket->delete();
        return redirect()->route('admin.events.show', $event)->with('success', 'Ticket type deleted successfully');
    }
}