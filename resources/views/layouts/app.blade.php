<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMA NEGERI 12 MAKASSAR</title>
    @vite('resources/css/app.css')
    
    {{-- CSS untuk Tooltip, Badge SPMB, dan Dropdown Navigasi --}}
    <style>
       /* ========== SPMB TOOLTIP CONTAINER - NAVBAR VERSION ========== */
.tooltip-container {
    height: 40px;
    width: 50px;
    border-radius: 8px;
    background-color: #fff;
    background-image: linear-gradient(
        to left bottom,
        #f2f5f8,
        #ecf1f2,
        #e7eceb,
        #e3e7e4,
        #e1e2de
    );
    border: 1px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    position: relative;
    transition: transform 0.3s ease;
    z-index: 40;
}

.tooltip-container::before {
    position: absolute;
    content: "";
    top: -50%;
    clip-path: polygon(50% 0, 0 100%, 100% 100%);
    border-radius: 8px;
    background-color: #fff;
    background-image: linear-gradient(
        to left bottom,
        #3b82f6,
        #60a5fa,
        #93c5fd
    );
    width: 100%;
    height: 50%;
    transform-style: preserve-3d;
    transform: perspective(1000px) rotateX(-150deg) translateY(-110%);
    transition: transform 0.3s ease;
    z-index: -1;
}

.tooltip-container .text {
    color: #1e3a8a;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
}

