<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasTranslations;

    protected $fillable = [
        'nama', 'jabatan', 'foto', 'inisial', 'warna',
        'rating', 'isi', 'aktif', 'urutan', 'translations',
    ];

    protected $casts = [
        'aktif'        => 'boolean',
        'rating'       => 'decimal:1',
        'translations' => 'array',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
