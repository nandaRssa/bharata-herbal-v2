<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::orderBy('stock');

        if ($filter = $request->get('filter')) {
            $query = match ($filter) {
                'critical' => $query->where('stock', '<', 10),
                'low'      => $query->whereBetween('stock', [10, 19]),
                'safe'     => $query->where('stock', '>=', 20),
                default    => $query,
            };
        }

        $products = $query->paginate(20)->withQueryString();
        return view('admin.stock.index', compact('products'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'new_stock' => ['required', 'integer', 'min:0', 'regex:/^[0-9]+$/'],
            'note'      => 'nullable|string|max:255',
        ], [
            'new_stock.regex' => 'Stok hanya boleh berisi angka tanpa simbol atau huruf.',
            'new_stock.integer' => 'Stok harus berupa angka bulat.',
            'new_stock.min' => 'Stok tidak boleh kurang dari 0.',
        ]);

        $previous = $product->stock;
        $product->update(['stock' => $request->new_stock]);

        StockLog::create([
            'product_id'     => $product->id,
            'previous_stock' => $previous,
            'new_stock'      => $request->new_stock,
            'changed_by'     => auth()->id(),
            'note'           => $request->note ?? 'Update manual stok',
        ]);

        return back()->with('success', "Stok {$product->name} diperbarui dari {$previous} ke {$request->new_stock}.");
    }
}
