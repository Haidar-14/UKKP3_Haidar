@extends('layouts.app')

@section('title', 'Dashboard User')
@section('page-title', 'Dashboard Pengguna')

@section('content')
<style>
    /* CSS Disamakan dengan Dashboard Admin */
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
        <!-- Banner Sambutan (Sama seperti Admin) -->
        <div class="welcome-banner shadow">
            <h3 class="fw-bold mb-2">Halo, {{ Auth::user()->nama }}</h3>
            <p class="mb-0 opacity-75">Selamat datang di Dashboard Pengguna. Senang melihat Anda kembali di sistem Serkom.</p>
        </div>
    </div>
</div>


@endsection