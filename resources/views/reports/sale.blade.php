@extends('layout.app')
@section('title', 'Sale Report')

@section('css')
<style>
    /* Reuse your existing styles or add below */
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
    }
    .page-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .table-container {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .modern-table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 14px 18px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    .modern-table tbody tr {
        transition: all 0.3s ease;
    }
    .modern-table tbody tr:hover {
        background-color: rgba(59, 130, 246, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }
    .modern-table td {
        padding: 14px 18px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    .payment-amount { font-weight: 600; color: #3b82f6; }
    .payment-date { color: #6c757d; font-size: 0.9rem; }
    .empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    .empty-state i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 20px;
    }
    .pagination {
        margin-top: 20px;
    }
    .page-link {
        border-radius: 50px;
        margin: 0 5px;
        border: none;
        color: #3b82f6;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }
    .page-item.active .page-link {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: #fff;
    }
    .search-box {
        border-radius: 50px;
        padding: 12px 20px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .search-box:focus {
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.15);
        border-color: #3b82f6;
    }
      .card-title {
        font-size: 1.25rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h2 class="fw-bold text-white m-0">Sale Report</h2>
            </div>
        </div>

        <!-- Filters form -->
        <form method="GET" action="{{ route('sales.report') }}" class="row g-3 align-items-center mb-4">
            <div class="col-md-3">
                <label for="from_date" class="form-label fw-semibold">From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-3">
                <label for="to_date" class="form-label fw-semibold">To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-2">
                <label for="status" class="form-label fw-semibold">Payment Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                    <option value="Paid" {{ request('status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 mt-4">Filter</button>
            </div>

             <div class="col-md-2 d-flex align-items-end">
                  <a href="{{ route('sale.export', request()->only(['from_date', 'to_date', 'status', 'search'])) }}" class="mt-4 btn btn-modern btn-outline-primary ms-2">
                    <i class="bi bi-file-earmark-excel me-2"></i> Export to Excel
                </a>


                <a href="{{ route('sale.exportPdf', request()->only(['from_date', 'to_date', 'status', 'search'])) }}" class="mt-4 btn btn-modern btn-outline-danger">
                    <i class="bi bi-filetype-pdf me-2"></i> Export to PDF
                </a>
            </div>
        </form>
>

        <div class="col-12" id="paymentTable">
            @if($payments->count() > 0)
                <div class="table-container">
                        <div class="card mb-4 shadow-sm border-primary">
                            <div class="card-header bg-primary text-white">
                                Total Sale Summary
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Total Sale Amount</h5>
                                <p class="card-text fs-4 fw-bold text-success">Rs. {{ number_format($totalAmount, 2) }}</p>
                            </div>
                        </div>
                        
                        <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Ref</th>
                                <th>Sale Date</th>
                                <th>Amount Paid</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Payment Status</th>
                                <th>Order Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $loop->iteration + ($payments->currentPage() - 1) * $payments->perPage() }}</td>
                                    <td>{{ $payment->order->order_ref ?? '-' }}</td>
                                    <td class="payment-date">{{ $payment->created_at->format('Y-m-d') }}</td>
                                    <td class="payment-amount">Rs. {{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->order->stock->product->product_name ?? '-' }}</td>
                                    <td>{{ $payment->order->qty ?? '-' }}</td>
                                    <td>{{ $payment->status }}</td>
                                    <td>{{ $payment->order->status ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card">
                    <div class="empty-state">
                        <i class="bi bi-cash-stack"></i>
                        <h4>No Sale Records Found</h4>
                        <p class="text-muted">Try changing filters or adding sales data.</p>
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                {{ $payments->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    let typingTimer;
    const doneTypingInterval = 300;

    const addLoadingState = () => {
        const table = document.getElementById("paymentTable");
        table.classList.add("opacity-50");
        table.style.position = "relative";
        if (!document.getElementById("loading-spinner")) {
            const spinner = document.createElement("div");
            spinner.id = "loading-spinner";
            spinner.className = "position-absolute top-50 start-50 translate-middle";
            spinner.innerHTML = `<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>`;
            table.appendChild(spinner);
        }
    };

    const removeLoadingState = () => {
        const table = document.getElementById("paymentTable");
        table.classList.remove("opacity-50");
        const spinner = document.getElementById("loading-spinner");
        if (spinner) spinner.remove();
    };

    searchInput.addEventListener("input", function () {
        clearTimeout(typingTimer);
        addLoadingState();
        typingTimer = setTimeout(() => {
            const query = searchInput.value;
            const url = new URL(window.location);
            url.searchParams.set('search', query);
            // Retain filters in URL
            url.searchParams.set('from_date', document.getElementById('from_date').value);
            url.searchParams.set('to_date', document.getElementById('to_date').value);
            url.searchParams.set('status', document.getElementById('status').value);

            fetch(url.toString(), {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector("#paymentTable");
                if (newContent) {
                    document.getElementById("paymentTable").innerHTML = newContent.innerHTML;
                    const rows = document.querySelectorAll('.modern-table tbody tr');
                    rows.forEach((row, index) => {
                        row.style.opacity = "0";
                        row.style.transform = "translateY(10px)";
                        setTimeout(() => {
                            row.style.transition = "opacity 0.3s ease, transform 0.3s ease";
                            row.style.opacity = "1";
                            row.style.transform = "translateY(0)";
                        }, index * 30);
                    });
                }
                removeLoadingState();
            })
            .catch(error => {
                console.error('Search error:', error);
                removeLoadingState();
            });
        }, doneTypingInterval);
    });
});
</script>
@endsection
