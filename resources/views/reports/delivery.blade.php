@extends('layout.app')
@section('title', 'Delivery Report')

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
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h2 class="fw-bold text-white m-0">Delivery Report</h2>
            </div>
        </div>

        <!-- Filters form -->
        <form method="GET" action="{{ route('delivery.report') }}" class="row g-3 align-items-center mb-4">
            <div class="col-md-3">
                <label for="from_date" class="form-label fw-semibold">From Date</label>
                <input type="date" name="from_date" id="from_date" class="form-control" value="{{ request('from_date') }}">
            </div>

            <div class="col-md-3">
                <label for="to_date" class="form-label fw-semibold">To Date</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
            </div>

            <div class="col-md-2">
                <label for="status" class="form-label fw-semibold">Order Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                    <option value="Delivered" {{ request('status') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Dispatched" {{ request('status') == 'Dispatched' ? 'selected' : '' }}>Dispatched</option>
                    <option value="Out for Delivery" {{ request('status') == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100 mt-4">Filter</button>
            </div>

             <div class="col-md-2 d-flex align-items-end">
                 <a href="{{ route('delivery.export', request()->only(['from_date', 'to_date', 'status', 'search'])) }}" class=" mt-4 btn btn-modern btn-outline-primary ms-2">
                    <i class="bi bi-file-earmark-excel me-2"></i> Export to Excel
                </a>
                <a href="{{ route('delivery.exportPdf', request()->only(['from_date', 'to_date', 'status', 'search'])) }}" 
                class="mt-4 btn btn-modern btn-outline-primary ms-2">
                    <i class="bi bi-file-earmark-pdf me-2"></i> Export to PDF
                </a>
            </div>
        </form>

        <!-- Search and Export -->
        
        <div class="col-12" id="deliveryTable">
            @if($orders->count() > 0)
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order Ref</th>
                                <th>Delivery Date</th>
                                <th>Customer</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration + ($orders->currentPage() - 1) * $orders->perPage() }}</td>
                                    <td>{{ $order->order_ref ?? '-' }}</td>
                                    <td class="payment-date">{{ $order->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $order->customer->cust_fname ?? '-' }}</td>
                                    <td>{{ $order->stock->product->product_name ?? '-' }}</td>
                                    <td>{{ $order->qty }}</td>
                                    <td>{{ $order->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
           @elseif(request()->hasAny(['from_date', 'to_date', 'status', 'search']))
                <div class="card">
                    <div class="empty-state">
                        <i class="bi bi-truck"></i>
                        <h4>No Delivery Records Found</h4>
                        <p class="text-muted">Try changing filters or adding delivery data.</p>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="empty-state">
                        <i class="bi bi-info-circle"></i>
                        <h4>Please apply filters to view delivery reports</h4>
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                {{ $orders->withQueryString()->links() }}
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
        const table = document.getElementById("deliveryTable");
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
        const table = document.getElementById("deliveryTable");
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
                const newContent = doc.querySelector("#deliveryTable");
                if (newContent) {
                    document.getElementById("deliveryTable").innerHTML = newContent.innerHTML;
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
