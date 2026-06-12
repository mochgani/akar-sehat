<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';

    protected $fillable = ['nama', 'slug', 'urutan', 'aktif'];

    protected $casts = ['aktif' => 'boolean'];

    public function products()
    {
        return $this->hasMany(Product::class, 'kategori', 'nama');
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    protected static function booted(): void
    {
        static::saving(function ($kat) {
            if (empty($kat->slug)) {
                $kat->slug = Str::slug($kat->nama);
            }
        });
    }
}
