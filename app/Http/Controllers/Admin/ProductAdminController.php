<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
            'name'               => 'required|string|max:255',
            'description'        => 'nullable|string',
            'ingredients'        => 'nullable|string',
            'usage'              => 'nullable|string',
            'price'              => 'required|integer|min:0',
            'stock'              => 'required|integer|min:0',
            'benefits'           => 'nullable|array',
            'images.*'           => 'nullable|image|max:2048',
            'discount_type'      => 'nullable|in:percentage,fixed',
            'discount_value'     => [
                'nullable',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percentage' && $value > 100) {
                        $fail('Diskon persen tidak boleh melebihi 100%.');
                    }
                    if ($request->discount_type === 'fixed' && $value > $request->price) {
                        $fail('Diskon nominal tidak boleh melebihi harga asli produk.');
                    }
                },
            ],
            'discount_start_at'  => 'nullable|date',
            'discount_end_at'    => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    if (!$value) return;
                    $end = $this->parseLocalDateTime($value, $request->timezone_offset);
                    // must be > now
                    if ($end->lte(now())) {
                        $fail('Tanggal berakhir diskon harus lebih dari waktu saat ini. Contoh: jika sekarang jam 21:00, maka minimal jam 21:01.');
                        return;
                    }
                    // must be >= discount_start_at
                    $start = $request->discount_start_at;
                    if ($start && $end->lt($this->parseLocalDateTime($start, $request->timezone_offset))) {
                        $fail('Tanggal berakhir diskon tidak boleh kurang dari tanggal mulai diskon.');
                    }
                },
            ],
        ]);

        $slug = Str::slug($request->name);
        $base = $slug;
        $i = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        $product = Product::create([
            'name'              => $request->name,
            'slug'              => $slug,
            'description'       => $request->description,
            'benefits'          => array_filter($request->benefits ?? []),
            'ingredients'       => $request->ingredients,
            'usage'             => $request->usage,
            'price'             => $request->price,
            'stock'             => $request->stock,
            'is_active'         => $request->boolean('is_active', true),
            'discount_type'     => $request->discount_type,
            'discount_value'    => $request->discount_value,
            'discount_start_at' => $this->localToUtc($request->discount_start_at, $request->timezone_offset),
            'discount_end_at'   => $this->localToUtc($request->discount_end_at, $request->timezone_offset),
            'is_discount_active' => $request->boolean('is_discount_active'),
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
            'name'               => 'required|string|max:255',
            'description'        => 'nullable|string',
            'ingredients'        => 'nullable|string',
            'usage'              => 'nullable|string',
            'price'              => 'required|integer|min:0',
            'stock'              => 'required|integer|min:0',
            'benefits'           => 'nullable|array',
            'images.*'           => 'nullable|image|max:2048',
            'discount_type'      => 'nullable|in:percentage,fixed',
            'discount_value'     => [
                'nullable',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->discount_type === 'percentage' && $value > 100) {
                        $fail('Diskon persen tidak boleh melebihi 100%.');
                    }
                    if ($request->discount_type === 'fixed' && $value > $request->price) {
                        $fail('Diskon nominal tidak boleh melebihi harga asli produk.');
                    }
                },
            ],
            'discount_start_at'  => 'nullable|date',
            'discount_end_at'    => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    if (!$value) return;
                    $end = $this->parseLocalDateTime($value, $request->timezone_offset);
                    // must be > now
                    if ($end->lte(now())) {
                        $fail('Tanggal berakhir diskon harus lebih dari waktu saat ini. Contoh: jika sekarang jam 21:00, maka minimal jam 21:01.');
                        return;
                    }
                    // must be >= discount_start_at
                    $start = $request->discount_start_at;
                    if ($start && $end->lt($this->parseLocalDateTime($start, $request->timezone_offset))) {
                        $fail('Tanggal berakhir diskon tidak boleh kurang dari tanggal mulai diskon.');
                    }
                },
            ],
        ]);

        $product->update([
            'name'               => $request->name,
            'description'        => $request->description,
            'benefits'           => array_filter($request->benefits ?? []),
            'ingredients'        => $request->ingredients,
            'usage'              => $request->usage,
            'price'              => $request->price,
            'stock'              => $request->stock,
            'is_active'          => $request->boolean('is_active'),
            'discount_type'      => $request->discount_type,
            'discount_value'     => $request->discount_value,
            'discount_start_at'  => $this->localToUtc($request->discount_start_at, $request->timezone_offset),
            'discount_end_at'    => $this->localToUtc($request->discount_end_at, $request->timezone_offset),
            'is_discount_active' => $request->boolean('is_discount_active'),
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

    private function parseLocalDateTime(?string $datetime, ?string $tzOffset): ?Carbon
    {
        if (!$datetime) return null;
        $tzOffset = (int) ($tzOffset ?? 0);
        $sign = $tzOffset <= 0 ? '+' : '-';
        $hours = str_pad((string) abs(intdiv($tzOffset, 60)), 2, '0', STR_PAD_LEFT);
        $mins = str_pad((string) abs($tzOffset % 60), 2, '0', STR_PAD_LEFT);
        $timezone = sprintf('%s%s:%s', $sign, $hours, $mins);
        return Carbon::parse($datetime, $timezone);
    }

    private function localToUtc(?string $datetime, ?string $tzOffset): ?string
    {
        if (!$datetime) {
            return null;
        }
        $tzOffset = (int) ($tzOffset ?? 0);
        $sign = $tzOffset <= 0 ? '+' : '-';
        $hours = str_pad((string) abs(intdiv($tzOffset, 60)), 2, '0', STR_PAD_LEFT);
        $mins = str_pad((string) abs($tzOffset % 60), 2, '0', STR_PAD_LEFT);
        $timezone = sprintf('%s%s:%s', $sign, $hours, $mins);
        return Carbon::parse($datetime, $timezone)->utc()->format('Y-m-d H:i:s');
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
