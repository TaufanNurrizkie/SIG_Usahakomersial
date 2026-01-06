<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Usaha extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'kategori_id',
        'kelurahan_id',
        'nama_usaha',
        'latitude',
        'longitude',
        'foto_usaha',
        'status',
        'surat_izin',
        'catatan_penolakan',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriUsaha::class, 'kategori_id');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function dokumens(): HasMany
    {
        return $this->hasMany(DokumenUsaha::class);
    }

    // Scopes
  public function scopeMenungguAdmin($q)
    {
        return $q->where('status', 'menunggu_admin');
    }

    public function scopeMenungguCamat($q)
    {
        return $q->where('status', 'menunggu_camat');
    }

    public function scopeDisetujui($q)
    {
        return $q->where('status', 'disetujui_camat');
    }

    public function scopeDitolakAdmin($q)
    {
        return $q->where('status', 'ditolak_admin');
    }

    public function scopeDitolakCamat($q)
    {
        return $q->where('status', 'ditolak_camat');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'menunggu_admin' => 'Menunggu Verifikasi',
            'menunggu_camat' => 'Menunggu Verifikasi',
            'disetujui_camat' => 'Disetujui',
            'ditolak_admin' => 'Ditolak',
            'ditolak_camat' => 'Ditolak',
            default => 'Unknown',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'menunggu_admin' => 'warning',
            'menunggu_camat' => 'warning',
            'disetujui_admin' => 'success',
            'disetujui_camat' => 'success',
            'ditolak_admin' => 'danger',
            'ditolak_camat' => 'danger',
            default => 'secondary',
        };
    }
}
