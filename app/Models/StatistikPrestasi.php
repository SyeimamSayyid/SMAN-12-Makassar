<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatistikPrestasi extends Model
{
    use HasFactory;

    protected $table = 'statistik_prestasi';
    
    protected $fillable = [
        'nama_prestasi', 'tingkat', 'juara', 'tahun', 'penyelenggara', 'deskripsi'
    ];
}