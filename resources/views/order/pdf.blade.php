<!DOCTYPE html>
<html>
<head>
    <title>Orders Report</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Order Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order Ref</th>
                <th>Product</th>
                <th>Color</th>
                <th>Size</th>
                <th>Paid Date</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->order_ref }}</td>
                    <td>{{ $order->stock?->product?->product_name ?? '-' }}</td>
                    <td>{{ $order->stock?->color?->color_name ?? '-' }}</td>
                    <td>{{ $order->stock?->size?->size ?? '-' }}</td>
                    <td>{{ $order->payment?->created_at ?? '-' }}</td>
                    <td>Rs. {{ number_format($order->payment?->amount ?? 0, 2) }}</td>
                    <td>{{ $order->order_type ?? '-' }}</td>
                    <td>{{ $order->status ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
