@extends('layouts.app')

@section('title', 'Ekstrakurikuler - SMAN 12 Makassar')

@section('content')

{{-- Navbar Khusus Eskul --}}
<nav class="fixed top-0 w-full bg-white/95 backdrop-blur-md shadow-md z-50">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-10 w-auto">
            <span class="font-bold text-lg text-gray-800">SMA NEGERI 12 MAKASSAR</span>
        </a>
        <div></div>
    </div>
</nav>

{{-- PlayStation Style Menu --}}
<div id="eskulApp" class="min-h-screen bg-gradient-to-br from-gray-900 via-blue-950 to-indigo-950 pt-20 pb-10 overflow-hidden">
    
    {{-- Background Dynamic (Berubah sesuai eskul yang di-hover) --}}
    <div id="bgOverlay" class="fixed inset-0 transition-all duration-700 ease-in-out opacity-0 pointer-events-none z-0">
        <div class="absolute inset-0 bg-cover bg-center blur-md scale-110" id="bgImage"></div>
        <div class="absolute inset-0 bg-black/60"></div>
    </div>
    
    {{-- Particles Background --}}
    <div class="fixed inset-0 z-0 opacity-20 pointer-events-none">
        <div class="absolute top-20 left-20 w-60 h-60 bg-blue-500 rounded-full mix-blend-screen filter blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-20 w-60 h-60 bg-purple-500 rounded-full mix-blend-screen filter blur-3xl animate-pulse" style="animation-delay: 3s;"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 bg-indigo-500 rounded-full mix-blend-screen filter blur-3xl animate-pulse" style="animation-delay: 1.5s;"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        
        {{-- Header --}}
        <div class="text-center mb-12">
            <p class="text-blue-300 text-sm uppercase tracking-widest mb-3">Pilih Ekstrakurikuler</p>
            <h1 class="text-4xl md:text-6xl font-extrabold text-white mb-4 drop-shadow-lg">
                Kegiatan Sekolah
            </h1>
            <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                Temukan minat dan bakatmu melalui berbagai kegiatan ekstrakurikuler
            </p>
            
            {{-- Indicator --}}
            <div class="flex items-center justify-center gap-2 mt-6 text-gray-500 text-sm">
                <svg class="w-5 h-5 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                </svg>
                <span>Gunakan mouse / swipe untuk navigasi</span>
            </div>
        </div>

        {{-- Eskul Carousel PlayStation Style --}}
        <div class="relative max-w-6xl mx-auto">
            
            {{-- Eskul Cards Container --}}
            <div id="eskulContainer" class="flex items-center justify-center gap-4 md:gap-6 flex-wrap md:flex-nowrap min-h-[500px] perspective-1000">
                
                @forelse($eskuls as $index => $eskul)
                <div class="eskul-card flex-shrink-0 w-64 md:w-72 transition-all duration-500 ease-out cursor-pointer"
                     data-index="{{ $index }}"
                     data-bg="{{ $eskul->background ? asset('storage/' . $eskul->background) : '' }}"
                     data-name="{{ $eskul->nama }}"
                     data-pembina="{{ $eskul->pembina ?? 'Tidak ada pembina' }}"
                     data-jadwal="{{ $eskul->jadwal ?? '-' }}"
                     data-anggota="{{ $eskul->jumlah_anggota ?? 0 }}"
                     data-slug="{{ $eskul->slug }}"
                     onmouseenter="focusCard(this)"
                     onmouseleave="unfocusCard(this)"
                     onclick="goToEskul('{{ $eskul->slug }}')">
                    
                    {{-- Card Content --}}
                    <div class="relative bg-white/10 backdrop-blur-md rounded-2xl overflow-hidden border border-white/10 shadow-2xl transform transition-all duration-500 hover:scale-105">
                        
                        {{-- Card Image --}}
                        <div class="relative h-56 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent z-10"></div>
                            
                            @if($eskul->logo)
                                <img src="{{ asset('storage/' . $eskul->logo) }}" 
                                     alt="{{ $eskul->nama }}" 
                                     class="w-full h-full object-cover">
                            @elseif($eskul->background)
                                <img src="{{ asset('storage/' . $eskul->background) }}" 
                                     alt="{{ $eskul->nama }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-600 to-purple-700 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            {{-- Hover Glow --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-blue-500/40 to-transparent opacity-0 transition-opacity duration-300 z-20" id="glow-{{ $index }}"></div>
                        </div>
                        
                        {{-- Card Info --}}
                        <div class="p-5 relative z-10">
                            <h3 class="text-lg font-bold text-white mb-2 truncate">{{ $eskul->nama }}</h3>
                            
                            <div class="space-y-2 text-sm">
                                @if($eskul->pembina)
                                <p class="text-gray-400 flex items-center gap-1">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="truncate">{{ $eskul->pembina }}</span>
                                </p>
                                @endif
                                
                                @if($eskul->jadwal)
                                <p class="text-gray-500 flex items-center gap-1 text-xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $eskul->jadwal }}
                                </p>
                                @endif
                            </div>
                            
                            {{-- Button --}}
                            <div class="mt-4 pt-4 border-t border-white/10">
                                <span class="text-blue-400 text-sm font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                                    Lihat Detail
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-20">
                    <svg class="w-24 h-24 text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h2 class="text-2xl font-bold text-white mb-2">Belum Ada Ekstrakurikuler</h2>
                    <p class="text-gray-400">Data ekstrakurikuler akan muncul di sini</p>
                </div>
                @endforelse
            </div>
            
            {{-- Detail Panel (Muncul saat hover/focus) --}}
            <div id="detailPanel" class="mt-8 text-center transition-all duration-500 opacity-0 transform translate-y-4">
                <div class="bg-white/5 backdrop-blur-md rounded-2xl p-6 border border-white/10 inline-block">
                    <h2 id="detailName" class="text-2xl font-bold text-white mb-3"></h2>
                    <div class="flex items-center justify-center gap-6 text-gray-400">
                        <span id="detailPembina" class="flex items-center gap-2"></span>
                        <span id="detailJadwal" class="flex items-center gap-2"></span>
                        <span id="detailAnggota" class="flex items-center gap-2"></span>
                    </div>
                </div>
            </div>
            
            {{-- Navigation Dots --}}
            <div class="flex justify-center gap-2 mt-8">
                @foreach($eskuls as $index => $eskul)
                <button class="nav-dot w-2.5 h-2.5 rounded-full bg-white/30 transition-all duration-300 hover:bg-white/60"
                        data-index="{{ $index }}"
                        onclick="scrollToCard({{ $index }})">
                </button>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .perspective-1000 {
        perspective: 1000px;
    }
    
    .eskul-card {
        transform-style: preserve-3d;
    }
    
    .eskul-card.focused {
        transform: scale(1.08) translateY(-10px);
        z-index: 20;
    }
    
    .eskul-card.focused .shadow-2xl {
        box-shadow: 0 0 40px rgba(59, 130, 246, 0.5), 0 20px 60px rgba(0, 0, 0, 0.5);
    }
    
    .eskul-card.unfocused {
        transform: scale(0.9);
        opacity: 0.5;
        filter: blur(1px);
    }
    
    .nav-dot.active {
        background: #3b82f6;
        width: 24px;
        border-radius: 9999px;
        box-shadow: 0 0 10px rgba(59, 130, 246, 0.5);
    }
    
    /* Smooth transition untuk semua card */
    .eskul-card {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Glow effect */
    #bgOverlay {
        transition: opacity 0.7s ease-in-out;
    }
