@extends('layouts.app')

@section('title', 'Semua Berita - Website Resmi Sekolah')

@section('content')

<!-- HERO BERITA DENGAN BACKGROUND KORAN -->
<section class="pt-28 pb-16 relative overflow-hidden">
    
    <!-- Background Pattern Koran -->
    <div class="absolute inset-0 newspaper-bg"></div>
    
    <!-- Overlay Gradient -->
    <div class="absolute inset-0 bg-gradient-to-b from-blue-900/80 via-blue-800/70 to-blue-900/80"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Berita & Informasi</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">Informasi terkini seputar kegiatan, prestasi, dan pengumuman penting dari sekolah kami</p>
            
            <!-- Breadcrumb -->
            <div class="flex items-center justify-center gap-2 mt-6 text-sm text-blue-200">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                <span class="text-white">Berita</span>
            </div>
        </div>
    </div>
</section>

<!-- SEARCH & FILTER -->
<section class="py-6 bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
    <div class="container mx-auto px-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Search Bar -->
            <div class="relative w-full md:w-96">
                <input type="text" 
                       id="searchBerita" 
                       placeholder="Cari berita..." 
                       value="{{ request('search') }}"
                       class="w-full px-5 py-3 pl-12 rounded-xl border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            
            <!-- Filter Kategori & Sort -->
            <div class="flex gap-3 flex-wrap justify-center">
                <select id="kategoriFilter" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium border-0 focus:ring-2 focus:ring-blue-200">
                    <option value="all" {{ request('kategori') == 'all' || !request('kategori') ? 'selected' : '' }}>Semua Kategori</option>
                    @foreach($kategoris ?? [] as $kat)
                        <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                    @endforeach
                </select>
                
                <select id="sortFilter" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium border-0 focus:ring-2 focus:ring-blue-200">
                    <option value="tanggal-desc" {{ request('sort_by') == 'tanggal' && request('sort_order', 'desc') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                    <option value="tanggal-asc" {{ request('sort_by') == 'tanggal' && request('sort_order') == 'asc' ? 'selected' : '' }}>Terlama</option>
                    <option value="views-desc" {{ request('sort_by') == 'views' ? 'selected' : '' }}>Terpopuler</option>
                    <option value="judul-asc" {{ request('sort_by') == 'judul' && request('sort_order') == 'asc' ? 'selected' : '' }}>A-Z</option>
                    <option value="judul-desc" {{ request('sort_by') == 'judul' && request('sort_order') == 'desc' ? 'selected' : '' }}>Z-A</option>
                </select>
            </div>
        </div>
    </div>
</section>

<!-- DAFTAR BERITA -->
<section class="py-16 min-h-screen" style="background-color: #f5f0e8;">
    <div class="container mx-auto px-6">
        
        <!-- Info Jumlah Berita -->
        <div class="mb-8 flex items-center justify-between">
            <p class="text-gray-700">
                Menampilkan <span class="font-semibold">{{ $beritas->count() }}</span> dari <span class="font-semibold">{{ $beritas->total() }}</span> berita
            </p>
            
            @if(request('search') || request('kategori'))
            <a href="{{ route('berita.index') }}" class="text-blue-600 hover:text-blue-700 text-sm flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                Reset Filter
            </a>
            @endif
        </div>

        @if($beritas->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8" id="beritaGrid">
            @foreach ($beritas as $berita)
            @php
                $images = [];
                if (is_array($berita->images)) {
                    $images = $berita->images;
                } elseif (is_string($berita->images)) {
                    $images = json_decode($berita->images, true) ?? [];
                }
                $firstImage = !empty($images) ? $images[0] : null;
            @endphp
            
            <div class="berita-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer transform hover:-translate-y-2 overflow-hidden border border-gray-200" 
                 data-kategori="{{ $berita->kategori ?? 'Umum' }}"
                 onclick="showBeritaDetail({{ $berita->id }})">
                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                    @if(!empty($firstImage))
                        @php
                            $imageSrc = $firstImage;
                            if (!str_starts_with($firstImage, 'data:image') && !filter_var($firstImage, FILTER_VALIDATE_URL)) {
                                $imageSrc = asset('storage/' . $firstImage);
                            }
                        @endphp
                        <img src="{{ $imageSrc }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $berita->judul }}" onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\' viewBox=\'0 0 400 300\'%3E%3Crect width=\'400\' height=\'300\' fill=\'%23f3f4f6\'/%3E%3Ctext x=\'50%25\' y=\'50%25\' text-anchor=\'middle\' dy=\'.3em\' fill=\'%239ca3af\' font-size=\'14\'%3EGambar tidak tersedia%3C/text%3E%3C/svg%3E'">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                            <svg class="w-16 h-16 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                    @endif
                    
                    <!-- Date Badge -->
                    <div class="absolute top-4 left-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-1.5 rounded-xl text-xs font-semibold shadow-lg">
                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}
                    </div>
                    
                    <!-- Kategori & Views Badge -->
                    <div class="absolute top-4 right-4 flex gap-2">
                        @if($berita->kategori)
                        <span class="bg-white/90 backdrop-blur-sm text-blue-700 px-3 py-1 rounded-lg text-xs font-semibold shadow-md">
                            {{ $berita->kategori }}
                        </span>
                        @endif
                        @if($berita->views > 0)
                        <span class="bg-black/50 backdrop-blur-sm text-white px-3 py-1 rounded-lg text-xs flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            {{ $berita->views }}
                        </span>
                        @endif
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-2 line-clamp-2 hover:text-blue-600 transition">{{ $berita->judul }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">{{ strip_tags(\Illuminate\Support\Str::limit($berita->isi, 120)) }}</p>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-100 to-blue-200 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <span class="text-sm text-gray-500 font-medium">{{ $berita->author }}</span>
                        </div>
                        
                        <div class="flex items-center gap-1 text-blue-600 group-hover:gap-2 transition-all duration-300">
                            <span class="text-sm font-semibold">Baca</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- No Results Message (hidden by default) -->
        <div id="noResults" class="hidden bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 p-16 rounded-3xl text-center">
            <div class="w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-gray-700 text-xl font-semibold">Tidak ada berita yang ditemukan</p>
            <p class="text-gray-500 mt-2">Coba ubah kata kunci atau filter kategori</p>
            <button onclick="resetFilters()" class="mt-4 text-blue-600 hover:text-blue-700 font-medium">Reset Filter</button>
        </div>
        
        <!-- Pagination -->
        <div class="mt-12">
            {{ $beritas->appends(request()->query())->links() }}
        </div>
        @else
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 p-16 rounded-3xl text-center">
            <div class="w-24 h-24 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
            <p class="text-gray-700 text-xl font-semibold">Belum ada berita</p>
            <p class="text-gray-500 mt-2">Silahkan tunggu update informasi dari kami</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-600 hover:text-blue-700 font-medium">Kembali ke Beranda</a>
        </div>
        @endif
    </div>
</section>

<!-- SIDEBAR BERITA TERBARU (Fixed di kanan pada desktop) -->
@if(isset($beritaTerbaru) && $beritaTerbaru->count() > 0)
<div class="hidden lg:block fixed right-6 bottom-6 z-40">
    <div class="bg-white rounded-2xl shadow-2xl p-4 w-80 border border-gray-200">
        <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            Berita Terbaru
        </h4>
        <div class="space-y-3 max-h-80 overflow-y-auto">
            @foreach($beritaTerbaru as $item)
            <a href="javascript:void(0)" onclick="showBeritaDetail({{ $item->id }})" class="flex gap-3 p-2 hover:bg-gray-50 rounded-lg transition group">
                <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                    @php
                        $img = is_array($item->images) ? ($item->images[0] ?? null) : (json_decode($item->images, true)[0] ?? null);
                    @endphp
                    @if($img)
                        <img src="{{ str_starts_with($img, 'data:image') || filter_var($img, FILTER_VALIDATE_URL) ? $img : asset('storage/' . $img) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16"/></svg>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 group-hover:text-blue-600 transition line-clamp-2">{{ $item->judul }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- MODAL BERITA -->
<div id="beritaModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm">
    <div id="modalContainer" class="absolute bottom-0 w-full h-[95vh] bg-white rounded-t-3xl shadow-2xl transform translate-y-full transition-transform duration-500 ease-out flex flex-col">
        <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto mt-3 mb-2 cursor-pointer hover:bg-gray-400 transition" onclick="closeModal()"></div>
        <button onclick="closeModal()" class="absolute right-4 top-4 z-20 bg-white rounded-full p-2 shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <div id="beritaContent" class="flex-1 overflow-y-auto">
            <div id="loadingState" class="flex flex-col items-center justify-center h-full py-16">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div>
                <p class="mt-4 text-gray-500">Memuat berita...</p>
            </div>
            <div id="beritaDetailContent" class="hidden">
                <div class="relative bg-black/5">
                    <div id="imageSlider" class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth"></div>
                    <button onclick="prevImage()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg transition-all duration-300">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button onclick="nextImage()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg transition-all duration-300">
                        <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    <div id="imageCounter" class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">1/1</div>
                </div>
                <div class="p-6">
                    <h1 id="modalTitle" class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 leading-tight"></h1>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-6 pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><span id="modalDate"></span></div>
                        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                        <div class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg><span id="modalAuthor" class="font-medium text-blue-600"></span></div>
                        @if($berita->kategori ?? false)
                        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                        <div class="flex items-center gap-1"><span id="modalKategori" class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full text-xs"></span></div>
                        @endif
                    </div>
                    <div id="modalContentText" class="text-gray-700 leading-relaxed space-y-4"></div>
                    <div id="modalGallery" class="mt-8 pt-4 border-t border-gray-100">
                        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>Galeri Foto</h3>
                        <div id="galleryThumbnails" class="grid grid-cols-3 md:grid-cols-5 gap-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ZOOM IMAGE -->
<div id="zoomViewer" class="fixed inset-0 bg-black/95 hidden z-[60] flex items-center justify-center cursor-pointer" onclick="closeZoom()">
    <img id="zoomImage" class="max-w-[90vw] max-h-[90vh] object-contain">
    <button class="absolute top-4 right-4 text-white bg-white/20 rounded-full p-2 hover:bg-white/30 transition">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
</div>

<style>
/* Background Koran Pattern */
.newspaper-bg {
    background-color: #2d3748;
    background-image: 
        repeating-linear-gradient(0deg, rgba(255,255,255,0.05) 0px, rgba(255,255,255,0.05) 1px, transparent 1px, transparent 30px),
        repeating-linear-gradient(90deg, rgba(255,255,255,0.03) 0px, rgba(255,255,255,0.03) 1px, transparent 1px, transparent 50px),
        radial-gradient(circle at 20% 30%, rgba(255,255,255,0.08) 0%, transparent 30%),
        radial-gradient(circle at 80% 70%, rgba(255,255,255,0.06) 0%, transparent 40%),
        linear-gradient(135deg, #1a202c 0%, #2d3748 50%, #1a202c 100%);
    position: relative;
}

.newspaper-bg::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        repeating-linear-gradient(45deg, rgba(0,0,0,0.02) 0px, rgba(0,0,0,0.02) 2px, transparent 2px, transparent 8px),
        repeating-linear-gradient(-45deg, rgba(255,255,255,0.01) 0px, rgba(255,255,255,0.01) 1px, transparent 1px, transparent 15px);
    pointer-events: none;
}

.newspaper-bg::after {
    content: "BERITA • INFORMASI • BERITA • INFORMASI • BERITA • INFORMASI • BERITA • INFORMASI •";
    position: absolute;
    bottom: 10px;
    left: 0;
    right: 0;
    font-size: 12px;
    color: rgba(255,255,255,0.05);
    white-space: nowrap;
    overflow: hidden;
    letter-spacing: 3px;
}

.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
#imageSlider::-webkit-scrollbar { display: none; }
#imageSlider { -ms-overflow-style: none; scrollbar-width: none; }
.snap-x > div { min-width: 100%; height: 280px; scroll-snap-align: start; }
@media(min-width: 768px){ .snap-x > div { height: 420px; } }
.berita-card.hidden { display: none; }
</style>

<script>
let currentImages = [];
let currentIndex = 0;

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const kategoriFilter = document.getElementById('kategoriFilter');
    const sortFilter = document.getElementById('sortFilter');
    const searchInput = document.getElementById('searchBerita');
    
    function updateUrlAndReload() {
        const params = new URLSearchParams(window.location.search);
        
        // Update search
        if (searchInput && searchInput.value) {
            params.set('search', searchInput.value);
        } else {
            params.delete('search');
        }
        
        // Update kategori
        if (kategoriFilter && kategoriFilter.value && kategoriFilter.value !== 'all') {
            params.set('kategori', kategoriFilter.value);
        } else {
            params.delete('kategori');
        }
        
        // Update sort
        if (sortFilter && sortFilter.value) {
            const [sortBy, sortOrder] = sortFilter.value.split('-');
            params.set('sort_by', sortBy);
            params.set('sort_order', sortOrder);
        }
        
        window.location.href = window.location.pathname + '?' + params.toString();
    }
    
    // Search with debounce
    let searchTimeout;
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(updateUrlAndReload, 500);
        });
    }
    
    // Filter and sort change
    if (kategoriFilter) kategoriFilter.addEventListener('change', updateUrlAndReload);
    if (sortFilter) sortFilter.addEventListener('change', updateUrlAndReload);
});

