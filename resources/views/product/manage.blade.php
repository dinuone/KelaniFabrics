@extends('layout.app')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@section('css')
<style>
    .product-form {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
    }
    .form-header {
        color: #2c3e50;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #eee;
    }
    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
    }
    .required-field::after {
        content: " *";
        color: #e53e3e;
    }
    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        transition: all 0.2s;
    }
    .form-control:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
    }
    .is-invalid {
        border-color: #e53e3e;
    }
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #e53e3e;
    }
    .is-invalid ~ .invalid-feedback,
    .is-invalid ~ div > .invalid-feedback {
        display: block;
    }
    .color-option {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        cursor: pointer;
        margin-right: 0.5rem;
        border: 2px solid transparent;
        transition: all 0.2s;
    }
    .color-option.selected {
        border-color: #4299e1;
        transform: scale(1.1);
    }
    .size-checkbox {
        margin-right: 0.5rem;
    }
    .image-preview {
        max-width: 200px;
        max-height: 200px;
        margin-top: 1rem;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="product-form">
        <h2 class="form-header">{{ isset($product) ? 'Edit Product' : 'Create New Product' }}</h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ isset($product) ? route('product.update', $product->id) : route('product.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
            @csrf
            @method(isset($product) ? 'PATCH' : 'POST')

            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="productId" class="form-label">Product Ref</label>
                        <input type="text" class="form-control bg-light" id="productId"
                               value="{{ old('productId', $product->product_ref ?? $nextProductId) }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="productName" class="form-label required-field">Product Name</label>
                        <input type="text" class="form-control @error('productName') is-invalid @enderror"
                               id="productName" name="productName"
                               value="{{ old('productName', $product->product_name ?? '') }}" required>
                        @error('productName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- <div class="mb-3">
                        <label for="qty" class="form-label required-field">Quantity</label>
                        <input type="number" class="form-control @error('qty') is-invalid @enderror"
                               id="qty" name="qty" min="0"
                               value="{{ old('qty', $product->qty ?? '') }}" required>
                        @error('qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> --}}

                    <div class="mb-3">
                        <label for="productPrice" class="form-label required-field">Product Price</label>
                        <input type="number" step="0.01" class="form-control @error('productPrice') is-invalid @enderror"
                               id="productPrice" name="productPrice" min="0.01"
                               value="{{ old('productPrice', $product->price ?? '') }}" required>
                        @error('productPrice')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                  

                    <div class="mb-3">
                        <label for="description"  class="form-label required-field">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  maxlength="1000">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max 1000 characters</small>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Product Image</label>
                        <input type="file" class="form-control @error('productImage') is-invalid @enderror"
                               id="productImage" name="productImage" accept="image/*">
                        @error('productImage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max 2MB, JPG/PNG/GIF/WEBP</small>

                        <div class="mt-2">
                            @if(isset($product) && $product->image)
                                <img id="imagePreview" src="{{ asset('storage/'.$product->image) }}"
                                     class="img-thumbnail image-preview">
                                @if(!isset($product))
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="removeImage" name="removeImage">
                                        <label class="form-check-label" for="removeImage">Remove current image</label>
                                    </div>
                                @endif
                            @else
                                <img id="imagePreview" class="img-thumbnail image-preview d-none">
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label required-field">Category</label>
                        <select name="category_id" id="category_id"
                                class="form-control @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->cat_id ?? null) == $category->id ? 'selected' : '' }}>
                                    {{ $category->cat_name }}
                                </option>
                            @endforeach
                        </select>
                         @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sub_category_id" class="form-label">Sub Category</label>
                        <select name="sub_category_id" id="sub_category_id"
                                class="form-control @error('sub_category_id') is-invalid @enderror">
                            <option value="">Select Sub Category</option>
                            @if(isset($subcategories))
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ old('sub_category_id', $product->sub_cat_id ?? null) == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->sub_cat_name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('sub_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required-field">Color</label>
                        <div class="d-flex align-items-center mb-2 flex-wrap color-selection-container">
                         @php
                            $selectedColorId = old('color', isset($product) && $product->colors->first() ? $product->colors->first()->id : null);
                        @endphp

                            @foreach ($colors as $color)
                                @php
                                    $isSelected = $selectedColorId == $color->id;
                                @endphp
                                <div class="color-option me-2 {{ $isSelected ? 'selected' : '' }}"
                                    style="background-color: {{ strtolower($color->color_name) }};"
                                    data-color-id="{{ $color->id }}"
                                    data-color-name="{{ $color->color_name }}"
                                    onclick="selectColor(this)">
                                </div>
                            @endforeach

                            <input type="hidden" name="color" id="colorInput" value="{{ $selectedColorId }}">
                            <span id="colorText" class="ms-2 text-muted">
                                {{ $selectedColorId ? 'Selected: ' . ($colors->find($selectedColorId)->color_name ?? '') : 'No color selected' }}
                            </span>
                        </div>
                        @error('color')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label required-field">Size</label>
                        <div class="row">
                            @php
                                $sizes = [
                                    1 => 'XS', 2 => 'S', 3 => 'M', 4 => 'L', 5 => 'XL',
                                    6 => 'XXL', 7 => 'XXXL', 8 => '26', 9 => '28',
                                    10 => '30', 11 => '32', 12 => '34', 13 => '36',
                                    14 => '38', 15 => '40', 16 => '42', 17 => '44',
                                    18 => '46', 19 => '48', 20 => '50'
                                ];
                                $selectedSizes = old('size', isset($product) ? $product->sizes->pluck('id')->toArray() : []);
                            @endphp
                            @foreach(array_chunk($sizes, 5, true) as $sizeChunk)
                                <div class="col-md-6">
                                    @foreach($sizeChunk as $val => $label)
                                        <div class="form-check">
                                            <input type="checkbox" name="size[]"
                                                   id="size_{{ $val }}"
                                                   class="form-check-input size-checkbox"
                                                   value="{{ $val }}"
                                                   {{ in_array($val, $selectedSizes) ? 'checked' : '' }}>
                                            <label for="size_{{ $val }}" class="form-check-label">{{ $label }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4 border-top pt-3">
                <a href="{{ route('product.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>{{ isset($product) ? 'Update' : 'Save' }} Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    // Image preview
    document.getElementById('productImage').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const file = e.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    });

    // Color selection
    function selectColor(element) {
        // Remove selection class from all
        document.querySelectorAll('.color-option').forEach(opt => {
            opt.classList.remove('selected');
        });

        // Mark clicked one as selected
        element.classList.add('selected');

        // Set the ID in the hidden input
        const colorId = element.getAttribute('data-color-id');
        const colorName = element.getAttribute('data-color-name');

        document.getElementById('colorInput').value = colorId;
        document.getElementById('colorText').textContent = `Selected: ${colorName}`;
    }

    // Subcategory loading
    document.getElementById('category_id').addEventListener('change', function () {
        const categoryId = this.value;
        const subCategorySelect = document.getElementById('sub_category_id');
        const selectedSubCategory = "{{ old('sub_category_id', $product->sub_cat_id ?? '') }}";

        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

        if (!categoryId) return;

        fetch(`/sub_category/get_category/${categoryId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data && Array.isArray(data)) {
                data.forEach(subCategory => {
                    const option = document.createElement('option');
                    option.value = subCategory.id;
                    option.textContent = subCategory.sub_cat_name;

                    // Preselect in edit mode
                    if (subCategory.id == selectedSubCategory) {
                        option.selected = true;
                    }

                    subCategorySelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading subcategories:', error);
        });
    });



    // Form validation
    document.getElementById('productForm').addEventListener('submit', function(e) {
        let isValid = true;

        // Validate required fields
        const requiredFields = this.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            }
        });

        // Validate at least one size is selected
        const sizeCheckboxes = this.querySelectorAll('input[name="size[]"]:checked');
        if (sizeCheckboxes.length === 0) {
            const sizeError = document.createElement('div');
            sizeError.className = 'invalid-feedback d-block';
            sizeError.textContent = 'Please select at least one size';
            document.querySelector('.size-selection-container').appendChild(sizeError);
            isValid = false;
        }

        // Validate color is selected
        if (!document.getElementById('colorInput').value) {
            const colorError = document.createElement('div');
            colorError.className = 'invalid-feedback d-block';
            colorError.textContent = 'Please select a color';
            document.querySelector('.color-selection-container').appendChild(colorError);
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    // Clear validation when user interacts
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
</script>
@endsection
