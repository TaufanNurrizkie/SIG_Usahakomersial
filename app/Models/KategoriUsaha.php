<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriUsaha extends Model
{
    protected $fillable = ['nama_kategori', 'deskripsi'];

    public function usahas(): HasMany
    {
        return $this->hasMany(Usaha::class, 'kategori_id');
    }
}
