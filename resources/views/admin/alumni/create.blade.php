@extends('layouts.admin')

@section('title', 'Tambah Alumni')

@section('content')
<div class="p-6 max-w-3xl">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Alumni</h1>
        <p class="text-gray-500 text-sm mt-1">Tambahkan data alumni baru</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.alumni.store') }}" method="POST">
            @csrf
            
            <div class="space-y-5">
                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                           class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500">
                    @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Tahun Lulus --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Tahun Lulus <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun_lulus" required class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500">
                        <option value="">Pilih Tahun</option>
                        @for($y = date('Y'); $y >= 1980; $y--)
                            <option value="{{ $y }}" {{ old('tahun_lulus') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                    @error('tahun_lulus') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Universitas --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Universitas</label>
                    <select name="universitas_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500">
                        <option value="">-- Pilih Universitas --</option>
                        @foreach($universitas as $univ)
                            <option value="{{ $univ->id }}" {{ old('universitas_id') == $univ->id ? 'selected' : '' }}>
                                {{ $univ->nama }} ({{ $univ->akronim }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Program Studi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Program Studi</label>
                    <input type="text" name="program_studi" value="{{ old('program_studi') }}"
                           class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500"
                           placeholder="Contoh: Teknik Informatika">
                </div>

                {{-- Pekerjaan & Perusahaan --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Pekerjaan</label>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500"
                               placeholder="Contoh: Software Engineer">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Perusahaan</label>
                        <input type="text" name="perusahaan" value="{{ old('perusahaan') }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500"
                               placeholder="Nama perusahaan">
                    </div>
                </div>

                {{-- Provinsi & Kota --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Provinsi</label>
                        <input type="text" name="provinsi" value="{{ old('provinsi') }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kota</label>
                        <input type="text" name="kota" value="{{ old('kota') }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500">
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                               class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500"
                               placeholder="081234567890">
                    </div>
                </div>

                {{-- Instagram --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Instagram</label>
                    <input type="text" name="instagram" value="{{ old('instagram') }}"
                           class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500"
                           placeholder="username (tanpa @)">
                </div>

                {{-- Testimoni --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Testimoni</label>
                    <textarea name="testimoni" rows="3" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500"
                              placeholder="Bagikan pengalaman atau pesan...">{{ old('testimoni') }}</textarea>
                </div>

                {{-- Featured --}}
                <div class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} 
                           class="w-4 h-4 text-rose-600 rounded focus:ring-rose-500">
                    <span class="ml-2 text-sm text-gray-700">Tandai sebagai Featured</span>
                </div>

                {{-- Tombol --}}
                <div class="flex gap-3 pt-4 border-t">
                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                        💾 Simpan
                    </button>
                    <a href="{{ route('admin.alumni.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">
                        ❌ Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection