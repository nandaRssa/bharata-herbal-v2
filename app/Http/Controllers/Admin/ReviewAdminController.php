<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewAdminController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Review::with(['product', 'order'])
            ->when($request->search, fn($q) =>
                $q->where('customer_name', 'like', "%{$request->search}%")
                  ->orWhereHas('product', fn($p) => $p->where('name', 'like', "%{$request->search}%"))
            )
            ->latest()
            ->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.reviews.form', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'    => 'required|exists:products,id',
            'customer_name' => 'required|string|max:100',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'nullable|string|max:1000',
            'admin_reply'   => 'nullable|string|max:1000',
            'is_visible'    => 'boolean',
        ]);

        $data['is_visible'] = $request->boolean('is_visible', true);
        Review::create($data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Ulasan berhasil ditambahkan.');
    }

    public function edit(Review $review)
    {
        $products = Product::orderBy('name')->get();
        return view('admin.reviews.form', compact('review', 'products'));
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'product_id'    => 'required|exists:products,id',
            'customer_name' => 'required|string|max:100',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'nullable|string|max:1000',
            'admin_reply'   => 'nullable|string|max:1000',
            'is_visible'    => 'boolean',
        ]);

        $data['is_visible'] = $request->boolean('is_visible', false);
        $review->update($data);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Ulasan berhasil diperbarui.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Ulasan dihapus.');
    }

    public function toggle(Review $review)
    {
        $review->update(['is_visible' => ! $review->is_visible]);
        return back()->with('success', 'Status ulasan diperbarui.');
    }
}
