<x-app-layout>
    <x-slot name="header">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
        <div>
            <h2 class="text-2xl font-bold text-white">
                @if(isset($genre))
                    {{ ucfirst($genre) }} Games
                @elseif(isset($query))
                    Search Results for "{{ $query }}"
                @else
                    Latest Games
                @endif
            </h2>
            <p class="text-gray-400 mt-1">Discover your next gaming adventure</p>
        </div>
        
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.games.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                    Add New Game
                </a>
            @endif
        @endauth
    </div>
</x-slot>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Search and Filter Bar -->
    <div class="mb-8 card-gaming rounded-lg p-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search Form -->
            <form action="{{ route('games.search') }}" method="GET" class="flex-1">
                <div class="relative">
                    <input type="text" 
                           name="q" 
                           value="{{ request('q') }}"
                           placeholder="Search games..." 
                           class="w-full bg-gray-700 border border-gray-600 rounded-lg px-4 py-2 pl-10 text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </form>
            
            <!-- Genre Filter -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('games.index') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !isset($genre) ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                    All
                </a>
                @foreach(['RPG', 'Action', 'Adventure', 'Racing', 'Strategy', 'Platformer', 'Stealth', 'Simulation'] as $g)
                    <a href="{{ route('games.genre', strtolower($g)) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ isset($genre) && strtolower($genre) === strtolower($g) ? 'bg-blue-600 text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600' }}">
                        {{ $g }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    @if($games->count() > 0)
        <!-- Games Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($games as $game)
                <div class="card-gaming rounded-lg overflow-hidden transition-all duration-300 hover:transform hover:scale-105 float-animation">
                    <!-- Game Image -->
                    <div class="aspect-video bg-gray-700 relative overflow-hidden">
                        @if($game->image)
                            <img src="{{ asset('storage/' . $game->image) }}" 
                                 alt="{{ $game->title }}" 
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
                            <span class="bg-gaming-purple text-white text-xs px-2 py-1 rounded-full font-medium">
                                {{ $game->genre }}
                            </span>
                        </div>
                        
                        <!-- Rating -->
                        @if($game->averageRating() > 0)
                            <div class="absolute top-2 right-2 bg-gray-900/90 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-full flex items-center space-x-1">
                                <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                </svg>
                                <span>{{ number_format($game->averageRating(), 1) }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Game Info -->
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">{{ $game->title }}</h3>
                        <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $game->description }}</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <span class="price-tag">${{ number_format($game->price, 2) }}</span>
                            @if($game->reviewCount() > 0)
                                <span class="text-gray-500 text-sm">{{ $game->reviewCount() }} reviews</span>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="{{ route('games.show', $game) }}" 
                               class="flex-1 btn-primary text-white text-center py-2 px-4 rounded-lg font-medium">
                                View Details
                            </a>
                            
                            @auth
                                @if(auth()->user()->isCustomer())
                                    <!-- Add to Cart -->
                                    <form action="{{ route('cart.store') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn-success text-white p-2 rounded-lg" title="Add to Cart">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 4.5M21 13v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6"></path>
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <!-- Add to Wishlist -->
                                    <form action="{{ route('wishlist.store') }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="game_id" value="{{ $game->id }}">
                                        <button type="submit" class="bg-gaming-pink text-white p-2 rounded-lg transition-colors" title="Add to Wishlist">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                                
                                @if(auth()->user()->isAdmin())
                                    <!-- Admin Actions -->
                                    <a href="{{ route('admin.games.edit', $game) }}" 
                                       class="bg-yellow-600 hover:bg-yellow-700 text-white p-2 rounded-lg transition-colors" title="Edit Game">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $games->links() }}
        </div>
    @else
        <!-- No Games Found -->
        <div class="text-center py-16">
            <div class="card-gaming rounded-lg p-8 max-w-md mx-auto">
                <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-white mb-2">No Games Found</h3>
                <p class="text-gray-400 mb-4">
                    @if(isset($query))
                        No games match your search for "{{ $query }}"
                    @elseif(isset($genre))
                        No {{ $genre }} games available yet
                    @else
                        No games available yet
                    @endif
                </p>
                @if(isset($query) || isset($genre))
                    <a href="{{ route('games.index') }}" class="btn-primary text-white px-4 py-2 rounded-lg font-medium">
                        View All Games
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>
</x-app-layout> 