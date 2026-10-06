@extends('layouts.public')
@section('title', 'Form Pemesanan')

@push('styles')
<style>
@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
    20%, 40%, 60%, 80% { transform: translateX(5px); }
}
.shake {
    animation: shake 0.4s ease-in-out;
}
.gold-shimmer {
    background: linear-gradient(90deg, #0D2618 0%, #0D2618 30%, #0D2618 50%, #0D2618 70%, #0D2618 100%);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: shimmer 4s ease-in-out infinite;
}
@keyframes shimmer {
    0%, 100% { background-position: 0% center; }
    50% { background-position: 100% center; }
}

/* ===== Address Form ===== */
.address-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.form-group label {
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6A7A72;
}
.form-group .required {
    color: #0D2618;
}
.form-group input[type="text"],
.form-group textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: border-color 0.2s;
    background: #fff;
    color: #1e293b;
}
.form-group input[type="text"]:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #0D2618;
    box-shadow: 0 0 0 3px rgba(13, 38, 24, 0.12);
}
.full-width {
    grid-column: 1 / -1;
}
@media (max-width: 640px) {
    .address-form {
        grid-template-columns: 1fr;
    }
    .full-width {
        grid-column: 1;
    }
    .address-form .form-group label {
        font-size: 0.75rem;
    }
}

/* ===== Search Select ===== */
.search-select {
    position: relative;
}
.search-select-trigger {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e2e8f0;
    border-radius: 8px;
    background: #fff;
    cursor: pointer;
    transition: border-color 0.2s, box-shadow 0.2s;
    user-select: none;
}
.search-select-trigger:hover {
    border-color: #cbd5e1;
}
.search-select-trigger.open {
    border-color: #0D2618;
    box-shadow: 0 0 0 3px rgba(13, 38, 24, 0.12);
}
.search-select-value {
    font-size: 0.9rem;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    flex: 1;
}
.search-select-value.placeholder {
    color: #94a3b8;
}
.search-select-chevron {
    width: 18px;
    height: 18px;
    color: #8A9A92;
    flex-shrink: 0;
    transition: transform 0.25s ease;
}
.search-select-chevron.rotated {
    transform: rotate(180deg);
}
.search-select-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.10);
    z-index: 50;
    overflow: hidden;
}
.search-select-search-wrap {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-bottom: 1px solid #e2e8f0;
}
.search-select-search-icon {
    width: 16px;
    height: 16px;
    color: #94a3b8;
    flex-shrink: 0;
}
.search-select-search-wrap input {
    flex: 1;
    border: none;
    outline: none;
    font-size: 0.85rem;
    color: #1e293b;
    background: transparent;
    padding: 4px 0;
}
.search-select-search-wrap input::placeholder {
    color: #94a3b8;
}
.search-select-options {
    max-height: 200px;
    overflow-y: auto;
}
.search-select-option {
    padding: 10px 14px;
    font-size: 0.85rem;
    color: #1e293b;
    cursor: pointer;
    transition: background 0.15s;
}
.search-select-option:hover,
.search-select-option.highlighted {
    background: #f5f0eb;
}
.search-select-option.selected {
    background: rgba(13, 38, 24, 0.1);
    font-weight: 600;
    color: #0D2618;
}
.search-select-empty {
    padding: 14px;
    text-align: center;
    color: #94a3b8;
    font-size: 0.85rem;
}
</style>
@endpush
@section('content')
<!-- Breadcrumb -->
<div class="bg-white border-b border-slate-100 px-4 py-2.5">
    <nav class="max-w-7xl mx-auto text-xs font-medium text-slate-400 flex items-center gap-1.5">
        <a href="{{ route('home') }}" class="hover:text-[#0D2618] transition duration-150">Beranda</a>
        <span class="text-[#0D2618] font-semibold">/</span>
        <span class="text-slate-600 font-semibold">Pemesanan</span>
    </nav>
</div>

