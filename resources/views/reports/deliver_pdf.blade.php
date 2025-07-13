<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Delivery Report</title>
    <style>
        body { font-family: 'Poppins', sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #3b82f6; color: white; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Delivery Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order Ref</th>
                <th>Delivery Date</th>
                <th>Customer</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $order->order_ref ?? '-' }}</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                    <td>{{ $order->customer->cust_fname ?? '-' }}</td>
                    <td>{{ $order->stock->product->product_name ?? '-' }}</td>
                    <td>{{ $order->qty }}</td>
                    <td>{{ $order->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
