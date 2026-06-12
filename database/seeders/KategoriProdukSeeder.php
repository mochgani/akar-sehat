<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use Illuminate\Database\Seeder;

class KategoriProdukSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Minuman Herbal',   'slug' => 'minuman-herbal',   'urutan' => 1],
            ['nama' => 'Suplemen',         'slug' => 'suplemen',         'urutan' => 2],
            ['nama' => 'Perawatan Tubuh',  'slug' => 'perawatan-tubuh',  'urutan' => 3],
            ['nama' => 'Rempah & Bumbu',   'slug' => 'rempah-bumbu',     'urutan' => 4],
            ['nama' => 'Paket Hemat',      'slug' => 'paket-hemat',      'urutan' => 5],
        ];

        foreach ($kategoris as $kat) {
            KategoriProduk::updateOrCreate(['slug' => $kat['slug']], array_merge($kat, ['aktif' => true]));
        }
    }
}
