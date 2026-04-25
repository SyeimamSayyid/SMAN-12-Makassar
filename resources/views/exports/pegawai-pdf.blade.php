<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Pegawai</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm;
        }
        
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            margin: 0; 
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #1e3a8a;
            padding-bottom: 15px;
        }
        
        h1 { 
            color: #1e3a8a; 
            margin: 0 0 5px 0;
            font-size: 28px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .subtitle { 
            color: #64748b; 
            margin: 0;
            font-size: 14px;
        }
        
        .subtitle span {
            background: #3b82f6;
            color: white;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-left: 10px;
        }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 12px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        th { 
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
            color: white; 
            padding: 12px 10px; 
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 11px;
        }
        
        td { 
            padding: 12px 10px; 
            border-bottom: 1px solid #e2e8f0; 
            vertical-align: middle;
        }
        
        tr:nth-child(even) { 
            background: #f8fafc; 
        }
        
        tr:hover {
            background: #eff6ff;
        }
        
        /* Foto Bulat Sempurna */
        .foto-cell {
            text-align: center;
            width: 60px;
        }
        
        .foto-container {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            border: 3px solid #3b82f6;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            background: #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .foto {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .foto-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 20px;
            text-transform: uppercase;
        }
        
        /* Badge Jabatan */
        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .badge-kepsek { background: #8b5cf6; color: white; }
        .badge-wakepsek { background: #f97316; color: white; }
        .badge-guru { background: #3b82f6; color: white; }
        .badge-guru-bk { background: #14b8a6; color: white; }
        .badge-perpus { background: #f59e0b; color: white; }
        .badge-lab { background: #06b6d4; color: white; }
        .badge-eskul { background: #6366f1; color: white; }
        .badge-staff { background: #10b981; color: white; }
        
        .nip {
            font-family: 'Courier New', monospace;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            display: inline-block;
        }
        
        .footer {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px solid #cbd5e1;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #64748b;
        }
        
        .footer-left {
            display: flex;
            gap: 20px;
        }
        
        .footer-right {
            text-align: right;
        }
        
        .page-number {
            font-weight: bold;
            color: #1e3a8a;
        }
        
        /* Statistik kecil */
        .stats {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-bottom: 10px;
        }
        
        .stat-item {
            font-size: 11px;
            color: #64748b;
        }
        
        .stat-item strong {
            color: #1e3a8a;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA PEGAWAI & GURU</h1>
        <p class="subtitle">
            SMAN 12 Makassar 
            <span>Total: {{ $pegawai->count() }} Pegawai</span>
        </p>
    </div>
    
    {{-- Statistik Cepat --}}
    @php
        $totalGuru = $pegawai->whereIn('jabatan', ['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru', 'Guru BK', 'Kepala Perpustakaan', 'Kepala Laboratorium', 'Pembimbing Ekstrakurikuler'])->count();
        $totalStaff = $pegawai->where('jabatan', 'Staff TU')->count();
    @endphp
    <div class="stats">
        <div class="stat-item">👨‍🏫 Guru: <strong>{{ $totalGuru }}</strong></div>
        <div class="stat-item">📋 Staff: <strong>{{ $totalStaff }}</strong></div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="7%">No</th>
                <th width="10%">Foto</th>
                <th width="15%">NIP</th>
                <th width="25%">Nama</th>
                <th width="18%">Jabatan</th>
                <th width="25%">Pangkat / Bidang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai as $index => $p)
            <tr>
                <td style="text-align: center; font-weight: 600; color: #64748b;">{{ $index + 1 }}</td>
                <td class="foto-cell">
                    @if($p->foto)
                        @php 
                            $fotoPath = public_path('storage/' . $p->foto); 
                        @endphp
                        @if(file_exists($fotoPath))
                            <div class="foto-container">
                                <img src="{{ $fotoPath }}" class="foto" alt="{{ $p->nama }}">
                            </div>
                        @else
                            <div class="foto-placeholder">
                                {{ strtoupper(substr($p->nama, 0, 1)) }}
                            </div>
                        @endif
                    @else
                        <div class="foto-placeholder">
                            {{ strtoupper(substr($p->nama, 0, 1)) }}
                        </div>
                    @endif
                </td>
                <td>
                    @if($p->nip)
                        <span class="nip">{{ $p->nip }}</span>
                    @else
                        <span style="color: #94a3b8;">-</span>
                    @endif
                </td>
                <td style="font-weight: 500;">{{ $p->nama }}</td>
                <td>
                    @php
                        $badgeClass = match($p->jabatan) {
                            'Kepala Sekolah' => 'badge-kepsek',
                            'Wakil Kepala Sekolah' => 'badge-wakepsek',
                            'Guru' => 'badge-guru',
                            'Guru BK' => 'badge-guru-bk',
                            'Kepala Perpustakaan' => 'badge-perpus',
                            'Kepala Laboratorium' => 'badge-lab',
                            'Pembimbing Ekstrakurikuler' => 'badge-eskul',
                            'Staff TU' => 'badge-staff',
                            default => ''
                        };
                        $jabatanLabel = match($p->jabatan) {
                            'Kepala Sekolah' => '🎓 Kepala Sekolah',
                            'Wakil Kepala Sekolah' => '📋 Wakil Kepala',
                            'Guru' => '📚 Guru',
                            'Guru BK' => '💬 Guru BK',
                            'Kepala Perpustakaan' => '📖 Kepala Perpus',
                            'Kepala Laboratorium' => '🔬 Kepala Lab',
                            'Pembimbing Ekstrakurikuler' => '🏆 Pembimbing Eskul',
                            'Staff TU' => '📁 Staff TU',
                            default => $p->jabatan
                        };
                    @endphp
                    <span class="badge {{ $badgeClass }}">{{ $jabatanLabel }}</span>
                </td>
                <td>{{ $p->pangkat ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <div class="footer-left">
            <span>📅 Dicetak: {{ now()->format('d M Y H:i') }} WIB</span>
            <span>👤 Diekspor oleh: {{ auth()->user()->name ?? 'Administrator' }}</span>
        </div>
        <div class="footer-right">
            <span class="page-number">Halaman 1/1</span>
        </div>
    </div>
</body>
</html>