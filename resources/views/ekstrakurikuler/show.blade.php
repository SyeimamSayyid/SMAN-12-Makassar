@extends('layouts.app')

@section('title', $eskul->nama . ' - Ekstrakurikuler SMAN 12 Makassar')

@section('content')

{{-- Sidebar Navigasi --}}
<aside class="fixed left-0 top-0 h-full w-16 bg-white/95 backdrop-blur-md shadow-xl z-50 flex flex-col items-center py-6 gap-5">
    {{-- Logo Sekolah --}}
    <a href="{{ route('home') }}" class="w-10 h-10 rounded-xl overflow-hidden hover:scale-110 transition shadow-md" title="Beranda">
        <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="w-full h-full object-cover">
    </a>
    
    <div class="w-8 h-px bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>
    
    {{-- Kembali ke Daftar Eskul --}}
    <a href="{{ route('ekstrakurikuler.index') }}" class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-blue-100 flex items-center justify-center transition group shadow-sm" title="Daftar Eskul">
        <svg class="w-5 h-5 text-gray-500 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
        </svg>
    </a>
    
    {{-- Home --}}
    <a href="{{ route('home') }}" class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-blue-100 flex items-center justify-center transition group shadow-sm" title="Beranda">
        <svg class="w-5 h-5 text-gray-500 group-hover:text-blue-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
        </svg>
    </a>

    {{-- SPMB --}}
    @php $spmbAktif = \App\Models\Spmb::aktif()->exists(); @endphp
    @if($spmbAktif)
    <a href="{{ route('spmb.index') }}" class="w-10 h-10 rounded-xl bg-blue-100 hover:bg-blue-200 flex items-center justify-center transition group relative shadow-sm" title="SPMB">
        <x-maki-school class="w-5 h-5 text-blue-600" />
        <span class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
    </a>
    @endif
    
    {{-- Spacer --}}
    <div class="flex-1"></div>
    
    {{-- Copyright kecil --}}
    <span class="text-[9px] text-gray-400 -rotate-90 whitespace-nowrap mb-4">SMAN 12 MKS</span>
</aside>

