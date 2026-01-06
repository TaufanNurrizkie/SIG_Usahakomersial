<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usaha;
use App\Models\KategoriUsaha;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsahaController extends Controller
{
    public function index(Request $request)
    {
        $query = Usaha::with(['user', 'kategori', 'kelurahan']);

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            // Default: show menunggu
            $query->menungguAdmin();
        }

        // Filter by kategori
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter by kelurahan
        if ($request->has('kelurahan') && $request->kelurahan) {
            $query->where('kelurahan_id', $request->kelurahan);
        }

        $usahas = $query->latest()->paginate(10);
        $kategoris = KategoriUsaha::all();
        $kelurahans = Kelurahan::all();

        return view('admin.usaha.index', compact('usahas', 'kategoris', 'kelurahans'));
    }

    public function show(Usaha $usaha)
    {
        $usaha->load(['user', 'kategori', 'kelurahan', 'dokumens']);
        
        return view('admin.usaha.show', compact('usaha'));
    }


public function approve(Usaha $usaha)
{
     if (! Auth::user()->hasRole('admin') || $usaha->status !== 'menunggu_admin') {
            abort(403, 'Aksi tidak diizinkan.');
        }

    $usaha->update([
        'status' => 'menunggu_camat',
        'catatan_penolakan' => null,
    ]);

    return redirect()->route('admin.usaha.index')
        ->with('success', 'Usaha berhasil diverifikasi dan diteruskan ke Camat.');
}

public function reject(Request $request, Usaha $usaha)
{
     if (! Auth::user()->hasRole('admin') || $usaha->status !== 'menunggu_admin') {
            abort(403, 'Aksi tidak diizinkan.');
        }

    $request->validate([
        'catatan_penolakan' => 'required|string|max:500',
    ]);

    $usaha->update([
        'status' => 'ditolak_admin',
        'catatan_penolakan' => $request->catatan_penolakan,
    ]);

    return redirect()->route('admin.usaha.index')
        ->with('success', 'Usaha telah ditolak.');
}

    public function destroy(Usaha $usaha)
    {
        Gate::authorize('delete', $usaha);

        $usaha->delete();

        return redirect()->route('admin.usaha.index')
            ->with('success', 'Usaha berhasil dihapus.');
    }
}
