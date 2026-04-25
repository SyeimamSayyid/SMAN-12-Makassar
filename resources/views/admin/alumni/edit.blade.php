@extends('layouts.admin')

@section('title', 'Edit Alumni')

@section('content')
<div class="p-6 max-w-4xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Data Alumni</h1>
        <p class="text-gray-500 text-sm mt-1">Lengkapi data alumni untuk verifikasi</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('admin.alumni.update', $alumni) }}" method="POST">
            @csrf
            @method('PUT')
            
            {{-- Data Wajib --}}
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $alumni->nama_lengkap) }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tahun Lulus</label>
                    <select name="tahun_lulus" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        @for($y = date('Y'); $y >= 1980; $y--)
                        <option value="{{ $y }}" {{ $alumni->tahun_lulus == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            
            {{-- Universitas --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Universitas</label>
                <select name="universitas_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">-- Pilih Universitas --</option>
                    @foreach($universitas as $univ)
                    <option value="{{ $univ->id }}" {{ $alumni->universitas_id == $univ->id ? 'selected' : '' }}>
                        {{ $univ->nama }} ({{ $univ->akronim }})
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Program Studi</label>
                    <input type="text" name="program_studi" value="{{ old('program_studi', $alumni->program_studi) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tahun Masuk Kuliah</label>
                    <select name="tahun_masuk_kuliah" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                        <option value="">-- Pilih --</option>
                        @for($y = date('Y'); $y >= 1980; $y--)
                        <option value="{{ $y }}" {{ $alumni->tahun_masuk_kuliah == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            
            {{-- Pekerjaan --}}
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $alumni->pekerjaan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Perusahaan</label>
                    <input type="text" name="perusahaan" value="{{ old('perusahaan', $alumni->perusahaan) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            
            {{-- Lokasi --}}
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Provinsi</label>
                    <input type="text" name="provinsi" value="{{ old('provinsi', $alumni->provinsi) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Kota</label>
                    <input type="text" name="kota" value="{{ old('kota', $alumni->kota) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            
            {{-- Kontak --}}
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $alumni->email) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Instagram</label>
                    <input type="text" name="instagram" value="{{ old('instagram', $alumni->instagram) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                </div>
            </div>
            
            {{-- Testimoni --}}
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-1">Testimoni</label>
                <textarea name="testimoni" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg">{{ old('testimoni', $alumni->testimoni) }}</textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.alumni.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection