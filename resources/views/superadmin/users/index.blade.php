@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-6 sm:p-8">
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-4 gap-3">
    <h2 class="text-xl font-bold">Kelola User</h2>
    <div class="flex gap-2">
      <a href="{{ route('superadmin.dashboard') }}"
         class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">← Back</a>
      <a href="{{ route('superadmin.users.create') }}"
         class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">➕ Tambah User</a>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 border border-red-300 rounded">{{ session('error') }}</div>
  @endif

  <div class="overflow-x-auto">
    <table class="min-w-full text-sm border rounded">
      <thead class="bg-gray-50">
        <tr class="text-left">
          <th class="p-3">ID</th>
          <th class="p-3">Nama</th>
          <th class="p-3">Email</th>
          <th class="p-3">Telp</th>
          <th class="p-3">JK</th>
          <th class="p-3">Role</th>
          <th class="p-3">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $u)
          <tr class="border-t">
            <td class="p-3">{{ $u->id_user }}</td>
            <td class="p-3">{{ $u->nama_lengkap }}</td>
            <td class="p-3">{{ $u->email }}</td>
            <td class="p-3">{{ $u->no_telpon }}</td>
            <td class="p-3">{{ $u->jenis_kelamin }}</td>
            <td class="p-3">{{ ucfirst(str_replace('_',' ',$u->role)) }}</td>
            <td class="p-3">
              <div class="flex gap-2">
                <a href="{{ route('superadmin.users.edit', $u->id_user) }}"
                   class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                <form action="{{ route('superadmin.users.destroy', $u->id_user) }}" method="POST"
                      onsubmit="return confirm('Hapus user ini?')">
                  @csrf @method('DELETE')
                  <button class="px-3 py-1 bg-red-600 text-white rounded">Hapus</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td class="p-3 text-center" colspan="7">Tidak ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if ($users->hasPages())
      <div class="mt-6 flex justify-center">
          <nav class="flex items-center space-x-1">
              {{-- Tombol Previous --}}
              @if ($users->onFirstPage())
                  <span class="px-3 py-1 rounded bg-gray-200 text-gray-500 cursor-not-allowed">Prev</span>
              @else
                  <a href="{{ $users->previousPageUrl() }}" class="px-3 py-1 rounded bg-blue-500 text-white hover:bg-blue-600">Prev</a>
              @endif

              {{-- Nomor Halaman --}}
              @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                  @if ($page == $users->currentPage())
                      <span class="px-3 py-1 rounded bg-blue-600 text-white font-bold">{{ $page }}</span>
                  @else
                      <a href="{{ $url }}" class="px-3 py-1 rounded bg-gray-200 text-gray-700 hover:bg-gray-300">{{ $page }}</a>
                  @endif
              @endforeach

              {{-- Tombol Next --}}
              @if ($users->hasMorePages())
                  <a href="{{ $users->nextPageUrl() }}" class="px-3 py-1 rounded bg-blue-500 text-white hover:bg-blue-600">Next</a>
              @else
                  <span class="px-3 py-1 rounded bg-gray-200 text-gray-500 cursor-not-allowed">Next</span>
              @endif
          </nav>
      </div>
  @endif
</div>
@endsection
