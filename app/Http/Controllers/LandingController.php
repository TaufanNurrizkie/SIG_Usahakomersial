<?php

namespace App\Http\Controllers;

use App\Models\Usaha;
use App\Models\KategoriUsaha;
use App\Models\Kelurahan;

class LandingController extends Controller
{
    public function index()
    {
        /**
         * =========================
         * DATA PETA (PUBLIK)
         * =========================
         * HANYA USAHA YANG SUDAH DISAHKAN CAMAT
         */
        $usahas = Usaha::where('status', 'disetujui_camat')
            ->with(['kategori', 'kelurahan'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($usaha) {
                return [
                    'id' => $usaha->id,
                    'nama_usaha' => $usaha->nama_usaha,
                    'latitude' => (float) $usaha->latitude,
                    'longitude' => (float) $usaha->longitude,
                    'kategori' => $usaha->kategori?->nama_kategori ?? 'Tanpa Kategori',
                    'kelurahan' => $usaha->kelurahan?->nama_kelurahan ?? 'Tidak Diketahui',
                ];
            })
            ->values();

        /**
         * =========================
         * STATISTIK PUBLIK
         * =========================
         */
        $approvedCount = Usaha::where('status', 'disetujui_camat')->count();

        $stats = [
            'usaha_terdaftar' => $approvedCount,
            'kategori' => KategoriUsaha::count(),
            'kelurahan' => Kelurahan::count(),
        ];

        /**
         * =========================
         * DATA KATEGORI (UNTUK UI)
         * =========================
         */
        $kategoris = KategoriUsaha::withCount([
            'usahas' => function ($query) {
                $query->where('status', 'disetujui_camat');
            }
        ])->get();

        return view('landing', compact('usahas', 'kategoris', 'stats'));
    }
}
