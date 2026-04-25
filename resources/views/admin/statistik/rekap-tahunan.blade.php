@extends('layouts.admin')

@section('title', 'Rekap Tahunan Statistik')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </span>
                    Rekap Tahunan Statistik
                </h1>
                <p class="text-gray-500 mt-2 ml-14">Rekapitulasi data siswa masuk, keluar, dan lulus per tahun ajaran</p>
            </div>
            <div class="flex gap-3">
                <button onclick="toggleForm()" 
                        class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-medium shadow-lg hover:shadow-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Generate Rekap
                </button>
                <a href="{{ route('admin.statistik.index') }}" 
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        {{-- Alert Success --}}
        @if(session('success'))
        <div class="mb-6 bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 rounded-xl p-4 flex items-center gap-3 animate-fadeIn">
            <div class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-emerald-800 font-medium">{{ session('success') }}</p>
            <button onclick="this.parentElement.remove()" class="ml-auto text-emerald-600 hover:text-emerald-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        @endif

        {{-- Filter Tahun --}}
        <div class="mb-6 flex justify-end">
            <div class="bg-white rounded-xl shadow-sm p-1.5 inline-flex border border-gray-200">
                <form method="GET" class="flex items-center gap-2">
                    <span class="text-sm text-gray-500 pl-2">Tahun Ajaran:</span>
                    <select name="tahun" class="border-0 bg-gray-50 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-purple-500">
                        @for($y = date('Y'); $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}/{{ $y+1 }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-purple-700 transition">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        {{-- Form Generate Rekap --}}
        <div id="generateForm" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8 hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Generate Rekap Tahunan
                </h2>
            </div>
            <div class="p-6">
                <form action="{{ route('admin.statistik.rekap-tahunan.generate') }}" method="POST">
                    @csrf
                    <div class="grid md:grid-cols-3 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran Awal</label>
                            <select name="tahun_ajaran_awal" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                @for($y = date('Y'); $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}/{{ $y+1 }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Semester</label>
                            <select name="semester" required class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Lulus Kelas 12</label>
                            <input type="number" name="lulus_kelas12" required min="0" 
                                   value="{{ $statistikAwal['kelas_12']->jumlah_siswa ?? 0 }}"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Laki-laki</label>
                            <input type="number" name="total_laki" required min="0" 
                                   value="{{ $statistikAwal['total']->laki_laki ?? 0 }}"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Perempuan</label>
                            <input type="number" name="total_perempuan" required min="0"
                                   value="{{ $statistikAwal['total']->perempuan ?? 0 }}"
                                   class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                        </div>
                    </div>
                    
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <textarea name="catatan" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white" 
                                  placeholder="Catatan tambahan (opsional)..."></textarea>
                    </div>
                    
                    {{-- Detail Kelulusan --}}
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-3">
                            <label class="block text-sm font-medium text-gray-700">Detail Kelulusan per Kelas</label>
                            <button type="button" onclick="addDetailKelas()" 
                                    class="text-sm text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Tambah Kelas
                            </button>
                        </div>
                        <div id="detailKelulusan" class="space-y-2">
                            <div class="grid grid-cols-12 gap-2">
                                <input type="text" name="detail_kelas[0][kelas]" placeholder="Kelas (contoh: 12 IPA 1)" 
                                       class="col-span-4 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 bg-white">
                                <input type="number" name="detail_kelas[0][jumlah_siswa]" placeholder="Jumlah" 
                                       class="col-span-3 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 bg-white">
                                <input type="number" name="detail_kelas[0][lulus]" placeholder="Lulus" 
                                       class="col-span-3 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 bg-white">
                                <button type="button" onclick="this.parentElement.remove()" 
                                        class="col-span-2 bg-red-50 text-red-600 rounded-lg px-2 py-2.5 text-sm hover:bg-red-100 transition">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 pt-4 border-t border-gray-100">
                        <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-md">
                            Generate Rekap
                        </button>
                        <button type="button" onclick="toggleForm()" 
                                class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Chart Trend --}}
        @if(!empty($chartData['labels']))
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-1 h-6 bg-gradient-to-b from-purple-500 to-indigo-600 rounded-full"></span>
                Trend Tahunan (Masuk, Keluar, Lulus)
            </h3>
            <canvas id="trendChart" height="100" class="w-full"></canvas>
        </div>
        @endif

        {{-- Tabel Rekap Tahunan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-slate-50 border-b border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Daftar Rekap Tahunan
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tahun Ajaran</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Awal</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Masuk</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Keluar</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Lulus</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Akhir</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Selisih</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">% Lulus</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($rekapTahunan as $r)
                        <tr class="hover:bg-gray-50/50 transition">
                            <td class="px-5 py-4">
                                <div class="font-medium text-gray-800">{{ $r->tahun_ajaran }}</div>
                                <div class="text-xs text-gray-400">{{ $r->semester }}</div>
                            </td>
                            <td class="px-5 py-4 text-center font-medium">{{ number_format($r->total_awal) }}</td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-green-600 font-medium">+{{ number_format($r->total_masuk) }}</span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-red-600 font-medium">-{{ number_format($r->total_keluar) }}</span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="text-orange-600 font-medium">{{ number_format($r->lulus_kelas12) }}</span>
                            </td>
                            <td class="px-5 py-4 text-center font-bold text-gray-800">{{ number_format($r->total_akhir) }}</td>
                            <td class="px-5 py-4 text-center">
                                <span class="font-medium {{ $r->selisih >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $r->selisih >= 0 ? '+' : '' }}{{ number_format($r->selisih) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $r->persentase_kelulusan >= 90 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ $r->persentase_kelulusan }}%
                                </span>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Cetak --}}
                                    <a href="{{ route('admin.statistik.rekap-tahunan.export', $r->id) }}" target="_blank" 
                                       class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Cetak">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                        </svg>
                                    </a>
                                    
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.statistik.rekap-tahunan.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Hapus rekap tahun ajaran {{ $r->tahun_ajaran }}? Data yang dihapus tidak dapat dikembalikan.')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-5 py-12 text-center">
                                <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-400">Belum ada data rekap tahunan</p>
                                <button onclick="toggleForm()" class="mt-3 text-blue-600 hover:text-blue-700 font-medium">
                                    Generate Rekap Sekarang
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function toggleForm() {
    document.getElementById('generateForm').classList.toggle('hidden');
}

