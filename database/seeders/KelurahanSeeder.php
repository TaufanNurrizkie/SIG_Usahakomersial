<?php

namespace Database\Seeders;

use App\Models\Kelurahan;
use Illuminate\Database\Seeder;

class KelurahanSeeder extends Seeder
{
    public function run(): void
    {
        $kelurahans = [
            'Kelurahan Sukamaju',
            'Kelurahan Mekarjaya',
            'Kelurahan Cilandak',
            'Kelurahan Pasar Minggu',
            'Kelurahan Kebayoran',
            'Kelurahan Petogogan',
            'Kelurahan Gandaria',
            'Kelurahan Cipete',
            'Kelurahan Bangka',
            'Kelurahan Ragunan',
        ];

        foreach ($kelurahans as $kelurahan) {
            Kelurahan::create([
                'nama_kelurahan' => $kelurahan,
            ]);
        }
    }
}
