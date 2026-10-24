<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Test App')</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --sidebar-bg: #1e293b;
            --sidebar-hover: #334155;
            --bg: #f1f5f9;
        }

        * { box-sizing: border-box; }

        body {
            background-color: var(--bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            min-height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 1.5rem;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar .brand i {
            font-size: 2rem;
            color: #60a5fa;
        }

        .sidebar .brand h5 {
            margin: 0;
            font-weight: 700;
        }

        .sidebar .brand small {
            color: #94a3b8;
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 4px 10px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: var(--sidebar-hover);
            transform: translateX(4px);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: var(--primary);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        /* Konten */
        .content {
            margin-left: 250px;
            padding: 24px;
        }

        /* Topbar */
        .topbar {
            background-color: #fff;
            padding: 14px 24px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .topbar h5 {
            margin: 0;
            font-weight: 600;
            color: #0f172a;
        }

        /* Kartu umum */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 600;
            border-radius: 12px 12px 0 0 !important;
            padding: 16px 20px;
        }

        .card-body {
            padding: 20px;
        }

        .table thead th {
            background-color: #f8fafc;
            color: #0f172a;
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
        }

        .table tbody tr:hover {
            background-color: #f1f5f9;
        }

        /* Kartu statistik */
        .stat-card {
            border: none;
            border-radius: 12px;
            color: #fff;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            box-shadow: 0 6px 18px rgba(0,0,0,0.15);
        }

        .stat-card .icon {
            font-size: 3rem;
            opacity: 0.5;
        }

        .stat-card .number {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .stat-card.green {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        .stat-card.orange {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }

        .stat-card.red {
            background: linear-gradient(135deg, #ef4444, #dc2626);
        }

        /* Tombol */
        .btn {
            border-radius: 8px;
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* Form */
        .form-control, .form-select {
            border-radius: 8px;
            border: 1px solid #d1d5db;
            padding: 10px 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.2);
        }

        /* Modal */
        .modal-content {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column ">
    <div class="brand mb-3 ">
        <div>
            <h5 class="text-white mb-0 ">Tester</h5>
            <small>
                @if (Auth::user()->role === 'admin')
                    Panel Admin
                @else
                    Panel Customer
                @endif
            </small>
        </div>
    </div>
    <ul class="nav flex-column mt-2">
        @if (Auth::user()->role === 'admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
             <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}" href="{{ route('user.index') }}">
                    <i class="bi bi-people"></i> Kelola User
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pengaduan.index') ? 'active' : '' }}" href="{{ route('pengaduan.index') }}">
                    <i class="bi bi-file-earmark-text"></i> Semua Laporan Pengaduan
                </a>
            </li>
        @else
        {{-- user --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" href="{{ route('user.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pengaduan.index') ? 'active' : '' }}" href="{{ route('pengaduan.index') }}">
                    <i class="bi bi-file-earmark-text"></i> Semua Laporan Pengaduan
                </a>
            </li>
        @endif
    </ul>
</div>

<div class="content">
    <div class="topbar">
        <h5>@yield('page-title', 'Dashboard')</h5>
        <div class="d-flex align-items-center">
            {{-- <span class="me-3 text-dark fw-semibold">Halo, {{ Auth::user()->nama }}</span> --}}
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>


    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>