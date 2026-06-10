<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'nama'        => 'Jahe Merah Plus',
                'sku'         => 'AS-001',
                'kategori'    => 'Minuman Herbal',
                'harga'       => 85000,
                'stok'        => 45,
                'kandungan'   => ['Jahe Merah', 'Madu Hutan', 'Kayu Manis', 'Cengkeh'],
                'deskripsi'   => 'Minuman herbal berbahan dasar jahe merah pilihan yang dipadukan dengan madu hutan asli. Membantu meningkatkan daya tahan tubuh dan menghangatkan badan.',
                'cara_pakai'  => 'Seduh 1 sachet dengan 200ml air panas. Minum 2x sehari pagi dan malam.',
                'foto'        => 'b-28-bioalpha.png',
                'is_featured' => true,
                'urutan'      => 1,
            ],
            [
                'nama'        => 'R12 Detox Herbal',
                'sku'         => 'AS-002',
                'kategori'    => 'Detoksifikasi',
                'harga'       => 120000,
                'stok'        => 28,
                'kandungan'   => ['Temulawak', 'Kunyit', 'Sambiloto', 'Meniran'],
                'deskripsi'   => 'Formula detoksifikasi alami untuk membersihkan racun dalam tubuh. Menggunakan 12 tanaman herbal pilihan yang telah terbukti secara tradisional.',
                'cara_pakai'  => 'Minum 1 kapsul 3x sehari setelah makan.',
                'foto'        => 'r12-detox.png',
                'is_featured' => true,
                'urutan'      => 2,
            ],
            [
                'nama'        => 'Madu Hutan Asli',
                'sku'         => 'AS-003',
                'kategori'    => 'Madu & Suplemen',
                'harga'       => 150000,
                'stok'        => 15,
                'kandungan'   => ['Madu Hutan Murni'],
                'deskripsi'   => 'Madu hutan asli yang dipanen langsung dari lebah liar di hutan Kalimantan. Tanpa campuran, tanpa pengawet.',
                'cara_pakai'  => 'Konsumsi 1-2 sendok makan per hari, bisa langsung atau dicampur air hangat.',
                'foto'        => null,
                'is_featured' => true,
                'urutan'      => 3,
            ],
            [
                'nama'        => 'Kapsul Sambiloto',
                'sku'         => 'AS-004',
                'kategori'    => 'Kapsul Herbal',
                'harga'       => 65000,
                'stok'        => 60,
                'kandungan'   => ['Sambiloto', 'Meniran', 'Daun Sirsak'],
                'deskripsi'   => 'Kapsul herbal sambiloto untuk menjaga daya tahan tubuh dan membantu mengatasi infeksi ringan secara alami.',
                'cara_pakai'  => 'Minum 2 kapsul 2x sehari setelah makan.',
                'foto'        => null,
                'is_featured' => false,
                'urutan'      => 4,
            ],
            [
                'nama'        => 'Teh Herbal Segar',
                'sku'         => 'AS-005',
                'kategori'    => 'Minuman Herbal',
                'harga'       => 45000,
                'stok'        => 80,
                'kandungan'   => ['Serai', 'Daun Pandan', 'Kayu Manis', 'Kapulaga'],
                'deskripsi'   => 'Teh herbal dengan kombinasi rempah pilihan untuk relaksasi dan menjaga kesehatan pencernaan.',
                'cara_pakai'  => 'Seduh 1 kantong teh dengan air panas 200ml, diamkan 3-5 menit.',
                'foto'        => null,
                'is_featured' => true,
                'urutan'      => 5,
            ],
            [
                'nama'        => 'Minyak Zaitun Herbal',
                'sku'         => 'AS-006',
                'kategori'    => 'Minyak & Salep',
                'harga'       => 95000,
                'stok'        => 8,
                'kandungan'   => ['Minyak Zaitun Extra Virgin', 'Habbatussauda', 'Lavender'],
                'deskripsi'   => 'Campuran minyak zaitun murni dengan habbatussauda dan essential oil lavender untuk pijat relaksasi dan kesehatan kulit.',
                'cara_pakai'  => 'Oleskan pada area yang diinginkan dan pijat perlahan.',
                'foto'        => null,
                'is_featured' => false,
                'urutan'      => 6,
            ],
            [
                'nama'        => 'Serbuk Temulawak',
                'sku'         => 'AS-007',
                'kategori'    => 'Serbuk Herbal',
                'harga'       => 55000,
                'stok'        => 35,
                'kandungan'   => ['Temulawak', 'Kunyit Putih', 'Lada Hitam'],
                'deskripsi'   => 'Serbuk temulawak murni untuk menjaga kesehatan hati dan meningkatkan nafsu makan secara alami.',
                'cara_pakai'  => 'Seduh 1 sendok teh dengan air panas, tambahkan madu secukupnya.',
                'foto'        => null,
                'is_featured' => false,
                'urutan'      => 7,
            ],
            [
                'nama'        => 'Paket Konsultasi Herbal',
                'sku'         => 'AS-008',
                'kategori'    => 'Paket',
                'harga'       => 250000,
                'stok'        => 0,
                'kandungan'   => [],
                'deskripsi'   => 'Paket konsultasi langsung dengan Kang Bahri selama 60 menit, termasuk rekomendasi herbal personal dan 1 produk herbal pilihan.',
                'cara_pakai'  => 'Hubungi via WhatsApp untuk penjadwalan.',
                'foto'        => null,
                'is_featured' => false,
                'urutan'      => 8,
            ],
        ];

        foreach ($products as $data) {
            Product::updateOrCreate(['sku' => $data['sku']], $data);
        }
    }
}
