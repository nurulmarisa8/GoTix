<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;

class FavoriteController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function toggle(Event $event) {
        $user = auth()->user();
        
        if ($user->favorites()->where('event_id', $event->id)->exists()) {
            $user->favorites()->detach($event->id);
            return response()->json(['message' => 'Removed from favorites']);
        } else {
            $user->favorites()->attach($event->id);
            return response()->json(['message' => 'Added to favorites']);
        }
    }
}
