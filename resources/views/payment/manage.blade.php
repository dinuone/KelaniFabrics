@extends('layout.app')

@section('title', isset($employee) ? 'Edit Employee Payment' : 'Create Employee Payment')

@section('css')
<style>
    .form-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 25px;
        margin-top: 20px;
    }
    .form-header {
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        padding: 10px 15px;
        border-radius: 6px;
    }
    .btn-submit {
        transition: all 0.3s ease;
        padding: 10px 20px;
        font-weight: 500;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .invalid-feedback {
        display: block;
        margin-top: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="form-container">
                <div class="form-header d-flex align-items-center">
                    <i class="fas fa-user-tie fa-2x text-primary me-3"></i>
                    <h1 class="mb-0">{{ isset($employee) ? 'Edit Employee Payment' : 'Create Employee Payment' }}</h1>
                </div>

                <form action="{{ isset($employee) ? route('employee.update', $employee->id) : route('employee.store') }}" method="POST">
                    @csrf
                    @method((isset($employee)) ? 'PATCH' : 'POST')

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paidDate" class="form-label">
                                    <i class="far fa-calendar-alt me-2 text-secondary"></i>Paid Date
                                </label>
                                <input type="date" class="form-control @error('paidDate') is-invalid @enderror"
                                       id="paidDate" name="paidDate"
                                       value="{{ old('paidDate', $employee->paid_date ?? '') }}">
                                @error('paidDate')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="paidAmount" class="form-label">
                                    <i class="fas fa-money-bill-wave me-2 text-secondary"></i>Paid Amount
                                </label>
                                <input type="number" step="0.01" class="form-control @error('paidAmount') is-invalid @enderror"
                                       id="paidAmount" name="paidAmount"
                                       value="{{ old('paidAmount', $employee->paid_amount ?? '') }}"
                                       placeholder="Enter amount">
                                @error('paidAmount')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="method" class="form-label">
                                    <i class="fas fa-credit-card me-2 text-secondary"></i>Payment Method
                                </label>
                                <select class="form-select @error('method') is-invalid @enderror" id="method" name="method">
                                    <option value="">Select payment method</option>
                                    <option value="cash" {{ old('method', $employee->method ?? '') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="bank" {{ old('method', $employee->method ?? '') == 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                                    <option value="check" {{ old('method', $employee->method ?? '') == 'check' ? 'selected' : '' }}>Check</option>
                                    <option value="digital" {{ old('method', $employee->method ?? '') == 'digital' ? 'selected' : '' }}>Digital Payment</option>
                                </select>
                                @error('method')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="discount" class="form-label">
                                    <i class="fas fa-percentage me-2 text-secondary"></i>Discount (%)
                                </label>
                                <input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror"
                                       id="discount" name="discount"
                                       value="{{ old('discount', $employee->discount ?? '0') }}"
                                       placeholder="Enter discount percentage">
                                @error('discount')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('employee.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary btn-submit px-4">
                            <i class="fas fa-save me-2"></i>{{ isset($employee) ? 'Update Payment' : 'Create Payment' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // You can add form validation or other interactive features here
        console.log('Employee payment form loaded');

        // Example: Format date display if needed
        const paidDateInput = document.getElementById('paidDate');
        if (paidDateInput) {
            // You can add date picker initialization here if needed
        }
    });
</script>
@endsection