let detailCount = 1;
function addDetailKelas() {
    const container = document.getElementById('detailKelulusan');
    const div = document.createElement('div');
    div.className = 'grid grid-cols-12 gap-2';
    div.innerHTML = `
        <input type="text" name="detail_kelas[${detailCount}][kelas]" placeholder="Kelas (contoh: 12 IPA 1)" 
               class="col-span-4 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 bg-white">
        <input type="number" name="detail_kelas[${detailCount}][jumlah_siswa]" placeholder="Jumlah" 
               class="col-span-3 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 bg-white">
        <input type="number" name="detail_kelas[${detailCount}][lulus]" placeholder="Lulus" 
               class="col-span-3 border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 bg-white">
        <button type="button" onclick="this.parentElement.remove()" 
                class="col-span-2 bg-red-50 text-red-600 rounded-lg px-2 py-2.5 text-sm hover:bg-red-100 transition">
            Hapus
        </button>
    `;
    container.appendChild(div);
    detailCount++;
}

@if(!empty($chartData['labels']))
new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [
            { 
                label: 'Masuk', 
                data: {!! json_encode($chartData['masuk']) !!}, 
                borderColor: '#10b981', 
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            },
            { 
                label: 'Keluar', 
                data: {!! json_encode($chartData['keluar']) !!}, 
                borderColor: '#ef4444', 
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#ef4444',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            },
            { 
                label: 'Lulus', 
                data: {!! json_encode($chartData['lulus']) !!}, 
                borderColor: '#f59e0b', 
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#f59e0b',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { 
                position: 'top',
                labels: { usePointStyle: true, padding: 20 }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f3f4f6' }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});
@endif
</script>
@endsection