<!-- Header Halaman -->
<div id="checkout-top" class="relative overflow-hidden bg-white pt-10 pb-6">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold mb-5 tracking-wider"
             style="background: rgba(13, 38, 24, 0.12); color: #0D2618; border: 1px solid rgba(13, 38, 24, 0.2);">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Secure Checkout
        </div>
        <h1 class="font-serif font-bold gold-shimmer mb-3" style="font-size: clamp(1.8rem, 3vw, 2.5rem);">
            Penyelesaian Pemesanan
        </h1>
        <p class="text-sm text-slate-500 max-w-xl mx-auto leading-relaxed">
            Lengkapi formulir di bawah ini untuk memproses pengiriman produk herbal Anda.
        </p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 pb-16" x-data="checkoutForm" id="checkout-form">

    <!-- Step Indicator -->
    <div class="flex items-center justify-center mb-10">
        @foreach(['Data Diri', 'Alamat', 'Produk', 'Konfirmasi'] as $i => $label)
        <div class="flex items-center">
            <div class="flex flex-col items-center">
                <div class="w-9 h-9 sm:w-11 sm:h-11 rounded-full flex items-center justify-center font-bold text-xs sm:text-sm transition-all duration-300 border-2 shadow-sm"
                    :class="step >= {{ $i+1 }} ? 'text-white border-transparent' : 'bg-white border-slate-200 text-slate-400'"
                    :style="step >= {{ $i+1 }} ? 'background: linear-gradient(135deg, #0D2618, #0D2618);' : ''">
                    @if ($i == 0)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    @elseif ($i == 1)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    @elseif ($i == 2)
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                </div>
                <div class="hidden sm:block text-[9px] font-bold uppercase tracking-wider mt-1.5 text-center"
                    :class="step >= {{ $i+1 }} ? 'text-[#0D2618]' : 'text-slate-400'">{{ $label }}</div>
            </div>
            @if($i < 3)
            <div class="w-8 sm:w-12 h-0.5 mx-1 sm:mx-2 mb-4 rounded-full transition-all duration-300"
                :style="step > {{ $i+1 }} ? 'background: linear-gradient(90deg, #0D2618, #0D2618)' : 'background: #e2e8f0'"></div>
            @endif
        </div>
        @endforeach
    </div>

    <form method="POST" action="{{ route('order.store') }}" x-ref="checkoutForm" @submit.prevent="submitOrder($event)" novalidate>
        @csrf

        @php
            $errorStep = 1;
            if ($errors->any()) {
                $step1Fields = ['customer_name', 'customer_phone'];
                $step2Fields = ['address_province', 'address_city', 'address_kecamatan', 'address_street', 'address_postal', 'address_kelurahan'];
                $step3Fields = ['items', 'shipping_method', 'shipping_cost', 'payment_method', 'notes'];

                $errorKeys = collect($errors->keys());
                if ($errorKeys->intersect($step3Fields)->isNotEmpty()) $errorStep = 3;
                elseif ($errorKeys->intersect($step2Fields)->isNotEmpty()) $errorStep = 2;
            }
        @endphp
        @if($errors->any())
        <div x-show="Object.keys(fieldErrors).length > 0" class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-5">
            <h4 class="font-bold text-red-700 text-sm mb-2"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg> Pesanan gagal diproses. Periksa data berikut:</h4>
            <ul class="text-red-600 text-xs space-y-1 list-disc pl-4">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <p class="text-xs text-red-500 mt-2 font-medium">Klik <strong>Kembali ke Langkah {{ $errorStep }}</strong> dan periksa kembali isian Anda.</p>
        </div>
        @endif

        <!-- Step 1: Data Diri -->
        <div x-show="step === 1" x-transition class="bg-white rounded-3xl shadow-sm border border-gray-100/80 sm:p-8 p-5 space-y-6">
            <h2 class="font-serif text-2xl font-bold border-b border-slate-100 pb-3 gold-shimmer" style="color:#0D2618;">Data Diri Pelanggan</h2>

            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nama Lengkap *</label>
                    <input type="text" name="customer_name" x-model="form.customer_name" @input="delete fieldErrors.customer_name; resolveFieldErrors()" required
                        placeholder="Contoh: Rian Pratama"
                        class="w-full border rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-[#0D2618]/20 focus:border-[#0D2618]/40 text-slate-700 font-medium transition duration-200"
                        :class="{'border-red-400 bg-red-50': fieldErrors.customer_name}">
                    <template x-if="fieldErrors.customer_name">
                        <p class="text-xs text-red-500 mt-1.5 font-medium" x-text="fieldErrors.customer_name[0]"></p>
                    </template>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Nomor WhatsApp *</label>
                    <input type="tel" name="customer_phone" x-model="form.customer_phone" @input="delete fieldErrors.customer_phone; validateField('customer_phone'); resolveFieldErrors()" required inputmode="tel" pattern="[0-9\s\-\+]+"
                        placeholder="Contoh: 08123456789"
                        class="w-full border rounded-xl px-4 py-3.5 focus:outline-none focus:ring-2 focus:ring-[#0D2618]/20 focus:border-[#0D2618]/40 text-slate-700 font-medium transition duration-200"
                        :class="{'border-red-400 bg-red-50': fieldErrors.customer_phone}">
                    <template x-if="fieldErrors.customer_phone">
                        <p class="text-xs text-red-500 mt-1.5 font-medium" x-text="fieldErrors.customer_phone[0]"></p>
                    </template>
                    <span class="text-[10px] text-slate-400 font-semibold mt-1.5 block">Diperlukan untuk konfirmasi pengiriman via kurir</span>
                </div>
            </div>
        </div>

        <!-- Step 2: Alamat -->
        <div x-show="step === 2" x-transition class="bg-white rounded-3xl shadow-sm border border-gray-100/80 sm:p-8 p-5">
            <h2 class="font-serif text-2xl font-bold border-b border-slate-100 pb-4 mb-6 gold-shimmer" style="color:#0D2618;">Alamat Pengiriman Paket</h2>

            <div class="address-form">
                <!-- Provinsi -->
                <div class="form-group">
                    <label>Provinsi <span class="required">*</span></label>
                    <div class="search-select" x-data="searchSelect({
                        options: provinces,
                        selectedId: selected_prov_id,
                        placeholder: 'Pilih Provinsi'
                    })" @select="selected_prov_id = $event.detail.id; form.address_province = $event.detail.name; fetchRegencies(); delete fieldErrors.address_province; resolveFieldErrors();">
                        <div class="search-select-trigger" @click="toggle" :class="{'open': isOpen}">
                            <span class="search-select-value" :class="{ 'placeholder': !selectedId }" x-text="selectedId ? search : placeholder"></span>
                            <svg class="search-select-chevron" :class="{'rotated': isOpen}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                        </div>
                        <input type="hidden" name="selected_prov_id" x-model="selected_prov_id">
                        <input type="hidden" name="address_province" x-model="form.address_province">
                        <div class="search-select-dropdown" x-show="isOpen" @click.outside="close">
                            <div class="search-select-search-wrap">
                                <svg class="search-select-search-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                                <input type="text" x-model="search" @keydown.escape="close" @keydown.down.prevent="next" @keydown.up.prevent="prev" @keydown.enter="selectHighlighted" placeholder="Cari..." autocomplete="off">
                            </div>
                            <div class="search-select-options">
                                <template x-for="(opt, i) in filteredOptions" :key="opt.id">
                                    <div class="search-select-option" :class="{'highlighted': i === highlightedIdx, 'selected': opt.id == selectedId}" @click="select(opt)" x-text="opt.name"></div>
                                </template>
                                <div class="search-select-empty" x-show="filteredOptions.length === 0">Tidak ditemukan</div>
                            </div>
                        </div>
                    </div>
                    <template x-if="fieldErrors.address_province">
                        <p class="text-xs text-red-500 mt-1.5 font-medium" x-text="fieldErrors.address_province[0]"></p>
                    </template>
                </div>

                <!-- Kota / Kabupaten -->
                <div class="form-group">
                    <label>Kota / Kabupaten <span class="required">*</span></label>
                    <div class="search-select" x-data="searchSelect({
                        options: regencies,
                        selectedId: selected_reg_id,
                        placeholder: 'Pilih Kota / Kabupaten'
                    })" @select="selected_reg_id = $event.detail.id; form.address_city = $event.detail.name; fetchDistricts(); delete fieldErrors.address_city; resolveFieldErrors();">
                        <div class="search-select-trigger" @click="toggle" :class="{'open': isOpen}">
                            <span class="search-select-value" :class="{ 'placeholder': !selectedId }" x-text="selectedId ? search : placeholder"></span>
                            <svg class="search-select-chevron" :class="{'rotated': isOpen}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                        </div>
                        <input type="hidden" name="selected_reg_id" x-model="selected_reg_id">
                        <input type="hidden" name="address_city" x-model="form.address_city">
                        <div class="search-select-dropdown" x-show="isOpen" @click.outside="close">
                            <div class="search-select-search-wrap">
                                <svg class="search-select-search-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                                <input type="text" x-model="search" @keydown.escape="close" @keydown.down.prevent="next" @keydown.up.prevent="prev" @keydown.enter="selectHighlighted" placeholder="Cari..." autocomplete="off">
                            </div>
                            <div class="search-select-options">
                                <template x-for="(opt, i) in filteredOptions" :key="opt.id">
                                    <div class="search-select-option" :class="{'highlighted': i === highlightedIdx, 'selected': opt.id == selectedId}" @click="select(opt)" x-text="opt.name"></div>
                                </template>
                                <div class="search-select-empty" x-show="filteredOptions.length === 0">Tidak ditemukan</div>
                            </div>
                        </div>
                    </div>
                    <template x-if="fieldErrors.address_city">
                        <p class="text-xs text-red-500 mt-1.5 font-medium" x-text="fieldErrors.address_city[0]"></p>
                    </template>
                </div>

                <!-- Kecamatan -->
                <div class="form-group">
                    <label>Kecamatan <span class="required">*</span></label>
                    <div class="search-select" x-data="searchSelect({
                        options: districts,
                        selectedId: selected_dist_id,
                        placeholder: 'Pilih Kecamatan'
                    })" @select="selected_dist_id = $event.detail.id; form.address_kecamatan = $event.detail.name; fetchVillages(); delete fieldErrors.address_kecamatan; resolveFieldErrors();">
                        <div class="search-select-trigger" @click="toggle" :class="{'open': isOpen}">
                            <span class="search-select-value" :class="{ 'placeholder': !selectedId }" x-text="selectedId ? search : placeholder"></span>
                            <svg class="search-select-chevron" :class="{'rotated': isOpen}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                        </div>
                        <input type="hidden" name="selected_dist_id" x-model="selected_dist_id">
                        <input type="hidden" name="address_kecamatan" x-model="form.address_kecamatan">
                        <div class="search-select-dropdown" x-show="isOpen" @click.outside="close">
                            <div class="search-select-search-wrap">
                                <svg class="search-select-search-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                                <input type="text" x-model="search" @keydown.escape="close" @keydown.down.prevent="next" @keydown.up.prevent="prev" @keydown.enter="selectHighlighted" placeholder="Cari..." autocomplete="off">
                            </div>
                            <div class="search-select-options">
                                <template x-for="(opt, i) in filteredOptions" :key="opt.id">
                                    <div class="search-select-option" :class="{'highlighted': i === highlightedIdx, 'selected': opt.id == selectedId}" @click="select(opt)" x-text="opt.name"></div>
                                </template>
                                <div class="search-select-empty" x-show="filteredOptions.length === 0">Tidak ditemukan</div>
                            </div>
                        </div>
                    </div>
                    <template x-if="fieldErrors.address_kecamatan">
                        <p class="text-xs text-red-500 mt-1.5 font-medium" x-text="fieldErrors.address_kecamatan[0]"></p>
                    </template>
                </div>

                <!-- Kelurahan / Desa -->
                <div class="form-group">
                    <label>Kelurahan / Desa</label>
                    <div class="search-select" x-data="searchSelect({
                        options: villages,
                        selectedId: form.address_kelurahan,
                        placeholder: 'Pilih Kelurahan / Desa'
                    })" @select="form.address_kelurahan = $event.detail.name; delete fieldErrors.address_kelurahan; resolveFieldErrors();">
                        <div class="search-select-trigger" @click="toggle" :class="{'open': isOpen}">
                            <span class="search-select-value" :class="{ 'placeholder': !selectedId }" x-text="selectedId ? search : placeholder"></span>
                            <svg class="search-select-chevron" :class="{'rotated': isOpen}" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/></svg>
                        </div>
                        <input type="hidden" name="address_kelurahan" x-model="form.address_kelurahan">
                        <div class="search-select-dropdown" x-show="isOpen" @click.outside="close">
                            <div class="search-select-search-wrap">
                                <svg class="search-select-search-icon" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd"/></svg>
                                <input type="text" x-model="search" @keydown.escape="close" @keydown.down.prevent="next" @keydown.up.prevent="prev" @keydown.enter="selectHighlighted" placeholder="Cari..." autocomplete="off">
                            </div>
                            <div class="search-select-options">
                                <template x-for="(opt, i) in filteredOptions" :key="opt.id">
                                    <div class="search-select-option" :class="{'highlighted': i === highlightedIdx, 'selected': opt.name == selectedId}" @click="select(opt)" x-text="opt.name"></div>
                                </template>
                                <div class="search-select-empty" x-show="filteredOptions.length === 0">Tidak ditemukan</div>
                            </div>
                        </div>
                    </div>
                    <template x-if="fieldErrors.address_kelurahan">
                        <p class="text-xs text-red-500 mt-1.5 font-medium" x-text="fieldErrors.address_kelurahan[0]"></p>
                    </template>
                </div>

                <!-- Kode Pos -->
                <div class="form-group">
                    <label>Kode Pos <span class="required">*</span></label>
                    <input type="text" name="address_postal" x-model="form.address_postal" @input="delete fieldErrors.address_postal; validateField('address_postal'); resolveFieldErrors()" required inputmode="numeric" pattern="[0-9]{5}" placeholder="12345" maxlength="10">
                    <template x-if="fieldErrors.address_postal">
                        <p class="text-xs text-red-500 mt-1.5 font-medium" x-text="fieldErrors.address_postal[0]"></p>
                    </template>
                </div>

                <!-- Nama Jalan -->
                <div class="form-group full-width">
                    <label>Nama Jalan, Blok, RT/RW, No. Rumah <span class="required">*</span></label>
                    <textarea name="address_street" x-model="form.address_street" @input="delete fieldErrors.address_street; resolveFieldErrors()" required rows="2" placeholder="Contoh: Jl. Diponegoro No. 123, Blok C4, RT 02/RW 05"></textarea>
                    <template x-if="fieldErrors.address_street">
                        <p class="text-xs text-red-500 mt-1.5 font-medium" x-text="fieldErrors.address_street[0]"></p>
                    </template>
                </div>
            </div>
        </div>


        <!-- Step 3: Produk & Pengiriman -->
        <div x-show="step === 3" x-transition class="bg-white rounded-3xl shadow-sm border border-gray-100/80 sm:p-8 p-5 space-y-6">
            <h2 class="font-serif text-2xl font-bold border-b border-slate-100 pb-3 gold-shimmer" style="color:#0D2618;">Daftar Produk &amp; Pengiriman</h2>

            <div class="space-y-4">

                <template x-if="fieldErrors.items">
                    <p class="text-xs text-red-500 font-medium" x-text="fieldErrors.items[0]"></p>
                </template>
                <template x-for="(item, idx) in form.items" :key="idx">
                    <div class="flex gap-3 items-start p-4 rounded-2xl border border-slate-100 bg-slate-50/50">
                        <div class="flex-1 space-y-1">
                            <select :name="'items[' + idx + '][product_id]'" x-model="item.product_id" @change="delete fieldErrors['items.' + idx + '.product_id']; resolveFieldErrors()" required
                                class="w-full border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-600/10 text-slate-700 font-medium"
                                :class="{'border-red-400 bg-red-50': fieldErrors['items.' + idx + '.product_id']}">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} &mdash; {{ $p->formatted_effective_price }}</option>
                                @endforeach
                            </select>
                            <template x-if="fieldErrors['items.' + idx + '.product_id']">
                                <p class="text-xs text-red-500 font-medium" x-text="fieldErrors['items.' + idx + '.product_id'][0]"></p>
                            </template>
                        </div>
                        <div class="w-20 space-y-1">
                            <input type="number" :name="'items[' + idx + '][quantity]'" x-model.number="item.quantity" @input="delete fieldErrors['items.' + idx + '.quantity']; validateField('items.' + idx + '.quantity'); resolveFieldErrors()" min="1" inputmode="numeric" pattern="[0-9]+"
                                class="w-full border border-slate-200 bg-white rounded-lg px-3 py-2 text-sm text-center focus:outline-none focus:ring-2 focus:ring-emerald-600/10 text-slate-700 font-bold"
                                :class="{'border-red-400 bg-red-50': fieldErrors['items.' + idx + '.quantity']}">
                            <template x-if="fieldErrors['items.' + idx + '.quantity']">
                                <p class="text-xs text-red-500 font-medium text-center" x-text="fieldErrors['items.' + idx + '.quantity'][0]"></p>
                            </template>
                        </div>
                        <button type="button" @click="removeItem(idx)" class="text-rose-500 hover:text-rose-700 p-2 text-sm font-bold transition flex-shrink-0 mt-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </div>
                </template>

                <button type="button" @click="addItem" class="text-sm font-bold flex items-center gap-1.5 transition hover:opacity-85" style="color: var(--primary);">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg> Tambah Item Produk Lain
                </button>
            </div>

            <!-- Metode Pengiriman -->
            <div class="border-t border-slate-100 pt-6 space-y-4">
                <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10l2-1m5 1a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4zm0 0V9l-3-3m0 0h-3m3 0v3"/></svg> Opsi Kurir Ekspedisi</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3"
                    :class="{'px-3 py-2 rounded-lg border border-red-400 bg-red-50': fieldErrors.shipping_method}">
                    @foreach([['JNE','JNE Regular',0],['JNT','J&T Express',12000],['SICEPAT','SiCepat',13000],['GOSEND','GoSend (Same Day)',25000]] as [$val,$label,$cost])
                    <label class="flex items-center justify-between p-4 border rounded-xl cursor-pointer transition duration-200"
                        :class="form.shipping_method === '{{ $val }}' ? 'border-[#0D2618] bg-[#F0EDE8]/50 ring-1 ring-[#0D2618]/20' : 'border-slate-200 hover:border-[#0D2618]'"
                        @click="form.shipping_method='{{ $val }}'; form.shipping_cost={{ $cost }}; delete fieldErrors.shipping_method; resolveFieldErrors()">
                        <input type="radio" name="shipping_method" value="{{ $val }}" class="sr-only">
                        <div>
                            <div class="font-bold text-slate-800 text-sm">{{ $label }}</div>
                        </div>
                        <div class="font-bold text-[#0D2618] text-sm">{{ 'Rp ' . number_format($cost,0,',','.') }}</div>
                    </label>
                    @endforeach


                </div>
                <template x-if="fieldErrors.shipping_method">
                    <p class="text-xs text-red-500 font-medium" x-text="fieldErrors.shipping_method[0]"></p>
                </template>
                <input type="hidden" name="shipping_cost" x-bind:value="form.shipping_cost">
                <input type="hidden" name="shipping_method" x-bind:value="form.shipping_method">
            </div>


            <!-- Metode Pembayaran -->
            <div class="border-t border-slate-100 pt-6 space-y-5">
                <h3 class="font-bold text-slate-700 text-sm uppercase tracking-wider"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg> Metode Pembayaran</h3>

                @php
                    $eWalletMethods = [];
                    $mBankingMethods = [];
                    $codMethod = null;
                    foreach ($availablePaymentMethods as $key => $method) {
                        if (!isset($enabledPaymentMethods[$key])) continue;
                        if ($method['group'] === 'e_wallet') $eWalletMethods[$key] = $method;
                        elseif ($method['group'] === 'm_banking') $mBankingMethods[$key] = $method;
                        elseif ($key === 'cod') $codMethod = [$key => $method];
                    }
                @endphp

                @if(!empty($eWalletMethods))
                <div>
                    <h4 class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> E-Wallet & QRIS
                    </h4>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-2.5">
                        @foreach($eWalletMethods as $key => $method)
                        <label class="flex flex-col items-center justify-center text-center p-3 border rounded-xl cursor-pointer transition duration-200"
                            :class="form.payment_method === '{{ $key }}' ? 'border-[#0D2618] bg-[#F0EDE8]/50 ring-1 ring-[#0D2618]/20' : 'border-slate-200 hover:border-[#0D2618] hover:bg-slate-50'"
                            @click="form.payment_method='{{ $key }}'; delete fieldErrors.payment_method; resolveFieldErrors()">
                            <input type="radio" name="payment_method" value="{{ $key }}" class="sr-only">
                            <x-icon :name="$method['icon']" class="w-5 h-5 mb-1" style="color:#0D2618;" />
                            <span class="text-[11px] font-bold text-slate-700 leading-tight">{{ $method['label'] }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($mBankingMethods))
                <div>
                    <h4 class="text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11m16-11v11M8 14v3m4-3v3m4-3v3"/></svg> M-Banking & Bank Transfer
                    </h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                        @foreach($mBankingMethods as $key => $method)
                        <label class="flex items-center justify-center text-center p-3 border rounded-xl cursor-pointer transition duration-200"
                            :class="form.payment_method === '{{ $key }}' ? 'border-[#0D2618] bg-[#F0EDE8]/50 ring-1 ring-[#0D2618]/20' : 'border-slate-200 hover:border-[#0D2618] hover:bg-slate-50'"
                            @click="form.payment_method='{{ $key }}'; delete fieldErrors.payment_method; resolveFieldErrors()">
                            <input type="radio" name="payment_method" value="{{ $key }}" class="sr-only">
                            <div>
                                <x-icon :name="$method['icon']" class="w-5 h-5 mb-0.5 mx-auto" style="color:#0D2618;" />
                                <span class="text-[11px] font-bold text-slate-700 leading-tight">{{ $method['label'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(!empty($codMethod))
                <div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                        @foreach($codMethod as $key => $method)
                        <label class="flex items-center justify-center text-center p-3 border rounded-xl cursor-pointer transition duration-200"
                            :class="form.payment_method === '{{ $key }}' ? 'border-[#0D2618] bg-[#F0EDE8]/50 ring-1 ring-[#0D2618]/20' : 'border-slate-200 hover:border-[#0D2618] hover:bg-slate-50'"
                            @click="form.payment_method='{{ $key }}'; delete fieldErrors.payment_method; resolveFieldErrors()">
                            <input type="radio" name="payment_method" value="{{ $key }}" class="sr-only">
                            <div>
                                <x-icon :name="$method['icon']" class="w-5 h-5 mb-0.5 mx-auto" style="color:#0D2618;" />
                                <span class="text-[11px] font-bold text-slate-700">{{ $method['label'] }}</span>
                                <div class="text-[10px] text-amber-600 font-medium">Bayar di Tempat</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <input type="hidden" name="payment_method" x-bind:value="form.payment_method">
                <template x-if="fieldErrors.payment_method">
                    <p class="text-xs text-red-500 font-medium" x-text="fieldErrors.payment_method[0]"></p>
                </template>
            </div>


            <div class="border-t border-slate-100 pt-6">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Catatan Tambahan (Opsional)</label>
                    <textarea name="notes" x-model="form.notes" @input="delete fieldErrors.notes; resolveFieldErrors()" rows="2" placeholder="Contoh: Kirim setelah jam 5 sore atau titipkan ke satpam"
                        class="w-full border rounded-xl px-4 py-3.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#0D2618]/20 focus:border-[#0D2618]/40 text-slate-700 font-medium transition duration-200"
                        :class="{'border-red-400 bg-red-50': fieldErrors.notes}"></textarea>
                    <template x-if="fieldErrors.notes">
                        <p class="text-xs text-red-500 mt-1.5 font-medium" x-text="fieldErrors.notes[0]"></p>
                    </template>
            </div>
        </div>

        <!-- Step 4: Review -->
        <div x-show="step === 4" x-transition class="bg-white rounded-3xl shadow-sm border border-gray-100/80 sm:p-8 p-5 space-y-6">
            <h2 class="font-serif text-2xl font-bold border-b border-slate-100 pb-3 gold-shimmer" style="color:#0D2618;">Konfirmasi Data & Pesanan</h2>

            <div class="space-y-5 text-sm">
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100/60">
                    <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-2">Informasi Penerima</h3>
                    <p class="text-slate-800 font-bold text-base"><span x-text="form.customer_name"></span></p>
                    <p class="text-slate-500 font-medium mt-1"><svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> WhatsApp: <span x-text="form.customer_phone"></span></p>
                </div>

                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100/60">
                    <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 mb-2">Tujuan Pengiriman</h3>
                    <p class="text-slate-700 leading-relaxed font-medium" x-text="form.address_street + ', ' + form.address_kelurahan + ', ' + form.address_kecamatan + ', ' + form.address_city + ', ' + form.address_province + ' ' + form.address_postal"></p>
                </div>

                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-100/60 space-y-4">
                    <h3 class="font-bold text-xs uppercase tracking-widest text-slate-400 border-b border-slate-200/50 pb-2">Rincian Pembayaran</h3>
                    <template x-for="item in form.items">
                        <div class="flex justify-between items-center text-slate-600 text-sm font-medium" x-show="item.product_id">
                            <span x-text="(getProduct(item.product_id)?.name || '') + ' (x' + item.quantity + ')'"></span>
                            <span class="font-bold text-slate-800" x-text="formatRp(((getProduct(item.product_id)?.effective_price || getProduct(item.product_id)?.price || 0)) * item.quantity)"></span>
                        </div>
                    </template>
                    <div class="flex justify-between items-center text-slate-600 text-sm font-medium pt-2 border-t border-slate-200/40">
                        <span>Ongkos Kirim (<span class="font-bold" x-text="form.shipping_method"></span>)</span>
                        <span class="font-bold text-slate-800" x-text="formatRp(form.shipping_cost)"></span>
                    </div>
                    <div class="flex justify-between items-center pt-3 border-t border-slate-200 font-bold text-lg text-slate-800">
                        <span>Total Pembayaran (<span class="capitalize text-slate-700" x-text="getPaymentLabel(form.payment_method)"></span>)</span>
                        <span style="color: var(--primary);" x-text="formatRp(getTotal())"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex flex-col-reverse sm:flex-row justify-between gap-4 mt-8">
            <button type="button" @click="prevStep" x-show="step > 1"
                class="w-full sm:w-auto px-6 py-3.5 rounded-xl font-bold border border-slate-200 text-slate-500 hover:bg-slate-50 hover:text-slate-700 transition">
                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg> Kembali
            </button>
            <div x-show="step === 1" class="hidden sm:block flex-grow"></div>

            <button type="button" @click="nextStep" x-show="step < 4"
                class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold transition duration-200 shadow-md hover:shadow-lg"
                :class="{'shake': shaking}"
                style="background: linear-gradient(135deg, #0D2618, #0D2618); color: #FFFFFF;">
                Lanjutkan Langkah <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>

            <button type="submit" x-show="step === 4" :disabled="isSubmitting"
                class="w-full sm:w-auto px-10 py-4 rounded-xl text-base font-bold transition duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
                :class="isSubmitting ? 'opacity-70 cursor-not-allowed' : ''"
                style="background: linear-gradient(135deg, #0D2618, #0D2618); color: #FFFFFF;">
                <template x-if="!isSubmitting">
                    <span><svg class="w-5 h-5 inline" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg> Selesaikan Pemesanan & Bayar</span>
                </template>
                <template x-if="isSubmitting">
                    <span><svg class="w-5 h-5 inline animate-spin" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Memproses...</span>
                </template>
            </button>
        </div>
    </form>
</div>

<style>
    html { scroll-behavior: auto !important; }
</style>
<script>
    if (history.scrollRestoration) history.scrollRestoration = 'manual';

    function scrollToCheckout() {
        var target = document.getElementById('checkout-top');
        if (target) {
            // Scroll element ke atas viewport dengan offset kecil
            var offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 8;
            // Fallback multi-method agar bekerja di iOS Safari & Android
            try { window.scrollTo({ top: offsetTop, behavior: 'instant' }); } catch(e) {}
            document.documentElement.scrollTop = offsetTop;
            document.body.scrollTop = offsetTop;
        } else {
            // Fallback ke top jika elemen belum ada
            try { window.scrollTo({ top: 0, behavior: 'instant' }); } catch(e) {}
            document.documentElement.scrollTop = 0;
            document.body.scrollTop = 0;
        }
    }

    // Jalankan sesegera mungkin
    scrollToCheckout();

    // Jalankan setelah DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        scrollToCheckout();
        // Ulangi beberapa kali untuk mengatasi layout shift mobile
        var count = 0;
        var iv = setInterval(function() {
            scrollToCheckout();
            if (++count >= 15) clearInterval(iv);
        }, 80);
    });

    // Mengatasi bfcache di iOS (kembali dari halaman lain)
    window.addEventListener('pageshow', function(e) {
        scrollToCheckout();
        var count = 0;
        var iv = setInterval(function() {
            scrollToCheckout();
            if (++count >= 10) clearInterval(iv);
        }, 80);
    });
</script>
@endsection

@php
    $initialForm = [
        'customer_name' => old('customer_name', ''),
        'customer_phone' => old('customer_phone', ''),
        'address_street' => old('address_street', ''),
        'address_kelurahan' => old('address_kelurahan', ''),
        'address_kecamatan' => old('address_kecamatan', ''),
        'address_city' => old('address_city', ''),
        'address_province' => old('address_province', ''),
        'address_postal' => old('address_postal', ''),
        'shipping_method' => old('shipping_method', 'JNE'),
        'shipping_cost' => (int) old('shipping_cost', 0),
        'payment_method' => old('payment_method', array_key_first($enabledPaymentMethods) ?? 'bank_transfer'),
        'notes' => old('notes', ''),
        'items' => old('items', $items),
    ];
    $fieldErrors = $errors->any() ? $errors->getBag('default')->messages() : [];
@endphp
@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('searchSelect', (initial = {}) => ({
            options: initial.options || [],
            selectedId: initial.selectedId ?? null,
            placeholder: initial.placeholder || 'Pilih...',
            search: '',
            isOpen: false,
            highlightedIdx: -1,
            filteredOptions: [],
            init() {
                this.$watch('search', () => { this.filterOptions(); });
                this.$watch('options', () => {
                    this.filterOptions();
                    if (this.selectedId) {
                        const found = this.options.find(o => String(o.id) === String(this.selectedId));
                        if (found) this.search = found.name;
                    }
                });
                this.filterOptions();
                if (this.selectedId) {
                    const found = this.options.find(o => String(o.id) === String(this.selectedId));
                    if (found) this.search = found.name;
                }
            },
            filterOptions() {
                const q = (this.search || '').toLowerCase().trim();
                this.filteredOptions = q
                    ? (this.options || []).filter(o => (o.name || '').toLowerCase().includes(q))
                    : (this.options || []).slice();
                this.highlightedIdx = -1;
            },
            open() { this.isOpen = true; this.filterOptions(); this.$nextTick(() => { const i = this.$el.querySelector('.search-select-search-wrap input'); if (i) i.focus(); }); },
            close() {
                this.isOpen = false;
                this.highlightedIdx = -1;
                if (this.selectedId) {
                    const found = this.options.find(o => String(o.id) === String(this.selectedId));
                    this.search = found ? found.name : '';
                } else {
                    this.search = '';
                }
            },
            toggle() { if (this.isOpen) { this.close(); } else { this.open(); } },
            select(opt) {
                if (!opt) return;
                this.search = opt.name || '';
                this.selectedId = opt.id;
                this.$dispatch('select', { id: opt.id, name: opt.name });
                this.close();
            },
            next() {
                if (!this.isOpen || !this.filteredOptions.length) return;
                this.highlightedIdx = Math.min(this.highlightedIdx + 1, this.filteredOptions.length - 1);
            },
            prev() {
                if (!this.isOpen || !this.filteredOptions.length) return;
                this.highlightedIdx = Math.max(this.highlightedIdx - 1, 0);
            },
            selectHighlighted() {
                if (this.highlightedIdx >= 0 && this.highlightedIdx < this.filteredOptions.length) {
                    this.select(this.filteredOptions[this.highlightedIdx]);
                }
            }
        }));
        Alpine.data('checkoutForm', () => ({
            step: {{ $errorStep }},
            totalSteps: 4,
            isSubmitting: false,
            shaking: false,
            provinces: [],
            regencies: [],
            districts: [],
            villages: [],
            selected_prov_id: '{{ old('selected_prov_id', '') }}',
            selected_reg_id: '{{ old('selected_reg_id', '') }}',
            selected_dist_id: '{{ old('selected_dist_id', '') }}',
            form: @json($initialForm),
            fieldErrors: @json($fieldErrors),
            paymentLabels: @json(collect($availablePaymentMethods)->mapWithKeys(fn($m, $k) => [$k => $k === 'bank_transfer' ? 'Bank Transfer' : ($k === 'cod' ? 'COD' : $m['label'])])),
            products: @json($products),
            getProduct(id) {
                return this.products.find(p => p.id == id);
            },
            getPaymentLabel(key) {
                return this.paymentLabels[key] || key.replace(/_/g, ' ');
            },
            getSubtotal() {
                return this.form.items.reduce((sum, item) => {
                    const p = this.getProduct(item.product_id);
                    const price = p ? (p.effective_price || p.price) : 0;
                    return sum + (price * item.quantity);
                }, 0);
            },
            getTotal() {
                return this.getSubtotal() + parseInt(this.form.shipping_cost);
            },
            formatRp(n) {
                return 'Rp ' + parseInt(n).toLocaleString('id-ID');
            },
            addItem() {
                this.form.items.push({ product_id: '', quantity: 1 });
            },
            removeItem(i) {
                if (this.form.items.length > 1) {
                    this.form.items.splice(i, 1);
                }
            },
            syncSelectedAddress() {
                this.form.address_province = this.provinces.find(p => p.id == this.selected_prov_id)?.name || this.form.address_province || '';
                this.form.address_city = this.regencies.find(r => r.id == this.selected_reg_id)?.name || this.form.address_city || '';
                this.form.address_kecamatan = this.districts.find(d => d.id == this.selected_dist_id)?.name || this.form.address_kecamatan || '';
            },
            hasErrorsInStep(targetStep) {
                const stepKeys = {
                    1: ['customer_name', 'customer_phone'],
                    2: ['address_province', 'address_city', 'address_kecamatan', 'address_kelurahan', 'address_street', 'address_postal'],
                    3: ['shipping_method', 'payment_method', 'notes'],
                };
                const keys = stepKeys[targetStep] || [];
                if (keys.some(k => this.fieldErrors[k])) return true;
                if (targetStep === 3 && Object.keys(this.fieldErrors).some(k => k === 'items' || k.startsWith('items.'))) return true;
                return false;
            },
            validateStep(targetStep = this.step) {
                this.syncSelectedAddress();

                if (this.hasErrorsInStep(targetStep)) return false;

                if (targetStep === 1) {
                    if (!this.form.customer_name.trim() || !this.form.customer_phone.trim()) {
                        Alpine.store('modal').alert('Silakan lengkapi kolom bertanda bintang (*).', 'error');
                        this.step = 1;
                        return false;
                    }
                }

                if (targetStep === 2) {
                    if (!this.form.address_province || !this.form.address_city || !this.form.address_kecamatan || !this.form.address_street.trim() || !this.form.address_postal.trim()) {
                        Alpine.store('modal').alert('Silakan lengkapi alamat pengiriman Anda secara lengkap (Pilih provinsi, kota, kecamatan, dan isi jalan serta kode pos).', 'error');
                        this.step = 2;
                        return false;
                    }
                }

                if (targetStep === 3) {
                    const hasInvalid = this.form.items.some(item => !item.product_id || !item.quantity || item.quantity < 1);
                    if (hasInvalid) {
                        Alpine.store('modal').alert('Silakan pilih produk yang valid dan tentukan jumlahnya.', 'error');
                        this.step = 3;
                        return false;
                    }

                    if (!this.form.shipping_method || !this.form.payment_method) {
                        Alpine.store('modal').alert('Silakan pilih metode pengiriman dan pembayaran.', 'error');
                        this.step = 3;
                        return false;
                    }
                }

                return true;
            },
            submitOrder(event) {
                if (this.isSubmitting) return;

                for (let i = 1; i <= 3; i++) {
                    if (!this.validateStep(i)) return;
                }

                this.isSubmitting = true;
                this.$nextTick(() => event.target.submit());
            },
            isFieldValid(key) {
                if (key === 'customer_name') return this.form.customer_name.trim().length > 0;
                if (key === 'customer_phone') return /^[0-9+\-\s]+$/.test(this.form.customer_phone.trim());
                if (key === 'address_province' || key === 'address_city' || key === 'address_kecamatan' || key === 'address_kelurahan') return !!this.form[key];
                if (key === 'address_street') return this.form.address_street.trim().length > 0;
                if (key === 'address_postal') return /^[0-9]+$/.test(this.form.address_postal.trim());
                if (key === 'shipping_method') return !!this.form.shipping_method;
                if (key === 'payment_method') return !!this.form.payment_method;
                if (key === 'notes') return true;
                if (key === 'items') return this.form.items.length > 0 && this.form.items.every(i => i.product_id && i.quantity >= 1);
                if (key.startsWith('items.')) {
                    const parts = key.split('.');
                    const idx = parseInt(parts[1]), field = parts[2];
                    const item = this.form.items[idx];
                    if (!item) return true;
                    if (field === 'product_id') return !!item.product_id;
                    if (field === 'quantity') return item.quantity >= 1;
                }
                return true;
            },
            resolveFieldErrors() {
                const keys = Object.keys(this.fieldErrors);
                if (keys.length === 0) return;
                const allResolved = keys.every(key => this.isFieldValid(key));
                if (allResolved) this.fieldErrors = {};
            },
            validateField(field) {
                if (field === 'customer_phone' && this.form.customer_phone && !/^[0-9+\-\s]*$/.test(this.form.customer_phone)) {
                    this.fieldErrors.customer_phone = ['Nomor WhatsApp hanya boleh berisi angka, spasi, tanda plus, atau tanda minus.'];
                    return false;
                }
                if (field === 'address_postal' && this.form.address_postal && !/^[0-9]*$/.test(this.form.address_postal)) {
                    this.fieldErrors.address_postal = ['Kode pos hanya boleh berisi angka.'];
                    return false;
                }
                if (field.startsWith('items.') && field.endsWith('.quantity')) {
                    const idx = parseInt(field.split('.')[1]);
                    const item = this.form.items[idx];
                    if (item && (isNaN(item.quantity) || item.quantity < 1)) {
                        this.fieldErrors[field] = ['Jumlah harus berupa angka minimal 1.'];
                        return false;
                    }
                }
                return true;
            },
            async init() {
                try {
                    const res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
                    const data = await res.json();
                    this.provinces.length = 0;
                    this.provinces.push(...data);
                } catch(e) { console.error('Gagal memuat provinsi'); }

                if (this.selected_prov_id) {
                    try {
                        const r = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.selected_prov_id}.json`);
                        const rd = await r.json();
                        this.regencies.length = 0;
                        this.regencies.push(...rd);
                    } catch(e) {}
                    if (this.selected_reg_id) {
                        try {
                            const d = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selected_reg_id}.json`);
                            const dd = await d.json();
                            this.districts.length = 0;
                            this.districts.push(...dd);
                        } catch(e) {}
                        if (this.selected_dist_id) {
                            try {
                                const v = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.selected_dist_id}.json`);
                                const vd = await v.json();
                                this.villages.length = 0;
                                this.villages.push(...vd);
                            } catch(e) {}
                        }
                    }
                }

                // sengaja dikosongkan — scroll handle ada di script bottom
            },
            async fetchRegencies() {
                this.form.address_province = this.provinces.find(p => p.id === this.selected_prov_id)?.name || '';
                this.selected_reg_id = ''; this.selected_dist_id = '';
                this.form.address_city = ''; this.form.address_kecamatan = ''; this.form.address_kelurahan = '';
                this.regencies.length = 0; this.districts.length = 0; this.villages.length = 0;
                if(this.selected_prov_id) {
                    try {
                        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${this.selected_prov_id}.json`);
                        const data = await res.json();
                        this.regencies.push(...data);
                    } catch(e) {}
                }
            },
            async fetchDistricts() {
                this.form.address_city = this.regencies.find(r => r.id === this.selected_reg_id)?.name || '';
                this.selected_dist_id = '';
                this.form.address_kecamatan = ''; this.form.address_kelurahan = '';
                this.districts.length = 0; this.villages.length = 0;
                if(this.selected_reg_id) {
                    try {
                        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${this.selected_reg_id}.json`);
                        const data = await res.json();
                        this.districts.push(...data);
                    } catch(e) {}
                }
            },
            async fetchVillages() {
                this.form.address_kecamatan = this.districts.find(d => d.id === this.selected_dist_id)?.name || '';
                this.form.address_kelurahan = '';
                this.villages.length = 0;
                if(this.selected_dist_id) {
                    try {
                        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${this.selected_dist_id}.json`);
                        const data = await res.json();
                        this.villages.push(...data);
                    } catch(e) {}
                }
            },
            scrollToTop() {
                var target = document.getElementById('checkout-top');
                if (target) {
                    var offsetTop = target.getBoundingClientRect().top + window.pageYOffset - 8;
                    try { window.scrollTo({ top: offsetTop, behavior: 'instant' }); } catch(e) {}
                    document.documentElement.scrollTop = offsetTop;
                    document.body.scrollTop = offsetTop;
                }
            },
            nextStep() {
                if (!this.validateStep(this.step)) {
                    this.shaking = true;
                    setTimeout(() => this.shaking = false, 500);
                    return;
                }

                if (this.step < this.totalSteps) {
                    this.step++;
                    this.$nextTick(() => this.scrollToTop());
                }
            },
            prevStep() {
                if (this.step > 1) {
                    this.step--;
                }
            }
        }));
    });
</script>
@endpush

