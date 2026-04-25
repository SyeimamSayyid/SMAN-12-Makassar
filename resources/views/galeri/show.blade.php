@extends('layouts.app')

@section('title', $galeri->judul)

@section('content')

{{-- Hero --}}
<section class="pt-28 pb-12 bg-gradient-to-br from-purple-600 to-indigo-700">
    <div class="container mx-auto px-6">
        <div class="text-white">
            <div class="flex items-center gap-2 text-sm text-purple-200 mb-4">
                <a href="{{ route('galeri.index') }}" class="hover:text-white">Galeri</a>
                <span>/</span>
                <span>{{ $galeri->kategori }}</span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-4">{{ $galeri->judul }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-purple-100">
                @if($galeri->tanggal_kegiatan)
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $galeri->tanggal_kegiatan->format('d M Y') }}
                </span>
                @endif
                @if($galeri->lokasi)
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    {{ $galeri->lokasi }}
                </span>
                @endif
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    {{ $galeri->views }} views
                </span>
            </div>
        </div>
    </div>
</section>

{{-- Gallery --}}
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        {{-- Gambar Utama --}}
        <div class="mb-8">
            <img src="{{ $galeri->gambar_utama_url }}" alt="{{ $galeri->judul }}" class="w-full max-h-96 object-cover rounded-2xl shadow-lg">
        </div>
        
        {{-- Deskripsi --}}
        @if($galeri->deskripsi)
        <div class="prose max-w-none mb-8">
            <p class="text-gray-700 leading-relaxed">{{ $galeri->deskripsi }}</p>
        </div>
        @endif
        
        {{-- Gambar Lain --}}
        @if($galeri->gambar_lain && count($galeri->gambar_lain) > 0)
        <div class="mt-8">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Foto Lainnya</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($galeri->gambar_lain as $img)
                <div class="cursor-pointer" onclick="openLightbox('{{ asset('storage/' . $img) }}')">
                    <img src="{{ asset('storage/' . $img) }}" class="w-full h-32 object-cover rounded-lg hover:opacity-80 transition">
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

{{-- Galeri Lain --}}
@if(isset($galeriLain) && $galeriLain->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">Galeri Lainnya</h3>
        <div class="grid md:grid-cols-4 gap-6">
            @foreach($galeriLain as $g)
            <a href="{{ route('galeri.show', $g->slug) }}" class="group">
                <div class="relative h-40 rounded-xl overflow-hidden">
                    <img src="{{ $g->gambar_utama_url }}" alt="{{ $g->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black/30 group-hover:bg-black/40 transition"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-3 text-white">
                        <h4 class="font-medium text-sm truncate">{{ $g->judul }}</h4>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Lightbox --}}
<div id="lightbox" class="fixed inset-0 bg-black/90 hidden z-50 flex items-center justify-center p-4" onclick="closeLightbox()">
    <button class="absolute top-4 right-4 text-white text-3xl">&times;</button>
    <img id="lightboxImg" class="max-w-full max-h-[90vh] object-contain">
</div>

<script>
function openLightbox(src) {
    document.getElementById('lightboxImg').src = src;
    document.getElementById('lightbox').classList.remove('hidden');
    document.getElementById('lightbox').classList.add('flex');
}

function closeLightbox() {
    document.getElementById('lightbox').classList.add('hidden');
    document.getElementById('lightbox').classList.remove('flex');
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeLightbox();
});
</script>
@endsection