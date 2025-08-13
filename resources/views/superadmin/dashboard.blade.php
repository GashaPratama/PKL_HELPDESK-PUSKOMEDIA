@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
  <h1 class="text-2xl font-bold mb-6">Dashboard Superadmin</h1>

  {{-- Kartu Statistik User --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded shadow p-4">
      <div class="text-sm text-gray-500">Total User</div>
      <div class="text-2xl font-bold">{{ \App\Models\User::count() }}</div>
    </div>
    <div class="bg-white rounded shadow p-4">
      <div class="text-sm text-gray-500">Customer</div>
      <div class="text-2xl font-bold">{{ \App\Models\User::where('role','customer')->count() }}</div>
    </div>
    <div class="bg-white rounded shadow p-4">
      <div class="text-sm text-gray-500">CS & Teknisi</div>
      <div class="text-2xl font-bold">{{ \App\Models\User::whereIn('role',['customer_service','teknisi'])->count() }}</div>
    </div>
  </div>

  {{-- Kartu Statistik Tiket --}}
  @php
    $totalTiket = \App\Models\Laporan::count();
    $cek        = \App\Models\Laporan::where('status','Di Cek')->count();
    $proses     = \App\Models\Laporan::where('status','Diproses')->count();
    $selesai    = \App\Models\Laporan::where('status','Selesai')->count();
    $ditolak    = \App\Models\Laporan::where('status','Ditolak')->count();
  @endphp

  <div class="grid grid-cols-1 sm:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded shadow p-4">
      <div class="text-sm text-gray-500">Total Tiket</div>
      <div class="text-2xl font-bold">{{ $totalTiket }}</div>
    </div>
    <div class="bg-white rounded shadow p-4">
      <div class="text-sm text-gray-500">Di Cek</div>
      <div class="text-2xl font-bold">{{ $cek }}</div>
    </div>
    <div class="bg-white rounded shadow p-4">
      <div class="text-sm text-gray-500">Diproses</div>
      <div class="text-2xl font-bold">{{ $proses }}</div>
    </div>
    <div class="bg-white rounded shadow p-4">
      <div class="text-sm text-gray-500">Selesai</div>
      <div class="text-2xl font-bold">{{ $selesai }}</div>
    </div>
    <div class="bg-white rounded shadow p-4">
      <div class="text-sm text-gray-500">Ditolak</div>
      <div class="text-2xl font-bold">{{ $ditolak }}</div>
    </div>
  </div>

  {{-- Tombol Aksi Cepat --}}
  <div class="flex gap-2 mb-6">
    <a href="{{ route('superadmin.users.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded shadow">Kelola User →</a>
    <a href="{{ route('superadmin.tickets.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded shadow">Kelola Tiket →</a>
  </div>

  {{-- Tabel 5 Tiket Terbaru --}}
  @php
    $latest = \App\Models\Laporan::with('kategori')->orderBy('created_at','desc')->limit(5)->get();
  @endphp

  <div class="bg-white rounded shadow">
    <div class="p-4 border-b font-semibold">Tiket Terbaru</div>
    <div class="p-4 overflow-x-auto">
      <table class="min-w-full text-sm border">
        <thead class="bg-gray-50">
          <tr>
            <th class="p-2 border text-left">ID</th>
            <th class="p-2 border text-left">Kategori</th>
            <th class="p-2 border text-left">Deskripsi</th>
            <th class="p-2 border text-left">Status</th>
            <th class="p-2 border text-left">Dibuat</th>
          </tr>
        </thead>
        <tbody>
          @forelse($latest as $t)
            <tr>
              <td class="p-2 border">{{ $t->id ?? $t->id_laporan }}</td>
              <td class="p-2 border">{{ $t->kategori->nama ?? '-' }}</td>
              <td class="p-2 border">
                {{ \Illuminate\Support\Str::limit(
                  $t->kendala ?? $t->isi_tugas ?? $t->keterangan ?? $t->deskripsi ?? '-',
                  60
                ) }}
              </td>
              <td class="p-2 border">{{ $t->status ?? '-' }}</td>
              <td class="p-2 border">{{ $t->created_at ? $t->created_at->format('d M Y H:i') : '-' }}</td>
            </tr>
          @empty
            <tr><td class="p-3 text-center" colspan="5">Belum ada tiket.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
