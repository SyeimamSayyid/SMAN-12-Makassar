@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-3xl shadow-lg relative">
    
    {{-- Success Notification --}}
    @if(session('success'))
    <div class="mb-6 animate-slideDown">
        <div class="card">
            <svg class="wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L1428.6,320C1417.1,320,1394,320,1371,320C1348.6,320,1326,320,1303,320C1280,320,1257,320,1234,320C1211.4,320,1189,320,1166,320C1142.9,320,1120,320,1097,320C1074.3,320,1051,320,1029,320C1005.7,320,983,320,960,320C937.1,320,914,320,891,320C868.6,320,846,320,823,320C800,320,777,320,754,320C731.4,320,709,320,686,320C662.9,320,640,320,617,320C594.3,320,571,320,549,320C525.7,320,503,320,480,320C457.1,320,434,320,411,320C388.6,320,366,320,343,320C320,320,297,320,274,320C251.4,320,229,320,206,320C182.9,320,160,320,137,320C114.3,320,91,320,69,320C45.7,320,23,320,11,320L0,320Z" fill-opacity="1"></path>
            </svg>

            <div class="icon-container">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="icon">
                    <path d="M256 48a208 208 0 1 1 0 416 208 208 0 1 1 0-416zm0 464A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-111 111-47-47c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0L369 209z"></path>
                </svg>
            </div>
            
            <div class="message-text-container">
                <p class="message-text">Berhasil!</p>
                <p class="sub-text">{{ session('success') }}</p>
            </div>
            
            <svg onclick="this.parentElement.remove()" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15 15" class="cross-icon">
                <path fill="currentColor" d="M11.7816 4.03157C12.0062 3.80702 12.0062 3.44295 11.7816 3.2184C11.5571 2.99385 11.193 2.99385 10.9685 3.2184L7.50005 6.68682L4.03164 3.2184C3.80708 2.99385 3.44301 2.99385 3.21846 3.2184C2.99391 3.44295 2.99391 3.80702 3.21846 4.03157L6.68688 7.49999L3.21846 10.9684C2.99391 11.193 2.99391 11.557 3.21846 11.7816C3.44301 12.0061 3.80708 12.0061 4.03164 11.7816L7.50005 8.31316L10.9685 11.7816C11.193 12.0061 11.5571 12.0061 11.7816 11.7816C12.0062 11.557 12.0062 11.193 11.7816 10.9684L8.31322 7.49999L11.7816 4.03157Z" clip-rule="evenodd" fill-rule="evenodd"></path>
            </svg>
        </div>
    </div>
    @endif

    {{-- Error Notifications --}}
    @if($errors->any())
    <div class="mb-6">
        @foreach($errors->all() as $error)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-2 rounded-lg shadow-md animate-slideDown">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ $error }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Berita Baru
        </h1>

        <a href="{{ route('admin.berita.index') }}" 
           class="group flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-xl font-medium shadow-md hover:shadow-lg transition-all duration-300">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar Berita
        </a>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        {{-- Form Input --}}
        <div class="space-y-5">
            <form action="{{ route('admin.berita.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="beritaForm">
                @csrf

                {{-- Judul --}}
                <div class="space-y-1.5">
                    <label for="judul" class="block font-medium text-gray-700">
                        Judul Berita <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="judul"
                           id="judul"
                           value="{{ old('judul') }}"
                           required
                           placeholder="Masukkan judul berita"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- Tanggal --}}
                <div class="space-y-1.5">
                    <label for="tanggal" class="block font-medium text-gray-700">
                        Tanggal Upload <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="date"
                               name="tanggal"
                               id="tanggal"
                               value="{{ old('tanggal', date('Y-m-d')) }}"
                               required
                               class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition cursor-pointer">
                    </div>
                </div>

                {{-- Author --}}
                <div class="space-y-1.5">
                    <label for="author" class="block font-medium text-gray-700">
                        Penulis <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="author"
                           id="author"
                           value="{{ old('author') }}"
                           required
                           placeholder="Nama penulis"
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- Isi Berita --}}
                <div class="space-y-1.5">
                    <label for="isi" class="block font-medium text-gray-700">
                        Isi Berita <span class="text-red-500">*</span>
                    </label>
                    <textarea name="isi"
                              id="isi"
                              rows="6"
                              required
                              placeholder="Tulis isi berita di sini..."
                              class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y">{{ old('isi') }}</textarea>
                </div>

                {{-- Upload Foto --}}
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="block font-medium text-gray-700">
                            Upload Foto (Min 1 - Max 10) <span class="text-red-500">*</span>
                        </label>
                        <span class="text-xs text-gray-500" id="sizeInfo">Total: 0 MB / 10 MB</span>
                    </div>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition cursor-pointer bg-gray-50"
                         onclick="document.getElementById('fileInput').click()">
                        <input type="file"
                               name="images[]"
                               id="fileInput"
                               multiple
                               accept="image/jpeg,image/png,image/jpg,image/gif"
                               required
                               class="hidden"
                               onchange="handleFileSelect(this)">
                        
                        <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm text-gray-600">Klik untuk pilih foto</p>
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG, GIF (Maks 10 foto, total 10MB)</p>
                    </div>

                    {{-- Loading Indicator --}}
                    <div id="uploadLoading" class="hidden mt-2 p-2 bg-blue-50 rounded-lg flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm text-blue-700">Memproses gambar...</span>
                    </div>

                    {{-- Info Foto Utama --}}
                    <div id="mainPhotoInfo" class="hidden mt-2 p-2 bg-yellow-50 rounded-lg text-xs text-yellow-700">
                        <span class="font-medium">Foto Utama:</span> <span id="mainPhotoName">-</span>
                        <button type="button" onclick="clearMainPhoto()" class="ml-2 text-yellow-800 hover:text-yellow-900 underline">Reset</button>
                    </div>

                    {{-- Grid Foto dengan Drag & Drop --}}
                    <div id="imagePreviewContainer" class="mt-3">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-xs text-gray-500">
                                <span id="imageCount">0</span>/10 foto dipilih
                            </p>
                            <p class="text-xs text-gray-400">Drag untuk mengatur urutan</p>
                        </div>
                        <div id="sortableGrid" class="grid grid-cols-5 gap-2"></div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex items-center gap-3 pt-4">
                    <button type="submit"
                            id="submitBtn"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition shadow-md flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1-4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Simpan Berita
                    </button>
                    
                    <a href="{{ route('admin.berita.index') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-medium transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        {{-- Preview Card --}}
        <div class="lg:sticky lg:top-4 h-fit">
            <h2 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                Preview Berita
            </h2>

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                {{-- Image Preview --}}
                <div class="h-48 bg-gray-100" id="previewMainImage">
                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm">Foto utama</p>
                        </div>
                    </div>
                </div>

                {{-- Content Preview --}}
                <div class="p-5">
                    <h3 id="previewJudul" class="font-bold text-xl text-gray-800 mb-2">Judul Berita</h3>
                    
                    <div class="flex items-center gap-3 text-sm text-gray-500 mb-3 pb-3 border-b border-gray-100">
                        <span id="previewAuthor" class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Penulis</span>
                        </span>
                        <span>|</span>
                        <span id="previewTanggal" class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span>{{ date('d M Y') }}</span>
                        </span>
                    </div>

                    <div id="previewIsi" class="text-gray-600 text-sm leading-relaxed line-clamp-4">
                        Isi berita akan tampil di sini...
                    </div>

                    {{-- Gallery Preview --}}
                    <div id="previewGallery" class="mt-4 pt-3 border-t border-gray-100">
                        <p class="text-xs text-gray-500 mb-2">Galeri Foto ({{ count($imagePreviews ?? []) }}/10)</p>
                        <div id="previewGalleryGrid" class="grid grid-cols-5 gap-1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Card Success */
