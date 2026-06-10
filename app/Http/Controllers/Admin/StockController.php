<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('stock')->paginate(20);
        return view('admin.stock.index', compact('products'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'new_stock' => 'required|integer|min:0',
            'note'      => 'nullable|string|max:255',
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

        return back()->with('success', "Stok {$product->name} diperbarui dari {$previous} → {$request->new_stock}.");
    }
}
