<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    public function index()
    {
        $kelurahans = Kelurahan::all();
        return view('admin.kelurahan.index', compact('kelurahans'));
    }

    public function create()
    {
        return view('admin.kelurahan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelurahan' => 'required|string|max:255',
        ]);

        Kelurahan::create($request->all());

        return redirect()->route('admin.kelurahan.index')->with('success', 'Kelurahan berhasil ditambahkan.');
    }

    public function edit(Kelurahan $kelurahan)
    {
        return view('admin.kelurahan.edit', compact('kelurahan'));
    }

    public function update(Request $request, Kelurahan $kelurahan)
    {
        $request->validate([
            'nama_kelurahan' => 'required|string|max:255',
        ]);

        $kelurahan->update($request->all());

        return redirect()->route('admin.kelurahan.index')->with('success', 'Kelurahan berhasil diperbarui.');
    }

    public function destroy(Kelurahan $kelurahan)
    {
        $kelurahan->delete();
        return redirect()->route('admin.kelurahan.index')->with('success', 'Kelurahan berhasil dihapus.');
    }
}
