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
            'phone' => ['required', 'regex:/^[0-9+\-\s]+$/', 'min:8', 'max:20'],
        ], [
            'phone.regex' => 'Nomor HP hanya boleh berisi angka, spasi, tanda plus, atau tanda minus.',
            'phone.min' => 'Nomor HP minimal 8 karakter.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
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

        // Verifikasi kepemilikan order via session (sama seperti verify())
        // Mencegah siapapun yang tahu nomor order bisa submit ulasan palsu
        $verifiedPhone = session('verified_phone');
        $orderPhone    = ltrim(preg_replace('/[^0-9]/', '', $order->customer_phone), '0');

        if (! $verifiedPhone || $verifiedPhone !== $orderPhone) {
            return redirect()
                ->route('order.track.show', $orderNumber)
                ->withErrors(['auth' => 'Silakan verifikasi nomor HP Anda terlebih dahulu sebelum memberikan ulasan.']);
        }

        // Hanya order yang sudah delivered yang bisa direview
        if ($order->order_status !== 'delivered') {
            return redirect()
                ->route('order.track.show', $orderNumber)
                ->withErrors(['auth' => 'Ulasan hanya bisa diberikan setelah pesanan selesai diterima.']);
        }

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
            ->with('success', 'Terima kasih atas ulasan Anda.');
    }

    // ────────────────────────────────────────────────────────────────
    private function buildTimeline(Order $order): array
    {
        $status = $order->order_status;

        $allSteps = [
            ['key' => 'new',        'label' => 'Menunggu Konfirmasi',   'icon' => 'clock-pending'],
            ['key' => 'processing', 'label' => 'Diproses',              'icon' => 'settings'],
            ['key' => 'packing',    'label' => 'Sedang Dikemas',        'icon' => 'package'],
            ['key' => 'shipped',    'label' => 'Sedang Dikirim',        'icon' => 'shipping'],
            ['key' => 'delivered',  'label' => 'Selesai',               'icon' => 'check'],
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
            'phone' => ['required', 'regex:/^[0-9+\-\s]+$/', 'min:8', 'max:20'],
        ], [
            'phone.regex' => 'Nomor HP hanya boleh berisi angka, spasi, tanda plus, atau tanda minus.',
            'phone.min' => 'Nomor HP minimal 8 karakter.',
            'phone.max' => 'Nomor HP maksimal 20 karakter.',
        ]);

        $inputPhone = preg_replace('/[^0-9]/', '', $request->phone);
        $inputNorm = ltrim($inputPhone, '0');

        // Simpan nomor HP yang sudah diverifikasi di session
        session(['verified_phone' => $inputNorm]);

        // Cari pesanan berdasarkan nomor HP (dengan/tanpa kode negara)
        // Gunakan LIMIT 50 untuk mencegah full table scan tak terbatas (DoS)
        $orders = Order::with('items.product')
            ->where(function ($q) use ($inputNorm) {
                $q->where('customer_phone', 'LIKE', '%' . $inputNorm)
                  ->orWhere('customer_phone', 'LIKE', '0' . $inputNorm . '%');
            })
            ->latest()
            ->limit(50)
            ->get();

        return view('public.order.history', [
            'orders' => $orders,
            'phone'  => $request->phone,
        ]);
    }
}
