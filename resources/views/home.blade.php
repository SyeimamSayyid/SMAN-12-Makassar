@extends('layouts.app')

@section('title', 'Website Resmi Sekolah')

@section('content')

<!-- HERO -->
<section id="home" class="pt-28 min-h-screen relative flex items-center justify-center text-white overflow-hidden">
    <img id="hero-bg" src="{{ asset('images/Gambar 1.jpeg') }}" 
         class="absolute inset-0 w-full h-full object-cover scale-110 transition-all duration-1000 ease-in-out" />
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-[#27B0F5]/80"></div>
    <div class="absolute inset-0 bg-[#27B0F5]/30 backdrop-blur-sm"></div>
    <div class="relative text-center px-6 max-w-3xl">
        <h1 class="text-4xl md:text-6xl font-bold mb-6 leading-tight animate-fade-in">Website Resmi Sekolah</h1>
        <p class="text-lg md:text-xl mb-8 text-gray-200 animate-slide-up">Informasi terbaru dan dokumentasi kegiatan sekolah kami.</p>
        <a href="#kepala-sekolah" class="bg-[#27B0F5] hover:bg-[#1E9AD6] px-6 py-3 rounded-full shadow-lg transition-all duration-300 hover:shadow-xl transform hover:-translate-y-1 inline-block">Jelajahi</a>
    </div>
</section>

<!-- STATISTIK -->
<section class="relative py-24 overflow-hidden bg-gradient-to-br from-white via-blue-50/30 to-sky-50/50">
    <div class="absolute inset-0 opacity-30">
        <div class="absolute top-10 left-10 w-72 h-72 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-72 h-72 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
    </div>
    <div class="container mx-auto px-6 text-center relative z-10">
        <h2 class="text-3xl font-bold mb-16 text-gray-800 drop-shadow-lg scroll-reveal">Statistik Sekolah</h2>
        <div class="grid md:grid-cols-4 gap-8">
            
            {{-- Tenaga Pengajar --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-8 transition-all duration-300 hover:scale-105 border border-white/50 scroll-reveal">
                <div class="flex justify-center mb-4 text-blue-600">
                    <x-bi-people-fill class="w-12 h-12" />
                </div>
                <h3 class="text-4xl font-bold text-blue-600 counter" data-target="{{ $totalGuru ?? 90 }}">{{ $totalGuru ?? 90 }}</h3>
                <p class="mt-2 text-gray-600 font-medium">Tenaga Pengajar</p>
            </div>
            
            {{-- Jumlah Siswa --}}
            <a href="{{ route('statistik.index') }}" 
               class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-8 transition-all duration-300 hover:scale-105 border border-white/50 scroll-reveal cursor-pointer group block">
                <div class="flex justify-center mb-4 text-green-600 group-hover:scale-110 transition-transform duration-300">
                    <x-phosphor-student class="w-12 h-12" />
                </div>
                <h3 class="text-4xl font-bold text-green-600 counter" data-target="{{ $totalSiswa ?? 1100 }}">{{ $totalSiswa ?? 1100 }}</h3>
                <p class="mt-2 text-gray-600 font-medium flex items-center justify-center gap-1">
                    Jumlah Siswa
                    <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                </p>
                <p class="text-xs text-green-500 mt-1 opacity-0 group-hover:opacity-100 transition-opacity duration-300">Klik untuk lihat detail →</p>
            </a>
            
            {{-- Ekstrakurikuler --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-8 transition-all duration-300 hover:scale-105 border border-white/50 scroll-reveal">
                <div class="flex justify-center mb-4 text-yellow-600">
                    <x-gameicon-diamond-trophy class="w-12 h-12" />
                </div>
                <h3 class="text-4xl font-bold text-yellow-600 counter" data-target="{{ $totalEkskul ?? 5 }}">{{ $totalEkskul ?? 5 }}</h3>
                <p class="mt-2 text-gray-500">Ekstrakurikuler</p>
            </div>
            
            {{-- Jumlah Kelas --}}
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg p-8 transition-all duration-300 hover:scale-105 border border-white/50 scroll-reveal">
                <div class="flex justify-center mb-4 text-purple-600">
                    <x-healthicons-f-i-training-class class="w-12 h-12" />
                </div>
                <h3 class="text-4xl font-bold text-purple-600 counter" data-target="{{ $totalRombel ?? 31 }}">{{ $totalRombel ?? 31 }}</h3>
                <p class="mt-2 text-gray-500">Jumlah Kelas</p>
            </div>
        </div>
        
        <div class="mt-10 scroll-reveal">
            <a href="{{ route('statistik.index') }}" 
               class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium transition group">
                <span>Lihat Statistik Lengkap</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- SECTION KEPALA SEKOLAH -->
<section id="kepala-sekolah" class="py-24 bg-gradient-to-b from-white to-blue-50/50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider scroll-reveal">Profil Pimpinan</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2 mb-4 scroll-reveal">Kepala Sekolah & Visi Misi</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-blue-600 mx-auto rounded-full scroll-reveal"></div>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto scroll-reveal">Mengenal lebih dekat pimpinan dan tujuan sekolah kami</p>
        </div>

        <div class="flex justify-center mb-12 scroll-reveal">
            <div class="inline-flex bg-white/80 backdrop-blur-sm rounded-2xl p-1.5 shadow-lg border border-gray-200">
                <button onclick="switchTab('video')" id="tabVideo" class="px-8 py-3 rounded-xl font-medium transition-all duration-300 bg-blue-600 text-white shadow-md">
                    <div class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>Video Sambutan</div>
                </button>
                <button onclick="switchTab('foto')" id="tabFoto" class="px-8 py-3 rounded-xl font-medium transition-all duration-300 text-gray-600 hover:text-gray-800">
                    <div class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>Foto & Sambutan</div>
                </button>
            </div>
        </div>

        <div id="videoTab" class="transition-all duration-500 scroll-reveal">
            <div class="max-w-5xl mx-auto">
                <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
                    <div class="relative bg-black">
                        <video id="kepsekVideo" class="w-full aspect-video object-cover" controls controlsList="nodownload">
                            <source src="{{ asset('videos/sambutan-kepsek.mp4') }}" type="video/mp4">
                        </video>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent pointer-events-none"></div>
                    </div>
                    <div class="p-6 md:p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <img src="{{ asset('images/Default.jpg') }}" class="w-16 h-16 rounded-full object-cover border-3 border-blue-100 shadow-md" alt="Kepala Sekolah">
                            <div><h3 class="text-2xl font-bold text-gray-800">Dra. Hj. Ariani</h3><p class="text-blue-600 font-medium">Kepala Sekolah</p></div>
                        </div>
                        <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                            <h4 class="font-semibold text-gray-800 mb-3 flex items-center gap-2"><svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>Pesan Singkat</h4>
                            <p class="text-gray-600 leading-relaxed">Assalamu'alaikum warahmatullahi wabarakatuh. Saya mengajak seluruh warga sekolah untuk bersama-sama menciptakan lingkungan belajar yang nyaman dan berkualitas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="fotoTab" class="hidden transition-all duration-500 scroll-reveal">
            <div class="grid lg:grid-cols-2 gap-12 items-start">
                <div>
                    <div class="bg-gradient-to-br from-blue-50 to-white rounded-3xl shadow-xl p-8 border border-blue-100 h-full">
                        <div class="flex flex-col items-center text-center mb-6">
                            <div class="relative mb-4">
                                <img src="{{ asset('images/Default.jpg') }}" class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-xl" alt="Kepala Sekolah">
                                <div class="absolute -bottom-2 -right-2 bg-blue-600 rounded-full p-2 shadow-lg"><svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-800">Dra. Hj. Ariani</h3>
                            <p class="text-blue-600 font-medium mb-2">Kepala Sekolah</p>
                            <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Periode 2023-2027</span>
                        </div>
                        <div class="space-y-4 text-gray-600 leading-relaxed">
                            <p class="font-semibold text-gray-800">Assalamu'alaikum warahmatullahi wabarakatuh,</p>
                            <p>Selamat datang di website resmi sekolah kami. Kami berkomitmen menciptakan lingkungan belajar yang inspiratif, inovatif, dan berkarakter.</p>
                            <p>Kami selalu berusaha memberikan yang terbaik bagi generasi penerus bangsa. Mari bersama kita wujudkan insan yang cerdas, beriman, dan berakhlak mulia.</p>
                            <p class="pt-2">Wassalamu'alaikum wr. wb.</p>
                        </div>
                    </div>
                </div>
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition duration-300">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-md"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg></div>
                            <h3 class="text-2xl font-bold text-gray-800">Visi Sekolah</h3>
                        </div>
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100"><p class="text-gray-700 leading-relaxed text-lg font-medium">"Menghasilkan lulusan yang bertaqwa, berprestasi, berbudaya dan berwawasan lingkungan"</p></div>
                    </div>
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition duration-300">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-md"><svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                            <h3 class="text-2xl font-bold text-gray-800">Misi Sekolah</h3>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3"><span class="text-purple-600 font-bold">1.</span><span class="text-gray-600">Terlaksananya pengamalan ajaran agama dan budaya dalam aktivitas keseharian.</span></li>
                            <li class="flex items-start gap-3"><span class="text-purple-600 font-bold">2.</span><span class="text-gray-600">Terwujudnya optimalisasi pemberdayaan tenaga pendidik dan kependidikan berdasarkan standar nasional pendidikan dan tenaga kependidikan.</span></li>
                            <li class="flex items-start gap-3"><span class="text-purple-600 font-bold">3.</span><span class="text-gray-600">Terwujudnya nilai-nilai kedisiplinan, ketertiban, kebersihan daya saing dan kerja keras</span></li>
                            <li class="flex items-start gap-3"><span class="text-purple-600 font-bold">4.</span><span class="text-gray-600">Terwujudnya inovasi pengembangan profesionalisme secara berkelanjutan.</span></li>
                            <li class="flex items-start gap-3"><span class="text-purple-600 font-bold">5.</span><span class="text-gray-600">Terwujudnya optimalisasi pemberdayaan seluruh komponen sekolah dalam upaya pengembangan potensi peserta didik secara maksimal.</span></li>
                            <li class="flex items-start gap-3"><span class="text-purple-600 font-bold">6.</span><span class="text-gray-600">Terwujudnya kesadaran peduli terhadap pelestarian lingkungan hidup.</span></li>
                            <li class="flex items-start gap-3"><span class="text-purple-600 font-bold">7.</span><span class="text-gray-600">Terwujudnya pemanfaatan lingkungan sebagai sumber belajar.</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- BERITA -->
<section id="berita" class="py-24 bg-gradient-to-b from-blue-50/30 to-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider scroll-reveal">Update Terkini</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2 mb-4 scroll-reveal">Berita Terbaru</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-blue-600 mx-auto rounded-full scroll-reveal"></div>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto scroll-reveal">Informasi terkini seputar kegiatan dan prestasi sekolah kami</p>
        </div>

        @if($beritas->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($beritas->take(6) as $berita)
            @php
                $images = is_array($berita->images) ? $berita->images : (json_decode($berita->images, true) ?? []);
                $firstImage = !empty($images) ? $images[0] : null;
            @endphp
            <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer transform hover:-translate-y-2 overflow-hidden scroll-reveal" onclick="showBeritaDetail({{ $berita->id }})">
                <div class="relative h-56 overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200">
                    @if(!empty($firstImage))
                        @php $imageSrc = (!str_starts_with($firstImage, 'data:image') && !filter_var($firstImage, FILTER_VALIDATE_URL)) ? asset('storage/' . $firstImage) : $firstImage; @endphp
                        <img src="{{ $imageSrc }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="{{ $berita->judul }}">
                    @else
                        <div class="w-full h-full flex items-center justify-center"><svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                    @endif
                    <div class="absolute top-4 left-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white px-3 py-1.5 rounded-xl text-xs font-semibold shadow-lg">{{ \Carbon\Carbon::parse($berita->tanggal)->format('d M Y') }}</div>
                    @if($berita->kategori)<div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-blue-700 px-3 py-1 rounded-lg text-xs font-semibold shadow-md">{{ $berita->kategori }}</div>@endif
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-2 line-clamp-2 hover:text-blue-600 transition">{{ $berita->judul }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-3 leading-relaxed">{{ strip_tags(\Illuminate\Support\Str::limit($berita->isi, 100)) }}</p>
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div class="flex items-center gap-2"><div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-100 to-blue-200 flex items-center justify-center"><svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></div><span class="text-sm text-gray-500 font-medium">{{ $berita->author }}</span></div>
                        <div class="flex items-center gap-1 text-blue-600 group-hover:gap-2 transition-all duration-300"><span class="text-sm font-semibold">Baca</span><svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12 scroll-reveal">
            <a href="{{ route('berita.index') }}" class="inline-flex items-center gap-3 bg-white hover:bg-blue-50 text-blue-600 font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl border-2 border-blue-600 transition-all duration-300 transform hover:-translate-y-1">
                <span>Tampilkan Selengkapnya</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
            <p class="text-gray-500 mt-4 text-sm">Total {{ \App\Models\Berita::count() }} berita tersedia</p>
        </div>
        @else
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 p-16 rounded-3xl text-center scroll-reveal">
            <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6"><svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg></div>
            <p class="text-gray-600 text-xl font-semibold">Belum ada berita terbaru</p>
            <p class="text-gray-400 mt-2">Silahkan tunggu update informasi dari kami</p>
        </div>
        @endif
    </div>
</section>

<!-- MODAL BERITA -->
<div id="beritaModal" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm">
    <div id="modalContainer" class="absolute bottom-0 w-full h-[95vh] bg-white rounded-t-3xl shadow-2xl transform translate-y-full transition-transform duration-500 ease-out flex flex-col">
        <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto mt-3 mb-2 cursor-pointer hover:bg-gray-400 transition" onclick="closeModal()"></div>
        <button onclick="closeModal()" class="absolute right-4 top-4 z-20 bg-white rounded-full p-2 shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300"><svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        <div id="beritaContent" class="flex-1 overflow-y-auto">
            <div id="loadingState" class="flex flex-col items-center justify-center h-full py-16"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600"></div><p class="mt-4 text-gray-500">Memuat berita...</p></div>
            <div id="beritaDetailContent" class="hidden">
                <div class="relative bg-black/5">
                    <div id="imageSlider" class="flex overflow-x-auto snap-x snap-mandatory scroll-smooth"></div>
                    <button onclick="prevImage()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg transition-all duration-300"><svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                    <button onclick="nextImage()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 shadow-lg transition-all duration-300"><svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
                    <div id="imageCounter" class="absolute bottom-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm">1/1</div>
                </div>
                <div class="p-6">
                    <h1 id="modalTitle" class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 leading-tight"></h1>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-6 pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><span id="modalDate"></span></div>
                        <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                        <div class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg><span id="modalAuthor" class="font-medium text-blue-600"></span></div>
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
    <button class="absolute top-4 right-4 text-white bg-white/20 rounded-full p-2 hover:bg-white/30 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
</div>

<!-- FASILITAS SEKOLAH -->
<section id="fasilitas" class="py-24 bg-gradient-to-b from-blue-50/30 via-white to-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider scroll-reveal">Sarana & Prasarana</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2 mb-4 scroll-reveal">Fasilitas Sekolah</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-blue-600 mx-auto rounded-full scroll-reveal"></div>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto scroll-reveal">Fasilitas modern dan lengkap untuk mendukung kegiatan belajar mengajar</p>
        </div>
        
        @if(isset($fasilitasList) && $fasilitasList->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($fasilitasList as $f)
            <div class="fasilitas-card group relative bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all duration-300 scroll-reveal">
                <div class="relative h-56 overflow-hidden">
                    @if($f->gambar)
                        <img src="{{ asset('storage/' . $f->gambar) }}" alt="{{ $f->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4 text-white"><h3 class="text-xl font-bold">{{ $f->nama }}</h3></div>
                    @if($f->kategori)<div class="absolute top-4 right-4"><span class="px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs rounded-full">{{ ucfirst(str_replace('_', ' ', $f->kategori)) }}</span></div>@endif
                </div>
                <div class="fasilitas-overlay absolute inset-0 bg-gradient-to-t from-blue-900/95 via-blue-800/85 to-blue-700/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6 text-white">
                    <h3 class="text-xl font-bold mb-2">{{ $f->nama }}</h3>
                    <p class="text-sm text-blue-100 mb-4 line-clamp-3">{{ $f->deskripsi ?? 'Fasilitas modern untuk mendukung kegiatan belajar mengajar.' }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">{{ $f->info_tambahan ?? $f->jumlah . ' Unit' }}</span>
                        <a href="{{ route('fasilitas.index') }}" class="text-sm font-medium flex items-center gap-1 hover:underline">Lihat Selengkapnya<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12 scroll-reveal">
            <a href="{{ route('fasilitas.index') }}" class="inline-flex items-center gap-2 bg-white border-2 border-blue-600 text-blue-600 font-semibold px-8 py-3 rounded-full hover:bg-blue-50 transition-all shadow-md hover:shadow-lg">
                <span>Lihat Semua Fasilitas</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        @else
        <div class="text-center py-12"><div class="bg-blue-50 rounded-2xl p-8 inline-block"><svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg><p class="text-gray-600">Belum ada data fasilitas</p></div></div>
        @endif
    </div>
</section>

<!-- GALERI KEGIATAN -->
<section id="galeri" class="py-24 bg-gradient-to-b from-white to-sky-50/30">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider scroll-reveal">Dokumentasi</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2 mb-4 scroll-reveal">Galeri Kegiatan</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-blue-600 mx-auto rounded-full scroll-reveal"></div>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto scroll-reveal">Momen berharga dari berbagai kegiatan dan prestasi sekolah kami</p>
        </div>
        
        @if(isset($galeriList) && $galeriList->count() > 0)
        <div class="flex justify-center mb-12 flex-wrap gap-3 scroll-reveal">
            <button class="filter-gallery-btn active px-6 py-2 bg-purple-600 text-white rounded-full text-sm font-medium shadow-md" data-filter="all">Semua</button>
            @php $kategoris = $galeriList->pluck('kategori')->unique(); @endphp
            @foreach($kategoris as $kat)
            <button class="filter-gallery-btn px-6 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium hover:bg-gray-200 transition" data-filter="{{ $kat }}">{{ $kat }}</button>
            @endforeach
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($galeriList as $index => $g)
            <div class="gallery-item group relative overflow-hidden rounded-xl cursor-pointer scroll-reveal" data-category="{{ $g->kategori }}" onclick="window.location='{{ route('galeri.show', $g->slug) }}'">
                <div class="aspect-square overflow-hidden">
                    @if($g->gambar_utama)<img src="{{ asset('storage/' . $g->gambar_utama) }}" alt="{{ $g->judul }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else<div class="w-full h-full bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center"><svg class="w-12 h-12 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>@endif
                </div>
                <div class="galeri-overlay absolute inset-0 bg-gradient-to-t from-purple-900/90 via-purple-800/80 to-purple-700/70 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4 text-white">
                    <h4 class="font-bold text-lg">{{ $g->judul }}</h4>
                    <p class="text-sm text-purple-100 line-clamp-2">{{ $g->deskripsi ?? 'Dokumentasi kegiatan sekolah.' }}</p>
                    <div class="flex items-center justify-between mt-3">
                        <span class="text-xs bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full">{{ $g->kategori }}</span>
                        <span class="text-xs flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>{{ $g->views ?? 0 }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12 scroll-reveal">
            <a href="{{ route('galeri.index') }}" class="inline-flex items-center gap-2 bg-white border-2 border-purple-600 text-purple-600 font-semibold px-8 py-3 rounded-full hover:bg-purple-50 transition-all shadow-md hover:shadow-lg">
                <span>Lihat Semua Galeri</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        @else
        <div class="text-center py-12"><div class="bg-purple-50 rounded-2xl p-8 inline-block"><svg class="w-16 h-16 text-purple-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg><p class="text-gray-600">Belum ada data galeri</p></div></div>
        @endif
    </div>
</section>

<!-- STAFF SEKOLAH & GURU -->
<section id="staff" class="py-24 relative overflow-hidden bg-gradient-to-br from-sky-50/50 via-white to-blue-50/30">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-80 h-80 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-80 h-80 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl"></div>
    </div>
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider scroll-reveal">Tenaga Pendidik</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2 mb-4 scroll-reveal">Staff & Guru</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-blue-600 mx-auto rounded-full scroll-reveal"></div>
            <p class="text-gray-600 mt-4 max-w-2xl mx-auto scroll-reveal">Tenaga pendidik profesional dan berdedikasi yang siap membimbing siswa</p>
        </div>

        <div class="flex justify-center mb-12 scroll-reveal">
            <div class="inline-flex bg-white/80 backdrop-blur-sm rounded-2xl p-1.5 shadow-lg border border-gray-200">
                <button onclick="switchStaffTab('guru')" id="tabGuru" class="px-8 py-3 rounded-xl font-medium transition-all duration-300 bg-blue-600 text-white shadow-md">
                    <span class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>Dewan Guru</span>
                </button>
                <button onclick="switchStaffTab('staff')" id="tabStaff" class="px-8 py-3 rounded-xl font-medium transition-all duration-300 text-gray-600 hover:text-gray-800">
                    <span class="flex items-center gap-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7a4 4 0 100-8 4 4 0 000 8z"></path></svg>Staff Tata Usaha</span>
                </button>
            </div>
        </div>

        <div id="guruTab" class="transition-all duration-500">
            @if($gurus->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($gurus as $guru)
                <div class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 scroll-reveal">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-4">
                            @if($guru->foto)<img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama }}" class="w-28 h-28 rounded-full object-cover border-4 shadow-md">
                            @else<div class="w-28 h-28 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center border-4 shadow-md"><svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>@endif
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg mb-1">{{ $guru->nama }}</h3>
                        <p class="font-medium text-sm mb-1 text-blue-600">{{ $guru->jabatan }}</p>
                        @if($guru->pangkat)<p class="text-gray-500 text-sm">{{ $guru->pangkat }}</p>@endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12"><div class="bg-blue-50 rounded-2xl p-8 inline-block"><svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg><p class="text-gray-600">Belum ada data guru</p></div></div>
            @endif
        </div>

        <div id="staffTab" class="hidden transition-all duration-500">
            @if($staffs->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($staffs as $staff)
                <div class="group bg-white rounded-2xl shadow-lg p-6 border border-gray-100 hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 scroll-reveal">
                    <div class="flex flex-col items-center text-center">
                        <div class="mb-4">
                            @if($staff->foto)<img src="{{ asset('storage/' . $staff->foto) }}" alt="{{ $staff->nama }}" class="w-28 h-28 rounded-full object-cover border-4 shadow-md">
                            @else<div class="w-28 h-28 rounded-full bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center border-4 shadow-md"><svg class="w-12 h-12 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7a4 4 0 100-8 4 4 0 000 8z"></path></svg></div>@endif
                        </div>
                        <h3 class="font-bold text-gray-800 text-lg mb-1">{{ $staff->nama }}</h3>
                        <p class="font-medium text-sm mb-1 text-green-600">{{ $staff->jabatan }}</p>
                        @if($staff->pangkat)<p class="text-gray-500 text-sm">{{ $staff->pangkat }}</p>@endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-12"><div class="bg-green-50 rounded-2xl p-8 inline-block"><svg class="w-16 h-16 text-green-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7a4 4 0 100-8 4 4 0 000 8z"></path></svg><p class="text-gray-600">Belum ada data staff</p></div></div>
            @endif
        </div>

        <div class="text-center mt-8 scroll-reveal">
            <a href="{{ route('pegawai.index') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-8 py-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <span>Lihat Semua Staff & Guru</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</section>

<!-- EKSTRAKURIKULER -->
<section id="eskul" class="py-24 bg-gradient-to-b from-white to-yellow-50/30">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-yellow-600 font-semibold text-sm uppercase tracking-wider scroll-reveal">Kegiatan</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2 mb-4 scroll-reveal">Ekstrakurikuler</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-yellow-500 to-orange-500 mx-auto rounded-full scroll-reveal"></div>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto scroll-reveal">Berbagai kegiatan ekstrakurikuler untuk mengembangkan minat dan bakat siswa</p>
        </div>

        @php
            $eskulList = \App\Models\Ekstrakurikuler::where('is_active', true)->orderBy('nama', 'asc')->limit(8)->get();
        @endphp
        
        @if($eskulList->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($eskulList as $eskul)
            <a href="{{ route('ekstrakurikuler.show', $eskul->slug) }}" class="group relative bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 scroll-reveal">
                <div class="relative h-48 overflow-hidden bg-gradient-to-br from-yellow-50 to-orange-50">
                    @if($eskul->logo)<img src="{{ asset('storage/' . $eskul->logo) }}" alt="{{ $eskul->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @elseif($eskul->background)<img src="{{ asset('storage/' . $eskul->background) }}" alt="{{ $eskul->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else<div class="w-full h-full flex items-center justify-center"><svg class="w-16 h-16 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>@endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4"><h3 class="text-white font-bold text-lg drop-shadow-lg line-clamp-1">{{ $eskul->nama }}</h3></div>
                    <div class="absolute top-3 right-3"><span class="px-2 py-1 bg-green-500/80 backdrop-blur-sm text-white text-xs rounded-full shadow-md">Aktif</span></div>
                </div>
                <div class="p-4">
                    @if($eskul->pembina)<p class="text-sm text-gray-600 flex items-center gap-1 mb-2"><svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg><span class="truncate">{{ $eskul->pembina }}</span></p>@endif
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        @if($eskul->jumlah_anggota)<span>{{ $eskul->jumlah_anggota }} Anggota</span>@endif
                        <span class="text-yellow-600 font-medium flex items-center gap-1 group-hover:gap-2 transition-all">Lihat<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="text-center mt-12 scroll-reveal">
            <a href="{{ route('ekstrakurikuler.index') }}" class="inline-flex items-center gap-2 bg-white border-2 border-yellow-500 text-yellow-600 font-semibold px-8 py-3 rounded-full hover:bg-yellow-50 transition-all shadow-md hover:shadow-lg">
                <span>Lihat Semua Ekstrakurikuler</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
            <p class="text-gray-500 mt-3 text-sm">Total {{ \App\Models\Ekstrakurikuler::where('is_active', true)->count() }} ekstrakurikuler aktif</p>
        </div>
        @else
        <div class="text-center py-12"><div class="bg-yellow-50 rounded-2xl p-8 inline-block"><svg class="w-16 h-16 text-yellow-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg><p class="text-gray-600">Belum ada data ekstrakurikuler</p></div></div>
        @endif
    </div>
</section>

<!-- ALUMNI SEKOLAH -->
<section id="alumni" class="py-24 bg-gradient-to-br from-blue-50/30 via-white to-sky-50/50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <span class="text-blue-600 font-semibold text-sm uppercase tracking-wider scroll-reveal">Keluarga Besar</span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mt-2 mb-4 scroll-reveal">Alumni Sekolah</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-blue-600 mx-auto rounded-full scroll-reveal"></div>
            <p class="text-gray-500 mt-4 max-w-2xl mx-auto scroll-reveal">Testimoni dan jejak karir para alumni yang telah sukses di berbagai bidang</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-6 text-center scroll-reveal"><div class="text-3xl font-bold text-blue-600 counter" data-target="{{ $statsAlumni['total'] ?? 0 }}">{{ $statsAlumni['total'] ?? 0 }}</div><p class="text-gray-600 mt-2">Total Alumni</p></div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6 text-center scroll-reveal"><div class="text-3xl font-bold text-green-600 counter" data-target="{{ $statsAlumni['universitas'] ?? 0 }}">{{ $statsAlumni['universitas'] ?? 0 }}</div><p class="text-gray-600 mt-2">Universitas</p></div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6 text-center scroll-reveal"><div class="text-3xl font-bold text-purple-600 counter" data-target="{{ $statsAlumni['provinsi'] ?? 0 }}">{{ $statsAlumni['provinsi'] ?? 0 }}</div><p class="text-gray-600 mt-2">Provinsi</p></div>
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-6 text-center scroll-reveal"><div class="text-3xl font-bold text-orange-600 counter" data-target="{{ $statsAlumni['angkatan'] ?? 0 }}">{{ $statsAlumni['angkatan'] ?? 0 }}</div><p class="text-gray-600 mt-2">Angkatan</p></div>
        </div>
        
        <div class="flex flex-col md:flex-row items-center justify-center gap-4 mb-12 scroll-reveal">
            <a href="{{ route('alumni.index') }}" class="inline-flex items-center gap-2 bg-white border-2 border-blue-600 text-blue-600 font-semibold px-6 py-3 rounded-full hover:bg-blue-50 transition-all">
                <span>Lihat Semua Alumni</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
        
        <div class="max-w-2xl mx-auto scroll-reveal">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-xl">
                <h3 class="text-2xl font-bold mb-3 text-center">Bergabung dengan Jaringan Alumni</h3>
                <p class="text-center text-blue-100 mb-6">Daftarkan diri Anda dan tetap terhubung dengan almamater</p>
                <form action="{{ route('alumni.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid md:grid-cols-2 gap-4">
                        <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <select name="tahun_lulus" required class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-white/50">
                            <option value="" class="text-gray-800">Tahun Lulus</option>
                            @for($y = date('Y'); $y >= 1980; $y--)<option value="{{ $y }}" class="text-gray-800">{{ $y }}</option>@endfor
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-white text-blue-600 py-3 rounded-xl font-semibold hover:bg-gray-100 transition">Daftar Sekarang</button>
                    <p class="text-center text-blue-100 text-xs mt-2">Data Anda akan diverifikasi oleh admin sebelum ditampilkan</p>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Floating SPMB Icon --}}
@php $spmbAktif = \App\Models\Spmb::aktif()->exists(); @endphp
@if($spmbAktif)
<a href="{{ route('spmb.index') }}" class="fixed bottom-6 right-6 z-50 group animate-bounce-slow">
    <div class="absolute bottom-full right-0 mb-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
        <div class="bg-gray-800 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-lg whitespace-nowrap">SPMB SMAN 12 Makassar<div class="absolute top-full right-6 w-0 h-0 border-l-8 border-l-transparent border-r-8 border-r-transparent border-t-8 border-t-gray-800"></div></div>
    </div>
    <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-full shadow-xl flex items-center justify-center hover:shadow-2xl transform hover:scale-110 transition-all duration-300">
        <x-maki-school class="w-8 h-8 text-white" />
    </div>
    <div class="absolute inset-0 rounded-full bg-blue-400 animate-ping opacity-30"></div>
</a>
@endif

<style>
@keyframes countUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
@keyframes bounce-slow { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
.counter { animation: countUp 0.8s ease-out forwards; }
.animate-fade-in { animation: fadeIn 1s ease-out forwards; }
.animate-slide-up { animation: slideUp 0.8s ease-out 0.3s forwards; opacity: 0; }
.animate-bounce-slow { animation: bounce-slow 3s ease-in-out infinite; }
#hero-bg { transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 1.2s cubic-bezier(0.4, 0, 0.2, 1); }
#imageSlider::-webkit-scrollbar { display: none; }
#imageSlider { -ms-overflow-style: none; scrollbar-width: none; }
.snap-x > div { min-width: 100%; height: 280px; scroll-snap-align: start; }
@media(min-width: 768px){ .snap-x > div { height: 420px; } }
.line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
.aspect-video { aspect-ratio: 16 / 9; }
.aspect-square { aspect-ratio: 1 / 1; }
.filter-gallery-btn.active { background: #2563eb !important; color: white !important; }
.gallery-item.hidden { display: none; }
@media (max-width: 768px) { .fasilitas-card:active .fasilitas-overlay, .gallery-item:active .galeri-overlay { opacity: 1 !important; } }
.scroll-reveal { opacity: 0; transform: translateY(30px); transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
.scroll-reveal.revealed { opacity: 1; transform: translateY(0); }
</style>

<script>
const heroImages = ["{{ asset('images/Gambar 1.jpeg') }}", "{{ asset('images/Gambar 2.jpeg') }}"];
let heroIndex = 0;
const heroBg = document.getElementById("hero-bg");
let currentImages = [], currentIndex = 0;

function switchTab(tab) {
    const videoTab = document.getElementById('videoTab'), fotoTab = document.getElementById('fotoTab');
    const tabVideoBtn = document.getElementById('tabVideo'), tabFotoBtn = document.getElementById('tabFoto');
    if (tab === 'video') {
        videoTab.classList.remove('hidden'); fotoTab.classList.add('hidden');
        tabVideoBtn.classList.add('bg-blue-600', 'text-white', 'shadow-md'); tabVideoBtn.classList.remove('text-gray-600');
        tabFotoBtn.classList.remove('bg-blue-600', 'text-white', 'shadow-md'); tabFotoBtn.classList.add('text-gray-600');
    } else {
        videoTab.classList.add('hidden'); fotoTab.classList.remove('hidden');
        tabFotoBtn.classList.add('bg-blue-600', 'text-white', 'shadow-md'); tabFotoBtn.classList.remove('text-gray-600');
        tabVideoBtn.classList.remove('bg-blue-600', 'text-white', 'shadow-md'); tabVideoBtn.classList.add('text-gray-600');
    }
}

function switchStaffTab(tab) {
    const guruTab = document.getElementById('guruTab'), staffTab = document.getElementById('staffTab');
    const tabGuruBtn = document.getElementById('tabGuru'), tabStaffBtn = document.getElementById('tabStaff');
    if (tab === 'guru') {
        guruTab.classList.remove('hidden'); staffTab.classList.add('hidden');
        tabGuruBtn.classList.add('bg-blue-600', 'text-white', 'shadow-md'); tabGuruBtn.classList.remove('text-gray-600');
        tabStaffBtn.classList.remove('bg-green-600', 'text-white', 'shadow-md'); tabStaffBtn.classList.add('text-gray-600');
    } else {
        guruTab.classList.add('hidden'); staffTab.classList.remove('hidden');
        tabStaffBtn.classList.add('bg-green-600', 'text-white', 'shadow-md'); tabStaffBtn.classList.remove('text-gray-600');
        tabGuruBtn.classList.remove('bg-blue-600', 'text-white', 'shadow-md'); tabGuruBtn.classList.add('text-gray-600');
    }
}

function initScrollReveal() {
    const revealElements = document.querySelectorAll('.scroll-reveal');
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => { if (entry.isIntersecting) { entry.target.classList.add('revealed'); revealObserver.unobserve(entry.target); } });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
    revealElements.forEach(el => revealObserver.observe(el));
}

function preloadImages(imageArray) { imageArray.forEach(src => { const img = new Image(); img.src = src; }); }
function changeHeroImage() {
    if (!heroBg) return;
    heroBg.style.opacity = '0.7'; heroBg.style.transform = 'scale(1.15)';
    setTimeout(() => { heroIndex = (heroIndex + 1) % heroImages.length; heroBg.src = heroImages[heroIndex]; setTimeout(() => { heroBg.style.opacity = '1'; heroBg.style.transform = 'scale(1.1)'; }, 50); }, 300);
}

function showBeritaDetail(id) {
    const modal = document.getElementById('beritaModal'), container = document.getElementById('modalContainer');
    const loadingState = document.getElementById('loadingState'), detailContent = document.getElementById('beritaDetailContent');
    modal.classList.remove('hidden'); loadingState.classList.remove('hidden'); detailContent.classList.add('hidden');
    document.body.style.overflow = 'hidden';
    setTimeout(() => container.classList.remove('translate-y-full'), 50);
    fetch(`/berita/${id}`).then(res => res.json()).then(res => {
        if (res.success) {
            const berita = res.data;
            currentImages = (berita.images || []).filter(img => img && img.trim() !== '');
            document.getElementById('modalTitle').textContent = berita.judul;
            document.getElementById('modalAuthor').textContent = berita.author;
            document.getElementById('modalDate').textContent = new Date(berita.tanggal).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            document.getElementById('modalContentText').innerHTML = (berita.isi || '').split('\n').filter(p => p.trim()).map(p => `<p>${p}</p>`).join('');
            const slider = document.getElementById('imageSlider'); slider.innerHTML = '';
            if (currentImages.length === 0) {
                slider.innerHTML = `<div class="snap-center flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200"><div class="text-center"><svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg><p class="text-gray-500 mt-2">Tidak ada gambar</p></div></div>`;
                document.getElementById('imageCounter').style.display = 'none';
            } else {
                currentImages.forEach((img) => { const d = document.createElement('div'); d.className = "snap-center flex items-center justify-center bg-black/5"; d.innerHTML = `<img src="${img.startsWith('data:image')||img.startsWith('http')?img:'/storage/'+img}" class="w-full h-full object-contain cursor-pointer" onclick="zoomImage('${img.startsWith('data:image')||img.startsWith('http')?img:'/storage/'+img}')">`; slider.appendChild(d); });
                document.getElementById('imageCounter').style.display = 'block'; updateImageCounter();
            }
            loadingState.classList.add('hidden'); detailContent.classList.remove('hidden');
        }
    }).catch(() => { loadingState.innerHTML = '<div class="text-red-500 text-center py-8">Terjadi kesalahan</div>'; });
}

function closeModal() { document.getElementById('modalContainer').classList.add('translate-y-full'); setTimeout(() => { document.getElementById('beritaModal').classList.add('hidden'); document.body.style.overflow = ''; }, 300); }
function updateImageCounter() { const s = document.getElementById('imageSlider'); if(s&&currentImages.length){ const w=s.clientWidth; if(w>0){currentIndex=Math.round(s.scrollLeft/w); document.getElementById('imageCounter').textContent=`${currentIndex+1}/${currentImages.length}`;} } }
function prevImage() { if(currentIndex>0) document.getElementById('imageSlider').scrollTo({left:(currentIndex-1)*document.getElementById('imageSlider').clientWidth,behavior:"smooth"}); }
function nextImage() { if(currentIndex<currentImages.length-1) document.getElementById('imageSlider').scrollTo({left:(currentIndex+1)*document.getElementById('imageSlider').clientWidth,behavior:"smooth"}); }
function zoomImage(src) { document.getElementById('zoomViewer').classList.remove('hidden'); document.getElementById('zoomImage').src=src; document.body.style.overflow='hidden'; }
function closeZoom() { document.getElementById('zoomViewer').classList.add('hidden'); document.body.style.overflow=''; }

document.addEventListener('DOMContentLoaded', function() {
    initScrollReveal();
    const counters = document.querySelectorAll('.counter');
    const animateCounter = (c) => { const t=parseInt(c.getAttribute('data-target')); let cur=0; const inc=t/50; const upd=()=>{cur+=inc; if(cur<t){c.textContent=Math.ceil(cur); requestAnimationFrame(upd);}else{c.textContent=t;} }; upd(); };
    const counterObs = new IntersectionObserver((e)=>{e.forEach(en=>{if(en.isIntersecting){animateCounter(en.target);counterObs.unobserve(en.target);}})},{threshold:0.5});
    counters.forEach(c=>counterObs.observe(c));
    
    document.querySelectorAll('.filter-gallery-btn').forEach(b=>{b.addEventListener('click',function(){document.querySelectorAll('.filter-gallery-btn').forEach(x=>{x.classList.remove('active','bg-purple-600','text-white');x.classList.add('bg-gray-100','text-gray-700');});this.classList.remove('bg-gray-100','text-gray-700');this.classList.add('active','bg-purple-600','text-white');document.querySelectorAll('.gallery-item').forEach(i=>{i.classList.toggle('hidden',this.dataset.filter!=='all'&&i.dataset.category!==this.dataset.filter);});});});
    
    document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',function(e){const h=this.getAttribute('href');if(h==="#"||h==="")return;const t=document.querySelector(h);if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'});}});});
    
    document.getElementById('imageSlider')?.addEventListener('scroll',updateImageCounter);
    document.addEventListener('keydown',(e)=>{if(e.key==="Escape"){closeModal();closeZoom();}});
    document.getElementById('beritaModal')?.addEventListener('click',function(e){if(e.target===this)closeModal();});
});

if(heroBg){preloadImages(heroImages);setInterval(changeHeroImage,5000);}
</script>

@endsection