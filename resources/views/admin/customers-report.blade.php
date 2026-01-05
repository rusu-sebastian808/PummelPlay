<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold text-white">Customer Analytics Report</h2>
                <p class="text-gray-400 mt-1">Detailed customer behavior and spending analysis</p>
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
                        <p class="text-blue-100 text-sm font-medium">Total Customers</p>
                        <p class="text-3xl font-bold">{{ $customerStats->count() }}</p>
                    </div>
                    <div class="bg-blue-500/30 rounded-lg p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Active Customers</p>
                        <p class="text-3xl font-bold">{{ $customerStats->where('total_orders', '>', 0)->count() }}</p>
                    </div>
                    <div class="bg-green-500/30 rounded-lg p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Revenue</p>
                        <p class="text-3xl font-bold">${{ number_format($customerStats->sum('total_spent'), 2) }}</p>
                    </div>
                    <div class="bg-purple-500/30 rounded-lg p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Avg. Spending</p>
                        <p class="text-3xl font-bold">
                            @php
                                $activeCustomers = $customerStats->where('total_orders', '>', 0);
                                $avgSpending = $activeCustomers->count() > 0 ? $activeCustomers->avg('total_spent') : 0;
                            @endphp
                            ${{ number_format($avgSpending, 2) }}
                        </p>
                    </div>
                    <div class="bg-orange-500/30 rounded-lg p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Table -->
        <div class="bg-gray-800/50 backdrop-blur-sm rounded-lg p-6 border border-gray-700">
            <h3 class="text-xl font-semibold text-white mb-6">Customer Details</h3>
            
            @if($customerStats->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-gray-600">
                                <th class="text-gray-300 py-3 px-4">Customer</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Total Orders</th>
                                <th class="text-gray-300 py-3 px-4 text-right">Total Spent</th>
                                <th class="text-gray-300 py-3 px-4 text-center">Last Order</th>
                                <th class="text-gray-300 py-3 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customerStats as $customer)
                                <tr class="border-b border-gray-700">
                                    <td class="py-4 px-4">
                                        <div>
                                            <h4 class="font-semibold text-white">{{ $customer->name }}</h4>
                                            <p class="text-gray-400 text-sm">{{ $customer->email }}</p>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-right text-blue-400 font-semibold">
                                        {{ $customer->total_orders }}
                                    </td>
                                    <td class="py-4 px-4 text-right text-green-400 font-bold">
                                        ${{ number_format($customer->total_spent, 2) }}
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-300">
                                        @if($customer->last_order_date)
                                            {{ \Carbon\Carbon::parse($customer->last_order_date)->diffForHumans() }}
                                        @else
                                            <span class="text-gray-500">Never</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        @if($customer->total_orders > 0)
                                            <span class="bg-green-600 text-white px-2 py-1 rounded-full text-xs">Active</span>
                                        @else
                                            <span class="bg-gray-600 text-gray-300 px-2 py-1 rounded-full text-xs">New</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-400 text-center py-8">No customers found.</p>
            @endif
        </div>
    </div>
</x-app-layout> 