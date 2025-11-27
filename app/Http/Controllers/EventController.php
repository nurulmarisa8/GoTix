<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Http\Request;

class EventController extends Controller {
    public function index(Request $request) {
        // Check if the user is an organizer to show their events
        if (auth()->check() && auth()->user()->role === 'organizer') {
            $events = Event::where('user_id', auth()->id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
            return view('organizer.events.index', compact('events'));
        }

        // For public/guest view
        $query = Event::where('status', 'active');

        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('location', 'like', "%{$request->search}%");
        }

        if ($request->sort === 'newest') {
            $query->orderBy('event_date', 'asc');
        } elseif ($request->sort === 'popular') {
            $query->withCount('bookings')->orderBy('bookings_count', 'desc');
        }

        $events = $query->paginate(12);
        return view('events.index', compact('events'));
    }

    public function show(Event $event) {
        $tickets = $event->tickets()->where('available_quota', '>', 0)->get();
        $isFavorite = auth()->check() && auth()->user()->favorites()->where('event_id', $event->id)->exists();
        $userReview = auth()->check() ? $event->reviews()->where('user_id', auth()->id())->first() : null;

        return view('events.show', compact('event', 'tickets', 'isFavorite', 'userReview'));
    }

    public function __construct() {
        $this->middleware(['auth'])->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function create() {
        // Check if the user is an organizer to show organizer create view
        if (auth()->check() && auth()->user()->role === 'organizer') {
            return view('events.create');
        }

        // For other users, we can show different behavior or redirect
        // For now, we'll show the same view but this can be expanded later
        return view('events.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date_format:Y-m-d H:i|after:now',
            'location' => 'required|string|max:255',
            'image' => 'required|image|max:2048'
        ]);

        $imagePath = $request->file('image')->store('events', 'public');

        Event::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'image_url' => $imagePath
        ]);

        return redirect()->route('dashboard')->with('success', 'Event created successfully');
    }

    public function edit(Event $event) {
        $this->authorize('update', $event);
        // Check if the event belongs to the current organizer
        if (auth()->check() && auth()->user()->role === 'organizer' && $event->user_id == auth()->id()) {
            return view('events.edit', compact('event'));
        } else {
            abort(403, 'Unauthorized to edit this event');
        }
    }

    public function update(Request $request, Event $event) {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date_format:Y-m-d H:i|after:now',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
            $event->image_url = $imagePath;
        }

        $event->update($validated);
        return redirect()->route('dashboard')->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event) {
        $this->authorize('delete', $event);
        $event->delete();
        return redirect()->route('dashboard')->with('success', 'Event deleted successfully');
    }

    public function createTicket(Event $event) {
        $this->authorize('update', $event);
        return view('events.tickets.create', compact('event'));
    }

    public function storeTicket(Request $request, Event $event) {
        $this->authorize('update', $event);

        $validated = $request->validate([
            'ticket_name' => 'required|string|max:255',
            'ticket_description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:1'
        ]);

        $validated['event_id'] = $event->id;
        $validated['available_quota'] = $validated['quota'];

        $event->tickets()->create($validated);

        return redirect()->route('organizer.events.edit', $event)->with('success', 'Ticket type created successfully');
    }

    public function editTicket(Ticket $ticket) {
        $this->authorize('update', $ticket->event);
        return view('events.tickets.edit', compact('ticket'));
    }

    public function updateTicket(Request $request, Ticket $ticket) {
        $this->authorize('update', $ticket->event);

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

        return redirect()->route('organizer.events.edit', $ticket->event)->with('success', 'Ticket type updated successfully');
    }

    public function destroyTicket(Ticket $ticket) {
        $this->authorize('update', $ticket->event);
        $event = $ticket->event;
        $ticket->delete();
        return redirect()->route('organizer.events.edit', $event)->with('success', 'Ticket type deleted successfully');
    }
}
