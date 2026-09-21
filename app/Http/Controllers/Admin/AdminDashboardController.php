<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalSales = Order::where('order_status', '!=', 'cancelled')->sum('total');
        $todaySales = Order::where('order_status', '!=', 'cancelled')
            ->whereDate('created_at', $today)
            ->sum('total');

        $totalOrders = Order::count();
        $pendingOrders = Order::whereIn('order_status', ['placed', 'confirmed', 'packed'])->count();
        $completedOrders = Order::where('order_status', 'delivered')->count();
        $cancelledOrders = Order::where('order_status', 'cancelled')->count();

        $totalCustomers = User::where('role', 'customer')->count();
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<=', 10)->where('stock', '>', 0)->count();
        $outOfStockProducts = Product::where('stock', '<=', 0)->count();

        $recentOrders = Order::orderBy('created_at', 'desc')->take(8)->get();
        $recentCustomers = User::where('role', 'customer')->orderBy('created_at', 'desc')->take(5)->get();
        $lowStockList = Product::where('stock', '<=', 10)->orderBy('stock', 'asc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalSales',
            'todaySales',
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'cancelledOrders',
            'totalCustomers',
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'recentOrders',
            'recentCustomers',
            'lowStockList'
        ));
    }
}
