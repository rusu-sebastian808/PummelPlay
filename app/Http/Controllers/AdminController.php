<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Game;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        
        $totalRevenue = Order::where('status', 'completed')->sum('total_amount');
        
        $revenuePerMonth = Order::where('status', 'completed')
            ->where(DB::raw("strftime('%Y', created_at)"), '=', date('Y'))
            ->select(
                DB::raw("strftime('%m', created_at) as month"),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        $mostSoldGames = OrderItem::select('game_id', DB::raw('SUM(quantity) as total_sold'))
            ->with('game')
            ->groupBy('game_id')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();
        
        $leastSoldGames = Game::leftJoin('order_items', 'games.id', '=', 'order_items.game_id')
            ->select('games.*', DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'))
            ->groupBy('games.id')
            ->orderBy('total_sold', 'asc')
            ->limit(10)
            ->get();
        
        $mostWishlistedGames = Wishlist::select('game_id', DB::raw('COUNT(*) as wishlist_count'))
            ->with('game')
            ->groupBy('game_id')
            ->orderByDesc('wishlist_count')
            ->limit(10)
            ->get();
        
        $topSpenders = User::where('role', 'customer')
            ->withSum(['orders' => function ($query) {
                $query->where('status', 'completed');
            }], 'total_amount')
            ->orderByDesc('orders_sum_total_amount')
            ->limit(10)
            ->get();
        
        $averageSpending = User::where('role', 'customer')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.status', 'completed')
            ->avg('orders.total_amount');
        
        $mostActiveCustomers = User::where('role', 'customer')
            ->withCount(['orders' => function ($query) {
                $query->where('status', 'completed');
            }])
            ->orderByDesc('orders_count')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'revenuePerMonth',
            'mostSoldGames',
            'leastSoldGames',
            'mostWishlistedGames',
            'topSpenders',
            'averageSpending',
            'mostActiveCustomers'
        ));
    }

    public function revenueReport()
    {
        $yearlyRevenue = Order::where('status', 'completed')
            ->select(
                DB::raw("strftime('%Y', created_at) as year"),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->groupBy('year')
            ->orderByDesc('year')
            ->get();

        $monthlyRevenue = Order::where('status', 'completed')
            ->where(DB::raw("strftime('%Y', created_at)"), '=', date('Y'))
            ->select(
                DB::raw("strftime('%m', created_at) as month"),
                DB::raw("CASE 
                    WHEN strftime('%m', created_at) = '01' THEN 'January'
                    WHEN strftime('%m', created_at) = '02' THEN 'February'
                    WHEN strftime('%m', created_at) = '03' THEN 'March'
                    WHEN strftime('%m', created_at) = '04' THEN 'April'
                    WHEN strftime('%m', created_at) = '05' THEN 'May'
                    WHEN strftime('%m', created_at) = '06' THEN 'June'
                    WHEN strftime('%m', created_at) = '07' THEN 'July'
                    WHEN strftime('%m', created_at) = '08' THEN 'August'
                    WHEN strftime('%m', created_at) = '09' THEN 'September'
                    WHEN strftime('%m', created_at) = '10' THEN 'October'
                    WHEN strftime('%m', created_at) = '11' THEN 'November'
                    WHEN strftime('%m', created_at) = '12' THEN 'December'
                END as month_name"),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $dailyRevenue = Order::where('status', 'completed')
            ->where(DB::raw("strftime('%m', created_at)"), '=', date('m'))
            ->where(DB::raw("strftime('%Y', created_at)"), '=', date('Y'))
            ->select(
                DB::raw("strftime('%d', created_at) as day"),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(*) as orders_count')
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('admin.revenue-report', compact('yearlyRevenue', 'monthlyRevenue', 'dailyRevenue'));
    }

    public function gamesReport()
    {
        $gamePerformance = Game::leftJoin('order_items', 'games.id', '=', 'order_items.game_id')
            ->leftJoin('wishlists', 'games.id', '=', 'wishlists.game_id')
            ->leftJoin('reviews', 'games.id', '=', 'reviews.game_id')
            ->select(
                'games.*',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as total_sold'),
                DB::raw('COALESCE(SUM(order_items.quantity * order_items.price), 0) as revenue'),
                DB::raw('COUNT(DISTINCT wishlists.id) as wishlist_count'),
                DB::raw('COUNT(DISTINCT reviews.id) as review_count'),
                DB::raw('COALESCE(AVG(reviews.rating), 0) as average_rating')
            )
            ->groupBy('games.id')
            ->orderByDesc('total_sold')
            ->get();

        return view('admin.games-report', compact('gamePerformance'));
    }

    public function customersReport()
    {
        $customerStats = User::where('role', 'customer')
            ->leftJoin('orders', 'users.id', '=', 'orders.user_id')
            ->select(
                'users.*',
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('COALESCE(SUM(CASE WHEN orders.status = "completed" THEN orders.total_amount END), 0) as total_spent'),
                DB::raw('MAX(orders.created_at) as last_order_date')
            )
            ->groupBy('users.id')
            ->orderByDesc('total_spent')
            ->get();

        return view('admin.customers-report', compact('customerStats'));
    }
}
