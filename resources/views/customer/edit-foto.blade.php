<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Foto Profil</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

  <div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-center">🖼️ Edit Foto Profil</h2>

    @if (session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 mb-4 rounded">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('customer.update-foto') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="mb-4">
        <label class="block text-sm font-semibold mb-2">Foto Saat Ini</label>
        <img src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : asset('images/profile.png') }}"
             class="w-24 h-24 rounded-full object-cover border" alt="Foto Profil">
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Upload Foto Baru</label>
        <input type="file" name="foto_profil" accept="image/*" required
               class="w-full border rounded px-3 py-2 text-sm">
        @error('foto_profil')
          <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-between mt-6">
        <a href="{{ route('dashboard.customer') }}" class="text-blue-600 text-sm hover:underline">← Kembali ke Profil</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
          Simpan
        </button>
      </div>
    </form>
  </div>

</body>
</html>
