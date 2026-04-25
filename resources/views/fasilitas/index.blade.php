@extends('layouts.app')

@section('title', 'Fasilitas Sekolah')

@section('content')

{{-- Hero --}}
<section class="pt-28 pb-12 bg-gradient-to-br from-blue-600 to-indigo-700">
    <div class="container mx-auto px-6 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Fasilitas Sekolah</h1>
        <p class="text-xl text-blue-100">Sarana dan prasarana modern untuk mendukung kegiatan belajar</p>
    </div>
</section>

{{-- Content --}}
<section class="py-16 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-6">
        
        @if($fasilitas->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($fasilitas as $f)
            <div class="fasilitas-card group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden flex flex-col h-full">
                
                {{-- Gambar --}}
                <div class="relative h-52 overflow-hidden flex-shrink-0">
                    @if($f->gambar)
                        <img src="{{ asset('storage/' . $f->gambar) }}" alt="{{ $f->nama }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    @endif
                    
                    {{-- Gradient Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    {{-- Kategori Badge --}}
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1.5 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-semibold rounded-full shadow-lg">
                            {{ $f->kategori_label }}
                        </span>
                    </div>
                    
                    {{-- Jumlah Unit Badge --}}
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1.5 bg-blue-600/90 backdrop-blur-sm text-white text-xs font-semibold rounded-full shadow-lg">
                            {{ $f->jumlah ?? 1 }} Unit
                        </span>
                    </div>
                    
                    {{-- Judul --}}
                    <div class="absolute bottom-4 left-4 right-4">
                        <h3 class="text-xl font-bold text-white">{{ $f->nama }}</h3>
                    </div>
                </div>
                
                {{-- Konten Card --}}
                <div class="p-5 flex-1 flex flex-col">
                    {{-- Info Tambahan --}}
                    @if($f->info_tambahan)
                    <div class="flex items-center gap-2 mb-3">
                        <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                        <p class="text-sm font-medium text-blue-700">{{ $f->info_tambahan }}</p>
                    </div>
                    @endif
                    
                    {{-- Deskripsi - FULL TANPA POTONG --}}
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $f->deskripsi ?? 'Fasilitas modern dan lengkap untuk mendukung kegiatan belajar mengajar serta pengembangan minat dan bakat siswa.' }}
                        </p>
                    </div>
                    
                    {{-- Footer --}}
                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-center">
                        <div class="flex items-center gap-1 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                            </svg>
                            <span class="text-xs">SMAN 12 Makassar</span>
                        </div>
                    </div>
                </div>
                
                {{-- Indicator panah (muncul saat hover) --}}
                <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 z-10">
                    <div class="w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Empty State --}}
        <div class="text-center py-12">
            <div class="bg-blue-50 rounded-2xl p-12 inline-block">
                <svg class="w-20 h-20 text-blue-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p class="text-gray-500 text-lg">Belum ada data fasilitas</p>
                <p class="text-gray-400 text-sm mt-2">Data akan muncul setelah admin menambahkan</p>
            </div>
        </div>
        @endif
        
        {{-- Tombol Kembali --}}
        <div class="text-center mt-12">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 font-medium px-6 py-3 rounded-full hover:bg-gray-50 hover:shadow-md transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>

<style>
/* Hover effect untuk card */
.fasilitas-card {
    transform: translateY(0);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.fasilitas-card:hover {
    transform: translateY(-8px);
}

/* Mobile responsive */
@media (max-width: 640px) {
    .fasilitas-card {
        max-width: 100%;
    }
}
</style>
@endsection