@extends('layout.app')
@section('title', 'Payments')

@section('css')
<style>
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
    .payment-method-badge {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.8rem;
        background-color: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
    }
    .discount-badge {
        padding: 4px 10px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 500;
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }
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


</style>
@endsection

@section('content')
<div class="container">
    @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h2 class="fw-bold text-white m-0">Payment Management</h2>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-end mb-4">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="search" class="form-control search-box border-start-0" placeholder="Search payments...">
                </div>
            </div>
              <div >
                <a href="{{ route('payments.export') }}" class="btn btn-modern btn-outline-primary ms-2">
                    <i class="bi bi-file-earmark-excel me-2"></i> Export to Excel
                </a>

                <a href="{{ route('payments.exportPdf') }}" class="btn btn-modern btn-outline-danger ms-2">
                    <i class="bi bi-filetype-pdf me-2"></i> Export to PDF
                </a>
            </div>
        </div>

        <div class="col-12" id="paymentTable">
            @if(count($payments) > 0)
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Ref</th>
                                <th>Paid Date</th>
                                <th>Amount</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Payment Method</th>
                                 <th>Payment Status</th>
                                <th>Order Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $payment->order->order_ref }}</td>
                                    <td class="payment-date">{{ $payment->created_at }}</td>
                                    <td class="payment-amount">Rs. {{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ $payment->order->stock->product->product_name ?? '-' }}</td>
                                    <td>{{ $payment->order->qty ?? '-' }}</td>
                                    <td>{{ $payment->order->order_type ?? '-' }}</td>
                                    <td>{{ $payment->status ?? '-' }}</td>
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
                        <h4>No Payments Found</h4>
                        <p class="text-muted">Try updating orders or checking filters.</p>
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                {{ $payments->links() }}
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
        typingTimer = setTimeout(performSearch, doneTypingInterval);
    });

    const performSearch = () => {
        let query = searchInput.value;
        fetch(`?search=${query}`, {
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
    };
});
</script>
@endsection
