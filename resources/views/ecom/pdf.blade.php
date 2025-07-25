<!DOCTYPE html>
<html>
<head>
    <title>Orders PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 8px; border: 1px solid #000; font-size: 12px; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Orders Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order Ref</th>
                <th>Customer Name</th>
                <th>Customer Email</th>
                <th>Customer Phone</th>
                <th>Customer Address</th>
                <th>Paid Date</th>
                <th>Total Amount</th>
                <th>Payment Method</th>
                <th>Payment Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->customer_name}}</td>
                <td>{{ $order->customer_email}}</td>
                <td>{{ $order->customer_phone}}</td>
                <td>{{ $order->customer_address}}</td>
                <td><span class="payment-date">{{ $order->created_at}}</span></td>
                <td><span class="payment-amount">Rs. {{ number_format($order->total_amount ?? 0, 2) }}</span></td>
                <td><span class="payment-method-badge">{{ $order->payment_method }}</span></td>
                <td><span class="orer-status-badge">{{ $order->status}}</span></td>
            </tr>
            @endforeach    
        </tbody>
    </table>
</body>
</html>
