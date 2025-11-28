<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventController extends Controller {
    public function __construct() {
        $this->middleware('can:manage-users');
    }

    public function index() {
        $events = Event::with('organizer')->paginate(15);
        return view('admin.events.index', compact('events'));
    }

    public function create() {
        $organizers = User::where('role', 'organizer')->where('organizer_status', 'approved')->get();
        return view('admin.events.create', compact('organizers'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'event_date' => 'required|date_format:Y-m-d H:i|after:now',
            'location' => 'required|string|max:255',
            'image' => 'required|image|max:2048'
        ]);

        $imagePath = $request->file('image')->store('events', 'public');

        Event::create([
            'user_id' => $validated['user_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'event_date' => $validated['event_date'],
            'location' => $validated['location'],
            'image_url' => $imagePath,
            'status' => 'active'
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully');
    }

    public function show(Event $event) {
        $tickets = $event->tickets;
        $bookingStats = $event->bookings()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        return view('admin.events.show', compact('event', 'tickets', 'bookingStats'));
    }

    public function edit(Event $event) {
        $organizers = User::where('role', 'organizer')->where('organizer_status', 'approved')->get();
        return view('admin.events.edit', compact('event', 'organizers'));
    }

    public function update(Request $request, Event $event) {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
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
        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully');
    }

    public function destroy(Event $event) {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully');
    }

    public function reports() {
        $totalRevenue = Booking::where('status', 'approved')->sum('total_price');

        $revenueByEvent = Event::select('events.id', 'events.name', DB::raw('SUM(bookings.total_price) as revenue'))
            ->leftJoin('bookings', 'events.id', '=', DB::raw('(SELECT event_id FROM tickets WHERE id = bookings.ticket_id)'))
            ->where('bookings.status', 'approved')
            ->groupBy('events.id', 'events.name')
            ->orderBy('revenue', 'desc')
            ->take(10)
            ->get();

        $bookingTrend = Booking::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->get();

        return view('admin.reports', compact('totalRevenue', 'revenueByEvent', 'bookingTrend'));
    }

    public function analytics() {
        // Total counts for cards
        $totalUsers = User::count();
        $totalEvents = Event::count();
        $totalBookings = Booking::count();
        $totalRevenue = Booking::where('status', 'approved')->sum('total_price');

        // User growth chart data
        $userGrowth = User::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('count(*) as total')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // Booking status distribution
        $bookingStatus = Booking::select(
            'status',
            DB::raw('count(*) as total')
        )
        ->groupBy('status')
        ->get();

        // Events by organizer
        $eventsByOrganizer = User::select(
            'users.name',
            DB::raw('COUNT(events.id) as total_events')
        )
        ->join('events', 'users.id', '=', 'events.user_id')
        ->where('users.role', 'organizer')
        ->groupBy('users.id', 'users.name')
        ->orderBy('total_events', 'desc')
        ->take(5)
        ->get();

        // Revenue by month
        $revenueByMonth = Booking::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total_revenue')
        )
        ->where('status', 'approved')
        ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
        ->orderBy(DB::raw('YEAR(created_at)'), 'desc')
        ->orderBy(DB::raw('MONTH(created_at)'), 'desc')
        ->take(12)
        ->get();

        return view('admin.analytics', compact(
            'totalUsers',
            'totalEvents',
            'totalBookings',
            'totalRevenue',
            'userGrowth',
            'bookingStatus',
            'eventsByOrganizer',
            'revenueByMonth'
        ));
    }

    public function allBookings() {
        $bookings = Booking::with('user', 'ticket.event')->paginate(20);
        return view('admin.bookings.index', compact('bookings'));
    }
}
