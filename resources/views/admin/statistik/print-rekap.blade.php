<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Tahunan {{ $rekap->tahun_ajaran }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            padding: 30px; 
            background: #f8fafc;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3b82f6;
        }
        h1 { 
            color: #1e3a8a; 
            font-size: 28px;
            margin-bottom: 5px;
        }
        .subtitle {
            color: #64748b;
            font-size: 16px;
        }
        .summary {
            background: linear-gradient(135deg, #eff6ff 0%, #e0e7ff 100%);
            padding: 25px;
            border-radius: 16px;
            margin: 25px 0;
            border: 1px solid #bfdbfe;
        }
        h2 {
            color: #1e293b;
            font-size: 20px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #cbd5e1;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            text-align: center;
        }
        th {
            background: #f1f5f9;
            color: #334155;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            color: #475569;
        }
        .positive { color: #10b981; font-weight: 600; }
        .negative { color: #ef4444; font-weight: 600; }
        .total-row {
            background: #f8fafc;
            font-weight: 700;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 25px 0;
        }
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        .stat-value {
            font-size: 36px;
            font-weight: bold;
            color: #1e293b;
        }
        .stat-label {
            color: #64748b;
            font-size: 14px;
            margin-top: 5px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: right;
            color: #94a3b8;
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        
        @media print {
            body { background: white; padding: 10px; }
            .container { box-shadow: none; padding: 10px; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 REKAP TAHUNAN STATISTIK</h1>
            <p class="subtitle">SMAN 12 Makassar - Tahun Ajaran {{ $rekap->tahun_ajaran }} ({{ $rekap->semester }})</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value">{{ number_format($rekap->total_awal) }}</div>
                <div class="stat-label">Total Siswa Awal</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">{{ number_format($rekap->total_akhir) }}</div>
                <div class="stat-label">Total Siswa Akhir</div>
            </div>
            <div class="stat-card">
                <div class="stat-value {{ $rekap->selisih >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ $rekap->selisih >= 0 ? '+' : '' }}{{ number_format($rekap->selisih) }}
                </div>
                <div class="stat-label">Selisih</div>
            </div>
        </div>
        
        <h2>📋 Ringkasan per Kelas</h2>
        <table>
            <thead>
                <tr>
                    <th>Keterangan</th>
                    <th>Kelas 10</th>
                    <th>Kelas 11</th>
                    <th>Kelas 12</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Jumlah Awal</strong></td>
                    <td>{{ number_format($rekap->jumlah_awal_kelas10) }}</td>
                    <td>{{ number_format($rekap->jumlah_awal_kelas11) }}</td>
                    <td>{{ number_format($rekap->jumlah_awal_kelas12) }}</td>
                    <td><strong>{{ number_format($rekap->total_awal) }}</strong></td>
                </tr>
                <tr>
                    <td><span class="positive">Mutasi Masuk</span></td>
                    <td class="positive">+{{ number_format($rekap->masuk_kelas10) }}</td>
                    <td class="positive">+{{ number_format($rekap->masuk_kelas11) }}</td>
                    <td class="positive">+{{ number_format($rekap->masuk_kelas12) }}</td>
                    <td class="positive"><strong>+{{ number_format($rekap->total_masuk) }}</strong></td>
                </tr>
                <tr>
                    <td><span class="negative">Mutasi Keluar</span></td>
                    <td class="negative">-{{ number_format($rekap->keluar_kelas10) }}</td>
                    <td class="negative">-{{ number_format($rekap->keluar_kelas11) }}</td>
                    <td class="negative">-{{ number_format($rekap->keluar_kelas12) }}</td>
                    <td class="negative"><strong>-{{ number_format($rekap->total_keluar) }}</strong></td>
                </tr>
                <tr>
                    <td>Lulus</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{ number_format($rekap->lulus_kelas12) }}</td>
                    <td>{{ number_format($rekap->lulus_kelas12) }}</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Jumlah Akhir</strong></td>
                    <td><strong>{{ number_format($rekap->jumlah_akhir_kelas10) }}</strong></td>
                    <td><strong>{{ number_format($rekap->jumlah_akhir_kelas11) }}</strong></td>
                    <td><strong>{{ number_format($rekap->jumlah_akhir_kelas12) }}</strong></td>
                    <td><strong>{{ number_format($rekap->total_akhir) }}</strong></td>
                </tr>
            </tbody>
        </table>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 25px 0;">
            <div style="background: #f0fdf4; padding: 20px; border-radius: 12px;">
                <p style="color: #065f46; font-weight: 600;">📈 Persentase Kelulusan</p>
                <p style="font-size: 42px; font-weight: bold; color: #059669;">{{ $rekap->persentase_kelulusan }}%</p>
                <p style="color: #047857;">{{ $rekap->lulus_kelas12 }} dari {{ $rekap->jumlah_awal_kelas12 }} siswa</p>
            </div>
            <div style="background: #eff6ff; padding: 20px; border-radius: 12px;">
                <p style="color: #1e40af; font-weight: 600;">👥 Komposisi Gender</p>
                <div style="display: flex; justify-content: space-around; margin-top: 15px;">
                    <div style="text-align: center;">
                        <p style="font-size: 28px; font-weight: bold; color: #2563eb;">{{ number_format($rekap->total_laki) }}</p>
                        <p style="color: #3b82f6;">Laki-laki</p>
                    </div>
                    <div style="text-align: center;">
                        <p style="font-size: 28px; font-weight: bold; color: #db2777;">{{ number_format($rekap->total_perempuan) }}</p>
                        <p style="color: #ec4899;">Perempuan</p>
                    </div>
                </div>
            </div>
        </div>
        
        @if($rekap->detailKelulusan->count() > 0)
        <h2>🎓 Detail Kelulusan per Kelas</h2>
        <table>
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Jumlah Siswa</th>
                    <th>Lulus</th>
                    <th>Tidak Lulus</th>
                    <th>Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rekap->detailKelulusan as $d)
                <tr>
                    <td>{{ $d->kelas }}</td>
                    <td>{{ number_format($d->jumlah_siswa) }}</td>
                    <td>{{ number_format($d->lulus) }}</td>
                    <td>{{ number_format($d->tidak_lulus) }}</td>
                    <td>
                        <span class="badge {{ $d->persentase >= 90 ? 'badge-success' : 'badge-warning' }}">
                            {{ $d->persentase }}%
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
        
        @if($rekap->catatan)
        <div style="margin-top: 25px; padding: 15px; background: #fef3c7; border-radius: 12px; border-left: 4px solid #f59e0b;">
            <p style="font-weight: 600; color: #92400e;">📝 Catatan:</p>
            <p style="color: #78350f;">{{ $rekap->catatan }}</p>
        </div>
        @endif
        
        <div class="footer">
            <p>Dicetak pada: {{ now()->format('d M Y H:i:s') }} WIB</p>
            <p>Oleh: {{ auth()->user()->name ?? 'Administrator' }}</p>
        </div>
        
        <div class="no-print" style="text-align: center; margin-top: 30px;">
            <button onclick="window.print()" style="background: #3b82f6; color: white; border: none; padding: 12px 30px; border-radius: 30px; font-size: 16px; font-weight: 600; cursor: pointer; box-shadow: 0 4px 6px rgba(59,130,246,0.3);">
                🖨️ Cetak Halaman
            </button>
            <button onclick="window.close()" style="background: #64748b; color: white; border: none; padding: 12px 30px; border-radius: 30px; font-size: 16px; font-weight: 600; cursor: pointer; margin-left: 10px;">
                Tutup
            </button>
        </div>
    </div>
</body>
</html>