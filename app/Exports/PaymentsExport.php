<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Payment::with(['order.stock.product', 'order.stock.color', 'order.stock.size'])
            ->get()
            ->map(function ($payment) {
                return [
                    'Order RefID'   => $payment->order?->order_ref ?? '-',
                    'Product Name'  => $payment->order->stock->product->product_name ?? '-',
                    'Color'         => $payment->order?->stock?->color?->color_name ?? '-',
                    'Size'          => $payment->order?->stock?->size?->size ?? '-',
                    'Paid Date'     => $payment->created_at,
                    'Amount'        => $payment->amount,
                    'Status'        => $payment->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Product Name',
            'Color',
            'Size',
            'Paid Date',
            'Amount',
            'Payment Method',
        ];
    }
}
