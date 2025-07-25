<?php

namespace App\Exports;

use App\Models\EcomOrder;
use Maatwebsite\Excel\Concerns\FromCollection;

class EcomOrderExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // You can customize the fields as needed
        return EcomOrder::select('id', 'order_number', 'customer_name', 'customer_email', 'customer_phone', 'customer_address', 'total_amount','status','created_at')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Order Number',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Customer Address',
            'Total Amount',
            'Status',
            'Created At',
        ];
    }
}