{{-- Main Content Area --}}
<div class="ml-16">

    {{-- Hero Section --}}
    <section class="relative min-h-[70vh] flex items-center overflow-hidden">
        {{-- Background --}}
        @if($eskul->bg_type === 'upload' && $eskul->background)
            <img src="{{ $eskul->background_url }}" class="absolute inset-0 w-full h-full object-cover scale-105" />
            <div class="absolute inset-0 bg-gradient-to-br from-black/80 via-black/50 to-black/70"></div>
        @elseif($eskul->bg_type === 'gradient' && $eskul->bg_color1 && $eskul->bg_color2)
            @php
                $r = intval(substr($eskul->bg_color2, 1, 2), 16);
                $g = intval(substr($eskul->bg_color2, 3, 2), 16);
                $b = intval(substr($eskul->bg_color2, 5, 2), 16);
                $opacity = ($eskul->bg_opacity ?? 50) / 100;
                $rgba = "rgba({$r}, {$g}, {$b}, {$opacity})";
                $direction = $eskul->bg_direction ?? 'to right';
            @endphp
            <div class="absolute inset-0" style="background: linear-gradient({{ $direction }}, {{ $eskul->bg_color1 }}, {{ $rgba }});"></div>
            <div class="absolute inset-0 bg-black/30"></div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-indigo-900"></div>
        @endif
        
        {{-- Pattern Overlay --}}
        <div class="absolute inset-0 opacity-10">
            <div class="h-full w-full" style="background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px); background-size: 30px 30px;"></div>
        </div>
        
        <div class="container mx-auto px-8 relative z-10 py-20">
            <div class="flex flex-col lg:flex-row items-center gap-10 max-w-6xl mx-auto">
                
                {{-- KIRI: Informasi Eskul --}}
                <div class="flex-1 text-white text-center lg:text-left">
                    {{-- Badge --}}
                    @if($eskul->is_active)
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-500/20 backdrop-blur-sm text-green-200 rounded-full text-xs mb-4 border border-green-400/30">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span> Aktif
                    </span>
                    @endif
                    
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-4 leading-tight drop-shadow-lg">{{ $eskul->nama }}</h1>
                    
                    @if($eskul->pembina)
                    <p class="text-white/60 text-lg">Dibimbing oleh <span class="font-semibold text-white">{{ $eskul->pembina }}</span></p>
                    @endif
                    
                    {{-- Quick Stats --}}
                    <div class="flex flex-wrap gap-4 mt-6 justify-center lg:justify-start">
                        @if($eskul->jumlah_anggota)
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3">
                            <div class="text-2xl font-bold">{{ $eskul->jumlah_anggota }}</div>
                            <div class="text-xs text-white/60">Anggota</div>
                        </div>
                        @endif
                        @if($eskul->jadwal)
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3">
                            <div class="text-sm font-medium">{{ $eskul->jadwal }}</div>
                            <div class="text-xs text-white/60">Jadwal</div>
                        </div>
                        @endif
                        @if($eskul->tempat)
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl px-4 py-3">
                            <div class="text-sm font-medium">{{ $eskul->tempat }}</div>
                            <div class="text-xs text-white/60">Tempat</div>
                        </div>
                        @endif
                    </div>
                </div>
                
                {{-- KANAN ATAS: Logo Eskul --}}
                <div class="flex-shrink-0">
                    @if($eskul->logo)
                        <div class="w-40 h-40 md:w-52 md:h-52 rounded-3xl overflow-hidden border-4 border-white/30 shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-500 backdrop-blur-sm">
                            <img src="{{ $eskul->logo_url }}" alt="Logo {{ $eskul->nama }}" class="w-full h-full object-cover">
                        </div>
                    @else
                        <div class="w-40 h-40 md:w-52 md:h-52 rounded-3xl bg-white/10 backdrop-blur-sm border-4 border-white/30 flex items-center justify-center shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-500">
                            <svg class="w-20 h-20 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    {{-- Logo Sekolah Kecil --}}
                    <div class="flex justify-center mt-3">
                        <img src="{{ asset('images/Logo.png') }}" alt="SMAN 12" class="h-6 opacity-50">
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
            <svg class="w-6 h-6 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    {{-- SECTION: Pembina & Deskripsi --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-8">
            <div class="max-w-6xl mx-auto">
                <div class="grid md:grid-cols-5 gap-10">
                    
                    {{-- KIRI: Foto Pembina --}}
                    <div class="md:col-span-2 flex flex-col items-center text-center">
                        @php
                            $pembina = null;
                            if($eskul->pembina) {
                                $pembina = \App\Models\Pegawai::where('nama', $eskul->pembina)->first();
                            }
                        @endphp
                        
                        <div class="relative mb-6">
                            @if($pembina && $pembina->foto)
                                <div class="w-48 h-48 rounded-full overflow-hidden border-4 border-blue-100 shadow-xl">
                                    <img src="{{ asset('storage/' . $pembina->foto) }}" alt="{{ $pembina->nama }}" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -bottom-3 -right-3 bg-blue-600 rounded-full p-2 shadow-lg">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            @else
                                <div class="w-48 h-48 rounded-full bg-gradient-to-br from-blue-100 to-indigo-100 border-4 border-blue-100 shadow-xl flex items-center justify-center">
                                    <svg class="w-20 h-20 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            {{-- Lingkaran dekoratif --}}
                            <div class="absolute -top-4 -left-4 w-16 h-16 border-2 border-blue-200 rounded-full opacity-50"></div>
                            <div class="absolute -bottom-4 -right-4 w-12 h-12 border-2 border-indigo-200 rounded-full opacity-50"></div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800 mb-1">
                            {{ $pembina ? $pembina->nama : ($eskul->pembina ?? 'Pembina') }}
                        </h3>
                        @if($pembina && $pembina->jabatan)
                            <span class="text-sm text-blue-600 font-medium bg-blue-50 px-3 py-1 rounded-full">{{ $pembina->jabatan }}</span>
                        @endif
                        <p class="text-gray-400 text-sm mt-2">Pembina {{ $eskul->nama }}</p>
                        
                        {{-- Social/Contact --}}
                        @if($pembina && $pembina->instagram)
                        <a href="https://instagram.com/{{ $pembina->instagram }}" target="_blank" class="mt-4 inline-flex items-center gap-2 text-pink-500 hover:text-pink-600 transition text-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/></svg>
                            @ {{ $pembina->instagram }}
                        </a>
                        @endif
                    </div>
                    
                    {{-- KANAN: Deskripsi Eskul --}}
                    <div class="md:col-span-3">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-800">Tentang Ekstrakurikuler</h2>
                        </div>
                        
                        @if($eskul->deskripsi)
                            <div class="bg-gradient-to-br from-gray-50 to-blue-50/50 rounded-2xl p-8 border border-gray-100 shadow-sm">
                                <div class="text-gray-700 leading-relaxed text-base">{!! nl2br(e($eskul->deskripsi)) !!}</div>
                            </div>
                        @else
                            <div class="bg-gray-50 rounded-2xl p-8 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p>Belum ada deskripsi untuk ekstrakurikuler ini.</p>
                            </div>
                        @endif
                        
                        {{-- Highlight Cards --}}
                        <div class="grid grid-cols-3 gap-4 mt-6">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center">
                                <div class="text-2xl mb-1">🎯</div>
                                <div class="text-xs text-gray-600 font-medium">Prestasi</div>
                                <div class="text-lg font-bold text-blue-700">{{ count(array_filter($eskul->prestasi ?? [])) }}</div>
                            </div>
                            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 text-center">
                                <div class="text-2xl mb-1">📸</div>
                                <div class="text-xs text-gray-600 font-medium">Galeri</div>
                                <div class="text-lg font-bold text-green-700">{{ count($eskul->galeri ?? []) }}</div>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center">
                                <div class="text-2xl mb-1">👥</div>
                                <div class="text-xs text-gray-600 font-medium">Anggota</div>
                                <div class="text-lg font-bold text-purple-700">{{ $eskul->jumlah_anggota ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION: Prestasi --}}
    @if($eskul->prestasi && count(array_filter($eskul->prestasi)) > 0)
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
        <div class="container mx-auto px-8">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <span class="text-yellow-600 font-semibold text-sm uppercase tracking-wider">Pencapaian</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-4">Prestasi & Penghargaan</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-yellow-500 to-orange-500 mx-auto rounded-full"></div>
                </div>
                <div class="space-y-4">
                    @foreach($eskul->prestasi as $index => $prestasi)
                        @if(!empty(trim($prestasi)))
                        <div class="group flex items-start gap-5 bg-white rounded-2xl shadow-md p-6 border border-gray-100 hover:shadow-xl transition-all duration-300">
                            <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center text-white font-bold text-lg shadow-lg">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <p class="text-gray-700 text-lg">{{ $prestasi }}</p>
                            </div>
                            <div class="text-yellow-400 text-2xl opacity-0 group-hover:opacity-100 transition">🏆</div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION: Galeri --}}
    @if($eskul->galeri && count($eskul->galeri) > 0)
    <section class="py-20 bg-white">
        <div class="container mx-auto px-8">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <span class="text-purple-600 font-semibold text-sm uppercase tracking-wider">Dokumentasi</span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mt-2 mb-4">Galeri Kegiatan</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
                </div>
                
                {{-- Masonry Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($eskul->galeri_urls as $index => $foto)
                    <div class="group relative overflow-hidden rounded-2xl cursor-pointer bg-gray-100 {{ $index === 0 ? 'md:row-span-2' : '' }}"
                         onclick="openLightbox({{ $index }})">
                        <img src="{{ $foto }}" alt="Galeri {{ $eskul->nama }}" 
                             class="w-full {{ $index === 0 ? 'h-full' : 'aspect-square' }} object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-between p-5">
                            <span class="text-white font-medium">{{ $index + 1 }}/{{ count($eskul->galeri_urls) }}</span>
                            <span class="bg-white/20 backdrop-blur-sm rounded-full p-2">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- SECTION: CTA --}}
    <section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700">
        <div class="container mx-auto px-8 text-center text-white">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">Tertarik Bergabung?</h2>
            <p class="text-blue-100 mb-6">Jadilah bagian dari {{ $eskul->nama }} dan kembangkan bakatmu!</p>
            <div class="flex gap-4 justify-center">
                <a href="{{ route('ekstrakurikuler.index') }}" class="bg-white text-blue-600 px-6 py-3 rounded-xl font-semibold hover:bg-gray-100 transition shadow-lg">
                    Lihat Eskul Lain
                </a>
                <a href="{{ route('home') }}" class="bg-blue-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-400 transition border border-blue-400">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </section>

