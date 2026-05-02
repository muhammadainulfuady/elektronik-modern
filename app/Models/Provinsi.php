<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provinsi extends Model
{
    protected $table = 'provinsis';
    protected $primaryKey = 'id_provinsi';
    public $timestamps = false;
    protected $fillable = [
        'nama_provinsi',
    ];

    public function kotas(): HasMany
    {
        return $this->hasMany(Kota::class, 'id_provinsi', 'id_provinsi');
    }
}
