<?php

namespace App\Exports;

use App\Models\Alumni;
use App\Models\Universitas;
use Barryvdh\DomPDF\Facade\Pdf;

class AlumniExportPDF
{
    protected $tahun_lulus;
    protected $universitas_id;
    protected $jenjang_karir;

    public function __construct($tahun_lulus = null, $universitas_id = null, $jenjang_karir = null)
    {
        $this->tahun_lulus = $tahun_lulus;
        $this->universitas_id = $universitas_id;
        $this->jenjang_karir = $jenjang_karir;
    }

    public function download()
    {
        $query = Alumni::with('universitas')->approved();

        // Filter Tahun Lulus
        if ($this->tahun_lulus && $this->tahun_lulus !== 'all') {
            $query->where('tahun_lulus', $this->tahun_lulus);
        }

        // Filter Universitas
        if ($this->universitas_id && $this->universitas_id !== 'all') {
            $query->where('universitas_id', $this->universitas_id);
        }

        // Filter Jenjang Karir (Pekerjaan)
        if ($this->jenjang_karir && $this->jenjang_karir !== 'all') {
            if ($this->jenjang_karir === 'bekerja') {
                $query->whereNotNull('pekerjaan')->where('pekerjaan', '!=', '');
            } elseif ($this->jenjang_karir === 'kuliah') {
                $query->whereNotNull('universitas_id');
            } elseif ($this->jenjang_karir === 'wirausaha') {
                $query->where(function($q) {
                    $q->where('pekerjaan', 'LIKE', '%wirausaha%')
                      ->orWhere('pekerjaan', 'LIKE', '%entrepreneur%')
                      ->orWhere('pekerjaan', 'LIKE', '%pengusaha%')
                      ->orWhere('perusahaan', 'LIKE', '%sendiri%')
                      ->orWhere('pekerjaan', 'LIKE', '%freelance%')
                      ->orWhere('pekerjaan', 'LIKE', '%owner%');
                });
            }
        }

        $alumni = $query->orderBy('tahun_lulus', 'desc')
                        ->orderBy('nama_lengkap')
                        ->get();

        // Generate nama file
        $filename = 'data-alumni';
        if ($this->tahun_lulus && $this->tahun_lulus !== 'all') {
            $filename .= '-angkatan-' . $this->tahun_lulus;
        }
        if ($this->universitas_id && $this->universitas_id !== 'all') {
            $universitas = Universitas::find($this->universitas_id);
            if ($universitas) {
                $filename .= '-' . str_replace(' ', '-', $universitas->akronim ?? $universitas->nama);
            }
        }
        if ($this->jenjang_karir && $this->jenjang_karir !== 'all') {
            $filename .= '-' . $this->jenjang_karir;
        }
        $filename .= '-' . date('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('exports.alumni-pdf', compact('alumni'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($filename);
    }
}