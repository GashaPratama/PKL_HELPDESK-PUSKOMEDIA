<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Laporan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

<!-- Navbar -->
<nav class="bg-blue-600 text-white py-4 shadow">
  <div class="flex justify-between items-center w-full px-6">
    <h1 class="text-base sm:text-lg font-semibold">
      Selamat Datang, {{ auth()->user()->nama_lengkap }}
    </h1>
    <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
      @csrf
      <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
        🔒 Logout
      </button>
    </form>
  </div>
</nav>

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">

  <h2 class="text-lg font-bold mb-4">✏️ Edit Laporan</h2>

  {{-- Notifikasi sukses --}}
  @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
      ✅ {{ session('success') }}
    </div>
  @endif

  <form action="{{ route('customer.laporan.update', $laporan->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
      <label class="block text-gray-700 mb-2">Kategori</label>
      <select name="kategori_id" class="border rounded w-full py-2 px-3" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach ($kategoriList as $kategori)
          <option value="{{ $kategori->id }}" {{ $laporan->kategori_id == $kategori->id ? 'selected' : '' }}>
            {{ $kategori->nama }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="mb-4">
      <label class="block text-gray-700 mb-2">Kendala</label>
      <textarea name="kendala" class="border rounded w-full py-2 px-3" required>{{ $laporan->kendala }}</textarea>
    </div>

    <div class="flex gap-2 mt-4">
      <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded shadow">
        💾 Simpan Perubahan
      </button>

      <a href="{{ route('dashboard.customer') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded shadow">
        ↩️ Kembali ke Dashboard
      </a>
    </div>
  </form>
</div>

</body>
</html>
