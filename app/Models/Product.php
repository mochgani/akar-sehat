<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = [
        'nama', 'slug', 'sku', 'kategori', 'harga', 'stok',
        'status', 'kandungan', 'deskripsi', 'cara_pakai',
        'foto', 'is_featured', 'urutan', 'translations',
    ];

    protected $appends = ['fotos'];

    protected function casts(): array
    {
        return [
            // kandungan kini berupa HTML (WYSIWYG), bukan array lagi
            'translations' => 'array',
            'is_featured'  => 'boolean',
            'harga'        => 'integer',
            'stok'         => 'integer',
        ];
    }

    /** Always returns an array of storage paths. Handles both old string and new JSON format. */
    public function getFotosAttribute(): array
    {
        $raw = $this->attributes['foto'] ?? null;
        if (empty($raw)) return [];
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) return array_values(array_filter($decoded));
        return [$raw]; // backward compat: old single-string path
    }

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->nama);
            }
            // auto-status berdasar stok
            if ($product->stok === 0) {
                $product->status = 'habis';
            } elseif ($product->stok <= 10) {
                $product->status = 'hampir-habis';
            } else {
                $product->status = 'tersedia';
            }
        });
    }

    public function getHargaFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    public function getFotoUrlAttribute(): string
    {
        $fotos = $this->fotos;
        return $fotos ? asset('storage/' . $fotos[0]) : '';
    }
}
