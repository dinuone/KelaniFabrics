@extends('layout.app')
@section('title', 'Customer Report')

@section('css')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }

    .page-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #939394 100%);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .filter-box {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 20px;
    }

    .filter-box .form-control,
    .filter-box .form-select {
        border-radius: 10px;
    }

    .filter-box .btn {
        border-radius: 10px;
        margin-top: 30px;
        margin-right: 8px;
    }

    .table-container {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    table.modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    table.modern-table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 14px 18px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    table.modern-table tbody tr {
        transition: all 0.3s ease;
    }

    table.modern-table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    table.modern-table td {
        padding: 14px 18px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="page-header">
        <h2 class="fw-bold text-white m-0">Customer Report</h2>
    </div>

    <!-- Filters -->
    <form method="GET" action="{{ route('customer.report') }}">
        <div class="row filter-box g-3">
            <div class="col-md-3">
                <label for="from_date" class="form-label fw-semibold">From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-3">
                <label for="to_date" class="form-label fw-semibold">To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-2">
                <label for="gender" class="form-label fw-semibold">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">All</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>

            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary" type="submit">Filter</button>
                <a href="{{ route('customer.report') }}" class="btn btn-outline-secondary">Reset</a>
                <a href="{{ route('customer.reportPdf', request()->query()) }}" class="btn btn-outline-danger">PDF</a>
                <a href="{{ route('customer.reportExcel', request()->query()) }}" class="btn btn-outline-success">Excel</a>
            </div>
        </div>
    </form>

    <!-- Table -->
    @if($customers->count())
    <div class="table-container mt-4">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $index => $customer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $customer->cust_fname }}</td>
                    <td>{{ $customer->cust_lname }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->contact_number }}</td>
                    <td>{{ ucfirst($customer->gender) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $customers->withQueryString()->links() }}
    </div>
    @elseif(request()->hasAny(['from_date', 'to_date', 'gender']))
    <div class="card mt-4">
        <div class="empty-state">
            <i class="bi bi-people"></i>
            <h4>No customer records found</h4>
        </div>
    </div>
    @else
    <div class="card mt-4">
        <div class="empty-state">
            <i class="bi bi-info-circle"></i>
            <h4>Please apply filters to view customer reports</h4>
        </div>
    </div>
    @endif
</div>
@endsection
