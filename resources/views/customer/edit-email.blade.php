<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Email - Puskomedia</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

  <!-- Navbar -->
  <nav class="bg-blue-600 text-white py-4 shadow">
    <div class="flex justify-between items-center px-6">
      <h1 class="text-base sm:text-lg font-semibold">
        Edit Email - {{ auth()->user()->nama_lengkap }}
      </h1>
      <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
          🔒 Logout
        </button>
      </form>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="max-w-2xl mx-auto mt-10 bg-white p-8 rounded-lg shadow">

    <h2 class="text-2xl font-bold mb-6 text-blue-700">Ubah Alamat Email</h2>

    <!-- Notifikasi sukses -->
    @if (session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
      </div>
    @endif

    <!-- Form Ubah Email -->
    <form action="{{ route('customer.update-email') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label for="email" class="block font-medium text-gray-700 mb-1">Email Baru</label>
        <input type="email" name="email" id="email"
          value="{{ old('email', auth()->user()->email) }}"
          class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:ring-blue-200"
          required>
        @error('email')
          <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-between mt-6">
        <a href="{{ route('dashboard.customer') }}" class="text-blue-600 text-sm hover:underline">← Kembali ke Profil</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
          Simpan Perubahan
        </button>
      </div>

      
    </form>

  </main>

</body>
</html>
