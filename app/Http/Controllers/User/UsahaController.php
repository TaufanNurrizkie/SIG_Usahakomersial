<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUsahaRequest;
use App\Http\Requests\UpdateUsahaRequest;
use App\Models\Usaha;
use App\Models\DokumenUsaha;
use App\Models\KategoriUsaha;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UsahaController extends Controller
{
    public function index()
    {
        $usahas = auth()->user()->usahas()
            ->with(['kategori', 'kelurahan'])
            ->latest()
            ->paginate(10);

        return view('user.usaha.index', compact('usahas'));
    }

    public function create()
    {
        $kategoris = KategoriUsaha::all();
        $kelurahans = Kelurahan::all();

        return view('user.usaha.create', compact('kategoris', 'kelurahans'));
    }

    public function store(StoreUsahaRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = 'menunggu_admin';

        // Handle foto_usaha upload
        if ($request->hasFile('foto_usaha')) {
            $foto = $request->file('foto_usaha');
            $filename = 'usaha_' . time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
            $data['foto_usaha'] = $foto->storeAs('foto_usaha', $filename, 'public');
        }

        $usaha = Usaha::create($data);

        // Handle multiple document uploads
        if ($request->hasFile('dokumen')) {
            foreach ($request->file('dokumen') as $index => $file) {
                $jenis = $request->jenis_dokumen[$index] ?? 'lainnya';
                $filename = 'dokumen_' . $usaha->id . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('dokumen_usaha', $filename, 'public');

                DokumenUsaha::create([
                    'usaha_id' => $usaha->id,
                    'jenis_dokumen' => $jenis,
                    'file_path' => $path,
                ]);
            }
        }

        return redirect()->route('user.usaha.index')
            ->with('success', 'Pengajuan usaha berhasil dikirim. Menunggu verifikasi admin.');
    }

    public function show(Usaha $usaha)
    {
        Gate::authorize('view', $usaha);
        
        $usaha->load(['kategori', 'kelurahan', 'dokumens']);

        return view('user.usaha.show', compact('usaha'));
    }

    public function edit(Usaha $usaha)
    {
        Gate::authorize('update', $usaha);

        $kategoris = KategoriUsaha::all();
        $kelurahans = Kelurahan::all();
        $usaha->load('dokumens');

        return view('user.usaha.edit', compact('usaha', 'kategoris', 'kelurahans'));
    }

public function update(UpdateUsahaRequest $request, Usaha $usaha)
{
    Gate::authorize('update', $usaha);

    $data = $request->validated();

    // Upload foto baru
    if ($request->hasFile('foto_usaha')) {
        if ($usaha->foto_usaha) {
            Storage::disk('public')->delete($usaha->foto_usaha);
        }

        $foto = $request->file('foto_usaha');
        $filename = 'usaha_' . time() . '_' . uniqid() . '.' . $foto->getClientOriginalExtension();
        $data['foto_usaha'] = $foto->storeAs('foto_usaha', $filename, 'public');
    }

    /**
     * ✅ JIKA PERNAH DITOLAK ADMIN ATAU CAMAT
     * ➜ BALIK KE MENUNGGU_ADMIN
     */
    if (
        $usaha->status === 'ditolak_admin' ||
        $usaha->status === 'ditolak_camat'
    ) {
        $data['status'] = 'menunggu_admin';
        $data['catatan_penolakan'] = null;
    }

    $usaha->update($data);

    // Upload dokumen baru
    if ($request->hasFile('dokumen')) {
        foreach ($request->file('dokumen') as $index => $file) {
            $jenis = $request->jenis_dokumen[$index] ?? 'lainnya';
            $filename = 'dokumen_' . $usaha->id . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('dokumen_usaha', $filename, 'public');

            DokumenUsaha::create([
                'usaha_id' => $usaha->id,
                'jenis_dokumen' => $jenis,
                'file_path' => $path,
            ]);
        }
    }

    return redirect()->route('user.usaha.index')
        ->with('success', 'Data usaha diperbarui dan dikirim ulang ke admin.');
}


    public function destroy(Usaha $usaha)
    {
        Gate::authorize('delete', $usaha);

        // Delete related files
        if ($usaha->foto_usaha) {
            Storage::disk('public')->delete($usaha->foto_usaha);
        }

        foreach ($usaha->dokumens as $dokumen) {
            Storage::disk('public')->delete($dokumen->file_path);
        }

        $usaha->delete();

        return redirect()->route('user.usaha.index')
            ->with('success', 'Usaha berhasil dihapus.');
    }

    public function deleteDokumen(Usaha $usaha, DokumenUsaha $dokumen)
    {
        Gate::authorize('update', $usaha);

        if ($dokumen->usaha_id !== $usaha->id) {
            abort(403);
        }

        Storage::disk('public')->delete($dokumen->file_path);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
