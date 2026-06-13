<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriArtikel extends Model
{
    use HasTranslations;

    protected $table = 'kategori_artikel';

    protected $fillable = ['nama', 'slug', 'urutan', 'aktif', 'translations'];

    protected $casts = ['aktif' => 'boolean', 'translations' => 'array'];

    public function articles()
    {
        return $this->hasMany(Article::class, 'kategori', 'nama');
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
