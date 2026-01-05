<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">Revenue Report</h2>
                <p class="text-gray-400 mt-1">Detailed revenue analytics and trends</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Yearly Revenue -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 mb-8">
            <h3 class="text-xl font-semibold text-white mb-6">Yearly Revenue Overview</h3>
            
            @if($yearlyRevenue->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-gray-300 py-3 px-4">Year</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Total Revenue</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Growth</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($yearlyRevenue as $index => $year)
                                @php
                                    $previousYear = $yearlyRevenue->get($index + 1);
                                    $growth = $previousYear ? (($year->revenue - $previousYear->revenue) / $previousYear->revenue) * 100 : 0;
                                @endphp
                                <tr class="border-b border-gray-700">
                                    <td class="text-white py-3 px-4 font-semibold">{{ $year->year }}</td>
                                    <td class="text-green-400 py-3 px-4 text-right font-bold">${{ number_format($year->revenue, 2) }}</td>
                                    <td class="py-3 px-4 text-right">
                                        @if($growth > 0)
                                            <span class="text-green-400">+{{ number_format($growth, 1) }}%</span>
                                        @elseif($growth < 0)
                                            <span class="text-red-400">{{ number_format($growth, 1) }}%</span>
                                        @else
                                            <span class="text-gray-400">--</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-400 text-center py-8">No revenue data available yet.</p>
            @endif
        </div>

        <!-- Monthly Revenue for Current Year -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700 mb-8">
            <h3 class="text-xl font-semibold text-white mb-6">Monthly Revenue - {{ date('Y') }}</h3>
            
            @if($monthlyRevenue->count() > 0)
                <!-- Chart Visualization -->
                <div class="grid grid-cols-12 gap-2 h-64 mb-6">
                    @php
                        $maxRevenue = $monthlyRevenue->max('revenue') ?: 1;
                    @endphp
                    @for($month = 1; $month <= 12; $month++)
                        @php
                            $monthData = $monthlyRevenue->firstWhere('month', $month);
                            $revenue = $monthData ? $monthData->revenue : 0;
                            $height = $maxRevenue > 0 ? ($revenue / $maxRevenue) * 100 : 0;
                            $monthName = date('M', mktime(0, 0, 0, $month, 1));
                        @endphp
                        <div class="flex flex-col items-center">
                            <div class="w-full bg-gray-700 rounded flex-1 relative flex items-end">
                                <div class="w-full bg-gradient-to-t from-blue-600 to-blue-400 rounded transition-all duration-500" 
                                     style="height: {{ $height }}%"
                                     title="{{ $monthName }}: ${{ number_format($revenue, 2) }}">
                                </div>
                            </div>
                            <span class="text-xs text-gray-400 mt-2">{{ $monthName }}</span>
                        </div>
                    @endfor
                </div>

                <!-- Monthly Data Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-gray-300 py-3 px-4">Month</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Revenue</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Orders</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Avg. Order</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyRevenue as $month)
                                <tr class="border-b border-gray-700">
                                    <td class="text-white py-3 px-4 font-semibold">{{ $month->month_name }}</td>
                                    <td class="text-green-400 py-3 px-4 text-right font-bold">${{ number_format($month->revenue, 2) }}</td>
                                    <td class="text-blue-400 py-3 px-4 text-right">{{ $month->orders_count }}</td>
                                    <td class="text-purple-400 py-3 px-4 text-right">
                                        ${{ $month->orders_count > 0 ? number_format($month->revenue / $month->orders_count, 2) : '0.00' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-400 text-center py-8">No monthly revenue data available for {{ date('Y') }}.</p>
            @endif
        </div>

        <!-- Daily Revenue for Current Month -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <h3 class="text-xl font-semibold text-white mb-6">Daily Revenue - {{ date('F Y') }}</h3>
            
            @if($dailyRevenue->count() > 0)
                <!-- Daily Chart -->
                <div class="grid gap-1 h-40 mb-6" style="grid-template-columns: repeat({{ $dailyRevenue->count() }}, 1fr);">
                    @php
                        $maxDailyRevenue = $dailyRevenue->max('revenue') ?: 1;
                    @endphp
                    @foreach($dailyRevenue as $day)
                        @php
                            $height = $maxDailyRevenue > 0 ? ($day->revenue / $maxDailyRevenue) * 100 : 0;
                        @endphp
                        <div class="flex flex-col items-center">
                            <div class="w-full bg-gray-700 rounded flex-1 relative flex items-end">
                                <div class="w-full bg-gradient-to-t from-green-600 to-green-400 rounded transition-all duration-300" 
                                     style="height: {{ $height }}%"
                                     title="Day {{ $day->day }}: ${{ number_format($day->revenue, 2) }}">
                                </div>
                            </div>
                            <span class="text-xs text-gray-400 mt-1">{{ $day->day }}</span>
                        </div>
                    @endforeach
                </div>

                <!-- Daily Summary Stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="bg-gray-700/50 rounded-lg p-4 text-center">
                        <p class="text-gray-400 text-sm">Total Days</p>
                        <p class="text-white text-2xl font-bold">{{ $dailyRevenue->count() }}</p>
                    </div>
                    <div class="bg-gray-700/50 rounded-lg p-4 text-center">
                        <p class="text-gray-400 text-sm">Total Revenue</p>
                        <p class="text-green-400 text-2xl font-bold">${{ number_format($dailyRevenue->sum('revenue'), 2) }}</p>
                    </div>
                    <div class="bg-gray-700/50 rounded-lg p-4 text-center">
                        <p class="text-gray-400 text-sm">Total Orders</p>
                        <p class="text-blue-400 text-2xl font-bold">{{ $dailyRevenue->sum('orders_count') }}</p>
                    </div>
                    <div class="bg-gray-700/50 rounded-lg p-4 text-center">
                        <p class="text-gray-400 text-sm">Avg. per Day</p>
                        <p class="text-purple-400 text-2xl font-bold">
                            ${{ $dailyRevenue->count() > 0 ? number_format($dailyRevenue->sum('revenue') / $dailyRevenue->count(), 2) : '0.00' }}
                        </p>
                    </div>
                </div>
            @else
                <p class="text-gray-400 text-center py-8">No daily revenue data available for {{ date('F Y') }}.</p>
            @endif
        </div>
    </div>
</x-app-layout> 