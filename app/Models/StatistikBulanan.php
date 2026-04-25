<?php
// app/Models/StatistikBulanan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatistikBulanan extends Model
{
    use HasFactory;

    protected $table = 'statistik_bulanan';
    
    protected $fillable = [
        'kelas', 'bulan', 'tahun', 'jumlah_awal', 'masuk', 
        'keluar', 'jumlah_akhir', 'laki_laki', 'perempuan'
    ];

    public function getNamaBulanAttribute()
    {
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $bulan[$this->bulan - 1] ?? '';
    }

    public function scopeKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    public function scopeTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    public function scopeBulan($query, $bulan)
    {
        return $query->where('bulan', $bulan);
    }
}