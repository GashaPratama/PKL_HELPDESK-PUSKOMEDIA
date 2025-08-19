<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List user (paginate biar ringan)
    public function index(Request $request)
    {
        $users = User::orderBy('id_user', 'desc')->paginate(10);
        return view('superadmin.users.index', compact('users'));
    }

    // Form tambah
    public function create()
    {
        $roles = ['customer', 'customer_service', 'teknisi', 'superadmin'];
        return view('superadmin.users.create', compact('roles'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:100|unique:user,nama_lengkap',
            'email'         => 'required|email|max:100|unique:user,email',
            'no_telpon'     => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'role'          => 'required|in:customer,customer_service,teknisi,superadmin',
            'password'      => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'no_telpon'     => $request->no_telpon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role'          => $request->role,
            'password'      => Hash::make($request->password),
        ]);

        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Form edit
    public function edit($id)
    {
        $user  = User::where('id_user', $id)->firstOrFail();
        $roles = ['customer', 'customer_service', 'teknisi', 'superadmin'];
        return view('superadmin.users.edit', compact('user', 'roles'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        $request->validate([
            'nama_lengkap'  => 'required|string|max:100|unique:user,nama_lengkap,' . $user->id_user . ',id_user',
            'email'         => 'required|email|max:100|unique:user,email,' . $user->id_user . ',id_user',
            'no_telpon'     => 'required|string|max:20',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'role'          => 'required|in:customer,customer_service,teknisi,superadmin',
            'password'      => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'nama_lengkap'  => $request->nama_lengkap,
            'email'         => $request->email,
            'no_telpon'     => $request->no_telpon,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role'          => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Hapus user
    public function destroy($id)
    {
        $user = User::where('id_user', $id)->firstOrFail();

        // Opsional: cegah hapus akun sendiri
        if (auth()->id() === $user->id_user) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('superadmin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
