<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Edit Nama - Puskomedia Helpdesk</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">

    <nav class="bg-blue-600 text-white px-6 py-4 shadow flex justify-between items-center">
        <h1 class="text-lg font-semibold">Edit Nama - {{ auth()->user()->nama_lengkap }}</h1>
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Logout?')">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-sm shadow">🔒 Logout</button>
        </form>
    </nav>

    <div class="flex justify-center items-center mt-20">
        <div class="bg-white p-8 rounded-xl shadow-md w-full max-w-md">
            <h2 class="text-xl font-bold text-blue-700 mb-4">Ubah Nama Lengkap</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('customer.update-nama') }}">
                @csrf
                <div class="mb-4">
                    <label for="nama_lengkap" class="block text-sm font-medium mb-1">Nama Baru</label>
                    <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    @error('nama_lengkap')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-between mt-6">
        <a href="{{ route('dashboard.customer') }}" class="text-blue-600 text-sm hover:underline">← Kembali ke Profil</a>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
          Simpan Perubahan
        </button>
      </div>
            </form>
        </div>
    </div>
    

</body>
</html>
