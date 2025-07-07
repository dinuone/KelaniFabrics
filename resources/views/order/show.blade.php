@extends('layout.app')

@section('title', 'View Order')

@section('css').
<style>
status-badge {
    padding: 6px 12px;
    border-radius: 50px;
    font-weight: 500;
    font-size: 0.8rem;
}

.status-pending {
    background-color: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.status-completed {
    background-color: rgba(25, 135, 84, 0.1);
    color: #198754;
}

.status-cancelled {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

</style>
@endsection


@section('content')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Order Details</h5>
        </div>
        <div class="card-body">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Order Type:</strong> {{ $order->order_type }}</p>

            {{-- Status with color --}}
            @php
                $status = strtolower($order->status);
                $statusClass = match($status) {
                    'pending' => 'status-pending',
                    'completed', 'delivered', 'collected' => 'status-completed',
                    'cancelled' => 'status-cancelled',
                    default => '',
                };
            @endphp
            <p><strong>Status:</strong> 
                <span class="status-badge {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
            </p>

            <p><strong>Quantity:</strong> {{ $order->qty }}</p>

            {{-- Customer --}}
            @if($order->customer)
                <p><strong>Customer:</strong> {{ $order->customer->cust_fname . " " .$order->customer->cust_lname }}</p>
            @endif

            {{-- Product, Color, Size --}}
            @if($order->stock && $order->stock->product)
                <p><strong>Product:</strong> {{ $order->stock->product->product_name }}</p>

                {{-- Assuming you have color and size in stock --}}
                @if($order->stock->color)
                    <p><strong>Color:</strong> {{ $order->stock->color->name }}</p>
                @endif

                @if($order->stock->size)
                    <p><strong>Size:</strong> {{ $order->stock->size->name }}</p>
                @endif
            @endif

            {{-- Payment --}}
            @if($order->payment)
                @php
                    $paymentStatus = strtolower($order->payment->status);
                    $paymentClass = $paymentStatus === 'paid' ? 'status-completed' : 'status-pending';
                @endphp
                <p><strong>Payment Status:</strong> 
                    <span class="status-badge {{ $paymentClass }}">{{ ucfirst($order->payment->status) }}</span>
                </p>
                <p><strong>Amount:</strong> {{ number_format($order->payment->amount, 2) }}</p>
            @endif

            <a href="{{ route('order.index') }}" class="btn btn-secondary mt-3">Back to Orders</a>
        </div>
    </div>
</div>
@endsection
