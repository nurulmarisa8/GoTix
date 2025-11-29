<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;

// ====================================================
// 1. HALAMAN PUBLIK (Bisa diakses tanpa login)
// ====================================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [HomeController::class, 'detail'])->name('event.detail');

// ====================================================
// 2. AUTH ROUTES (Login, Register, Logout)
// ====================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


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
        
        // Reports (Laporan Penjualan)
        Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');

        // Manage Events (CRUD) - Nama Route: admin.events.index, admin.events.edit, dll
        Route::resource('events', EventController::class)->names('admin.events');

        // Manage Tickets Admin (Store Only - karena formnya ada di Edit Event)
        Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('admin.events.tickets.store');
    });


    // ----------------------------------------------------
    // ROLE: ORGANIZER (Manajemen Acara Sendiri)
    // ----------------------------------------------------
    
    // Halaman Status (Pending/Rejected) - Diakses di luar middleware role:organizer agar tidak looping
    Route::get('/organizer/pending', [OrganizerController::class, 'pendingPage'])->name('organizer.pending');
    Route::get('/organizer/rejected', [OrganizerController::class, 'rejectedPage'])->name('organizer.rejected');

    // Dashboard & Fitur Inti (Hanya jika status Approved)
    Route::middleware(['role:organizer'])->prefix('organizer')->group(function () {
        
        // Dashboard & Approval Booking
        Route::get('/dashboard', [OrganizerController::class, 'dashboard'])->name('organizer.dashboard');
        Route::post('/bookings/{id}/approve', [OrganizerController::class, 'approveBooking'])->name('organizer.bookings.approve');
        
        // Manage Events (CRUD) - Nama Route: organizer.events.index, organizer.events.create, dll
        Route::resource('events', EventController::class)->names('organizer.events');
        
        // --- MANAJEMEN TIKET ---
        
        // 1. Tambah Tiket Baru (Butuh ID Event)
        Route::get('/events/{event}/tickets/create', [TicketController::class, 'create'])->name('organizer.events.tickets.create');
        Route::post('/events/{event}/tickets', [TicketController::class, 'store'])->name('organizer.events.tickets.store');
        
        // 2. Edit & Update Tiket Spesifik (Butuh ID Ticket) - INI YANG PENTING
        Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('organizer.tickets.edit');
        Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('organizer.tickets.update');
        
        // 3. Hapus Tiket (Butuh ID Ticket)
        Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('organizer.tickets.destroy');
    });


    // ----------------------------------------------------
    // ROLE: REGISTERED USER (Pembeli Tiket)
    // ----------------------------------------------------
    Route::middleware(['role:user'])->group(function () {
        Route::post('/book-ticket', [BookingController::class, 'store'])->name('booking.store');
        Route::get('/my-bookings', [BookingController::class, 'history'])->name('booking.history');
    });

    // ----------------------------------------------------
    // GENERAL AUTH ROUTES
    // ----------------------------------------------------
    // Hapus Akun (Bisa dipakai user atau organizer yang ditolak)
    Route::delete('/profile', [HomeController::class, 'destroy'])->name('profile.destroy');

});