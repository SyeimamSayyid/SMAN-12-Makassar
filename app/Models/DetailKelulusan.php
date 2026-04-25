<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKelulusan extends Model
{
    use HasFactory;

    protected $table = 'detail_kelulusan';
    
    protected $fillable = [
        'rekap_tahunan_id', 'kelas', 'jumlah_siswa', 'lulus', 'tidak_lulus', 'persentase'
    ];

    protected $casts = [
        'persentase' => 'float',
    ];

    public function rekapTahunan()
    {
        return $this->belongsTo(RekapTahunan::class);
    }
}