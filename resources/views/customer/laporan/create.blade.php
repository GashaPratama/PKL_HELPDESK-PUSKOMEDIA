<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buat Laporan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 p-6 font-sans">

  <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-4 text-blue-700">📝 Buat Laporan</h1>

    <form action="{{ route('customer.laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf

      <div>
        <label class="block font-semibold mb-1">Kategori</label>
        <select name="kategori_id" class="w-full border rounded p-2">
          @foreach($kategoris as $kategori)
            <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block font-semibold mb-1">URL Situs</label>
        <input type="text" name="url_situs" class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block font-semibold mb-1">Kendala</label>
        <textarea name="kendala" rows="4" class="w-full border rounded p-2" required></textarea>
      </div>

      <div>
        <label class="block font-semibold mb-1">Foto/Video (opsional)</label>
        <input type="file" name="lampiran" accept="image/*,video/*" class="w-full">
      </div>

      <div class="flex justify-between mt-6">
        <a href="{{ route('dashboard.customer') }}" class="text-blue-600 text-sm hover:underline mt-6">← Kembali ke Profil</a>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">Kirim Laporan</button>
      </div>
    </form>
  </div>

</body>
</html>