</style>

<script>
    let currentFocus = null;
    const cards = document.querySelectorAll('.eskul-card');
    const detailPanel = document.getElementById('detailPanel');
    const bgOverlay = document.getElementById('bgOverlay');
    const bgImage = document.getElementById('bgImage');
    const dots = document.querySelectorAll('.nav-dot');
    
    function focusCard(card) {
        const index = parseInt(card.dataset.index);
        currentFocus = index;
        
        // Update cards state
        cards.forEach((c, i) => {
            if (i === index) {
                c.classList.add('focused');
                c.classList.remove('unfocused');
            } else {
                c.classList.remove('focused');
                c.classList.add('unfocused');
            }
        });
        
        // Update dots
        dots.forEach((d, i) => {
            d.classList.toggle('active', i === index);
        });
        
        // Update detail panel
        detailPanel.style.opacity = '1';
        detailPanel.style.transform = 'translateY(0)';
        document.getElementById('detailName').textContent = card.dataset.name;
        document.getElementById('detailPembina').innerHTML = `
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            ${card.dataset.pembina}
        `;
        document.getElementById('detailJadwal').innerHTML = `
            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            ${card.dataset.jadwal}
        `;
        document.getElementById('detailAnggota').innerHTML = `
            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
            ${card.dataset.anggota} Anggota
        `;
        
        // Update background
        const bg = card.dataset.bg;
        if (bg) {
            bgImage.style.backgroundImage = `url(${bg})`;
            bgImage.classList.add('bg-cover', 'bg-center');
            bgOverlay.style.opacity = '1';
        } else {
            bgOverlay.style.opacity = '0';
        }
    }
    
    function unfocusCard(card) {
        cards.forEach(c => {
            c.classList.remove('focused', 'unfocused');
        });
        
        detailPanel.style.opacity = '0';
        detailPanel.style.transform = 'translateY(10px)';
        bgOverlay.style.opacity = '0';
        currentFocus = null;
        
        dots.forEach(d => d.classList.remove('active'));
    }
    
    function goToEskul(slug) {
        window.location.href = `/ekstrakurikuler/${slug}`;
    }
    
    function scrollToCard(index) {
        const card = cards[index];
        if (card) {
            card.scrollIntoView({ behavior: 'smooth', block: 'center' });
            focusCard(card);
            
            // Auto unfocus after 3 seconds
            clearTimeout(window.unfocusTimeout);
            window.unfocusTimeout = setTimeout(() => unfocusCard(card), 3000);
        }
    }
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (cards.length === 0) return;
        
        if (e.key === 'ArrowRight' || e.key === 'ArrowLeft') {
            e.preventDefault();
            const newIndex = currentFocus !== null 
                ? (currentFocus + (e.key === 'ArrowRight' ? 1 : -1) + cards.length) % cards.length 
                : 0;
            scrollToCard(newIndex);
        }
        
        if (e.key === 'Enter' && currentFocus !== null) {
            const slug = cards[currentFocus].dataset.slug;
            goToEskul(slug);
        }
        
        if (e.key === 'Escape') {
            unfocusCard();
        }
    });
    
    // Touch swipe support
    let touchStartX = 0;
    
    document.addEventListener('touchstart', (e) => {
        touchStartX = e.touches[0].clientX;
    });
    
    document.addEventListener('touchend', (e) => {
        if (cards.length === 0) return;
        const touchEndX = e.changedTouches[0].clientX;
        const diff = touchStartX - touchEndX;
        
        if (Math.abs(diff) > 50) {
            const newIndex = currentFocus !== null 
                ? (currentFocus + (diff > 0 ? 1 : -1) + cards.length) % cards.length 
                : 0;
            scrollToCard(newIndex);
        }
    });
    
    // Initial state - focus first card
    if (cards.length > 0) {
        setTimeout(() => focusCard(cards[0]), 500);
    }
</script>

@endsection