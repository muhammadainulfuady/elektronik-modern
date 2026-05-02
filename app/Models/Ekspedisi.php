<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ekspedisi extends Model
{
    protected $table = 'ekspedisis';
    protected $primaryKey = 'id_ekspedisi';
    public $timestamps = false;
    protected $fillable = [
        'nama_ekspedisi',
        'biaya_pengiriman',
    ];

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_ekspedisi', 'id_ekspedisi');
    }
}
