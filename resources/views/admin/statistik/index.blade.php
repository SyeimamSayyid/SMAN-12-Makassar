@extends('layouts.admin')

@section('title', 'Kelola Statistik Sekolah')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <span class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </span>
                    Kelola Statistik Sekolah
                </h1>
                <p class="text-gray-500 mt-2 ml-14">Atur data statistik siswa, mutasi, dan rekap</p>
            </div>
            <div class="flex gap-3">
                {{-- Rekap Bulanan --}}
                <a href="{{ route('admin.statistik.rekap-bulanan') }}" 
                   class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-green-600 to-emerald-700 text-white rounded-xl font-medium shadow-lg hover:shadow-xl hover:from-green-700 hover:to-emerald-800 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Rekap Bulanan
                </a>
                {{-- Rekap Tahunan --}}
                <a href="{{ route('admin.statistik.rekap-tahunan') }}" 
                   class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl font-medium shadow-lg hover:shadow-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Rekap Tahunan
                </a>
                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-medium shadow-sm hover:bg-gray-50 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
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
        </div>
        @endif

        {{-- Filter Tahun --}}
        <div class="mb-6 flex justify-end">
            <div class="bg-white rounded-xl shadow-sm p-1.5 inline-flex border border-gray-200">
                <form method="GET" class="flex items-center gap-2">
                    <span class="text-sm text-gray-500 pl-2">Tahun Ajaran:</span>
                    <select name="tahun" class="border-0 bg-gray-50 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}/{{ $y+1 }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        {{-- Cards Statistik Cepat --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            @php
                $totalSiswa = ($kelasData['10']->jumlah_siswa ?? 0) + ($kelasData['11']->jumlah_siswa ?? 0) + ($kelasData['12']->jumlah_siswa ?? 0);
                $totalRombel = ($kelasData['10']->jumlah_rombel ?? 0) + ($kelasData['11']->jumlah_rombel ?? 0) + ($kelasData['12']->jumlah_rombel ?? 0);
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Siswa</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ number_format($totalSiswa) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Rombel</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalRombel }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Laki-laki</p>
                        <p class="text-3xl font-bold text-blue-600 mt-1">{{ number_format($pieData['laki']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Perempuan</p>
                        <p class="text-3xl font-bold text-pink-600 mt-1">{{ number_format($pieData['perempuan']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-pink-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grafik Preview --}}
        <div class="grid lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></span>
                    Jumlah Siswa per Kelas
                </h3>
                <canvas id="barChartPreview" height="200" class="w-full"></canvas>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-gradient-to-b from-pink-500 to-rose-600 rounded-full"></span>
                    Perbandingan Gender
                </h3>
                <canvas id="pieChartPreview" height="200" class="w-full"></canvas>
            </div>
        </div>

        {{-- Form Edit Statistik & Mutasi --}}
        <div class="grid lg:grid-cols-2 gap-6">
            {{-- Form Edit Statistik --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Data Statistik
                    </h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.statistik.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tahun_ajaran" value="{{ $tahun }}/{{ $tahun+1 }}">
                        <input type="hidden" name="semester" value="Ganjil">
                        
                        @foreach(['10', '11', '12'] as $kelas)
                        @php $data = $kelasData[$kelas] ?? null; @endphp
                        <div class="mb-5 p-5 bg-gray-50/80 rounded-xl border border-gray-100">
                            <h3 class="font-bold text-gray-700 mb-3 flex items-center gap-2">
                                <span class="w-6 h-6 bg-blue-500 text-white rounded-lg flex items-center justify-center text-xs">{{ $kelas }}</span>
                                Kelas {{ $kelas }}
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Jumlah Siswa</label>
                                    <input type="number" name="kelas_{{ $kelas }}_jumlah" value="{{ $data->jumlah_siswa ?? 0 }}" 
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Rombel</label>
                                    <input type="number" name="kelas_{{ $kelas }}_rombel" value="{{ $data->jumlah_rombel ?? 1 }}" 
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Laki-laki</label>
                                    <input type="number" name="kelas_{{ $kelas }}_laki" value="{{ $data->laki_laki ?? 0 }}" 
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Perempuan</label>
                                    <input type="number" name="kelas_{{ $kelas }}_perempuan" value="{{ $data->perempuan ?? 0 }}" 
                                           class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg">
                            <span class="flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1-4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Simpan Perubahan
                            </span>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Form Mutasi & Riwayat --}}
            <div class="space-y-6">
                {{-- Form Tambah Mutasi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Tambah Mutasi Siswa
                        </h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.statistik.mutasi.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                        <select name="kelas" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                                            <option value="10">Kelas 10</option>
                                            <option value="11">Kelas 11</option>
                                            <option value="12">Kelas 12</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                                        <select name="jenis_mutasi" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                                            <option value="masuk">📥 Masuk</option>
                                            <option value="keluar">📤 Keluar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                        <input type="number" name="jumlah" min="1" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                        <input type="date" name="tanggal" required value="{{ date('Y-m-d') }}" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                    <input type="text" name="keterangan" placeholder="Alasan mutasi (opsional)" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-green-500 focus:border-transparent bg-white">
                                </div>
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-2.5 rounded-xl font-medium hover:from-green-700 hover:to-emerald-700 transition-all duration-300">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Tambah Mutasi
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Riwayat Mutasi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 bg-gradient-to-r from-amber-50 to-yellow-50 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Riwayat Mutasi Terbaru
                        </h2>
                    </div>
                    <div class="p-4">
                        <div class="max-h-80 overflow-y-auto">
                            @if($riwayatMutasi->count() > 0)
                            <div class="space-y-2">
                                @foreach($riwayatMutasi as $m)
                                <div class="flex items-center justify-between p-3 rounded-xl {{ $m->jenis_mutasi == 'masuk' ? 'bg-green-50/50' : 'bg-red-50/50' }} border border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 {{ $m->jenis_mutasi == 'masuk' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} rounded-lg flex items-center justify-center">
                                            @if($m->jenis_mutasi == 'masuk')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                            </svg>
                                            @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                            </svg>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">
                                                Kelas {{ $m->kelas }} - 
                                                <span class="{{ $m->jenis_mutasi == 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $m->jenis_mutasi == 'masuk' ? '+' : '-' }}{{ $m->jumlah }} siswa
                                                </span>
                                            </p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($m->tanggal)->format('d M Y') }} • {{ $m->keterangan ?: 'Tanpa keterangan' }}</p>
                                        </div>
                                    </div>
                                    <form action="{{ route('admin.statistik.mutasi.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus data mutasi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-gray-400 hover:text-red-500 transition p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                <p class="text-gray-400 text-sm">Belum ada riwayat mutasi</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
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
document.addEventListener('DOMContentLoaded', function() {
    // Bar Chart
    new Chart(document.getElementById('barChartPreview'), {
        type: 'bar',
        data: {
            labels: ['Kelas 10', 'Kelas 11', 'Kelas 12'],
            datasets: [{
                label: 'Jumlah Siswa',
                data: [
                    {{ $kelasData['10']->jumlah_siswa ?? 0 }},
                    {{ $kelasData['11']->jumlah_siswa ?? 0 }},
                    {{ $kelasData['12']->jumlah_siswa ?? 0 }}
                ],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                borderRadius: 8,
                barPercentage: 0.6,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
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
    
    // Pie Chart
    new Chart(document.getElementById('pieChartPreview'), {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [{{ $pieData['laki'] }}, {{ $pieData['perempuan'] }}],
                backgroundColor: ['#3b82f6', '#ec4899'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15 } }
            },
            cutout: '60%'
        }
    });
});
</script>
@endsection