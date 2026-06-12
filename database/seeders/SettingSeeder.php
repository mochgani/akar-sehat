<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // Identitas Website
            'site.name'        => 'Akar Sehat',
            'site.tagline'     => 'Herbal Tradisional Terpercaya',
            'site.wa_number'   => '6281234567890',
            'site.wa_number_2' => '',
            'site.email'       => 'info@akarsehat.id',
            'site.instagram'   => '@akarsehat.id',
            'site.logo'        => '',
            'site.favicon'     => '',
            // Footer
            'site.address'     => 'Bandung, Jawa Barat',
            'site.footer_desc' => 'Platform edukasi dan pendampingan kesehatan modern yang membantu masyarakat memahami tubuh dari akar masalahnya secara natural.',
            'site.copyright'   => '© 2026 Akar Sehat. All rights reserved.',
            'site.fb_url'      => '',
            'site.ig_url'      => '',
            'site.yt_url'      => '',
            'site.tiktok_url'  => '',

            // Under Construction
            'uc.mode'           => 'off',
            'uc.launch_date'    => '2026-09-01T00:00:00',
            'uc.progress'       => '75',
            'uc.title_line1'    => 'Website Kami',
            'uc.title_line2'    => 'Segera Hadir!',
            'uc.description'    => 'Kami sedang menyiapkan sesuatu yang lebih baik untuk Anda. Website Akar Sehat sedang dalam proses pengembangan.',
            'uc.show_countdown' => '1',
            'uc.show_progress'  => '1',
            'uc.show_subscribe' => '1',

            // Hero Homepage
            'homepage.hero_badge'    => 'Herbal Tradisional Terpercaya',
            'homepage.hero_title1'   => 'Pahami Tubuh.',
            'homepage.hero_title2'   => 'Sehat dari Akar.',
            'homepage.hero_desc'     => 'Akar Sehat menyediakan edukasi dan pendampingan kesehatan untuk membantu Anda memahami penyakit secara menyeluruh sampai ke akarnya.',
            'homepage.hero_btn_text' => 'Selengkapnya',
            'homepage.hero_image'    => '',

            // Stats strip
            'homepage.stats' => json_encode([
                ['icon' => '👥', 'nilai' => '2.500+', 'label' => 'Pengguna Puas'],
                ['icon' => '🌿', 'nilai' => '15+',    'label' => 'Tahun Pengalaman'],
                ['icon' => '📦', 'nilai' => '50+',    'label' => 'Produk Herbal'],
                ['icon' => '💬', 'nilai' => 'Gratis', 'label' => 'Konsultasi Pertama'],
            ], JSON_UNESCAPED_UNICODE),

            // Mentor section
            'homepage.mentor_image' => '',
            'homepage.mentor_tag'   => 'Dibimbing Oleh',
            'homepage.mentor_nama'  => 'Kang Bahri',
            'homepage.mentor_bio'   => 'Kang Bahri membantu masyarakat memahami tubuh melalui edukasi, konsultasi, dan panduan kesehatan alami yang mudah diterapkan dalam kehidupan sehari-hari secara fleksibel dan bertahap.',
            'homepage.mentor_btn'   => 'Kenali Kang Bahri →',
            'homepage.mentor_stats' => json_encode([
                ['nilai' => '20+',       'label' => 'Tahun Pengalaman'],
                ['nilai' => 'Ratusan+',  'label' => 'Orang Terbantu'],
                ['nilai' => 'Sertifikasi','label'=> 'Terapis Kesehatan'],
            ], JSON_UNESCAPED_UNICODE),

            // Mid CTA
            'homepage.cta_title' => 'Mulai pahami tubuh Anda dari akarnya.',
            'homepage.cta_desc'  => 'Langkah kecil hari ini untuk kesehatan yang jauh lebih baik di masa depan.',
            'homepage.cta_btn'   => 'Selengkapnya →',

            // Konsultasi CTA
            'homepage.konsul_title' => 'Butuh Arahan yang Lebih Personal?',
            'homepage.konsul_desc'  => 'Konsultasi manual bersama Kang Bahri untuk memahami kondisi fungsional tubuh Anda secara spesifik dan menentukan langkah pemulihan alami yang paling tepat.',
            'homepage.konsul_btn'   => 'Konsultasi via WhatsApp',

            // Halaman Tentang — Hero
            'tentang.hero_badge'  => 'Mengenal Akar Sehat',
            'tentang.hero_title'  => 'Kesehatan yang Dimulai dari Akar Permasalahannya',
            'tentang.hero_desc'   => 'Kami bukan sekadar platform suplemen herbal. Akar Sehat adalah gerakan untuk mengembalikan masyarakat pada pemahaman bahwa tubuh memiliki kecerdasan alaminya sendiri — dan tugas kita adalah mendukungnya, bukan melawannya.',

            // Halaman Tentang — Profil
            'tentang.profil_foto'  => '',
            'tentang.profil_nama'  => 'Bahri, S.Kes.',
            'tentang.profil_gelar' => 'Terapis Herbal · Konsultan Kesehatan Holistik · Pendiri Akar Sehat',
            'tentang.profil_bio'   => "Kang Bahri adalah seorang terapis herbal dan konsultan kesehatan holistik yang telah mengabdikan lebih dari satu setengah dekade hidupnya untuk mempelajari, mempraktikkan, dan menyebarluaskan pengetahuan tentang pengobatan herbal Nusantara dan pendekatan kesehatan integratif.\n\nLahir dan besar di lingkungan yang akrab dengan tanaman obat, Kang Bahri mewarisi kecintaan pada herbal dari sang nenek yang dikenal sebagai dukun beranak di desanya. Keingintahuan masa kecil ini kemudian tumbuh menjadi dedikasi seumur hidup.\n\nKang Bahri menempuh pendidikan formal di bidang kesehatan sambil terus belajar dari berbagai guru dan maestro pengobatan tradisional di Jawa, Sumatera, hingga Kalimantan.\n\nHari ini, Kang Bahri melayani konsultasi kesehatan secara personal dan mendirikan Akar Sehat sebagai platform untuk menjangkau lebih banyak masyarakat.",

            // Halaman Tentang — Visi Misi
            'tentang.visi' => 'Menjadi platform edukasi dan pendampingan kesehatan herbal terpercaya yang mengembalikan masyarakat Indonesia pada kearifan alami untuk hidup sehat, seimbang, dan berdaya dari dalam.',
            'tentang.misi' => "Memberikan edukasi kesehatan holistik yang akurat, mudah dipahami, dan dapat langsung dipraktikkan oleh masyarakat luas.\nMembantu setiap individu menemukan akar masalah kesehatannya melalui pendampingan personal yang empatik dan terstruktur.\nMenyediakan produk herbal berkualitas tinggi yang bahan bakunya dapat ditelusuri, formulasinya terbukti, dan dampaknya nyata.\nMembangun komunitas yang saling mendukung dalam perjalanan menuju kesehatan optimal berbasis alam dan gaya hidup seimbang.",
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key, 'locale' => 'id'], ['value' => $value]);
        }
    }
}
