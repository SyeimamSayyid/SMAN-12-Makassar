@extends('layouts.app')

@section('title', 'Alumni')

@section('content')

{{-- Hero Section --}}
<section class="pt-28 pb-12 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700">
    <div class="container mx-auto px-6 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in">Jejaring Alumni</h1>
        <p class="text-xl text-blue-100 max-w-2xl mx-auto animate-slide-up">Mari terhubung dan bangun jaringan bersama alumni SMAN 12 Makassar</p>
    </div>
</section>

{{-- Stats Section --}}
<section class="py-12 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 text-center scroll-reveal">
                <div class="text-4xl font-bold text-blue-600">{{ number_format($stats['total']) }}</div>
                <p class="text-gray-600 mt-2">Total Alumni</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 text-center scroll-reveal">
                <div class="text-4xl font-bold text-green-600">{{ number_format($stats['universitas']) }}</div>
                <p class="text-gray-600 mt-2">Universitas</p>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 text-center scroll-reveal">
                <div class="text-4xl font-bold text-purple-600">{{ number_format($stats['provinsi']) }}</div>
                <p class="text-gray-600 mt-2">Provinsi</p>
            </div>
        </div>
    </div>
</section>

{{-- Featured Alumni --}}
<section class="py-16 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 text-center mb-4 scroll-reveal">Alumni Sukses</h2>
        <p class="text-gray-500 text-center mb-12 scroll-reveal">Mereka yang telah menginspirasi</p>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($featuredAlumni as $alumni)
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 scroll-reveal">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-xl">
                        {{ substr($alumni->nama_lengkap, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">{{ $alumni->nama_lengkap }}</h3>
                        <p class="text-sm text-gray-500">Lulus {{ $alumni->tahun_lulus }}</p>
                    </div>
                </div>
                
                @if($alumni->universitas)
                <div class="flex items-center gap-3 mb-3 p-3 bg-gray-50 rounded-xl">
                    <img src="{{ $alumni->logo_universitas_url }}" alt="{{ $alumni->nama_universitas }}" class="w-10 h-10 object-contain">
                    <div>
                        <p class="font-medium text-gray-800 text-sm">{{ $alumni->nama_universitas }}</p>
                        <p class="text-xs text-gray-500">{{ $alumni->program_studi }}</p>
                    </div>
                </div>
                @endif
                
                @if($alumni->pekerjaan)
                <p class="text-sm text-gray-600 mb-3">
                    <span class="font-medium">{{ $alumni->pekerjaan }}</span>
                    @if($alumni->perusahaan) di {{ $alumni->perusahaan }} @endif
                </p>
                @endif
                
                @if($alumni->testimoni)
                <div class="relative mt-3 pt-3 border-t border-gray-100">
                    <svg class="w-6 h-6 text-blue-200 absolute -top-3 left-0 bg-white pr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                    <p class="text-gray-600 italic text-sm pl-5">{{ $alumni->testimoni }}</p>
                </div>
                @endif
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-400">Belum ada alumni featured</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- FLOATING CARDS - Sebaran Alumni --}}
<section class="py-16 bg-gradient-to-b from-white to-blue-50/30">
    <div class="container mx-auto px-6">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-3 scroll-reveal">Mereka yang Telah Melanjutkan</h2>
            <p class="text-gray-500 max-w-2xl mx-auto scroll-reveal">Alumni yang berhasil melanjutkan pendidikan ke berbagai universitas ternama</p>
        </div>
        
        {{-- Floating Cards Container --}}
        <div class="relative max-w-6xl mx-auto" style="min-height: 450px;">
            
            @php
                // Posisi card (left, top dalam persen) - Responsive
                $positions = [
                    ['left' => '3%', 'top' => '5%'],
                    ['left' => '22%', 'top' => '0%'],
                    ['left' => '42%', 'top' => '10%'],
                    ['left' => '62%', 'top' => '3%'],
                    ['left' => '80%', 'top' => '12%'],
                    ['left' => '8%', 'top' => '30%'],
                    ['left' => '30%', 'top' => '35%'],
                    ['left' => '52%', 'top' => '30%'],
                    ['left' => '72%', 'top' => '38%'],
                    ['left' => '15%', 'top' => '58%'],
                    ['left' => '40%', 'top' => '60%'],
                    ['left' => '65%', 'top' => '65%'],
                    ['left' => '85%', 'top' => '62%'],
                    ['left' => '25%', 'top' => '80%'],
                    ['left' => '55%', 'top' => '82%'],
                    ['left' => '78%', 'top' => '85%'],
                ];
            @endphp
            
            @forelse($floatingAlumni as $index => $alumni)
                @if($index < count($positions))
                <div class="floating-card absolute w-64 md:w-72 transform hover:scale-105 hover:z-20 transition-all duration-500 scroll-reveal"
                     style="left: {{ $positions[$index]['left'] }}; top: {{ $positions[$index]['top'] }};">
                    <div class="bg-white rounded-2xl shadow-xl p-4 border border-gray-100 hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center gap-4">
                            {{-- Logo Universitas --}}
                            <div class="flex-shrink-0">
                                @if($alumni->universitas && $alumni->universitas->logo)
                                    <img src="{{ asset('storage/' . $alumni->universitas->logo) }}" 
                                         alt="{{ $alumni->universitas->nama }}" 
                                         class="w-14 h-14 object-contain rounded-xl bg-gray-50 p-1">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            {{-- Info Alumni --}}
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-800 truncate">{{ $alumni->nama_lengkap }}</h4>
                                <p class="text-sm text-blue-600 truncate">
                                    {{ $alumni->universitas->akronim ?? $alumni->universitas->nama ?? '-' }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Lulus {{ $alumni->tahun_lulus }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        @if($alumni->program_studi)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-500 truncate">{{ $alumni->program_studi }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            @empty
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p class="text-gray-400">Belum ada data alumni</p>
                </div>
            </div>
            @endforelse
        </div>
        
        {{-- Tombol Lihat Semua --}}
        <div class="text-center mt-12">
            <a href="{{ route('alumni.index') }}" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <span>Lihat Semua Alumni</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

{{-- Call to Action --}}
<section class="py-16 bg-gradient-to-br from-blue-50 to-indigo-50">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4 scroll-reveal">Bergabung dengan Jaringan Alumni</h2>
        <p class="text-gray-600 mb-8 max-w-2xl mx-auto scroll-reveal">Daftarkan diri Anda dan tetap terhubung dengan almamater serta alumni lainnya</p>
        <a href="{{ route('alumni.create') }}" 
           class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Daftar Sekarang
        </a>
    </div>
</section>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
.animate-slide-up { animation: fadeIn 0.8s ease-out 0.2s forwards; opacity: 0; }
.scroll-reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease; }
.scroll-reveal.revealed { opacity: 1; transform: translateY(0); }

/* Animasi untuk floating cards */
.floating-card {
    animation: float 4s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

/* Delay animasi untuk setiap card */
.floating-card:nth-child(1) { animation-delay: 0s; }
.floating-card:nth-child(2) { animation-delay: 0.15s; }
.floating-card:nth-child(3) { animation-delay: 0.3s; }
.floating-card:nth-child(4) { animation-delay: 0.45s; }
.floating-card:nth-child(5) { animation-delay: 0.6s; }
.floating-card:nth-child(6) { animation-delay: 0.75s; }
.floating-card:nth-child(7) { animation-delay: 0.9s; }
.floating-card:nth-child(8) { animation-delay: 1.05s; }
.floating-card:nth-child(9) { animation-delay: 1.2s; }
.floating-card:nth-child(10) { animation-delay: 1.35s; }
.floating-card:nth-child(11) { animation-delay: 1.5s; }
.floating-card:nth-child(12) { animation-delay: 1.65s; }
.floating-card:nth-child(13) { animation-delay: 1.8s; }
.floating-card:nth-child(14) { animation-delay: 1.95s; }
.floating-card:nth-child(15) { animation-delay: 2.1s; }
.floating-card:nth-child(16) { animation-delay: 2.25s; }

/* Responsive */
@media (max-width: 768px) {
    .floating-card {
        position: relative !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        margin-bottom: 16px;
        transform: none !important;
    }
    
    .floating-card:hover {
        transform: scale(1.02) !important;
    }
    
    .floating-card {
        animation: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const revealElements = document.querySelectorAll('.scroll-reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
    revealElements.forEach(el => observer.observe(el));
});
</script>
@endsection