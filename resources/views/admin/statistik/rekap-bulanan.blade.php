@extends('layouts.admin')

@section('title', 'Rekap Bulanan & Tahunan')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </span>
                    Rekap Bulanan & Tahunan
                </h1>
                <p class="text-gray-500 mt-2 ml-14">Rekapitulasi data siswa per bulan dan tahunan</p>
            </div>
            <div class="flex gap-3">
                <form method="POST" action="{{ route('admin.statistik.rekap-bulanan.generate-all', ['tahun' => $tahun, 'semester' => $semester]) }}" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 bg-purple-600 text-white rounded-xl font-medium shadow-lg hover:bg-purple-700 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Generate Semua
                    </button>
                </form>
                <button onclick="toggleForm()" 
                        class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-medium shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Generate Bulanan
                </button>
                <a href="{{ route('admin.statistik.index') }}" 
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-all">
                    ← Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 text-green-700">{{ session('success') }}</div>
        @endif

        {{-- Filter --}}
        <div class="mb-6 flex justify-end gap-3">
            <form method="GET" class="flex items-center gap-3">
                <select name="tahun" class="border rounded-lg px-3 py-2">
                    @for($y = date('Y'); $y >= 2020; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <select name="semester" class="border rounded-lg px-3 py-2">
                    <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Ganjil (Jul-Des)</option>
                    <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Genap (Jan-Jun)</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Filter</button>
            </form>
        </div>

        {{-- Form Generate Bulanan --}}
        <div id="generateForm" class="bg-white rounded-2xl shadow-sm p-6 mb-8 hidden">
            <h3 class="font-bold mb-4">Generate Rekap Bulanan</h3>
            <form action="{{ route('admin.statistik.rekap-bulanan.generate') }}" method="POST">
                @csrf
                <div class="grid md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm mb-1">Bulan</label>
                        <select name="bulan" required class="w-full border rounded-lg px-3 py-2">
                            @php $bulanList = $semester == 'Ganjil' ? range(7, 12) : range(1, 6); @endphp
                            @foreach($bulanList as $b)
                                @php $nama = Carbon\Carbon::create()->month($b)->locale('id')->monthName; @endphp
                                <option value="{{ $b }}">{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Tahun</label>
                        <input type="number" name="tahun" required value="{{ $tahun }}" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Semester</label>
                        <select name="semester" required class="w-full border rounded-lg px-3 py-2">
                            <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block text-sm mb-1">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="2" class="w-full border rounded-lg px-3 py-2"></textarea>
                </div>
                <div class="mt-4 flex gap-3">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">Generate</button>
                    <button type="button" onclick="toggleForm()" class="bg-gray-200 px-6 py-2 rounded-lg">Batal</button>
                </div>
            </form>
        </div>

        {{-- REKAP TAHUNAN --}}
        @if($rekapTahunan)
        <div class="mb-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm">📊</span>
                Rekap Tahunan {{ $tahun }} ({{ $semester }})
            </h2>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-xl p-4 text-center shadow-sm">
                    <p class="text-gray-500 text-sm">Total Awal</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $rekapTahunan['awal']['total'] }}</p>
                </div>
                <div class="bg-green-50 rounded-xl p-4 text-center shadow-sm">
                    <p class="text-gray-500 text-sm">Total Masuk</p>
                    <p class="text-2xl font-bold text-green-600">+{{ $rekapTahunan['masuk']['total'] }}</p>
                </div>
                <div class="bg-red-50 rounded-xl p-4 text-center shadow-sm">
                    <p class="text-gray-500 text-sm">Total Keluar</p>
                    <p class="text-2xl font-bold text-red-600">-{{ $rekapTahunan['keluar']['total'] }}</p>
                </div>
                <div class="bg-orange-50 rounded-xl p-4 text-center shadow-sm">
                    <p class="text-gray-500 text-sm">Lulus</p>
                    <p class="text-2xl font-bold text-orange-600">{{ $rekapTahunan['lulus'] }}</p>
                </div>
                <div class="bg-blue-50 rounded-xl p-4 text-center shadow-sm">
                    <p class="text-gray-500 text-sm">Total Akhir</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $rekapTahunan['akhir']['total'] }}</p>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm bg-white rounded-xl overflow-hidden">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Kelas</th>
                            <th class="px-4 py-2 text-center">Awal</th>
                            <th class="px-4 py-2 text-center">Masuk</th>
                            <th class="px-4 py-2 text-center">Keluar</th>
                            <th class="px-4 py-2 text-center">Lulus</th>
                            <th class="px-4 py-2 text-center">Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="px-4 py-2 font-medium">Kelas 10</td>
                            <td class="px-4 py-2 text-center">{{ $rekapTahunan['awal']['kelas10'] }}</td>
                            <td class="px-4 py-2 text-center text-green-600">+{{ $rekapTahunan['masuk']['kelas10'] }}</td>
                            <td class="px-4 py-2 text-center text-red-600">-{{ $rekapTahunan['keluar']['kelas10'] }}</td>
                            <td class="px-4 py-2 text-center">-</td>
                            <td class="px-4 py-2 text-center font-medium">{{ $rekapTahunan['akhir']['kelas10'] }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="px-4 py-2 font-medium">Kelas 11</td>
                            <td class="px-4 py-2 text-center">{{ $rekapTahunan['awal']['kelas11'] }}</td>
                            <td class="px-4 py-2 text-center text-green-600">+{{ $rekapTahunan['masuk']['kelas11'] }}</td>
                            <td class="px-4 py-2 text-center text-red-600">-{{ $rekapTahunan['keluar']['kelas11'] }}</td>
                            <td class="px-4 py-2 text-center">-</td>
                            <td class="px-4 py-2 text-center font-medium">{{ $rekapTahunan['akhir']['kelas11'] }}</td>
                        </tr>
                        <tr class="border-t">
                            <td class="px-4 py-2 font-medium">Kelas 12</td>
                            <td class="px-4 py-2 text-center">{{ $rekapTahunan['awal']['kelas12'] }}</td>
                            <td class="px-4 py-2 text-center text-green-600">+{{ $rekapTahunan['masuk']['kelas12'] }}</td>
                            <td class="px-4 py-2 text-center text-red-600">-{{ $rekapTahunan['keluar']['kelas12'] }}</td>
                            <td class="px-4 py-2 text-center text-orange-600">{{ $rekapTahunan['lulus'] }}</td>
                            <td class="px-4 py-2 text-center font-medium">{{ $rekapTahunan['akhir']['kelas12'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 grid grid-cols-3 gap-4 text-sm">
                <div class="bg-white rounded-lg p-3 text-center">
                    <span class="text-gray-500">Laki-laki:</span>
                    <span class="font-bold text-blue-600">{{ $rekapTahunan['laki'] }}</span>
                </div>
                <div class="bg-white rounded-lg p-3 text-center">
                    <span class="text-gray-500">Perempuan:</span>
                    <span class="font-bold text-pink-600">{{ $rekapTahunan['perempuan'] }}</span>
                </div>
                <div class="bg-white rounded-lg p-3 text-center">
                    <span class="text-gray-500">% Kelulusan:</span>
                    <span class="font-bold text-green-600">{{ $rekapTahunan['persentase_kelulusan'] }}%</span>
                </div>
            </div>
        </div>
        @endif

        {{-- Tabel Rekap Bulanan --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b">
                <h3 class="font-bold text-gray-800">Rekap Bulanan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-3 py-3 text-left">Bulan</th>
                            <th colspan="4" class="px-3 py-3 text-center border-l">Kelas 10</th>
                            <th colspan="4" class="px-3 py-3 text-center border-l">Kelas 11</th>
                            <th colspan="4" class="px-3 py-3 text-center border-l">Kelas 12</th>
                            <th colspan="2" class="px-3 py-3 text-center border-l">Total</th>
                            <th class="px-3 py-3 text-center">Aksi</th>
                        </tr>
                        <tr class="bg-gray-50 text-xs">
                            <th></th>
                            <th class="px-2 py-1 text-center">Awal</th><th class="px-2 py-1 text-center">M</th><th class="px-2 py-1 text-center">K</th><th class="px-2 py-1 text-center">Akhir</th>
                            <th class="px-2 py-1 text-center border-l">Awal</th><th class="px-2 py-1 text-center">M</th><th class="px-2 py-1 text-center">K</th><th class="px-2 py-1 text-center">Akhir</th>
                            <th class="px-2 py-1 text-center border-l">Awal</th><th class="px-2 py-1 text-center">M</th><th class="px-2 py-1 text-center">K</th><th class="px-2 py-1 text-center">Akhir</th>
                            <th class="px-2 py-1 text-center border-l">Awal</th><th class="px-2 py-1 text-center">Akhir</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($rekapBulanan as $r)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-3 font-medium">{{ $r->nama_bulan }}</td>
                            <td class="px-2 py-3 text-center">{{ $r->kelas10_awal }}</td>
                            <td class="px-2 py-3 text-center text-green-600">+{{ $r->kelas10_masuk }}</td>
                            <td class="px-2 py-3 text-center text-red-600">-{{ $r->kelas10_keluar }}</td>
                            <td class="px-2 py-3 text-center font-medium">{{ $r->kelas10_akhir }}</td>
                            <td class="px-2 py-3 text-center border-l">{{ $r->kelas11_awal }}</td>
                            <td class="px-2 py-3 text-center text-green-600">+{{ $r->kelas11_masuk }}</td>
                            <td class="px-2 py-3 text-center text-red-600">-{{ $r->kelas11_keluar }}</td>
                            <td class="px-2 py-3 text-center font-medium">{{ $r->kelas11_akhir }}</td>
                            <td class="px-2 py-3 text-center border-l">{{ $r->kelas12_awal }}</td>
                            <td class="px-2 py-3 text-center text-green-600">+{{ $r->kelas12_masuk }}</td>
                            <td class="px-2 py-3 text-center text-red-600">-{{ $r->kelas12_keluar }}</td>
                            <td class="px-2 py-3 text-center font-medium">{{ $r->kelas12_akhir }}</td>
                            <td class="px-2 py-3 text-center border-l">{{ $r->total_awal }}</td>
                            <td class="px-2 py-3 text-center font-medium">{{ $r->total_akhir }}</td>
                            <td class="px-3 py-3 text-center">
                                <form action="{{ route('admin.statistik.rekap-bulanan.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus rekap {{ $r->nama_bulan }}?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 text-xs hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="16" class="px-4 py-8 text-center text-gray-400">Belum ada data rekap bulanan</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function toggleForm() {
    document.getElementById('generateForm').classList.toggle('hidden');
}
</script>
@endsection