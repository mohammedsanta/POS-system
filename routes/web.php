<?php

use App\Http\Controllers\Admin\CommitmentController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\Auth\OwnerAuthController;
use App\Http\Controllers\Auth\StaffAuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MobileBookingController;
use App\Http\Controllers\OtherInvoicesController;
use App\Http\Controllers\ProductBarcodeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\ReturnInvoiceController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

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


// Public owner routes (login/signup) accessible only if NOT logged in as owner
Route::middleware('guest:owner')->group(function () {
    Route::get('/owner/login', [OwnerAuthController::class, 'showLogin'])->name('owner.login');
    Route::post('/owner/login', [OwnerAuthController::class, 'login']);
    // Route::get('/owner/signup', [OwnerAuthController::class, 'showSignup'])->name('owner.signup');
    Route::get('/owner/signup', function () {
        return redirect('/home');
    })->name('owner.signup');
    Route::post('/owner/signup', [OwnerAuthController::class, 'signup']);
});

// Public staff routes (login/signup) accessible only if NOT logged in as staff
Route::middleware('guest:staff')->group(function () {
    Route::get('/staff/login', [StaffAuthController::class, 'showLogin'])->name('login');
    Route::post('/staff/login', [StaffAuthController::class, 'login']);
    Route::get('/staff/signup', [StaffAuthController::class, 'showSignup'])->name('staff.signup');
    Route::post('/staff/signup', [StaffAuthController::class, 'signup']);
});



