<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    public function index()
    {
        // Cek siapa yang sedang login
        if (Auth::user()->role === 'admin') {
            // Kalau Admin, ambil SEMUA data pengaduan
            $pengaduans = Pengaduan::orderBy('id', 'desc')->get();
        } else {
            // Kalau User biasa, ambil data pengaduan MILIKNYA SENDIRI
            $pengaduans = Pengaduan::where('nama', Auth::user()->nama)
                            ->orderBy('id', 'desc')
                            ->get();
        }

        // Sesuaikan nama view-nya dengan struktur folder kamu
        // Kalau file-nya ada di resources/views/pengaduan/index.blade.php, pakai 'pengaduan.index'
        return view('admin.pengaduan.index', compact('pengaduans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_meja' => 'required',
            'kategori' => 'required|string|max:100',
            'isi_pengaduan' => 'required',
            'file_upload' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $fileName = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/pengaduan', $fileName, 'public');
        }

        Pengaduan::create([
            'nama' => Auth::user()->nama,
            'email' => Auth::user()->email,
            'no_telp' => Auth::user()->no_telp ?? '-',
            'no_meja' => $request->no_meja,
            'kategori' => $request->kategori,
            'isi_pengaduan' => $request->isi_pengaduan,
            'file_upload' => $fileName,
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        $request->validate([
            'no_meja' => 'required',
            'kategori' => 'required|string|max:100',
            'isi_pengaduan' => 'required',
            'file_upload' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $data = [
            'no_meja' => $request->no_meja,
            'kategori' => $request->kategori,
            'isi_pengaduan' => $request->isi_pengaduan,
        ];

        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('uploads/pengaduan', $fileName, 'public');
            
            if ($pengaduan->file_upload && file_exists(storage_path('app/public/uploads/pengaduan/' . $pengaduan->file_upload))) {
                unlink(storage_path('app/public/uploads/pengaduan/' . $pengaduan->file_upload));
            }
            $data['file_upload'] = $fileName;
        }

        $pengaduan->update($data);
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil diperbarui.');
    }

    // TAMBAHKAN METHOD INI UNTUK TOMBOL SELESAI DI ADMIN
    public function updateStatus($id)
{
    $pengaduan = Pengaduan::findOrFail($id);
    $pengaduan->status = 'Selesai';
    $pengaduan->save();

    return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil ditandai selesai!');
}

    public function destroy($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        if ($pengaduan->file_upload && file_exists(storage_path('app/public/uploads/pengaduan/' . $pengaduan->file_upload))) {
            unlink(storage_path('app/public/uploads/pengaduan/' . $pengaduan->file_upload));
        }
        
        $pengaduan->delete();
        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dihapus.');
    }
}