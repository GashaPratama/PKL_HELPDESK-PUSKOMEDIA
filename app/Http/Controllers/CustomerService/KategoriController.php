<?php

namespace App\Http\Controllers\CustomerService;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('customerservice.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255']);
        Kategori::create(['nama' => $request->nama]);

        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
