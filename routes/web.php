<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;

Route::get('/', [EventController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Pending Page
Route::get('/pending', function() {
    return view('auth.pending');
})->name('pending')->middleware('pending.organizer');

// Events
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

// User Dashboard & Bookings
Route::middleware(['auth', 'organizer.pending'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/bookings/{ticket}', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('/bookings', [BookingController::class, 'history'])->name('bookings.history');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/favorites/{event}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/reviews/{event}/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/reviews/{event}', [ReviewController::class, 'store'])->name('reviews.store');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    // Accept both PUT and PATCH for profile updates to match tests and common clients
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Allow users to delete their account
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Organizer Routes
Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/events', [EventController::class, 'organizerIndex'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    Route::get('/events/{event}/tickets/create', [EventController::class, 'createTicket'])->name('events.tickets.create');
    Route::post('/events/{event}/tickets', [EventController::class, 'storeTicket'])->name('events.tickets.store');
    Route::get('/tickets/{ticket}/edit', [EventController::class, 'editTicket'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [EventController::class, 'updateTicket'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [EventController::class, 'destroyTicket'])->name('tickets.destroy');
    Route::get('/bookings', [BookingController::class, 'organizerBookings'])->name('bookings.index');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::post('/users/{user}/approve', [AdminUserController::class, 'approveOrganizer'])->name('users.approve');
    Route::post('/users/{user}/reject', [AdminUserController::class, 'rejectOrganizer'])->name('users.reject');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::resource('events', AdminEventController::class);
    Route::get('/events/{event}/tickets/create', [AdminTicketController::class, 'create'])->name('events.tickets.create');
    Route::post('/events/{event}/tickets', [AdminTicketController::class, 'store'])->name('events.tickets.store');
    Route::get('/tickets/{ticket}/edit', [AdminTicketController::class, 'edit'])->name('tickets.edit');
    Route::put('/tickets/{ticket}', [AdminTicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/{ticket}', [AdminTicketController::class, 'destroy'])->name('tickets.destroy');
    Route::get('/reports', [AdminEventController::class, 'reports'])->name('reports');
    Route::get('/analytics', [AdminEventController::class, 'analytics'])->name('analytics');
    Route::get('/bookings', [AdminEventController::class, 'allBookings'])->name('bookings.index');
    Route::post('/bookings/{booking}/approve', [BookingController::class, 'approveBooking'])->name('bookings.approve');
    Route::post('/bookings/{booking}/reject', [BookingController::class, 'rejectBooking'])->name('bookings.reject');
});

require __DIR__.'/auth.php';
