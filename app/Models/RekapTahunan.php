<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapTahunan extends Model
{
    use HasFactory;

    protected $table = 'rekap_tahunan';
    
    protected $fillable = [
        'tahun_ajaran_awal', 'tahun_ajaran_akhir', 'semester',
        'jumlah_awal_kelas10', 'jumlah_awal_kelas11', 'jumlah_awal_kelas12', 'total_awal',
        'masuk_kelas10', 'masuk_kelas11', 'masuk_kelas12', 'total_masuk',
        'keluar_kelas10', 'keluar_kelas11', 'keluar_kelas12', 'total_keluar',
        'lulus_kelas12', 'persentase_kelulusan',
        'jumlah_akhir_kelas10', 'jumlah_akhir_kelas11', 'jumlah_akhir_kelas12', 'total_akhir',
        'total_laki', 'total_perempuan', 'catatan', 'created_by'
    ];

    protected $casts = [
        'tahun_ajaran_awal' => 'integer',
        'tahun_ajaran_akhir' => 'integer',
        'persentase_kelulusan' => 'float',
    ];

    public function detailKelulusan()
    {
        return $this->hasMany(DetailKelulusan::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getTahunAjaranAttribute()
    {
        return $this->tahun_ajaran_awal . '/' . $this->tahun_ajaran_akhir;
    }

    public function getSelisihAttribute()
    {
        return $this->total_akhir - $this->total_awal;
    }

    public function scopeTerbaru($query)
    {
        return $query->orderBy('tahun_ajaran_awal', 'desc');
    }
}