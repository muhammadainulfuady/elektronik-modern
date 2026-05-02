<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Desa extends Model
{
    protected $table = 'desas';
    protected $primaryKey = 'id_desa';
    public $timestamps = false;
    protected $fillable = [
        'id_kecamatan',
        'nama_desa',
    ];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function dusuns(): HasMany
    {
        return $this->hasMany(Dusun::class, 'id_desa', 'id_desa');
    }
}
