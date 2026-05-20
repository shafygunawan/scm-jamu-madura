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
use Illuminate\Support\Facades\Route;

Route::permanentRedirect('/', '/dashboard');

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
    Route::get('/users', function () {
        return view('users.index');
    })->name('users.index')->middleware('role:Admin');
    Route::get('/users/create', function () {
        return view('users.create');
    })->name('users.create')->middleware('role:Admin');
    Route::get('/users/{id}/edit', function ($id) {
        return view('users.edit', ['id' => $id]);
    })->name('users.edit')->middleware('role:Admin');

    // Modul Manajemen Supplier & Evaluasi WSM
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index')->middleware('role:Admin|Manager');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create')->middleware('role:Admin|Manager');
    Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit')->middleware('role:Admin|Manager');
    Route::get('/suppliers/katalog', [SupplierController::class, 'katalog'])->name('suppliers.katalog')->middleware('role:Admin|Manager');
    Route::post('/suppliers/{id}/preferred', [SupplierController::class, 'setPreferred'])->name('suppliers.preferred')->middleware('role:Admin|Manager');

    // Modul Manajemen Produksi
    Route::get('/productions', [ProductionController::class, 'index'])->name('productions.index')->middleware('role:Admin|Manager|Produksi');
    Route::get('/productions/create', [ProductionController::class, 'create'])->name('productions.create')->middleware('role:Admin|Manager|Produksi');
    Route::get('/productions/{id}/edit', [ProductionController::class, 'edit'])->name('productions.edit')->middleware('role:Admin|Manager|Produksi');
    Route::post('/productions', [ProductionController::class, 'store'])->name('productions.store')->middleware('role:Admin|Manager|Produksi');

    // Modul Manajemen Gudang / Inventaris
    Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index')->middleware('role:Admin|Manager|Gudang');
    Route::get('/inventories/receive', [InventoryController::class, 'receive'])->name('inventories.receive')->middleware('role:Admin|Manager|Gudang');
    Route::post('/inventories/receive', [InventoryController::class, 'storeReceive'])->name('inventories.receive.store')->middleware('role:Admin|Manager|Gudang');
    Route::get('/inventories/product/create', [InventoryController::class, 'productCreate'])->name('inventories.product.create')->middleware('role:Admin|Manager|Gudang');

    // Modul Distribusi
    Route::get('/distributions', [DistributionController::class, 'index'])->name('distributions.index')->middleware('role:Admin|Manager|Distributor');
    Route::get('/distributions/create', [DistributionController::class, 'create'])->name('distributions.create')->middleware('role:Admin|Manager|Distributor');
    Route::post('/distributions', [DistributionController::class, 'storeShipment'])->name('distributions.store')->middleware('role:Admin|Manager|Distributor');
    Route::get('/distributions/distributor/create', [DistributionController::class, 'distributorCreate'])->name('distributions.distributor.create')->middleware('role:Admin|Manager|Distributor');

    // Modul Pelaporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index')->middleware('role:Admin|Manager');
    Route::get('/reports/export', [ReportController::class, 'exportPdf'])->name('reports.export')->middleware('role:Admin|Manager');
});
