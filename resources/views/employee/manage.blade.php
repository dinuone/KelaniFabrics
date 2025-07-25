@extends('layout.app')

@section('title', 'employee-create')

@section('css')
<style>
    .employee-form {
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
</style>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif



<div class="container py-5">
    <div class="employee-form">
        <h2 class="form-header">{{ isset($employee) ? 'Edit Employee' : 'Create New Employee' }}</h2>

        <form action="{{ isset($employee) ? route('employee.update', $employee->id) : route('employee.store') }}" method="POST">
            @csrf
            @method((isset($employee)) ? 'PATCH' : 'POST')



            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control @error('firstName') is-invalid @enderror"
                               id="firstName" name="firstName"
                               value="{{ old('firstName', $employee->first_name ?? '') }}">
                        @error('firstName')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control @error('lastName') is-invalid @enderror"
                               id="lastName" name="lastName"
                               value="{{ old('lastName', $employee->last_name ?? '') }}">
                                        @error('lastName')
                                            <span class="error-message">{{ $message }}</span>
                                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $employee->user->email ?? '') }}" required>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                @if(!isset($employee))
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <div class="form-group mb-4">
                    <label class="form-label fw-semibold mb-3">Assign Roles</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($roles as $role)
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="roles[]"
                                    id="role-{{ $role->id }}"
                                    value="{{ $role->name }}"
                                    {{ (isset($employee) && $employee->user && $employee->user->hasRole($role->name)) ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="role-{{ $role->id }}">
                                    {{ ucfirst($role->name) }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                     @error('roles')
                            <span class="error-message">{{ $message }}</span>
                     @enderror
                </div>



                <div class="col-12">
                    <div class="form-group">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                               id="address" name="address"
                               value="{{ old('address', $employee->address ?? '') }}">
                        @error('address')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control @error('dob') is-invalid @enderror"
                               id="dob" name="dob"
                               value="{{ old('dob', $employee->dob ?? '') }}">
                        @error('dob')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

               <div class="col-md-6">
                <div class="form-group">
                    <label for="phoneNumber" class="form-label">Phone Number</label>
                    <input type="text" class="form-control"
                        id="phoneNumber" name="phoneNumber"
                        inputmode="numeric"
                        autocomplete="off"
                        placeholder=""
                        maxlength="10"
                        value="{{ old('phoneNumber', $employee->contact_number ?? '') }}">
                    @error('phoneNumber')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="joinDate" class="form-label">Join Date</label>
                        <input type="date" class="form-control @error('joinDate') is-invalid @enderror"
                               id="joinDate" name="joinDate"
                               value="{{ old('joinDate', $employee->join_date ?? '') }}">
                        @error('joinDate')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="resignDate" class="form-label">Resign Date</label>
                        <input type="date" class="form-control @error('resignDate') is-invalid @enderror"
                               id="resignDate" name="resignDate"
                               value="{{ old('resignDate', $employee->resign_date ?? '') }}">
                        @error('resignDate')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-footer">
                        <button type="submit" class="submit-btn">
                            {{ isset($employee) ? 'Update Employee' : 'Create Employee' }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Phone number formatting
        const phoneInput = document.getElementById('phoneNumber');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0) {
                    value = '+94 ' + value.substring(0, 9);
                }
                e.target.value = value;
            });
        }

        // Date input placeholders (optional)
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            if (!input.value) {
                input.classList.add('placeholder-gray-400');
            }
        });
    });
</script> --}}
<script>
    const phoneInput = document.getElementById('phoneNumber');

    function cleanPhoneNumber(value) {
        // Remove everything that is not a digit
        let cleaned = value.replace(/\D/g, '');

        // If starts with 94 (or 0094), remove it
        if (cleaned.startsWith('94')) {
            cleaned = cleaned.slice(2);
        } else if (cleaned.startsWith('0094')) {
            cleaned = cleaned.slice(4);
        }

        // Limit to 10 digits only
        cleaned = cleaned.slice(-10);

        return cleaned;
    }

    // Clean on input
    phoneInput.addEventListener('input', function () {
        this.value = cleanPhoneNumber(this.value);
    });

    // Clean on page load (if browser autofilled)
    window.addEventListener('DOMContentLoaded', () => {
        phoneInput.value = cleanPhoneNumber(phoneInput.value);
    });
</script>
@endsection
