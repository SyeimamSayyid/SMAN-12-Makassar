<?php
// app/Models/Berita.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $table = 'beritas';

    protected $fillable = [
        'judul',
        'tanggal',
        'isi',
        'author',
        'images'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'images' => 'array' // Ini akan mengkonversi JSON ke array otomatis
    ];

    // Accessor untuk foto pertama (thumbnail) - DIPERBAIKI
    public function getThumbnailAttribute()
    {
        $images = $this->images;
        
        // Cek apakah images adalah array dan tidak kosong
        if (is_array($images) && !empty($images)) {
            return $images[0];
        }
        
        // Cek apakah images adalah string JSON
        if (is_string($images) && !empty($images)) {
            $decoded = json_decode($images, true);
            if (is_array($decoded) && !empty($decoded)) {
                return $decoded[0];
            }
        }
        
        // Jika tidak ada gambar, return null
        return null;
    }

    // Accessor untuk semua gambar - DIPERBAIKI
    public function getAllImagesAttribute()
    {
        $images = $this->images;
        
        // Jika sudah array
        if (is_array($images)) {
            return $images;
        }
        
        // Jika string JSON
        if (is_string($images) && !empty($images)) {
            $decoded = json_decode($images, true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }
        
        // Jika tidak ada gambar, return array kosong
        return [];
    }

    // Accessor untuk jumlah foto - DIPERBAIKI
    public function getJumlahFotoAttribute()
    {
        $images = $this->images;
        
        // Jika sudah array
        if (is_array($images)) {
            return count($images);
        }
        
        // Jika string JSON
        if (is_string($images) && !empty($images)) {
            $decoded = json_decode($images, true);
            if (is_array($decoded)) {
                return count($decoded);
            }
        }
        
        // Jika tidak ada gambar
        return 0;
    }

    // Accessor untuk mengecek apakah images valid - METHOD BARU
    public function getHasImagesAttribute()
    {
        return $this->jumlah_foto > 0;
    }

    // Accessor untuk mendapatkan gambar pertama dengan format yang aman - METHOD BARU
    public function getFirstImageAttribute()
    {
        $images = $this->getAllImagesAttribute();
        return !empty($images) ? $images[0] : null;
    }

    // Scope untuk berita terbaru
    public function scopeTerbaru($query)
    {
        return $query->orderBy('tanggal', 'desc');
    }

    // Scope untuk berita yang memiliki gambar - METHOD BARU
    public function scopeMemilikiGambar($query)
    {
        return $query->whereNotNull('images')
                     ->where('images', '!=', '')
                     ->where('images', '!=', '[]')
                     ->where('images', '!=', 'null');
    }
}