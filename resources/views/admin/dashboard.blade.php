{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-50 pb-12 px-4 md:px-8">

    {{-- Header dengan Animasi Typing --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 id="dashboard-title" class="text-3xl font-extrabold text-gray-800 tracking-tight min-h-[40px]">
                <!-- Akan diisi oleh JavaScript -->
            </h1>
            <div class="text-gray-500 mt-1 flex items-center gap-2 flex-wrap">
                <span id="greeting-text" class="text-lg min-w-[200px]"></span>
                <span class="text-gray-400 mx-2 hidden md:inline">|</span>
                <span id="current-time" class="text-lg font-mono bg-white px-3 py-1 rounded-lg shadow-sm border min-w-[300px]"></span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="flex items-center gap-2 bg-white border border-red-200 text-red-600 px-5 py-2.5 rounded-xl font-semibold shadow-sm hover:bg-red-50 hover:shadow-md transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Logout
            </button>
        </form>
    </div>

    {{-- QUICK ACTION ROW 1 --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

        {{-- Upload Berita --}}
        <a href="{{ route('admin.berita.create') }}"
           class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-4 text-white">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm group-hover:scale-110 transition duration-300">
                    <x-entypo-news class="w-8 h-8 drop-shadow-lg" />
                </div>
                <div>
                    <p class="text-lg font-bold">Upload Berita</p>
                    <p class="text-sm opacity-80">Tambah berita terbaru</p>
                </div>
            </div>
        </a>

        {{-- Kelola Biodata Guru dan Pegawai --}}
        <a href="{{ route('admin.pegawai.index') }}"
           class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-600 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-4 text-white">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm group-hover:scale-110 transition duration-300">
                    <x-fluentui-people-edit-20-o class="w-8 h-8 drop-shadow-lg" />
                </div>
                <div>
                    <p class="text-lg font-bold">Kelola Biodata</p>
                    <p class="text-sm opacity-80">Guru & Pegawai</p>
                </div>
            </div>
        </a>

        {{-- Kelola Statistik --}}
        <a href="{{ route('admin.statistik.index') }}"
           class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-purple-500 to-indigo-600 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-4 text-white">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm group-hover:scale-110 transition duration-300">
                    <svg class="w-8 h-8 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-bold">Kelola Statistik</p>
                    <p class="text-sm opacity-80">Data & Rekap Siswa</p>
                </div>
            </div>
        </a>

        {{-- Tambah Ekskul --}}
        <a href="{{ route('admin.ekstrakurikuler.create') }}"
           class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-orange-500 to-orange-600 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-4 text-white">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm group-hover:scale-110 transition duration-300">
                    <x-mdi-shoe-sneaker class="w-8 h-8 drop-shadow-lg" />
                </div>
                <div>
                    <p class="text-lg font-bold">Tambah Ekskul</p>
                    <p class="text-sm opacity-80">Tambah kegiatan baru</p>
                </div>
            </div>
        </a>
    </div>

    {{-- QUICK ACTION ROW 2 --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-14">

        {{-- Kelola Alumni --}}
        <a href="{{ route('admin.alumni.index') }}"
           class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-rose-500 to-rose-600 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-4 text-white">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm group-hover:scale-110 transition duration-300">
                    <x-fas-graduation-cap class="w-8 h-8 drop-shadow-lg" />
                </div>
                <div>
                    <p class="text-lg font-bold">Kelola Alumni</p>
                    <p class="text-sm opacity-80">Data & Verifikasi Alumni</p>
                </div>
            </div>
        </a>

        {{-- Kelola Universitas --}}
        <a href="{{ route('admin.alumni.universitas') }}"
           class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-cyan-500 to-blue-500 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-4 text-white">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm group-hover:scale-110 transition duration-300">
                    <svg class="w-8 h-8 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-bold">Kelola Universitas</p>
                    <p class="text-sm opacity-80">Data & Logo Universitas</p>
                </div>
            </div>
        </a>

        {{-- Kelola Fasilitas --}}
        <a href="{{ route('admin.fasilitas.index') }}"
           class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-blue-400 to-cyan-500 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-4 text-white">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm group-hover:scale-110 transition duration-300">
                    <svg class="w-8 h-8 drop-shadow-lg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-bold">Kelola Fasilitas</p>
                    <p class="text-sm opacity-80">Sarana & Prasarana</p>
                </div>
            </div>
        </a>

        {{-- Kelola Galeri --}}
        <a href="{{ route('admin.galeri.index') }}"
           class="group relative overflow-hidden p-6 rounded-3xl bg-gradient-to-br from-pink-500 to-rose-500 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-center gap-4 text-white">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm group-hover:scale-110 transition duration-300">
                    <x-grommet-gallery class="w-8 h-8 drop-shadow-lg" />
                </div>
                <div>
                    <p class="text-lg font-bold">Kelola Galeri</p>
                    <p class="text-sm opacity-80">Foto Kegiatan</p>
                </div>
            </div>
        </a>
    </div>

    {{-- RINGKASAN & LOG AKTIVITAS --}}
    <div class="grid lg:grid-cols-3 gap-8">
        {{-- Kolom Kiri: Ringkasan Data Sekolah --}}
        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold text-gray-700 mb-6">
                Ringkasan Data Sekolah
            </h2>

            <div class="grid md:grid-cols-2 gap-6">
                {{-- BERITA --}}
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3 text-blue-600">
                            <x-entypo-news class="w-6 h-6"/>
                            <h3 class="text-gray-600 font-medium">Berita</h3>
                        </div>
                        <p class="text-4xl font-black text-gray-800 my-2">{{ $beritas->count() }}</p>
                        @if($beritas && $beritas->count() > 0)
                            <p class="text-sm text-gray-700 italic truncate">"{{ $beritas->first()->judul }}"</p>
                            <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($beritas->first()->tanggal)->diffForHumans() }}</p>
                        @else
                            <p class="text-sm text-gray-400 italic">Belum ada berita</p>
                        @endif
                    </div>
                    <a href="{{ route('admin.berita.index') }}" class="block text-center py-3 bg-gray-50 text-blue-600 font-bold hover:bg-blue-50 transition">Lihat Semua Berita →</a>
                </div>

                {{-- BIODATA GURU & PEGAWAI --}}
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3 text-emerald-600">
                            <x-fluentui-people-edit-20-o class="w-6 h-6"/>
                            <h3 class="text-gray-600 font-medium">Guru & Pegawai</h3>
                        </div>
                        <p class="text-4xl font-black text-gray-800 my-2">{{ $totalPegawai }}</p>
                        <p class="text-sm text-gray-700">Total tenaga pendidik dan kependidikan</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full">{{ $totalGuru }} Guru</span>
                            <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full">{{ $totalStaff }} Staff</span>
                        </div>
                        @if($pegawaiTerbaru->count() > 0)
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-2">Terbaru:</p>
                            <div class="space-y-2">
                                @foreach($pegawaiTerbaru as $p)
                                <div class="flex items-center gap-2">
                                    @if($p->foto)<img src="{{ asset('storage/' . $p->foto) }}" class="w-6 h-6 rounded-full object-cover">
                                    @else<div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-[8px]">No</div>@endif
                                    <span class="text-sm text-gray-700 truncate">{{ $p->nama }}</span>
                                    <span class="text-xs px-1.5 py-0.5 rounded-full 
                                        @if($p->jabatan == 'Kepala Sekolah') bg-purple-100 text-purple-700
                                        @elseif($p->jabatan == 'Wakil Kepala Sekolah') bg-orange-100 text-orange-700
                                        @elseif($p->jabatan == 'Guru') bg-blue-100 text-blue-700
                                        @else bg-green-100 text-green-700 @endif
                                    ">{{ $p->jabatan }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('admin.pegawai.index') }}" class="block text-center py-3 bg-gray-50 text-emerald-600 font-bold hover:bg-emerald-50 transition">Kelola Biodata →</a>
                </div>

                {{-- STATISTIK --}}
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3 text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <h3 class="text-gray-600 font-medium">Statistik Siswa</h3>
                        </div>
                        <p class="text-4xl font-black text-gray-800 my-2">{{ $totalSiswa ?? 0 }}</p>
                        <p class="text-sm text-gray-700">Total siswa aktif</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">{{ $siswaKelas10 ?? 0 }} Kelas 10</span>
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">{{ $siswaKelas11 ?? 0 }} Kelas 11</span>
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full">{{ $siswaKelas12 ?? 0 }} Kelas 12</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.statistik.index') }}" class="block text-center py-3 bg-gray-50 text-purple-600 font-bold hover:bg-purple-50 transition">Kelola Statistik →</a>
                </div>

                {{-- ALUMNI --}}
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3 text-rose-600">
                            <x-fas-graduation-cap class="w-6 h-6"/>
                            <h3 class="text-gray-600 font-medium">Alumni</h3>
                        </div>
                        <p class="text-4xl font-black text-gray-800 my-2">{{ $totalAlumni ?? 0 }}</p>
                        <p class="text-sm text-gray-700">Total alumni terdaftar</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-rose-100 text-rose-700 text-xs rounded-full">{{ $alumniPending ?? 0 }} Menunggu</span>
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">{{ $alumniApproved ?? 0 }} Disetujui</span>
                        </div>
                        @if(isset($alumniTerbaru) && $alumniTerbaru->count() > 0)
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-2">Pendaftaran terbaru:</p>
                            <div class="space-y-2">
                                @foreach($alumniTerbaru as $a)
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-700 truncate">{{ $a->nama_lengkap }}</span>
                                    <span class="text-xs text-gray-400">Lulus {{ $a->tahun_lulus }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('admin.alumni.index') }}" class="block text-center py-3 bg-gray-50 text-rose-600 font-bold hover:bg-rose-50 transition">Kelola Alumni →</a>
                </div>

                {{-- FASILITAS --}}
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3 text-cyan-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="text-gray-600 font-medium">Fasilitas</h3>
                        </div>
                        <p class="text-4xl font-black text-gray-800 my-2">{{ $totalFasilitas ?? 0 }}</p>
                        <p class="text-sm text-gray-700">Total fasilitas sekolah</p>
                        @if(isset($fasilitasTerbaru) && $fasilitasTerbaru->count() > 0)
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-2">Fasilitas terbaru:</p>
                            <div class="space-y-2">
                                @foreach($fasilitasTerbaru as $f)
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-700 truncate">{{ $f->nama }}</span>
                                    <span class="text-xs px-1.5 py-0.5 bg-cyan-100 text-cyan-700 rounded-full">{{ $f->kategori_label ?? $f->kategori }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('admin.fasilitas.index') }}" class="block text-center py-3 bg-gray-50 text-cyan-600 font-bold hover:bg-cyan-50 transition">Kelola Fasilitas →</a>
                </div>

                {{-- GALERI --}}
                <div class="bg-white rounded-2xl shadow-sm border overflow-hidden hover:shadow-md transition">
                    <div class="p-6">
                        <div class="flex items-center gap-3 mb-3 text-pink-600">
                            <x-grommet-gallery class="w-6 h-6"/>
                            <h3 class="text-gray-600 font-medium">Galeri</h3>
                        </div>
                        <p class="text-4xl font-black text-gray-800 my-2">{{ $totalGaleri ?? 0 }}</p>
                        <p class="text-sm text-gray-700">Total galeri kegiatan</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="px-2 py-1 bg-pink-100 text-pink-700 text-xs rounded-full">{{ $galeriFeatured ?? 0 }} Featured</span>
                            <span class="px-2 py-1 bg-pink-100 text-pink-700 text-xs rounded-full">{{ $totalGaleriViews ?? 0 }} Views</span>
                        </div>
                        @if(isset($galeriTerbaru) && $galeriTerbaru->count() > 0)
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 mb-2">Galeri terbaru:</p>
                            <div class="space-y-2">
                                @foreach($galeriTerbaru as $g)
                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-gray-700 truncate">{{ $g->judul }}</span>
                                    <span class="text-xs text-gray-400">{{ $g->tanggal_kegiatan?->format('d M') ?? '-' }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('admin.galeri.index') }}" class="block text-center py-3 bg-gray-50 text-pink-600 font-bold hover:bg-pink-50 transition">Kelola Galeri →</a>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Log Aktivitas Admin --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border overflow-hidden sticky top-4">
                <div class="p-6 border-b bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Log Aktivitas
                            </h2>
                            <p class="text-sm text-gray-500 mt-1">Riwayat perubahan data</p>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">Demo Mode</span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="mb-6 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <h3 class="text-sm font-bold text-blue-800 mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Status Fitur
                        </h3>
                        <p class="text-xs text-blue-700">✅ Berita, Pegawai, Statistik, Ekstrakurikuler, Alumni, Fasilitas & Galeri sudah aktif.</p>
                    </div>

                    <div class="space-y-4">
                        <h3 class="text-sm font-bold text-gray-700">Aktivitas Terbaru</h3>
                        
                        <div class="relative pl-8 pb-4 border-l-2 border-dashed border-gray-200">
                            <div class="absolute left-[-9px] top-0 w-4 h-4 rounded-full bg-blue-500 ring-4 ring-blue-50"></div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-mono text-gray-500">{{ now()->format('H:i') }} WIB</span>
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full">LOGIN</span>
                                </div>
                                <p class="text-sm text-gray-700">Admin login ke dashboard</p>
                                <p class="text-xs text-gray-500 mt-1">Oleh: Admin</p>
                            </div>
                        </div>

                        <div class="relative pl-8 pb-4 border-l-2 border-dashed border-gray-200">
                            <div class="absolute left-[-9px] top-0 w-4 h-4 rounded-full bg-cyan-500 ring-4 ring-cyan-50"></div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-mono text-gray-500">{{ now()->subHour()->format('H:i') }} WIB</span>
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">CREATE</span>
                                </div>
                                <p class="text-sm text-gray-700">Menambahkan fasilitas baru</p>
                                <p class="text-xs text-gray-500 mt-1">Oleh: Admin</p>
                            </div>
                        </div>

                        <div class="relative pl-8 pb-2">
                            <div class="absolute left-[-9px] top-0 w-4 h-4 rounded-full bg-pink-500 ring-4 ring-pink-50"></div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-mono text-gray-500">{{ now()->subHours(2)->format('H:i') }} WIB</span>
                                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 text-xs rounded-full">UPLOAD</span>
                                </div>
                                <p class="text-sm text-gray-700">Mengupload galeri kegiatan</p>
                                <p class="text-xs text-gray-500 mt-1">Oleh: Admin</p>
                            </div>
                        </div>
                    </div>

                    <a href="#" onclick="alert('Fitur log aktivitas akan segera diimplementasikan')"
                       class="block text-center py-3 mt-6 bg-gray-50 text-gray-600 font-bold rounded-xl hover:bg-gray-100 transition border border-gray-200 text-sm">
                       Lihat Semua Aktivitas →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script untuk Animasi Typing --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dashboardTitles = ['Admin Dashboard ✨'];
    const greetings = ['Selamat datang kembali, Admin 👋'];

    const titleElement = document.getElementById('dashboard-title');
    const greetingElement = document.getElementById('greeting-text');
    const timeElement = document.getElementById('current-time');

    let titleIndex = 0, greetingIndex = 0;
    let titleCharIndex = 0, greetingCharIndex = 0;
    let isTitleDeleting = false, isGreetingDeleting = false;
    let titleSpeed = 100, greetingSpeed = 100;

    function updateClock() {
        const now = new Date();
        timeElement.innerHTML = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) + 
                               ' ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }

    function typeTitle() {
        const currentTitle = dashboardTitles[titleIndex];
        if (isTitleDeleting) {
            titleElement.textContent = currentTitle.substring(0, titleCharIndex - 1);
            titleCharIndex--;
            titleSpeed = 50;
        } else {
            titleElement.textContent = currentTitle.substring(0, titleCharIndex + 1);
            titleCharIndex++;
            titleSpeed = 100;
        }
        if (!isTitleDeleting && titleCharIndex === currentTitle.length) {
            titleSpeed = 3000;
            isTitleDeleting = true;
        } else if (isTitleDeleting && titleCharIndex === 0) {
            isTitleDeleting = false;
            titleIndex = (titleIndex + 1) % dashboardTitles.length;
            titleSpeed = 200;
        }
        setTimeout(typeTitle, titleSpeed);
    }

    function typeGreeting() {
        const currentGreeting = greetings[greetingIndex];
        if (isGreetingDeleting) {
            greetingElement.textContent = currentGreeting.substring(0, greetingCharIndex - 1);
            greetingCharIndex--;
            greetingSpeed = 50;
        } else {
            greetingElement.textContent = currentGreeting.substring(0, greetingCharIndex + 1);
            greetingCharIndex++;
            greetingSpeed = 70;
        }
        if (!isGreetingDeleting && greetingCharIndex === currentGreeting.length) {
            greetingSpeed = 2500;
            isGreetingDeleting = true;
        } else if (isGreetingDeleting && greetingCharIndex === 0) {
            isGreetingDeleting = false;
            greetingIndex = (greetingIndex + 1) % greetings.length;
            greetingSpeed = 150;
        }
        setTimeout(typeGreeting, greetingSpeed);
    }

    setTimeout(() => { typeTitle(); typeGreeting(); }, 500);
    updateClock();
    setInterval(updateClock, 1000);
});
</script>

<style>
#dashboard-title::after, #greeting-text::after { content: '|'; animation: blink 1s infinite; margin-left: 2px; color: #3b82f6; font-weight: normal; }
#greeting-text::after { color: #6b7280; }
@keyframes blink { 0%, 50% { opacity: 1; } 51%, 100% { opacity: 0; } }
#current-time { font-family: 'JetBrains Mono', 'Fira Code', monospace; background: linear-gradient(145deg, #ffffff, #f8fafc); border: 1px solid #e2e8f0; color: #1e293b; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
.sticky { position: sticky; top: 1rem; z-index: 10; }
</style>

@endsection