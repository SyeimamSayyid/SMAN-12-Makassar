<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StatistikSekolah;
use App\Models\MutasiSiswa;
use App\Models\StatistikBulanan;
use App\Models\RekapTahunan;
use App\Models\RekapBulanan;
use App\Models\DetailKelulusan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StatistikController extends Controller
{
    /**
     * Halaman utama statistik
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        
        $statistik = StatistikSekolah::aktif()
            ->where('tahun_ajaran', 'LIKE', $tahun . '%')
            ->get()
            ->keyBy('kategori');
        
        $kelasData = [
            '10' => $statistik['kelas_10'] ?? null,
            '11' => $statistik['kelas_11'] ?? null,
            '12' => $statistik['kelas_12'] ?? null,
        ];
        
        $totalStats = $statistik['total'] ?? null;
        $pieData = [
            'laki' => $totalStats?->laki_laki ?? 0,
            'perempuan' => $totalStats?->perempuan ?? 0,
        ];
        
        $mutasiBulanan = [];
        foreach (['10', '11', '12'] as $kelas) {
            $mutasiBulanan[$kelas] = StatistikBulanan::kelas($kelas)
                ->tahun($tahun)
                ->orderBy('bulan')
                ->get();
        }
        
        $riwayatMutasi = MutasiSiswa::with('user')
            ->where('tahun', $tahun)
            ->orderBy('tanggal', 'desc')
            ->limit(10)
            ->get();
        
        return view('admin.statistik.index', compact(
            'statistik', 'kelasData', 'pieData', 'mutasiBulanan', 'riwayatMutasi', 'tahun'
        ));
    }
    
    /**
     * Update data statistik sekolah
     */
    public function updateStatistik(Request $request)
    {
        $validated = $request->validate([
            'kelas_10_jumlah' => 'required|integer|min:0',
            'kelas_10_laki' => 'required|integer|min:0',
            'kelas_10_perempuan' => 'required|integer|min:0',
            'kelas_10_rombel' => 'required|integer|min:1',
            'kelas_11_jumlah' => 'required|integer|min:0',
            'kelas_11_laki' => 'required|integer|min:0',
            'kelas_11_perempuan' => 'required|integer|min:0',
            'kelas_11_rombel' => 'required|integer|min:1',
            'kelas_12_jumlah' => 'required|integer|min:0',
            'kelas_12_laki' => 'required|integer|min:0',
            'kelas_12_perempuan' => 'required|integer|min:0',
            'kelas_12_rombel' => 'required|integer|min:1',
            'tahun_ajaran' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
        ]);
        
        $totalJumlah = $totalLaki = $totalPerempuan = $totalRombel = 0;
        
        foreach (['10', '11', '12'] as $kelas) {
            $jumlah = $validated["kelas_{$kelas}_jumlah"];
            $laki = $validated["kelas_{$kelas}_laki"];
            $perempuan = $validated["kelas_{$kelas}_perempuan"];
            $rombel = $validated["kelas_{$kelas}_rombel"];
            
            $totalJumlah += $jumlah;
            $totalLaki += $laki;
            $totalPerempuan += $perempuan;
            $totalRombel += $rombel;
            
            StatistikSekolah::updateOrCreate(
                ['kategori' => "kelas_{$kelas}", 'tahun_ajaran' => $validated['tahun_ajaran'], 'semester' => $validated['semester']],
                [
                    'jumlah_siswa' => $jumlah,
                    'laki_laki' => $laki,
                    'perempuan' => $perempuan,
                    'jumlah_rombel' => $rombel,
                    'is_active' => true,
                ]
            );
        }
        
        StatistikSekolah::updateOrCreate(
            ['kategori' => 'total', 'tahun_ajaran' => $validated['tahun_ajaran'], 'semester' => $validated['semester']],
            [
                'jumlah_siswa' => $totalJumlah,
                'laki_laki' => $totalLaki,
                'perempuan' => $totalPerempuan,
                'jumlah_rombel' => $totalRombel,
                'is_active' => true,
            ]
        );
        
        return redirect()->route('admin.statistik.index')
            ->with('success', 'Data statistik berhasil diperbarui!');
    }
    
    /**
     * Tambah data mutasi siswa
     */
    public function storeMutasi(Request $request)
    {
        $validated = $request->validate([
            'kelas' => 'required|in:10,11,12',
            'jenis_mutasi' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
        ]);
        
        $tanggal = Carbon::parse($validated['tanggal']);
        $validated['bulan'] = $tanggal->month;
        $validated['tahun'] = $tanggal->year;
        $validated['user_id'] = auth()->id();
        
        MutasiSiswa::create($validated);
        
        $this->updateStatistikBulanan($validated['kelas'], $tanggal->month, $tanggal->year);
        
        return redirect()->route('admin.statistik.index')
            ->with('success', 'Data mutasi berhasil ditambahkan!');
    }
    
    /**
     * Hapus data mutasi siswa
     */
    public function destroyMutasi($id)
    {
        $mutasi = MutasiSiswa::findOrFail($id);
        $kelas = $mutasi->kelas;
        $bulan = $mutasi->bulan;
        $tahun = $mutasi->tahun;
        
        $mutasi->delete();
        
        $this->updateStatistikBulanan($kelas, $bulan, $tahun);
        
        return redirect()->route('admin.statistik.index')
            ->with('success', 'Data mutasi berhasil dihapus!');
    }
    
    /**
     * Update statistik bulanan setelah mutasi
     */
    private function updateStatistikBulanan($kelas, $bulan, $tahun): void
    {
        $masuk = MutasiSiswa::kelas($kelas)->masuk()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $keluar = MutasiSiswa::kelas($kelas)->keluar()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        
        $prevBulan = $bulan - 1;
        $prevTahun = $tahun;
        if ($prevBulan < 1) {
            $prevBulan = 12;
            $prevTahun--;
        }
        
        $prevData = StatistikBulanan::kelas($kelas)->bulan($prevBulan)->tahun($prevTahun)->first();
        $jumlahAwal = $prevData ? $prevData->jumlah_akhir : 0;
        
        if ($jumlahAwal == 0) {
            $statistik = StatistikSekolah::kelas("kelas_{$kelas}")->aktif()->first();
            $jumlahAwal = $statistik ? $statistik->jumlah_siswa : 0;
        }
        
        $jumlahAkhir = $jumlahAwal + $masuk - $keluar;
        
        StatistikBulanan::updateOrCreate(
            ['kelas' => $kelas, 'bulan' => $bulan, 'tahun' => $tahun],
            [
                'jumlah_awal' => $jumlahAwal,
                'masuk' => $masuk,
                'keluar' => $keluar,
                'jumlah_akhir' => $jumlahAkhir,
                'laki_laki' => round($jumlahAkhir * 0.45),
                'perempuan' => round($jumlahAkhir * 0.55),
            ]
        );
    }

    /**
     * Halaman Rekap Tahunan
     */
    public function rekapTahunan(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        
        $rekapTahunan = RekapTahunan::terbaru()->get();
        $rekap = RekapTahunan::where('tahun_ajaran_awal', $tahun)->first();
        
        $statistikAwal = StatistikSekolah::aktif()
            ->where('tahun_ajaran', 'LIKE', $tahun . '%')
            ->get()
            ->keyBy('kategori');
        
        $chartData = [];
        if ($rekapTahunan->isNotEmpty()) {
            $chartData = [
                'labels' => $rekapTahunan->map(fn($r) => $r->tahun_ajaran_awal . '/' . substr($r->tahun_ajaran_akhir, -2))->toArray(),
                'masuk' => $rekapTahunan->pluck('total_masuk')->toArray(),
                'keluar' => $rekapTahunan->pluck('total_keluar')->toArray(),
                'lulus' => $rekapTahunan->pluck('lulus_kelas12')->toArray(),
            ];
        }
        
        return view('admin.statistik.rekap-tahunan', compact(
            'rekapTahunan', 'rekap', 'tahun', 'statistikAwal', 'chartData'
        ));
    }

    /**
     * Generate Rekap Tahunan
     */
    public function generateRekapTahunan(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_awal' => 'required|integer|min:2020|max:2100',
            'semester' => 'required|in:Ganjil,Genap',
            'lulus_kelas12' => 'required|integer|min:0',
            'total_laki' => 'required|integer|min:0',
            'total_perempuan' => 'required|integer|min:0',
            'catatan' => 'nullable|string',
        ]);
        
        $tahunAwal = $validated['tahun_ajaran_awal'];
        $tahunAkhir = $tahunAwal + 1;
        
        $statistik = StatistikSekolah::where('tahun_ajaran', 'LIKE', $tahunAwal . '%')
            ->where('semester', $validated['semester'])
            ->get()
            ->keyBy('kategori');
        
        $masukKelas10 = MutasiSiswa::kelas('10')->masuk()->tahun($tahunAwal)->sum('jumlah') ?? 0;
        $masukKelas11 = MutasiSiswa::kelas('11')->masuk()->tahun($tahunAwal)->sum('jumlah') ?? 0;
        $masukKelas12 = MutasiSiswa::kelas('12')->masuk()->tahun($tahunAwal)->sum('jumlah') ?? 0;
        
        $keluarKelas10 = MutasiSiswa::kelas('10')->keluar()->tahun($tahunAwal)->sum('jumlah') ?? 0;
        $keluarKelas11 = MutasiSiswa::kelas('11')->keluar()->tahun($tahunAwal)->sum('jumlah') ?? 0;
        $keluarKelas12 = MutasiSiswa::kelas('12')->keluar()->tahun($tahunAwal)->sum('jumlah') ?? 0;
        
        $awal10 = $statistik['kelas_10']->jumlah_siswa ?? 0;
        $awal11 = $statistik['kelas_11']->jumlah_siswa ?? 0;
        $awal12 = $statistik['kelas_12']->jumlah_siswa ?? 0;
        
        $akhir10 = $awal10 + $masukKelas10 - $keluarKelas10;
        $akhir11 = $awal11 + $masukKelas11 - $keluarKelas11;
        $akhir12 = $awal12 + $masukKelas12 - $keluarKelas12 - $validated['lulus_kelas12'];
        
        $persentaseKelulusan = $awal12 > 0 ? ($validated['lulus_kelas12'] / $awal12) * 100 : 0;
        
        $rekap = RekapTahunan::updateOrCreate(
            [
                'tahun_ajaran_awal' => $tahunAwal,
                'tahun_ajaran_akhir' => $tahunAkhir,
                'semester' => $validated['semester']
            ],
            [
                'jumlah_awal_kelas10' => $awal10,
                'jumlah_awal_kelas11' => $awal11,
                'jumlah_awal_kelas12' => $awal12,
                'total_awal' => $awal10 + $awal11 + $awal12,
                
                'masuk_kelas10' => $masukKelas10,
                'masuk_kelas11' => $masukKelas11,
                'masuk_kelas12' => $masukKelas12,
                'total_masuk' => $masukKelas10 + $masukKelas11 + $masukKelas12,
                
                'keluar_kelas10' => $keluarKelas10,
                'keluar_kelas11' => $keluarKelas11,
                'keluar_kelas12' => $keluarKelas12,
                'total_keluar' => $keluarKelas10 + $keluarKelas11 + $keluarKelas12,
                
                'lulus_kelas12' => $validated['lulus_kelas12'],
                'persentase_kelulusan' => round($persentaseKelulusan, 2),
                
                'jumlah_akhir_kelas10' => max(0, $akhir10),
                'jumlah_akhir_kelas11' => max(0, $akhir11),
                'jumlah_akhir_kelas12' => max(0, $akhir12),
                'total_akhir' => max(0, $akhir10 + $akhir11 + $akhir12),
                
                'total_laki' => $validated['total_laki'],
                'total_perempuan' => $validated['total_perempuan'],
                'catatan' => $validated['catatan'],
                'created_by' => auth()->id(),
            ]
        );
        
        if ($request->has('detail_kelas')) {
            DetailKelulusan::where('rekap_tahunan_id', $rekap->id)->delete();
            
            foreach ($request->detail_kelas as $detail) {
                if (!empty($detail['kelas']) && isset($detail['jumlah_siswa'])) {
                    $lulus = $detail['lulus'] ?? 0;
                    $jumlah = $detail['jumlah_siswa'];
                    $persentase = $jumlah > 0 ? ($lulus / $jumlah) * 100 : 0;
                    
                    DetailKelulusan::create([
                        'rekap_tahunan_id' => $rekap->id,
                        'kelas' => $detail['kelas'],
                        'jumlah_siswa' => $jumlah,
                        'lulus' => $lulus,
                        'tidak_lulus' => $jumlah - $lulus,
                        'persentase' => round($persentase, 2),
                    ]);
                }
            }
        }
        
        return redirect()->route('admin.statistik.rekap-tahunan', ['tahun' => $tahunAwal])
            ->with('success', 'Rekap tahunan berhasil digenerate!');
    }

    /**
     * Hapus Rekap Tahunan
     */
    public function destroyRekapTahunan($id)
    {
        $rekap = RekapTahunan::findOrFail($id);
        $rekap->delete();
        
        return redirect()->route('admin.statistik.rekap-tahunan')
            ->with('success', 'Rekap tahunan berhasil dihapus!');
    }

    /**
     * Export Rekap Tahunan ke PDF/Print
     */
    public function exportRekapTahunan($id)
    {
        $rekap = RekapTahunan::with('detailKelulusan')->findOrFail($id);
        return view('admin.statistik.print-rekap', compact('rekap'));
    }

    /**
     * Halaman Rekap Bulanan
     */
    public function rekapBulanan(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $semester = $request->get('semester', 'Ganjil');
        
        $rekapBulanan = RekapBulanan::tahun($tahun)
            ->semester($semester)
            ->orderBy('bulan')
            ->get();
        
        $statistikAwal = StatistikSekolah::aktif()
            ->where('tahun_ajaran', 'LIKE', $tahun . '%')
            ->get()
            ->keyBy('kategori');
        
        $rekapTahunan = $this->hitungRekapTahunan($tahun, $semester, $rekapBulanan);
        
        return view('admin.statistik.rekap-bulanan', compact(
            'rekapBulanan', 'tahun', 'semester', 'statistikAwal', 'rekapTahunan'
        ));
    }

    /**
     * Generate Rekap Bulanan
     */
    public function generateRekapBulanan(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:2100',
            'semester' => 'required|in:Ganjil,Genap',
            'catatan' => 'nullable|string',
        ]);
        
        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
        
        $statistik = StatistikSekolah::aktif()
            ->where('tahun_ajaran', 'LIKE', $tahun . '%')
            ->get()
            ->keyBy('kategori');
        
        $masuk10 = MutasiSiswa::kelas('10')->masuk()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $keluar10 = MutasiSiswa::kelas('10')->keluar()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $masuk11 = MutasiSiswa::kelas('11')->masuk()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $keluar11 = MutasiSiswa::kelas('11')->keluar()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $masuk12 = MutasiSiswa::kelas('12')->masuk()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $keluar12 = MutasiSiswa::kelas('12')->keluar()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        
        $prevBulan = $bulan - 1;
        $prevTahun = $tahun;
        if ($prevBulan < 1) {
            $prevBulan = 12;
            $prevTahun--;
        }
        
        $prevRekap = RekapBulanan::bulan($prevBulan)->tahun($prevTahun)->first();
        
        $awal10 = $prevRekap ? $prevRekap->kelas10_akhir : ($statistik['kelas_10']->jumlah_siswa ?? 0);
        $awal11 = $prevRekap ? $prevRekap->kelas11_akhir : ($statistik['kelas_11']->jumlah_siswa ?? 0);
        $awal12 = $prevRekap ? $prevRekap->kelas12_akhir : ($statistik['kelas_12']->jumlah_siswa ?? 0);
        
        $akhir10 = $awal10 + $masuk10 - $keluar10;
        $akhir11 = $awal11 + $masuk11 - $keluar11;
        $akhir12 = $awal12 + $masuk12 - $keluar12;
        
        $totalAwal = $awal10 + $awal11 + $awal12;
        $totalMasuk = $masuk10 + $masuk11 + $masuk12;
        $totalKeluar = $keluar10 + $keluar11 + $keluar12;
        $totalAkhir = $akhir10 + $akhir11 + $akhir12;
        
        RekapBulanan::updateOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun, 'semester' => $validated['semester']],
            [
                'kelas10_awal' => $awal10, 'kelas10_masuk' => $masuk10, 'kelas10_keluar' => $keluar10, 'kelas10_akhir' => $akhir10,
                'kelas10_laki' => round($akhir10 * 0.45), 'kelas10_perempuan' => round($akhir10 * 0.55),
                'kelas11_awal' => $awal11, 'kelas11_masuk' => $masuk11, 'kelas11_keluar' => $keluar11, 'kelas11_akhir' => $akhir11,
                'kelas11_laki' => round($akhir11 * 0.45), 'kelas11_perempuan' => round($akhir11 * 0.55),
                'kelas12_awal' => $awal12, 'kelas12_masuk' => $masuk12, 'kelas12_keluar' => $keluar12, 'kelas12_akhir' => $akhir12,
                'kelas12_laki' => round($akhir12 * 0.45), 'kelas12_perempuan' => round($akhir12 * 0.55),
                'total_awal' => $totalAwal, 'total_masuk' => $totalMasuk, 'total_keluar' => $totalKeluar, 'total_akhir' => $totalAkhir,
                'total_laki' => round($totalAkhir * 0.45), 'total_perempuan' => round($totalAkhir * 0.55),
                'catatan' => $validated['catatan'],
                'created_by' => auth()->id(),
            ]
        );
        
        return redirect()->route('admin.statistik.rekap-bulanan', ['tahun' => $tahun, 'semester' => $validated['semester']])
            ->with('success', 'Rekap bulan ' . Carbon::create()->month($bulan)->locale('id')->monthName . ' berhasil digenerate!');
    }

    /**
     * Hapus Rekap Bulanan
     */
    public function destroyRekapBulanan($id)
    {
        $rekap = RekapBulanan::findOrFail($id);
        $tahun = $rekap->tahun;
        $semester = $rekap->semester;
        $rekap->delete();
        
        return redirect()->route('admin.statistik.rekap-bulanan', ['tahun' => $tahun, 'semester' => $semester])
            ->with('success', 'Rekap bulanan berhasil dihapus!');
    }

    /**
     * Generate Semua Rekap Bulanan (untuk satu semester)
     */
    public function generateAllRekapBulanan(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));
        $semester = $request->get('semester', 'Ganjil');
        
        $bulanRange = $semester == 'Ganjil' ? range(7, 12) : range(1, 6);
        
        foreach ($bulanRange as $bulan) {
            $exists = RekapBulanan::bulan($bulan)->tahun($tahun)->semester($semester)->exists();
            if (!$exists) {
                $this->generateSingleRekap($bulan, $tahun, $semester);
            }
        }
        
        return redirect()->route('admin.statistik.rekap-bulanan', ['tahun' => $tahun, 'semester' => $semester])
            ->with('success', 'Semua rekap bulanan berhasil digenerate!');
    }

    /**
     * Helper untuk generate single rekap
     */
    private function generateSingleRekap($bulan, $tahun, $semester)
    {
        $statistik = StatistikSekolah::aktif()
            ->where('tahun_ajaran', 'LIKE', $tahun . '%')
            ->get()
            ->keyBy('kategori');
        
        $masuk10 = MutasiSiswa::kelas('10')->masuk()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $keluar10 = MutasiSiswa::kelas('10')->keluar()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $masuk11 = MutasiSiswa::kelas('11')->masuk()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $keluar11 = MutasiSiswa::kelas('11')->keluar()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $masuk12 = MutasiSiswa::kelas('12')->masuk()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        $keluar12 = MutasiSiswa::kelas('12')->keluar()->where('bulan', $bulan)->where('tahun', $tahun)->sum('jumlah') ?? 0;
        
        $prevBulan = $bulan - 1;
        $prevTahun = $tahun;
        if ($prevBulan < 1) {
            $prevBulan = 12;
            $prevTahun--;
        }
        
        $prevRekap = RekapBulanan::bulan($prevBulan)->tahun($prevTahun)->first();
        
        $awal10 = $prevRekap ? $prevRekap->kelas10_akhir : ($statistik['kelas_10']->jumlah_siswa ?? 0);
        $awal11 = $prevRekap ? $prevRekap->kelas11_akhir : ($statistik['kelas_11']->jumlah_siswa ?? 0);
        $awal12 = $prevRekap ? $prevRekap->kelas12_akhir : ($statistik['kelas_12']->jumlah_siswa ?? 0);
        
        $akhir10 = max(0, $awal10 + $masuk10 - $keluar10);
        $akhir11 = max(0, $awal11 + $masuk11 - $keluar11);
        $akhir12 = max(0, $awal12 + $masuk12 - $keluar12);
        
        RekapBulanan::updateOrCreate(
            ['bulan' => $bulan, 'tahun' => $tahun, 'semester' => $semester],
            [
                'kelas10_awal' => $awal10, 'kelas10_masuk' => $masuk10, 'kelas10_keluar' => $keluar10, 'kelas10_akhir' => $akhir10,
                'kelas10_laki' => round($akhir10 * 0.45), 'kelas10_perempuan' => round($akhir10 * 0.55),
                'kelas11_awal' => $awal11, 'kelas11_masuk' => $masuk11, 'kelas11_keluar' => $keluar11, 'kelas11_akhir' => $akhir11,
                'kelas11_laki' => round($akhir11 * 0.45), 'kelas11_perempuan' => round($akhir11 * 0.55),
                'kelas12_awal' => $awal12, 'kelas12_masuk' => $masuk12, 'kelas12_keluar' => $keluar12, 'kelas12_akhir' => $akhir12,
                'kelas12_laki' => round($akhir12 * 0.45), 'kelas12_perempuan' => round($akhir12 * 0.55),
                'total_awal' => $awal10 + $awal11 + $awal12,
                'total_masuk' => $masuk10 + $masuk11 + $masuk12,
                'total_keluar' => $keluar10 + $keluar11 + $keluar12,
                'total_akhir' => $akhir10 + $akhir11 + $akhir12,
                'total_laki' => round(($akhir10 + $akhir11 + $akhir12) * 0.45),
                'total_perempuan' => round(($akhir10 + $akhir11 + $akhir12) * 0.55),
                'created_by' => auth()->id(),
            ]
        );
    }

    /**
     * Hitung Rekap Tahunan dari data bulanan
     */
    private function hitungRekapTahunan($tahun, $semester, $rekapBulanan)
    {
        if ($rekapBulanan->isEmpty()) {
            return null;
        }
        
        $firstMonth = $rekapBulanan->first();
        $lastMonth = $rekapBulanan->last();
        
        $totalMasuk10 = $rekapBulanan->sum('kelas10_masuk');
        $totalKeluar10 = $rekapBulanan->sum('kelas10_keluar');
        $totalMasuk11 = $rekapBulanan->sum('kelas11_masuk');
        $totalKeluar11 = $rekapBulanan->sum('kelas11_keluar');
        $totalMasuk12 = $rekapBulanan->sum('kelas12_masuk');
        $totalKeluar12 = $rekapBulanan->sum('kelas12_keluar');
        
        $lulus12 = $lastMonth->kelas12_akhir ?? 0;
        
        return [
            'tahun' => $tahun,
            'semester' => $semester,
            'awal' => [
                'kelas10' => $firstMonth->kelas10_awal ?? 0,
                'kelas11' => $firstMonth->kelas11_awal ?? 0,
                'kelas12' => $firstMonth->kelas12_awal ?? 0,
                'total' => $firstMonth->total_awal ?? 0,
            ],
            'masuk' => [
                'kelas10' => $totalMasuk10,
                'kelas11' => $totalMasuk11,
                'kelas12' => $totalMasuk12,
                'total' => $totalMasuk10 + $totalMasuk11 + $totalMasuk12,
            ],
            'keluar' => [
                'kelas10' => $totalKeluar10,
                'kelas11' => $totalKeluar11,
                'kelas12' => $totalKeluar12,
                'total' => $totalKeluar10 + $totalKeluar11 + $totalKeluar12,
            ],
            'lulus' => $lulus12,
            'akhir' => [
                'kelas10' => $lastMonth->kelas10_akhir ?? 0,
                'kelas11' => $lastMonth->kelas11_akhir ?? 0,
                'kelas12' => $lastMonth->kelas12_akhir ?? 0,
                'total' => $lastMonth->total_akhir ?? 0,
            ],
            'laki' => $lastMonth->total_laki ?? 0,
            'perempuan' => $lastMonth->total_perempuan ?? 0,
            'persentase_kelulusan' => $firstMonth->kelas12_awal > 0 
                ? round(($lulus12 / $firstMonth->kelas12_awal) * 100, 2) 
                : 0,
        ];
    }
}