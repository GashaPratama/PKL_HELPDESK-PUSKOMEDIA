<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Customer - Puskomedia Helpdesk</title>
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

  <!-- Layout -->
  <div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-1/5 bg-blue-50 p-6 shadow-md flex flex-col items-center">

      <!-- Judul -->
      <h2 class="text-xl font-bold text-blue-700 mb-6 self-start">Profil</h2>

      <!-- Foto dan Info Pengguna -->
      <div class="mb-6 text-center w-full">
        <div class="w-24 h-24 mx-auto rounded-full overflow-hidden border-4 border-white shadow-lg ring-2 ring-blue-300 mb-3">
          <img src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('images/profile.png') }}" alt="Foto Profil" class="w-full h-full object-cover">
        </div>
        <p class="text-base font-semibold text-gray-800">
          {{ auth()->user()->nama_lengkap }}
        </p>
        <p class="text-sm text-gray-500">
          {{ auth()->user()->email }}
        </p>
        <span class="inline-block mt-2 text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full shadow-sm">
          👤 Customer
        </span>
      </div>

      <!-- Tombol Aksi -->
      <div class="flex flex-col gap-3 w-full">
        <a href="{{ route('customer.edit-foto') }}" class="bg-white text-left px-4 py-3 rounded-lg shadow hover:bg-blue-100 transition">
          🖼️ Edit Foto
        </a>
        <a href="{{ route('customer.edit-nama') }}" class="bg-white text-left px-4 py-3 rounded-lg shadow hover:bg-blue-100 transition">
          ✏️ Edit Nama
        </a>
        <a href="{{ route('customer.edit-email') }}" class="bg-white text-left px-4 py-3 rounded-lg shadow hover:bg-blue-100 transition">
          📧 Edit Email
        </a>
        <a href="{{ route('customer.edit-password') }}" class="bg-white text-left px-4 py-3 rounded-lg shadow hover:bg-blue-100 transition">
          🔒 Edit Password
        </a>
      </div>

    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">

      <!-- Section: Lapor -->
      <section class="mb-12">
        <h3 class="text-xl font-bold mb-4">Lapor</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
         <a href="{{ route('customer.laporan.create') }}" class="bg-white p-4 rounded shadow hover:bg-blue-50 block text-center">
   Add Laporan
</a>
        </div>
        <p class="text-sm mt-4 text-gray-600 leading-relaxed">
          ➤ Isian Laporan, Kategori, URL situs, Kendala, Foto/Video, Status laporan.<br>
          ➤ Akan diberi ID Ticket (generate by system).
        </p>
      </section>

<!-- Section: Laporan Saya -->
<section class="mt-12">
  <h3 class="text-xl font-bold mb-4">📋 Laporan Saya</h3>

  @if($laporan->isEmpty())
    <p class="text-gray-500">Belum ada laporan yang dikirim.</p>
  @else
    <div class="bg-white shadow rounded overflow-hidden">
<table class="min-w-full text-sm">
  <thead class="bg-blue-100 text-left">
    <tr>
      <th class="px-4 py-2">ID Ticket</th>
      <th class="px-4 py-2">Kategori</th>
      <th class="px-4 py-2">Kendala</th>
      <th class="px-4 py-2">Status</th>
      <th class="px-4 py-2">Tanggal</th>
      <th class="px-4 py-2">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @foreach($laporan as $item)
      <tr class="border-b hover:bg-gray-50">
        <td class="px-4 py-2">{{ $item->id }}</td>
        <td class="px-4 py-2">
        {{ json_decode($item->kategori)->nama ?? '-' }}
        </td>
        <td class="px-4 py-2">{{ Str::limit($item->kendala, 30) }}</td>
        <td class="px-4 py-2">
          <span class="inline-block px-2 py-1 text-xs bg-blue-200 text-blue-800 rounded">
            {{ $item->status }}
          </span>
        </td>
        <td class="px-4 py-2">{{ $item->created_at->format('d M Y') }}</td>
        <td class="px-4 py-2 flex gap-2">
          <!-- Tombol Edit -->
          <a href="{{ route('customer.laporan.edit', $item->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-xs rounded shadow">
            ✏️ Edit
          </a>

          <!-- Tombol Delete -->
          <form action="{{ route('customer.laporan.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
              @csrf
              @method('DELETE')
              <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 text-xs rounded shadow">
                  🗑️ Hapus
              </button>
          </form>
        </td>
      </tr>
    @endforeach
  </tbody>
</table>

    </div>
  @endif
</section>

    </main>
  </div>

</body>
</html>
