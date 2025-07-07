<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Order::with(['stock.product', 'stock.color', 'stock.size', 'payment'])
            ->get()
            ->map(function ($order) {
                return [
                    'Order Ref' => $order->order_ref,
                    'Product' => $order->stock->product->product_name ?? '-',
                    'Color' => $order->stock->color->color_name ?? '-',
                    'Size' => $order->stock->size->size ?? '-',
                    'Paid Date' => $order->payment->created_at ?? '-',
                    'Amount' => $order->payment->amount ?? 0,
                    'Payment Method' => $order->order_type ?? '-',
                    'Order Status' => $order->status ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Order Ref',
            'Product',
            'Color',
            'Size',
            'Paid Date',
            'Amount',
            'Payment Method',
            'Order Status',
        ];
    }
}
