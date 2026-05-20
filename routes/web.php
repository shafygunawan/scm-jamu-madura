<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\ProfileController;
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
    })->name('users.index');
    Route::get('/users/create', function () {
        return view('users.create');
    })->name('users.create');
    Route::get('/users/{id}/edit', function ($id) {
        return view('users.edit', ['id' => $id]);
    })->name('users.edit');

    // Modul Manajemen Supplier & Evaluasi WSM
    Route::get('/suppliers', function () {
        return view('suppliers.index');
    })->name('suppliers.index');
    Route::get('/suppliers/create', function () {
        return view('suppliers.create');
    })->name('suppliers.create');
    Route::get('/suppliers/{id}/edit', function ($id) {
        return view('suppliers.edit', ['id' => $id]);
    })->name('suppliers.edit');
    Route::get('/suppliers/katalog', function () {
        return view('suppliers.katalog');
    })->name('suppliers.katalog');

    // Modul Manajemen Produksi
    Route::get('/productions', function () {
        return view('productions.index');
    })->name('productions.index');
    Route::get('/productions/create', function () {
        return view('productions.create');
    })->name('productions.create');
    Route::get('/productions/{id}/edit', function ($id) {
        return view('productions.edit', ['id' => $id]);
    })->name('productions.edit');

    // Modul Manajemen Gudang / Inventaris
    Route::get('/inventories', function () {
        return view('inventories.index');
    })->name('inventories.index');
    Route::get('/inventories/receive', function () {
        return view('inventories.receive');
    })->name('inventories.receive');
    Route::get('/inventories/product/create', function () {
        return view('inventories.product_create');
    })->name('inventories.product.create');

    // Modul Distribusi
    Route::get('/distributions', function () {
        return view('distributions.index');
    })->name('distributions.index');
    Route::get('/distributions/create', function () {
        return view('distributions.create');
    })->name('distributions.create');
    Route::get('/distributions/distributor/create', function () {
        return view('distributions.distributor_create');
    })->name('distributions.distributor.create');

    // Modul Pelaporan
    Route::get('/reports', function () {
        return view('reports.index');
    })->name('reports.index');
});
