<x-app-layout>
    <x-slot name="header">
    <h2 class="text-3xl font-bold text-white">Shopping Cart</h2>
    <p class="text-gray-400 mt-1">Review your selected games</p>
</x-slot>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
            <div class="lg:col-span-2 space-y-4">
                @foreach($cartItems as $item)
                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 transition-all hover:border-gray-600">
                        <div class="flex items-center space-x-4">
                        
                            <div class="w-20 h-20 bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
                                @if($item->game->image)
                                    <img src="{{ asset('storage/' . $item->game->image) }}" 
                                         alt="{{ $item->game->title }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-700 to-gray-800">
                                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                      
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-white truncate">{{ $item->game->title }}</h3>
                                <p class="text-gray-400 text-sm">{{ $item->game->genre }}</p>
                                <p class="text-blue-400 font-bold">${{ number_format($item->game->price, 2) }}</p>
                            </div>
                            
               
                            <div class="flex items-center space-x-3">
                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <label for="quantity-{{ $item->id }}" class="text-gray-400 text-sm">Qty:</label>
                                    <input type="number" 
                                           id="quantity-{{ $item->id }}"
                                           name="quantity" 
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="10"
                                           class="w-16 bg-gray-700 border border-gray-600 rounded px-2 py-1 text-white text-center"
                                           onchange="this.form.submit()">
                                </form>
                                
                          
                                <form action="{{ route('cart.destroy', $item) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 p-2" title="Remove from cart">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            
                      
                            <div class="text-right">
                                <p class="text-white font-bold">${{ number_format($item->total_price, 2) }}</p>
                                <p class="text-gray-400 text-sm">subtotal</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                
      
                <div class="flex justify-between items-center mt-6">
                    <a href="{{ route('games.index') }}" class="text-blue-400 hover:text-blue-300 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>Continue Shopping</span>
                    </a>
                    
                    <form action="{{ route('cart.clear') }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to clear your cart?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300 flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            <span>Clear Cart</span>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="lg:col-span-1">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 sticky top-20">
                    <h3 class="text-xl font-semibold text-white mb-6">Order Summary</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Items ({{ $cartItems->sum('quantity') }})</span>
                            <span class="text-white">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Tax</span>
                            <span class="text-white">$0.00</span>
                        </div>
                        <div class="border-t border-gray-700 pt-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-white">Total</span>
                                <span class="text-2xl font-bold text-blue-400">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('orders.create') }}" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors flex items-center justify-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <span>Proceed to Checkout</span>
                    </a>
                    
                    <p class="text-gray-400 text-sm text-center mt-4">
                        Secure checkout powered by PummelPlay
                    </p>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16">
            <div class="bg-gray-800/30 backdrop-blur-sm rounded-lg p-8 border border-gray-700 max-w-md mx-auto">
                <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 4.5M21 13v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6"></path>
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">Your cart is empty</h3>
                <p class="text-gray-400 mb-6">Looks like you haven't added any games to your cart yet.</p>
                <a href="{{ route('games.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>Start Shopping</span>
                </a>
            </div>
        </div>
    @endif
</div>
</x-app-layout> 
