<?php
// app/Http/Controllers/PegawaiController.php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        // Kepala Sekolah
        $kepalaSekolah = Pegawai::where('jabatan', 'Kepala Sekolah')
                                ->where('is_active', true)
                                ->first();
        
        // Wakil Kepala Sekolah
        $wakilKepalaSekolah = Pegawai::where('jabatan', 'Wakil Kepala Sekolah')
                                     ->where('is_active', true)
                                     ->orderBy('pangkat')
                                     ->get();
        
        // Guru (dikelompokkan berdasarkan pangkat/mata pelajaran)
        $gurus = Pegawai::where('jabatan', 'Guru')
                        ->where('is_active', true)
                        ->orderBy('pangkat')
                        ->orderBy('nama')
                        ->get();
        
        // Kelompokkan guru berdasarkan mata pelajaran (pangkat)
        $guruByMapel = $gurus->groupBy('pangkat');
        
        // Staff TU
        $staffs = Pegawai::where('jabatan', 'Staff TU')
                         ->where('is_active', true)
                         ->orderBy('pangkat')
                         ->orderBy('nama')
                         ->get();
        
        // Kelompokkan staff berdasarkan bidang (pangkat)
        $staffByBidang = $staffs->groupBy('pangkat');
        
        return view('pegawai.index', compact(
            'kepalaSekolah',
            'wakilKepalaSekolah',
            'gurus',
            'guruByMapel',
            'staffs',
            'staffByBidang'
        ));
    }
}