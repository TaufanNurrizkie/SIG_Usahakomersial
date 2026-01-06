<?php

namespace App\Http\Controllers;

use App\Models\Usaha;
use App\Models\KategoriUsaha;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    // Public map page
    public function index()
    {
        $kategoris = KategoriUsaha::all();
        $kelurahans = Kelurahan::all();

        return view('peta.index', compact('kategoris', 'kelurahans'));
    }

    // API endpoint for map data
    public function apiPetaUsaha(Request $request)
    {
        $query = Usaha::with(['kategori', 'kelurahan'])
            ->disetujui();

        // Filter by kategori
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter by kelurahan
        if ($request->has('kelurahan') && $request->kelurahan) {
            $query->where('kelurahan_id', $request->kelurahan);
        }

        $usahas = $query->get();

        // Define colors for each category
        $categoryColors = [
            1 => '#e74c3c', // Kuliner - Red
            2 => '#3498db', // Retail - Blue
            3 => '#2ecc71', // Jasa - Green
            4 => '#9b59b6', // Produksi - Purple
            5 => '#e91e63', // Kesehatan - Pink
            6 => '#ff9800', // Pendidikan - Orange
            7 => '#00bcd4', // Teknologi - Cyan
            8 => '#795548', // Lainnya - Brown
        ];

        $data = $usahas->map(function ($usaha) use ($categoryColors) {
            return [
                'id' => $usaha->id,
                'nama_usaha' => $usaha->nama_usaha,
                'latitude' => (float) $usaha->latitude,
                'longitude' => (float) $usaha->longitude,
                'kategori' => $usaha->kategori?->nama_kategori ?? 'Tanpa Kategori',
                'kategori_id' => $usaha->kategori_id,
                'kelurahan' => $usaha->kelurahan?->nama_kelurahan ?? 'Tidak Diketahui',
                'foto_usaha' => $usaha->foto_usaha ? asset('storage/' . $usaha->foto_usaha) : null,
                'color' => $categoryColors[$usaha->kategori_id] ?? '#757575',
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }
}
