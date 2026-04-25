@extends('layouts.admin')

@section('title', 'Kelola Pegawai')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between items-center flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Pegawai & Guru</h1>
            <p class="text-gray-500 text-sm mt-1">Data tenaga pendidik dan kependidikan</p>
        </div>
        <div class="flex gap-2">
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
            
            <a href="{{ route('admin.pegawai.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pegawai
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900 text-xl">&times;</button>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Foto</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jabatan</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pangkat/Bidang</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($pegawai as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        @if($p->foto)
                            <img src="{{ asset('storage/' . $p->foto) }}" class="w-10 h-10 rounded-full object-cover">
                        @else
                            <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-400 text-xs">No</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm font-mono">{{ $p->nip ?? '-' }}</td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $p->nama }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded-full {{ $p->jabatan_badge_class }}">
                            {{ $p->jabatan_label }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $p->pangkat ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs {{ $p->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $p->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.pegawai.edit', $p) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.pegawai.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-gray-400">Belum ada data pegawai</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">{{ $pegawai->links() }}</div>
</div>

{{-- Modal Export PDF --}}
<div id="exportModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="p-6 border-b">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Filter Export PDF
            </h3>
        </div>
        
        <form action="{{ route('admin.pegawai.export-pdf') }}" method="GET" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jabatan</label>
                <select name="jabatan" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="all">📋 Semua Jabatan</option>
                    <option value="Kepala Sekolah">🎓 Kepala Sekolah</option>
                    <option value="Wakil Kepala Sekolah">📋 Wakil Kepala Sekolah</option>
                    <option value="Guru">📚 Guru</option>
                    <option value="Guru BK">💬 Guru BK</option>
                    <option value="Kepala Perpustakaan">📖 Kepala Perpustakaan</option>
                    <option value="Kepala Laboratorium">🔬 Kepala Laboratorium</option>
                    <option value="Pembimbing Ekstrakurikuler">🏆 Pembimbing Ekstrakurikuler</option>
                    <option value="Staff TU">📁 Staff TU</option>
                </select>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg font-medium transition">
                    📥 Download PDF
                </button>
                <button type="button" onclick="closeExportModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg font-medium transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openExportModal() {
    document.getElementById('exportModal').classList.remove('hidden');
    document.getElementById('exportModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
    document.getElementById('exportModal').classList.remove('flex');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeExportModal(); });
document.getElementById('exportModal')?.addEventListener('click', (e) => { if (e.target === e.currentTarget) closeExportModal(); });
</script>
@endsection