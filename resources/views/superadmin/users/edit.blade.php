@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6 sm:p-8">
  <h2 class="text-xl font-bold mb-6">Edit User</h2>

  @if ($errors->any())
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
      <ul class="list-disc list-inside">
        @foreach ($errors->all() as $e)
          <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm font-medium">Nama Lengkap</label>
      <input type="text" name="nama_lengkap" value="{{ $user->nama_lengkap }}" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium">Email</label>
      <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium">No. Telpon</label>
      <input type="text" name="no_telpon" value="{{ $user->no_telpon }}" class="w-full border rounded p-2" required>
    </div>

    <div>
      <label class="block text-sm font-medium">Jenis Kelamin</label>
      <select name="jenis_kelamin" class="w-full border rounded p-2" required>
        <option value="">-- Pilih --</option>
        <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
        <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">Role</label>
      <select name="role" class="w-full border rounded p-2" required>
        <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
        <option value="customer_service" {{ $user->role == 'customer_service' ? 'selected' : '' }}>Customer Service</option>
        <option value="teknisi" {{ $user->role == 'teknisi' ? 'selected' : '' }}>Teknisi</option>
        <option value="superadmin" {{ $user->role == 'superadmin' ? 'selected' : '' }}>Superadmin</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium">Password (Kosongkan jika tidak diubah)</label>
      <input type="password" name="password" class="w-full border rounded p-2">
    </div>

    <div class="flex justify-end gap-2">
      <a href="{{ route('superadmin.users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Kembali</a>
      <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
    </div>
  </form>
</div>
@endsection
