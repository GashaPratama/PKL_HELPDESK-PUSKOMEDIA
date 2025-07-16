<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrasiController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\LaporanController;
use App\Http\Controllers\CustomerService\KategoriController;

// ==========================================================
// 🌐 PUBLIC ROUTES (Akses tanpa login)
// ==========================================================

Route::get('/', fn () => view('landing-page'));

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegistrasiController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegistrasiController::class, 'register'])->name('register.post');

// ==========================================================
// 🔐 LOGOUT (Butuh Auth)
// ==========================================================

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ==========================================================
// 🧑‍💼 ROLE-BASED DASHBOARD ROUTES
// ==========================================================

// SUPERADMIN
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    Route::get('/dashboard/superadmin', fn () => view('superadmin.dashboard'))->name('dashboard.superadmin');
});

// CUSTOMER SERVICE
Route::middleware(['auth', 'role:customer_service'])->group(function () {
    Route::get('/dashboard/customerservice', fn () => view('customerservice.dashboard'))->name('dashboard.customerservice');

    // Kategori (untuk kategori dinamis)
    Route::prefix('/kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });
});

// TEKNISI
Route::middleware(['auth', 'role:teknisi'])->group(function () {
    Route::get('/dashboard/teknisi', fn () => view('teknisi.dashboard'))->name('dashboard.teknisi');
});

// ==========================================================
// 👤 CUSTOMER AREA
// ==========================================================
Route::middleware(['auth', 'role:customer'])->group(function () {

    // Dashboard Customer (dengan data laporan ditampilkan)
    Route::get('/dashboard/customer', [LaporanController::class, 'dashboard'])->name('dashboard.customer');

    // Laporan
    Route::prefix('/laporan')->name('customer.laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/create', [LaporanController::class, 'create'])->name('create');
        Route::post('/store', [LaporanController::class, 'store'])->name('store');
        Route::get('/{id}', [LaporanController::class, 'show'])->name('show');
    });

    // Profil
    Route::prefix('/profil')->name('customer.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profil');

        // Foto
        Route::get('/edit-foto', [ProfileController::class, 'editFoto'])->name('edit-foto');
        Route::post('/update-foto', [ProfileController::class, 'updateFoto'])->name('update-foto');

        // Nama
        Route::get('/edit-nama', [ProfileController::class, 'editNama'])->name('edit-nama');
        Route::post('/update-nama', [ProfileController::class, 'updateNama'])->name('update-nama');

        // Email
        Route::get('/edit-email', [ProfileController::class, 'editEmail'])->name('edit-email');
        Route::post('/update-email', [ProfileController::class, 'updateEmail'])->name('update-email');

        // Password
        Route::get('/edit-password', [ProfileController::class, 'editPassword'])->name('edit-password');
        Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    });
});