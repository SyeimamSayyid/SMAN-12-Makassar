@extends('layouts.admin')

@section('title', 'Kelola Galeri')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Galeri</h1>
            <p class="text-gray-500 text-sm mt-1">Data galeri kegiatan sekolah</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.galeri.create') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Galeri
            </a>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 text-xl">&times;</button>
    </div>
    @endif

    {{-- Alert Error --}}
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 text-xl">&times;</button>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($galeri as $g)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        @if($g->gambar_utama)
                            <img src="{{ asset('storage/' . $g->gambar_utama) }}" class="w-12 h-12 object-cover rounded-lg">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-800">{{ $g->judul }}</div>
                        <div class="text-xs text-gray-400">{{ Str::limit($g->deskripsi, 40) }}</div>
                    </td>
                    <td class="px-4 py-3">
                        @php
                            $kategoriColors = [
                                'Upacara' => 'bg-red-100 text-red-700',
                                'Akademik' => 'bg-blue-100 text-blue-700',
                                'Olahraga' => 'bg-green-100 text-green-700',
                                'Seni' => 'bg-pink-100 text-pink-700',
                                'Keagamaan' => 'bg-yellow-100 text-yellow-700',
                                'Lomba' => 'bg-orange-100 text-orange-700',
                                'Study Tour' => 'bg-cyan-100 text-cyan-700',
                                'Lainnya' => 'bg-gray-100 text-gray-700',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs rounded-full {{ $kategoriColors[$g->kategori] ?? 'bg-purple-100 text-purple-700' }}">
                            {{ $g->kategori }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $g->tanggal_kegiatan ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <div class="space-y-1.5">
                            <span class="px-2 py-1 rounded-full text-xs {{ $g->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} block text-center">
                                {{ $g->is_active ? '✅ Aktif' : '⏸️ Nonaktif' }}
                            </span>
                            @if($g->is_featured)
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full block text-center">
                                    ⭐ Featured
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.galeri.edit', $g) }}" 
                               class="text-blue-600 hover:text-blue-800 transition">
                                Edit
                            </a>
                            
                            <form action="{{ route('admin.galeri.destroy', $g) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus galeri &quot;{{ $g->judul }}&quot;?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p>Belum ada data galeri</p>
                        <a href="{{ route('admin.galeri.create') }}" class="text-purple-600 hover:underline mt-2 inline-block">
                            + Tambah Galeri Sekarang
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $galeri->links() }}
    </div>
</div>
@endsection