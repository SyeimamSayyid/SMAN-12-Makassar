<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Ekstrakurikuler;
use App\Models\Pegawai;
use App\Models\StatistikSekolah;
use App\Models\Alumni;
use App\Models\Fasilitas;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $beritas = Berita::latest()->get();
        $galeris = Galeri::all();
        $ekskuls = Ekstrakurikuler::all();
        
        // Data Pegawai
        $pegawais = Pegawai::where('is_active', true)->get();
        $totalPegawai = $pegawais->count();
        $totalGuru = $pegawais->whereIn('jabatan', ['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru'])->count();
        $totalStaff = $pegawais->where('jabatan', 'Staff TU')->count();
        $pegawaiTerbaru = Pegawai::orderBy('created_at', 'desc')->take(4)->get();
        
        // Data Statistik
        $statistikAktif = StatistikSekolah::where('is_active', true)->get()->keyBy('kategori');
        $totalSiswa = $statistikAktif['total']->jumlah_siswa ?? 0;
        $siswaKelas10 = $statistikAktif['kelas_10']->jumlah_siswa ?? 0;
        $siswaKelas11 = $statistikAktif['kelas_11']->jumlah_siswa ?? 0;
        $siswaKelas12 = $statistikAktif['kelas_12']->jumlah_siswa ?? 0;
        
        // Data Alumni
        $totalAlumni = Alumni::count();
        $alumniPending = Alumni::pending()->count();
        $alumniApproved = Alumni::approved()->count();
        $alumniTerbaru = Alumni::orderBy('created_at', 'desc')->take(3)->get();
        
        // ✅ Data Fasilitas
        $totalFasilitas = Fasilitas::aktif()->count();
        $fasilitasTerbaru = Fasilitas::aktif()->urut()->limit(3)->get();
        
        // ✅ Data Galeri
        $totalGaleri = Galeri::aktif()->count();
        $galeriFeatured = Galeri::aktif()->featured()->count();
        $totalGaleriViews = Galeri::aktif()->sum('views');
        $galeriTerbaru = Galeri::aktif()->orderBy('created_at', 'desc')->limit(3)->get();

        return view('admin.dashboard', compact(
            'beritas',
            'galeris',
            'ekskuls',
            'pegawais',
            'totalPegawai',
            'totalGuru',
            'totalStaff',
            'pegawaiTerbaru',
            'totalSiswa',
            'siswaKelas10',
            'siswaKelas11',
            'siswaKelas12',
            'totalAlumni',
            'alumniPending',
            'alumniApproved',
            'alumniTerbaru',
            'totalFasilitas',
            'fasilitasTerbaru',
            'totalGaleri',
            'galeriFeatured',
            'totalGaleriViews',
            'galeriTerbaru'
        ));
    }
}