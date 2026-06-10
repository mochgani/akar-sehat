<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'         => 'Kang Bahri',
                'username'     => 'kangbahri',
                'email'        => 'bahri@akarsehat.id',
                'password'     => Hash::make('akarsehat123'),
                'wa'           => '081234567890',
                'bio'          => 'Konsultan herbal tradisional dengan pengalaman 15 tahun.',
                'role'         => 'administrator',
                'status'       => 'aktif',
                'avatar_color' => '#C86A44',
                'login_count'  => 412,
            ],
            [
                'name'         => 'Siti Rahayu',
                'username'     => 'sitirahayu',
                'email'        => 'siti@akarsehat.id',
                'password'     => Hash::make('password123'),
                'wa'           => '082345678901',
                'bio'          => 'Editor konten dan artikel kesehatan herbal.',
                'role'         => 'editor',
                'status'       => 'aktif',
                'avatar_color' => '#3b82f6',
                'login_count'  => 87,
            ],
            [
                'name'         => 'Ahmad Ridwan',
                'username'     => 'ahmadridwan',
                'email'        => 'ridwan@akarsehat.id',
                'password'     => Hash::make('password123'),
                'wa'           => '083456789012',
                'bio'          => 'Penulis artikel edukasi herbal.',
                'role'         => 'penulis',
                'status'       => 'aktif',
                'avatar_color' => '#8b5cf6',
                'login_count'  => 34,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(['email' => $data['email']], $data);
        }
    }
}
