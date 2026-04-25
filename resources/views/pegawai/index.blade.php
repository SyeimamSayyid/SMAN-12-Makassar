@extends('layouts.app')

@section('title', 'Staff & Guru - Website Resmi Sekolah')

@section('content')

{{-- Hero Section --}}
<section class="pt-28 pb-12 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800">
    <div class="container mx-auto px-6">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Staff & Guru</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto">Tenaga pendidik profesional dan berdedikasi yang siap membimbing siswa</p>
            
            {{-- Breadcrumb --}}
            <div class="flex items-center justify-center gap-2 mt-6 text-sm text-blue-200">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-white">Staff & Guru</span>
            </div>
        </div>
    </div>
</section>

{{-- Content Section --}}
<section class="py-16 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-6">
        
        {{-- 1. KEPALA SEKOLAH --}}
        @if($kepalaSekolah)
        <div class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Kepala Sekolah</h2>
            </div>
            
            <div class="max-w-md mx-auto">
                <div class="bg-white rounded-3xl shadow-xl p-8 border border-purple-100">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-4">
                            @if($kepalaSekolah->foto)
                                <img src="{{ asset('storage/' . $kepalaSekolah->foto) }}" 
                                     alt="{{ $kepalaSekolah->nama }}" 
                                     class="w-36 h-36 rounded-full object-cover border-4 border-purple-200 shadow-lg">
                            @else
                                <div class="w-36 h-36 rounded-full bg-gradient-to-br from-purple-50 to-purple-100 flex items-center justify-center border-4 border-purple-200 shadow-lg">
                                    <svg class="w-16 h-16 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute -bottom-2 -right-2 bg-gradient-to-r from-purple-500 to-purple-600 rounded-full p-2 shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $kepalaSekolah->nama }}</h3>
                        <p class="text-purple-600 font-medium mb-2">{{ $kepalaSekolah->jabatan }}</p>
                        @if($kepalaSekolah->pangkat)
                            <p class="text-gray-500 text-sm">{{ $kepalaSekolah->pangkat }}</p>
                        @endif
                        
                        <div class="flex gap-2 mt-4">
                            @if($kepalaSekolah->instagram)
                            <a href="https://instagram.com/{{ $kepalaSekolah->instagram }}" target="_blank" 
                               class="w-10 h-10 bg-purple-50 rounded-full flex items-center justify-center text-purple-600 hover:bg-purple-100 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0 10.837c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"/>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- 2. WAKIL KEPALA SEKOLAH --}}
        @if($wakilKepalaSekolah->count() > 0)
        <div class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Wakil Kepala Sekolah</h2>
            </div>
            
            <div class="grid md:grid-cols-3 gap-6">
                @foreach($wakilKepalaSekolah as $wakil)
                <div class="bg-white rounded-2xl shadow-lg p-6 border border-orange-100 hover:shadow-xl transition-all duration-300">
                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-4">
                            @if($wakil->foto)
                                <img src="{{ asset('storage/' . $wakil->foto) }}" 
                                     alt="{{ $wakil->nama }}" 
                                     class="w-28 h-28 rounded-full object-cover border-4 border-orange-200 shadow-md">
                            @else
                                <div class="w-28 h-28 rounded-full bg-gradient-to-br from-orange-50 to-orange-100 flex items-center justify-center border-4 border-orange-200 shadow-md">
                                    <svg class="w-12 h-12 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-gray-800 text-lg mb-1">{{ $wakil->nama }}</h3>
                        <p class="text-orange-600 font-medium text-sm mb-1">{{ $wakil->jabatan }}</p>
                        @if($wakil->pangkat)
                            <p class="text-gray-500 text-sm">{{ $wakil->pangkat }}</p>
                        @endif
                        
                        @if($wakil->instagram)
                        <div class="flex gap-2 mt-3">
                            <a href="https://instagram.com/{{ $wakil->instagram }}" target="_blank" 
                               class="w-8 h-8 bg-orange-50 rounded-full flex items-center justify-center text-orange-600 hover:bg-orange-100 transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                                </svg>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- 3. GURU (Dikelompokkan berdasarkan Mata Pelajaran) --}}
        @if($gurus->count() > 0)
        <div class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Dewan Guru</h2>
            </div>
            
            @foreach($guruByMapel as $mapel => $guruGroup)
            <div class="mb-10">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-1 h-6 bg-blue-500 rounded-full"></div>
                    <h3 class="text-xl font-bold text-gray-700">{{ $mapel ?: 'Mata Pelajaran Umum' }}</h3>
                    <span class="text-sm text-gray-400 ml-2">({{ $guruGroup->count() }} Guru)</span>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($guruGroup as $guru)
                    <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                @if($guru->foto)
                                    <img src="{{ asset('storage/' . $guru->foto) }}" 
                                         alt="{{ $guru->nama }}" 
                                         class="w-16 h-16 rounded-full object-cover border-2 border-blue-200">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center border-2 border-blue-200">
                                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-800 text-sm truncate">{{ $guru->nama }}</h4>
                                <p class="text-xs text-blue-600">{{ $guru->pangkat ?: 'Guru' }}</p>
                                @if($guru->instagram)
                                <a href="https://instagram.com/{{ $guru->instagram }}" target="_blank" 
                                   class="inline-flex items-center gap-1 text-xs text-gray-400 hover:text-blue-600 mt-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                                    </svg>
                                    <span class="truncate">{{ $guru->instagram }}</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- 4. STAFF TATA USAHA --}}
        @if($staffs->count() > 0)
        <div>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7a4 4 0 100-8 4 4 0 000 8z"></path>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-800">Staff Tata Usaha</h2>
            </div>
            
            @foreach($staffByBidang as $bidang => $staffGroup)
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-5">
                    <div class="w-1 h-6 bg-green-500 rounded-full"></div>
                    <h3 class="text-xl font-bold text-gray-700">{{ $bidang ?: 'Staff' }}</h3>
                    <span class="text-sm text-gray-400 ml-2">({{ $staffGroup->count() }} Staff)</span>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5">
                    @foreach($staffGroup as $staff)
                    <div class="bg-white rounded-xl shadow-md p-5 border border-gray-100 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-4">
                            <div class="flex-shrink-0">
                                @if($staff->foto)
                                    <img src="{{ asset('storage/' . $staff->foto) }}" 
                                         alt="{{ $staff->nama }}" 
                                         class="w-16 h-16 rounded-full object-cover border-2 border-green-200">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-green-50 to-green-100 flex items-center justify-center border-2 border-green-200">
                                        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21v-2a4 4 0 00-4-4H9a4 4 0 00-4 4v2"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 7a4 4 0 100-8 4 4 0 000 8z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-800 text-sm truncate">{{ $staff->nama }}</h4>
                                <p class="text-xs text-green-600">{{ $staff->pangkat ?: 'Staff' }}</p>
                                @if($staff->instagram)
                                <a href="https://instagram.com/{{ $staff->instagram }}" target="_blank" 
                                   class="inline-flex items-center gap-1 text-xs text-gray-400 hover:text-green-600 mt-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/>
                                    </svg>
                                    <span class="truncate">{{ $staff->instagram }}</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Back to Home Button --}}
        <div class="text-center mt-16">
            <a href="{{ route('home') }}" 
               class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-6 py-3 rounded-full transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</section>

