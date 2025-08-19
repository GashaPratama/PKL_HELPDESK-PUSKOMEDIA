<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller


{
    // Tampilkan halaman profil utama
    public function index()
    {
        return view('customer.profil');
    }

    // Halaman Edit
    public function editNama()
    {
        return view('customer.edit-nama');
    }

    public function editEmail()
    {
        return view('customer.edit-email');
    }

    public function editPassword()
{
    return view('customer.edit-password');
}


    public function editFoto()
    {
        return view('customer.edit-foto');
    }

    // Proses Update Nama
    public function updateNama(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->nama_lengkap = $request->nama_lengkap;
        $user->save();

        return back()->with('success', 'Nama berhasil diperbarui.');
    }

    // Proses Update Email
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:user,email,' . Auth::user()->id_user . ',id_user',
        ]);

        $user = Auth::user();
        $user->email = $request->email;
        $user->save();

        return back()->with('success', 'Email berhasil diperbarui.');
    }

    // Proses Update Password
    public function updatePassword(Request $request)
{
    $request->validate([
        'password_lama' => 'required',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Cek apakah password lama benar
    if (!Hash::check($request->password_lama, $user->password)) {
        return back()->withErrors(['password_lama' => '❌ Password lama tidak sesuai']);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success', '✅ Password berhasil diperbarui.');
}

    // Proses Update Foto Profil
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            // Simpan foto baru
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $user->foto_profil = $path;
        }

        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
