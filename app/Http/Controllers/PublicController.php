<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicController extends Controller
{
    public function home()
    {
        $salesSub = DB::table('order_items')
            ->selectRaw('COALESCE(SUM(quantity), 0)')
            ->whereColumn('product_id', 'products.id')
            ->whereIn('order_id', fn($q) => $q->select('id')->from('orders')->where('order_status', 'delivered'));

        $products = Product::select('products.*')
            ->selectSub($salesSub, 'sales_count')
            ->with('images')
            ->withAvg('reviews', 'rating')
            ->where('is_active', true)
            ->latest()
            ->get();

        $settings = StoreSetting::getInstance();

        return view('public.home', compact('products', 'settings'));
    }

    public function about()
    {
        $settings = StoreSetting::getInstance();
        return view('public.about', compact('settings'));
    }

    public function contact()
    {
        $settings = StoreSetting::getInstance();
        $availablePaymentMethods = StoreSetting::availablePaymentMethods();
        $enabledPaymentMethods = $settings->enabledPaymentMethods();
        return view('public.contact', compact('settings', 'availablePaymentMethods', 'enabledPaymentMethods'));
    }
}
