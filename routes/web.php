<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WsmCriteriaController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Modul Manajemen Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('role:Admin');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create')->middleware('role:Admin');
    Route::post('/users', [UserController::class, 'store'])->name('users.store')->middleware('role:Admin');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('role:Admin');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('role:Admin');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('role:Admin');

    // Modul Manajemen Supplier & Evaluasi WSM
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index')->middleware('role:Admin|Manager');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create')->middleware('role:Admin|Manager');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store')->middleware('role:Admin|Manager');
    Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit')->middleware('role:Admin|Manager');
    Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update')->middleware('role:Admin|Manager');
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy')->middleware('role:Admin|Manager');
    Route::get('/suppliers/katalog', [SupplierController::class, 'katalog'])->name('suppliers.katalog')->middleware('role:Admin|Manager');
    Route::post('/suppliers/{id}/preferred', [SupplierController::class, 'setPreferred'])->name('suppliers.preferred')->middleware('role:Admin|Manager');
    Route::get('/wsm-criteria', [WsmCriteriaController::class, 'index'])->name('wsm-criteria.index')->middleware('role:Admin|Manager');
    Route::put('/wsm-criteria', [WsmCriteriaController::class, 'update'])->name('wsm-criteria.update')->middleware('role:Admin|Manager');

    // Modul Manajemen Produksi
    Route::get('/productions', [ProductionController::class, 'index'])->name('productions.index')->middleware('role:Admin|Manager|Produksi');
    Route::get('/productions/create', [ProductionController::class, 'create'])->name('productions.create')->middleware('role:Admin|Manager|Produksi');
    Route::get('/productions/{production}/edit', [ProductionController::class, 'edit'])->name('productions.edit')->middleware('role:Admin|Manager|Produksi');
    Route::post('/productions', [ProductionController::class, 'store'])->name('productions.store')->middleware('role:Admin|Manager|Produksi');
    Route::put('/productions/{production}', [ProductionController::class, 'update'])->name('productions.update')->middleware('role:Admin|Manager|Produksi');

    // Modul Manajemen Gudang / Inventaris
    Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index')->middleware('role:Admin|Manager|Gudang');
    Route::get('/inventories/receive', [InventoryController::class, 'receive'])->name('inventories.receive')->middleware('role:Admin|Manager|Gudang');
    Route::post('/inventories/receive', [InventoryController::class, 'storeReceive'])->name('inventories.receive.store')->middleware('role:Admin|Manager|Gudang');
    Route::get('/inventories/product/create', [InventoryController::class, 'productCreate'])->name('inventories.product.create')->middleware('role:Admin|Manager|Gudang');
    Route::post('/inventories/products', [InventoryController::class, 'productStore'])->name('inventories.products.store')->middleware('role:Admin|Manager|Gudang');
    Route::get('/inventories/products/{product}/edit', [InventoryController::class, 'productEdit'])->name('inventories.products.edit')->middleware('role:Admin|Manager|Gudang');
    Route::put('/inventories/products/{product}', [InventoryController::class, 'productUpdate'])->name('inventories.products.update')->middleware('role:Admin|Manager|Gudang');
    Route::delete('/inventories/products/{product}', [InventoryController::class, 'productDestroy'])->name('inventories.products.destroy')->middleware('role:Admin|Manager|Gudang');
    Route::get('/inventories/raw-materials/create', [InventoryController::class, 'rawMaterialCreate'])->name('inventories.raw-materials.create')->middleware('role:Admin|Manager|Gudang');
    Route::post('/inventories/raw-materials', [InventoryController::class, 'rawMaterialStore'])->name('inventories.raw-materials.store')->middleware('role:Admin|Manager|Gudang');
    Route::get('/inventories/raw-materials/{rawMaterial}/edit', [InventoryController::class, 'rawMaterialEdit'])->name('inventories.raw-materials.edit')->middleware('role:Admin|Manager|Gudang');
    Route::put('/inventories/raw-materials/{rawMaterial}', [InventoryController::class, 'rawMaterialUpdate'])->name('inventories.raw-materials.update')->middleware('role:Admin|Manager|Gudang');
    Route::delete('/inventories/raw-materials/{rawMaterial}', [InventoryController::class, 'rawMaterialDestroy'])->name('inventories.raw-materials.destroy')->middleware('role:Admin|Manager|Gudang');

    // Modul Distribusi
    Route::get('/distributions', [DistributionController::class, 'index'])->name('distributions.index')->middleware('role:Admin|Manager|Distributor');
    Route::get('/distributions/create', [DistributionController::class, 'create'])->name('distributions.create')->middleware('role:Admin|Manager|Distributor');
    Route::post('/distributions', [DistributionController::class, 'storeShipment'])->name('distributions.store')->middleware('role:Admin|Manager|Distributor');
    Route::get('/distributions/distributor/create', [DistributionController::class, 'distributorCreate'])->name('distributions.distributor.create')->middleware('role:Admin|Manager|Distributor');
    Route::post('/distributions/distributors', [DistributionController::class, 'distributorStore'])->name('distributions.distributor.store')->middleware('role:Admin|Manager|Distributor');
    Route::get('/distributions/distributors/{distributor}/edit', [DistributionController::class, 'distributorEdit'])->name('distributions.distributor.edit')->middleware('role:Admin|Manager|Distributor');
    Route::put('/distributions/distributors/{distributor}', [DistributionController::class, 'distributorUpdate'])->name('distributions.distributor.update')->middleware('role:Admin|Manager|Distributor');
    Route::delete('/distributions/distributors/{distributor}', [DistributionController::class, 'distributorDestroy'])->name('distributions.distributor.destroy')->middleware('role:Admin|Manager|Distributor');
    Route::get('/distributions/{shipment}/edit', [DistributionController::class, 'edit'])->name('distributions.edit')->middleware('role:Admin|Manager|Distributor');
    Route::put('/distributions/{shipment}', [DistributionController::class, 'updateShipment'])->name('distributions.update')->middleware('role:Admin|Manager|Distributor');

    // Modul Pelaporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('role:Admin|Manager');
    Route::get('/reports/export', [ReportController::class, 'exportPdf'])->name('reports.export')->middleware('role:Admin|Manager');
});
