<?php

use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/events', function () {
    return view('public.events.index');
})->name('events.index');

Route::get('/events/{id}', function ($id) {
    return view('public.events.show');
})->name('events.show');

Route::get('/about', function () {
    return view('public.about'); // You may need to create this view
})->name('about');

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
