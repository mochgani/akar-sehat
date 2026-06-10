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

    protected function casts(): array
    {
        return [
            'kandungan'    => 'array',
            'translations' => 'array',
            'is_featured'  => 'boolean',
            'harga'        => 'integer',
            'stok'         => 'integer',
        ];
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
        if ($this->foto && file_exists(public_path('asset/produk/' . $this->foto))) {
            return asset('asset/produk/' . $this->foto);
        }
        return asset('asset/produk/placeholder.png');
    }
}
