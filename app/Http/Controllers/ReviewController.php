<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'review' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $existingReview = Review::where('user_id', Auth::id())
                               ->where('game_id', $request->game_id)
                               ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this game!');
        }

        Review::create([
            'user_id' => Auth::id(),
            'game_id' => $request->game_id,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Review added successfully!');
    }

  
    public function edit(Review $review)
    {
       
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        return view('reviews.edit', compact('review'));
    }

  
    public function update(Request $request, Review $review)
    {
        $request->validate([
            'review' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

    
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->update([
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->route('games.show', $review->game_id)->with('success', 'Review updated successfully!');
    }


    public function destroy(Review $review)
    {
        
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $gameId = $review->game_id;
        $review->delete();

        return redirect()->route('games.show', $gameId)->with('success', 'Review deleted successfully!');
    }
}
