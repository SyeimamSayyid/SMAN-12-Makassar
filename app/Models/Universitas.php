<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universitas extends Model
{
    use HasFactory;

    protected $table = 'universitas';
    
    protected $fillable = [
        'nama', 'logo', 'akronim', 'provinsi', 'latitude', 'longitude', 'status'
    ];

    public function alumni()
    {
        return $this->hasMany(Alumni::class);
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}