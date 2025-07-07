@extends('layout.app')
@section('title', 'Order')

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
     .orer-status-badge {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.8rem;
        background-color: rgba(108, 216, 6, 0.1);
        color: #000000;
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

       .btn-modern {
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 500;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
    }

    .btn-create {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border: none;
        color: white;
    }
</style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="page-header">
                    <h2 class="fw-bold text-white m-0">Order Management</h2>
                </div>
            </div>

            <div class="col-12 mb-4">
                <div class="row align-items-center">
                    <!-- Left: Add Order -->
                    <div class="col-md-6 d-flex justify-content-start">
                        <a href="{{ route('order.create') }}" class="btn btn-modern btn-create">
                            <i class="bi bi-plus-circle me-2"></i>Add New Order
                        </a>
                    </div>

                    <!-- Right: Search + Export -->
                    <div class="col-md-6 d-flex justify-content-end">
                        <div class="input-group me-2" style="max-width: 300px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search text-muted"></i>
                            </span>
                            <input type="text" id="search" class="form-control search-box border-start-0" placeholder="Search orders...">
                        </div>

                        <a href="{{ route('order.export') }}" class="btn btn-modern btn-outline-primary">
                            <i class="bi bi-file-earmark-excel me-2"></i>Export to Excel
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-12" id="orderTable">
                @if(count($orders) > 0)
                    <div class="table-container">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Ref</th>
                                    <th>Product</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                    <th>Paid Date</th>
                                    <th>Amount</th>
                                    <th>Payment Method</th>
                                    <th>Order Status</th>
                                </tr>
                            </thead>

                            <tbody>
                               @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $order->order_ref }}</td>
                                    <td>{{ $order->stock?->product?->product_name ?? '-' }}</td>
                                    <td>
                                       <span style="background-color: {{ strtolower($order->stock?->color?->color_name) }}; 
                                                            display:inline-block; width: 20px; height: 20px; border-radius: 50%; margin-right: 5px;"
                                                    title="{{ $order->stock?->color?->color_name }}">
                                        </span>
                                    </td>
                                   
                                    <td>{{ $order->stock?->size?->size ?? '-' }}</td>
                                    <td><span class="payment-date">{{ $order->payment?->created_at ?? '-' }}</span></td>
                                    <td><span class="payment-amount">Rs. {{ number_format($order->payment?->amount ?? 0, 2) }}</span></td>
                                    <td><span class="payment-method-badge">{{ $order->order_type?? '-' }}</span></td>
                                    <td><span class="orer-status-badge">{{ $order->status?? '-' }}</span></td>
                                    
                                </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card">
                        <div class="empty-state">
                            <i class="bi bi-cart-x"></i>
                            <h4>No Orders Found</h4>
                            <p class="text-muted">Try creating a new order or adjusting your search.</p>
                        </div>
                    </div>
                @endif

                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="bi bi-exclamation-triangle text-warning fs-1 mb-3 d-block"></i>
                    <h2 class="fs-4 mb-3">Are you sure you want to delete this order?</h2>
                    <p class="text-muted">This action cannot be undone and may affect related data.</p>
                </div>
                <form action="" method="post" id="deleteForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-modern btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-modern btn-danger px-4">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    // Function to handle the delete modal
    const appendId = (X) => {
        document.getElementById('deleteForm').action = "{{route('order.destroy', ':id')}}".replace(':id', X);
    }

    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("search");
        let typingTimer;
        const doneTypingInterval = 300; // Wait for 300ms after user stops typing

        // Add loading animation
        const addLoadingState = () => {
            const orderTable = document.getElementById("orderTable");
            orderTable.classList.add("opacity-50");
            orderTable.style.position = "relative";

            // Check if loading spinner already exists
            if (!document.getElementById("loading-spinner")) {
                const spinner = document.createElement("div");
                spinner.id = "loading-spinner";
                spinner.className = "position-absolute top-50 start-50 translate-middle";
                spinner.innerHTML = `
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                `;
                orderTable.appendChild(spinner);
            }
        };

        // Remove loading animation
        const removeLoadingState = () => {
            const orderTable = document.getElementById("orderTable");
            orderTable.classList.remove("opacity-50");

            const spinner = document.getElementById("loading-spinner");
            if (spinner) {
                spinner.remove();
            }
        };

        // Handle search with debounce
        searchInput.addEventListener("input", function () {
            clearTimeout(typingTimer);

            addLoadingState();
            typingTimer = setTimeout(performSearch, doneTypingInterval);
        });

        // Perform the actual search
        const performSearch = () => {
            let query = searchInput.value;

            fetch(`?search=${query}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newOrderContent = doc.querySelector("#orderTable");
                const newPagination = doc.querySelector(".pagination");

                if (newOrderContent) {
                    // Replace the entire table container
                    document.getElementById("orderTable").innerHTML = newOrderContent.innerHTML;

                    // Add animation to table rows
                    const rows = document.querySelectorAll('.modern-table tbody tr');
                    rows.forEach((row, index) => {
                        row.style.opacity = "0";
                        row.style.transform = "translateY(10px)";

                        setTimeout(() => {
                            row.style.transition = "opacity 0.3s ease, transform 0.3s ease";
                            row.style.opacity = "1";
                            row.style.transform = "translateY(0)";
                        }, index * 30); // Stagger the animations
                    });
                }

                removeLoadingState();
            })
            .catch(error => {
                console.error('Search error:', error);
                removeLoadingState();
            });
        };

        // Add entrance animations to table rows on page load
        const rows = document.querySelectorAll('.modern-table tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = "0";
            row.style.transform = "translateY(10px)";

            setTimeout(() => {
                row.style.transition = "opacity 0.3s ease, transform 0.3s ease";
                row.style.opacity = "1";
                row.style.transform = "translateY(0)";
            }, 100 + index * 30); // Stagger the animations
        });
    });
</script>
@endsection
