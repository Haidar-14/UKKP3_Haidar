@extends('layouts.app')

@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')
<style>
    /* CSS Khusus biar tampilan lebih soft & modern */
    .card-custom {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .table-custom {
        margin-bottom: 0;
    }
    .table-custom thead th {
        background-color: #f8fafc;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        padding: 16px;
    }
    .table-custom tbody td {
        vertical-align: middle;
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
    }
    .table-custom tbody tr {
        transition: background-color 0.2s ease;
    }
    .table-custom tbody tr:hover {
        background-color: #f8fafc;
    }
    .avatar-circle {
        width: 40px;
        height: 40px;
        background-color: #e0e7ff;
        color: #4f46e5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.1rem;
        flex-shrink: 0;
    }
    .btn-action {
        width: 35px;
        height: 35px;
        padding: 0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .badge-soft-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }
    .badge-soft-success {
        background-color: #dcfce7;
        color: #16a34a;
    }
</style>

{{-- Notifikasi --}}

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" style="border-radius: 10px;" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i> {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card card-custom">
    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold" style="color: #1e293b;">Daftar Pengguna</h5>
        <button class="btn btn-primary px-4 py-2" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i> Tambah User
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-custom table-hover">
                <thead>
                    <tr>
                        <th width="5%" class="text-center">No</th>
                        <th>Pengguna</th>
                        <th class="text-center">Role</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            {{-- Nomor urut --}}
                            <td class="text-center text-muted">
                                {{ method_exists($users, 'firstItem') ? $users->firstItem() + $index : $index + 1 }}
                            </td>

                            {{-- Kolom Nama, Email, No Telp (Ditumpuk) --}}
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle">
                                        {{ strtoupper(substr($user->nama, 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold" style="color: #334155;">{{ $user->nama }}</h6>
                                        <small class="text-muted d-block"><i class="fas fa-envelope me-1"></i>{{ $user->email }}</small>
                                        <small class="text-muted d-block"><i class="fas fa-phone me-1"></i>{{ $user->no_telp ?? '-' }}</small>
                                    </div>
                                </div>
                            </td>

                            {{-- Kolom Role --}}
                            <td class="text-center">
                                <span class="badge rounded-pill {{ $user->role == 'admin' ? 'badge-soft-danger' : 'badge-soft-success' }} px-3 py-2">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="text-center">
                                <button class="btn btn-warning btn-action me-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $user->id }}" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>

                                @if(auth()->id() == $user->id)
                                    <button class="btn btn-secondary btn-action" title="Tidak bisa menghapus akun sendiri" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @else
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-action" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="fas fa-users fs-1 d-block mb-3 text-secondary opacity-50"></i>
                                Belum ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
@foreach($users as $user)
<div class="modal fade" id="modalEdit{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-lg bg-light" value="{{ $user->nama }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg bg-light" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">No Telp</label>
                        <input type="text" name="no_telp" class="form-control form-control-lg bg-light" value="{{ $user->no_telp }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Role Akses</label>
                        <select name="role" class="form-select form-select-lg bg-light" required>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Password Baru <small>(Opsional)</small></label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="Kosongkan jika tidak diubah">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control form-control-lg bg-light" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Email</label>
                        <input type="email" name="email" class="form-control form-control-lg bg-light" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">No Telp</label>
                        <input type="text" name="no_telp" class="form-control form-control-lg bg-light">
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Role Akses</label>
                        <select name="role" class="form-select form-select-lg bg-light" required>
                            <option value="admin">Admin</option>
                            <option value="user" selected>User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection