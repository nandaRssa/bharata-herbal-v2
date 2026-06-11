<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('public.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::with('images')->findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        $currentQty = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;
        $newQty = $currentQty + $request->quantity;

        if ($newQty > $product->stock) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock,
                ], 400);
            }
            return redirect()->back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $newQty;
        } else {
            $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
            $effectivePrice = $product->effective_price;
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $effectivePrice,
                'original_price' => $product->price,
                'quantity' => $request->quantity,
                'image_path' => $primaryImage ? $primaryImage->image_path : null,
                'stock' => $product->stock,
            ];
        }

        session()->put('cart', $cart);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cart_count' => collect($cart)->sum('quantity'),
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if ($request->quantity > $product->stock) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock,
                ], 400);
            }
            return redirect()->back()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product->stock);
        }

        if (isset($cart[$request->product_id])) {
            $cart[$request->product_id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil diperbarui!',
                'cart_count' => collect($cart)->sum('quantity'),
                'subtotal' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            ]);
        }

        return redirect()->back()->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
            session()->put('cart', $cart);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari keranjang!',
                'cart_count' => collect($cart)->sum('quantity'),
                'subtotal' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
