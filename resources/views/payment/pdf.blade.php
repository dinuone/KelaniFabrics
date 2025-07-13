<!DOCTYPE html>
<html>
<head>
    <title>Payments Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-muted {
            color: #6c757d;
        }

        .highlight {
            font-weight: bold;
            color: #3b82f6;
        }
    </style>
</head>
<body>
    <h2>Payment Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order Ref</th>
                <th>Paid Date</th>
                <th>Amount</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Payment Method</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->order->order_ref ?? '-' }}</td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td class="highlight">Rs. {{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->order->stock->product->product_name ?? '-' }}</td>
                    <td>{{ $payment->order->qty ?? '-' }}</td>
                    <td>{{ $payment->order->order_type ?? '-' }}</td>
                    <td>{{ $payment->order->status ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
