<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 1. Menampilkan daftar user
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();
        return view('admin.user.index', compact('users'));
    }

    // 2. Menyimpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'no_telp'  => 'nullable|numeric|digits_between:10,15',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,user',
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'no_telp'  => $request->no_telp,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 3. Mengupdate data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email,' . $id,
            'no_telp'  => 'nullable|numeric|digits_between:10,15',
            'role'     => 'required|in:admin,user',
            'password' => 'nullable|min:6', // Opsional saat edit
        ]);

        $data = [
            'nama'    => $request->nama,
            'email'   => $request->email,
            'no_telp' => $request->no_telp,
            'role'    => $request->role,
        ];

        // Jika password diisi, update passwordnya
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 4. Menghapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Mencegah admin menghapus dirinya sendiri
        if ($user->id === Auth::user()->id) {
            return back()->withErrors(['error' => 'Anda tidak bisa menghapus akun Anda sendiri!']);
        }

        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}