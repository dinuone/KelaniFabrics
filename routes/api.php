<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SubCategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PaymentController;


Route::get('/products',[ProductController::class,'ProductList']);
Route::get('/product/{id}', [ProductController::class, 'ProductDetails']);
Route::get('/products/search', [ProductController::class, 'searchProducts']);


Route::get('/categories', [CategoryController::class, 'CategoryList']);
Route::get('/categories/{id}/subcategories', [SubCategoryController::class, 'SubCategoryList']);

Route::get('/subcategories/{id}/products', [ProductController::class, 'SubCategoryProducts']);

Route::post('/place-order', [OrderController::class, 'placeOrder']);
Route::post('/order/mark-paid', [OrderController::class, 'markOrderAsPaid']);
Route::post('/create-payment', [PaymentController::class, 'createPaymentIntent']);