function resetFilters() {
    window.location.href = '{{ route("berita.index") }}';
}

// Modal functions
function getImageUrl(img) {
    if (!img) return null;
    if (img.startsWith('data:image')) return img;
    if (img.startsWith('http')) return img;
    return '/storage/' + img;
}

function showBeritaDetail(id) {
    const modal = document.getElementById('beritaModal');
    const container = document.getElementById('modalContainer');
    const loadingState = document.getElementById('loadingState');
    const detailContent = document.getElementById('beritaDetailContent');
    
    modal.classList.remove('hidden');
    loadingState.classList.remove('hidden');
    detailContent.classList.add('hidden');
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => container.classList.remove('translate-y-full'), 50);
    
    fetch(`/berita/${id}`)
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const berita = res.data;
                currentImages = (berita.images || []).filter(img => img && img.trim() !== '');
                
                document.getElementById('modalTitle').textContent = berita.judul;
                document.getElementById('modalAuthor').textContent = berita.author;
                
                const date = new Date(berita.tanggal);
                document.getElementById('modalDate').textContent = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                
                const kategoriEl = document.getElementById('modalKategori');
                if (kategoriEl && berita.kategori) {
                    kategoriEl.textContent = berita.kategori;
                }
                
                document.getElementById('modalContentText').innerHTML = (berita.isi || '').split('\n').filter(p => p.trim()).map(p => `<p>${p}</p>`).join('');
                
                const slider = document.getElementById('imageSlider');
                slider.innerHTML = '';
                
                if (currentImages.length === 0) {
                    slider.innerHTML = `<div class="snap-center flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200"><div class="text-center"><svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><p class="text-gray-500 mt-2">Tidak ada gambar</p></div></div>`;
                    document.getElementById('imageCounter').style.display = 'none';
                } else {
                    currentImages.forEach((img) => {
                        const imgUrl = getImageUrl(img);
                        const div = document.createElement('div');
                        div.className = "snap-center flex items-center justify-center bg-black/5";
                        div.innerHTML = `<img src="${imgUrl}" class="w-full h-full object-contain cursor-pointer" onclick="zoomImage('${imgUrl}')">`;
                        slider.appendChild(div);
                    });
                    document.getElementById('imageCounter').style.display = 'block';
                    updateImageCounter();
                }
                
                const gallery = document.getElementById('galleryThumbnails');
                gallery.innerHTML = '';
                if (currentImages.length > 0) {
                    currentImages.forEach((img, idx) => {
                        const imgUrl = getImageUrl(img);
                        const el = document.createElement('div');
                        el.className = "overflow-hidden rounded-xl cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-md";
                        el.innerHTML = `<img src="${imgUrl}" class="w-full h-24 object-cover" onclick="scrollToImage(${idx})">`;
                        gallery.appendChild(el);
                    });
                } else {
                    gallery.innerHTML = '<p class="text-gray-500 text-sm col-span-5 text-center py-4">Tidak ada foto galeri</p>';
                }
                
                loadingState.classList.add('hidden');
                detailContent.classList.remove('hidden');
            } else {
                loadingState.innerHTML = '<div class="text-red-500 text-center py-8">Gagal memuat berita</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadingState.innerHTML = '<div class="text-red-500 text-center py-8">Terjadi kesalahan</div>';
        });
}

