<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapBulanan extends Model
{
    use HasFactory;

    protected $table = 'rekap_bulanan';
    
    protected $fillable = [
        'bulan', 'tahun', 'semester',
        'kelas10_awal', 'kelas10_masuk', 'kelas10_keluar', 'kelas10_akhir', 'kelas10_laki', 'kelas10_perempuan',
        'kelas11_awal', 'kelas11_masuk', 'kelas11_keluar', 'kelas11_akhir', 'kelas11_laki', 'kelas11_perempuan',
        'kelas12_awal', 'kelas12_masuk', 'kelas12_keluar', 'kelas12_akhir', 'kelas12_laki', 'kelas12_perempuan',
        'total_awal', 'total_masuk', 'total_keluar', 'total_akhir', 'total_laki', 'total_perempuan',
        'catatan', 'created_by'
    ];

    protected $casts = [
        'bulan' => 'integer',
        'tahun' => 'integer',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getNamaBulanAttribute()
    {
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return $bulan[$this->bulan - 1] ?? '';
    }

    public function getPeriodeAttribute()
    {
        return $this->nama_bulan . ' ' . $this->tahun;
    }

    public function getSelisihAttribute()
    {
        return $this->total_akhir - $this->total_awal;
    }

    public function scopeTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }

    public function scopeBulan($query, $bulan)
    {
        return $query->where('bulan', $bulan);
    }

    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }
}