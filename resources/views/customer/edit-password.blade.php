<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password - Helpdesk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    <!-- Navbar -->
    <nav class="bg-blue-600 text-white py-4 shadow">
        <div class="flex justify-between items-center w-full px-6">
            <h1 class="text-base sm:text-lg font-semibold">
                Edit Password - {{ auth()->user()->nama_lengkap }}
            </h1>
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
                    🔒 Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Container -->
    <main class="max-w-lg mx-auto mt-10 bg-white p-8 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-blue-700 mb-6 flex items-center gap-2">
            🔐 Ubah Password
        </h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Error List --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('customer.update-password') }}" class="space-y-5">
            @csrf

            <div>
                <label for="password_lama" class="block font-medium text-sm mb-1">🔑 Password Lama</label>
                <input type="password" name="password_lama" id="password_lama"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>

            <div>
                <label for="password" class="block font-medium text-sm mb-1">🔏 Password Baru</label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>

            <div>
                <label for="password_confirmation" class="block font-medium text-sm mb-1">✅ Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('dashboard.customer') }}" class="text-sm text-gray-600 hover:underline">← Kembali ke Profil</a>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition font-semibold shadow">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </main>

</body>
</html>
