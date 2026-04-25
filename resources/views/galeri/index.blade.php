@extends('layouts.app')

@section('title', 'Galeri Kegiatan')

@section('content')

{{-- Hero --}}
<section class="pt-28 pb-12 bg-gradient-to-br from-purple-600 to-indigo-700">
    <div class="container mx-auto px-6 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Galeri Kegiatan</h1>
        <p class="text-xl text-purple-100">Dokumentasi momen berharga dari berbagai kegiatan sekolah</p>
    </div>
</section>

{{-- Filter Kategori --}}
<section class="py-6 bg-white border-b sticky top-0 z-30 shadow-sm">
    <div class="container mx-auto px-6">
        <div class="flex justify-center flex-wrap gap-2">
            <a href="{{ route('galeri.index') }}" class="px-5 py-2 rounded-full text-sm font-medium {{ $kategori == 'all' ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition">
                Semua
            </a>
            @foreach($kategoris as $kat)
            <a href="{{ route('galeri.index', ['kategori' => $kat]) }}" class="px-5 py-2 rounded-full text-sm font-medium {{ $kategori == $kat ? 'bg-purple-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }} transition">
                {{ $kat }}
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Content --}}
<section class="py-16 bg-gradient-to-b from-white to-gray-50 min-h-screen">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($galeri as $g)
            <div class="galeri-card group relative bg-white rounded-2xl shadow-lg overflow-hidden cursor-pointer transition-all duration-300 hover:shadow-2xl" onclick="window.location='{{ route('galeri.show', $g->slug) }}'">
                {{-- Gambar --}}
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $g->gambar_utama_url }}" alt="{{ $g->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1 bg-purple-600 text-white text-xs rounded-full">{{ $g->kategori }}</span>
                    </div>
                    @if($g->is_featured)
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1 bg-yellow-500 text-white text-xs rounded-full">★ Featured</span>
                    </div>
                    @endif
                </div>
                
                {{-- Overlay --}}
                <div class="galeri-overlay absolute inset-0 bg-gradient-to-t from-purple-900/90 via-purple-800/80 to-purple-700/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">{{ $g->judul }}</h3>
                    <p class="text-sm text-purple-100 mb-4 line-clamp-3">{{ $g->deskripsi ?? 'Dokumentasi kegiatan sekolah.' }}</p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-xs">
                            @if($g->tanggal_kegiatan)
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ $g->tanggal_kegiatan->format('d M Y') }}
                            </span>
                            @endif
                            @if($g->views > 0)
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ $g->views }}
                            </span>
                            @endif
                        </div>
                        <span class="text-sm font-medium flex items-center gap-1">
                            Lihat Detail
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-400">Belum ada data galeri</p>
            </div>
            @endforelse
        </div>
        
        <div class="mt-12">
            {{ $galeri->links() }}
        </div>
    </div>
</section>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@media (max-width: 768px) {
    .galeri-card:active .galeri-overlay {
        opacity: 1 !important;
    }
}
</style>
@endsection