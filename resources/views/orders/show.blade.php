<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
            <div>
                <h2 class="text-3xl font-bold text-white">Order #{{ $order->id }}</h2>
                <p class="text-gray-400 mt-1">Order placed on {{ $order->created_at->format('M j, Y g:i A') }}</p>
                @if(auth()->user()->isAdmin() && $order->user)
                    <p class="text-gray-400">Customer: {{ $order->user->name }} ({{ $order->user->email }})</p>
                @endif
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('orders.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    ← Back to Orders
                </a>
                <a href="{{ route('orders.invoice', $order) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    📄 Download Invoice
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2">
                <!-- Order Status Card -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 mb-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-semibold text-white">Order Status</h3>
                        <span class="px-4 py-2 rounded-full text-sm font-medium
                            {{ $order->status === 'completed' ? 'bg-green-600 text-white' : '' }}
                            {{ $order->status === 'pending' ? 'bg-yellow-600 text-white' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-600 text-white' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-400">Order Date</span>
                            <div class="text-white font-semibold">{{ $order->created_at->format('F j, Y') }}</div>
                        </div>
                        <div>
                            <span class="text-gray-400">Order Time</span>
                            <div class="text-white font-semibold">{{ $order->created_at->format('g:i A') }}</div>
                        </div>
                        @if(auth()->user()->isAdmin())
                        <div>
                            <span class="text-gray-400">Customer</span>
                            <div class="text-white font-semibold">{{ $order->user->name }}</div>
                        </div>
                        <div>
                            <span class="text-gray-400">Email</span>
                            <div class="text-white font-semibold">{{ $order->user->email }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
                    <h3 class="text-xl font-semibold text-white mb-6">Games in this Order</h3>
                    
                    <div class="space-y-4">
                        @foreach($order->orderItems as $item)
                            <div class="flex items-center space-x-4 p-4 bg-gray-700/50 rounded-lg border border-gray-600">
                                <!-- Game Image -->
                                <div class="w-16 h-16 bg-gray-600 rounded-lg overflow-hidden flex-shrink-0">
                                    @if($item->game->image)
                                        <img src="{{ asset('storage/' . $item->game->image) }}" 
                                             alt="{{ $item->game->title }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-600 to-gray-700">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Game Details -->
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-lg font-semibold text-white truncate">{{ $item->game->title }}</h4>
                                    <p class="text-gray-400 text-sm">{{ $item->game->genre }}</p>
                                    <p class="text-gray-300 text-sm mt-1 line-clamp-2">{{ Str::limit($item->game->description, 100) }}</p>
                                </div>
                                
                                <!-- Quantity and Price -->
                                <div class="text-right flex-shrink-0">
                                    <div class="text-gray-400 text-sm">Quantity: {{ $item->quantity }}</div>
                                    <div class="text-gray-400 text-sm">Unit Price: ${{ number_format($item->price, 2) }}</div>
                                    <div class="text-blue-400 font-bold text-lg">
                                        ${{ number_format($item->quantity * $item->price, 2) }}
                                    </div>
                                </div>
                                
                                <!-- Action Button -->
                                <div class="flex-shrink-0">
                                    <a href="{{ route('games.show', $item->game) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-colors">
                                        View Game
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Order Summary Sidebar -->
            <div class="lg:col-span-1">
                <!-- Order Summary -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 mb-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Order Summary</h3>
                    
                    <div class="space-y-3">
                        @php
                            $subtotal = $order->orderItems->sum(fn($item) => $item->quantity * $item->price);
                            $itemCount = $order->orderItems->sum('quantity');
                        @endphp
                        
                        <div class="flex justify-between text-gray-400">
                            <span>Items ({{ $itemCount }})</span>
                            <span>${{ number_format($subtotal, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between text-gray-400">
                            <span>Tax</span>
                            <span>$0.00</span>
                        </div>
                        
                        <div class="flex justify-between text-gray-400">
                            <span>Shipping</span>
                            <span class="text-green-400">FREE</span>
                        </div>
                        
                        <hr class="border-gray-600">
                        
                        <div class="flex justify-between text-xl font-bold">
                            <span class="text-white">Total</span>
                            <span class="text-blue-400">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Order Actions -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 mb-6">
                    <h3 class="text-xl font-semibold text-white mb-4">Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('orders.invoice', $order) }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg font-medium transition-colors flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Download Invoice</span>
                        </a>
                        
                        @if($order->status === 'completed')
                            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg font-medium transition-colors flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span>Add to Wishlist</span>
                            </button>
                        @endif
                        
                        <a href="{{ route('games.index') }}" 
                           class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-4 rounded-lg font-medium transition-colors flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 4.5M21 13v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6"></path>
                            </svg>
                            <span>Continue Shopping</span>
                        </a>
                    </div>
                </div>
                
                @if(auth()->user()->isAdmin())
                    <!-- Admin Actions -->
                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
                        <h3 class="text-xl font-semibold text-white mb-4">Admin Actions</h3>
                        
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mb-4">
                            @csrf
                            @method('PATCH')
                            <label for="status" class="block text-gray-300 font-medium mb-2">Update Status</label>
                            <div class="flex space-x-2">
                                <select name="status" id="status" class="flex-1 bg-gray-600 text-white px-3 py-2 rounded">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded font-medium transition-colors">
                                    Update
                                </button>
                            </div>
                        </form>
                        
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded font-medium transition-colors">
                                Delete Order
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout> 