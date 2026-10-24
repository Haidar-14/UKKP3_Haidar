@extends('layouts.app')

@section('title', 'Data Pengaduan')
@section('page-title', 'Data Pengaduan')

@section('content')
<style>
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .table-custom { margin-bottom: 0; }
    .table-custom thead th {
        background-color: #f8fafc; color: #64748b; font-weight: 600;
        text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0; padding: 16px;
    }
    .table-custom tbody td {
        vertical-align: middle; padding: 16px; border-bottom: 1px solid #f1f5f9;
    }
    .table-custom tbody tr { transition: background-color 0.2s ease; }
    .table-custom tbody tr:hover { background-color: #f8fafc; }
    .avatar-circle {
        width: 40px; height: 40px; background-color: #e0e7ff; color: #4f46e5;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 1.1rem; flex-shrink: 0;
    }
    .badge-soft-primary { background-color: #e0e7ff; color: #4338ca; font-weight: 600; }
</style>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card card-custom">
    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold" style="color: #1e293b;">Daftar Pengaduan</h5>
        
        {{-- TOMBOL TAMBAH (Hanya untuk User) --}}
        @if(Auth::user()->role === 'user')
            <button class="btn btn-primary px-4 py-2" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="fas fa-plus me-1"></i> Buat Pengaduan
            </button>
        @endif
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Pelapor</th>
                        <th>Meja</th>
                        <th>Kategori</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">File</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduans as $index => $p)
                        <tr>
                            <td class="text-center text-muted">{{ $index + 1 }}</td>

                            {{-- Pelapor --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($p->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold" style="color: #334155;">{{ $p->nama }}</h6>
                                        <small class="text-muted d-block"><i class="fas fa-envelope me-1"></i>{{ $p->email }}</small>
                                        <small class="text-muted d-block"><i class="fas fa-phone me-1"></i>{{ $p->no_telp ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- Meja --}}
                            <td>
                                <span class="badge bg-info text-dark px-3 py-2 rounded-pill">Meja {{ $p->no_meja }}</span>
                            </td>

                            {{-- Kategori --}}
                            <td>
                                <span class="badge badge-soft-primary px-3 py-2 rounded-pill">{{ $p->kategori }}</span>
                            </td>

                            {{-- Status --}}
                            <td class="text-center">
                                @if($p->status == 'Menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @else
                                    <span class="badge bg-success">Selesai</span>
                                @endif
                            </td>

                            {{-- File --}}
                            <td class="text-center">
                                @if($p->file_upload)
                                    <button type="button" class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#imageModal{{ $p->id }}">
                                        <i class="fas fa-eye text-primary"></i>
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                                {{-- Aksi --}}
                                <td class="text-center">
                                @if(Auth::user()->role === 'admin')
                                    
                                    @if($p->status == 'Menunggu')
                                    <!-- Gunakan Link <a>, bukan <form> -->
                                    <a href="{{ route('pengaduan.selesai', $p->id) }}" class="btn btn-success btn-sm" title="Tandai Selesai" onclick="return confirm('Tandai selesai?')">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    @else
                                        <span class="text-muted"><i class="fas fa-check-double text-success"></i></span>
                                    @endif

                                @else
                                    
                                    {{-- AKSI USER --}}
                                    @if($p->status == 'Menunggu')
                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <form action="{{ route('pengaduan.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted" style="font-size: 0.85rem;"><i class="fas fa-lock me-1"></i> Terkunci</span>
                                    @endif

                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="fas fa-inbox fs-1 d-block mb-3 text-secondary opacity-50"></i>
                                Belum ada data pengaduan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- LOOPING UNTUK SEMUA MODAL (DILETAKKAN DI LUAR TABEL) --}}
@foreach($pengaduans as $p)
    
    {{-- MODAL EDIT (User Only) --}}
    @if(Auth::user()->role === 'user' && $p->status == 'Menunggu')
    <div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form action="{{ route('pengaduan.update', $p->id) }}" method="POST" enctype="multipart/form-data" class="modal-content" style="border-radius: 12px; border: none;">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pengaduan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Nomor Meja</label>
                            <select name="no_meja" class="form-select" required>
                                <option value="1" {{ $p->no_meja == '1' ? 'selected' : '' }}>Meja 1</option>
                                <option value="2" {{ $p->no_meja == '2' ? 'selected' : '' }}>Meja 2</option>
                                <option value="3" {{ $p->no_meja == '3' ? 'selected' : '' }}>Meja 3</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Kategori</label>
                            <input type="text" name="kategori" class="form-control" value="{{ $p->kategori }}" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Pengaduan</label>
                        <textarea name="isi_pengaduan" class="form-control" rows="4" required>{{ $p->isi_pengaduan }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ganti Bukti (Opsional)</label>
                        <input type="file" name="file_upload" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- MODAL LIHAT GAMBAR --}}
    @if($p->file_upload)
    <div class="modal fade" id="imageModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none; overflow: hidden;">
                <div class="modal-body p-0 position-relative text-center" style="background-color: #f8fafc;">
                    <button type="button" class="btn-close bg-white shadow-sm" data-bs-dismiss="modal" style="position: absolute; top: 15px; right: 15px; z-index: 10; opacity: 1; padding: 12px; border-radius: 50%;"></button>
                    <img src="{{ asset('storage/uploads/pengaduan/'.$p->file_upload) }}" class="img-fluid" style="max-height: 80vh; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
    @endif

@endforeach

{{-- MODAL TAMBAH (User Only) --}}
@if(Auth::user()->role === 'user')
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="modal-content" style="border-radius: 12px; border: none;">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Buat Pengaduan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Pelapor</label>
                        <input type="text" class="form-control bg-light" value="{{ Auth::user()->nama }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control bg-light" value="{{ Auth::user()->email }}" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Nomor Meja</label>
                        <select name="no_meja" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="1">Meja 1</option>
                            <option value="2">Meja 2</option>
                            <option value="3">Meja 3</option>
                        </select>
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Isi Pengaduan</label>
                    <textarea name="isi_pengaduan" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload Bukti (Opsional)</label>
                    <input type="file" name="file_upload" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- Script Buka Modal Otomatis kalau Error Validasi --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var myModal = new bootstrap.Modal(document.getElementById('modalTambah'));
        myModal.show();
    });
</script>
@endif
@endsection