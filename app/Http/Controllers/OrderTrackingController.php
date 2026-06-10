<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Show order detail. If phone was already verified via session, show detail directly.
     * GET /pesanan/{orderNumber}/status
     */
    public function show(string $orderNumber)
    {
        $order = Order::with(['items.product.images'])
            ->where('order_number', $orderNumber)
            ->first();

        if (! $order) {
            abort(404, 'Nomor pesanan tidak ditemukan.');
        }

        // Jika sudah verifikasi nomor HP via session, tampilkan detail langsung
        $verifiedPhone = session('verified_phone');
        $orderPhone    = ltrim(preg_replace('/[^0-9]/', '', $order->customer_phone), '0');

        if ($verifiedPhone && $verifiedPhone === $orderPhone) {
            $steps                     = $this->buildTimeline($order);
            $existingReviewProductIds  = $order->order_status === 'delivered'
                ? Review::where('order_id', $order->id)->pluck('product_id')->toArray()
                : [];
            $settings = \App\Models\StoreSetting::first();

            return view('public.order.track', compact(
                'orderNumber', 'order', 'steps', 'existingReviewProductIds', 'settings'
            ));
        }

        return view('public.order.track', [
            'orderNumber' => $orderNumber,
            'order'       => null,  // not yet verified
        ]);
    }

    /**
     * Verify phone and return order detail.
     * POST /pesanan/{orderNumber}/status
     */
    public function verify(Request $request, string $orderNumber)
    {
        $request->validate([
            'phone' => 'required|string',
        ]);

        $order = Order::with(['items.product.images'])
            ->where('order_number', $orderNumber)
            ->first();

        if (! $order) {
            abort(404);
        }

        // Normalize both phone numbers for comparison
        $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
        $orderPhone = preg_replace('/[^0-9]/', '', $order->customer_phone);

        // Allow matching with/without leading 0 vs 62
        $inputNorm = ltrim($inputPhone, '0');
        $orderNorm = ltrim($orderPhone, '0');

        if ($inputNorm !== $orderNorm) {
            return back()->withErrors(['phone' => 'Nomor HP tidak sesuai dengan data pesanan.']);
        }

        // Simpan nomor HP yang sudah diverifikasi di session
        session(['verified_phone' => $inputNorm]);

        // Build timeline steps
        $steps = $this->buildTimeline($order);

        // Reviews already submitted for this order
        $existingReviewProductIds = $order->order_status === 'delivered'
            ? Review::where('order_id', $order->id)->pluck('product_id')->toArray()
            : [];

        $settings = \App\Models\StoreSetting::first();

        return view('public.order.track', [
            'orderNumber'              => $orderNumber,
            'order'                    => $order,
            'steps'                    => $steps,
            'existingReviewProductIds' => $existingReviewProductIds,
            'settings'                 => $settings,
        ]);
    }

    /**
     * Submit a product review from the tracking page.
     * POST /pesanan/{orderNumber}/ulasan
     */
    public function submitReview(Request $request, string $orderNumber)
    {
        $request->validate([
            'product_id'    => 'required|exists:products,id',
            'rating'        => 'required|integer|min:1|max:5',
            'comment'       => 'nullable|string|max:1000',
            'customer_name' => 'required|string|max:100',
        ]);

        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        // Prevent duplicate reviews
        $already = Review::where('order_id', $order->id)
            ->where('product_id', $request->product_id)
            ->exists();

        if (! $already) {
            Review::create([
                'order_id'      => $order->id,
                'product_id'    => $request->product_id,
                'customer_name' => $request->customer_name,
                'rating'        => $request->rating,
                'comment'       => $request->comment,
                'is_visible'    => true,
            ]);
        }

        return redirect()
            ->route('order.track.show', $orderNumber)
            ->with('success', 'Terima kasih atas ulasan Anda! 🌿');
    }

    // ────────────────────────────────────────────────────────────────
    private function buildTimeline(Order $order): array
    {
        $status = $order->order_status;

        $allSteps = [
            ['key' => 'new',        'label' => 'Menunggu Konfirmasi',   'icon' => '⏳'],
            ['key' => 'processing', 'label' => 'Diproses',              'icon' => '⚙️'],
            ['key' => 'packing',    'label' => 'Sedang Dikemas',        'icon' => '📦'],
            ['key' => 'shipped',    'label' => 'Sedang Dikirim',        'icon' => '🚚'],
            ['key' => 'delivered',  'label' => 'Selesai',               'icon' => '✅'],
        ];

        $order_sequence = ['new', 'processing', 'packing', 'shipped', 'delivered'];
        $currentIndex   = array_search($status, $order_sequence);

        return array_map(function ($step, $i) use ($currentIndex, $status, $order) {
            $stepIndex = array_search($step['key'], ['new','processing','packing','shipped','delivered']);
            $done      = $currentIndex !== false && $stepIndex <= $currentIndex;
            $active    = $step['key'] === $status;

            $extra = '';
            if ($step['key'] === 'shipped' && $order->tracking_number && $active) {
                $extra = 'No. Resi: ' . $order->tracking_number;
            }

            return array_merge($step, [
                'done'   => $done,
                'active' => $active,
                'extra'  => $extra,
            ]);
        }, $allSteps, array_keys($allSteps));
    }

    /**
     * Show the form to check order history.
     * GET /riwayat-pesanan
     */
    public function historyForm()
    {
        return view('public.order.history');
    }

    /**
     * Check order history by phone number.
     * POST /riwayat-pesanan
     */
    public function historyCheck(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|min:8',
        ]);

        $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
        $inputNorm = ltrim($inputPhone, '0');

        // Simpan nomor HP yang sudah diverifikasi di session
        session(['verified_phone' => $inputNorm]);

        $orders = Order::with('items.product')
            ->where('customer_phone', 'LIKE', '%' . $inputNorm)
            ->latest()
            ->get();

        return view('public.order.history', [
            'orders' => $orders,
            'phone'  => $request->phone,
        ]);
    }
}
