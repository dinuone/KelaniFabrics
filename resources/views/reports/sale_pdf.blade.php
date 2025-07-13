<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report PDF</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #999;
            padding: 6px 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .summary {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Sales Report</h2>
    <p class="summary">Total Sale Amount: Rs. {{ number_format($totalAmount, 2) }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Order Ref</th>
                <th>Sale Date</th>
                <th>Amount Paid</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Payment Status</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->order->order_ref ?? '-' }}</td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                    <td>{{ $payment->order->stock->product->product_name ?? '-' }}</td>
                    <td>{{ $payment->order->qty ?? '-' }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->order->status ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
