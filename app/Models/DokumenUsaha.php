<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DokumenUsaha extends Model
{
    protected $fillable = [
        'usaha_id',
        'jenis_dokumen',
        'file_path',
    ];

    public function usaha(): BelongsTo
    {
        return $this->belongsTo(Usaha::class);
    }

    public function getJenisLabelAttribute(): string
    {
        return match($this->jenis_dokumen) {
            'KTP' => 'KTP',
            'foto_lokasi' => 'Foto Lokasi',
            'lainnya' => 'Dokumen Lainnya',
            default => $this->jenis_dokumen,
        };
    }
}
