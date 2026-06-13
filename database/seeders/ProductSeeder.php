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
                'cara_pakai'  => '<ol><li><strong>Waktu Konsumsi</strong>Konsumsi 1 kapsul pagi setelah sarapan dan 1 kapsul malam setelah makan.</li><li><strong>Durasi Program</strong>Program intensif: 30 hari. Setelah itu lanjutkan dengan R12 Detoksifikasi standar untuk pemeliharaan.</li><li><strong>Hidrasi</strong>Perbanyak konsumsi air putih selama program — minimal 2,5 liter per hari untuk mendukung pembuangan racun.</li><li><strong>Penyimpanan</strong>Simpan di tempat sejuk dan kering, jauhkan dari jangkauan anak-anak.</li></ol>',
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

        // Field tambahan per SKU (deskripsi singkat, manfaat, satuan, isi kemasan)
        $extra = [
            'AS-001' => ['satuan' => 'sachet', 'isi' => '10 sachet / box', 'singkat' => 'Minuman jahe merah dan madu hutan untuk meningkatkan daya tahan tubuh dan menghangatkan badan.', 'manfaat' => ['Meningkatkan daya tahan tubuh', 'Menghangatkan badan secara alami', 'Membantu meredakan masuk angin']],
            'AS-002' => ['satuan' => 'botol', 'isi' => '60 kapsul / botol', 'singkat' => 'Formula detoksifikasi alami dari 12 herbal pilihan untuk membersihkan racun dalam tubuh.', 'manfaat' => ['Membantu detoksifikasi alami', 'Mendukung fungsi hati & ginjal', 'Cocok untuk program detoks 14–30 hari']],
            'AS-003' => ['satuan' => 'botol', 'isi' => '250 ml / botol', 'singkat' => 'Madu hutan asli dari lebah liar Kalimantan, tanpa campuran dan tanpa pengawet.', 'manfaat' => ['100% madu hutan murni', 'Sumber energi & antioksidan alami', 'Tanpa gula tambahan']],
            'AS-004' => ['satuan' => 'botol', 'isi' => '50 kapsul / botol', 'singkat' => 'Kapsul sambiloto untuk menjaga daya tahan tubuh dan membantu mengatasi infeksi ringan.', 'manfaat' => ['Mendukung sistem imun', 'Membantu meredakan infeksi ringan', 'Bahan herbal alami']],
            'AS-005' => ['satuan' => 'box', 'isi' => '20 kantong / box', 'singkat' => 'Teh herbal rempah pilihan untuk relaksasi dan menjaga kesehatan pencernaan.', 'manfaat' => ['Membantu relaksasi tubuh', 'Menjaga kesehatan pencernaan', 'Aroma rempah yang menenangkan']],
            'AS-006' => ['satuan' => 'botol', 'isi' => '100 ml / botol', 'singkat' => 'Minyak zaitun dengan habbatussauda dan lavender untuk pijat relaksasi dan kesehatan kulit.', 'manfaat' => ['Melembapkan & menyehatkan kulit', 'Cocok untuk pijat relaksasi', 'Aroma lavender menenangkan']],
            'AS-007' => ['satuan' => 'pouch', 'isi' => '200 gram / pouch', 'singkat' => 'Serbuk temulawak murni untuk menjaga kesehatan hati dan meningkatkan nafsu makan.', 'manfaat' => ['Menjaga kesehatan hati', 'Meningkatkan nafsu makan', '100% temulawak murni']],
            'AS-008' => ['satuan' => 'sesi', 'isi' => '1 sesi 60 menit', 'singkat' => 'Konsultasi personal 60 menit bersama Kang Bahri plus rekomendasi herbal dan 1 produk pilihan.', 'manfaat' => ['Konsultasi personal 60 menit', 'Rekomendasi herbal sesuai kebutuhan', 'Termasuk 1 produk herbal pilihan']],
        ];

        foreach ($products as $data) {
            $data['kandungan'] = $this->kandunganHtml($data['kandungan']);
            // Harga mata uang lain (perkiraan kurs)
            $data['harga_usd'] = round($data['harga'] / 15500, 2);
            $data['harga_sar'] = round($data['harga'] / 4130, 2);
            if ($e = $extra[$data['sku']] ?? null) {
                $data['satuan']            = $e['satuan'];
                $data['isi_kemasan']       = $e['isi'];
                $data['deskripsi_singkat'] = '<p>' . e($e['singkat']) . '</p>';
                $data['manfaat']           = '<ul>' . implode('', array_map(fn ($x) => '<li>' . e($x) . '</li>', $e['manfaat'])) . '</ul>';
            }
            Product::updateOrCreate(['sku' => $data['sku']], $data);
        }

        // Produk terkait (demo) — dipetakan per SKU
        $ids = Product::pluck('id', 'sku');
        $relations = [
            'AS-001' => ['AS-002', 'AS-003', 'AS-007'],
            'AS-002' => ['AS-007', 'AS-004', 'AS-001'],
            'AS-003' => ['AS-001', 'AS-005', 'AS-006'],
            'AS-004' => ['AS-002', 'AS-007', 'AS-005'],
            'AS-005' => ['AS-001', 'AS-003', 'AS-004'],
            'AS-006' => ['AS-003', 'AS-005', 'AS-007'],
            'AS-007' => ['AS-002', 'AS-004', 'AS-001'],
            'AS-008' => ['AS-002', 'AS-001', 'AS-003'],
        ];
        foreach ($relations as $sku => $relSkus) {
            $p = Product::where('sku', $sku)->first();
            if (!$p) continue;
            $p->related_ids = array_values(array_filter(array_map(fn ($s) => $ids[$s] ?? null, $relSkus)));
            $p->save();
        }
    }

    /** Ubah daftar bahan menjadi HTML (intro + list) untuk editor WYSIWYG. */
    private function kandunganHtml(array $items): string
    {
        $items = array_values(array_filter(array_map('trim', $items)));
        if (empty($items)) return '';
        return '<p>Diformulasikan dari bahan-bahan herbal pilihan berikut:</p><ul>'
            . implode('', array_map(fn ($x) => '<li>' . e($x) . '</li>', $items))
            . '</ul>';
    }
}
