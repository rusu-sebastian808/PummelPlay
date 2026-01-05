<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">
                    {{ auth()->user()->isAdmin() ? 'All Orders' : 'My Orders' }}
                </h2>
                <p class="text-gray-400 mt-1">View and manage orders</p>
            </div>
            @if(!auth()->user()->isAdmin())
                <a href="{{ route('games.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Continue Shopping
                </a>
            @endif
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-semibold text-white">Order #{{ $order->id }}</h3>
                                <p class="text-gray-400">{{ $order->created_at->format('M j, Y g:i A') }}</p>
                                @if(auth()->user()->isAdmin() && $order->user)
                                    <p class="text-gray-400">Customer: {{ $order->user->name }}</p>
                                @endif
                            </div>
                            <div class="flex items-center space-x-4 mt-4 md:mt-0">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    {{ $order->status === 'completed' ? 'bg-green-600 text-white' : '' }}
                                    {{ $order->status === 'pending' ? 'bg-yellow-600 text-white' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-600 text-white' : '' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="text-2xl font-bold text-blue-400">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4 justify-between items-center">
                            <div class="flex space-x-2">
                                <a href="{{ route('orders.show', $order) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    View Details
                                </a>
                                <a href="{{ route('orders.invoice', $order) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Download Invoice
                                </a>
                            </div>

                            @if(auth()->user()->isAdmin())
                                <div class="flex space-x-2">
                                    <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="bg-gray-600 text-white px-3 py-1 rounded text-sm">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this order?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @else
            <!-- No Orders -->
            <div class="text-center py-16">
                <div class="bg-gray-800/30 backdrop-blur-sm rounded-lg p-8 border border-gray-700 max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-white mb-2">
                        {{ auth()->user()->isAdmin() ? 'No orders found' : 'No orders yet' }}
                    </h3>
                    <p class="text-gray-400 mb-6">
                        {{ auth()->user()->isAdmin() ? 'There are no orders in the system yet.' : 'You haven\'t placed any orders yet.' }}
                    </p>
                    @if(!auth()->user()->isAdmin())
                        <a href="{{ route('games.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            <span>Start Shopping</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout> 