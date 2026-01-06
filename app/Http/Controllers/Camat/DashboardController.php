<?php

namespace App\Http\Controllers\Camat;

use App\Http\Controllers\Controller;
use App\Models\Usaha;

class DashboardController extends Controller
{
    public function index()
    {
        /**
         * =========================
         * RINGKASAN CAMAT
         * =========================
         */
        $izinDiterbitkan = Usaha::disetujui()->count(); // disetujui_camat

        $menungguPersetujuan = Usaha::menungguCamat()->count();

        $totalDitolak = Usaha::where('status', 'ditolak_camat')->count();

        /**
         * =========================
         * IZIN TERBARU
         * =========================
         */
        $izinTerbaru = Usaha::with(['user', 'kategori', 'kelurahan'])
            ->disetujui()
            ->latest('updated_at')
            ->limit(5)
            ->get();

        /**
         * =========================
         * PENGAJUAN MENUNGGU CAMAT
         * =========================
         */
        $pengajuanMenunggu = Usaha::with(['user', 'kategori', 'kelurahan'])
            ->menungguCamat()
            ->latest()
            ->limit(5)
            ->get();

        return view('camat.dashboard', compact(
            'izinDiterbitkan',
            'menungguPersetujuan',
            'totalDitolak',
            'izinTerbaru',
            'pengajuanMenunggu'
        ));
    }
}
