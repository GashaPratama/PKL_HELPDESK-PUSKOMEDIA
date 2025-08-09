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
