<?php
// app/Models/StatistikSekolah.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatistikSekolah extends Model
{
    use HasFactory;

    protected $table = 'statistik_sekolah';
    
    protected $fillable = [
        'kategori', 'jumlah_siswa', 'laki_laki', 'perempuan', 
        'jumlah_rombel', 'tahun_ajaran', 'semester', 'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeKelas($query, $kelas)
    {
        return $query->where('kategori', $kelas);
    }
}