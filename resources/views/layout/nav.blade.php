<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelaniya Fabrics</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome for 3D-style icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        /* Hide default browser scrollbar */
        html, body {
            scrollbar-width: none; /* Firefox */
            -ms-overflow-style: none; /* IE and Edge */
        }

        html::-webkit-scrollbar, body::-webkit-scrollbar {
            display: none; /* Chrome, Safari, and Opera */
        }
        /* Additional styling for 3D effect */
        .nav-link i {
            transition: all 0.3s ease;
            transform-style: preserve-3d;
        }
        .nav-link:hover i {
            transform: translateY(-3px) scale(1.1);
            text-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        /* Sidebar styling */
        .bg-blue-800 {
            background-color: #1e40af;
        }
        .bg-blue-700 {
            background-color: #1e3a8a;
        }
        .bg-primary {
            background-color: #1e3a8a;
        }

        /* Custom scrollbar styling */
        /* For WebKit browsers (Chrome, Safari, Edge) */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #1e3a8a;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #60a5fa;
        }

        /* For Firefox */
        .sidebar, .content-area {
            scrollbar-width: thin;
            scrollbar-color: #3b82f6 #1e3a8a;
        }

        /* Content area scrollbar styling (WebKit) */
        .content-area::-webkit-scrollbar {
            width: 6px;
        }

        .content-area::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .content-area::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }

        .content-area::-webkit-scrollbar-thumb:hover {
            background: #60a5fa;
        }

        /* Fixed sidebar and scrollable content */
        .sidebar-container {
            position: sticky;
            top: 0;
            height: calc(100vh - 56px); /* Subtract navbar height */
            z-index: 100;
        }

        .content-container {
            height: calc(100vh - 56px); /* Subtract navbar height */
            overflow-y: auto;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .sidebar {
                max-height: 50vh;
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }

            .row.min-vh-100 {
                flex-direction: column;
            }

            .col-md-3.col-lg-2.p-0.bg-blue-800 {
                width: 100%;
                position: relative;
                height: auto;
            }

            .sidebar-container {
                position: relative;
                height: auto;
                max-height: 50vh;
            }

            .content-container {
                height: auto;
                min-height: 50vh;
            }
        }



        .btn-toggle {
            background: none;
            border: none;
            color: #fff;
            padding: 0.375rem 0.75rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }
        .btn-toggle:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo.jpg') }}" alt="Kelani Fabrics Logo" class="me-2 h-8 rounded" height="10" />
                <span>Kelani Fabrics</span>
            </a>

            <!-- Profile Dropdown -->
            <div class="dropdown ms-auto">
                <a class="btn btn-outline-light dropdown-toggle d-flex align-items-center" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    @auth
                        <span class="me-2">Hi, {{ auth()->user()->first_name }}</span>
                        <span class="me-3 text-warning" style="white-space: nowrap;">
                            ({{ auth()->user()->getRoleNames()->join(', ') ?: 'No Role' }})
                        </span>
                    @endauth

                    <i class="bi bi-person-circle"></i> Profile
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.show') }}">
                            <i class="fas fa-user-circle me-2"></i> View Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider" /></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar with 3D icons -->
            <div class="col-md-3 col-lg-2 p-0 bg-blue-800 sidebar-container">
                <div class="sidebar h-100 overflow-auto">
                    <ul class="navbar-nav flex-column p-3">
                        @can('view dashboard')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('dashboard') ? 'bg-blue-700' : '' }}" href="/dashboard">
                                <i class="fas fa-cube fa-lg me-3"></i> Dashboard
                            </a>
                        </li>
                        @endcan

                        @can('manage roles')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('roles*') ? 'bg-blue-700' : '' }}" href="/roles">
                                <i class="fas fa-users fa-lg me-3"></i> Roles
                            </a>
                        </li>
                        @endcan

                        @can('manage employees')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('employee*') ? 'bg-blue-700' : '' }}" href="/employee">
                                <i class="fas fa-users fa-lg me-3"></i> Employee
                            </a>
                        </li>
                        @endcan

                        @can('manage customers')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('customer*') ? 'bg-blue-700' : '' }}" href="/customer">
                                <i class="fas fa-user-tie fa-lg me-3"></i> Customer
                            </a>
                        </li>
                        @endcan

                        @can('manage products')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('product*') ? 'bg-blue-700' : '' }}" href="/product">
                                <i class="fas fa-box-open fa-lg me-3"></i> Product
                            </a>
                        </li>
                        @endcan

                        @can('manage orders')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('order*') ? 'bg-blue-700' : '' }}" href="/order">
                                <i class="fas fa-shopping-cart fa-lg me-3"></i> Order
                            </a>
                        </li>
                        @endcan

                        @can('manage payments')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('payment*') ? 'bg-blue-700' : '' }}" href="/payment">
                                <i class="fas fa-money-bill-wave fa-lg me-3"></i> Payment
                            </a>
                        </li>
                        @endcan

                        @can('manage stock')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('stock*') ? 'bg-blue-700' : '' }}" href="/stock">
                                <i class="fas fa-warehouse fa-lg me-3"></i> Stock
                            </a>
                        </li>
                        @endcan

                        @can('manage categories')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('category*') ? 'bg-blue-700' : '' }}" href="/category">
                                <i class="fas fa-tags fa-lg me-3"></i> Category
                            </a>
                        </li>
                        @endcan

                        @can('manage sub categories')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('sub_category*') ? 'bg-blue-700' : '' }}" href="/sub_category">
                                <i class="fas fa-tag fa-lg me-3"></i> Sub Category
                            </a>
                        </li>
                        @endcan

                        @can('view reports')
                        <li class="nav-item dropdown">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center dropdown-toggle {{ request()->is('report*') ? 'bg-blue-700' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-chart-bar fa-lg me-3"></i> Reports
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark bg-dark">
                                <li>
                                    <a class="dropdown-item text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('report/sales*') ? 'bg-blue-700' : '' }}" href="/report/sales">
                                        <i class="fas fa-dollar-sign fa-lg me-3"></i> Sale Report
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('report/delivery*') ? 'bg-blue-700' : '' }}" href="/report/delivery">
                                        <i class="fas fa-truck fa-lg me-3"></i> Delivery Report
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('report/customer*') ? 'bg-blue-700' : '' }}" href="/report/customer">
                                        <i class="fas fa-shopping-cart fa-lg me-3"></i> Customer Report
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan
{{--
                        @can('view reports')
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('report/sales*') ? 'bg-blue-700' : '' }}" href="/report/sales">
                                <i class="fas fa-dollar-sign  fa-lg me-3"></i> Sale Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('report/delivery*') ? 'bg-blue-700' : '' }}" href="/report/delivery">
                                <i class="fas fa-truck  fa-lg me-3"></i> Delivery Report
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white hover:bg-blue-700 p-2 rounded d-flex align-items-center {{ request()->is('/report/customer*') ? 'bg-blue-700' : '' }}" href="/report/customer">
                                <i class="fas fa-shopping-cart  fa-lg me-3"></i> Customer Report
                            </a>
                        </li>
                        @endcan --}}


                    </ul>
                </div>
            </div>

            <div class="col-md-9 col-lg-10 p-4 bg-gray-100 content-container">
                <div class="content-area h-100">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script>
        // Optional: Rotate the chevron icon on toggle
       document.querySelectorAll('.btn-toggle').forEach(button => {
    button.addEventListener('click', (event) => {
        event.stopPropagation();  // prevent bubbling
    });
});
    </script>
</body>
</html>