// ============================
// Cashier Pages
// ============================
Route::middleware('auth:staff')->group(function () {
    Route::post('/staff/logout', [StaffAuthController::class, 'logout'])->name('staff.logout');
    Route::get('/cashier/dashboard', [CashierController::class, 'dashboard'])->name('cashier.dashboard');
    // search by barcode
    Route::get('/search-barcode', [ProductController::class, 'searchBarcodeForm'])->name('products.search.form');
    Route::post('/search-barcode', [ProductController::class, 'searchBarcode'])->name('products.search');

    Route::prefix('staff/invoices/other')->name('other.invoices.')->group(function () {
        Route::get('/', [OtherInvoicesController::class, 'index'])->name('index');
        Route::get('/create', [OtherInvoicesController::class, 'create'])->name('create');
        Route::post('/', [OtherInvoicesController::class, 'store'])->name('store');
        Route::get('/{otherInvoice}', [OtherInvoicesController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [OtherInvoicesController::class, 'edit'])->name('edit');
        Route::put('/{otherInvoice}', [OtherInvoicesController::class, 'update'])->name('update');
        Route::delete('/{otherInvoice}', [OtherInvoicesController::class, 'destroy'])->name('destroy');
    });

    Route::resource('expenses', ExpenseController::class)->names([
        'index'   => 'expenses.index',
        'create'  => 'expenses.create',
        'store'   => 'expenses.store',
        'show'    => 'expenses.show',
        'edit'    => 'expenses.edit',
        'update'  => 'expenses.update',
        'destroy' => 'expenses.destroy',
    ]);

    // Start Invoices

    Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
    Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    // Show products of a specific invoice
    Route::get('/invoices/{invoice_number}/items', [InvoiceController::class, 'show'])->name('invoices.show');

    // End Invoices

    // Start Return Invoices
    
    Route::prefix('returns')->group(function () {
        Route::get('/', [ReturnInvoiceController::class, 'index'])->name('returns.index');
        Route::get('/choose-invoice', [ReturnInvoiceController::class, 'chooseInvoice'])->name('returns.chooseInvoice');
        Route::get('/{invoice_number}', [ReturnInvoiceController::class, 'show'])->name('returns.show');
        Route::post('/{item}/process', [ReturnInvoiceController::class, 'process'])->name('returns.process');
        Route::post('/{invoice_number}/return-invoice', [ReturnInvoiceController::class, 'returnInvoice'])->name('returns.returnInvoice');
    });

    // End Return Invoices

});


// ============================
// Admin Pages
// ============================
Route::middleware('owner')->group(function () {
    Route::get('/admin', [OwnerDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/owner/logout', [OwnerAuthController::class, 'logout'])->name('owner.logout');

    // Start Categories
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/edit/{category}', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/edit/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/delete/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    // End Categories
    // product
    Route::get('/admin/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/admin/product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/admin/product/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/admin/product/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/admin/product/edit/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/admin/product/delete/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    // end product
    // cashier
    Route::get('/admin/cashier', [CashierController::class, 'index'])->name('admin.cashier');
    Route::get('/admin/cashier/create', [CashierController::class, 'create'])->name('cashiers.create');
    Route::post('/admin/cashier/create', [CashierController::class, 'store'])->name('cashiers.store');
    Route::get('/admin/cashier/edit/{id}', [CashierController::class, 'edit'])->name('cashiers.edit');
    Route::put('/admin/cashier/update/{cashier}', [CashierController::class, 'update'])->name('cashiers.update');
    Route::delete('/admin/cashier/{cashier}', [CashierController::class, 'destroy'])->name('cashiers.destroy');
    // end cashier
    // start barcode
    // Route::get('/product-barcodes', [ProductBarcodeController::class, 'index'])->name('admin.products.barcodes');
    // Route::get('/product-barcodes/create', [ProductBarcodeController::class, 'create'])->name('admin.products.barcode.add');
    // Route::post('/product-barcodes', [ProductBarcodeController::class, 'store'])->name('barcodes.store');
    // Route::get('/product-barcodes/{barcode}/edit', [ProductBarcodeController::class, 'edit'])->name('admin.products.barcode.edit');
    // Route::put('/product-barcodes/{barcode}', [ProductBarcodeController::class, 'update'])->name('barcodes.update');
    // Route::delete('/product-barcodes/{barcode}', [ProductBarcodeController::class, 'destroy'])->name('barcodes.destroy');
    // new
    // Route::get('/increase-quantity', [ProductBarcodeController::class, 'showForm'])->name('barcode.increase');
    // Route::post('/increase-quantity', [ProductBarcodeController::class, 'increaseQuantity']);
    // end barcode
    // Start Purchases
    Route::get('/admin/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/admin/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/admin/purchases/store', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/admin/purchases/edit/{purchase}', [PurchaseController::class, 'edit'])->name('purchases.edit');
    Route::put('/admin/purchases/update/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
    Route::delete('/admin/purchases/delete/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.destroy');
    // End Purchases
    // Start Item Purchases
    // إدارة الأصناف الخاصة بفاتورة معينة
    Route::get('/admin/purchases/{purchase}/items', [PurchaseItemController::class, 'index'])->name('purchase-items.index');
    Route::get('/admin/purchases/{purchase}/items/create', [PurchaseItemController::class, 'create'])->name('purchase-items.create');
    Route::post('/admin/purchases/{purchase}/items', [PurchaseItemController::class, 'store'])->name('purchase-items.store');
    Route::get('/admin/purchases/{purchase}/items/{item}/edit', [PurchaseItemController::class, 'edit'])->name('purchase-items.edit');
    Route::put('/admin/purchases/{purchase}/items/{item}', [PurchaseItemController::class, 'update'])->name('purchase-items.update');
    Route::delete('/admin/purchases/{purchase}/items/{item}', [PurchaseItemController::class, 'destroy'])->name('purchase-items.destroy');
    // End Item Purchases

    // routes/web.php
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('suppliers', SupplierController::class);
    });

    Route::get('/admin/expenses', [ExpenseController::class, 'indexAdmin'])->name('expenses.indexAdmin');

    Route::prefix('admin')->name('admin.')->group(function() {
        Route::resource('/commitments', CommitmentController::class);
    });

    Route::get('/admin/product-inventory', function () {
        return view('admin.inventory.ProductInventory');
    })->name('admin.product-inventory');

    Route::resource('/admin/bookings', MobileBookingController::class);

    // // QuickInsertProduct
    // Route::get('/quick-insert-product', function () {
    //     return view('admin.quick-insert-product');
    // })->name('quick-insert-product');

    // restore invoices and admin view invoices
    // routes/web.php
    Route::get('/admin/invoices', [InvoiceController::class, 'AdminIndex'])->name('admin.invoices.index');
    Route::get('/admin/invoices/show', [InvoiceController::class, 'adminViewInvoices'])->name('admin.view.invoices');
    Route::post('/admin/invoices/{id}/restore', [InvoiceController::class, 'restore'])->name('invoices.restore');



});

// ============================
// Home Redirect
// ============================
Route::get('/home', function () {
    return view('welcome-login');
});

Route::get('/', function () {
    return redirect('/home');
});