{{-- Pattern Background --}}
<style>
.education-pattern {
    background-color: #f8fafc;
    background-image: 
        radial-gradient(circle at 10% 20%, rgba(59, 130, 246, 0.03) 0%, transparent 30%),
        radial-gradient(circle at 90% 70%, rgba(16, 185, 129, 0.03) 0%, transparent 40%),
        repeating-linear-gradient(45deg, rgba(59, 130, 246, 0.02) 0px, rgba(59, 130, 246, 0.02) 2px, transparent 2px, transparent 15px);
}
</style>

<script>
function switchStaffTab(tab) {
    const guruTab = document.getElementById('guruTab');
    const staffTab = document.getElementById('staffTab');
    const tabGuruBtn = document.getElementById('tabGuru');
    const tabStaffBtn = document.getElementById('tabStaff');
    
    if (tab === 'guru') {
        guruTab.classList.remove('hidden');
        staffTab.classList.add('hidden');
        tabGuruBtn.classList.add('bg-blue-600', 'text-white', 'shadow-md');
        tabGuruBtn.classList.remove('text-gray-600', 'hover:text-gray-800');
        tabStaffBtn.classList.remove('bg-green-600', 'text-white', 'shadow-md');
        tabStaffBtn.classList.add('text-gray-600', 'hover:text-gray-800');
    } else {
        guruTab.classList.add('hidden');
        staffTab.classList.remove('hidden');
        tabStaffBtn.classList.add('bg-green-600', 'text-white', 'shadow-md');
        tabStaffBtn.classList.remove('text-gray-600', 'hover:text-gray-800');
        tabGuruBtn.classList.remove('bg-blue-600', 'text-white', 'shadow-md');
        tabGuruBtn.classList.add('text-gray-600', 'hover:text-gray-800');
    }
}
</script>
@endsection