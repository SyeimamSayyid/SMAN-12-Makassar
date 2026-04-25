<?php

namespace App\Exports;

use App\Models\Pegawai;
use Barryvdh\DomPDF\Facade\Pdf;

class PegawaiExportPDF
{
    protected $jabatan;

    public function __construct($jabatan = null)
    {
        $this->jabatan = $jabatan;
    }

    public function download()
    {
        $query = Pegawai::aktif()->orderBy('jabatan')->orderBy('nama');

        if ($this->jabatan && $this->jabatan !== 'all') {
            $query->where('jabatan', $this->jabatan);
        }

        $pegawai = $query->get();

        $filename = 'data-pegawai';
        if ($this->jabatan && $this->jabatan !== 'all') {
            $filename .= '-' . str_replace(' ', '-', $this->jabatan);
        }
        $filename .= '-' . date('Y-m-d') . '.pdf';

        $pdf = Pdf::loadView('exports.pegawai-pdf', compact('pegawai'));
        
        // ✅ Set paper A4 Landscape
        $pdf->setPaper('A4', 'landscape');
        
        return $pdf->download($filename);
    }
}