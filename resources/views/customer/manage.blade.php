@extends('layout.app')

@section('title', 'customer-create')

@section('css')
<style>
    .customer-form {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        max-width: 800px;
        margin: 0 auto;
    }
    .form-header {
        color: #2c3e50;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
        font-size: 1.5rem;
    }
    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-control {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
        width: 100%;
        font-size: 0.95rem;
    }
    .form-control:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        outline: none;
    }
    .is-invalid {
        border-color: #e53e3e;
    }
    .is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(229, 62, 62, 0.2);
    }
    .error-message {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: block;
    }
    .submit-btn {
        background: #4299e1;
        color: white;
        font-weight: 600;
        padding: 0.6rem 1.5rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        border: none;
        margin-top: 1.5rem;
        font-size: 0.95rem;
        cursor: pointer;
    }
    .submit-btn:hover {
        background: #3182ce;
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 1.25rem;
    }
    .form-footer {
        text-align: right;
        margin-top: 2rem;
    }
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -0.75rem;
    }
    .col-md-6, .col-12 {
        padding: 0 0.75rem;
        flex: 0 0 auto;
        width: 100%;
    }
    @media (min-width: 768px) {
        .col-md-6 {
            width: 50%;
        }
    }
    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 16px 12px;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="customer-form">
        <h2 class="form-header">{{ isset($customer) ? 'Edit Customer' : 'Create New Customer' }}</h2>

        <form action="{{ isset($customer) ? route('customer.update', $customer->id) : route('customer.store') }}" method="POST">
            @csrf
            @method((isset($customer)) ? 'PATCH' : 'POST')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="custFName" class="form-label">First Name</label>
                        <input type="text" class="form-control @error('custFName') is-invalid @enderror"
                               id="custFName" name="custFName"
                               value="{{ old('custFName', $customer->cust_fname ?? '') }}">
                        @error('custFName')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="custLName" class="form-label">Last Name</label>
                        <input type="text" class="form-control @error('custLName') is-invalid @enderror"
                               id="custLName" name="custLName"
                               value="{{ old('custLName', $customer->cust_lname ?? '') }}">
                        @error('custLName')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                               id="address" name="address"
                               value="{{ old('address', $customer->address ?? '') }}">
                        @error('address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"
                               value="{{ old('email', $customer->email ?? '') }}">
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                <div class="form-group">
                    <label for="contactNumber" class="form-label">Contact Number</label>
                    <input 
                        type="text" 
                        class="form-control @error('contactNumber') is-invalid @enderror" 
                        id="contactNumber" 
                        name="contactNumber"
                        value="{{ old('contactNumber', $customer->contact_number ?? '') }}"
                    >
                    @error('contactNumber')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>


                <div class="col-md-6">
                    <div class="form-group">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control @error('gender') is-invalid @enderror"
                                id="gender" name="gender">
                            <option value="male" {{ (old('gender', $customer->gender ?? '') == 'male') ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ (old('gender', $customer->gender ?? '') == 'female') ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ (old('gender', $customer->gender ?? '') == 'other') ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-footer">
                        <button type="submit" class="submit-btn">
                            {{ isset($customer) ? 'Update Customer' : 'Create Customer' }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Email validation helper (optional)
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.addEventListener('blur', function(e) {
                if (!e.target.value.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                    e.target.classList.add('is-invalid');
                } else {
                    e.target.classList.remove('is-invalid');
                }
            });
        }
    });
</script>
@endsection
