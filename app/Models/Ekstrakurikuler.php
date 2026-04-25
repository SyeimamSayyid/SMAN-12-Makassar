<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $table = 'ekstrakurikulers';
    
    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'pembina',
        'jadwal',
        'tempat',
        'jumlah_anggota',
        'prestasi',
        'logo',
        'background',
        'bg_type',
        'bg_color1',
        'bg_color2',
        'bg_direction',
        'bg_opacity',
        'galeri',
        'berita_terkait',
        'is_active',
    ];

    protected $casts = [
        'prestasi' => 'array',
        'galeri' => 'array',
        'berita_terkait' => 'array',
        'is_active' => 'boolean',
        'jumlah_anggota' => 'integer',
        'bg_opacity' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($eskul) {
            if (empty($eskul->slug)) {
                $eskul->slug = Str::slug($eskul->nama);
            }
        });
        
        static::updating(function ($eskul) {
            if ($eskul->isDirty('nama') && empty($eskul->slug)) {
                $eskul->slug = Str::slug($eskul->nama);
            }
        });
    }

    /**
     * Scope untuk yang aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor untuk logo URL.
     */
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return null;
        }
        if (str_starts_with($this->logo, 'data:')) {
            return $this->logo;
        }
        if (str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }
        return asset('storage/' . $this->logo);
    }

    /**
     * Accessor untuk background URL.
     */
    public function getBackgroundUrlAttribute()
    {
        if (!$this->background) {
            return null;
        }
        if (str_starts_with($this->background, 'data:')) {
            return $this->background;
        }
        if (str_starts_with($this->background, 'http')) {
            return $this->background;
        }
        return asset('storage/' . $this->background);
    }

    /**
     * Accessor untuk background style (CSS gradient).
     */
    public function getBackgroundStyleAttribute()
    {
        // Jika upload gambar, return null (ditangani dengan <img>)
        if ($this->bg_type === 'upload' && $this->background) {
            return null;
        }
        
        // Jika gradient, generate CSS
        if ($this->bg_type === 'gradient' && $this->bg_color1 && $this->bg_color2) {
            $color2 = $this->bg_color2;
            $r = intval(substr($color2, 1, 2), 16);
            $g = intval(substr($color2, 3, 2), 16);
            $b = intval(substr($color2, 5, 2), 16);
            
            $opacityValue = $this->bg_opacity;
            if ($opacityValue === null) {
                $opacityValue = 50;
            }
            $opacity = $opacityValue / 100;
            $rgba = "rgba({$r}, {$g}, {$b}, {$opacity})";
            
            $direction = $this->bg_direction;
            if ($direction === null) {
                $direction = 'to right';
            }
            
            return "background: linear-gradient({$direction}, {$this->bg_color1}, {$rgba});";
        }
        
        return null;
    }

    /**
     * Accessor untuk galeri URLs.
     */
    public function getGaleriUrlsAttribute()
    {
        $galeri = $this->galeri;
        if ($galeri === null) {
            $galeri = [];
        }
        
        $result = [];
        foreach ($galeri as $img) {
            if ($img === null) {
                continue;
            }
            if (str_starts_with($img, 'data:')) {
                $result[] = $img;
            } elseif (str_starts_with($img, 'http')) {
                $result[] = $img;
            } else {
                $result[] = asset('storage/' . $img);
            }
        }
        
        return $result;
    }

    /**
     * Accessor untuk status badge.
     */
    public function getStatusBadgeAttribute()
    {
        if (!$this->is_active) {
            return ['bg-gray-100 text-gray-700', 'Nonaktif'];
        }
        return ['bg-green-100 text-green-700', 'Aktif'];
    }
}