@extends('layouts.admin')

@section('title', 'Cek Duplikat Nomor HP')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Cek Duplikat Nomor HP</h1>
            <p class="text-gray-500 text-sm mt-1">Data alumni dengan nomor HP yang sama</p>
        </div>
        <a href="{{ route('admin.alumni.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition">
            ← Kembali
        </a>
    </div>

    @if(isset($detailDuplicates) && count($detailDuplicates) > 0)
        @foreach($detailDuplicates as $dup)
        <div class="bg-white rounded-xl shadow mb-6 overflow-hidden">
            <div class="px-6 py-4 bg-orange-50 border-b flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-gray-800">
                        Nomor HP: <span class="text-orange-600">{{ $dup['no_hp'] }}</span>
                    </h3>
                    <p class="text-sm text-gray-500">{{ $dup['count'] }} data duplikat ditemukan</p>
                </div>
                <button onclick="deleteDuplicates('{{ $dup['no_hp'] }}')" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition">
                    🗑️ Hapus Duplikat (Sisakan 1)
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Tahun Lulus</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Universitas</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">No. HP</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($dup['data'] as $index => $a)
                        <tr class="{{ $index > 0 ? 'bg-yellow-50' : '' }}">
                            <td class="px-4 py-3 text-sm">#{{ $a->id }}</td>
                            <td class="px-4 py-3">{{ $a->nama_lengkap }}</td>
                            <td class="px-4 py-3">{{ $a->tahun_lulus }}</td>
                            <td class="px-4 py-3">{{ $a->universitas->nama ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $a->no_hp }}</td>
                            <td class="px-4 py-3">
                                @if($index == 0)
                                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">✅ Data Utama</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full">⚠️ Duplikat</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endforeach
    @else
        <div class="bg-white rounded-xl shadow p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-green-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-gray-600 text-lg">Tidak ada data duplikat nomor HP!</p>
            <a href="{{ route('admin.alumni.index') }}" class="mt-4 inline-block text-blue-600 hover:underline">
                ← Kembali ke Daftar Alumni
            </a>
        </div>
    @endif
</div>

<script>
function deleteDuplicates(noHp) {
    if (!confirm('Yakin ingin menghapus data duplikat untuk nomor ' + noHp + '?\n\nData pertama akan disimpan, sisanya dihapus.')) {
        return;
    }
    
    fetch('{{ route("admin.alumni.delete-duplicates") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ no_hp: noHp })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Data duplikat berhasil dihapus!');
            location.reload();
        } else {
            alert('Gagal menghapus duplikat: ' + data.message);
        }
    })
    .catch(err => {
        alert('Terjadi kesalahan: ' + err.message);
    });
}
</script>
@endsection