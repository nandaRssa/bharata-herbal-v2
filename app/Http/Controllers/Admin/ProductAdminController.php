<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('images');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'usage'       => 'nullable|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'benefits'    => 'nullable|array',
            'images.*'    => 'nullable|image|max:2048',
        ]);

        $slug = Str::slug($request->name);
        $base = $slug;
        $i = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        $product = Product::create([
            'name'        => $request->name,
            'slug'        => $slug,
            'description' => $request->description,
            'benefits'    => array_filter($request->benefits ?? []),
            'ingredients' => $request->ingredients,
            'usage'       => $request->usage,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'is_active'   => $request->boolean('is_active', true),
        ]);

        $this->handleImageUploads($request, $product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $product->load('images');
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'nullable|string',
            'usage'       => 'nullable|string',
            'price'       => 'required|integer|min:0',
            'stock'       => 'required|integer|min:0',
            'benefits'    => 'nullable|array',
            'images.*'    => 'nullable|image|max:2048',
        ]);

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'benefits'    => array_filter($request->benefits ?? []),
            'ingredients' => $request->ingredients,
            'usage'       => $request->usage,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'is_active'   => $request->boolean('is_active'),
        ]);

        $this->handleImageUploads($request, $product);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus!');
    }

    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Status produk diperbarui.');
    }

    public function deleteImage(ProductImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }

    private function handleImageUploads(Request $request, Product $product): void
    {
        if ($request->hasFile('images')) {
            $isFirst = $product->images()->count() === 0;
            foreach ($request->file('images') as $i => $file) {
                $path = $file->store('products', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $isFirst && $i === 0,
                    'sort_order' => $product->images()->count() + $i,
                ]);
            }
        }

        if ($request->filled('primary_image_id')) {
            $product->images()->update(['is_primary' => false]);
            $product->images()->where('id', $request->primary_image_id)->update(['is_primary' => true]);
        }
    }
}
