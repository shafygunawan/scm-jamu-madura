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

    // Modul Manajemen Supplier & Evaluasi WSM
    Route::get('/suppliers', function () {
        return view('suppliers.index');
    })->name('suppliers.index');

    // Modul Manajemen Produksi
    Route::get('/productions', function () {
        return view('productions.index');
    })->name('productions.index');

    // Modul Manajemen Gudang / Inventaris
    Route::get('/inventories', function () {
        return view('inventories.index');
    })->name('inventories.index');

    // Modul Distribusi
    Route::get('/distributions', function () {
        return view('distributions.index');
    })->name('distributions.index');

    // Modul Pelaporan
    Route::get('/reports', function () {
        return view('reports.index');
    })->name('reports.index');
});
