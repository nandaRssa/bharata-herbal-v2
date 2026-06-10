<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\OrdersExport;
use App\Models\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items');

        $start = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $end   = $request->end_date   ?? now()->format('Y-m-d');

        $query->whereBetween('created_at', [$start . ' 00:00:00', $end . ' 23:59:59']);

        $orders       = $query->get();
        $totalOrders  = $orders->count();
        $totalRevenue = $orders->where('payment_status', 'confirmed')->sum('total_amount');

        return view('admin.reports.index', compact('orders', 'totalOrders', 'totalRevenue', 'start', 'end'));
    }

    public function exportExcel(Request $request)
    {
        $start = $request->start_date ?? now()->startOfMonth()->format('Y-m-d');
        $end   = $request->end_date   ?? now()->format('Y-m-d');

        $orders = Order::with('items')
            ->whereBetween('created_at', [
                $start . ' 00:00:00',
                $end   . ' 23:59:59',
            ])
            ->orderBy('created_at')
            ->get();

        $filename = "laporan-{$start}_sampai_{$end}.xlsx";

        return Excel::download(new OrdersExport($orders), $filename);
    }
}

