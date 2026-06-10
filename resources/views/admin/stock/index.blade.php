@extends('layouts.admin')
@section('title','Manajemen Stok')
@section('page-title','Manajemen Stok')
@section('page-subtitle','Update stok produk dan catat perubahan')

@section('content')
<div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <div class="p-4 border-b flex items-center gap-4 text-xs font-semibold" style="background:#f8fdf9">
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span> Kritis (&lt;10)</span>
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span> Rendah (&lt;20)</span>
        <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-green-400 inline-block"></span> Aman (≥20)</span>
    </div>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-xs text-gray-500 uppercase border-b">
                <th class="text-left py-3 px-4">Produk</th>
                <th class="text-left py-3 px-4">Kategori</th>
                <th class="text-center py-3 px-4">Stok</th>
                <th class="text-left py-3 px-4 w-72">Update Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="table-row border-b border-gray-50">
                <td class="py-3 px-4">
                    <div class="flex items-center gap-3">
                        <div class="w-2 h-8 rounded-full flex-shrink-0 {{ $product->stock < 10 ? 'bg-red-400' : ($product->stock < 20 ? 'bg-yellow-400' : 'bg-green-400') }}"></div>
                        <div>
                            <p class="font-semibold" style="color:var(--primary)">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400">{{ $product->slug }}</p>
                        </div>
                    </div>
                </td>
                <td class="py-3 px-4"><span class="badge badge-green text-xs">{{ $product->category_label }}</span></td>
                <td class="py-3 px-4 text-center">
                    <span class="text-2xl font-bold {{ $product->stock < 10 ? 'text-red-600' : ($product->stock < 20 ? 'text-yellow-600' : 'text-green-700') }}" style="font-family:'Cormorant Garamond',serif">
                        {{ $product->stock }}
                    </span>
                </td>
                <td class="py-3 px-4">
                    <form method="POST" action="{{ route('admin.stock.update', $product) }}" class="flex gap-2">
                        @csrf @method('PUT')
                        <input type="number" name="new_stock" value="{{ $product->stock }}" min="0" class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm w-24 focus:outline-none focus:ring-2 focus:ring-green-400">
                        <input type="text" name="note" placeholder="Keterangan..." class="border border-gray-200 rounded-lg px-3 py-1.5 text-sm flex-1 focus:outline-none focus:ring-2 focus:ring-green-400">
                        <button type="submit" class="btn-sm btn-green px-3">✓</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="p-4">{{ $products->links() }}</div>
</div>
@endsection
