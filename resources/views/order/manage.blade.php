@extends('layout.app')

@section('title', isset($order) ? 'Edit Order' : 'Create Order')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .form-container {
        background: #fff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="form-container">
        <h3 class="mb-4">{{ isset($order) ? 'Edit Order' : 'Create New Order' }}</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form 
            action="{{ isset($order) ? route('order.update', $order->id) : route('order.store') }}" 
            method="POST"
        >
            @csrf
           @if(isset($order))
                @method('PATCH')
            @endif

            {{-- Customer Search --}}
            <div class="mb-3 position-relative">
                <label for="customerSearch" class="form-label">Search Customer</label>
                <input 
                    type="text" 
                    id="customerSearch" 
                    class="form-control" 
                    placeholder="Type customer name..." 
                    autocomplete="off" 
                    value="{{ isset($order) ? $order->customer->cust_fname . ' ' . $order->customer->cust_lname : '' }}"
                >
                <ul id="customerSuggestions" class="list-group position-absolute w-100" style="z-index: 999;"></ul>
                <input type="hidden" name="customer_id" id="customer_id" value="{{ $order->customer_id ?? '' }}">
            </div>

            

            {{-- Customer Contact Number --}}
            <div class="mb-3">
                <label class="form-label">Customer Contact</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="customer_contact" 
                    value="{{ isset($order) ? $order->customer->contact_number : '' }}" 
                    disabled
                >
            </div>

            {{-- Product --}}
            <div class="mb-3">
                <label for="stock_id" class="form-label">Select Product</label>
                <select class="form-control select2" name="stock_id" id="stock_id" required>
                    <option value="">Search product (name or ref)</option>
                    @foreach ($stocks as $stock)
                        <option 
                            value="{{ $stock->id }}"
                            data-price="{{ $stock->price }}"
                            {{ (isset($order) && $order->stock_id == $stock->id) ? 'selected' : '' }}
                        >
                            {{ $stock->product->product_name }} ({{ $stock->product->product_ref }}) - {{ $stock->color->color_name }} / {{ $stock->size->size }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Price</label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="product_price" 
                    value="{{ isset($order) ? number_format($order->stock->price, 2) : '' }}" 
                    disabled
                >
            </div>

            {{-- Order Status --}}
            <div class="mb-3">
                <label for="status" class="form-label">Order Status</label>
                <select class="form-control" name="status" id="status" required>
                    @php
                        if (isset($order)) {
                            // Full status list for edit
                            $statuses = ['Processing','Dispatched','Out for Delivery','Delivered','Collected','Cancelled','Returned','Failed'];
                        } else {
                            // Limited statuses for create
                            $statuses = ['Pending','Processing','Dispatched'];
                        }
                    @endphp

                    @foreach ($statuses as $status)
                        <option value="{{ $status }}"
                            {{ (isset($order) && $order->status == $status) ? 'selected' : '' }}
                        >{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Order Type --}}
            <div class="mb-3">
                <label for="orderType" class="form-label">Payment Method</label>
                <select class="form-control @error('orderType') is-invalid @enderror" name="orderType" id="orderType" required>
                    <option value="">Select Payment Method</option>
                    @foreach (['Cash on Delivery', 'Card Payment', 'Cash'] as $type)
                        <option value="{{ $type }}" 
                            {{ (old('orderType', $order->order_type ?? '') == $type) ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
                @error('orderType')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Quantity --}}
            <div class="mb-3">
                <label for="qty" class="form-label">Quantity</label>
                <input type="number" 
                    class="form-control @error('qty') is-invalid @enderror" 
                    id="qty" 
                    name="qty" 
                    value="{{ old('qty', $order->qty ?? '') }}" 
                    min="1" 
                    required>
                @error('qty')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Shipping Address --}}
            <div class="mb-3">
                <label for="shipping_address" class="form-label">Shipping Address</label>
                <textarea class="form-control" name="shipping_address" id="shipping_address" rows="3" required>{{ old('shipping_address', $order->customer->address?? '') }}</textarea>
            </div>

            {{-- Additional Notes --}}
            <div class="mb-3">
                <label for="notes" class="form-label">Additional Notes</label>
                <textarea class="form-control" name="notes" id="notes" rows="2">{{ old('notes', $order->notes ?? '') }}</textarea>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    {{ isset($order) ? 'Update Order' : 'Create Order' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('customerSearch');
    const suggestions = document.getElementById('customerSuggestions');
    const customerId = document.getElementById('customer_id');
    const customerContact = document.getElementById('customer_contact');
    const productPriceInput = document.getElementById('product_price');
    const stockSelect = document.getElementById('stock_id');

    let timeout = null;

    // Update product price input when a product is selected
    function updatePrice() {
        const selectedOption = stockSelect.options[stockSelect.selectedIndex];
        const price = selectedOption ? selectedOption.getAttribute('data-price') : '';
        productPriceInput.value = price ? parseFloat(price).toFixed(2) : '';
    }

    // Initial price update on page load (edit page)
    updatePrice();

    // Update price when product selection changes
    stockSelect.addEventListener('change', updatePrice);

    // Customer search input
    input.addEventListener('input', function () {
        const query = this.value.trim();

        clearTimeout(timeout);
        suggestions.innerHTML = '';

        if (query.length < 2) return;

        timeout = setTimeout(() => {
            fetch(`{{ route('customers.search') }}?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    suggestions.innerHTML = '';
                    data.forEach(customer => {
                        const item = document.createElement('li');
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.textContent = `${customer.name}`;
                        item.dataset.id = customer.id;
                        item.dataset.contact = customer.contact_number;
                        item.dataset.address = customer.address || '';
                        item.addEventListener('click', () => {
                            input.value = customer.name;
                            customerId.value = customer.id;
                            customerContact.value = customer.contact_number;
                            // Set shipping address from customer record
                            document.getElementById('shipping_address').value = customer.address || '';
                            suggestions.innerHTML = '';
                        });

                        suggestions.appendChild(item);
                    });

                    if (data.length === 0) {
                        const noResult = document.createElement('li');
                        noResult.classList.add('list-group-item', 'text-muted');
                        noResult.textContent = 'No customers found.';
                        suggestions.appendChild(noResult);
                    }
                });
        }, 300);
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', (e) => {
        if (!input.contains(e.target) && !suggestions.contains(e.target)) {
            suggestions.innerHTML = '';
        }
    });
});
</script>
@endsection
