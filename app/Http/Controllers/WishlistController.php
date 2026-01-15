<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{

    public function index()
    {
        $wishlistItems = Auth::user()->wishlistItems()->with('game')->latest()->paginate(12);
        
        return view('wishlist.index', compact('wishlistItems'));
    }


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

   
    public function destroy(Wishlist $wishlist)
    {
        
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }

        $wishlist->delete();

        return redirect()->back()->with('success', 'Game removed from wishlist!');
    }

   
    public function moveToCart(Wishlist $wishlist)
    {
       
        if ($wishlist->user_id !== Auth::id()) {
            abort(403);
        }

      
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

        $wishlist->delete();

        return redirect()->back()->with('success', 'Game moved to cart!');
    }
}
