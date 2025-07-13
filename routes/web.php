<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\RoleController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use App\Exports\PaymentsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\SaleReportController;
use App\Http\Controllers\DeliveryReportController;



Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/', [LoginController::class, 'showLoginForm']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registration routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Password reset routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});




Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashBoardController::class, 'index'] )->name('dashboard');

    
    Route::get('/employee',[EmployeeController::class,'index'])->name('employee.index');
    Route::get('/employee/create',[EmployeeController::class,'create'])->name('employee.create');
    Route::post('/employee/store', [EmployeeController::class,'store'])->name('employee.store');
    Route::get('/employee/edit/{employee}', [EmployeeController::class,'edit'])->name('employee.edit');
    Route::patch('/employee/update/{employee}', [EmployeeController::class,'update'])->name('employee.update');
    Route::delete('/employee/delete/{employee}', [EmployeeController::class,'destroy'])->name('employee.destroy');
    //customer
    Route::get('/customer',[CustomerController::class,'index'])->name('customer.index');
    Route::get('/customer/create',[CustomerController::class,'create'])->name('customer.create');
    Route::post('/customer/store', [CustomerController::class,'store'])->name('customer.store');
    Route::get('/customer/edit/{customer}', [CustomerController::class,'edit'])->name('customer.edit');
    Route::patch('/customer/update/{customer}', [CustomerController::class,'update'])->name('customer.update');
    Route::delete('/customer/delete/{customer}', [CustomerController::class,'destroy'])->name('customer.destroy');
    Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
    //product
    Route::get('/product',[ProductController::class,'index'])->name('product.index');
    Route::get('/product/create',[ProductController::class,'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class,'store'])->name('product.store');
    Route::get('/product/edit/{product}', [ProductController::class,'edit'])->name('product.edit');
    Route::patch('/product/update/{product}', [ProductController::class,'update'])->name('product.update');
    Route::delete('/product/delete/{product}', [ProductController::class,'destroy'])->name('product.destroy');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    //order
    Route::get('/order',[OrderController::class,'index'])->name('order.index');
    Route::get('/order/create',[OrderController::class,'create'])->name('order.create');
    Route::post('/order/store', [OrderController::class,'store'])->name('order.store');
    Route::get('/order/edit/{order}', [OrderController::class,'edit'])->name('order.edit');
    Route::patch('order/{order}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/order/delete/{order}', [OrderController::class,'destroy'])->name('order.destroy');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
    //payment
    
    Route::get('/payment',[PaymentController::class,'index'])->name('payment.index');
    Route::get('/payment/create',[PaymentController::class,'create'])->name('payment.create');
    Route::post('/payment/store', [PaymentController::class,'store'])->name('payment.store');
    Route::get('/payment/edit/{payment}', [PaymentController::class,'edit'])->name('payment.edit');
    Route::patch('/payment/update/{payment}', [PaymentController::class,'update'])->name('payment.update');
    Route::delete('/payment/delete/{payment}', [PaymentController::class,'destroy'])->name('payment.destroy');
    //stock
    Route::get('/stock',[StockController::class,'index'])->name('stock.index');
    Route::get('/stock/create',[StockController::class,'create'])->name('stock.create');
    Route::post('/stock/store', [StockController::class,'store'])->name('stock.store');
    Route::get('/stock/edit/{stock}', [StockController::class,'edit'])->name('stock.edit');
    Route::patch('/stock/update/{stock}', [StockController::class,'update'])->name('stock.update');
    Route::delete('/stock/delete/{stock}', [StockController::class,'deleteStock'])->name('stock.destroy');
    Route::get('/stock/edit/{stock}', [StockController::class,'edit'])->name('stock.edit');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
    
    //category
    Route::get('/category',[CategoryController::class,'index'])->name('category.index');
    Route::get('/category/create',[CategoryController::class,'create'])->name('category.create');
    Route::post('/category/store', [CategoryController::class,'store'])->name('category.store');
    Route::get('/category/edit/{category}', [CategoryController::class,'edit'])->name('category.edit');
    Route::patch('/category/update/{category}', [CategoryController::class,'update'])->name('category.update');
    Route::delete('/category/delete/{category}', [CategoryController::class,'destroy'])->name('category.destroy');
    //delivery
    Route::get('/delivery',[DeliveryController::class,'index'])->name('delivery.index');
    Route::get('/delivery/create',[DeliveryController::class,'create'])->name('delivery.create');
    Route::post('/delivery/store', [DeliveryController::class,'store'])->name('delivery.store');
    Route::get('/delivery/edit/{delivery}', [DeliveryController::class,'edit'])->name('delivery.edit');
    Route::patch('/delivery/update/{delivery}', [DeliveryController::class,'update'])->name('delivery.update');
    Route::delete('/delivery/delete/{delivery}', [DeliveryController::class,'destroy'])->name('delivery.destroy');
    //sub_category
    Route::get('/sub_category',[SubCategoryController::class,'index'])->name('sub_category.index');
    Route::get('/sub_category/create',[SubCategoryController::class,'create'])->name('sub_category.create');
    Route::post('/sub_category/store', [SubCategoryController::class,'store'])->name('sub_category.store');
    Route::get('/sub_category/edit/{sub_category}', [SubCategoryController::class,'edit'])->name('sub_category.edit');
    Route::patch('/sub_category/update/{sub_category}', [SubCategoryController::class,'update'])->name('sub_category.update');
    Route::delete('/sub_category/delete/{sub_category}', [SubCategoryController::class,'destroy'])->name('sub_category.destroy');
    Route::get('/sub_category/get_category/{id}',[SubCategoryController::class,'getSubCategoryByCatId'])->name('sub_category_get_category');

    Route::get('/faq/create',[FaqController::class,'create'])->name('faq.create');
    Route::post('/faq/store', [FaqController::class,'store'])->name('faq.store');
    Route::get('/faq/edit/{faq}', [FaqController::class,'edit'])->name('faq.edit');
    Route::patch('/faq/update/{faq}', [FaqController::class,'update'])->name('faq.update');
    Route::delete('/faq/delete/{faq}', [FaqController::class,'destroy'])->name('faq.destroy');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/edit/{role}', [RoleController::class,'edit'])->name('roles.edit');
    Route::patch('/roles/update/{role}', [RoleController::class,'update'])->name('roles.update');
    Route::delete('/roles/delete/{role}', [RoleController::class,'destroy'])->name('roles.destroy');

    
    // Export routes
   Route::get('/payment/export', [PaymentController::class, 'export'])->name('payments.export');
   Route::get('/products/export', [ProductController::class, 'export'])->name('product.export');
   Route::get('/orders/export', [OrderController::class, 'export'])->name('order.export');
   Route::get('/stock/export', [StockController::class, 'export'])->name('stock.export');
   Route::get('/customer/export', [CustomerController::class, 'export'])->name('customer.export');
   Route::get('/category/export', [CategoryController::class, 'export'])->name('category.export');
   Route::get('/sub-category/export', [SubCategoryController::class, 'export'])->name('sub_category.export');
   Route::get('/report/sale/export', [SaleReportController::class, 'export'])->name('sale.export');
   Route::get('/report/delivery/export', [DeliveryReportController::class, 'export'])->name('delivery.export');


   Route::get('/orders/export/pdf', [OrderController::class, 'exportPdf'])->name('order.export.pdf');
   Route::get('/products/export-pdf', [ProductController::class, 'exportPdf'])->name('product.exportPdf');
   

   //reports
   Route::get('/report/sales', [SaleReportController::class, 'generate'])->name('sales.report');
   Route::get('/report/delivery', [DeliveryReportController::class, 'generate'])->name('delivery.report');
   Route::get('/customers/export-pdf', [CustomerController::class, 'exportPdf'])->name('customer.exportPdf');
   Route::get('/payments/export-pdf', [PaymentController::class, 'exportPdf'])->name('payments.exportPdf');
   Route::get('/stock/export-pdf', [StockController::class, 'exportPdf'])->name('stock.exportPdf');
   Route::get('/category/export-pdf', [CategoryController::class, 'exportPdf'])->name('category.exportPdf');
   Route::get('/sub-category/export-pdf', [SubCategoryController::class, 'exportPdf'])->name('sub_category.exportPdf');
   Route::get('/sales/export-pdf', [SaleReportController::class, 'exportPdf'])->name('sale.exportPdf');
   Route::get('/delivery/export-pdf', [DeliveryReportController::class, 'exportPdf'])->name('delivery.exportPdf');



});

// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/login', [LoginController::class, 'logout'])->name('logout');


// Route::get('/dashboard', [DashboardController::class, 'index']);

// Route::get('/layout', function () {
//     return view('layout.nav');
// });
