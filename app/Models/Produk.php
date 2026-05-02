<?php

namespace App\Models;

use App\Models\DetailKeranjang;
use App\Models\DetailPesanan;
use App\Models\Kategori;
use App\Models\Ulasan;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    protected $table = 'produks';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;
    protected $fillable = [
        'id_kategori',
        'gambar',
        'nama_produk',
        'deskripsi',
        'harga',
        'stok',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function detailKeranjangs(): HasMany
    {
        return $this->hasMany(DetailKeranjang::class, 'id_produk', 'id_produk');
    }

    public function detailPesanans(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_produk', 'id_produk');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'id_produk', 'id_produk');
    }

    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_produk', 'id_produk');
    }
}
