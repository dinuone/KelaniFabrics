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
}
