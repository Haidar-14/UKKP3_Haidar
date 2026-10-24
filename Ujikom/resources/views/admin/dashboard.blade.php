@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<style>
    /* CSS Khusus Dashboard */
    .card-stat {
        border: none;
        border-radius: 15px;
        color: white;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
    }
    .bg-gradient-blue { background: linear-gradient(135deg, #3b82f6, #2563eb); }
    .bg-gradient-orange { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .bg-gradient-green { background: linear-gradient(135deg, #10b981, #059669); }
    
    .welcome-banner {
        background: linear-gradient(135deg, #1e293b, #334155);
        border-radius: 15px;
        color: white;
        padding: 30px;
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <!-- Banner Sambutan -->
        <div class="welcome-banner shadow">
            <h3 class="fw-bold mb-2">Halo, {{ Auth::user()->nama }}</h3>
            <p class="mb-0 opacity-75">Selamat datang di Panel Administrator. Berikut adalah ringkasan data aplikasi pengaduan saat ini.</p>
        </div>
    </div>
</div>

<div class="row">
    <!-- Total Pengguna (Biru) -->
    <div class="col-md-6 mb-4">
        <div class="card card-stat bg-gradient-blue shadow-sm">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-2 opacity-75">Total Pengguna</h6>
                    <h2 class="mb-0 fw-bold">{{ $totalUser ?? 0 }}</h2>
                </div>
                <i class="fas fa-users fs-1 opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Total Pengaduan (Hijau) -->
    <div class="col-md-6 mb-4">
        <div class="card card-stat bg-gradient-green shadow-sm">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase mb-2 opacity-75">Total Pengaduan</h6>
                    <h2 class="mb-0 fw-bold">{{ $totalPengaduan ?? 0 }}</h2>
                </div>
                <i class="fas fa-file-alt fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>
@endsection