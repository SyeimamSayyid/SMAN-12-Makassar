<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Galeri extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'galeri';
    
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'gambar_utama',
        'gambar_lain',
        'kategori',
        'tanggal_kegiatan',
        'lokasi',
        'is_active',
        'is_featured',
        'views',
        'urutan'
    ];

    protected $casts = [
        'gambar_lain' => 'array',
        'tanggal_kegiatan' => 'date',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Boot model untuk generate slug otomatis
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($galeri) {
            if (empty($galeri->slug)) {
                $galeri->slug = Str::slug($galeri->judul);
            }
        });
        
        static::updating(function ($galeri) {
            if ($galeri->isDirty('judul') && empty($galeri->slug)) {
                $galeri->slug = Str::slug($galeri->judul);
            }
        });
    }

    /**
     * Scope untuk galeri aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk galeri featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk filter kategori
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Accessor untuk URL gambar utama
     */
    public function getGambarUtamaUrlAttribute()
    {
        if ($this->gambar_utama) {
            return asset('storage/' . $this->gambar_utama);
        }
        return asset('images/default-galeri.jpg');
    }

    /**
     * Accessor untuk semua gambar (utama + lain)
     */
    public function getSemuaGambarAttribute()
    {
        $gambar = [];
        
        if ($this->gambar_utama) {
            $gambar[] = $this->gambar_utama;
        }
        
        if ($this->gambar_lain) {
            $gambar = array_merge($gambar, $this->gambar_lain);
        }
        
        return array_filter($gambar);
    }

    /**
     * Accessor untuk jumlah gambar
     */
    public function getJumlahGambarAttribute()
    {
        return count($this->semua_gambar);
    }

    /**
     * Accessor untuk badge warna kategori
     */
    public function getKategoriBadgeColorAttribute()
    {
        $colors = [
            'Upacara'       => 'bg-red-100 text-red-700',
            'Akademik'      => 'bg-blue-100 text-blue-700',
            'Olahraga'      => 'bg-green-100 text-green-700',
            'Seni'          => 'bg-purple-100 text-purple-700',
            'Keagamaan'     => 'bg-yellow-100 text-yellow-700',
            'Lomba'         => 'bg-orange-100 text-orange-700',
            'Study Tour'    => 'bg-cyan-100 text-cyan-700',
            'Lainnya'       => 'bg-gray-100 text-gray-700',
        ];
        
        return $colors[$this->kategori] ?? 'bg-gray-100 text-gray-700';
    }

    /**
     * Increment views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }
}