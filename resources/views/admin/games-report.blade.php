<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">Games Performance Report</h2>
                <p class="text-gray-400 mt-1">Comprehensive analytics for all games</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Summary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Games</p>
                        <p class="text-3xl font-bold">{{ $gamePerformance->count() }}</p>
                    </div>
                    <div class="bg-blue-500/30 rounded-lg p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Units Sold</p>
                        <p class="text-3xl font-bold">{{ number_format($gamePerformance->sum('total_sold')) }}</p>
                    </div>
                    <div class="bg-green-500/30 rounded-lg p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 4.5M21 13v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-bold">${{ number_format($gamePerformance->sum('revenue'), 2) }}</p>
                    </div>
                    <div class="bg-purple-500/30 rounded-lg p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-pink-600 to-pink-700 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-pink-100 text-sm font-medium">Total Wishlisted</p>
                        <p class="text-3xl font-bold">{{ number_format($gamePerformance->sum('wishlist_count')) }}</p>
                    </div>
                    <div class="bg-pink-500/30 rounded-lg p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Games Performance Table -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-white">Detailed Game Performance</h3>
                <div class="flex space-x-2">
                    <select class="bg-gray-600 text-white px-3 py-2 rounded text-sm" onchange="sortTable(this.value)">
                        <option value="revenue">Sort by Revenue</option>
                        <option value="units">Sort by Units Sold</option>
                        <option value="rating">Sort by Rating</option>
                        <option value="wishlist">Sort by Wishlist</option>
                    </select>
                </div>
            </div>

            @if($gamePerformance->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left" id="gamesTable">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-gray-300 py-3 px-4">Game</th>
                                <th class="text-gray-300 py-3 px-4 text-center">Genre</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Price</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Units Sold</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Revenue</th>
                                <th class="text-gray-300 py-3 px-4 text-center">Rating</th>
                                <th class="text-gray-300 py-3 px-4 text-center">Reviews</th>
                                <th class="text-gray-300 py-3 px-4 text-center">Wishlisted</th>
                                <th class="text-gray-300 py-3 px-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gamePerformance as $game)
                                <tr class="border-b border-gray-700 hover:bg-gray-700/30 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-3">
                                            <!-- Game Image -->
                                            <div class="w-12 h-12 bg-gray-600 rounded-lg overflow-hidden flex-shrink-0">
                                                @if($game->image)
                                                    <img src="{{ asset('storage/' . $game->image) }}" 
                                                         alt="{{ $game->title }}" 
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-600 to-gray-700">
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <!-- Game Info -->
                                            <div>
                                                <h4 class="font-semibold text-white">{{ $game->title }}</h4>
                                                <p class="text-gray-400 text-sm">{{ Str::limit($game->description, 40) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="bg-gray-600 text-gray-200 px-2 py-1 rounded-full text-xs">
                                            {{ $game->genre }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4 text-right text-blue-400 font-semibold">
                                        ${{ number_format($game->price, 2) }}
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="text-green-400 font-bold">{{ number_format($game->total_sold) }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-right">
                                        <span class="text-green-400 font-bold">${{ number_format($game->revenue, 2) }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        @if($game->average_rating > 0)
                                            <div class="flex items-center justify-center space-x-1">
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                                <span class="text-yellow-400 font-semibold">{{ number_format($game->average_rating, 1) }}</span>
                                            </div>
                                        @else
                                            <span class="text-gray-500">No ratings</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-300">
                                        {{ $game->review_count }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="text-pink-400 font-semibold">{{ $game->wishlist_count }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('games.show', $game) }}" 
                                               class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs transition-colors"
                                               title="View Game">
                                                View
                                            </a>
                                            <a href="{{ route('admin.games.edit', $game) }}" 
                                               class="bg-yellow-600 hover:bg-yellow-700 text-white px-2 py-1 rounded text-xs transition-colors"
                                               title="Edit Game">
                                                Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Performance Insights -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $bestSeller = $gamePerformance->where('total_sold', $gamePerformance->max('total_sold'))->first();
                        $topRevenue = $gamePerformance->where('revenue', $gamePerformance->max('revenue'))->first();
                        $topRated = $gamePerformance->where('average_rating', $gamePerformance->max('average_rating'))->first();
                    @endphp

                    <!-- Best Seller -->
                    @if($bestSeller && $bestSeller->total_sold > 0)
                        <div class="bg-green-600/20 border border-green-600/30 rounded-lg p-4">
                            <h4 class="text-green-400 font-semibold mb-2">🏆 Best Seller</h4>
                            <p class="text-white font-bold">{{ $bestSeller->title }}</p>
                            <p class="text-green-300 text-sm">{{ number_format($bestSeller->total_sold) }} units sold</p>
                        </div>
                    @endif

                    <!-- Top Revenue -->
                    @if($topRevenue && $topRevenue->revenue > 0)
                        <div class="bg-purple-600/20 border border-purple-600/30 rounded-lg p-4">
                            <h4 class="text-purple-400 font-semibold mb-2">💰 Top Revenue</h4>
                            <p class="text-white font-bold">{{ $topRevenue->title }}</p>
                            <p class="text-purple-300 text-sm">${{ number_format($topRevenue->revenue, 2) }} earned</p>
                        </div>
                    @endif

                    <!-- Top Rated -->
                    @if($topRated && $topRated->average_rating > 0)
                        <div class="bg-yellow-600/20 border border-yellow-600/30 rounded-lg p-4">
                            <h4 class="text-yellow-400 font-semibold mb-2">⭐ Top Rated</h4>
                            <p class="text-white font-bold">{{ $topRated->title }}</p>
                            <p class="text-yellow-300 text-sm">{{ number_format($topRated->average_rating, 1) }} stars</p>
                        </div>
                    @endif
                </div>
            @else
                <p class="text-gray-400 text-center py-8">No games available yet.</p>
            @endif
        </div>
    </div>

    <script>
        function sortTable(criteria) {
            // This would require JavaScript implementation for client-side sorting
            // For now, we'll just refresh the page with a sort parameter
            const url = new URL(window.location);
            url.searchParams.set('sort', criteria);
            window.location = url;
        }
    </script>
</x-app-layout> 