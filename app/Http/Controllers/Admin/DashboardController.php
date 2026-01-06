<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usaha;
use App\Models\KategoriUsaha;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Ringkasan utama (ADMIN CONTEXT)
        $totalUsaha = Usaha::count();

        $usahaMenunggu = Usaha::menungguAdmin()->count();
        $usahaDiverifikasi = Usaha::menungguCamat()->count();
        $usahaDitolak = Usaha::where('status', 'ditolak_admin')->count();

        $totalUsers = User::role('user')->count();

        /**
         * =========================
         * GRAFIK KATEGORI (INTERNAL)
         * =========================
         */
        $kategoriStats = KategoriUsaha::withCount('usahas')->get();

        $kategoriLabels = $kategoriStats->pluck('nama_kategori')->toArray();
        $kategoriData = $kategoriStats->pluck('usahas_count')->toArray();

        /**
         * =========================
         * PENGAJUAN TERBARU
         * =========================
         * HANYA YANG BUTUH TINDAKAN ADMIN
         */
        $pengajuanTerbaru = Usaha::with(['user', 'kategori', 'kelurahan'])
            ->menungguAdmin()
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsaha',
            'usahaMenunggu',
            'usahaDiverifikasi',
            'usahaDitolak',
            'totalUsers',
            'kategoriLabels',
            'kategoriData',
            'pengajuanTerbaru'
        ));
    }
}
