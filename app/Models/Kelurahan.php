<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelurahan extends Model
{
    protected $fillable = ['nama_kelurahan'];

    public function usahas(): HasMany
    {
        return $this->hasMany(Usaha::class);
    }
}
