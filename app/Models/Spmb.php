<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Spmb extends Model
{
    use HasFactory;

    protected $table = 'spmb';
    
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'link_pendaftaran',  // ✅ Tambah
        'foto',
        'video',
        'galeri',
        'tanggal_upload',
        'tanggal_berakhir',
        'is_active',
        'views',
        'created_by',
    ];

    protected $casts = [
        'galeri' => 'array',
        'video' => 'array',  // ✅ Array of objects: [{type, url, caption}]
        'tanggal_upload' => 'date',
        'tanggal_berakhir' => 'date',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($spmb) {
            if (empty($spmb->slug)) {
                $spmb->slug = Str::slug($spmb->judul);
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeAktif($query)
    {
        return $query->where('is_active', true)
                     ->whereDate('tanggal_berakhir', '>=', now());
    }

    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('images/default-spmb.jpg');
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return ['bg-gray-100 text-gray-700', '⏸️ Nonaktif'];
        }
        
        if ($this->tanggal_berakhir < now()) {
            return ['bg-red-100 text-red-700', '⏰ Expired'];
        }
        
        return ['bg-green-100 text-green-700', '✅ Aktif'];
    }
    
    public function getJumlahFotoAttribute()
    {
        return count($this->galeri ?? []);
    }
    
    public function getJumlahVideoAttribute()
    {
        return count($this->video ?? []);
    }
    
    // ✅ Helper untuk generate YouTube embed URL
    public static function parseYoutubeUrl($url)
    {
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i';
        if (preg_match($pattern, $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return $url;
    }
}