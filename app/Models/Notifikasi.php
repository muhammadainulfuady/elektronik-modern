<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table = 'notifikasis';
    protected $primaryKey = 'id_notifikasi';
    public $timestamps = false;
    protected $fillable = [
        'id_users',
        'judul',
        'pesan',
        'is_read',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_users', 'id_users');
    }
}
