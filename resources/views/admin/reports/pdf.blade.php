<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan {{ $start }} s/d {{ $end }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        h1 { color: #1B4332; font-size: 18px; margin-bottom: 4px; }
        .subtitle { color: #666; font-size: 11px; margin-bottom: 20px; }
        .summary { display: flex; gap: 20px; margin-bottom: 20px; }
        .summary-box { border: 1px solid #ddd; padding: 10px 15px; border-radius: 6px; flex: 1; }
        .summary-box .label { font-size: 10px; color: #888; text-transform: uppercase; }
        .summary-box .value { font-size: 16px; font-weight: bold; color: #1B4332; margin-top: 3px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background: #1B4332; color: white; }
        thead th { padding: 8px 10px; text-align: left; font-size: 11px; }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody td { padding: 7px 10px; border-bottom: 1px solid #eee; }
        .total-row td { font-weight: bold; background: #FEFAE0; color: #1B4332; }
        .footer { margin-top: 20px; font-size: 10px; color: #999; text-align: center; }
        .gold { color: #C9A84C; font-weight: bold; }
    </style>
</head>
<body>
    <h1>🌿 Bharata Herbal ID — Laporan Penjualan</h1>
    <p class="subtitle">Periode: {{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y') }}</p>

    <div class="summary">
        <div class="summary-box">
            <div class="label">Total Pesanan</div>
            <div class="value">{{ $orders->count() }}</div>
        </div>
        <div class="summary-box">
            <div class="label">Total Pendapatan (Dikonfirmasi)</div>
            <div class="value gold">Rp {{ number_format($totalRevenue,0,',','.') }}</div>
        </div>
        <div class="summary-box">
            <div class="label">Rata-rata per Pesanan</div>
            <div class="value">Rp {{ $orders->count() > 0 ? number_format($totalRevenue/$orders->count(),0,',','.') : '0' }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No. Pesanan</th>
                <th>Pelanggan</th>
                <th>Metode Bayar</th>
                <th>Status</th>
                <th>Subtotal</th>
                <th>Ongkir</th>
                <th>Total</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ strtoupper(str_replace('_',' ',$order->payment_method)) }}</td>
                <td>{{ $order->payment_status_label }}</td>
                <td>Rp {{ number_format($order->subtotal,0,',','.') }}</td>
                <td>Rp {{ number_format($order->shipping_cost,0,',','.') }}</td>
                <td class="gold">Rp {{ number_format($order->total_amount,0,',','.') }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="6" style="text-align:right">TOTAL PENDAPATAN DIKONFIRMASI:</td>
                <td colspan="2">Rp {{ number_format($totalRevenue,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>

    <p class="footer">Dicetak pada {{ now()->format('d/m/Y H:i') }} | Bharata Herbal ID © {{ date('Y') }}</p>
</body>
</html>
