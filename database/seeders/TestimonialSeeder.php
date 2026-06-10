<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama'    => 'Dewi R.',
                'jabatan' => 'Ibu Rumah Tangga',
                'inisial' => 'DR',
                'warna'   => '#C86A44',
                'rating'  => 5.0,
                'isi'     => 'Setelah konsultasi dengan Kang Bahri, saya jadi lebih paham kondisi tubuh saya dan tahu langkah yang tepat untuk memperbaikinya.',
                'aktif'   => true,
                'urutan'  => 1,
            ],
            [
                'nama'    => 'Budi S.',
                'jabatan' => 'Wirausaha',
                'inisial' => 'BS',
                'warna'   => '#3b82f6',
                'rating'  => 4.9,
                'isi'     => 'Masalah lambung kronis saya yang sudah bertahun-tahun akhirnya membaik setelah mengikuti arahan pola makan dan detoks dari Akar Sehat.',
                'aktif'   => true,
                'urutan'  => 2,
            ],
            [
                'nama'    => 'Rina M.',
                'jabatan' => 'Karyawan Swasta',
                'inisial' => 'RM',
                'warna'   => '#8b5cf6',
                'rating'  => 5.0,
                'isi'     => 'Pendekatan holistik di sini sangat masuk akal. Saya merasa lebih berenergi setiap hari dan kualitas tidur meningkat drastis.',
                'aktif'   => true,
                'urutan'  => 3,
            ],
            [
                'nama'    => 'Ahmad F.',
                'jabatan' => 'Guru',
                'inisial' => 'AF',
                'warna'   => '#22c55e',
                'rating'  => 4.8,
                'isi'     => 'Sangat merekomendasikan program pendampingannya. Edukasinya sangat detail dan mudah dipraktikkan.',
                'aktif'   => true,
                'urutan'  => 4,
            ],
        ];

        foreach ($data as $item) {
            \App\Models\Testimonial::create($item);
        }
    }
}
