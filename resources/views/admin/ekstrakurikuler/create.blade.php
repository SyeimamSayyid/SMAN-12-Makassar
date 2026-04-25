@extends('layouts.admin')

@section('title', 'Tambah Ekstrakurikuler')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Tambah Ekstrakurikuler</h1>
            <p class="text-gray-500 mt-1">Lengkapi form berikut untuk menambahkan kegiatan ekstrakurikuler baru</p>
        </div>

        {{-- ✅ ERROR DISPLAY --}}
        @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-red-700 font-bold">Gagal menyimpan! Periksa kembali:</h3>
            </div>
            <ul class="list-disc list-inside text-red-600 text-sm space-y-1 ml-7">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- ✅ ERROR DARI EXCEPTION --}}
        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 rounded-lg p-4 mb-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-red-700 font-medium">{{ session('error') }}</p>
            </div>
        </div>
        @endif

        {{-- ✅ SUCCESS --}}
        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 rounded-lg p-4 mb-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <form action="{{ route('admin.ekstrakurikuler.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- 1. INFORMASI DASAR -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm">1</span>
                        Informasi Dasar
                    </h2>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Ekstrakurikuler <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: Pramuka, Futsal, PMR, Paduan Suara">
                            <p class="text-xs text-gray-500 mt-1">Nama akan digunakan sebagai slug URL otomatis</p>
                            @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="is_active" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Nonaktifkan jika ekstrakurikuler sedang tidak berjalan</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Ekstrakurikuler <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="6" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Jelaskan tentang ekstrakurikuler ini, kegiatan yang dilakukan, manfaat mengikuti, dll...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- 2. DETAIL KEGIATAN -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm">2</span>
                        Detail Kegiatan
                    </h2>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Anggota</label>
                            <input type="number" name="jumlah_anggota" value="{{ old('jumlah_anggota', 0) }}" min="0"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('jumlah_anggota')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jadwal Kegiatan</label>
                            <input type="text" name="jadwal" value="{{ old('jadwal') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: Senin & Rabu, 15:00-17:00">
                            @error('jadwal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tempat Kegiatan</label>
                            <input type="text" name="tempat" value="{{ old('tempat') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: Lapangan Basket, Ruang Multimedia, Aula">
                            @error('tempat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Pembina -->
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Pembina / Pelatih <span class="text-gray-400 text-xs font-normal">(Pilih dari data guru)</span>
                        </label>
                        
                        @php
                            $gurus = \App\Models\Pegawai::whereIn('jabatan', ['Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru'])
                                        ->where('is_active', true)
                                        ->orderByRaw("FIELD(jabatan, 'Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru')")
                                        ->orderBy('nama')
                                        ->get();
                        @endphp
                        
                        @if($gurus->count() > 0)
                            <div class="mb-3 flex items-center justify-between">
                                <p class="text-sm text-gray-600">
                                    <span id="selectedPembinaCount">0</span> pembina dipilih
                                </p>
                                <button type="button" id="clearAllPembina" class="text-xs text-red-500 hover:text-red-700 hidden">Hapus</button>
                            </div>

                            <input type="hidden" name="pembina" id="selectedPembinaInput" value="{{ old('pembina') }}">

                            <div class="relative mb-3">
                                <input type="text" id="searchPembinaInput" placeholder="Cari nama guru..." 
                                       class="w-full px-4 py-2 pl-10 border rounded-lg text-sm">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 max-h-80 overflow-y-auto p-1" id="pembinaGrid">
                                @foreach($gurus as $guru)
                                <div class="pembina-card relative bg-white border-2 border-gray-200 rounded-xl overflow-hidden cursor-pointer transition-all hover:shadow-md" 
                                     data-nama="{{ $guru->nama }}"
                                     onclick="togglePembinaSelection(this, '{{ $guru->nama }}')">
                                    <div class="absolute top-2 right-2 z-10 checkmark-pembina hidden">
                                        <div class="w-6 h-6 bg-green-600 rounded-full flex items-center justify-center shadow-lg">
                                            <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100">
                                        @if($guru->foto)<img src="{{ asset('storage/' . $guru->foto) }}" alt="{{ $guru->nama }}" class="w-full h-full object-cover">
                                        @else<div class="w-full h-full flex items-center justify-center"><svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>@endif
                                    </div>
                                    <div class="p-2">
                                        <h5 class="font-medium text-gray-800 text-xs truncate">{{ $guru->nama }}</h5>
                                        <span class="inline-block mt-1 text-[10px] px-1.5 py-0.5 rounded-full bg-blue-100 text-blue-700">{{ $guru->jabatan }}</span>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Atau tulis manual</label>
                                <input type="text" id="pembinaManual" value="{{ old('pembina') }}"
                                       class="w-full px-4 py-2 border rounded-lg" placeholder="Nama pembina (jika tidak ada di daftar)">
                                <p class="text-xs text-gray-400 mt-1">Isi manual akan menggantikan pilihan dari card</p>
                            </div>
                        @else
                            <input type="text" name="pembina" value="{{ old('pembina') }}" class="w-full px-4 py-2 border rounded-lg" placeholder="Nama pembina">
                        @endif
                        @error('pembina')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- 3. MEDIA & DOKUMENTASI -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center text-sm">3</span>
                        Media & Dokumentasi
                    </h2>

                    <!-- Logo -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logo Ekstrakurikuler</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                            <input type="file" name="logo" id="logoInput" accept="image/*" class="hidden">
                            <label for="logoInput" class="cursor-pointer block">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="mt-2 text-sm text-gray-600">Klik untuk upload logo</p>
                                <p class="text-xs text-gray-500">Format: JPG, PNG (Maks 5MB)</p>
                            </label>
                        </div>
                        <div id="logoPreview" class="mt-4 hidden"><img id="logoPreviewImg" class="w-32 h-32 object-cover rounded-lg border"></div>
                        @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Background -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Background / Banner</label>
                        <div class="flex gap-3 mb-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="bg_type" value="gradient" checked onchange="toggleBgType('gradient')" class="w-4 h-4 text-blue-600">
                                <span class="text-sm">Kombinasi Warna</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="bg_type" value="upload" onchange="toggleBgType('upload')" class="w-4 h-4 text-blue-600">
                                <span class="text-sm">Upload Gambar</span>
                            </label>
                        </div>

                        <div id="bgGradientSection">
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Warna Utama</label>
                                    <div class="flex gap-2">
                                        <input type="color" name="bg_color1" id="bgColor1" value="#3b82f6" class="w-12 h-10 rounded-lg border" onchange="updateGradientPreview()">
                                        <input type="text" id="bgColor1Text" value="#3b82f6" class="flex-1 px-3 py-2 border rounded-lg text-sm font-mono" oninput="updateColorFromText('bgColor1', this.value)">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Warna Cadangan</label>
                                    <div class="flex gap-2">
                                        <input type="color" name="bg_color2" id="bgColor2" value="#1d4ed8" class="w-12 h-10 rounded-lg border" onchange="updateGradientPreview()">
                                        <input type="text" id="bgColor2Text" value="#1d4ed8" class="flex-1 px-3 py-2 border rounded-lg text-sm font-mono" oninput="updateColorFromText('bgColor2', this.value)">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs text-gray-500 mb-1">Opacity: <span id="opacityValue">50%</span></label>
                                <input type="range" name="bg_opacity" id="bgOpacity" min="10" max="100" value="50" class="w-full accent-blue-600" oninput="updateGradientPreview()">
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs text-gray-500 mb-1">Arah</label>
                                <select name="bg_direction" id="bgDirection" class="w-full px-3 py-2 border rounded-lg text-sm" onchange="updateGradientPreview()">
                                    <option value="to right">Kiri ke Kanan</option>
                                    <option value="to bottom">Atas ke Bawah</option>
                                    <option value="to bottom right">Diagonal</option>
                                    <option value="to bottom left">Diagonal Terbalik</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <div id="gradientPreview" class="w-full h-32 rounded-xl border flex items-center justify-center text-white font-bold" style="background: linear-gradient(to right, #3b82f6, rgba(29, 78, 216, 0.5));">Preview</div>
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                <button type="button" onclick="setPresetGradient('#3b82f6','#1d4ed8','to right',50)" class="h-12 rounded-lg border-2 bg-gradient-to-r from-blue-500 to-blue-800"></button>
                                <button type="button" onclick="setPresetGradient('#8b5cf6','#ec4899','to right',40)" class="h-12 rounded-lg border-2 bg-gradient-to-r from-purple-500 to-pink-500"></button>
                                <button type="button" onclick="setPresetGradient('#10b981','#059669','to right',30)" class="h-12 rounded-lg border-2 bg-gradient-to-r from-emerald-500 to-green-700"></button>
                                <button type="button" onclick="setPresetGradient('#f59e0b','#ef4444','to right',50)" class="h-12 rounded-lg border-2 bg-gradient-to-r from-amber-500 to-red-500"></button>
                            </div>
                        </div>

                        <div id="bgUploadSection" class="hidden">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                                <input type="file" name="background" id="bgInput" accept="image/*" class="hidden">
                                <label for="bgInput" class="cursor-pointer block">
                                    <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <p class="mt-2 text-sm">Klik untuk upload</p>
                                </label>
                            </div>
                            <div id="bgPreview" class="mt-4 hidden"><img id="bgPreviewImg" class="w-full h-40 object-cover rounded-lg border"></div>
                        </div>
                        @error('background')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Galeri -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Galeri Foto (Maks 10)</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition">
                            <input type="file" name="galeri[]" id="galleryInput" accept="image/*" multiple class="hidden">
                            <label for="galleryInput" class="cursor-pointer block">
                                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="mt-2 text-sm">Klik untuk upload</p>
                            </label>
                        </div>
                        <div id="galleryPreview" class="grid grid-cols-3 md:grid-cols-5 gap-3 mt-4"></div>
                    </div>
                </div>

                <!-- 4. PRESTASI -->
                <div class="border-b border-gray-200 pb-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <span class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center text-sm">4</span>
                        Prestasi
                    </h2>
                    <div id="prestasiList">
                        <div class="flex gap-2 mb-2 prestasi-item">
                            <input type="text" name="prestasi[]" class="flex-1 px-4 py-2 border rounded-lg" placeholder="Juara 1...">
                            <button type="button" class="remove-prestasi text-red-500 px-3 py-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>
                    </div>
                    <button type="button" id="addPrestasi" class="mt-2 text-blue-600 text-sm">+ Tambah</button>
                </div>

                <!-- 5. TOMBOL -->
                <div class="flex justify-end gap-3 pt-4">
                    <a href="{{ route('admin.ekstrakurikuler.index') }}" class="px-6 py-2.5 border rounded-lg text-gray-700 hover:bg-gray-50">Batal</a>
                    <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let selectedPembinaCard = null;
let galleryFiles = new DataTransfer();

function toggleBgType(type) {
    document.getElementById('bgGradientSection').classList.toggle('hidden', type !== 'gradient');
    document.getElementById('bgUploadSection').classList.toggle('hidden', type !== 'upload');
}
function updateGradientPreview() {
    const c1 = document.getElementById('bgColor1').value;
    const c2 = document.getElementById('bgColor2').value;
    const dir = document.getElementById('bgDirection').value;
    const op = document.getElementById('bgOpacity').value;
    document.getElementById('bgColor1Text').value = c1;
    document.getElementById('bgColor2Text').value = c2;
    document.getElementById('opacityValue').textContent = op + '%';
    const r = parseInt(c2.slice(1,3), 16), g = parseInt(c2.slice(3,5), 16), b = parseInt(c2.slice(5,7), 16);
    document.getElementById('gradientPreview').style.background = `linear-gradient(${dir}, ${c1}, rgba(${r},${g},${b},${op/100}))`;
}
function updateColorFromText(id, v) { document.getElementById(id).value = v; updateGradientPreview(); }
function setPresetGradient(c1,c2,dir,op) { document.getElementById('bgColor1').value=c1; document.getElementById('bgColor2').value=c2; document.getElementById('bgDirection').value=dir; document.getElementById('bgOpacity').value=op; updateGradientPreview(); }

function togglePembinaSelection(card, nama) {
    const cm = card.querySelector('.checkmark-pembina');
    const pm = document.getElementById('pembinaManual');
    const si = document.getElementById('selectedPembinaInput');
    if (selectedPembinaCard === card) {
        selectedPembinaCard = null; cm.classList.add('hidden'); card.classList.remove('border-green-500','bg-green-50/30'); card.classList.add('border-gray-200');
        if(pm){pm.disabled=false;pm.placeholder='Nama pembina';} if(si)si.value='';
    } else {
        if(selectedPembinaCard){selectedPembinaCard.querySelector('.checkmark-pembina').classList.add('hidden'); selectedPembinaCard.classList.remove('border-green-500','bg-green-50/30'); selectedPembinaCard.classList.add('border-gray-200');}
        selectedPembinaCard=card; cm.classList.remove('hidden'); card.classList.remove('border-gray-200'); card.classList.add('border-green-500','bg-green-50/30');
        if(si)si.value=nama; if(pm){pm.value='';pm.disabled=true;pm.placeholder='Dipilih dari daftar';}
    }
    const c=document.getElementById('selectedPembinaCount'),b=document.getElementById('clearAllPembina');
    if(c)c.textContent=selectedPembinaCard?'1':'0'; if(b)b.classList.toggle('hidden',!selectedPembinaCard);
}
function clearPembinaSelection() {
    if(selectedPembinaCard){selectedPembinaCard.querySelector('.checkmark-pembina').classList.add('hidden');selectedPembinaCard.classList.remove('border-green-500','bg-green-50/30');selectedPembinaCard.classList.add('border-gray-200');selectedPembinaCard=null;}
    const pm=document.getElementById('pembinaManual'); if(pm){pm.disabled=false;pm.value='';} document.getElementById('selectedPembinaInput').value='';
    document.getElementById('selectedPembinaCount').textContent='0'; document.getElementById('clearAllPembina').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchPembinaInput')?.addEventListener('input', function() {
        const t = this.value.toLowerCase();
        document.querySelectorAll('.pembina-card').forEach(c => { c.style.display = c.dataset.nama.toLowerCase().includes(t) ? '' : 'none'; });
    });
    document.getElementById('clearAllPembina')?.addEventListener('click', clearPembinaSelection);
    const pm = document.getElementById('pembinaManual'), si = document.getElementById('selectedPembinaInput');
    if(pm && si) pm.addEventListener('input', function() { if(this.value && selectedPembinaCard) clearPembinaSelection(); si.value = this.value; });
    
    @if(old('pembina'))
        const op = @json(old('pembina'));
        document.querySelectorAll('.pembina-card').forEach(c => { if(c.dataset.nama === op) togglePembinaSelection(c, op); });
        if(!selectedPembinaCard && pm) { pm.value = op; si.value = op; }
    @endif
});

