@extends('layouts.admin')

@section('title', 'Kelola Alumni')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between items-center flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Alumni</h1>
            <p class="text-gray-500 text-sm mt-1">Verifikasi dan kelola data alumni</p>
        </div>
        <div class="flex gap-2 flex-wrap">
            <a href="{{ route('admin.dashboard') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>
            
            <button onclick="openExportModal()" 
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Export PDF
            </button>
            
            <a href="{{ route('admin.alumni.check-duplicates') }}" 
               class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                Cek Duplikat
            </a>
            
            <a href="{{ route('admin.alumni.create') }}" 
               class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Alumni
            </a>
            
            <a href="{{ route('admin.alumni.universitas') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Universitas
            </a>
        </div>
    </div>

    {{-- Warning Message --}}
    @if(session('warning'))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
        <span>{!! session('warning') !!}</span>
        <button onclick="this.parentElement.remove()" class="text-yellow-700 hover:text-yellow-900 text-xl">&times;</button>
    </div>
    @endif

    {{-- Alerts --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 text-xl">&times;</button>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900 text-xl">&times;</button>
    </div>
    @endif

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4">
            <div class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</div>
            <p class="text-sm text-gray-500">Total Alumni</p>
        </div>
        <div class="bg-yellow-50 rounded-xl shadow-sm p-4 border border-yellow-200">
            <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
            <p class="text-sm text-yellow-600">⏳ Menunggu</p>
        </div>
        <div class="bg-green-50 rounded-xl shadow-sm p-4 border border-green-200">
            <div class="text-2xl font-bold text-green-600">{{ $stats['approved'] }}</div>
            <p class="text-sm text-green-600">✅ Disetujui</p>
        </div>
        <div class="bg-red-50 rounded-xl shadow-sm p-4 border border-red-200">
            <div class="text-2xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
            <p class="text-sm text-red-600">❌ Ditolak</p>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex gap-2 mb-4 flex-wrap">
        <a href="{{ route('admin.alumni.index', ['status' => 'pending']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $status == 'pending' ? 'bg-yellow-100 text-yellow-700 border border-yellow-300' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            ⏳ Menunggu ({{ $stats['pending'] }})
        </a>
        <a href="{{ route('admin.alumni.index', ['status' => 'approved']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $status == 'approved' ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            ✅ Disetujui ({{ $stats['approved'] }})
        </a>
        <a href="{{ route('admin.alumni.index', ['status' => 'rejected']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $status == 'rejected' ? 'bg-red-100 text-red-700 border border-red-300' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            ❌ Ditolak ({{ $stats['rejected'] }})
        </a>
        <a href="{{ route('admin.alumni.index', ['status' => 'all']) }}" 
           class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $status == 'all' ? 'bg-blue-100 text-blue-700 border border-blue-300' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            📋 Semua ({{ $stats['total'] }})
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lulus</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Universitas / Pekerjaan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prodi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. HP</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">★</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($alumni as $a)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="font-medium text-gray-800">{{ $a->nama_lengkap }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm">{{ $a->tahun_lulus }}</td>
                    <td class="px-4 py-3">
                        @if($a->universitas_id)
                            {{-- Tampilkan Universitas --}}
                            <div class="flex items-center gap-2">
                                @if($a->universitas && $a->universitas->logo)
                                    <img src="{{ asset('storage/' . $a->universitas->logo) }}" class="h-5 object-contain">
                                @endif
                                <span class="text-sm font-medium text-blue-700">{{ $a->universitas->nama ?? '-' }}</span>
                            </div>
                        @elseif($a->pekerjaan)
                            {{-- Tampilkan Pekerjaan --}}
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-green-700">💼 {{ $a->pekerjaan }}</span>
                            </div>
                            @if($a->perusahaan)
                                <div class="text-xs text-gray-500 mt-0.5 ml-0">{{ $a->perusahaan }}</div>
                            @endif
                        @else
                            <span class="text-sm text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        @if($a->universitas_id && $a->program_studi)
                            {{ $a->program_studi }}
                        @elseif($a->pekerjaan && $a->perusahaan)
                            <span class="text-xs text-gray-400">-</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $a->no_hp ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @php $badge = $a->status_badge; @endphp
                        <span class="px-2 py-1 rounded-full text-xs {{ $badge[0] }}">{{ $badge[1] }}</span>
                        @if($a->verified_at)
                            <div class="text-xs text-gray-400 mt-1">{{ $a->verified_at->format('d M Y') }}</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        @if($a->status == 'approved')
                        <form action="{{ route('admin.alumni.toggle-featured', $a) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-2xl {{ $a->is_featured ? 'text-yellow-500' : 'text-gray-300' }} hover:text-yellow-600 transition">
                                ★
                            </button>
                        </form>
                        @else
                            <span class="text-gray-300 text-2xl">★</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.alumni.edit', $a) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                            
                            @if($a->status == 'pending')
                            <form action="{{ route('admin.alumni.approve', $a) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-green-600 hover:text-green-800 text-sm">Approve</button>
                            </form>
                            <form action="{{ route('admin.alumni.reject', $a) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-red-600 hover:text-red-800 text-sm">Reject</button>
                            </form>
                            @endif
                            
                            <form action="{{ route('admin.alumni.destroy', $a) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Hapus alumni &quot;{{ $a->nama_lengkap }}&quot;?')">
                                @csrf @method('DELETE')
                                <button class="text-gray-500 hover:text-gray-700 text-sm">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-gray-400">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <p class="text-gray-500">Belum ada data alumni</p>
                        <div class="mt-3">
                            <a href="{{ route('admin.alumni.create') }}" class="text-rose-600 hover:underline">
                                + Tambah Alumni
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $alumni->links() }}
    </div>
</div>

@include('admin.alumni.export-modal')
@endsection