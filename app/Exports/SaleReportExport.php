<?php


namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class SaleReportExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Payment::with(['order.stock.product']);

        // Apply filters if any
        if (!empty($this->filters['from_date']) && !empty($this->filters['to_date'])) {
            $query->whereBetween('created_at', [
                $this->filters['from_date'] . ' 00:00:00',
                $this->filters['to_date'] . ' 23:59:59',
            ]);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        return $query->get();
    }

    public function map($payment): array
    {
        return [
            $payment->order->order_ref ?? '-',
            $payment->created_at->format('Y-m-d'),
            $payment->amount,
            $payment->order->stock->product->product_name ?? '-',
            $payment->order->qty ?? '-',
            $payment->status,
            $payment->order->status ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'Order Ref',
            'Sale Date',
            'Amount Paid',
            'Product Name',
            'Quantity',
            'Payment Status',
            'Order Status',
        ];
    }
}
