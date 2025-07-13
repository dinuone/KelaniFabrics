<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Product List</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Product Ref</th>
                <th>Product Name</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Price</th>
                <th>Colors</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->product_ref }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category->cat_name ?? 'N/A' }}</td>
                    <td>{{ $product->subCategory->sub_cat_name ?? 'N/A' }}</td>
                    <td>Rs. {{ number_format($product->price, 2) }}</td>
                    <td>
                        @foreach ($product->colors as $color)
                            {{ $color->color_name }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
