<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certification extends Model
{
    use HasTranslations;

    protected $fillable = ['judul', 'gambar', 'urutan', 'aktif', 'translations'];

    protected $casts = ['aktif' => 'boolean', 'translations' => 'array'];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /** URL gambar — dukung path upload (storage) maupun aset bawaan (asset/). */
    public function getGambarUrlAttribute(): string
    {
        if (empty($this->gambar)) return '';
        return Str::startsWith($this->gambar, 'asset/')
            ? asset($this->gambar)
            : asset('storage/' . $this->gambar);
    }
}
