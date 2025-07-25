@extends('layout.app')

@section('title', isset($stock) ? 'Edit Stock' : 'Add Stock')

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
    .form-label {
        font-weight: 600;
    }
   .submit-btn {
        background: #4299e1;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        border: none;
        margin-top: 2rem;
        font-size: 0.95rem;
        cursor: pointer;
    }
    .submit-btn:hover {
        background: #3182ce;
    }
</style>
@endsection

@section('content')

  @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


<div class="container">
    <div class="form-container">
        <h3 class="mb-4">{{ isset($stock) ? 'Edit Stock' : 'Add New Stock' }}</h3>

            <form action="{{ isset($stock) ? route('stock.update', $stock->id) : route('stock.store') }}" method="POST">
                @csrf
                @method(isset($stock) ? 'PATCH' : 'POST')

                {{-- Product Search Input --}}
                <div class="mb-3 position-relative">
                    <label for="productSearch" class="form-label">Search Product</label>
                  <input 
                        type="text" 
                        class="form-control" 
                        id="productSearch" 
                        placeholder="Type product name or reference..." 
                        autocomplete="off"
                        value="{{ isset($stock) ? $stock->product->product_name . ' (' . $stock->product->product_ref . ')' : '' }}"
           
                    >


                    <ul id="productSuggestions" class="list-group position-absolute w-100" style="z-index: 999;"></ul>
                    <input type="hidden" name="product_id" id="product_id" value="{{ $stock->product_id ?? '' }}">
                </div>

                {{-- Price --}}
                <div class="mb-3">
                    <label for="price" class="form-label">Unit Price</label>
                    <input 
                    type="number" 
                    class="form-control" 
                    name="price" 
                    id="price" 
                    step="0.01" 
                    min="0.01" 
                    required 
                    value="{{ old('price', $stock->price ?? '') }}"
                    >
                </div>

                {{-- Color --}}
                <div class="mb-3">
                    <label for="color_id" class="form-label">Color</label>
                    <select name="color_id" id="color_id" class="form-control" required>
                        {{-- @foreach ($colors as $color)
                            <option value="{{ $color->id }}" {{ isset($stock) && $stock->color_id == $color->id ? 'selected' : '' }}>
                                {{ $color->color_name }}
                            </option>
                        @endforeach --}}
                    </select>
                </div>

                {{-- Size --}}
                <div class="mb-3">
                    <label for="size_id" class="form-label">Size</label>
                    <select name="size_id" id="size_id" class="form-control" required>
                        {{-- @foreach ($sizes as $size)
                            <option value="{{ $size->id }}" {{ isset($stock) && $stock->size_id == $size->id ? 'selected' : '' }}>
                                {{ $size->size }}
                            </option>
                        @endforeach --}}
                    </select>
                </div>

                {{-- Quantity --}}
                <div class="mb-3">
                    <label for="receive_qty" class="form-label">Quantity</label>
                    <input 
                    type="number" 
                    class="form-control" 
                    name="receive_qty" 
                    id="receive_qty" 
                  
                    required 
                    value="{{ old('receive_qty', $stock->receive_qty ?? '') }}"
                    >
                </div>

                {{-- Availability --}}
                <div class="mb-3">
                    <label for="availability" class="form-label">Availability</label>
                    <select name="availability" id="availability" class="form-control" required>
                        <option value="In Stock" {{ isset($stock) && $stock->availability == 'In Stock' ? 'selected' : '' }}>In Stock</option>
                        <option value="Out of Stock" {{ isset($stock) && $stock->availability == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>
                        <option value="Pre-order" {{ isset($stock) && $stock->availability == 'Pre-order' ? 'selected' : '' }}>Pre-order</option>
                    </select>
                </div>

              
                <div class="form-footer text-end">
                    <button type="submit" class="submit-btn">{{ isset($stock) ? 'Update' : 'Add' }} Stock</button>
                </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('productSearch');
    const suggestionBox = document.getElementById('productSuggestions');
    const productIdInput = document.getElementById('product_id');
    const priceInput = document.getElementById('price');
    const colorSelect = document.getElementById('color_id');
    const sizeSelect = document.getElementById('size_id');

    let timeout = null;

    searchInput.addEventListener('input', function () {
        const query = this.value.trim();
        clearTimeout(timeout);

        if (query.length < 2) {
            suggestionBox.innerHTML = '';
            return;
        }

        timeout = setTimeout(() => {
            fetch(`{{ route('products.search') }}?query=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(products => {
                    suggestionBox.innerHTML = '';

                    products.forEach(product => {
                        const item = document.createElement('li');
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.textContent = `${product.product_name} (${product.product_ref})`;
                        
                        // Store full product JSON in dataset
                        item.dataset.product = JSON.stringify(product);

                        item.addEventListener('click', () => {
                            searchInput.value = `${product.product_name} (${product.product_ref})`;
                            productIdInput.value = product.id;
                            priceInput.value = product.price;
                            suggestionBox.innerHTML = '';

                            populateColors(product.colors);
                            populateSizes(product.sizes);
                        });

                        suggestionBox.appendChild(item);
                    });

                    if (products.length === 0) {
                        const noResult = document.createElement('li');
                        noResult.classList.add('list-group-item', 'text-muted');
                        noResult.textContent = 'No products found.';
                        suggestionBox.appendChild(noResult);
                    }
                });
        }, 300);
    });

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !suggestionBox.contains(e.target)) {
            suggestionBox.innerHTML = '';
        }
    });

    function populateColors(colors) {
        colorSelect.innerHTML = '';
        colors.forEach(color => {
            const option = document.createElement('option');
            option.value = color.id;
            option.textContent = color.color_name;
            colorSelect.appendChild(option);
        });
    }

    function populateSizes(sizes) {
        sizeSelect.innerHTML = '';
        sizes.forEach(size => {
            const option = document.createElement('option');
            option.value = size.id;
            option.textContent = size.size;
            sizeSelect.appendChild(option);
        });
    }
});
</script>


@endsection
