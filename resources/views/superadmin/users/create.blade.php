@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6 sm:p-8">
  <h2 class="text-xl font-bold mb-6">Tambah User</h2>

  @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-4">
    @csrf

    <div>
      <label class="block text-sm font-medium">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium">Email</label>
      <input type="email" name="email" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium">No. Telpon</label>
      <input type="text" name="no_telpon" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium">Jenis Kelamin</label>
      <select name="jenis_kelamin" class="w-full border rounded p-2" required>
        <option value="">-- Pilih --</option>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">Role</label>
      <select name="role" class="w-full border rounded p-2" required>
        <option value="">-- Pilih Role --</option>
        <option value="customer">Customer</option>
        <option value="customer_service">Customer Service</option>
        <option value="teknisi">Teknisi</option>
        <option value="superadmin">Superadmin</option>
      </select>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
      <div>
        <label class="block text-sm font-medium">Password</label>
        <input type="password" name="password" class="w-full border rounded p-2" required>
      </div>
      <div>
        <label class="block text-sm font-medium">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
      </div>
    </div>

    <div class="flex justify-end gap-2">
      <a href="{{ route('superadmin.users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
    </div>
  </form>
</div>
@endsection