</div>

{{-- Lightbox --}}
<div id="lightbox" class="fixed inset-0 bg-black/95 hidden z-[60] flex items-center justify-center p-4" onclick="closeLightbox()">
    <button class="absolute top-6 right-6 text-white/80 hover:text-white text-4xl z-10 transition">&times;</button>
    <button class="absolute left-6 top-1/2 -translate-y-1/2 text-white/80 hover:text-white text-3xl z-10 p-2" onclick="event.stopPropagation(); navigateLightbox(-1)">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
    </button>
    <img id="lightboxImg" class="max-w-full max-h-[90vh] object-contain rounded-2xl">
    <button class="absolute right-6 top-1/2 -translate-y-1/2 text-white/80 hover:text-white text-3xl z-10 p-2" onclick="event.stopPropagation(); navigateLightbox(1)">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>
    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/80 text-sm bg-black/50 backdrop-blur-sm px-5 py-2.5 rounded-full">
        <span id="lightboxCounter">1 / 1</span>
    </div>
</div>

<script>
const galleryImages = @json($eskul->galeri_urls ?? []);
let currentIndex = 0;

function openLightbox(index) {
    currentIndex = index;
    updateLightboxImage();
    document.getElementById('lightbox').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.body.style.overflow = '';
}
function navigateLightbox(direction) {
    currentIndex = (currentIndex + direction + galleryImages.length) % galleryImages.length;
    updateLightboxImage();
}
function updateLightboxImage() {
    document.getElementById('lightboxImg').src = galleryImages[currentIndex];
    document.getElementById('lightboxCounter').textContent = `${currentIndex + 1} / ${galleryImages.length}`;
}
document.addEventListener('keydown', (e) => {
    const lightbox = document.getElementById('lightbox');
    if (!lightbox.classList.contains('hidden')) {
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') navigateLightbox(-1);
        if (e.key === 'ArrowRight') navigateLightbox(1);
    }
});
</script>

@endsection