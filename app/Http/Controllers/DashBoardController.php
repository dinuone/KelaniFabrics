<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DashBoardController extends Controller
{
    public function index()
    {


        return view('Dashboard.index', [
            'categoriesCount' => Category::count(),
            'productsCount' => Product::count(),
            'customersCount' => Customer::count(),
            'employeesCount' => Employee::count(),
            'ordersCount' => Order::count(),
            'paymentsCount' => Payment::count(),
            'stocksCount' => Stock::count(),
        ]);
    }


//     public function getChartData()
// {
//     try {
//         $year = now()->year;

//         // Get monthly orders count
//         $orders = DB::table('orders')
//             ->select(
//                 DB::raw('MONTH(created_at) as month'),
//                 DB::raw('COUNT(*) as count')
//             )
//             ->whereYear('created_at', $year)
//             ->groupBy('month')
//             ->get()
//             ->pluck('count', 'month')
//             ->toArray();

//         // Get monthly payments total
//         $payments = DB::table('payments')
//             ->select(
//                 DB::raw('MONTH(created_at) as month'),
//                 DB::raw('SUM(amount) as total')
//             )
//             ->whereYear('created_at', $year)
//             ->groupBy('month')
//             ->get()
//             ->pluck('total', 'month')
//             ->toArray();

//         // Default values for all months
//         $ordersData = array_fill(1, 12, 0);
//         $paymentsData = array_fill(1, 12, 0);

//         foreach ($orders as $month => $count) {
//             $ordersData[$month] = $count;
//         }

//         foreach ($payments as $month => $total) {
//             $paymentsData[$month] = $total;
//         }

//         return response()->json([
//             'orders' => array_values($ordersData),
//             'payments' => array_values($paymentsData),
//         ]);

//     } catch (\Exception $e) {
//         // Log the error and return a valid JSON response
//         \Log::error('Chart data error: ' . $e->getMessage());
//         return response()->json([
//             'error' => 'Failed to load chart data',
//             'details' => $e->getMessage()
//         ], 500);
//     }
// }
public function getChartData()
{
    try {
        $year = now()->year;

        // 1. Fetch Paid Payments
        $paidData = DB::table('payments')
            ->whereYear('created_at', $year)
            ->where('status', 'paid')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // 2. Fetch Pending Payments
        $pendingData = DB::table('payments')
            ->whereYear('created_at', $year)
            ->where('status', 'pending')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // 3. Initialize Defaults (0 for all months)
        $defaults = array_fill(1, 12, 0);
        $paid = array_replace($defaults, $paidData);
        $pending = array_replace($defaults, $pendingData);

        // 4. Calculate and format totals
        $formatNumber = function($num) {
            $formatted = number_format($num, 2, '.', '');
            return rtrim(rtrim($formatted, '0'), '.');
        };

        return response()->json([
            'paid' => array_values($paid),
            'pending' => array_values($pending),
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'totals' => [
                'paid' => $formatNumber(array_sum($paid)),
                'pending' => $formatNumber(array_sum($pending))
            ]
        ]);

    } catch (\Exception $e) {
        Log::error('Chart Error: ' . $e->getMessage());
        return response()->json([
            'paid' => array_fill(0, 12, 0),
            'pending' => array_fill(0, 12, 0),
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'totals' => [
                'paid' => '0',
                'pending' => '0'
            ],
            'error' => 'Data load failed'
        ], 500);
    }
}

}