function closeModal() {
    const modal = document.getElementById('beritaModal');
    const container = document.getElementById('modalContainer');
    container.classList.add('translate-y-full');
    setTimeout(() => {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        document.getElementById('loadingState').classList.remove('hidden');
        document.getElementById('beritaDetailContent').classList.add('hidden');
    }, 300);
}

function updateImageCounter() {
    const slider = document.getElementById('imageSlider');
    if (!slider || currentImages.length === 0) return;
    const itemWidth = slider.clientWidth;
    if (itemWidth > 0) {
        currentIndex = Math.round(slider.scrollLeft / itemWidth);
        document.getElementById('imageCounter').textContent = `${currentIndex + 1}/${currentImages.length}`;
    }
}

function scrollToImage(index) {
    const slider = document.getElementById('imageSlider');
    slider.scrollTo({ left: index * slider.clientWidth, behavior: "smooth" });
    setTimeout(updateImageCounter, 300);
}

function prevImage() { if (currentIndex > 0) scrollToImage(currentIndex - 1); }
function nextImage() { if (currentIndex < currentImages.length - 1) scrollToImage(currentIndex + 1); }

function zoomImage(src) {
    document.getElementById('zoomViewer').classList.remove('hidden');
    document.getElementById('zoomImage').src = src;
    document.body.style.overflow = 'hidden';
}

function closeZoom() {
    document.getElementById('zoomViewer').classList.add('hidden');
    document.body.style.overflow = '';
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('imageSlider')?.addEventListener('scroll', updateImageCounter);
    document.addEventListener('keydown', (e) => { if (e.key === "Escape") { closeModal(); closeZoom(); } });
    document.getElementById('beritaModal')?.addEventListener('click', function(e) { if (e.target === this) closeModal(); });
});
</script>

@endsection