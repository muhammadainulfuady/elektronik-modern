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

    /**
     * Mapping nama kategori → Flaticon class (fallback cerdas).
     */
    private const ICON_MAP = [
        'lampu'      => 'fi fi-rr-bulb',
        'kabel'      => 'fi fi-rr-pulse',
        'daya'       => 'fi fi-rr-charging-station',
        'audio'      => 'fi fi-rr-volume',
        'jaringan'   => 'fi fi-rr-wifi',
        'tv'         => 'fi fi-rr-screen',
        'ac'         => 'fi fi-rr-snowflake',
        'kulkas'     => 'fi fi-rr-box',
        'mesin cuci' => 'fi fi-rr-recycle',
        'speaker'    => 'fi fi-rr-headphones',
        'router'     => 'fi fi-rr-globe',
        'kipas'      => 'fi fi-rr-wind',
        'elektronik' => 'fi fi-rr-bolt',
        'komputer'   => 'fi fi-rr-laptop',
        'hp'         => 'fi fi-rr-smartphone',
        'kamera'     => 'fi fi-rr-camera',
        'printer'    => 'fi fi-rr-print',
        'setrika'    => 'fi fi-rr-flame',
        'blender'    => 'fi fi-rr-utensils',
    ];

    /**
     * Cek apakah ikon_kategori berupa file gambar.
     */
    public function getIsIconImageAttribute(): bool
    {
        if (!$this->ikon_kategori) {
            return false;
        }
        return \Illuminate\Support\Str::contains($this->ikon_kategori, ['.jpg', '.jpeg', '.png', '.webp', '.svg']);
    }

    /**
     * Ambil class ikon Flaticon fallback berdasarkan nama kategori.
     * Prioritas: ikon_kategori (jika bukan gambar) → mapping nama → default.
     */
    public function getIkonFallbackAttribute(): string
    {
        // Jika ikon_kategori ada dan bukan file gambar, anggap sebagai Flaticon class
        if ($this->ikon_kategori && !$this->is_icon_image) {
            return $this->ikon_kategori;
        }

        // Cari dari mapping berdasarkan nama kategori
        $namaLower = strtolower(trim($this->nama_kategori));
        foreach (self::ICON_MAP as $keyword => $icon) {
            if (str_contains($namaLower, $keyword)) {
                return $icon;
            }
        }

        return 'fi fi-rr-apps'; // default
    }

    /**
     * Render HTML ikon: gambar jika tersedia, Flaticon jika tidak.
     */
    public function ikonHtml(string $imgClass = 'w-10 h-10 object-contain', string $iconClass = ''): string
    {
        if ($this->is_icon_image) {
            return '<img src="' . asset('storage/categories/' . $this->ikon_kategori) . '" alt="' . e($this->nama_kategori) . '" class="' . $imgClass . '">';
        }

        return '<i class="' . $this->ikon_fallback . ' ' . $iconClass . '"></i>';
    }

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
