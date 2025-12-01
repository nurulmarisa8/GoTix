<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| Web Routes - GoTix Project
|--------------------------------------------------------------------------
*/

// ====================================================
// 1. HALAMAN PUBLIK (Bisa diakses tanpa login)
// ====================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [HomeController::class, 'detail'])->name('event.detail');


// ====================================================
// 3. ROUTES KHUSUS USER LOGIN (Middleware Auth)
// ====================================================
Route::middleware(['auth'])->group(function () {

    // ----------------------------------------------------
    // ROLE: ADMIN (Akses Penuh)
    // ----------------------------------------------------
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        // Dashboard & User Management
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
        Route::post('/approve-organizer/{id}', [AdminController::class, 'approveOrganizer'])->name('admin.approve');
        
        // Reports
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');

        // Manage User
        Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // Manage Events (CRUD)
        Route::resource('events', EventController::class)->names('admin.events');

        // --- KELOLA TRANSAKSI (BOOKINGS) ---
        Route::get('/bookings', [AdminController::class, 'manageBookings'])->name('admin.bookings');
        Route::post('/bookings/{id}/approve', [AdminController::class, 'approveBooking'])->name('admin.bookings.approve');
        Route::post('/bookings/{id}/reject', [AdminController::class, 'rejectBooking'])->name('admin.bookings.reject');

        // Manage Tickets (Store Only - via Edit Event)
        Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('admin.events.tickets.store');
    });


    // ----------------------------------------------------
    // ROLE: ORGANIZER (Manajemen Acara Sendiri)
    // ----------------------------------------------------
    
    // Halaman Status (Pending/Rejected) - Diakses di luar middleware role:organizer
    Route::get('/organizer/pending', [OrganizerController::class, 'pendingPage'])->name('organizer.pending');
    Route::get('/organizer/rejected', [OrganizerController::class, 'rejectedPage'])->name('organizer.rejected');

    // Dashboard & Fitur Inti (Hanya jika status Approved)
    Route::middleware(['role:organizer'])->prefix('organizer')->group(function () {
        
        // Dashboard & Approval Booking
        Route::get('/dashboard', [OrganizerController::class, 'dashboard'])->name('organizer.dashboard');
        Route::post('/bookings/{id}/approve', [OrganizerController::class, 'approveBooking'])->name('organizer.bookings.approve');
        Route::post('/bookings/{id}/reject', [OrganizerController::class, 'rejectBooking'])->name('organizer.bookings.reject');
        
        // Manage Events (CRUD)
        Route::resource('events', EventController::class)->names('organizer.events');
        
        // Manage Tickets (Create, Store, Edit, Update, Destroy)
        Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('organizer.events.tickets.create');
        Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('organizer.events.tickets.store');
        Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('organizer.tickets.edit');
        Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('organizer.tickets.update');
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('organizer.tickets.destroy');
    });


    // ----------------------------------------------------
    // ROLE: REGISTERED USER (Pembeli Tiket)
    // ----------------------------------------------------
    Route::middleware(['role:user'])->group(function () {
        Route::post('/book-ticket', [BookingController::class, 'store'])->name('booking.store');
        Route::get('/my-bookings', [BookingController::class, 'history'])->name('booking.history');
        Route::put('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
        Route::get('/bookings/{id}/download', [BookingController::class, 'downloadTicket'])->name('booking.download');
    });

    // ----------------------------------------------------
    // GENERAL AUTH ROUTES (Bisa Diakses Semua Role)
    // ----------------------------------------------------
    
    // 1. Hapus Akun
    Route::delete('/profile', [HomeController::class, 'destroy'])->name('profile.destroy');

    // 2. FAVORIT (Aman untuk User)
    Route::post('/event/{id}/favorite', [HomeController::class, 'toggleFavorite'])->name('event.favorite');

});

// Auth routes should be accessible to unauthenticated users
require __DIR__.'/auth.php';