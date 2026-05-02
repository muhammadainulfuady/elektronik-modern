<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlamatUser extends Model
{
    protected $table = 'alamat_users';
    protected $primaryKey = 'id_alamat';
    public $timestamps = false;
    protected $fillable = [
        'id_users',
        'id_dusun',
        'label_alamat',
        'nomor_telepon',
        'detail_alamat',
        'is_utama',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }

    public function dusun(): BelongsTo
    {
        return $this->belongsTo(Dusun::class, 'id_dusun', 'id_dusun');
    }

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_alamat', 'id_alamat');
    }
}
