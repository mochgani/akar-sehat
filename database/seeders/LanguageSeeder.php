<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            [
                'code'        => 'id',
                'name'        => 'Indonesia',
                'native_name' => 'Indonesia',
                'dir'         => 'ltr',
                'flag'        => '🇮🇩',
                'aktif'       => true,
                'is_default'  => true,
                'urutan'      => 1,
            ],
            [
                'code'        => 'en',
                'name'        => 'English',
                'native_name' => 'English',
                'dir'         => 'ltr',
                'flag'        => '🇬🇧',
                'aktif'       => true,
                'is_default'  => false,
                'urutan'      => 2,
            ],
            [
                'code'        => 'ar',
                'name'        => 'Arab',
                'native_name' => 'العربية',
                'dir'         => 'rtl',
                'flag'        => '🇸🇦',
                'aktif'       => true,
                'is_default'  => false,
                'urutan'      => 3,
            ],
        ];

        foreach ($languages as $lang) {
            Language::updateOrCreate(['code' => $lang['code']], $lang);
        }
    }
}