.tooltip-container .tooltip {
    position: absolute;
    top: -10px;
    opacity: 0;
    background: linear-gradient(-90deg, rgba(0, 0, 0, 0.05) 1px, white 1px),
        linear-gradient(rgba(0, 0, 0, 0.05) 1px, white 1px),
        linear-gradient(-90deg, rgba(0, 0, 0, 0.04) 1px, white 1px),
        linear-gradient(rgba(0, 0, 0, 0.04) 1px, white 1px),
        linear-gradient(white 3px, #f2f2f2 3px, #f2f2f2 40px, white 40px),
        linear-gradient(-90deg, #aaa 1px, white 1px),
        linear-gradient(-90deg, white 3px, #f2f2f2 3px, #f2f2f2 40px, white 40px),
        linear-gradient(#aaa 1px, white 1px), #f2f2f2;
    background-size: 4px 4px, 4px 4px, 60px 60px, 60px 60px, 60px 60px, 60px 60px, 60px 60px, 60px 60px;
    padding: 4px 12px;
    border: 1px solid rgb(206, 204, 204);
    height: 32px;
    width: auto;
    min-width: 150px;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition-duration: 0.2s;
    pointer-events: none;
    letter-spacing: 0.5px;
    font-size: 12px;
    font-weight: 600;
    color: #1e3a8a;
    white-space: nowrap;
    right: 0;
}

.tooltip-container:hover {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}

.tooltip-container:hover::before {
    transform: rotateY(0);
    background-image: none;
    background-color: white;
}

.tooltip-container:hover .tooltip {
    top: -48px;
    opacity: 1;
    transition-duration: 0.3s;
}

/* ========== SPMB BADGE NOTIFIKASI ========== */
.spmb-badge-dot {
    position: absolute;
    top: -4px;
    right: -4px;
    width: 12px;
    height: 12px;
    background: #ef4444;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 2px 4px rgba(239, 68, 68, 0.4);
    animation: badge-pulse 1.5s ease-in-out infinite;
    z-index: 50;
}

.spmb-badge-text {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    font-size: 10px;
    font-weight: 700;
    padding: 3px 6px;
    border-radius: 9999px;
    box-shadow: 0 2px 4px rgba(59, 130, 246, 0.4);
    border: 1.5px solid white;
    letter-spacing: 0.5px;
    animation: badge-pulse 2.5s ease-in-out infinite;
    z-index: 50;
}

.spmb-badge-new {
    position: absolute;
    top: -6px;
    right: -6px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    font-size: 9px;
    font-weight: 800;
    padding: 2px 5px;
    border-radius: 9999px;
    box-shadow: 0 2px 4px rgba(16, 185, 129, 0.4);
    border: 1.5px solid white;
    animation: badge-pulse 2s ease-in-out infinite;
    z-index: 50;
}

@keyframes badge-pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.tooltip-container:hover .spmb-badge-dot,
.tooltip-container:hover .spmb-badge-text,
.tooltip-container:hover .spmb-badge-new {
    animation: none;
    transform: scale(1);
}

@keyframes spmb-pulse {
    0%, 100% { box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); }
    50% { box-shadow: 0px 4px 12px rgba(59, 130, 246, 0.4); }
}

.spmb-active {
    animation: spmb-pulse 2s ease-in-out infinite;
}

/* ========== DROPDOWN MENU STYLES ========== */
.dropdown-container {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%) translateY(8px);
    min-width: 200px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 8px;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.dropdown-container:hover .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateX(-50%) translateY(4px);
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 10px;
    color: #374151;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s;
    white-space: nowrap;
}

.dropdown-item:hover {
    background: #f0f9ff;
    color: #2563eb;
}

.dropdown-item svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
}

/* ✅ Arrow indicator - TANPA ROTASI */
.nav-link-dropdown::after {
    content: '▾';
    display: inline-block;
    margin-left: 6px;
    font-size: 10px;
}

/* Responsive Mobile */
@media (max-width: 768px) {
    .tooltip-container {
        height: 36px;
        width: 45px;
    }
    
    .tooltip-container .tooltip {
        min-width: 130px;
        font-size: 11px;
        padding: 4px 10px;
    }
    
    .spmb-badge-text {
        font-size: 8px;
        padding: 2px 4px;
        top: -6px;
        right: -6px;
    }

    .mobile-dropdown {
        overflow: hidden;
        transition: max-height 0.3s ease;
    }

    .mobile-dropdown.collapsed {
        max-height: 0;
    }

    .mobile-dropdown.expanded {
        max-height: 500px;
    }
}

/* Line Clamp Utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
    </style>
</head>

<body class="font-sans scroll-smooth">

<!-- NAVBAR -->
<nav id="navbar"
     class="fixed top-0 w-full bg-transparent transition-all duration-300 z-50">

    <div class="container mx-auto px-6 py-4 flex justify-between items-center">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/Logo.png') }}"
                 alt="Logo Sekolah"
                 class="h-10 w-auto">

            <span id="logoText"
                  class="font-bold text-2xl text-white tracking-wide transition-colors duration-300">
                SMA NEGERI 12 MAKASSAR
            </span>
        </a>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-1 font-medium">
            
            {{-- Home --}}
            <a href="{{ route('home') }}" class="nav-link text-white hover:text-blue-300 transition px-4 py-2 rounded-lg">
                Home
            </a>
            
            {{-- Berita --}}
            <a href="{{ route('berita.index') }}" class="nav-link text-white hover:text-blue-300 transition px-4 py-2 rounded-lg">
                Berita
            </a>
            
            {{-- Profil Sekolah (Dropdown) --}}
            <div class="dropdown-container">
                <span class="nav-link-dropdown nav-link text-white hover:text-blue-300 transition px-4 py-2 rounded-lg cursor-pointer inline-flex items-center">
                    Profil Sekolah
                </span>
                <div class="dropdown-menu">
                    <a href="{{ route('fasilitas.index') }}" class="dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Fasilitas
                    </a>
                    <a href="{{ route('pegawai.index') }}" class="dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        Guru & Staff
                    </a>
                </div>
            </div>

            {{-- Program (Dropdown) --}}
            <div class="dropdown-container">
                <span class="nav-link-dropdown nav-link text-white hover:text-blue-300 transition px-4 py-2 rounded-lg cursor-pointer inline-flex items-center">
                    Program
                </span>
                <div class="dropdown-menu">
                    <a href="{{ route('galeri.index') }}" class="dropdown-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Galeri Kegiatan
                    </a>
                    <a href="#" class="dropdown-item opacity-50 cursor-not-allowed">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.121-.659-.515-.386-.515-1.11 0-1.496.343-.257.727-.386 1.121-.386"></path>
                        </svg>
                        <span class="text-xs">Segera Hadir</span>
                    </a>
                </div>
            </div>

            {{-- SPMB Icon --}}
            @php
                $spmbAktif = \App\Models\Spmb::aktif()->exists();
            @endphp
            
            @if($spmbAktif)
            <a href="{{ route('spmb.index') }}" class="tooltip-container spmb-active relative ml-4">
                <span class="tooltip">SPMB SMAN 12 Makassar</span>
                <span class="text">
                    <x-maki-school class="w-5 h-5" />
                </span>
                <span class="spmb-badge-text">SPMB</span>
            </a>
            @endif
        </div>

        <!-- Mobile: SPMB Icon + Hamburger Button -->
        <div class="flex items-center gap-3 md:hidden">
            @php
                $spmbAktif = \App\Models\Spmb::aktif()->exists();
            @endphp
            
            @if($spmbAktif)
            <a href="{{ route('spmb.index') }}" class="tooltip-container spmb-active relative">
                <span class="tooltip">SPMB SMAN 12 Makassar</span>
                <span class="text">
                    <x-maki-school class="w-4 h-4" />
                </span>
                <span class="spmb-badge-dot"></span>
            </a>
            @endif
            
            <button id="menuBtn" class="text-white text-2xl focus:outline-none transition-colors duration-300">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile Menu Dropdown -->
    <div id="mobileMenu"
         class="hidden md:hidden bg-white shadow-lg px-6 py-4 space-y-1 font-medium max-h-[80vh] overflow-y-auto">
        
        {{-- Home --}}
        <a href="{{ route('home') }}" class="block py-3 text-gray-800 hover:text-blue-600 transition">
            🏠 Home
        </a>
        
        {{-- Berita --}}
        <a href="{{ route('berita.index') }}" class="block py-3 text-gray-800 hover:text-blue-600 transition">
            📰 Berita
        </a>
        
        {{-- Profil Sekolah (Mobile Dropdown) --}}
        <div class="mobile-dropdown-container">
            <button onclick="toggleMobileDropdown(this)" class="mobile-dropdown-item flex items-center justify-between w-full py-3 text-gray-800 hover:text-blue-600 transition">
                <span>🏫 Profil Sekolah</span>
                <svg class="dropdown-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="mobile-dropdown collapsed pl-4 border-l-2 border-blue-200 ml-2">
                <a href="{{ route('fasilitas.index') }}" class="block py-2 text-sm text-gray-600 hover:text-blue-600 transition">
                    🏢 Fasilitas
                </a>
                <a href="{{ route('pegawai.index') }}" class="block py-2 text-sm text-gray-600 hover:text-blue-600 transition">
                    👨‍🏫 Guru & Staff
                </a>
            </div>
        </div>
        
        {{-- Program (Mobile Dropdown) --}}
        <div class="mobile-dropdown-container">
            <button onclick="toggleMobileDropdown(this)" class="mobile-dropdown-item flex items-center justify-between w-full py-3 text-gray-800 hover:text-blue-600 transition">
                <span>📋 Program</span>
                <svg class="dropdown-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            <div class="mobile-dropdown collapsed pl-4 border-l-2 border-purple-200 ml-2">
                <a href="{{ route('galeri.index') }}" class="block py-2 text-sm text-gray-600 hover:text-blue-600 transition">
                    🖼️ Galeri Kegiatan
                </a>
                <span class="block py-2 text-sm text-gray-400 cursor-not-allowed">
                    ⏳ Segera Hadir
                </span>
            </div>
        </div>
        
        {{-- SPMB Mobile --}}
        @php
            $spmbAktif = \App\Models\Spmb::aktif()->exists();
        @endphp
        
        @if($spmbAktif)
        <div class="pt-3 mt-3 border-t border-gray-200">
            <a href="{{ route('spmb.index') }}" 
               class="flex items-center gap-2 py-3 text-blue-600 font-medium hover:text-blue-700 transition">
                <x-maki-school class="w-5 h-5" />
                <span>SPMB</span>
                <span class="ml-auto bg-gradient-to-r from-red-500 to-red-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-md animate-pulse">
                    BARU!
                </span>
            </a>
        </div>
        @endif
    </div>
</nav>

{{-- Content Section --}}
@yield('content')

{{-- Footer --}}
@include('partials.footer')

<script>
    const navbar = document.getElementById("navbar");
    const menuBtn = document.getElementById("menuBtn");
    const mobileMenu = document.getElementById("mobileMenu");
    const logoText = document.getElementById("logoText");

    // Toggle mobile menu
    if (menuBtn) {
        menuBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            mobileMenu.classList.toggle("hidden");
        });
    }

    // Toggle mobile dropdown
    function toggleMobileDropdown(btn) {
        const dropdown = btn.nextElementSibling;
        const icon = btn.querySelector('.dropdown-icon');
        
        if (dropdown.classList.contains('collapsed')) {
            dropdown.classList.remove('collapsed');
            dropdown.classList.add('expanded');
            dropdown.style.maxHeight = dropdown.scrollHeight + 'px';
            icon.style.transform = 'rotate(180deg)';
        } else {
            dropdown.classList.remove('expanded');
            dropdown.classList.add('collapsed');
            dropdown.style.maxHeight = '0';
            icon.style.transform = 'rotate(0deg)';
        }
    }

    // Scroll effect - Navbar color change
    window.addEventListener("scroll", () => {
        if (window.scrollY > 50) {
            navbar.classList.remove("bg-transparent");
            navbar.classList.add("bg-white", "shadow-md");

            document.querySelectorAll(".nav-link, .nav-link-dropdown").forEach(link => {
                link.classList.remove("text-white");
                link.classList.add("text-gray-800");
            });

            if (logoText) {
                logoText.classList.remove("text-white");
                logoText.classList.add("text-gray-800");
            }
            
            if (menuBtn) {
                menuBtn.classList.remove("text-white");
                menuBtn.classList.add("text-gray-800");
            }

        } else {
            navbar.classList.remove("bg-white", "shadow-md");
            navbar.classList.add("bg-transparent");

            document.querySelectorAll(".nav-link, .nav-link-dropdown").forEach(link => {
                link.classList.remove("text-gray-800");
                link.classList.add("text-white");
            });

            if (logoText) {
                logoText.classList.remove("text-gray-800");
                logoText.classList.add("text-white");
            }
            
            if (menuBtn) {
                menuBtn.classList.remove("text-gray-800");
                menuBtn.classList.add("text-white");
            }
        }
    });
    
    // Tutup mobile menu
    document.querySelectorAll('#mobileMenu a:not(.cursor-not-allowed)').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.add('hidden');
        });
    });
    
    document.addEventListener('click', (e) => {
        if (!mobileMenu.contains(e.target) && !menuBtn.contains(e.target)) {
            mobileMenu.classList.add('hidden');
        }
    });
    
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            if (href === "#" || href === "" || href === "#home") return;
            
            const target = document.querySelector(href);
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>

</body>
</html>