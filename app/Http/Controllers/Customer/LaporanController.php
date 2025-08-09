<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Kategori;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // Menampilkan form create laporan
    public function create()
    {
        $kategoris = Kategori::all();
        return view('customer.laporan.create', compact('kategoris'));
    }

    // Menyimpan laporan baru
   public function store(Request $request)
{
    $request->validate([
        'kategori_id' => 'required|exists:kategoris,id',
        'url_situs' => 'nullable|url',
        'kendala' => 'required|string',
        'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:2048',
    ]);

    try {
        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran', 'public');
        }

        $laporan = new Laporan();
        $laporan->user_id = Auth::id();
        $laporan->ticket_id = 'TCK-' . strtoupper(uniqid());
        $laporan->kategori_id = $request->kategori_id;
        $laporan->url_situs = $request->url_situs;
        $laporan->kendala = $request->kendala;
        $laporan->lampiran = $lampiranPath;
        $laporan->status = 'Diproses';
        
        if ($laporan->save()) {
            return redirect()->route('dashboard.customer')->with('success', 'Laporan berhasil dikirim.');
        } else {
            return back()->with('error', '❌ Gagal menyimpan laporan.');
        }
    } catch (\Exception $e) {
        return back()->with('error', '❌ Error: ' . $e->getMessage());
    }
}



    // Halaman Dashboard Customer dengan Laporan
    public function dashboard()
    {
        $laporan = Laporan::where('user_id', Auth::id())->latest()->get();
        return view('customer.dashboard', compact('laporan'));
    }

    // Menampilkan seluruh laporan user
    public function index()
    {
        $laporan = Laporan::where('user_id', Auth::id())->latest()->get();
        return view('customer.laporan.index', compact('laporan'));
    }

    // Menampilkan detail laporan
    public function show($id)
    {
        $laporan = Laporan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('customer.laporan.show', compact('laporan'));
    }

    //delete laporan
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

// Menampilkan form edit laporan
public function edit($id)
{
    $laporan = Laporan::findOrFail($id);
    $kategoriList = \App\Models\Kategori::all(); // ambil semua kategori

    return view('customer.laporan.edit-laporan', compact('laporan', 'kategoriList'));
}

// Proses update laporan
public function update(Request $request, $id)
{
    $request->validate([
        'kategori_id' => 'required',
        'kendala' => 'required',
    ]);

    $laporan = Laporan::findOrFail($id);
    $laporan->update([
        'kategori_id' => $request->kategori_id,
        'kendala' => $request->kendala,
    ]);

    return redirect()->back()->with('success', 'Laporan berhasil diperbarui.');
}




}