<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('images')->where('is_active', true);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('benefits', 'like', "%$search%");
            });
        }



        $products = $query->latest()->paginate(12)->withQueryString();

        return view('public.products.index', compact('products'));
    }

    public function show(string $slug)
    {
        $product = Product::with('images')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $related = Product::with('images')
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        $reviews = \App\Models\Review::with('product')
            ->where('product_id', $product->id)
            ->where('is_visible', true)
            ->latest()
            ->get();

        $settings = \App\Models\StoreSetting::first();

        return view('public.products.show', compact('product', 'related', 'settings', 'reviews'));
    }
}
