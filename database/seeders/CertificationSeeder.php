<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        $certs = [
            ['judul' => 'Terdaftar BPOM',        'en' => 'BPOM Registered',     'ar' => 'مسجّل لدى BPOM',      'gambar' => 'asset/produk/b-28-bioalpha.png',                'urutan' => 1],
            ['judul' => 'Sertifikat Halal MUI',  'en' => 'Halal MUI Certified', 'ar' => 'شهادة حلال MUI',      'gambar' => 'asset/produk/r12-detox.png',                    'urutan' => 2],
            ['judul' => 'Standar Mutu ISO',      'en' => 'ISO Quality Standard','ar' => 'معيار الجودة ISO',    'gambar' => 'asset/produk/b-28-bioalpha-removebg-preview.png','urutan' => 3],
            ['judul' => 'Sertifikat CPOTB',      'en' => 'GMP Certified',       'ar' => 'شهادة CPOTB',         'gambar' => 'asset/produk/r12-detox-removebg-preview.png',    'urutan' => 4],
        ];

        foreach ($certs as $c) {
            Certification::updateOrCreate(
                ['judul' => $c['judul']],
                [
                    'gambar'       => $c['gambar'],
                    'urutan'       => $c['urutan'],
                    'aktif'        => true,
                    'translations' => ['en' => ['judul' => $c['en']], 'ar' => ['judul' => $c['ar']]],
                ]
            );
        }
    }
}
