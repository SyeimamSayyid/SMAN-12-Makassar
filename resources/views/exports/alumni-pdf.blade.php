<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Alumni</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
        }
        h1 { 
            color: #1e3a8a; 
            text-align: center; 
            margin-bottom: 5px; 
        }
        .subtitle { 
            text-align: center; 
            color: #64748b; 
            margin-bottom: 20px; 
            font-size: 12px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 10px; 
        }
        th { 
            background: #3b82f6; 
            color: white; 
            padding: 8px 5px; 
            text-align: left; 
        }
        td { 
            padding: 6px 5px; 
            border-bottom: 1px solid #e2e8f0; 
            vertical-align: middle; 
        }
        tr:nth-child(even) { 
            background: #f8fafc; 
        }
        .logo { 
            width: 25px; 
            height: 25px; 
            object-fit: contain; 
            margin-right: 5px; 
        }
        .univ-cell { 
            display: flex; 
            align-items: center; 
        }
        .footer { 
            margin-top: 20px; 
            text-align: right; 
            font-size: 9px; 
            color: #94a3b8; 
        }
    </style>
</head>
<body>
    <h1>DATA ALUMNI</h1>
    <p class="subtitle">SMAN 12 Makassar - Total: {{ $alumni->count() }} Alumni</p>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="18%">Nama</th>
                <th width="22%">Universitas</th>
                <th width="15%">Program Studi</th>
                <th width="8%">Lulus</th>
                <th width="12%">No. HP</th>
                <th width="20%">Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumni as $index => $a)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $a->nama_lengkap }}</td>
                <td>
                    <div class="univ-cell">
                        @if($a->universitas && $a->universitas->logo)
                            @php
                                $logoPath = public_path('storage/' . $a->universitas->logo);
                            @endphp
                            @if(file_exists($logoPath))
                                <img src="{{ $logoPath }}" class="logo">
                            @endif
                        @endif
                        {{ $a->universitas->nama ?? '-' }}
                    </div>
                </td>
                <td>{{ $a->program_studi ?? '-' }}</td>
                <td>{{ $a->tahun_lulus }}</td>
                <td>{{ $a->no_hp ?? '-' }}</td>
                <td>{{ $a->kota ?? '' }}{{ $a->kota && $a->provinsi ? ', ' : '' }}{{ $a->provinsi ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d M Y H:i') }} WIB</p>
        <p>Diekspor oleh: {{ auth()->user()->name ?? 'Administrator' }}</p>
    </div>
</body>
</html>