document.getElementById('logoInput')?.addEventListener('change', function(e) {
    if(e.target.files[0]) { const r = new FileReader(); r.onload = ev => { document.getElementById('logoPreviewImg').src = ev.target.result; document.getElementById('logoPreview').classList.remove('hidden'); }; r.readAsDataURL(e.target.files[0]); }
});
document.getElementById('bgInput')?.addEventListener('change', function(e) {
    if(e.target.files[0]) { const r = new FileReader(); r.onload = ev => { document.getElementById('bgPreviewImg').src = ev.target.result; document.getElementById('bgPreview').classList.remove('hidden'); }; r.readAsDataURL(e.target.files[0]); }
});

const gi = document.getElementById('galleryInput'), gp = document.getElementById('galleryPreview');
if(gi) gi.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    if(files.length > 10) { alert('Maks 10!'); this.value=''; return; }
    gp.innerHTML=''; galleryFiles = new DataTransfer();
    files.forEach((f,i) => {
        if(f.size > 5*1024*1024) { alert(`File ${f.name} >5MB!`); return; }
        galleryFiles.items.add(f);
        const r = new FileReader();
        r.onload = ev => {
            const d = document.createElement('div'); d.className='relative group'; d.dataset.index=i;
            d.innerHTML=`<img src="${ev.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-gray-200"><button class="remove-gallery absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>`;
            gp.appendChild(d);
        };
        r.readAsDataURL(f);
    });
    gi.files = galleryFiles.files;
});

