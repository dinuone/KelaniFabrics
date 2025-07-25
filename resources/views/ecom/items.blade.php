@if($items->count())
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Color</th>
                <th>Size</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->product->product_name ?? 'N/A' }}</td>
                    <td>{{ $item->color->color_name?? 'N/A' }}</td>
                    <td>{{ $item->size->size ?? 'N/A' }}</td>
                    <td>Rs. {{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-muted">No items found for this order.</p>
@endif
