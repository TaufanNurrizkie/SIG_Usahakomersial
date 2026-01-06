<?php

namespace App\Http\Controllers\Camat;

use App\Http\Controllers\Controller;
use App\Models\KategoriUsaha;
use Illuminate\Http\Request;

class KategoriUsahaController extends Controller
{
    public function index()
    {
        $kategoriUsaha = KategoriUsaha::all();
        return view('camat.kategori.index', compact('kategoriUsaha'));
    }

    public function create()
    {
        return view('camat.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriUsaha::create($request->all());

        return redirect()->route('camat.kategori.index')->with('success', 'Kategori Usaha berhasil ditambahkan.');
    }

    public function edit(KategoriUsaha $kategori)
    {
        return view('camat.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriUsaha $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori->update($request->all());

        return redirect()->route('camat.kategori.index')->with('success', 'Kategori Usaha berhasil diperbarui.');
    }

    public function destroy(KategoriUsaha $kategori)
    {
        $kategori->delete();
        return redirect()->route('camat.kategori.index')->with('success', 'Kategori Usaha berhasil dihapus.');
    }
}
