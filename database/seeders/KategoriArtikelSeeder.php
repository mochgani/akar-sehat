<?php

namespace Database\Seeders;

use App\Models\KategoriArtikel;
use Illuminate\Database\Seeder;

class KategoriArtikelSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            ['nama' => 'Tanaman Herbal', 'slug' => 'tanaman-herbal', 'urutan' => 1, 'en' => 'Herbal Plants',     'ar' => 'النباتات العشبية'],
            ['nama' => 'Kesehatan',      'slug' => 'kesehatan',      'urutan' => 2, 'en' => 'Health',            'ar' => 'الصحة'],
            ['nama' => 'Pencernaan',     'slug' => 'pencernaan',     'urutan' => 3, 'en' => 'Digestion',         'ar' => 'الهضم'],
            ['nama' => 'Nutrisi',        'slug' => 'nutrisi',        'urutan' => 4, 'en' => 'Nutrition',         'ar' => 'التغذية'],
            ['nama' => 'Panduan',        'slug' => 'panduan',        'urutan' => 5, 'en' => 'Guides',            'ar' => 'أدلة'],
        ];

        foreach ($kategoris as $kat) {
            KategoriArtikel::updateOrCreate(
                ['slug' => $kat['slug']],
                [
                    'nama'         => $kat['nama'],
                    'urutan'       => $kat['urutan'],
                    'aktif'        => true,
                    'translations' => ['en' => ['nama' => $kat['en']], 'ar' => ['nama' => $kat['ar']]],
                ]
            );
        }
    }
}
