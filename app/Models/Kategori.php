<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;
    protected $fillable = [
        'nama_kategori',
        'ikon_kategori',
    ];

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Use nama_kategori (lowercase with underscores) instead of id_kategori for routing.
     */
    public function getRouteKey()
    {
        return str_replace(' ', '_', strtolower($this->nama_kategori));
    }

    /**
     * Resolve model binding using id_kategori or nama_kategori.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $nameForQuery = str_replace('_', ' ', $value);

        return $this->where('id_kategori', $value)
            ->orWhere('nama_kategori', 'like', $nameForQuery)
            ->firstOrFail();
    }
}
