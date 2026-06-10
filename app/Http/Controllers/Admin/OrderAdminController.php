<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        if ($request->filled('status')) {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('order_number', 'like', "%$s%")
                  ->orWhere('customer_name', 'like', "%$s%");
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status'    => 'required|in:new,processing,packing,shipped,delivered,cancelled',
            'payment_status'  => 'nullable|in:pending,confirmed,failed',
            'tracking_number' => 'nullable|string|max:100',
        ]);

        $order->update($request->only('order_status', 'payment_status', 'tracking_number'));

        return back()->with('success', 'Status pesanan diperbarui!');
    }
}
