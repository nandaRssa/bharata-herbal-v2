<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings              = StoreSetting::getInstance();
        $availablePaymentMethods = StoreSetting::availablePaymentMethods();
        $enabledPaymentMethods = $settings->enabledPaymentMethods();

        return view('admin.settings.index', compact(
            'settings', 'availablePaymentMethods', 'enabledPaymentMethods'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name'      => 'required|string|max:255',
            'wa_number'       => 'nullable|string|max:20',
            'store_address'   => 'nullable|string',
            'operating_hours' => 'nullable|string|max:255',
            'qris_image'      => 'nullable|image|max:2048',
        ]);

        $settings = StoreSetting::getInstance();

        // Handle data dasar toko
        $data = $request->only(['store_name', 'wa_number', 'store_address', 'operating_hours']);

        // Handle upload QRIS
        if ($request->hasFile('qris_image')) {
            if ($settings->qris_image) {
                Storage::disk('public')->delete($settings->qris_image);
            }
            $data['qris_image'] = $request->file('qris_image')->store('settings', 'public');
        }

        // Handle payment methods toggle
        $available       = StoreSetting::availablePaymentMethods();
        $paymentMethods  = [];
        foreach (array_keys($available) as $key) {
            $val = $request->input('payment_method_' . $key, 0);
            $paymentMethods[$key] = (int) $val === 1;
        }
        $data['payment_methods'] = $paymentMethods;

        $settings->update($data);

        return back()->with('success', 'Pengaturan toko berhasil disimpan!');
    }
}
