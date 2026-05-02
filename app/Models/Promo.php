<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promo extends Model
{
    protected $table = 'promos';
    protected $primaryKey = 'id_promo';
    public $timestamps = false;
    protected $fillable = [
        'kode_voucher',
        'tipe_diskon',
        'nilai_diskon',
        'kuota',
        'tanggal_mulai',
        'tanggal_berakhir',
    ];

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_promo', 'id_promo');
    }
}
