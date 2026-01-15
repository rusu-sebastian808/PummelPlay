<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">Checkout</h2>
                <p class="text-gray-400 mt-1">Review and complete your order</p>
            </div>
            <a href="{{ route('cart.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Back to Cart
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
                    <h3 class="text-xl font-semibold text-white mb-6">Order Summary</h3>
                    
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-4 p-4 bg-gray-700/50 rounded-lg">
                                <div class="w-16 h-16 bg-gray-700 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->game->image)
                                        <img src="{{ asset('storage/' . $item->game->image) }}" 
                                             alt="{{ $item->game->title }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-700 to-gray-800">
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
            
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-white truncate">{{ $item->game->title }}</h4>
                                    <p class="text-gray-400 text-sm">{{ $item->game->genre }}</p>
                                    <p class="text-gray-400 text-sm">Quantity: {{ $item->quantity }}</p>
                                </div>
                                
          
                                <div class="text-right">
                                    <p class="text-white font-bold">${{ number_format($item->game->price * $item->quantity, 2) }}</p>
                                    <p class="text-gray-400 text-sm">${{ number_format($item->game->price, 2) }} each</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            

            <div class="lg:col-span-1">
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 sticky top-20">
                    <h3 class="text-xl font-semibold text-white mb-6">Payment Summary</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                            <span class="text-white">${{ number_format($total, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Tax</span>
                            <span class="text-white">$0.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Shipping</span>
                            <span class="text-white">Free</span>
                        </div>
                        <div class="border-t border-gray-700 pt-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-white">Total</span>
                                <span class="text-2xl font-bold text-blue-400">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                    </div>

   
                    <div class="mb-6">
                        <h4 class="text-lg font-medium text-white mb-4">Payment Method</h4>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 bg-gray-700/50 rounded-lg cursor-pointer">
                                <input type="radio" name="payment_method" value="credit_card" class="text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-3 text-white">Credit Card</span>
                            </label>
                            <label class="flex items-center p-3 bg-gray-700/50 rounded-lg cursor-pointer">
                                <input type="radio" name="payment_method" value="paypal" class="text-blue-600 focus:ring-blue-500">
                                <span class="ml-3 text-white">PayPal</span>
                            </label>
                        </div>
                    </div>

    
                    <div class="mb-6">
                        <h4 class="text-lg font-medium text-white mb-4">Billing Information</h4>
                        <div class="text-gray-300">
                            <p class="font-medium">{{ auth()->user()->name }}</p>
                            <p>{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    

                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>Place Order</span>
                        </button>
                    </form>
                    
                    <p class="text-gray-400 text-sm text-center mt-4">
                        By placing this order you agree to our Terms of Service
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 
