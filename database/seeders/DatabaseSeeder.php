<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriProdukSeeder::class,
            KategoriArtikelSeeder::class,
            ProductSeeder::class,
            ArticleSeeder::class,
            ConsultationSeeder::class,
            LanguageSeeder::class,
            SettingSeeder::class,
            TentangSeeder::class,
            ProductArticleI18nSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}
