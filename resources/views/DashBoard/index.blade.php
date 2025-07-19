@extends('layout.app')

@section('title', 'Dashboard')

@section('css')
    <style>
        .dashboard-card {
            transition: transform 0.2s ease-in-out;
        }
        .dashboard-card:hover {
            transform: scale(1.05);
        }

        /* Additional styles from the reference code */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(45deg, #3498db, #2980b9);
        }

        .stat-card h3 {
            color: #7f8c8d;
            font-size: 16px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .stat-trend {
            font-size: 14px;
            color: #27ae60;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .charts-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .chart-container {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .chart-title {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }

        .data-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .table-header {
            background: linear-gradient(45deg, #3498db, #2980b9);
            color: white;
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
        }

        th {
            background: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
        }

        tr:hover {
            background: #f8f9fa;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
        }

        .progress-bar {
            width: 100%;
            height: 8px;
            background: #ecf0f1;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(45deg, #27ae60, #2ecc71);
            transition: width 0.3s ease;
        }

        @media (max-width: 768px) {
            .charts-section {
                grid-template-columns: 1fr;
            }
        }

        .chart-totals {
    background: rgba(255, 255, 255, 0.9);
    padding: 12px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    font-size: 1.1rem;
}
    </style>
@endsection

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Dashboard</h1>

    @auth
        <div class="welcome-message mb-5 p-4 rounded shadow-sm text-white d-flex align-items-center" style="background: linear-gradient(90deg, #4f46e5, #3b82f6);">
            <i class="fas fa-smile-wink fa-2x me-3 animate__animated animate__bounce"></i>
            <div>
                <h3 class="mb-0 fw-bold">Welcome back, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}!</h3>
                <small class="opacity-75">We're glad to see you again.</small>
            </div>
        </div>
    @endauth

    <div class="stats-grid">
        @php
            $data = [
                'Categories' => $categoriesCount,
                'Products' => $productsCount,
                'Customers' => $customersCount,
                'Employees' => $employeesCount,
                'Orders' => $ordersCount,
                'Payments' => $paymentsCount,
                'Stocks' => $stocksCount,
            ];
        @endphp

        @foreach ($data as $label => $count)
            <div class="stat-card">
                <h3>{{ $label }}</h3>
                <div class="stat-value">{{ $count }}</div>
                <div class="stat-trend">
                    <span>📊</span>

                </div>
            </div>
        @endforeach
        {{-- @can('view reports')
            <div class="stat-card">
                <h3>Sale Report</h3>
                <div class="stat-trend">
                    <span>📊</span>
                    <a href="{{ route('sales.report') }}" class="text-decoration-none text-dark">
                    <span>View Sale Report</span>
                    </a>
                </div>
            </div>
             <div class="stat-card">
                <h3>Customer Report</h3>
                <div  class="stat-trend">
                    <span>📊</span>
                    <a href="{{ route('customer.report') }}" class="text-decoration-none text-dark">
                    <span>View Customer Report</span>
                    </a>
                </div>
            </div>
             <div class="stat-card">
                <h3>Delivery Report</h3>
                <div class="stat-trend">
                    <span>📊</span>
                    <a href="{{ route('delivery.report') }}" class="text-decoration-none text-dark">
                    <span>View Delivery Report</span>
                    </a>
                </div>
            </div>
            @endcan --}}

    </div>

    <div class="charts-section">
        <div class="chart-container">
            <div class="chart-title">Business Overview - Pie Chart</div>
            <canvas id="pieChart" width="400" height="300"></canvas>
        </div>
        <div class="chart-container">
            <div class="chart-title">Monthly Performance - Bar Chart</div>
            <canvas id="barChart" width="400" height="300"></canvas>
        </div>
    </div>

    <div class="data-table">
        <div class="table-header">Recent Activities & Data Summary</div>
        <table>
            <thead>
                <tr>
                    <th>Module</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                    <th>Progress</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Categories</td>
                    <td><span class="status-badge status-active">Active</span></td>
                    <td>{{ now()->format('M d, Y') }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $categoriesCount > 0 ? '75%' : '0%' }}"></div>
                        </div>
                    </td>
                    <td>📝 Manage</td>
                </tr>
                <tr>
                    <td>Products</td>
                    <td><span class="status-badge {{ $productsCount > 0 ? 'status-active' : 'status-pending' }}">{{ $productsCount > 0 ? 'Active' : 'Setup Required' }}</span></td>
                    <td>{{ $productsCount > 0 ? now()->format('M d, Y') : '-' }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $productsCount > 0 ? '50%' : '0%' }}"></div>
                        </div>
                    </td>
                    <td>{{ $productsCount > 0 ? '📝 Manage' : '➕ Add Products' }}</td>
                </tr>
                <tr>
                    <td>Customers</td>
                    <td><span class="status-badge {{ $customersCount > 0 ? 'status-active' : 'status-pending' }}">{{ $customersCount > 0 ? 'Active' : 'Setup Required' }}</span></td>
                    <td>{{ $customersCount > 0 ? now()->format('M d, Y') : '-' }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $customersCount > 0 ? '40%' : '0%' }}"></div>
                        </div>
                    </td>
                    <td>{{ $customersCount > 0 ? '📝 Manage' : '👥 Add Customers' }}</td>
                </tr>
                <tr>
                    <td>Employees</td>
                    <td><span class="status-badge {{ $employeesCount > 0 ? 'status-active' : 'status-pending' }}">{{ $employeesCount > 0 ? 'Active' : 'Setup Required' }}</span></td>
                    <td>{{ $employeesCount > 0 ? now()->format('M d, Y') : '-' }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $employeesCount > 0 ? '60%' : '0%' }}"></div>
                        </div>
                    </td>
                    <td>{{ $employeesCount > 0 ? '📝 Manage' : '👨‍💼 Add Staff' }}</td>
                </tr>
                <tr>
                    <td>Orders</td>
                    <td><span class="status-badge {{ $ordersCount > 0 ? 'status-active' : 'status-inactive' }}">{{ $ordersCount > 0 ? 'Active' : 'Not Started' }}</span></td>
                    <td>{{ $ordersCount > 0 ? now()->format('M d, Y') : '-' }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $ordersCount > 0 ? '30%' : '0%' }}"></div>
                        </div>
                    </td>
                    <td>{{ $ordersCount > 0 ? '📝 Manage' : '🛒 Start Orders' }}</td>
                </tr>
                <tr>
                    <td>Stock Management</td>
                    <td><span class="status-badge {{ $stocksCount > 0 ? 'status-active' : 'status-pending' }}">{{ $stocksCount > 0 ? 'Active' : 'Ready' }}</span></td>
                    <td>{{ $stocksCount > 0 ? now()->format('M d, Y') : '-' }}</td>
                    <td>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $stocksCount > 0 ? '25%' : '0%' }}"></div>
                        </div>
                    </td>
                    <td>{{ $stocksCount > 0 ? '📝 Manage' : '📦 Setup Inventory' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        // Sample data for demonstration using the actual counts from your backend
        const businessData = {
            categories: {{ $categoriesCount }},
            products: {{ $productsCount }},
            customers: {{ $customersCount }},
            employees: {{ $employeesCount }},
            orders: {{ $ordersCount }},
            payments: {{ $paymentsCount }},
            stocks: {{ $stocksCount }}
        };

        // Pie Chart
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: ['Categories', 'Products', 'Customers', 'Employees', 'Orders', 'Payments', 'Stocks'],
                datasets: [{
                    data: [
                        businessData.categories,
                        businessData.products,
                        businessData.customers,
                        businessData.employees,
                        businessData.orders,
                        businessData.payments,
                        businessData.stocks
                    ],
                    backgroundColor: [
                        '#3498db',
                        '#e74c3c',
                        '#2ecc71',
                        '#f39c12',
                        '#9b59b6',
                        '#1abc9c',
                        '#34495e'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // // Bar Chart - Monthly Performance (using sample data)


            // Fetch data from Laravel backend
fetch('/chart-data')
    .then(response => response.json())
    .then(data => {
        const barCtx = document.getElementById('barChart').getContext('2d');

        // Format numbers for display
        const formatNumber = num => {
            if (num % 1 === 0) return num.toLocaleString();
            return parseFloat(num).toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        };

        // Create chart
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [
                    {
                        label: 'Paid Payments',
                        data: data.paid,
                        backgroundColor: 'rgba(46, 204, 113, 0.8)',
                        borderColor: '#2ecc71',
                        borderWidth: 2,
                        borderRadius: 5
                    },
                    {
                        label: 'Pending Payments',
                        data: data.pending,
                        backgroundColor: 'rgba(231, 76, 60, 0.8)',
                        borderColor: '#e74c3c',
                        borderWidth: 2,
                        borderRadius: 5
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Amount' }
                    },
                    x: {
                        title: { display: true, text: 'Months' }
                    }
                },
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: context => {
                                return `${context.dataset.label}: ${formatNumber(context.raw)}`;
                            }
                        }
                    }
                }
            }
        });

        // Display totals below the chart
        const totalsContainer = document.createElement('div');
        totalsContainer.className = 'chart-totals mt-4 text-center';
        totalsContainer.innerHTML = `
            <div class="inline-block mx-4">
                <span class="font-bold text-green-600">Total Paid:</span>
                <span>${formatNumber(parseFloat(data.totals.paid))}</span>
            </div>
            <div class="inline-block mx-4">
                <span class="font-bold text-red-600">Total Pending:</span>
                <span>${formatNumber(parseFloat(data.totals.pending))}</span>
            </div>
        `;

        document.getElementById('barChart').parentNode.appendChild(totalsContainer);
    })
    .catch(error => console.error('Error:', error));

        // const barCtx = document.getElementById('barChart').getContext('2d');
        // new Chart(barCtx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
        //         datasets: [{
        //             label: 'Setup Progress',
        //             data: [10, 25, 40, 50, 65, 75],
        //             backgroundColor: 'rgba(52, 152, 219, 0.8)',
        //             borderColor: '#3498db',
        //             borderWidth: 2,
        //             borderRadius: 5
        //         }, {
        //             label: 'Target',
        //             data: [20, 35, 50, 65, 80, 100],
        //             backgroundColor: 'rgba(46, 204, 113, 0.8)',
        //             borderColor: '#2ecc71',
        //             borderWidth: 2,
        //             borderRadius: 5
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         scales: {
        //             y: {
        //                 beginAtZero: true,
        //                 max: 100
        //             }
        //         },
        //         plugins: {
        //             legend: {
        //                 position: 'top'
        //             }
        //         }
        //     }
        // });

        // Animate progress bars on load
        window.addEventListener('load', function() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 500);
            });
        });
    </script>
@endsection
