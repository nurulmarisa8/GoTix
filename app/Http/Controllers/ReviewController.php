<?php

namespace App\Http\Controllers;
use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function create(Event $event) {
        $userReview = $event->reviews()->where('user_id', auth()->id())->first();
        return view('reviews.create', compact('event', 'userReview'));
    }
    
    public function store(Request $request, Event $event) {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000'
        ]);
        
        $review = $event->reviews()
            ->where('user_id', auth()->id())
            ->first();
        
        if ($review) {
            $review->update($validated);
        } else {
            $event->reviews()->create([
                'user_id' => auth()->id(),
                ...$validated
            ]);
        }
        
        return redirect()->route('events.show', $event)
            ->with('success', 'Review submitted successfully');
    }
}
