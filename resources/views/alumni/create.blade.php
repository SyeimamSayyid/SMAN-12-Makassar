@extends('layouts.app')

@section('title', 'Daftar Alumni')

@section('content')

<section class="pt-28 pb-12 bg-gradient-to-br from-blue-600 to-indigo-700">
    <div class="container mx-auto px-6 text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Daftar Alumni</h1>
        <p class="text-xl text-blue-100">Bergabung dengan jejaring alumni SMAN 12 Makassar</p>
    </div>
</section>

<section class="py-16 bg-white">
    <div class="container mx-auto px-6 max-w-2xl">
        
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4 text-green-700">
            {{ session('success') }}
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <form action="{{ route('alumni.store') }}" method="POST">
                @csrf
                
                {{-- Data Wajib --}}
                <div class="bg-blue-50 rounded-xl p-4 mb-6">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs">1</span>
                        Data Wajib
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Masukkan nama lengkap">
                            @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Tahun Lulus <span class="text-red-500">*</span></label>
                            <select name="tahun_lulus" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Tahun</option>
                                @for($y = date('Y'); $y >= 1980; $y--)
                                <option value="{{ $y }}" {{ old('tahun_lulus') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                            @error('tahun_lulus') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
                
                {{-- Data Kuliah (Opsional) --}}
                <div class="bg-purple-50 rounded-xl p-4 mb-6">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-purple-500 text-white rounded-full flex items-center justify-center text-xs">2</span>
                        Data Kuliah <span class="text-xs font-normal text-gray-500">(Opsional)</span>
                    </h3>
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Universitas</label>
                        <div class="border border-gray-200 rounded-lg p-2 max-h-64 overflow-y-auto">
                            <input type="text" id="searchUniversitas" placeholder="🔍 Cari universitas..." 
                                   class="w-full px-3 py-2 border border-gray-200 rounded-lg mb-2 text-sm sticky top-0 bg-white">
                            <div class="grid grid-cols-1 gap-1">
                                <label class="univ-item flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-purple-100">
                                    <input type="radio" name="universitas_id" value="" {{ old('universitas_id') ? '' : 'checked' }}>
                                    <span class="text-gray-500">-- Tidak ada / Lainnya --</span>
                                </label>
                                @foreach($universitasList as $univ)
                                <label class="univ-item flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-purple-100">
                                    <input type="radio" name="universitas_id" value="{{ $univ->id }}" {{ old('universitas_id') == $univ->id ? 'checked' : '' }}>
                                    @if($univ->logo)
                                        <img src="{{ asset('storage/' . $univ->logo) }}" alt="{{ $univ->nama }}" class="w-6 h-6 object-contain">
                                    @endif
                                    <span class="text-sm">{{ $univ->nama }} ({{ $univ->akronim }})</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @error('universitas_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Program Studi</label>
                            <input type="text" name="program_studi" value="{{ old('program_studi') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"
                                   placeholder="Contoh: Teknik Informatika">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Tahun Masuk Kuliah</label>
                            <select name="tahun_masuk_kuliah"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                                <option value="">Pilih Tahun</option>
                                @for($y = date('Y'); $y >= 1980; $y--)
                                <option value="{{ $y }}" {{ old('tahun_masuk_kuliah') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                
                {{-- Data Pekerjaan (Opsional) --}}
                <div class="bg-green-50 rounded-xl p-4 mb-6">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-green-500 text-white rounded-full flex items-center justify-center text-xs">3</span>
                        Data Pekerjaan <span class="text-xs font-normal text-gray-500">(Opsional)</span>
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Pekerjaan</label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                   placeholder="Contoh: Software Engineer">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Perusahaan</label>
                            <input type="text" name="perusahaan" value="{{ old('perusahaan') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500"
                                   placeholder="Nama perusahaan">
                        </div>
                    </div>
                </div>
                
                {{-- Data Lokasi & Kontak (Opsional) --}}
                <div class="bg-amber-50 rounded-xl p-4 mb-6">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <span class="w-6 h-6 bg-amber-500 text-white rounded-full flex items-center justify-center text-xs">4</span>
                        Lokasi & Kontak <span class="text-xs font-normal text-gray-500">(Opsional)</span>
                    </h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Provinsi</label>
                            <input type="text" name="provinsi" value="{{ old('provinsi') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500"
                                   placeholder="Contoh: DKI Jakarta">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Kota</label>
                            <input type="text" name="kota" value="{{ old('kota') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500"
                                   placeholder="Contoh: Jakarta Selatan">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500"
                                   placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Instagram</label>
                            <input type="text" name="instagram" value="{{ old('instagram') }}"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500"
                                   placeholder="username (tanpa @)">
                        </div>
                    </div>
                </div>
                
                {{-- Testimoni --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Testimoni</label>
                    <textarea name="testimoni" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                              placeholder="Bagikan pengalaman atau pesan untuk almamater...">{{ old('testimoni') }}</textarea>
                </div>
                
                <button type="submit" 
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all shadow-md">
                    Daftar Sekarang
                </button>
                
                <p class="text-center text-gray-500 text-sm mt-4">
                    Data Anda akan diverifikasi oleh admin sebelum ditampilkan.
                </p>
            </form>
            
            <div class="mt-6 text-center">
                <a href="{{ route('alumni.index') }}" class="text-blue-600 hover:underline">
                    ← Kembali ke halaman alumni
                </a>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('searchUniversitas')?.addEventListener('input', function() {
    const search = this.value.toLowerCase();
    document.querySelectorAll('.univ-item').forEach(item => {
        const text = item.textContent.toLowerCase();
        item.style.display = text.includes(search) ? 'flex' : 'none';
    });
});
</script>
@endsection