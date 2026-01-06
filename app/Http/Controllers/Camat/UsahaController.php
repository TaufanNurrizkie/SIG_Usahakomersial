<?php

namespace App\Http\Controllers\Camat;

use App\Http\Controllers\Controller;
use App\Models\Usaha;
use App\Models\KategoriUsaha;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            $query->menungguCamat();
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

        return view('camat.usaha.index', compact('usahas', 'kategoris', 'kelurahans'));
    }

    public function show(Usaha $usaha)
    {
        $usaha->load(['user', 'kategori', 'kelurahan', 'dokumens']);
        
        return view('camat.usaha.show', compact('usaha'));
    }

public function approve(Request $request, Usaha $usaha)
    {
        // 🔐 Cek: hanya camat & status harus 'menunggu_camat'
        if (! Auth::user()->hasRole('camat') || $usaha->status !== 'menunggu_camat') {
            abort(403, 'Anda tidak berwenang menyetujui usaha ini.');
        }

        $request->validate([
            'surat_izin' => 'required|file|mimes:pdf|max:5120',
        ], [
            'surat_izin.required' => 'Surat izin wajib diupload',
            'surat_izin.mimes' => 'Surat izin harus berformat PDF',
            'surat_izin.max' => 'Ukuran surat izin maksimal 5MB',
        ]);

        // Upload surat izin
        $suratIzin = $request->file('surat_izin');
        $filename = 'surat_izin_' . $usaha->id . '_' . time() . '.pdf';
        $path = $suratIzin->storeAs('surat_izin', $filename, 'public');

        $usaha->update([
            'status' => 'disetujui_camat',
            'surat_izin' => $path,
            'catatan_penolakan' => null, // bersihkan jika pernah ditolak
        ]);

        return redirect()->route('camat.usaha.index')
            ->with('success', 'Usaha berhasil disetujui dan surat izin telah diterbitkan.');
    }

    public function reject(Request $request, Usaha $usaha)
    {
        // 🔐 Cek: hanya camat & status harus 'menunggu_camat'
        if (! Auth::user()->hasRole('camat') || $usaha->status !== 'menunggu_camat') {
            abort(403, 'Anda tidak berwenang menolak usaha ini.');
        }

        $request->validate([
            'catatan_penolakan' => 'required|string|max:500',
        ], [
            'catatan_penolakan.required' => 'Catatan penolakan wajib diisi',
        ]);

        $usaha->update([
            'status' => 'ditolak_camat',
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);

        return redirect()->route('camat.usaha.index')
            ->with('success', 'Usaha telah ditolak.');
    }

    // Riwayat izin yang sudah diterbitkan
    public function riwayat(Request $request)
    {
        $query = Usaha::with(['user', 'kategori', 'kelurahan'])
            ->disetujui();

        // Filter
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->has('kelurahan') && $request->kelurahan) {
            $query->where('kelurahan_id', $request->kelurahan);
        }

        $usahas = $query->latest('updated_at')->paginate(10);
        $kategoris = KategoriUsaha::all();
        $kelurahans = Kelurahan::all();

        return view('camat.usaha.riwayat', compact('usahas', 'kategoris', 'kelurahans'));
    }
}
