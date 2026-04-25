@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Fasilitas</h1>
        <p class="text-gray-500 text-sm mt-1">Tambahkan data fasilitas baru</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Form Input --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data" id="fasilitasForm">
                    @csrf
                    <div class="space-y-4">
                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Nama Fasilitas <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required 
                                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                            @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori" id="kategori" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
                                <option value="ruang_kelas">🏫 Ruang Kelas</option>
                                <option value="laboratorium">🔬 Laboratorium</option>
                                <option value="perpustakaan">📚 Perpustakaan</option>
                                <option value="olahraga">⚽ Olahraga</option>
                                <option value="aula">🎭 Aula</option>
                                <option value="kantin">🍽️ Kantin</option>
                                <option value="lainnya">📦 Lainnya</option>
                            </select>
                            @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" 
                                      class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Info Tambahan & Jumlah --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Info Tambahan</label>
                                <input type="text" name="info_tambahan" id="info_tambahan" value="{{ old('info_tambahan') }}" 
                                       placeholder="Contoh: 24 Ruang Kelas" class="w-full border rounded-lg px-4 py-2">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Jumlah</label>
                                <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', 1) }}" min="1" 
                                       class="w-full border rounded-lg px-4 py-2">
                            </div>
                        </div>

                        {{-- Gambar --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Gambar</label>
                            <input type="file" name="gambar" id="gambar" accept="image/*" 
                                   class="w-full border rounded-lg px-4 py-2" onchange="previewImage(event)">
                            @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Urutan & Status --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Urutan</label>
                                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', 0) }}" 
                                       class="w-full border rounded-lg px-4 py-2">
                                <p class="text-xs text-gray-400 mt-1">Semakin kecil, semakin awal</p>
                            </div>
                            <div class="flex items-end pb-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1" checked 
                                           class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">Aktif (Tampilkan di website)</span>
                                </label>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex gap-3 pt-4 border-t">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                                💾 Simpan
                            </button>
                            <a href="{{ route('admin.fasilitas.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">
                                ❌ Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Preview Card --}}
        <div class="lg:col-span-1">
            <div class="sticky top-4">
                <h3 class="text-sm font-medium text-gray-500 mb-3 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Preview Card
                </h3>

                {{-- Card Preview --}}
                <div class="fasilitas-card group bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col">
                    {{-- Gambar --}}
                    <div class="relative h-44 overflow-hidden flex-shrink-0 bg-gradient-to-br from-gray-100 to-gray-200">
                        <img id="previewGambar" src="{{ asset('images/default-fasilitas.jpg') }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        
                        {{-- Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        {{-- Kategori Badge --}}
                        <div class="absolute top-4 left-4">
                            <span id="previewKategori" class="px-3 py-1.5 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-semibold rounded-full shadow-lg">
                                Ruang Kelas
                            </span>
                        </div>
                        
                        {{-- Jumlah Unit Badge --}}
                        <div class="absolute top-4 right-4">
                            <span id="previewJumlah" class="px-3 py-1.5 bg-blue-600/90 backdrop-blur-sm text-white text-xs font-semibold rounded-full shadow-lg">
                                1 Unit
                            </span>
                        </div>
                        
                        {{-- Judul --}}
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 id="previewNama" class="text-xl font-bold text-white">Nama Fasilitas</h3>
                        </div>
                    </div>
                    
                    {{-- Konten Card --}}
                    <div class="p-5 flex-1 flex flex-col">
                        {{-- Info Tambahan --}}
                        <div id="previewInfoContainer" class="flex items-center gap-2 mb-3">
                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>
                            <p id="previewInfo" class="text-sm font-medium text-blue-700">Info Tambahan</p>
                        </div>
                        
                        {{-- Deskripsi --}}
                        <div class="flex-1">
                            <p id="previewDeskripsi" class="text-gray-600 text-sm leading-relaxed">
                                Deskripsi fasilitas akan tampil di sini...
                            </p>
                        </div>
                        
                        {{-- Footer --}}
                        <div class="mt-5 pt-4 border-t border-gray-100 flex items-center">
                            <div class="flex items-center gap-1 text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"></path>
                                </svg>
                                <span class="text-xs">SMAN 12 Makassar</span>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Indicator panah --}}
                    <div class="absolute bottom-0 left-1/2 -translate-x-1/2 translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 z-10">
                        <div class="w-8 h-8 bg-white rounded-full shadow-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-3 text-center">Preview akan diperbarui secara otomatis</p>
            </div>
        </div>
    </div>
</div>

<style>
.fasilitas-card {
    transform: translateY(0);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.fasilitas-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}
</style>

<script>
// Kategori labels
const kategoriLabels = {
    'ruang_kelas': '🏫 Ruang Kelas',
    'laboratorium': '🔬 Laboratorium',
    'perpustakaan': '📚 Perpustakaan',
    'olahraga': '⚽ Olahraga',
    'aula': '🎭 Aula',
    'kantin': '🍽️ Kantin',
    'lainnya': '📦 Lainnya'
};

// Update preview real-time
function updatePreview() {
    // Nama
    const nama = document.getElementById('nama').value || 'Nama Fasilitas';
    document.getElementById('previewNama').textContent = nama;
    
    // Kategori
    const kategori = document.getElementById('kategori').value;
    document.getElementById('previewKategori').textContent = kategoriLabels[kategori] || 'Ruang Kelas';
    
    // Jumlah
    const jumlah = document.getElementById('jumlah').value || '1';
    document.getElementById('previewJumlah').textContent = jumlah + ' Unit';
    
    // Info Tambahan
    const info = document.getElementById('info_tambahan').value;
    const infoContainer = document.getElementById('previewInfoContainer');
    const infoText = document.getElementById('previewInfo');
    
    if (info) {
        infoContainer.style.display = 'flex';
        infoText.textContent = info;
    } else {
        infoContainer.style.display = 'none';
    }
    
    // Deskripsi
    const deskripsi = document.getElementById('deskripsi').value;
    if (deskripsi) {
        document.getElementById('previewDeskripsi').textContent = deskripsi;
        document.getElementById('previewDeskripsi').classList.remove('text-gray-400', 'italic');
    } else {
        document.getElementById('previewDeskripsi').textContent = 'Deskripsi fasilitas akan tampil di sini...';
        document.getElementById('previewDeskripsi').classList.add('text-gray-400', 'italic');
    }
}

// Preview gambar
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewGambar').src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('previewGambar').src = "{{ asset('images/default-fasilitas.jpg') }}";
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['nama', 'kategori', 'jumlah', 'info_tambahan', 'deskripsi'];
    inputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updatePreview);
        }
    });
    
    // Initial preview
    updatePreview();
    
    // Set old values if any
    @if(old('nama'))
        document.getElementById('nama').value = @json(old('nama'));
    @endif
    @if(old('kategori'))
        document.getElementById('kategori').value = @json(old('kategori'));
    @endif
    @if(old('info_tambahan'))
        document.getElementById('info_tambahan').value = @json(old('info_tambahan'));
    @endif
    @if(old('jumlah'))
        document.getElementById('jumlah').value = @json(old('jumlah'));
    @endif
    @if(old('deskripsi'))
        document.getElementById('deskripsi').value = @json(old('deskripsi'));
    @endif
    
    // Update after setting old values
    setTimeout(updatePreview, 100);
});
</script>
@endsection