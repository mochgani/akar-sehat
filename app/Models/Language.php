<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['code','name','native_name','dir','flag','aktif','is_default','urutan'];
    protected $casts    = ['aktif' => 'boolean', 'is_default' => 'boolean'];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
