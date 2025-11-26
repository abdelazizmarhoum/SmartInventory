<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Redirect the root URL to the products page
Route::get('/', function () {
    return redirect()->route('products.index');
});

// Resourceful Routes for all our main resources
// This single line creates all the necessary routes for index, create, store, show, edit, update, and destroy
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('customers', CustomerController::class);
Route::resource('orders', OrderController::class);

// Custom route for the PDF export
// This is needed because Route::resource doesn't include our custom exportPdf method
Route::get('orders/{order}/export-pdf', [OrderController::class, 'exportPdf'])->name('orders.export-pdf');