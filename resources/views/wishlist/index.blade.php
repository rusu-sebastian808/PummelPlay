<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">My Wishlist</h2>
                <p class="text-gray-400 mt-1">Your saved games</p>
            </div>
            <a href="{{ route('games.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Browse Games
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($wishlistItems->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($wishlistItems as $item)
                    <div class="bg-gray-800/30 backdrop-blur-sm rounded-lg overflow-hidden border border-gray-700 hover:border-gray-600 transition-all duration-300 hover:transform hover:scale-105">
                        <!-- Game Image -->
                        <div class="aspect-video bg-gray-700 relative overflow-hidden">
                            @if($item->game->image)
                                <img src="{{ asset('storage/' . $item->game->image) }}" 
                                     alt="{{ $item->game->title }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-700 to-gray-800">
                                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <!-- Genre Badge -->
                            <div class="absolute top-2 left-2">
                                <span class="bg-purple-600/90 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-full">
                                    {{ $item->game->genre }}
                                </span>
                            </div>
                            
                            <!-- Remove Button -->
                            <form action="{{ route('wishlist.destroy', $item) }}" method="POST" class="absolute top-2 right-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600/90 backdrop-blur-sm hover:bg-red-700 text-white p-2 rounded-full transition-colors" title="Remove from wishlist">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Game Info -->
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">{{ $item->game->title }}</h3>
                            <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $item->game->description }}</p>
                            
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold text-blue-400">${{ number_format($item->game->price, 2) }}</span>
                                <span class="text-gray-500 text-sm">Added {{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex space-x-2">
                                <form action="{{ route('wishlist.moveToCart', $item) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg font-medium transition-colors text-sm">
                                        Move to Cart
                                    </button>
                                </form>
                                
                                <a href="{{ route('games.show', $item->game) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition-colors text-sm">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $wishlistItems->links() }}
            </div>
        @else
            <!-- Empty Wishlist -->
            <div class="text-center py-16">
                <div class="bg-gray-800/30 backdrop-blur-sm rounded-lg p-8 border border-gray-700 max-w-md mx-auto">
                    <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-white mb-2">Your wishlist is empty</h3>
                    <p class="text-gray-400 mb-6">Start adding games you'd like to play later!</p>
                    <a href="{{ route('games.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors inline-flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>Browse Games</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout> 