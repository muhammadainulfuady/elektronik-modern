<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\AlamatUser;
use App\Models\Keranjang;
use App\Models\Notifikasi;
use App\Models\Pesanan;
use App\Models\Ulasan;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['nama', 'email', 'password', 'role'])]
#[Hidden(['password'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_users';

    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function alamatUsers(): HasMany
    {
        return $this->hasMany(AlamatUser::class, 'id_users', 'id_users');
    }

    public function keranjang(): HasOne
    {
        return $this->hasOne(Keranjang::class, 'id_users', 'id_users');
    }

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'id_users', 'id_users');
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class, 'id_users', 'id_users');
    }

    public function ulasans(): HasMany
    {
        return $this->hasMany(Ulasan::class, 'id_users', 'id_users');
    }

    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'id_users', 'id_users');
    }
}
