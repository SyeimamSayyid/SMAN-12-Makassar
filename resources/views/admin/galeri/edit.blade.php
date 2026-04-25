@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Galeri</h1>
        <p class="text-gray-500 text-sm mt-1">Perbarui data galeri kegiatan</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Form Input --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <form action="{{ route('admin.galeri.update', $galeri) }}" method="POST" enctype="multipart/form-data" id="galeriForm">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        {{-- Judul --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Judul <span class="text-red-500">*</span></label>
                            <input type="text" name="judul" id="judul" value="{{ old('judul', $galeri->judul) }}" required 
                                   class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                            @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Kategori --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori" id="kategori" required class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">
                                <option value="Upacara" {{ old('kategori', $galeri->kategori) == 'Upacara' ? 'selected' : '' }}>🇮🇩 Upacara</option>
                                <option value="Akademik" {{ old('kategori', $galeri->kategori) == 'Akademik' ? 'selected' : '' }}>📚 Akademik</option>
                                <option value="Olahraga" {{ old('kategori', $galeri->kategori) == 'Olahraga' ? 'selected' : '' }}>⚽ Olahraga</option>
                                <option value="Seni" {{ old('kategori', $galeri->kategori) == 'Seni' ? 'selected' : '' }}>🎨 Seni</option>
                                <option value="Keagamaan" {{ old('kategori', $galeri->kategori) == 'Keagamaan' ? 'selected' : '' }}>🕌 Keagamaan</option>
                                <option value="Lomba" {{ old('kategori', $galeri->kategori) == 'Lomba' ? 'selected' : '' }}>🏆 Lomba</option>
                                <option value="Study Tour" {{ old('kategori', $galeri->kategori) == 'Study Tour' ? 'selected' : '' }}>🚌 Study Tour</option>
                                <option value="Lainnya" {{ old('kategori', $galeri->kategori) == 'Lainnya' ? 'selected' : '' }}>📦 Lainnya</option>
                            </select>
                            @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" 
                                      class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                            @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Tanggal & Lokasi --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Tanggal Kegiatan <span class="text-gray-400 text-xs font-normal">(Opsional)</span></label>
                                <input type="text" name="tanggal_kegiatan" id="tanggal_kegiatan" 
                                       value="{{ old('tanggal_kegiatan', $galeri->tanggal_kegiatan) }}" 
                                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"
                                       placeholder="Contoh: 17 Agustus">
                                <p class="text-xs text-gray-400 mt-1">Format bebas, tanpa tahun</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Lokasi</label>
                                <input type="text" name="lokasi" id="lokasi" value="{{ old('lokasi', $galeri->lokasi) }}" 
                                       class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"
                                       placeholder="Contoh: Lapangan Utama">
                            </div>
                        </div>

                        {{-- Gambar Utama --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Gambar Utama</label>
                            @if($galeri->gambar_utama)
                                <img src="{{ asset('storage/' . $galeri->gambar_utama) }}" class="w-24 h-24 object-cover rounded-lg mb-2 border">
                            @endif
                            <input type="file" name="gambar_utama" id="gambar_utama" accept="image/*" 
                                   class="w-full border rounded-lg px-4 py-2" onchange="previewMainImage(event)">
                            <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti gambar</p>
                            @error('gambar_utama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Gambar Lain --}}
                        <div>
                            <label class="block text-sm font-medium mb-1">Gambar Lain (Multiple)</label>
                            @if($galeri->gambar_lain)
                                <div class="flex flex-wrap gap-2 mb-3" id="existing-images">
                                    @foreach($galeri->gambar_lain as $index => $img)
                                        <div class="relative" data-index="{{ $index }}">
                                            <img src="{{ asset('storage/' . $img) }}" class="w-20 h-20 object-cover rounded-lg border">
                                            <button type="button" onclick="deleteImage({{ $index }})" 
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600">
                                                ×
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" name="gambar_lain[]" id="gambar_lain" accept="image/*" multiple 
                                   class="w-full border rounded-lg px-4 py-2" onchange="previewOtherImages(event)">
                            <p class="text-xs text-gray-400 mt-1">Bisa pilih lebih dari satu gambar (Max 2MB per gambar)</p>
                            @error('gambar_lain.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Urutan, Aktif, Featured --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Urutan</label>
                                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $galeri->urutan) }}" 
                                       class="w-full border rounded-lg px-4 py-2">
                                <p class="text-xs text-gray-400 mt-1">Semakin kecil, semakin awal</p>
                            </div>
                            <div class="flex items-end pb-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $galeri->is_active) ? 'checked' : '' }}
                                           class="w-4 h-4 text-purple-600 rounded focus:ring-purple-500">
                                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                </label>
                            </div>
                            <div class="flex items-end pb-2">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $galeri->is_featured) ? 'checked' : '' }}
                                           class="w-4 h-4 text-yellow-600 rounded focus:ring-yellow-500">
                                    <span class="ml-2 text-sm text-gray-700">Featured</span>
                                </label>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex gap-3 pt-4 border-t">
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                                💾 Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.galeri.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">
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
                <div class="galeri-card group bg-white rounded-2xl shadow-lg overflow-hidden">
                    {{-- Gambar --}}
                    <div class="relative h-44 overflow-hidden bg-gradient-to-br from-purple-100 to-indigo-100">
                        <img id="previewGambarUtama" 
                             src="{{ $galeri->gambar_utama ? asset('storage/' . $galeri->gambar_utama) : asset('images/default-galeri.jpg') }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        
                        {{-- Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        {{-- Kategori Badge --}}
                        <div class="absolute top-4 left-4">
                            <span id="previewKategori" class="px-3 py-1.5 bg-white/90 backdrop-blur-sm text-gray-800 text-xs font-semibold rounded-full shadow-lg">
                                {{ $galeri->kategori }}
                            </span>
                        </div>
                        
                        {{-- Featured Badge --}}
                        <div id="previewFeatured" class="absolute top-4 right-4 {{ $galeri->is_featured ? '' : 'hidden' }}">
                            <span class="px-3 py-1.5 bg-yellow-500/90 backdrop-blur-sm text-white text-xs font-semibold rounded-full shadow-lg">
                                ★ Featured
                            </span>
                        </div>
                        
                        {{-- Judul --}}
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 id="previewJudul" class="text-xl font-bold text-white">{{ $galeri->judul }}</h3>
                        </div>
                    </div>
                    
                    {{-- Konten --}}
                    <div class="p-5">
                        {{-- Tanggal & Lokasi --}}
                        <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                            <span id="previewTanggalContainer" class="flex items-center gap-1 {{ $galeri->tanggal_kegiatan ? '' : 'hidden' }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span id="previewTanggal">{{ $galeri->tanggal_kegiatan }}</span>
                            </span>
                            <span id="previewLokasiContainer" class="flex items-center gap-1 {{ $galeri->lokasi ? '' : 'hidden' }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span id="previewLokasi">{{ $galeri->lokasi }}</span>
                            </span>
                        </div>
                        
                        {{-- Deskripsi --}}
                        <p id="previewDeskripsi" class="text-gray-600 text-sm leading-relaxed line-clamp-3 {{ $galeri->deskripsi ? '' : 'text-gray-400 italic' }}">
                            {{ $galeri->deskripsi ?? 'Deskripsi galeri akan tampil di sini...' }}
                        </p>
                        
                        {{-- Gambar Lain --}}
                        <div id="previewGambarLainContainer" class="mt-4 pt-3 border-t border-gray-100">
                            <p class="text-xs text-gray-400 mb-2">Gambar Lain</p>
                            <div id="previewGambarLain" class="grid grid-cols-4 gap-2">
                                @if($galeri->gambar_lain)
                                    @foreach($galeri->gambar_lain as $img)
                                        <div class="aspect-square rounded-lg overflow-hidden border border-gray-200">
                                            <img src="{{ asset('storage/' . $img) }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-3 text-center">Preview akan diperbarui secara otomatis</p>
            </div>
        </div>
    </div>
</div>

<style>
.galeri-card {
    transform: translateY(0);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.galeri-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
// Kategori labels
const kategoriLabels = {
    'Upacara': '🇮🇩 Upacara',
    'Akademik': '📚 Akademik',
    'Olahraga': '⚽ Olahraga',
    'Seni': '🎨 Seni',
    'Keagamaan': '🕌 Keagamaan',
    'Lomba': '🏆 Lomba',
    'Study Tour': '🚌 Study Tour',
    'Lainnya': '📦 Lainnya'
};

// Update preview real-time
function updatePreview() {
    // Judul
    const judul = document.getElementById('judul').value || 'Judul Galeri';
    document.getElementById('previewJudul').textContent = judul;
    
    // Kategori
    const kategori = document.getElementById('kategori').value;
    document.getElementById('previewKategori').textContent = kategoriLabels[kategori] || kategori;
    
    // Featured
    const featured = document.getElementById('is_featured').checked;
    document.getElementById('previewFeatured').style.display = featured ? 'block' : 'none';
    
    // Tanggal
    const tanggal = document.getElementById('tanggal_kegiatan').value;
    const tanggalSpan = document.getElementById('previewTanggal');
    const tanggalContainer = document.getElementById('previewTanggalContainer');
    if (tanggal) {
        tanggalSpan.textContent = tanggal;
        tanggalContainer.style.display = 'flex';
    } else {
        tanggalContainer.style.display = 'none';
    }
    
    // Lokasi
    const lokasi = document.getElementById('lokasi').value;
    const lokasiSpan = document.getElementById('previewLokasi');
    const lokasiContainer = document.getElementById('previewLokasiContainer');
    if (lokasi) {
        lokasiSpan.textContent = lokasi;
        lokasiContainer.style.display = 'flex';
    } else {
        lokasiContainer.style.display = 'none';
    }
    
    // Deskripsi
    const deskripsi = document.getElementById('deskripsi').value;
    const previewDeskripsi = document.getElementById('previewDeskripsi');
    if (deskripsi) {
        previewDeskripsi.textContent = deskripsi;
        previewDeskripsi.classList.remove('text-gray-400', 'italic');
    } else {
        previewDeskripsi.textContent = 'Deskripsi galeri akan tampil di sini...';
        previewDeskripsi.classList.add('text-gray-400', 'italic');
    }
}

// Preview gambar utama
function previewMainImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewGambarUtama').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}

// Preview gambar lain (tambahan)
let newImagePreviews = [];
function previewOtherImages(event) {
    const files = Array.from(event.target.files);
    const container = document.getElementById('previewGambarLain');
    
    // Simpan existing images dulu
    const existingImages = container.querySelectorAll('.existing-preview');
    
    // Hapus preview baru sebelumnya
    container.querySelectorAll('.new-preview').forEach(el => el.remove());
    
    files.slice(0, 8).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'aspect-square rounded-lg overflow-hidden border border-gray-200 new-preview';
            div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            container.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    
    if (files.length > 8) {
        const div = document.createElement('div');
        div.className = 'aspect-square rounded-lg bg-gray-100 flex items-center justify-center text-xs text-gray-500 new-preview';
        div.textContent = '+' + (files.length - 8);
        container.appendChild(div);
    }
}

// Delete image function
function deleteImage(index) {
    if (!confirm('Hapus gambar ini?')) return;
    
    fetch('{{ route("admin.galeri.delete-image", $galeri) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ index: index })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            // Hapus dari DOM
            document.querySelector(`[data-index="${index}"]`).remove();
            // Hapus dari preview
            const previewContainer = document.getElementById('previewGambarLain');
            if (previewContainer.children[index]) {
                previewContainer.children[index].remove();
            }
        }
    });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['judul', 'kategori', 'tanggal_kegiatan', 'lokasi', 'deskripsi', 'is_featured'];
    inputs.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.addEventListener('input', updatePreview);
            el.addEventListener('change', updatePreview);
        }
    });
    
    // Initial preview
    updatePreview();
});
</script>
@endsection