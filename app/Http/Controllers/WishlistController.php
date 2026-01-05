<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the wishlist.
     */
    public function index()
    {
        $wishlistItems = Auth::user()->wishlistItems()->with('game')->latest()->paginate(12);
        
        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Store a newly created wishlist item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
        ]);

        $existingWishlist = Wishlist::where('user_id', Auth::id())
                                  ->where('game_id', $request->game_id)
                                  ->first();

        if ($existingWishlist) {
            return redirect()->back()->with('info', 'Game is already in your wishlist!');
        }

        Wishlist::create([
            'user_id' => Auth::id(),
            'game_id' => $request->game_id,
        ]);

        return redirect()->back()->with('success', 'Game added to wishlist!');
    }

    /**
     * Remove the specified wishlist item.
     */
    public function destroy(Wishlist $wishlist)
    {
        // Check if wishlist belongs to current user
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }

        $wishlist->delete();

        return redirect()->back()->with('success', 'Game removed from wishlist!');
    }

    /**
     * Move item from wishlist to cart.
     */
    public function moveToCart(Wishlist $wishlist)
    {
        // Check if wishlist belongs to current user
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }

        // Add to cart
        $existingCart = \App\Models\Cart::where('user_id', Auth::id())
                                       ->where('game_id', $wishlist->game_id)
                                       ->first();

        if ($existingCart) {
            $existingCart->increment('quantity');
        } else {
            \App\Models\Cart::create([
                'user_id' => Auth::id(),
                'game_id' => $wishlist->game_id,
                'quantity' => 1,
            ]);
        }

        // Remove from wishlist
        $wishlist->delete();

        return redirect()->back()->with('success', 'Game moved to cart!');
    }
}
