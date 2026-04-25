<?php
// app/Models/MutasiSiswa.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiSiswa extends Model
{
    use HasFactory;

    protected $table = 'mutasi_siswa';
    
    protected $fillable = [
        'kelas', 'jenis_mutasi', 'jumlah', 'keterangan', 
        'tanggal', 'bulan', 'tahun', 'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMasuk($query)
    {
        return $query->where('jenis_mutasi', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->where('jenis_mutasi', 'keluar');
    }

    public function scopeKelas($query, $kelas)
    {
        return $query->where('kelas', $kelas);
    }

    public function scopeTahun($query, $tahun)
    {
        return $query->where('tahun', $tahun);
    }
}