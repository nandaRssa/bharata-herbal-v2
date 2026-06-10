<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected Collection $orders;
    protected string $type;

    public function __construct(Collection $orders, string $type = 'daily')
    {
        $this->orders = $orders;
        $this->type   = $type;
    }

    public function collection(): Collection
    {
        return $this->orders;
    }

    public function headings(): array
    {
        return [
            'No. Pesanan',
            'Tanggal',
            'Pelanggan',
            'No. HP',
            'Kota',
            'Jumlah Item',
            'Subtotal (Rp)',
            'Ongkir (Rp)',
            'Total (Rp)',
            'Metode Bayar',
            'Status Bayar',
            'Status Pesanan',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('d/m/Y'),
            $order->customer_name,
            $order->customer_phone,
            $order->address_city ?? '-',
            $order->items->count(),
            $order->subtotal,
            $order->shipping_cost,
            $order->total_amount,
            strtoupper($order->payment_method),
            $order->payment_status_label ?? $order->payment_status,
            $order->status_label ?? $order->order_status,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1C4526']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
