@extends('layouts.app')

@section('title', $spmb->judul . ' - SPMB SMAN 12 Makassar')

@section('content')

{{-- Hero Section --}}
<section class="relative pt-28 pb-16 overflow-hidden">
    {{-- Background Gradient --}}
    <div class="absolute inset-0 bg-gradient-to-br from-blue-700 via-indigo-800 to-purple-900"></div>
    
    {{-- Animated Circles --}}
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    </div>
    
    {{-- Grid Pattern Overlay --}}
    <div class="absolute inset-0 opacity-10">
        <div class="h-full w-full" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-blue-200 mb-6 animate-fade-in">
            <a href="{{ route('home') }}" class="hover:text-white transition flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Home
            </a>
            <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('spmb.index') }}" class="hover:text-white transition">SPMB</a>
            <svg class="w-4 h-4 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-white/80 truncate max-w-[200px]">{{ $spmb->judul }}</span>
        </div>
        
        {{-- Status Badge --}}
        <div class="mb-4 animate-fade-in">
            @php $status = $spmb->status; @endphp
            <span class="inline-flex items-center gap-1.5 px-4 py-1.5 {{ $status[0] }} rounded-full text-sm font-medium shadow-lg backdrop-blur-sm">
                <span class="w-2 h-2 rounded-full {{ str_contains($status[1], 'Aktif') ? 'bg-green-500 animate-pulse' : (str_contains($status[1], 'Expired') ? 'bg-red-500' : 'bg-gray-500') }}"></span>
                {{ $status[1] }}
            </span>
        </div>
        
        {{-- Title --}}
        <h1 class="text-3xl md:text-5xl font-extrabold text-white mb-6 leading-tight animate-slide-up drop-shadow-lg">
            {{ $spmb->judul }}
        </h1>
        
        {{-- Meta Info --}}
        <div class="flex flex-wrap items-center gap-6 text-sm text-blue-100 animate-fade-in">
            <span class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                {{ $spmb->tanggal_upload->format('d M Y') }}
            </span>
            <span class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Berakhir: {{ $spmb->tanggal_berakhir->format('d M Y') }}
            </span>
            <span class="flex items-center gap-2 bg-white/10 backdrop-blur-sm px-4 py-2 rounded-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                {{ number_format($spmb->views) }} views
            </span>
        </div>
    </div>
    
    {{-- Wave Shape --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="w-full">
            <path fill="#ffffff" fill-opacity="1" d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,48C1120,43,1280,53,1360,58.7L1440,64L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"></path>
        </svg>
    </div>
</section>

{{-- Quick Action Bar --}}
@if($spmb->link_pendaftaran && $spmb->is_active && now()->lte($spmb->tanggal_berakhir))
<section class="sticky top-20 z-40 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
    <div class="container mx-auto px-6 py-3 flex items-center justify-between">
        <p class="text-sm text-gray-600 hidden md:block">
            <span class="font-medium text-gray-800">SPMB Masih Dibuka!</span> Segera daftarkan diri Anda
        </p>
        <a href="{{ $spmb->link_pendaftaran }}" target="_blank" 
           class="w-full md:w-auto inline-flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-8 py-3 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 animate-pulse hover:animate-none">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Daftar Sekarang
        </a>
    </div>
</section>
@endif

{{-- Main Content --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-4xl mx-auto">
            
            {{-- Foto Utama --}}
            @if($spmb->foto)
            <div class="relative mb-12 group">
                <div class="absolute -inset-4 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-3xl opacity-0 group-hover:opacity-20 blur-xl transition-opacity duration-500"></div>
                <img src="{{ asset('storage/' . $spmb->foto) }}" 
                     alt="{{ $spmb->judul }}" 
                     class="relative w-full rounded-2xl shadow-2xl object-cover max-h-[500px] transform group-hover:scale-[1.01] transition-transform duration-500">
                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent h-32 rounded-b-2xl pointer-events-none"></div>
            </div>
            @endif
            
            {{-- Link Pendaftaran (jika tidak ada sticky bar) --}}
            @if($spmb->link_pendaftaran && !($spmb->is_active && now()->lte($spmb->tanggal_berakhir)))
                <div class="mb-10">
                    <a href="{{ $spmb->link_pendaftaran }}" target="_blank" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-8 py-4 rounded-xl font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Daftar Sekarang
                    </a>
                </div>
            @endif
            
            {{-- Deskripsi --}}
            @if($spmb->deskripsi)
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Deskripsi</h2>
                </div>
                <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-2xl p-8 border border-gray-100">
                    <div class="prose max-w-none text-gray-700 leading-relaxed whitespace-pre-line text-base">
                        {!! nl2br(e($spmb->deskripsi)) !!}
                    </div>
                </div>
            </div>
            @endif
            
{{-- Video Section --}}
@if($spmb->video && count($spmb->video) > 0)
<div class="mb-12">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Video Terkait</h2>
        <span class="text-sm text-gray-400 bg-gray-100 px-3 py-1 rounded-full">{{ count($spmb->video) }} video</span>
    </div>
    
    <div class="grid md:grid-cols-2 gap-6">
        @foreach($spmb->video as $video)
        <div class="group bg-white rounded-2xl overflow-hidden shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
            
            {{-- Container Video --}}
            @if($video['type'] === 'youtube')
                {{-- YouTube: tetap 16:9 --}}
                <div class="aspect-video bg-black relative">
                    <iframe src="{{ $video['url'] }}" 
                            class="w-full h-full" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
            @else
                {{-- Upload: menyesuaikan aspect ratio asli --}}
                <div class="bg-black relative flex items-center justify-center max-h-[500px]">
                    <video src="{{ asset('storage/' . $video['url']) }}" 
                           class="w-full h-auto max-h-[500px] object-contain" 
                           controls
                           preload="metadata">
                    </video>
                </div>
            @endif
            
            {{-- Caption --}}
            @if(isset($video['caption']) && $video['caption'])
                <div class="p-4">
                    <div class="flex items-start gap-2">
                        <span class="text-red-500 mt-0.5">🎬</span>
                        <p class="text-sm text-gray-700 font-medium">{{ $video['caption'] }}</p>
                    </div>
                </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif
            
            {{-- Galeri Foto --}}
            @if($spmb->galeri && count($spmb->galeri) > 0)
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Galeri Foto</h2>
                    <span class="text-sm text-gray-400 bg-gray-100 px-3 py-1 rounded-full">{{ count($spmb->galeri) }} foto</span>
                </div>
                
                {{-- Grid Galeri --}}
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($spmb->galeri as $index => $img)
                    <div class="group relative overflow-hidden rounded-xl cursor-pointer bg-gray-100"
                         onclick="openLightbox({{ $index }})">
                        <img src="{{ asset('storage/' . $img) }}" 
                             alt="Galeri {{ $index + 1 }}" 
                             class="w-full aspect-square object-cover transform group-hover:scale-110 transition-transform duration-500">
                        
                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-between p-4">
                            <span class="text-white text-sm font-medium">{{ $index + 1 }}/{{ count($spmb->galeri) }}</span>
                            <span class="bg-white/20 backdrop-blur-sm rounded-full p-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </span>
                        </div>
                        
                        {{-- Badge Nomor --}}
                        <span class="absolute top-2 left-2 bg-black/50 backdrop-blur-sm text-white text-xs px-2 py-1 rounded-lg">
                            {{ $index + 1 }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            {{-- Footer Info --}}
            <div class="border-t border-gray-200 pt-8 mt-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Informasi ini berlaku hingga {{ $spmb->tanggal_berakhir->format('d F Y') }}</span>
                    </div>
                    <a href="{{ route('spmb.index') }}" class="flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                        </svg>
                        Kembali ke daftar SPMB
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Lightbox --}}
<div id="lightbox" class="fixed inset-0 bg-black/95 hidden z-50 flex items-center justify-center p-4" onclick="closeLightbox()">
    {{-- Close Button --}}
    <button class="absolute top-4 right-4 text-white/80 hover:text-white text-4xl z-10 transition">
        &times;
    </button>
    
    {{-- Previous Button --}}
    <button class="absolute left-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white text-3xl z-10 transition p-2" 
            onclick="event.stopPropagation(); navigateLightbox(-1)">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>
    
    {{-- Image --}}
    <img id="lightboxImg" class="max-w-full max-h-[90vh] object-contain rounded-lg">
    
    {{-- Next Button --}}
    <button class="absolute right-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white text-3xl z-10 transition p-2" 
            onclick="event.stopPropagation(); navigateLightbox(1)">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>
    
    {{-- Counter --}}
    <div class="absolute bottom-4 left-1/2 -translate-x-1/2 text-white/80 text-sm bg-black/50 backdrop-blur-sm px-4 py-2 rounded-full">
        <span id="lightboxCounter">1 / 1</span>
    </div>
</div>

<style>
@keyframes fade-in { from { opacity: 0; } to { opacity: 1; } }
@keyframes slide-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
.animate-fade-in { animation: fade-in 0.6s ease-out forwards; }
.animate-slide-up { animation: slide-up 0.8s ease-out 0.2s forwards; opacity: 0; }
</style>

<script>
const galleryImages = @json($spmb->galeri ?? []);
let currentIndex = 0;

function openLightbox(index) {
    currentIndex = index;
    updateLightboxImage();
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.getElementById('lightbox').classList.remove('flex');
    document.body.style.overflow = '';
}

function navigateLightbox(direction) {
    currentIndex = (currentIndex + direction + galleryImages.length) % galleryImages.length;
    updateLightboxImage();
}

function updateLightboxImage() {
    document.getElementById('lightboxImg').src = '/storage/' + galleryImages[currentIndex];
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