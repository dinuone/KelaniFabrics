@extends('layout.app')
@section('title', 'Roles')

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

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
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

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        margin-right: 8px;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }

    .action-btn-delete {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .action-btn-delete:hover {
        background-color: rgba(220, 53, 69, 0.2);
    }

    .action-btn-edit {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }

    .action-btn-edit:hover {
        background-color: rgba(255, 193, 7, 0.2);
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .status-active {
        background-color: rgba(25, 135, 84, 0.1);
        color: #198754;
    }

    .status-inactive {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }

    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        border-radius: 15px 15px 0 0;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
    }

    .modal-footer {
        border-top: none;
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

    /* Modern Table Styles */
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
        padding: 16px 20px;
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
        padding: 16px 20px;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    .table-actions {
        display: flex;
        justify-content: flex-end;
    }

    .date-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .date-label {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .date-value {
        font-weight: 500;
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
                <h2 class="fw-bold text-white m-0">Role Management</h2>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('roles.create') }}" class="btn btn-modern btn-create">
                <i class="bi bi-plus-circle me-2"></i>Add New Role
            </a>

            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" id="search" class="form-control search-box border-start-0" placeholder="Search roles...">
                </div>
            </div>
        </div>

        <div class="col-12" id="roleTable">
            @if(count($roles) > 0)
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td><span class="product-name">{{ $role->name }}</span></td>
                                    <td>
                                        @foreach ($role->permissions as $permission)
                                            <span class="badge bg-secondary me-1">{{ $permission->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if($role->name !="super-admin")
                                        <div class="table-actions">
                                            <a href="javascript:void(0)" class="action-btn action-btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="appendId('{{ $role->id }}')">
                                                <i class="bi bi-trash3"></i>
                                            </a>
                                            <a href="{{ route('roles.edit', $role->id) }}" class="action-btn action-btn-edit">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="card">
                    <div class="empty-state">
                        <i class="bi bi-shield-lock"></i>
                        <h4>No Roles Found</h4>
                        <p class="text-muted">Try creating a new role or adjusting your search.</p>
                    </div>
                </div>
            @endif

            <div class="d-flex justify-content-center mt-4">
                {{ $roles->links() }}
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
                <h2 class="fs-4 mb-3">Are you sure you want to delete this role?</h2>
                <p class="text-muted">This action cannot be undone and may affect users assigned to this role.</p>
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
    const appendId = (id) => {
        document.getElementById('deleteForm').action = "{{ route('roles.destroy', ':id') }}".replace(':id', id);
    };

    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("search");
        let typingTimer;
        const doneTypingInterval = 300;

        const performSearch = () => {
            const query = searchInput.value;

            fetch(`?search=${query}`, {
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newRoleContent = doc.querySelector("#roleTable");
                if (newRoleContent) {
                    document.getElementById("roleTable").innerHTML = newRoleContent.innerHTML;
                }
            })
            .catch(error => console.error("Search error:", error));
        };

        searchInput.addEventListener("input", function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(performSearch, doneTypingInterval);
        });
    });
</script>
@endsection
