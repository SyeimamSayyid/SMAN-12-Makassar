<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fasilitas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fasilitas';
    
    protected $fillable = [
        'nama', 
        'ikon', 
        'gambar', 
        'deskripsi', 
        'info_tambahan', 
        'jumlah', 
        'kategori', 
        'is_active', 
        'urutan'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk fasilitas aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mengurutkan fasilitas
     */
    public function scopeUrut($query)
    {
        return $query->orderBy('urutan')->orderBy('id');
    }

    /**
     * Accessor untuk URL gambar
     */
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/' . $this->gambar);
        }
        return asset('images/default-fasilitas.jpg');
    }

    /**
     * Accessor untuk label kategori
     */
    public function getKategoriLabelAttribute()
    {
        $labels = [
            'ruang_kelas'   => 'Ruang Kelas',
            'laboratorium'  => 'Laboratorium',
            'perpustakaan'  => 'Perpustakaan',
            'olahraga'      => 'Olahraga',
            'aula'          => 'Aula',
            'kantin'        => 'Kantin',
            'lainnya'       => 'Lainnya',
        ];
        
        return $labels[$this->kategori] ?? ucfirst(str_replace('_', ' ', $this->kategori));
    }

    /**
     * Accessor untuk badge warna kategori
     */
    public function getKategoriBadgeColorAttribute()
    {
        $colors = [
            'ruang_kelas'   => 'bg-blue-100 text-blue-700',
            'laboratorium'  => 'bg-green-100 text-green-700',
            'perpustakaan'  => 'bg-yellow-100 text-yellow-700',
            'olahraga'      => 'bg-orange-100 text-orange-700',
            'aula'          => 'bg-purple-100 text-purple-700',
            'kantin'        => 'bg-red-100 text-red-700',
            'lainnya'       => 'bg-gray-100 text-gray-700',
        ];
        
        return $colors[$this->kategori] ?? 'bg-gray-100 text-gray-700';
    }
}