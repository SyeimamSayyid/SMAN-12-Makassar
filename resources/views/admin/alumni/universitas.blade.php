@extends('layouts.admin')

@section('title', 'Kelola Universitas')

@section('content')
<div class="p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Universitas</h1>
            <p class="text-gray-500 text-sm mt-1">Tambah dan kelola data universitas beserta logo</p>
        </div>
        <a href="{{ route('admin.alumni.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg">
            ← Kembali ke Alumni
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    {{-- Form Tambah Universitas --}}
    <div class="bg-white rounded-2xl shadow p-6 mb-8">
        <h2 class="text-lg font-bold mb-4">Tambah Universitas</h2>
        <form action="{{ route('admin.alumni.universitas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nama Universitas</label>
                    <input type="text" name="nama" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Akronim</label>
                    <input type="text" name="akronim" placeholder="Contoh: UI, UGM, ITB" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Provinsi</label>
                    <input type="text" name="provinsi" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="Negeri">Negeri</option>
                        <option value="Swasta">Swasta</option>
                        <option value="Kedinasan">Kedinasan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Logo</label>
                    <input type="file" name="logo" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            <button type="submit" class="mt-4 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Tambah Universitas
            </button>
        </form>
    </div>

    {{-- Tabel Universitas --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Logo</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Akronim</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Provinsi</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($universitas as $u)
                <tr>
                    <td class="px-4 py-3">
                        @if($u->logo)
                            <img src="{{ asset('storage/' . $u->logo) }}" class="h-8 object-contain">
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $u->nama }}</td>
                    <td class="px-4 py-3">{{ $u->akronim ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $u->provinsi ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $u->status }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <button onclick="editUniversitas({{ $u->id }})" class="text-blue-600">Edit</button>
                            <form action="{{ route('admin.alumni.universitas.destroy', $u) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">Belum ada data universitas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $universitas->links() }}
    </div>
</div>
@endsection