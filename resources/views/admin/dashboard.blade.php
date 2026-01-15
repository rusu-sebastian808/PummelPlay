<x-app-layout>
    <x-slot name="header">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-white">Admin Dashboard</h2>
            <p class="text-gray-400 mt-1">Comprehensive analytics and reports</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.games.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Add Game
            </a>
            <a href="{{ route('admin.revenue-report') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Revenue Report
            </a>
        </div>
    </div>
</x-slot>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
   
        <div class="bg-gaming-blue rounded-lg p-6 text-white glow-animation">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total Orders</p>
                    <p class="text-3xl font-bold">{{ number_format($totalOrders) }}</p>
                </div>
                <div class="bg-blue-500/30 rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

     
        <div class="bg-gaming-green rounded-lg p-6 text-white glow-animation">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Total Revenue</p>
                    <p class="text-3xl font-bold">${{ number_format($totalRevenue, 2) }}</p>
                </div>
                <div class="bg-green-500/30 rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

      
        <div class="bg-gaming-purple rounded-lg p-6 text-white glow-animation">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium">Avg. Spending</p>
                    <p class="text-3xl font-bold">${{ number_format($averageSpending ?? 0, 2) }}</p>
                </div>
                <div class="bg-purple-500/30 rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>

  
        <div class="bg-gaming-pink rounded-lg p-6 text-white glow-animation">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Total Games</p>
                    <p class="text-3xl font-bold">{{ \App\Models\Game::count() }}</p>
                </div>
                <div class="bg-orange-500/30 rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h.01M19 10a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>


    <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 mb-8">
        <h3 class="text-xl font-semibold text-white mb-4">Monthly Revenue ({{ date('Y') }})</h3>
        <div class="grid grid-cols-12 gap-2 h-64">
            @for($month = 1; $month <= 12; $month++)
                @php
                    $monthRevenue = $revenuePerMonth->firstWhere('month', $month);
                    $revenue = $monthRevenue ? $monthRevenue->revenue : 0;
                    $maxRevenue = $revenuePerMonth->max('revenue') ?: 1;
                    $height = $maxRevenue > 0 ? ($revenue / $maxRevenue) * 100 : 0;
                @endphp
                <div class="flex flex-col items-center">
                    <div class="w-full bg-gray-700 rounded flex-1 relative flex items-end">
                        <div class="w-full bg-blue-500 rounded transition-all duration-500" 
                             style="height: {{ $height }}%"
                             title="Month {{ $month }}: ${{ number_format($revenue, 2) }}">
                        </div>
                    </div>
                    <span class="text-xs text-gray-400 mt-2">{{ date('M', mktime(0, 0, 0, $month, 1)) }}</span>
                </div>
            @endfor
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">

        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-white">Most Sold Games</h3>
                <a href="{{ route('admin.games-report') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
            </div>
            @if($mostSoldGames->count() > 0)
                <div class="space-y-3">
                    @foreach($mostSoldGames->take(5) as $item)
                        <div class="flex items-center justify-between p-3 bg-gray-700/50 rounded-lg">
                            <div>
                                <h4 class="font-medium text-white">{{ $item->game->title }}</h4>
                                <p class="text-gray-400 text-sm">{{ $item->game->genre }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-blue-400">{{ number_format($item->total_sold) }}</p>
                                <p class="text-gray-400 text-sm">sold</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center py-4">No sales data available</p>
            @endif
        </div>

 
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-white">Top Spenders</h3>
                <a href="{{ route('admin.customers-report') }}" class="text-blue-400 hover:text-blue-300 text-sm">View All</a>
            </div>
            @if($topSpenders->count() > 0)
                <div class="space-y-3">
                    @foreach($topSpenders->take(5) as $customer)
                        <div class="flex items-center justify-between p-3 bg-gray-700/50 rounded-lg">
                            <div>
                                <h4 class="font-medium text-white">{{ $customer->name }}</h4>
                                <p class="text-gray-400 text-sm">{{ $customer->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-400">${{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}</p>
                                <p class="text-gray-400 text-sm">total spent</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center py-4">No customer data available</p>
            @endif
        </div>

 
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <h3 class="text-xl font-semibold text-white mb-4">Most Wishlisted Games</h3>
            @if($mostWishlistedGames->count() > 0)
                <div class="space-y-3">
                    @foreach($mostWishlistedGames->take(5) as $item)
                        <div class="flex items-center justify-between p-3 bg-gray-700/50 rounded-lg">
                            <div>
                                <h4 class="font-medium text-white">{{ $item->game->title }}</h4>
                                <p class="text-gray-400 text-sm">{{ $item->game->genre }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-purple-400">{{ number_format($item->wishlist_count) }}</p>
                                <p class="text-gray-400 text-sm">wishlisted</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center py-4">No wishlist data available</p>
            @endif
        </div>

    
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <h3 class="text-xl font-semibold text-white mb-4">Most Active Customers</h3>
            @if($mostActiveCustomers->count() > 0)
                <div class="space-y-3">
                    @foreach($mostActiveCustomers->take(5) as $customer)
                        <div class="flex items-center justify-between p-3 bg-gray-700/50 rounded-lg">
                            <div>
                                <h4 class="font-medium text-white">{{ $customer->name }}</h4>
                                <p class="text-gray-400 text-sm">{{ $customer->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-orange-400">{{ number_format($customer->orders_count) }}</p>
                                <p class="text-gray-400 text-sm">orders</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-400 text-center py-4">No customer activity data available</p>
            @endif
        </div>
    </div>

    <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
        <h3 class="text-xl font-semibold text-white mb-4">Least Sold Games (Need Attention)</h3>
        @if($leastSoldGames->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($leastSoldGames->take(6) as $game)
                    <div class="p-4 bg-gray-700/50 rounded-lg border border-red-500/20">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium text-white">{{ $game->title }}</h4>
                            <span class="text-red-400 text-sm">{{ $game->total_sold }} sold</span>
                        </div>
                        <p class="text-gray-400 text-sm mb-2">{{ $game->genre }} - ${{ number_format($game->price, 2) }}</p>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.games.edit', $game) }}" class="text-blue-400 hover:text-blue-300 text-sm">Edit</a>
                            <a href="{{ route('games.show', $game) }}" class="text-gray-400 hover:text-gray-300 text-sm">View</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-400 text-center py-4">No games data available</p>
        @endif
    </div>
</div>
</x-app-layout> 