.card {
    width: 100%;
    max-width: 400px;
    height: 80px;
    border-radius: 8px;
    box-sizing: border-box;
    padding: 10px 15px;
    background-color: #ffffff;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-around;
    gap: 15px;
    margin: 0 auto;
}

.wave {
    position: absolute;
    transform: rotate(90deg);
    left: -31px;
    top: 32px;
    width: 80px;
    fill: #04e4003a;
}

.icon-container {
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #04e40048;
    border-radius: 50%;
    margin-left: 8px;
    flex-shrink: 0;
}

.icon {
    width: 17px;
    height: 17px;
    color: #269b24;
}

.message-text-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    flex-grow: 1;
    min-width: 0;
}

.message-text {
    color: #269b24;
    font-size: 17px;
    font-weight: 700;
    margin: 0;
}

.sub-text {
    font-size: 14px;
    color: #555;
    margin: 0;
}

.cross-icon {
    width: 18px;
    height: 18px;
    color: #555;
    cursor: pointer;
    flex-shrink: 0;
}

.cross-icon:hover {
    color: #ff4444;
}

.line-clamp-4 {
    display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-slideDown {
    animation: slideDown 0.3s ease-out;
}

/* Thumbnail Styles */
.thumb-item {
    aspect-ratio: 1/1;
    border-radius: 0.375rem;
    overflow: hidden;
    border: 2px solid #e5e7eb;
    position: relative;
    cursor: move;
    transition: all 0.2s;
}

.thumb-item:hover {
    border-color: #3b82f6;
    transform: scale(1.02);
}

.thumb-item.is-main {
    border-color: #eab308;
    border-width: 3px;
    box-shadow: 0 0 0 2px rgba(234, 179, 8, 0.2);
}

.thumb-item.is-main::before {
    content: '★';
    position: absolute;
    top: 2px;
    left: 2px;
    background: #eab308;
    color: white;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    z-index: 10;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumb-overlay {
    position: absolute;
    top: 2px;
    right: 2px;
    display: flex;
    gap: 2px;
    opacity: 0;
    transition: opacity 0.2s;
}

.thumb-item:hover .thumb-overlay {
    opacity: 1;
}

.thumb-btn {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    transition: all 0.2s;
}

.thumb-btn.main {
    background: #eab308;
    color: white;
}

.thumb-btn.main:hover {
    background: #ca8a04;
}

.thumb-btn.remove {
    background: #ef4444;
    color: white;
}

.thumb-btn.remove:hover {
    background: #dc2626;
}

.thumb-btn.move {
    background: #3b82f6;
    color: white;
    cursor: grab;
}

.thumb-btn.move:active {
    cursor: grabbing;
}

/* Drag & Drop */
.sortable-ghost {
    opacity: 0.4;
    border: 2px dashed #3b82f6;
}

.sortable-drag {
    opacity: 0.8;
    transform: rotate(2deg);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
</style>

{{-- SortableJS Library --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
let selectedFiles = [];
let imagePreviews = [];
let mainPhotoIndex = 0;
let sortableInstance = null;
let totalSize = 0;

const MAX_FILES = 10;
const MAX_TOTAL_SIZE = 10 * 1024 * 1024; // 10 MB

function formatSize(bytes) {
    return (bytes / (1024 * 1024)).toFixed(2);
}

function updateSizeInfo() {
    document.getElementById('sizeInfo').textContent = `Total: ${formatSize(totalSize)} MB / 10 MB`;
}

function handleFileSelect(input) {
    const files = Array.from(input.files);
    
    // Validasi jumlah file
    if (files.length > MAX_FILES) {
        alert(`Maksimal ${MAX_FILES} foto yang dapat diupload!`);
        input.value = '';
        return;
    }
    
    // Hitung total size
    let newTotalSize = 0;
    for (let file of files) {
        newTotalSize += file.size;
    }
    
    // Validasi total ukuran
    if (newTotalSize > MAX_TOTAL_SIZE) {
        alert(`Total ukuran foto (${formatSize(newTotalSize)} MB) melebihi batas 10 MB!`);
        input.value = '';
        return;
    }
    
    // Validasi tipe file
    for (let file of files) {
        if (!file.type.startsWith('image/')) {
            alert(`File ${file.name} bukan gambar!`);
            input.value = '';
            return;
        }
    }
    
    // Tampilkan loading
    document.getElementById('uploadLoading').classList.remove('hidden');
    
    setTimeout(() => {
        selectedFiles = files;
        totalSize = newTotalSize;
        updateSizeInfo();
        
        // Reset main photo index jika melebihi
        if (mainPhotoIndex >= files.length) {
            mainPhotoIndex = 0;
        }
        
        generatePreviews(files);
        document.getElementById('uploadLoading').classList.add('hidden');
    }, 100);
}

function generatePreviews(files) {
    const container = document.getElementById('sortableGrid');
    const galleryGrid = document.getElementById('previewGalleryGrid');
    
    container.innerHTML = '';
    galleryGrid.innerHTML = '';
    imagePreviews = [];
    
    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreviews[index] = e.target.result;
            renderAllThumbnails();
        };
        reader.readAsDataURL(file);
    });
    
    document.getElementById('imageCount').textContent = files.length;
}

function renderAllThumbnails() {
    if (imagePreviews.length !== selectedFiles.length) return;
    
    const container = document.getElementById('sortableGrid');
    const galleryGrid = document.getElementById('previewGalleryGrid');
    
    container.innerHTML = '';
    galleryGrid.innerHTML = '';
    
    selectedFiles.forEach((file, index) => {
        const preview = imagePreviews[index];
        if (!preview) return;
        
        // Thumbnail untuk form (dengan kontrol)
        const thumb = document.createElement('div');
        thumb.className = `thumb-item ${index === mainPhotoIndex ? 'is-main' : ''}`;
        thumb.dataset.index = index;
        thumb.innerHTML = `
            <img src="${preview}" alt="Foto ${index + 1}">
            <div class="thumb-overlay">
                ${index !== mainPhotoIndex ? `
                <button type="button" class="thumb-btn main" onclick="setAsMainPhoto(${index})" title="Jadikan foto utama">★</button>
                ` : ''}
                <button type="button" class="thumb-btn remove" onclick="removePhoto(${index})" title="Hapus">×</button>
                <button type="button" class="thumb-btn move" title="Drag untuk memindahkan">☰</button>
            </div>
        `;
        container.appendChild(thumb);
        
        // Thumbnail untuk preview gallery
        const galleryThumb = document.createElement('div');
        galleryThumb.className = 'thumb-item' + (index === mainPhotoIndex ? ' is-main' : '');
        galleryThumb.innerHTML = `<img src="${preview}" alt="Foto ${index + 1}">`;
        galleryGrid.appendChild(galleryThumb);
    });
    
    // Update main preview
    if (imagePreviews[mainPhotoIndex]) {
        updateMainPreview(imagePreviews[mainPhotoIndex]);
        document.getElementById('mainPhotoName').textContent = selectedFiles[mainPhotoIndex]?.name || '-';
        document.getElementById('mainPhotoInfo').classList.remove('hidden');
    } else {
        updateMainPreview(null);
        document.getElementById('mainPhotoInfo').classList.add('hidden');
    }
    
    // Update gallery count
    document.querySelector('#previewGallery p').innerHTML = `Galeri Foto (${selectedFiles.length}/${MAX_FILES})`;
    
    // Inisialisasi SortableJS
    initSortable();
}

function initSortable() {
    const container = document.getElementById('sortableGrid');
    
    if (sortableInstance) {
        sortableInstance.destroy();
    }
    
    sortableInstance = new Sortable(container, {
        animation: 150,
        handle: '.thumb-btn.move',
        ghostClass: 'sortable-ghost',
        dragClass: 'sortable-drag',
        onEnd: function(evt) {
            // Update urutan file
            const oldIndex = evt.oldIndex;
            const newIndex = evt.newIndex;
            
            if (oldIndex !== newIndex) {
                // Reorder array
                const movedFile = selectedFiles[oldIndex];
                const movedPreview = imagePreviews[oldIndex];
                
                selectedFiles.splice(oldIndex, 1);
                selectedFiles.splice(newIndex, 0, movedFile);
                
                imagePreviews.splice(oldIndex, 1);
                imagePreviews.splice(newIndex, 0, movedPreview);
                
                // Update main photo index jika perlu
                if (mainPhotoIndex === oldIndex) {
                    mainPhotoIndex = newIndex;
                } else if (oldIndex < mainPhotoIndex && newIndex >= mainPhotoIndex) {
                    mainPhotoIndex--;
                } else if (oldIndex > mainPhotoIndex && newIndex <= mainPhotoIndex) {
                    mainPhotoIndex++;
                }
                
                // Update DataTransfer untuk file input
                updateFileInput();
                
                // Render ulang
                renderAllThumbnails();
            }
        }
    });
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    document.getElementById('fileInput').files = dt.files;
}

function setAsMainPhoto(index) {
    mainPhotoIndex = index;
    renderAllThumbnails();
    updateFileInput();
}

function clearMainPhoto() {
    // Set main photo ke index 0 atau null jika tidak ada
    if (selectedFiles.length > 0) {
        mainPhotoIndex = 0;
    }
    renderAllThumbnails();
}

function removePhoto(index) {
    // Hapus dari array
    selectedFiles.splice(index, 1);
    imagePreviews.splice(index, 1);
    
    // Update total size
    totalSize = selectedFiles.reduce((sum, file) => sum + file.size, 0);
    updateSizeInfo();
    
    // Update main photo index
    if (selectedFiles.length === 0) {
        mainPhotoIndex = 0;
    } else if (mainPhotoIndex >= selectedFiles.length) {
        mainPhotoIndex = selectedFiles.length - 1;
    }
    
    // Update file input
    updateFileInput();
    
    // Render ulang
    if (selectedFiles.length > 0) {
        renderAllThumbnails();
    } else {
        document.getElementById('sortableGrid').innerHTML = '';
        document.getElementById('previewGalleryGrid').innerHTML = '';
        document.getElementById('imageCount').textContent = '0';
        document.getElementById('mainPhotoInfo').classList.add('hidden');
        updateMainPreview(null);
        document.querySelector('#previewGallery p').innerHTML = `Galeri Foto (0/${MAX_FILES})`;
    }
}

function updateMainPreview(src) {
    const mainPreview = document.getElementById('previewMainImage');
    
    if (src) {
        mainPreview.innerHTML = `<img src="${src}" class="w-full h-full object-cover">`;
    } else {
        mainPreview.innerHTML = `
            <div class="w-full h-full flex items-center justify-center text-gray-400">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-sm">Foto utama</p>
                </div>
            </div>
        `;
    }
}

// Update preview real-time
document.addEventListener('DOMContentLoaded', function() {
    const judulInput = document.getElementById('judul');
    const authorInput = document.getElementById('author');
    const tanggalInput = document.getElementById('tanggal');
    const isiInput = document.getElementById('isi');
    
    function updateTextPreview() {
        document.getElementById('previewJudul').textContent = judulInput.value || 'Judul Berita';
        
        const authorSpan = document.querySelector('#previewAuthor span');
        if (authorSpan) {
            authorSpan.textContent = authorInput.value || 'Penulis';
        }
        
        if (tanggalInput.value) {
            const date = new Date(tanggalInput.value + 'T00:00:00');
            const options = { day: 'numeric', month: 'short', year: 'numeric' };
            const dateStr = date.toLocaleDateString('id-ID', options);
            document.querySelector('#previewTanggal span').textContent = dateStr;
        }
        
        const isi = isiInput.value;
        const previewIsi = document.getElementById('previewIsi');
        if (isi) {
            previewIsi.textContent = isi;
            previewIsi.classList.remove('text-gray-400', 'italic');
        } else {
            previewIsi.textContent = 'Isi berita akan tampil di sini...';
            previewIsi.classList.add('text-gray-400', 'italic');
        }
    }
    
    judulInput.addEventListener('input', updateTextPreview);
    authorInput.addEventListener('input', updateTextPreview);
    tanggalInput.addEventListener('change', updateTextPreview);
    isiInput.addEventListener('input', updateTextPreview);
    
    updateTextPreview();
});

// Loading state saat submit
document.getElementById('beritaForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = `
        <svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Menyimpan...
    `;
    btn.disabled = true;
});
</script>
@endsection