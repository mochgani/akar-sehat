<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductSeeder::class,
            ArticleSeeder::class,
            ConsultationSeeder::class,
            LanguageSeeder::class,
            SettingSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}
