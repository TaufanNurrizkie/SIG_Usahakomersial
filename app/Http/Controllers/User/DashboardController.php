<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Usaha;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalUsaha = $user->usahas()->count();

        /**
         * =========================
         * TERJEMAHAN STATUS (USER)
         * =========================
         */
        $usahaMenunggu = $user->usahas()
            ->whereIn('status', ['menunggu_admin', 'menunggu_camat'])
            ->count();

        $usahaDisetujui = $user->usahas()
            ->where('status', 'disetujui_camat')
            ->count();

        $usahaDitolak = $user->usahas()
            ->whereIn('status', ['ditolak_admin', 'ditolak_camat'])
            ->count();

        /**
         * =========================
         * USAHA TERBARU USER
         * =========================
         */
        $usahaTerbaru = $user->usahas()
            ->with(['kategori', 'kelurahan'])
            ->latest()
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'totalUsaha',
            'usahaMenunggu',
            'usahaDisetujui',
            'usahaDitolak',
            'usahaTerbaru'
        ));
    }
}
