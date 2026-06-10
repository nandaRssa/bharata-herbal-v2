<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $todayOrders = Order::whereDate('created_at', today())->count();
        $monthRevenue = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('payment_status', 'confirmed')
            ->sum('total_amount');
        $pendingOrders   = Order::where('order_status', 'new')->count();
        $criticalStock   = Product::where('stock', '<', 5)->where('is_active', true)->count();
        $restockNeeded   = Product::whereBetween('stock', [5, 9])->where('is_active', true)->count();

        $recentOrders = Order::with('items')->latest()->take(10)->get();

        $topProducts = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Grafik 30 hari terakhir
        $salesChart = Order::selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total_amount) as revenue')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.dashboard', compact(
            'todayOrders', 'monthRevenue', 'pendingOrders', 'criticalStock', 'restockNeeded',
            'recentOrders', 'topProducts', 'salesChart'
        ));
    }
}
