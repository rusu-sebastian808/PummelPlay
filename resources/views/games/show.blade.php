<x-app-layout>
    <x-slot name="header">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-3xl font-bold text-white">{{ $game->title }}</h2>
            <p class="text-gray-400 mt-1">{{ $game->genre }} Game</p>
        </div>
        
        @auth
            @if(auth()->user()->isAdmin())
                <div class="flex space-x-2">
                    <a href="{{ route('admin.games.edit', $game) }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Edit Game
                    </a>
                    <form action="{{ route('admin.games.destroy', $game) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this game?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Delete Game
                        </button>
                    </form>
                </div>
            @endif
        @endauth
    </div>
</x-slot>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Game Image -->
        <div class="lg:col-span-1">
            <div class="aspect-square bg-gray-700 rounded-lg overflow-hidden mb-4">
                @if($game->image)
                    <img src="{{ asset('storage/' . $game->image) }}" 
                         alt="{{ $game->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-700 to-gray-800">
                        <svg class="w-24 h-24 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                @endif
            </div>
            
            <!-- Game Stats -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-4 border border-gray-700">
                <h3 class="text-lg font-semibold text-white mb-4">Game Statistics</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Genre</span>
                        <span class="text-white">{{ $game->genre }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Price</span>
                        <span class="text-blue-400 font-bold">${{ number_format($game->price, 2) }}</span>
                    </div>
                    @if($averageRating > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-400">Rating</span>
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span class="text-white">{{ number_format($averageRating, 1) }}</span>
                                <span class="text-gray-400 text-sm">({{ $reviewCount }})</span>
                            </div>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-400">Reviews</span>
                        <span class="text-white">{{ $reviewCount }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Game Details -->
        <div class="lg:col-span-2">
            <!-- Description -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 mb-6">
                <h3 class="text-xl font-semibold text-white mb-4">About This Game</h3>
                <p class="text-gray-300 leading-relaxed">{{ $game->description }}</p>
                
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-gray-400">Genre</span>
                        <div class="text-white font-semibold">{{ $game->genre }}</div>
                    </div>
                    <div>
                        <span class="text-gray-400">Price</span>
                        <div class="text-blue-400 font-bold text-xl">${{ number_format($game->price, 2) }}</div>
                    </div>
                    @if($averageRating > 0)
                        <div>
                            <span class="text-gray-400">Rating</span>
                            <div class="flex items-center space-x-1">
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span class="text-white">{{ number_format($averageRating, 1) }}</span>
                                <span class="text-gray-400 text-sm">({{ $reviewCount }})</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Purchase Actions -->
            @auth
                @if(auth()->user()->isCustomer())
                    <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 mb-6">
                        <h3 class="text-xl font-semibold text-white mb-4">Purchase Options</h3>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- Add to Cart -->
                            <form action="{{ route('cart.store') }}" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="game_id" value="{{ $game->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 4.5M21 13v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6"></path>
                                    </svg>
                                    <span>Add to Cart</span>
                                </button>
                            </form>
                            
                            <!-- Add to Wishlist -->
                            <form action="{{ route('wishlist.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="game_id" value="{{ $game->id }}">
                                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors flex items-center justify-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    <span>Add to Wishlist</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <!-- Guest Purchase Prompt -->
                <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 mb-6 text-center">
                    <h3 class="text-xl font-semibold text-white mb-4">Ready to Play?</h3>
                    <p class="text-gray-400 mb-4">Create an account or login to purchase this game</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors">
                            Create Account
                        </a>
                        <a href="{{ route('login') }}" class="bg-gray-600 hover:bg-gray-700 text-white py-3 px-6 rounded-lg font-semibold transition-colors">
                            Login
                        </a>
                    </div>
                </div>
            @endauth
            
            <!-- Reviews Section -->
            <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-white">Reviews ({{ $reviewCount }})</h3>
                    
                    @auth
                        @if(auth()->user()->isCustomer())
                            <!-- Add Review Form -->
                            <details class="relative">
                                <summary class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors cursor-pointer">
                                    Write Review
                                </summary>
                                <div class="absolute right-0 top-12 w-96 bg-gray-700 rounded-lg p-4 border border-gray-600 z-10">
                                    <form action="{{ route('reviews.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                                        
                                        <div class="mb-4">
                                            <label for="rating" class="block text-gray-300 font-medium mb-2">Rating</label>
                                            <select name="rating" id="rating" required class="w-full bg-gray-600 border border-gray-500 rounded px-3 py-2 text-white">
                                                <option value="5">5 Stars - Excellent</option>
                                                <option value="4">4 Stars - Good</option>
                                                <option value="3">3 Stars - Average</option>
                                                <option value="2">2 Stars - Poor</option>
                                                <option value="1">1 Star - Terrible</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="review" class="block text-gray-300 font-medium mb-2">Review</label>
                                            <textarea name="review" 
                                                      id="review" 
                                                      rows="3" 
                                                      required
                                                      placeholder="Share your thoughts..."
                                                      class="w-full bg-gray-600 border border-gray-500 rounded px-3 py-2 text-white placeholder-gray-400"></textarea>
                                        </div>
                                        
                                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded font-medium transition-colors">
                                            Submit Review
                                        </button>
                                    </form>
                                </div>
                            </details>
                        @endif
                    @endauth
                </div>
                
                <!-- Reviews List -->
                @if($reviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($reviews as $review)
                            <div class="border-b border-gray-700 pb-4 last:border-b-0">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-semibold text-white">{{ $review->user->name }}</h4>
                                        <div class="flex items-center space-x-2 mt-1">
                                            <div class="flex space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <span class="text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-500' }}">★</span>
                                                @endfor
                                            </div>
                                            <span class="text-gray-400 text-sm">{{ $review->created_at->format('M j, Y') }}</span>
                                        </div>
                                    </div>
                                    
                                    @auth
                                        @if(auth()->user()->id === $review->user_id || auth()->user()->isAdmin())
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this review?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-400 hover:text-red-300 text-sm">Delete</button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                                <p class="text-gray-300">{{ $review->review }}</p>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $reviews->links() }}
                    </div>
                @else
                    <p class="text-gray-400 text-center py-8">No reviews yet. Be the first to review this game!</p>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout> 