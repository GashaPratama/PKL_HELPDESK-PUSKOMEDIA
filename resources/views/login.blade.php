<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusko HELPDESK - Login</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Login!',
                    confirmButtonColor: '#3085d6',
                    timer: 1500,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
</head>
<body class="min-h-screen flex flex-col justify-between bg-gray-100 font-sans">
    
    <div class="flex flex-1">
        <div class="flex-1 flex flex-col justify-center p-10">
            <h1 class="text-2xl font-bold mb-4">Sistem Aduan Terpusat Puskomedia</h1>
            <p class="text-gray-600 mb-6">Hi, Selamat datang. Silahkan masuk dengan email</p>
            
            <!-- Form untuk login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" name="email" placeholder="Email" class="w-full p-3 mb-4 border border-gray-300 rounded-md" required>
                <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full p-3 mb-4 border border-gray-300 rounded-md" required>
                
                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700">Masuk</button>
            </form>

            <!-- Tombol buat akun -->
            <div class="text-center mt-4">
                <p class="text-gray-600 text-sm">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Buat sekarang</a>
                </p>
            </div>
        </div>

        <div class="hidden md:flex flex-1 justify-center items-center">
            <!-- Kosongkan atau tambahkan ilustrasi -->
        </div>
    </div>

    <footer class="bg-blue-600 text-white text-center py-4">
        © 2025 ALL RIGHTS RESERVED
    </footer>

</body>
</html>
