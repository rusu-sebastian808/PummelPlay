<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{

    public function index()
    {
        if (Auth::user()->isAdmin()) {
            $orders = Order::with('user')->latest()->paginate(15);
        } else {
            $orders = Auth::user()->orders()->with('orderItems.game')->latest()->paginate(15);
        }
        
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $cartItems = Auth::user()->cartItems()->with('game')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }
        
        $total = $cartItems->sum(fn($item) => $item->quantity * $item->game->price);
        
        return view('orders.create', compact('cartItems', 'total'));
    }


    public function store(Request $request)
    {
        $cartItems = Auth::user()->cartItems()->with('game')->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        DB::transaction(function () use ($cartItems) {
            $total = $cartItems->sum(fn($item) => $item->quantity * $item->game->price);
            
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'completed',
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'game_id' => $cartItem->game_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->game->price,
                ]);
            }

          
            Auth::user()->cartItems()->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

  
    public function show(Order $order)
    {
        
        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.game', 'user');
        
        return view('orders.show', compact('order'));
    }


    public function invoice(Order $order)
    {
       
        if (!Auth::user()->isAdmin() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.game', 'user');
        
        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        
        return $pdf->download('invoice-' . $order->id . '.pdf');
    }

 
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order->update([
            'status' => $request->status
        ]);

        return redirect()->route('orders.index')->with('success', 'Order status updated!');
    }

  
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully!');
    }
}
