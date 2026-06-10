<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $articles = [
            [
                'judul'      => 'Manfaat Jahe Merah untuk Daya Tahan Tubuh',
                'slug'       => 'manfaat-jahe-merah-untuk-daya-tahan-tubuh',
                'status'     => 'terbit',
                'kategori'   => 'Tanaman Herbal',
                'penulis'    => 'Kang Bahri',
                'thumbnail'  => 'detox-alami-tubuh.png',
                'keywords'   => ['jahe merah', 'imunitas', 'herbal'],
                'meta_title' => 'Manfaat Jahe Merah untuk Daya Tahan Tubuh | Akar Sehat',
                'meta_desc'  => 'Pelajari manfaat jahe merah untuk meningkatkan imunitas tubuh secara alami berdasarkan penelitian dan tradisi.',
                'read_time'  => 5,
                'views'      => 1240,
                'published_at' => '2026-06-01 08:00:00',
                'konten'     => '<p>Jahe merah (<em>Zingiber officinale var. rubrum</em>) telah lama digunakan dalam pengobatan tradisional Indonesia sebagai salah satu tanaman herbal paling bermanfaat.</p><h2>Kandungan Aktif Jahe Merah</h2><p>Jahe merah mengandung gingerol dan shogaol dalam konsentrasi lebih tinggi dibanding jahe biasa. Kedua senyawa ini memiliki sifat antiinflamasi dan antioksidan yang kuat.</p><h2>Manfaat untuk Imunitas</h2><p>Konsumsi rutin jahe merah dapat membantu meningkatkan produksi sel imun, mengurangi peradangan kronis, dan melindungi tubuh dari infeksi virus maupun bakteri.</p><p>Penelitian menunjukkan bahwa ekstrak jahe merah dapat menghambat pertumbuhan beberapa jenis bakteri patogen secara in vitro.</p><h2>Cara Konsumsi yang Tepat</h2><p>Untuk mendapatkan manfaat optimal, konsumsi jahe merah sebaiknya dilakukan secara rutin setiap hari. Bisa dalam bentuk minuman hangat, kapsul, atau ditambahkan ke masakan.</p>',
            ],
            [
                'judul'      => 'Detoksifikasi Alami: Membersihkan Tubuh dengan Herbal',
                'slug'       => 'detoksifikasi-alami-membersihkan-tubuh-dengan-herbal',
                'status'     => 'terbit',
                'kategori'   => 'Kesehatan',
                'penulis'    => 'Kang Bahri',
                'thumbnail'  => 'detox-alami-tubuh.png',
                'keywords'   => ['detox', 'detoksifikasi', 'temulawak', 'kunyit'],
                'meta_title' => 'Detoksifikasi Alami dengan Herbal | Akar Sehat',
                'meta_desc'  => 'Cara membersihkan racun tubuh secara alami menggunakan tanaman herbal tradisional yang terbukti efektif.',
                'read_time'  => 7,
                'views'      => 980,
                'published_at' => '2026-05-28 10:00:00',
                'konten'     => '<p>Detoksifikasi adalah proses pembersihan racun yang menumpuk di dalam tubuh akibat pola makan tidak sehat, polusi, dan stres.</p><h2>Tanaman Herbal untuk Detoks</h2><p>Beberapa tanaman herbal terbukti memiliki kemampuan detoksifikasi yang baik:</p><ul><li><strong>Temulawak</strong> — melindungi liver dari kerusakan akibat racun</li><li><strong>Kunyit</strong> — antiinflamasi dan mendukung fungsi hati</li><li><strong>Sambiloto</strong> — membantu sistem kekebalan dan detoks</li><li><strong>Meniran</strong> — mendukung fungsi ginjal</li></ul><h2>Program Detoks 7 Hari</h2><p>Program detoks herbal sederhana yang bisa dilakukan di rumah dengan bahan-bahan yang mudah didapat di pasar tradisional.</p>',
            ],
            [
                'judul'      => 'Menjaga Kesehatan Pencernaan dengan Rempah Tradisional',
                'slug'       => 'menjaga-kesehatan-pencernaan-dengan-rempah-tradisional',
                'status'     => 'terbit',
                'kategori'   => 'Pencernaan',
                'penulis'    => 'Ahmad Ridwan',
                'thumbnail'  => 'pencernaan-sehat.png',
                'keywords'   => ['pencernaan', 'rempah', 'kunyit', 'temulawak'],
                'meta_title' => 'Kesehatan Pencernaan dengan Rempah | Akar Sehat',
                'meta_desc'  => 'Tips menjaga kesehatan pencernaan menggunakan rempah-rempah tradisional Indonesia.',
                'read_time'  => 6,
                'views'      => 756,
                'published_at' => '2026-05-20 09:00:00',
                'konten'     => '<p>Sistem pencernaan yang sehat adalah fondasi dari kesehatan tubuh secara keseluruhan. Rempah-rempah tradisional Indonesia menyimpan segudang manfaat untuk menjaga kesehatan pencernaan.</p><h2>Rempah Sahabat Pencernaan</h2><p>Jahe, kunyit, kayu manis, dan kapulaga adalah beberapa rempah yang secara tradisional digunakan untuk mengatasi masalah pencernaan seperti kembung, mual, dan perut tidak nyaman.</p>',
            ],
            [
                'judul'      => 'Antioksidan dari Alam: Melawan Radikal Bebas',
                'slug'       => 'antioksidan-dari-alam-melawan-radikal-bebas',
                'status'     => 'terbit',
                'kategori'   => 'Nutrisi',
                'penulis'    => 'Siti Rahayu',
                'thumbnail'  => 'nutrisi-antioksidan.png',
                'keywords'   => ['antioksidan', 'radikal bebas', 'herbal'],
                'meta_title' => 'Antioksidan Alami dari Herbal | Akar Sehat',
                'meta_desc'  => 'Sumber antioksidan terbaik dari tanaman herbal untuk melindungi sel tubuh dari kerusakan radikal bebas.',
                'read_time'  => 5,
                'views'      => 623,
                'published_at' => '2026-05-15 11:00:00',
                'konten'     => '<p>Radikal bebas adalah molekul tidak stabil yang dapat merusak sel-sel tubuh dan berkontribusi pada penuaan dini serta berbagai penyakit degeneratif.</p><h2>Sumber Antioksidan Herbal</h2><p>Alam Indonesia menyediakan banyak sumber antioksidan alami yang mudah diakses, mulai dari rempah dapur hingga tanaman liar yang tumbuh di sekitar kita.</p>',
            ],
            [
                'judul'      => 'Panduan Memilih Suplemen Herbal yang Tepat',
                'slug'       => 'panduan-memilih-suplemen-herbal-yang-tepat',
                'status'     => 'draft',
                'kategori'   => 'Panduan',
                'penulis'    => 'Ahmad Ridwan',
                'thumbnail'  => null,
                'keywords'   => ['suplemen', 'herbal', 'panduan'],
                'meta_title' => 'Panduan Memilih Suplemen Herbal | Akar Sehat',
                'meta_desc'  => 'Tips memilih suplemen herbal yang aman, berkualitas, dan sesuai kebutuhan kesehatan Anda.',
                'read_time'  => 8,
                'views'      => 0,
                'published_at' => null,
                'konten'     => '<p>Artikel dalam tahap penulisan.</p>',
            ],
        ];

        foreach ($articles as $data) {
            Article::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
