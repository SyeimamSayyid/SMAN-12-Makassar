<?php

namespace App\Http\Controllers;

use App\Models\StatistikSekolah;
use App\Models\StatistikBulanan;
use App\Models\MutasiSiswa;
use App\Models\RekapTahunan;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        
        // Data Statistik Utama
        $statistik = StatistikSekolah::aktif()
            ->where('tahun_ajaran', 'LIKE', $tahun . '%')
            ->get()
            ->keyBy('kategori');
        
        // Bar Chart Data
        $barData = [
            'labels' => ['Kelas 10', 'Kelas 11', 'Kelas 12'],
            'jumlah' => [
                $statistik['kelas_10']->jumlah_siswa ?? 0,
                $statistik['kelas_11']->jumlah_siswa ?? 0,
                $statistik['kelas_12']->jumlah_siswa ?? 0,
            ],
            'rombel' => [
                $statistik['kelas_10']->jumlah_rombel ?? 0,
                $statistik['kelas_11']->jumlah_rombel ?? 0,
                $statistik['kelas_12']->jumlah_rombel ?? 0,
            ],
        ];
        
        // Pie Chart Data
        $totalStats = $statistik['total'] ?? null;
        $pieData = [
            'laki' => $totalStats->laki_laki ?? 0,
            'perempuan' => $totalStats->perempuan ?? 0,
        ];
        
        // Line Chart Data
        $lineData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'kelas10' => [],
            'kelas11' => [],
            'kelas12' => [],
        ];
        
        for ($kelas = 10; $kelas <= 12; $kelas++) {
            $data = StatistikBulanan::kelas((string)$kelas)->tahun($tahun)->orderBy('bulan')->get();
            foreach (range(1, 12) as $bulan) {
                $item = $data->firstWhere('bulan', $bulan);
                $lineData["kelas{$kelas}"][] = $item ? $item->jumlah_akhir : null;
            }
        }
        
        // Detail per Kelas
        $detailKelas = [];
        for ($kelas = 10; $kelas <= 12; $kelas++) {
            $key = "kelas_{$kelas}";
            $detailKelas[$kelas] = $statistik[$key] ?? null;
        }
        
        // Mutasi Terbaru
        $mutasiTerbaru = MutasiSiswa::with('user')
            ->where('tahun', $tahun)
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();
        
        // Rekap Tahunan
        $rekapTahunan = RekapTahunan::terbaru()->limit(5)->get();
        
        return view('statistik.index', compact(
            'statistik', 'barData', 'pieData', 'lineData', 'detailKelas', 
            'mutasiTerbaru', 'rekapTahunan', 'tahun'
        ));
    }
}