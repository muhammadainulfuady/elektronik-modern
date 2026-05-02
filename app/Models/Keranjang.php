<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keranjang extends Model
{
    protected $table = 'keranjangs';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = false;
    protected $fillable = [
        'id_users',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function detailKeranjangs(): HasMany
    {
        return $this->hasMany(DetailKeranjang::class, 'id_keranjang', 'id_keranjang');
    }
}