document.addEventListener('click', function(e) {
    if(e.target.closest('.remove-gallery')) {
        const btn = e.target.closest('.remove-gallery'), div = btn.closest('.relative'), idx = parseInt(div.dataset.index);
        div.remove();
        const ndt = new DataTransfer();
        for(let i=0;i<galleryFiles.files.length;i++) if(i!==idx) ndt.items.add(galleryFiles.files[i]);
        galleryFiles=ndt; gi.files=galleryFiles.files;
        document.querySelectorAll('#galleryPreview .relative').forEach((item,ni)=>{item.dataset.index=ni;});
    }
});

document.getElementById('addPrestasi')?.addEventListener('click', function() {
    const d = document.createElement('div'); d.className='flex gap-2 mb-2 prestasi-item';
    d.innerHTML=`<input type="text" name="prestasi[]" class="flex-1 px-4 py-2 border rounded-lg" placeholder="Juara..."><button class="remove-prestasi text-red-500 px-3 py-2"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>`;
    document.getElementById('prestasiList').appendChild(d);
});
document.addEventListener('click', function(e) {
    if(e.target.closest('.remove-prestasi') && document.querySelectorAll('.prestasi-item').length>1) e.target.closest('.prestasi-item').remove();
});
</script>

<style>
input:focus, textarea:focus, select:focus { outline: none; }
.pembina-card.border-green-500 { border-color: #10b981 !important; box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.1); }
.checkmark-pembina { animation: checkmark-pop 0.2s ease-out; }
@keyframes checkmark-pop { 0% { transform: scale(0); opacity: 0; } 80% { transform: scale(1.1); } 100% { transform: scale(1); opacity: 1; } }
#pembinaGrid::-webkit-scrollbar { width: 6px; }
#pembinaGrid::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
#pembinaGrid::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>
@endsection