<?php
// app/Http/Controllers/User/FavoriteController.php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FavoriteEvent;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /** Menampilkan daftar acara favorit[cite: 641]. */
    public function index() {
        $favoriteEvents = Auth::user()->favorites()->with('event')->paginate(10);
        return view('user.favorites.index', compact('favoriteEvents'));
    }

    /** Menambah atau menghapus acara dari daftar favorit[cite: 582, 637]. */
    public function toggleFavorite(Event $event) {
        $favorite = FavoriteEvent::where('user_id', Auth::id())->where('event_id', $event->id)->first();

        if ($favorite) {
            $favorite->delete();
            $message = 'Acara dihapus dari favorit.';
        } else {
            FavoriteEvent::create(['user_id' => Auth::id(), 'event_id' => $event->id]);
            $message = 'Acara ditambahkan ke favorit.';
        }

        return back()->with('success', $message);
    }
}