<?php

namespace Database\Seeders;

use App\Models\KategoriUsaha;
use Illuminate\Database\Seeder;

class KategoriUsahaSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Kuliner',
                'deskripsi' => 'Usaha makanan dan minuman seperti restoran, warung makan, kafe, catering',
            ],
            [
                'nama_kategori' => 'Retail',
                'deskripsi' => 'Usaha perdagangan eceran seperti toko kelontong, minimarket, toko pakaian',
            ],
            [
                'nama_kategori' => 'Jasa',
                'deskripsi' => 'Usaha jasa seperti salon, bengkel, laundry, travel, konsultan',
            ],
            [
                'nama_kategori' => 'Produksi',
                'deskripsi' => 'Usaha manufaktur/produksi seperti konveksi, kerajinan, pabrik kecil',
            ],
            [
                'nama_kategori' => 'Kesehatan',
                'deskripsi' => 'Usaha di bidang kesehatan seperti apotek, klinik, optik',
            ],
            [
                'nama_kategori' => 'Pendidikan',
                'deskripsi' => 'Usaha di bidang pendidikan seperti bimbel, kursus, pelatihan',
            ],
            [
                'nama_kategori' => 'Teknologi',
                'deskripsi' => 'Usaha di bidang teknologi seperti service komputer, software house',
            ],
            [
                'nama_kategori' => 'Lainnya',
                'deskripsi' => 'Kategori usaha lainnya yang tidak termasuk kategori di atas',
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriUsaha::create($kategori);
        }
    }
}
