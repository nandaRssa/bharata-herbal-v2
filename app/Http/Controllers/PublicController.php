<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        $products = Product::with('images')
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
