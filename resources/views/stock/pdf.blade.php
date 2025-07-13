<!DOCTYPE html>
<html>
<head>
    <title>Stock Report</title>
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
            margin: auto;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <h2>Stock Report</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Color</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $index => $stock)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $stock->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $stock->product->category->cat_name ?? 'N/A' }}</td>
                    <td>{{ $stock->product->subCategory->sub_cat_name ?? 'N/A' }}</td>
                    <td>{{ $stock->color->color_name ?? 'N/A' }}</td>
                    <td>{{ $stock->size->size ?? 'N/A' }}</td>
                    <td>{{ $stock->receive_qty }}</td>
                    <td>{{ $stock->availability }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
