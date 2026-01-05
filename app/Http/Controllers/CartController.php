<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the cart items.
     */
    public function index()
    {
        $cartItems = Auth::user()->cartItems()->with('game')->get();
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->game->price);
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add item to cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $existingCart = Cart::where('user_id', Auth::id())
                           ->where('game_id', $request->game_id)
                           ->first();

        if ($existingCart) {
            $existingCart->update([
                'quantity' => $existingCart->quantity + $request->quantity
            ]);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'game_id' => $request->game_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Game added to cart!');
    }

    /**
     * Update the specified cart item.
     */
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if cart belongs to current user
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    /**
     * Remove the specified cart item.
     */
    public function destroy(Cart $cart)
    {
        // Check if cart belongs to current user
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
    }

    /**
     * Clear all cart items for the current user.
     */
    public function clear()
    {
        Auth::user()->cartItems()->delete();

        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}
