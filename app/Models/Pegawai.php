<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';
    
    protected $fillable = [
        'nama',
        'nip',
        'foto',
        'jabatan',
        'pangkat',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope untuk pegawai aktif
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk guru (termasuk kepsek, wakepsek, guru bk, kepala perpus)
    public function scopeGuru($query)
    {
        return $query->whereIn('jabatan', [
            'Kepala Sekolah', 
            'Wakil Kepala Sekolah', 
            'Guru', 
            'Guru BK', 
            'Kepala Perpustakaan'
        ]);
    }

    // Scope untuk staff TU
    public function scopeStaff($query)
    {
        return $query->where('jabatan', 'Staff TU');
    }

    // Accessor untuk URL foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }

    // Accessor untuk badge jabatan (HTML class)
    public function getJabatanBadgeClassAttribute()
    {
        return match($this->jabatan) {
            'Kepala Sekolah' => 'bg-purple-100 text-purple-700',
            'Wakil Kepala Sekolah' => 'bg-orange-100 text-orange-700',
            'Guru' => 'bg-blue-100 text-blue-700',
            'Guru BK' => 'bg-teal-100 text-teal-700',
            'Kepala Perpustakaan' => 'bg-amber-100 text-amber-700',
            'Staff TU' => 'bg-green-100 text-green-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    // Accessor untuk warna border foto
    public function getBorderColorAttribute()
    {
        return match($this->jabatan) {
            'Kepala Sekolah' => 'border-purple-200',
            'Wakil Kepala Sekolah' => 'border-orange-200',
            'Guru' => 'border-blue-200',
            'Guru BK' => 'border-teal-200',
            'Kepala Perpustakaan' => 'border-amber-200',
            'Staff TU' => 'border-green-200',
            default => 'border-gray-200',
        };
    }

    // Accessor untuk warna teks jabatan
    public function getTextColorAttribute()
    {
        return match($this->jabatan) {
            'Kepala Sekolah' => 'text-purple-600',
            'Wakil Kepala Sekolah' => 'text-orange-600',
            'Guru' => 'text-blue-600',
            'Guru BK' => 'text-teal-600',
            'Kepala Perpustakaan' => 'text-amber-600',
            'Staff TU' => 'text-green-600',
            default => 'text-gray-600',
        };
    }

    // Accessor untuk label jabatan
    public function getJabatanLabelAttribute()
    {
        return match($this->jabatan) {
            'Kepala Sekolah' => '🎓 Kepala Sekolah',
            'Wakil Kepala Sekolah' => '📋 Wakil Kepala Sekolah',
            'Guru' => '📚 Guru',
            'Guru BK' => '💬 Guru BK',
            'Kepala Perpustakaan' => '📖 Kepala Perpustakaan',
            'Staff TU' => '📁 Staff TU',
            default => $this->jabatan,
        };
    }
}