<?php

namespace Database\Seeders;

use App\Models\Consultation;
use Illuminate\Database\Seeder;

class ConsultationSeeder extends Seeder
{
    public function run(): void
    {
        $consultations = [
            ['nama' => 'Ahmad Fauzi',    'kontak' => '081234567890', 'keluhan' => 'Sering merasa lelah dan tidak bertenaga meski sudah cukup tidur.', 'status' => 'baru',       'sumber' => 'whatsapp', 'prioritas' => 'normal', 'catatan' => ''],
            ['nama' => 'Sari Dewi',      'kontak' => '082345678901', 'keluhan' => 'Masalah pencernaan, sering kembung dan tidak nyaman setelah makan.', 'status' => 'diproses',  'sumber' => 'website',  'prioritas' => 'normal', 'catatan' => 'Sudah diarahkan konsumsi teh jahe'],
            ['nama' => 'Budi Santoso',   'kontak' => '083456789012', 'keluhan' => 'Tekanan darah tinggi, ingin coba pengobatan herbal sebagai pendamping.', 'status' => 'selesai',   'sumber' => 'referral', 'prioritas' => 'tinggi', 'catatan' => 'Diberikan rekomendasi herbal untuk hipertensi'],
            ['nama' => 'Rina Kusuma',    'kontak' => '084567890123', 'keluhan' => 'Susah tidur (insomnia) sudah 3 bulan terakhir.', 'status' => 'baru',       'sumber' => 'whatsapp', 'prioritas' => 'normal', 'catatan' => ''],
            ['nama' => 'Dono Hartono',   'kontak' => '085678901234', 'keluhan' => 'Nyeri sendi dan otot, terutama di lutut dan punggung bawah.', 'status' => 'diproses',  'sumber' => 'langsung', 'prioritas' => 'tinggi', 'catatan' => 'Sedang menjalani terapi herbal'],
            ['nama' => 'Maya Putri',     'kontak' => '086789012345', 'keluhan' => 'Ingin program detoksifikasi tubuh setelah konsumsi obat kimia jangka panjang.', 'status' => 'selesai',   'sumber' => 'website',  'prioritas' => 'normal', 'catatan' => 'Program detoks 30 hari selesai'],
            ['nama' => 'Hendra Wijaya',  'kontak' => '087890123456', 'keluhan' => 'Masalah kulit, jerawat dan kulit kusam.', 'status' => 'baru',       'sumber' => 'whatsapp', 'prioritas' => 'normal', 'catatan' => ''],
            ['nama' => 'Fitri Amalia',   'kontak' => '088901234567', 'keluhan' => 'Sering sakit kepala dan migrain.', 'status' => 'dibatalkan', 'sumber' => 'whatsapp', 'prioritas' => 'normal', 'catatan' => 'Pasien tidak bisa dihubungi kembali'],
            ['nama' => 'Rudi Permana',   'kontak' => '081112233445', 'keluhan' => 'Diabetes tipe 2, ingin pendamping herbal selain obat dokter.', 'status' => 'diproses',  'sumber' => 'referral', 'prioritas' => 'urgent', 'catatan' => 'Koordinasi dengan dokter pribadi pasien'],
            ['nama' => 'Lestari Ayu',    'kontak' => '082223344556', 'keluhan' => 'Hormon tidak seimbang, siklus menstruasi tidak teratur.', 'status' => 'baru',       'sumber' => 'website',  'prioritas' => 'normal', 'catatan' => ''],
        ];

        foreach ($consultations as $data) {
            $history = [];
            if ($data['status'] !== 'baru') {
                $history[] = ['status' => 'baru', 'catatan' => 'Konsultasi masuk', 'waktu' => now()->subDays(rand(3, 14))->format('Y-m-d H:i')];
            }
            if (in_array($data['status'], ['selesai', 'dibatalkan'])) {
                $history[] = ['status' => 'diproses', 'catatan' => 'Sedang ditangani', 'waktu' => now()->subDays(rand(1, 3))->format('Y-m-d H:i')];
                $history[] = ['status' => $data['status'], 'catatan' => $data['catatan'], 'waktu' => now()->format('Y-m-d H:i')];
            }
            $data['history'] = $history;
            Consultation::create($data);
        }
    }
}
