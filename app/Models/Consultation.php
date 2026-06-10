<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'nama', 'kontak', 'keluhan', 'status',
        'sumber', 'prioritas', 'catatan', 'history',
    ];

    protected function casts(): array
    {
        return [
            'history' => 'array',
        ];
    }

    public function addHistory(string $statusBaru, string $catatan = ''): void
    {
        $history = $this->history ?? [];
        $history[] = [
            'status'  => $statusBaru,
            'catatan' => $catatan,
            'waktu'   => now()->format('Y-m-d H:i'),
        ];
        $this->history = $history;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'baru'       => '#3b82f6',
            'diproses'   => '#f59e0b',
            'selesai'    => '#22c55e',
            'dibatalkan' => '#ef4444',
            default      => '#7A6355',
        };
    }

    public function getPrioritasColorAttribute(): string
    {
        return match ($this->prioritas) {
            'urgent' => '#ef4444',
            'tinggi' => '#f59e0b',
            default  => '#7A6355',
        };
    }
}
