<?php


namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class DeliveryReportExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Order::with(['customer', 'stock.product']);

        if (!empty($this->filters['from_date']) && !empty($this->filters['to_date'])) {
            $query->whereBetween('created_at', [
                $this->filters['from_date'] . ' 00:00:00',
                $this->filters['to_date'] . ' 23:59:59',
            ]);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        // Get all matching orders
        $orders = $query->latest()->get();

        // Map to a simple array for export
        return $orders->map(function ($order) {
            return [
                'Order Ref' => $order->order_ref,
                'Customer' => $order->customer->name ?? '-',
                'Product' => $order->stock->product->product_name ?? '-',
                'Quantity' => $order->qty,
                'Order Type' => $order->order_type,
                'Status' => $order->status,
                'Order Date' => $order->created_at->format('Y-m-d'),
                'Shipping Address' => $order->shipping_address,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Order Ref',
            'Customer',
            'Product',
            'Quantity',
            'Order Type',
            'Status',
            'Order Date',
            'Shipping Address',
        ];
    }
}
