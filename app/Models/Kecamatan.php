<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kecamatan extends Model
{
    protected $table = 'kecamatans';
    protected $primaryKey = 'id_kecamatan';
    public $timestamps = false;
    protected $fillable = [
        'id_kota',
        'nama_kecamatan',
    ];

    public function kota(): BelongsTo
    {
        return $this->belongsTo(Kota::class, 'id_kota', 'id_kota');
    }

    public function desas(): HasMany
    {
        return $this->hasMany(Desa::class, 'id_kecamatan', 'id_kecamatan');
    }
}
