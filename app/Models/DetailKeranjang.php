<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailKeranjang extends Model
{
    protected $table = 'detail_keranjangs';
    protected $primaryKey = 'id_detail_keranjang';
    public $timestamps = false;
    protected $fillable = [
        'id_produk',
        'id_keranjang',
        'qty',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function keranjang(): BelongsTo
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id_keranjang');
    }
}
