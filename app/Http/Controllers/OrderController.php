<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function form(Request $request)
    {
        $products = Product::with('images')->where('is_active', true)->get();
        $settings = StoreSetting::getInstance();

        // Kirim daftar metode pembayaran yang aktif ke view
        $enabledPaymentMethods   = $settings->enabledPaymentMethods();
        $availablePaymentMethods = StoreSetting::availablePaymentMethods();

        $selectedProduct = null;
        $items = [];

        if ($request->filled('produk')) {
            $selectedProduct = Product::where('slug', $request->produk)
                ->where('is_active', true)->first();
            if ($selectedProduct) {
                $qty     = $request->input('qty', 1);
                $items[] = [
                    'product_id' => (string) $selectedProduct->id,
                    'quantity'   => (int) $qty
                ];
            }
        } elseif ($request->query('source') === 'cart') {
            $cart = session()->get('cart', []);
            foreach ($cart as $cartItem) {
                $items[] = [
                    'product_id' => (string) $cartItem['id'],
                    'quantity'   => (int) $cartItem['quantity']
                ];
            }
        }

        if (empty($items)) {
            $items[] = ['product_id' => '', 'quantity' => 1];
        }

        return view('public.order.form', compact(
            'products', 'settings', 'selectedProduct', 'items',
            'enabledPaymentMethods', 'availablePaymentMethods'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name'      => 'required|string|max:255',
            'customer_phone'     => 'required|string|max:20',
            'address_street'     => 'required|string',
            'address_kecamatan'  => 'required|string|max:100',
            'address_city'       => 'required|string|max:100',
            'address_province'   => 'required|string|max:100',
            'address_postal'     => 'required|string|max:10',
            'shipping_method'    => 'required|string',
            'payment_method'     => 'required|string',
            'items'              => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        Log::info('Order store request', [
            'payment_method'  => $request->payment_method,
            'shipping_method' => $request->shipping_method,
            'address_province'=> $request->address_province,
            'items'           => $request->items,
        ]);

        DB::beginTransaction();
        try {
            $subtotal  = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $product      = Product::findOrFail($item['product_id']);
                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal    += $itemSubtotal;
                $itemsData[]  = [
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'price'        => $product->price,
                    'quantity'     => $item['quantity'],
                    'subtotal'     => $itemSubtotal,
                ];
                $product->decrement('stock', $item['quantity']);
            }

            $shippingCost = (int) ($request->shipping_cost ?? 0);
            $total        = $subtotal + $shippingCost;

            $order = Order::create([
                'order_number'      => Order::generateOrderNumber(),
                'customer_name'     => $request->customer_name,
                'customer_phone'    => $request->customer_phone,
                'address_street'    => $request->address_street,
                'address_kelurahan' => $request->address_kelurahan,
                'address_kecamatan' => $request->address_kecamatan,
                'address_city'      => $request->address_city,
                'address_province'  => $request->address_province,
                'address_postal'    => $request->address_postal,
                'shipping_method'   => $request->shipping_method,
                'shipping_cost'     => $shippingCost,
                'payment_method'    => $request->payment_method,
                'notes'             => $request->notes,
                'subtotal'          => $subtotal,
                'total_amount'      => $total,
            ]);

            foreach ($itemsData as $item) {
                $order->items()->create($item);
            }

            // Generate Snap Token Midtrans jika bukan COD
            if ($request->payment_method !== 'cod') {
                try {
                    $midtrans = new MidtransService();
                    $order->load('items');
                    $snapToken = $midtrans->createSnapToken($order, $request->payment_method);
                    $order->update(['midtrans_snap_token' => $snapToken]);
                } catch (\Exception $e) {
                    // Jika gagal generate token, order tetap dibuat
                    // Customer masih bisa request token ulang dari halaman sukses
                    Log::error('Gagal generate Midtrans Snap Token saat checkout', [
                        'order_number' => $order->order_number,
                        'error'        => $e->getMessage(),
                    ]);
                }
            }

            DB::commit();
            session()->forget('cart');

            return redirect()->route('order.success', $order->order_number)
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success(string $orderNumber)
    {
        $order    = Order::with('items.product')
            ->where('order_number', $orderNumber)
            ->firstOrFail();
        $settings = StoreSetting::getInstance();

        return view('public.order.success', compact('order', 'settings'));
    }
}
