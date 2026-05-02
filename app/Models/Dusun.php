<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dusun extends Model
{
    protected $table = 'dusuns';
    protected $primaryKey = 'id_dusun';
    public $timestamps = false;
    protected $fillable = [
        'id_desa',
        'nama_dusun',
    ];

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    public function alamatUsers(): HasMany
    {
        return $this->hasMany(AlamatUser::class, 'id_dusun', 'id_dusun');
    }
}
