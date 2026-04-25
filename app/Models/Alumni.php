<?php
// app/Models/Alumni.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Alumni extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'alumni';
    
    protected $fillable = [
    'nama_lengkap', 'tahun_lulus',
    'universitas_id', 'program_studi', 'tahun_masuk_kuliah',
    'pekerjaan', 'perusahaan',
    'provinsi', 'kota', 'latitude', 'longitude',
    'email', 'no_hp', 'instagram',  // ✅ no_hp sudah ditambahkan
    'testimoni',
    'status', 'catatan_admin', 'verified_by', 'verified_at',
    'is_featured'
];

    protected $casts = [
        'tahun_lulus' => 'integer',
        'tahun_masuk_kuliah' => 'integer',
        'verified_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    // Relationships
    public function universitas()
    {
        return $this->belongsTo(Universitas::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)  // ✅ TAMBAHKAN INI
    {
        return $query->where('status', 'rejected');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('status', 'approved');
    }

    // Accessors
    public function getLogoUniversitasUrlAttribute()
    {
        if ($this->universitas && $this->universitas->logo) {
            return asset('storage/' . $this->universitas->logo);
        }
        return asset('images/default-university.png');
    }

    public function getNamaUniversitasAttribute()
    {
        return $this->universitas ? $this->universitas->nama : '-';
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'approved' => ['bg-green-100 text-green-800', 'Disetujui'],
            'pending' => ['bg-yellow-100 text-yellow-800', 'Menunggu'],
            'rejected' => ['bg-red-100 text-red-800', 'Ditolak'],
            default => ['bg-gray-100 text-gray-800', $this->status],
        };
    }
    
    // Accessor untuk status label (versi simple)
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'approved' => 'Disetujui',
            'pending' => 'Menunggu',
            'rejected' => 'Ditolak',
            default => $this->status,
        };
    }
    
    // Accessor untuk status color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'approved' => 'green',
            'pending' => 'yellow',
            'rejected' => 'red',
            default => 'gray',
        };
    }
}