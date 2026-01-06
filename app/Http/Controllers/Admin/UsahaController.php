<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Usaha;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use App\Models\KategoriUsaha;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PengajuanUsahaBaru;

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

        // 🔔 kirim ke CAMAT
        User::role('camat')->get()->each(function ($camat) use ($usaha) {
            $camat->notify(
                new PengajuanUsahaBaru(
                    $usaha,
                    "Usaha \"{$usaha->nama_usaha}\" telah disetujui admin dan menunggu persetujuan camat"
                )
            );
        });

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

        $user = $usaha->user; // PENGAJU

        if (! $user) {
            abort(500, 'User pengaju tidak ditemukan');
        }

        $usaha->update([
            'status' => 'ditolak_admin',
            'catatan_penolakan' => $request->catatan_penolakan,
        ]);

        $user->notify(
            new PengajuanUsahaBaru(
                $usaha,
                "Pengajuan usaha kamu DITOLAK. Catatan: {$request->catatan_penolakan}"
            )
        );
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

    public function daftar(Request $request)
    {
        $query = Usaha::with(['user', 'kategori', 'kelurahan'])->where('status', 'disetujui_camat');

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

        return view('admin.usaha.daftar', compact('usahas', 'kategoris', 'kelurahans'));
    }
}
