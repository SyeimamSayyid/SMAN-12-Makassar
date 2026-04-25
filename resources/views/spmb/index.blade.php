@extends('layouts.app')

@section('title', 'SPMB - SMAN 12 Makassar')

@section('content')

<section class="pt-28 pb-12 bg-gradient-to-br from-blue-600 to-indigo-700">
    <div class="container mx-auto px-6 text-center text-white">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">SPMB</h1>
        <p class="text-xl text-blue-100">Seleksi Penerimaan Murid Baru SMAN 12 Makassar</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        @if($spmb->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($spmb as $s)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-all">
                    <a href="{{ route('spmb.show', $s->slug) }}">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $s->foto_url }}" alt="{{ $s->judul }}" 
                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                        </div>
                    </a>
                    <div class="p-5">
                        <a href="{{ route('spmb.show', $s->slug) }}">
                            <h3 class="text-lg font-bold mb-2 hover:text-blue-600">{{ $s->judul }}</h3>
                        </a>
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4">{{ $s->deskripsi ?? 'Klik untuk melihat informasi lengkap.' }}</p>
                        
                        {{-- Link Pendaftaran di Card ✅ --}}
                        @if($s->link_pendaftaran)
                            <a href="{{ $s->link_pendaftaran }}" target="_blank" 
                               class="inline-flex items-center gap-1 text-sm text-green-600 hover:text-green-700 font-medium mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                                Daftar Sekarang
                            </a>
                        @endif
                        
                        <div class="flex items-center justify-between text-xs text-gray-400">
                            <span>📅 {{ $s->tanggal_upload->format('d M Y') }}</span>
                            <span>👁️ {{ $s->views }} views</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-12">{{ $spmb->links() }}</div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-400">Belum ada informasi SPMB</p>
            </div>
        @endif
    </div>
</section>
@endsection