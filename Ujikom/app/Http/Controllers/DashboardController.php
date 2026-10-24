<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaduan; // Pastikan ini dipanggil
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        // Menghitung jumlah data
        $totalUser = User::count();
        $totalPengaduan = Pengaduan::count(); // Menghitung total pengaduan

        return view('admin.dashboard', compact('totalUser', 'totalPengaduan'));
    }

    public function user()
    {
        // (Kode dashboard user biarkan seperti sebelumnya)
        return view('user.dashboard');
    }
}