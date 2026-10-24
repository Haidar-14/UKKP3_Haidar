<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengaduanController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware fungsi untuk cek udh login atau blm, bisa buat cek session, dan cek role 
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::get('/user/dashboard', [DashboardController::class, 'user'])->name('user.dashboard');

    // Kelola User
    Route::get('/admin/user', [UserController::class, 'index'])->name('user.index');
    Route::post('/admin/user', [UserController::class, 'store'])->name('user.store');
    Route::put('/admin/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/admin/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Pengaduan
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::put('/pengaduan/{id}', [PengaduanController::class, 'update'])->name('pengaduan.update');
    Route::delete('/pengaduan/{id}', [PengaduanController::class, 'destroy'])->name('pengaduan.destroy');
    
    Route::get('/pengaduan/{id}/selesai', [PengaduanController::class, 'updateStatus'])->name('pengaduan.selesai');
});