<?php

namespace App\Http\Controllers;

use App\Models\Usaha;
use App\Models\KategoriUsaha;
use App\Models\Kelurahan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $kategoris  = KategoriUsaha::all();
        $kelurahans = Kelurahan::all();

        $query = Usaha::with(['user', 'kategori', 'kelurahan']);

        // ✅ Filter status (AMAN)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter kelurahan
        if ($request->filled('kelurahan')) {
            $query->where('kelurahan_id', $request->kelurahan);
        }

        // Filter tanggal
        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $usahas = $query->latest()->paginate(20)->withQueryString();

        // ✅ Statistik TANPA scope model
        $stats = [
            'total'           => Usaha::count(),
            'menunggu_admin'  => Usaha::where('status', 'menunggu_admin')->count(),
            'menunggu_camat'  => Usaha::where('status', 'menunggu_camat')->count(),
            'disetujui'       => Usaha::where('status', 'disetujui_camat')->count(),
            'ditolak_admin'   => Usaha::where('status', 'ditolak_admin')->count(),
            'ditolak_camat'   => Usaha::where('status', 'ditolak_camat')->count(),
        ];

        return view('laporan.index', compact(
            'usahas',
            'kategoris',
            'kelurahans',
            'stats'
        ));
    }

    public function exportPdf(Request $request)
    {
        $query = Usaha::with(['user', 'kategori', 'kelurahan']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('kelurahan')) {
            $query->where('kelurahan_id', $request->kelurahan);
        }

        if ($request->filled('dari_tanggal')) {
            $query->whereDate('created_at', '>=', $request->dari_tanggal);
        }

        if ($request->filled('sampai_tanggal')) {
            $query->whereDate('created_at', '<=', $request->sampai_tanggal);
        }

        $usahas = $query->latest()->get();

        // Label filter PDF
        $filterLabels = [];

        if ($request->kategori) {
            $filterLabels['kategori'] = optional(
                KategoriUsaha::find($request->kategori)
            )->nama_kategori ?? '-';
        }

        if ($request->kelurahan) {
            $filterLabels['kelurahan'] = optional(
                Kelurahan::find($request->kelurahan)
            )->nama_kelurahan ?? '-';
        }

        if ($request->status && $request->status !== 'all') {
            $filterLabels['status'] = ucfirst(str_replace('_', ' ', $request->status));
        }

        if ($request->dari_tanggal) {
            $filterLabels['dari_tanggal'] = $request->dari_tanggal;
        }

        if ($request->sampai_tanggal) {
            $filterLabels['sampai_tanggal'] = $request->sampai_tanggal;
        }

        $pdf = Pdf::loadView('pdf.laporan-usaha', compact('usahas', 'filterLabels'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('laporan-usaha-' . now()->format('YmdHis') . '.pdf');
    }
}
