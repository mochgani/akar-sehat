<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * kandungan berubah dari array (JSON) menjadi HTML (WYSIWYG).
 * Migrasi ini mengonversi data lama: array bahan -> <ul><li>..</li></ul>,
 * baik di kolom dasar maupun di setiap locale pada kolom translations.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Ubah tipe kolom dari json -> longText agar bisa menyimpan HTML
        if (Schema::hasColumn('products', 'kandungan')) {
            Schema::table('products', function (Blueprint $table) {
                $table->longText('kandungan')->nullable()->change();
            });
        }

        $toHtml = function ($val) {
            // Sudah HTML / string biasa -> biarkan
            if (is_string($val)) {
                $trim = trim($val);
                if ($trim === '') return $trim;
                if (str_contains($trim, '<')) return $trim; // sudah ada markup
                $decoded = json_decode($trim, true);
                if (is_array($decoded)) $val = $decoded;
                else return '<p>' . e($trim) . '</p>';
            }
            if (is_array($val)) {
                $items = array_filter(array_map(fn ($x) => is_string($x) ? trim($x) : '', $val));
                if (empty($items)) return '';
                return '<ul>' . implode('', array_map(fn ($x) => '<li>' . e($x) . '</li>', $items)) . '</ul>';
            }
            return '';
        };

        foreach (DB::table('products')->get() as $p) {
            $newKandungan = $toHtml($p->kandungan);

            $trans = json_decode($p->translations ?? '', true);
            if (is_array($trans)) {
                foreach ($trans as $loc => &$fields) {
                    if (isset($fields['kandungan'])) {
                        $fields['kandungan'] = $toHtml($fields['kandungan']);
                    }
                }
                unset($fields);
            }

            DB::table('products')->where('id', $p->id)->update([
                'kandungan'    => $newKandungan,
                'translations' => is_array($trans) ? json_encode($trans, JSON_UNESCAPED_UNICODE) : $p->translations,
            ]);
        }
    }

    public function down(): void
    {
        // Tidak dapat dikembalikan ke array secara akurat; biarkan.
    }
};
