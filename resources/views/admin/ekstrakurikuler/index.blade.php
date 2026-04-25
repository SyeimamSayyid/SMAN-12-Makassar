@extends('layouts.admin')

@section('title', 'Kelola Ekstrakurikuler')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Kelola Ekstrakurikuler</h1>
                <p class="text-gray-600 mt-2">Kelola kegiatan ekstrakurikuler sekolah</p>
            </div>
            <a href="{{ route('admin.ekstrakurikuler.create') }}" 
               class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition flex items-center gap-2 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Ekstrakurikuler
            </a>
        </div>

        @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-md">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg shadow-md">
            @foreach($errors->all() as $error)
            <p class="text-red-700">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <!-- Grid Ekstrakurikuler -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($ekstrakurikulers as $ekskul)
            <div class="group bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                <!-- Background Image -->
                <div class="relative h-40 bg-gradient-to-r from-blue-500 to-purple-600 overflow-hidden">
                    @if($ekskul->background)
                        <img src="{{ $ekskul->background }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-600"></div>
                    @endif
                    
                    <!-- Logo -->
                    <div class="absolute -bottom-8 left-4">
                        <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center overflow-hidden border-4 border-white">
                            @if($ekskul->logo)
                                <img src="{{ $ekskul->logo }}" class="w-full h-full object-cover">
                            @else
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $ekskul->is_active ? 'bg-green-500 text-white' : 'bg-gray-500 text-white' }}">
                            {{ $ekskul->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
                
                <div class="pt-12 p-6">
                    <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $ekskul->nama }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($ekskul->deskripsi, 80) }}</p>
                    
                    <div class="flex items-center gap-4 text-xs text-gray-500 mb-4">
                        @if($ekskul->pembina)
                        <div class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>{{ $ekskul->pembina }}</span>
                        </div>
                        @endif
                        
                        @if($ekskul->jumlah_anggota)
                        <div class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>{{ $ekskul->jumlah_anggota }} Anggota</span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.ekstrakurikuler.edit', $ekskul->id) }}" 
                           class="text-blue-600 hover:text-blue-700 font-medium text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                        
                        <form action="{{ route('admin.ekstrakurikuler.destroy', $ekskul->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus ekstrakurikuler ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600 font-medium text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 p-12 rounded-2xl text-center">
                    <svg class="w-20 h-20 mx-auto text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <p class="text-gray-600 text-lg">Belum ada data ekstrakurikuler</p>
                    <a href="{{ route('admin.ekstrakurikuler.create') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        Tambah Ekstrakurikuler
                    </a>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            {{ $ekstrakurikulers->links() }}
        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection