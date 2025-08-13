@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8" 
     x-data="{open:false, current:{id:null, kategori:'', deskripsi:'', status:'', link:''}}"
     x-on:opendetail.window="open=true; current=$event.detail">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-8">
    <h1 class="text-4xl font-extrabold text-gray-900">Kelola Tiket</h1>
    <a href="{{ route('superadmin.dashboard') }}" 
       class="inline-flex items-center gap-2 px-5 py-2 bg-gray-100 hover:bg-gray-200 rounded-md font-semibold text-gray-700 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
      </svg>
      Kembali ke Dashboard
    </a>
  </div>

  {{-- Alert sukses --}}
  @if(session('success'))
    <div class="mb-6 rounded-lg bg-green-50 border border-green-200 p-4 text-green-700 font-medium shadow-sm" role="alert">
      {{ session('success') }}
    </div>
  @endif

  {{-- Filter & Search --}}
  <form method="GET" class="bg-white rounded-lg shadow p-6 mb-8 grid grid-cols-1 md:grid-cols-5 gap-6">
    <div class="col-span-2">
      <label for="q" class="block text-sm font-medium text-gray-700 mb-1">Cari (ID/URL/Deskripsi)</label>
      <input
        type="text" name="q" id="q" value="{{ $q ?? '' }}"
        placeholder="Cari berdasarkan ID, URL, atau Deskripsi..."
        class="w-full border border-gray-300 rounded-md px-4 py-2 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500"
      />
    </div>

    <div>
      <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
      <select name="status" id="status" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Semua</option>
        @php $statuses = ['Di Cek','Diproses','Selesai','Ditolak']; @endphp
        @foreach($statuses as $s)
          <option value="{{ $s }}" {{ ($status ?? '') === $s ? 'selected' : '' }}>
            {{ $s }}
          </option>
        @endforeach
      </select>
    </div>

    <div>
      <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
      <select name="kategori" id="kategori" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Semua Kategori</option>
        @foreach($categoryOptions as $id => $name)
          <option value="{{ $id }}" {{ (string)($kategori ?? '') === (string)$id ? 'selected' : '' }}>
            {{ $name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="flex items-end gap-3 col-span-1 md:col-span-1">
      <button type="submit" class="w-full py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 transition">
        Terapkan
      </button>
      <a href="{{ route('superadmin.tickets.index') }}" 
         class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-100 transition text-gray-700">
        Reset
      </a>
    </div>
  </form>

  {{-- Tabel Tiket --}}
  <div class="bg-white rounded-lg shadow overflow-x-auto border border-gray-200">
    <table class="min-w-[900px] w-full text-sm text-left text-gray-700">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th scope="col" class="px-4 py-3 font-semibold cursor-pointer" @click="sortTickets('id')">
            ID
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block ml-2" fill="none" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
          </th>
          <th scope="col" class="px-4 py-3 font-semibold">Kategori</th>
          <th scope="col" class="px-4 py-3 font-semibold">Deskripsi</th>
          <th scope="col" class="px-4 py-3 font-semibold">Status</th>
          <th scope="col" class="px-4 py-3 font-semibold">Tanggal</th>
          <th scope="col" class="px-4 py-3 font-semibold text-center w-48">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($tickets as $t)
          <tr class="border-b hover:bg-blue-50 transition">
            <td class="px-4 py-3 align-top font-mono text-gray-800">{{ $t->id_laporan ?? $t->id }}</td>
            <td class="px-4 py-3 align-top">{{ $t->kategori->nama ?? '-' }}</td>
            <td class="px-4 py-3 align-top max-w-xs truncate" title="{{ $t->deskripsi ?? '-' }}">{{ $t->deskripsi ?? '-' }}</td>
            <td class="px-4 py-3 align-top font-semibold">
              @php
                $statusColors = [
                  'Di Cek' => 'text-yellow-600 bg-yellow-100',
                  'Diproses' => 'text-blue-600 bg-blue-100',
                  'Selesai' => 'text-green-600 bg-green-100',
                  'Ditolak' => 'text-red-600 bg-red-100',
                ];
                $cls = $statusColors[$t->status ?? ''] ?? 'text-gray-600 bg-gray-100';
              @endphp
              <span class="inline-block px-2 py-1 rounded-md text-xs font-medium {{ $cls }}">
                {{ $t->status ?? '-' }}
              </span>
            </td>
            <td class="px-4 py-3 align-top whitespace-nowrap">
              {{ $t->created_at ? $t->created_at->format('d M Y H:i') : '-' }}
            </td>
            <td class="px-4 py-3 align-top text-center">
              <div class="flex justify-center items-center gap-2">
                {{-- Ganti status langsung --}}
                <form method="POST" action="{{ route('superadmin.tickets.updateStatus', $t->id_laporan ?? $t->id) }}">
                  @csrf
                  @method('PUT')
                  <select name="status" class="border rounded-md p-1 text-sm cursor-pointer"
                    onchange="this.form.submit()" aria-label="Ubah status tiket {{ $t->id_laporan ?? $t->id }}">
                    @foreach($statuses as $s)
                      <option value="{{ $s }}" {{ ($t->status ?? '') === $s ? 'selected' : '' }}>
                        {{ $s }}
                      </option>
                    @endforeach
                  </select>
                </form>

                {{-- Tombol Detail --}}
                <button
                  type="button"
                  class="px-3 py-1.5 text-xs bg-blue-600 text-white rounded-md hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-400 w-full"
                  @click="$dispatch('opendetail', {
                      id: '{{ $t->id_laporan ?? $t->id }}',
                      kategori: '{{ $t->kategori->nama ?? '-' }}',
                      deskripsi: @js($t->deskripsi ?? '-'),
                      status: @js($t->status ?? '-'),
                      link: '{{ $t->url ?? '' }}'
                  })"
                >DETAIL</button>
              </div>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" class="p-6 text-center text-gray-500 font-semibold">Tidak ada data tiket</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Modal Detail --}}
  <div
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50"
  >
    <div
      class="bg-white max-w-md w-full rounded-xl shadow-2xl p-6 sm:p-8 relative"
      @click.away="open=false"
      x-trap.noscroll="open"
      role="dialog" aria-modal="true" aria-labelledby="modal-title"
    >
      {{-- Close Button --}}
      <button
        @click="open=false"
        aria-label="Tutup modal"
        class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-full"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>

      {{-- Title --}}
      <h2 id="modal-title" class="text-3xl font-bold text-gray-900 mb-6 text-center">
        Detail Tiket
      </h2>

      {{-- Content dengan tabel rapi --}}
      <table class="w-full text-gray-700 text-base leading-relaxed">
        <tbody>
          <tr>
            <td class="font-semibold pr-3 text-right align-top w-28">ID</td>
            <td class="px-2">:</td>
            <td x-text="current.id" class="pl-2"></td>
          </tr>
          <tr>
            <td class="font-semibold pr-3 text-right align-top w-28">Kategori</td>
            <td class="px-2">:</td>
            <td x-text="current.kategori" class="pl-2"></td>
          </tr>
          <tr>
            <td class="font-semibold pr-3 text-right align-top w-28 align-top">Deskripsi</td>
            <td class="px-2 align-top">:</td>
            <td class="pl-2 whitespace-pre-wrap" x-text="current.deskripsi"></td>
          </tr>
          <tr>
            <td class="font-semibold pr-3 text-right align-top w-28">Status</td>
            <td class="px-2">:</td>
            <td>
              <span x-text="current.status"
                class="inline-block px-2 py-1 rounded-md text-white"
                :class="{
                  'bg-yellow-500': current.status === 'Di Cek',
                  'bg-blue-600': current.status === 'Diproses',
                  'bg-green-600': current.status === 'Selesai',
                  'bg-red-600': current.status === 'Ditolak',
                }"
              ></span>
            </td>
          </tr>
          <tr>
            <td class="font-semibold pr-3 text-right w-28 align-top">Link</td>
            <td class="px-2 align-top">:</td>
            <td>
              <template x-if="current.link">
                <a :href="current.link" target="_blank"
                   class="inline-block px-4 py-2 bg-blue-600 text-white rounded-md
                   hover:bg-blue-700 transition shadow-md w-full text-center"
                >
                  Buka Link
                </a>
              </template>
              <template x-if="!current.link">
                <span class="text-gray-500 italic">-</span>
              </template>
            </td>
          </tr>
        </tbody>
      </table>

    </div>
  </div>
</div>
@endsection
