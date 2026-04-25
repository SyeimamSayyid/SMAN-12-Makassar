<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Pegawai;
use App\Models\Ekstrakurikuler;
use App\Models\StatistikSekolah;
use App\Models\Alumni;
use App\Models\Universitas;
use App\Models\Fasilitas;
use App\Models\Galeri;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Berita terbaru
        $beritas = Berita::orderBy('tanggal', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->limit(6)
                        ->get();
        
        // Data Guru & Staff
        $gurus = Pegawai::whereIn('jabatan', ['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru'])
                        ->where('is_active', true)
                        ->orderBy('jabatan')
                        ->orderBy('nama')
                        ->get();
        
        $staffs = Pegawai::where('jabatan', 'Staff TU')
                         ->where('is_active', true)
                         ->orderBy('nama')
                         ->get();
        
        // Data Statistik
        $totalGuru = Pegawai::whereIn('jabatan', ['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru'])
                            ->where('is_active', true)
                            ->count();
        
        $statistikAktif = StatistikSekolah::where('is_active', true)
                                          ->get()
                                          ->keyBy('kategori');
        
        $totalSiswa = $statistikAktif['total']->jumlah_siswa ?? 1100;
        $totalRombel = $statistikAktif['total']->jumlah_rombel ?? 31;
        $totalEkskul = Ekstrakurikuler::where('is_active', true)->count();
        
        // ✅ Data Ekstrakurikuler untuk Home
        $eskulList = Ekstrakurikuler::where('is_active', true)
            ->orderBy('nama', 'asc')
            ->limit(8)
            ->get();
        
        // Data Alumni
        $featuredAlumni = Alumni::with('universitas')
            ->featured()
            ->orderBy('tahun_lulus', 'desc')
            ->limit(3)
            ->get();
        
        $statsAlumni = [
            'total' => Alumni::approved()->count(),
            'universitas' => Universitas::count(),
            'provinsi' => Alumni::approved()->whereNotNull('provinsi')->distinct('provinsi')->count('provinsi'),
            'angkatan' => Alumni::approved()->distinct('tahun_lulus')->count('tahun_lulus'),
        ];
        
        $universitasList = Universitas::orderBy('nama')->limit(10)->get();
        $floatingAlumni = Alumni::with('universitas')
            ->approved()
            ->whereNotNull('universitas_id')
            ->inRandomOrder()
            ->limit(16)
            ->get();
        
        // Data Fasilitas
        $fasilitasList = Fasilitas::aktif()->urut()->limit(6)->get();
        
        // Data Galeri
        $galeriList = Galeri::aktif()
            ->orderBy('is_featured', 'desc')
            ->orderBy('tanggal_kegiatan', 'desc')
            ->limit(8)
            ->get();

        return view('home', compact(
            'beritas', 
            'gurus', 
            'staffs',
            'totalGuru',
            'totalSiswa',
            'totalRombel',
            'totalEkskul',
            'eskulList',        // ✅ Data Eskul
            'featuredAlumni',
            'statsAlumni',
            'universitasList',
            'floatingAlumni',
            'fasilitasList',
            'galeriList'
        ));
    }
}