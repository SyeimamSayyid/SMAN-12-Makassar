@extends('layouts.admin')

@section('title', 'Tambah SPMB')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah SPMB</h1>
        <p class="text-gray-500 text-sm mt-1">Tambahkan informasi Seleksi Penerimaan Murid Baru</p>
    </div>

    {{-- Grid: Form (kiri) + Preview (kanan) --}}
    <div class="grid lg:grid-cols-2 gap-6">
        
        {{-- FORM SECTION --}}
        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('admin.spmb.store') }}" method="POST" enctype="multipart/form-data" id="spmbForm">
                @csrf
                <div class="space-y-5">
                    
                    {{-- Judul --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" id="inputJudul" value="{{ old('judul') }}" required 
                               class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500" 
                               placeholder="Contoh: Penerimaan Murid Baru 2025/2026">
                        @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Deskripsi</label>
                        <textarea name="deskripsi" id="inputDeskripsi" rows="4" 
                                  class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500" 
                                  placeholder="Informasi lengkap tentang SPMB...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Link Pendaftaran --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Link Pendaftaran</label>
                        <input type="url" name="link_pendaftaran" id="inputLink" value="{{ old('link_pendaftaran') }}" 
                               class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500" 
                               placeholder="https://ppdb.sman12mks.sch.id">
                        <p class="text-xs text-gray-400 mt-1">Link untuk tombol "Daftar Sekarang"</p>
                        @error('link_pendaftaran') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Upload <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_upload" id="inputTglUpload" value="{{ old('tanggal_upload', date('Y-m-d')) }}" required 
                                   class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                            @error('tanggal_upload') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Berakhir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_berakhir" id="inputTglBerakhir" value="{{ old('tanggal_berakhir') }}" required 
                                   class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                            @error('tanggal_berakhir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Foto Utama --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Foto Utama</label>
                        <input type="file" name="foto" id="inputFoto" accept="image/*" 
                               class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG. Maksimal 2MB</p>
                        @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Video --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Video (Maksimal 5)</label>
                        <div id="video-container"></div>
                        <button type="button" onclick="addVideoField()" 
                                class="mt-3 text-blue-600 hover:text-blue-700 text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Video
                        </button>
                        <p class="text-xs text-gray-400 mt-1">Pilih tipe: Link YouTube atau Upload File. Maksimal 5 video.</p>
                        @error('video') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Galeri Foto dengan Drag & Drop + REORDER --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Galeri Foto 
                            <span class="text-gray-400 text-xs ml-2">(Maksimal 15 foto, drag untuk upload & atur ulang)</span>
                        </label>
                        
                        {{-- Preview Grid dengan Drag & Drop Reorder --}}
                        <div id="galeriPreview" class="grid grid-cols-5 gap-2 mb-3 min-h-[80px]"></div>
                        
                        {{-- Drag & Drop Upload Area --}}
                        <div id="dropZone" 
                             class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 transition-all duration-300 hover:border-blue-400 hover:bg-blue-50/50 cursor-pointer">
                            <input type="file" name="galeri[]" id="inputGaleri" accept="image/*" multiple 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            
                            <div class="text-center pointer-events-none">
                                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-gray-600 font-medium mb-1 text-sm">
                                    <span class="text-blue-600">Drag & drop</span> atau <span class="text-blue-600">klik</span> untuk upload
                                </p>
                                <p class="text-xs text-gray-400">JPG, PNG. Maks 2MB/foto. Total 15 foto.</p>
                            </div>
                        </div>
                        
                        {{-- Info --}}
                        <div id="galeriInfo" class="mt-2 flex items-center justify-between text-xs">
                            <span id="photoCount" class="text-gray-500">0/15 foto</span>
                            <span class="text-gray-400 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                                Drag foto untuk atur ulang
                            </span>
                            <span id="photoSizeWarning" class="text-orange-500 hidden">⚠️ Ada foto > 2MB</span>
                        </div>
                        
                        @error('galeri') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-3 pt-4 border-t">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                            Simpan
                        </button>
                        <a href="{{ route('admin.spmb.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">
                            Batal
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- PREVIEW CARD SECTION --}}
        <div class="lg:sticky lg:top-24 h-fit">
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex items-center justify-between mb-4 pb-2 border-b">
                    <h3 class="font-semibold text-gray-700 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Preview Tampilan Public
                    </h3>
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Live</span>
                </div>
                
                {{-- Preview Card --}}
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-blue-100 to-indigo-100">
                        <img id="previewFoto" src="{{ asset('images/default-spmb.jpg') }}" 
                             alt="Preview" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        <div class="absolute top-3 left-3">
                            <span id="previewStatus" class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold shadow-md">
                                ✅ Aktif
                            </span>
                        </div>
                        
                        <div class="absolute top-3 right-3">
                            <span id="previewTanggal" class="bg-white/90 backdrop-blur-sm text-gray-700 px-2.5 py-1 rounded-full text-xs font-medium shadow-md flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span id="previewTanggalText">{{ date('d M Y') }}</span>
                            </span>
                        </div>
                        
                        <div class="absolute bottom-3 left-3 right-16">
                            <h4 id="previewJudul" class="text-white font-bold text-base drop-shadow-lg line-clamp-2">
                                Judul SPMB
                            </h4>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <p id="previewDeskripsi" class="text-gray-600 text-sm line-clamp-3 leading-relaxed mb-3">
                            Deskripsi SPMB akan muncul di sini...
                        </p>
                        
                        <div id="previewLinkContainer" class="mb-3 hidden">
                            <span class="inline-flex items-center gap-1 text-sm text-green-600 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                </svg>
                                <span id="previewLinkText">Daftar Sekarang</span>
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500 pt-3 border-t border-gray-100">
                            <span id="previewTglBerakhir" class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span id="previewTglBerakhirText">Berakhir: -</span>
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                0 views
                            </span>
                        </div>
                    </div>
                </div>
                
                <p class="text-xs text-gray-400 mt-2 text-center">
                    <span class="inline-flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                        Preview otomatis diperbarui
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
#dropZone { transition: all 0.2s ease; }
#dropZone.border-blue-500 { border-color: #3b82f6 !important; background-color: #eff6ff !important; }
.gallery-item { cursor: grab; transition: all 0.2s; }
.gallery-item:active { cursor: grabbing; opacity: 0.7; }
.gallery-item.dragging { opacity: 0.5; transform: scale(0.95); }
.gallery-item.drag-over { border: 2px solid #3b82f6; transform: scale(1.02); }
</style>

<script>
// ========== VARIABEL ==========
let videoCount = 0;
const MAX_VIDEOS = 5;
let selectedFiles = [];
const MAX_PHOTOS = 15;
const MAX_SIZE = 2 * 1024 * 1024;
let draggedIndex = null;

// ========== PREVIEW FUNCTIONS ==========
function updatePreview() {
    const judul = document.getElementById('inputJudul').value || 'Judul SPMB';
    document.getElementById('previewJudul').textContent = judul;
    
    const deskripsi = document.getElementById('inputDeskripsi').value || 'Deskripsi SPMB akan muncul di sini...';
    document.getElementById('previewDeskripsi').textContent = deskripsi;
    
    const tglUpload = document.getElementById('inputTglUpload').value;
    if (tglUpload) {
        const date = new Date(tglUpload);
        const formatted = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        document.getElementById('previewTanggalText').textContent = formatted;
    }
    
    const tglBerakhir = document.getElementById('inputTglBerakhir').value;
    const tglBerakhirText = document.getElementById('previewTglBerakhirText');
    if (tglBerakhir) {
        const date = new Date(tglBerakhir);
        const formatted = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
        tglBerakhirText.textContent = `Berakhir: ${formatted}`;
    } else {
        tglBerakhirText.textContent = 'Berakhir: -';
    }
    
    const link = document.getElementById('inputLink').value;
    const linkContainer = document.getElementById('previewLinkContainer');
    if (link) { linkContainer.classList.remove('hidden'); } 
    else { linkContainer.classList.add('hidden'); }
    
    const fotoInput = document.getElementById('inputFoto');
    if (fotoInput.files && fotoInput.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => { document.getElementById('previewFoto').src = e.target.result; };
        reader.readAsDataURL(fotoInput.files[0]);
    }
}

// ========== VIDEO FUNCTIONS ==========
function addVideoField() {
    if (videoCount >= MAX_VIDEOS) { alert('Maksimal 5 video!'); return; }
    
    const container = document.getElementById('video-container');
    const index = videoCount;
    const div = document.createElement('div');
    div.className = 'bg-gray-50 p-4 rounded-lg mb-3 border';
    div.id = `video-field-${index}`;
    div.innerHTML = `
        <div class="flex justify-between items-start mb-3">
            <span class="font-medium text-sm text-gray-700">Video ${index + 1}</span>
            <button type="button" onclick="removeVideoField(${index})" class="text-red-500 hover:text-red-700 text-sm">✕</button>
        </div>
        <div class="mb-3">
            <label class="block text-sm font-medium mb-1">Tipe Video</label>
            <select name="video_type[]" onchange="toggleVideoInput(this, ${index})" class="w-full border rounded-lg px-3 py-2">
                <option value="youtube">🎬 Link YouTube</option>
                <option value="upload">📁 Upload File</option>
            </select>
        </div>
        <div class="youtube-input-${index}">
            <label class="block text-sm font-medium mb-1">URL YouTube</label>
            <input type="text" name="video_url[]" placeholder="https://www.youtube.com/watch?v=..." class="w-full border rounded-lg px-4 py-2">
        </div>
        <div class="upload-input-${index} hidden">
            <label class="block text-sm font-medium mb-1">File Video</label>
            <input type="file" name="video_file[]" accept="video/*" class="w-full border rounded-lg px-4 py-2">
            <p class="text-xs text-gray-400 mt-1">MP4, MOV, AVI, WebM. Maks 50MB</p>
        </div>
        <div class="mt-3">
            <label class="block text-sm font-medium mb-1">Caption</label>
            <input type="text" name="video_caption[]" placeholder="Caption video..." class="w-full border rounded-lg px-4 py-2">
        </div>
    `;
    container.appendChild(div);
    videoCount++;
}

function removeVideoField(index) { 
    const field = document.getElementById(`video-field-${index}`); 
    if (field) { field.remove(); videoCount--; reindexVideoFields(); } 
}

function toggleVideoInput(select, index) {
    const youtubeDiv = document.querySelector(`.youtube-input-${index}`);
    const uploadDiv = document.querySelector(`.upload-input-${index}`);
    if (select.value === 'youtube') { youtubeDiv.classList.remove('hidden'); uploadDiv.classList.add('hidden'); } 
    else { youtubeDiv.classList.add('hidden'); uploadDiv.classList.remove('hidden'); }
}

function reindexVideoFields() {
    const container = document.getElementById('video-container');
    const fields = container.children;
    videoCount = fields.length;
    for (let i = 0; i < fields.length; i++) {
        const field = fields[i];
        field.id = `video-field-${i}`;
        field.querySelector('span').textContent = `Video ${i + 1}`;
        field.querySelector('button').setAttribute('onclick', `removeVideoField(${i})`);
        const select = field.querySelector('select');
        select.setAttribute('onchange', `toggleVideoInput(this, ${i})`);
        const youtubeDiv = field.querySelector('[class*="youtube-input-"]');
        const uploadDiv = field.querySelector('[class*="upload-input-"]');
        youtubeDiv.className = `youtube-input-${i}`;
        uploadDiv.className = `upload-input-${i} ${uploadDiv.classList.contains('hidden') ? 'hidden' : ''}`;
    }
}

// ========== GALERI DRAG & DROP + REORDER ==========
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('inputGaleri');
const galeriPreview = document.getElementById('galeriPreview');
const photoCountSpan = document.getElementById('photoCount');
const photoSizeWarning = document.getElementById('photoSizeWarning');

function handleFiles(files) {
    let hasOversize = false;
    const validFiles = [];
    
    for (let file of files) {
        if (!file.type.startsWith('image/')) continue;
        if (file.size > MAX_SIZE) { hasOversize = true; continue; }
        if (selectedFiles.length + validFiles.length >= MAX_PHOTOS) { alert(`Maksimal ${MAX_PHOTOS} foto!`); break; }
        validFiles.push(file);
    }
    
    if (hasOversize) { photoSizeWarning.classList.remove('hidden'); setTimeout(() => photoSizeWarning.classList.add('hidden'), 3000); }
    
    selectedFiles = [...selectedFiles, ...validFiles].slice(0, MAX_PHOTOS);
    updateFileInput();
    renderGalleryPreview();
}

function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
}

function renderGalleryPreview() {
    galeriPreview.innerHTML = '';
    if (selectedFiles.length === 0) {
        galeriPreview.innerHTML = '<p class="col-span-5 text-center text-xs text-gray-400 py-4">Belum ada foto</p>';
        photoCountSpan.textContent = `0/${MAX_PHOTOS} foto`;
        return;
    }
    
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const div = document.createElement('div');
            div.className = 'gallery-item relative group';
            div.setAttribute('draggable', 'true');
            div.setAttribute('data-index', index);
            div.innerHTML = `
                <img src="${e.target.result}" class="w-full aspect-square object-cover rounded-lg border shadow-sm">
                <button type="button" onclick="removePhoto(${index})" 
                        class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md transition z-10">
                    ×
                </button>
                <span class="absolute bottom-1 left-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded-md">
                    ${index + 1}
                </span>
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                    <span class="bg-black/50 text-white text-[10px] px-2 py-1 rounded-full">↕️ Drag</span>
                </div>
            `;
            
            // Drag events untuk reorder
            div.addEventListener('dragstart', handleDragStart);
            div.addEventListener('dragend', handleDragEnd);
            div.addEventListener('dragover', handleDragOver);
            div.addEventListener('dragenter', handleDragEnter);
            div.addEventListener('dragleave', handleDragLeave);
            div.addEventListener('drop', handleDrop);
            
            galeriPreview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
    
    photoCountSpan.textContent = `${selectedFiles.length}/${MAX_PHOTOS} foto`;
}

function handleDragStart(e) {
    draggedIndex = parseInt(e.target.closest('.gallery-item').dataset.index);
    e.target.closest('.gallery-item').classList.add('dragging');
    e.dataTransfer.effectAllowed = 'move';
}

function handleDragEnd(e) {
    e.target.closest('.gallery-item').classList.remove('dragging');
    document.querySelectorAll('.gallery-item').forEach(item => item.classList.remove('drag-over'));
    draggedIndex = null;
}

function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
}

function handleDragEnter(e) {
    e.preventDefault();
    const item = e.target.closest('.gallery-item');
    if (item && parseInt(item.dataset.index) !== draggedIndex) {
        item.classList.add('drag-over');
    }
}

function handleDragLeave(e) {
    const item = e.target.closest('.gallery-item');
    if (item) item.classList.remove('drag-over');
}

function handleDrop(e) {
    e.preventDefault();
    const targetItem = e.target.closest('.gallery-item');
    if (!targetItem) return;
    
    const targetIndex = parseInt(targetItem.dataset.index);
    if (draggedIndex === null || draggedIndex === targetIndex) return;
    
    // Reorder array
    const draggedFile = selectedFiles[draggedIndex];
    selectedFiles.splice(draggedIndex, 1);
    selectedFiles.splice(targetIndex, 0, draggedFile);
    
    updateFileInput();
    renderGalleryPreview();
    
    document.querySelectorAll('.gallery-item').forEach(item => item.classList.remove('drag-over'));
}

function removePhoto(index) {
    selectedFiles.splice(index, 1);
    updateFileInput();
    renderGalleryPreview();
}

// ========== EVENT LISTENERS ==========
document.addEventListener('DOMContentLoaded', function() {
    addVideoField();
    
    ['inputJudul', 'inputDeskripsi', 'inputLink', 'inputTglUpload', 'inputTglBerakhir'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', updatePreview);
    });
    
    document.getElementById('inputFoto')?.addEventListener('change', updatePreview);
    updatePreview();
    
    fileInput.addEventListener('change', (e) => handleFiles(e.target.files));
    
    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-blue-500', 'bg-blue-50'); });
    dropZone.addEventListener('dragleave', () => { dropZone.classList.remove('border-blue-500', 'bg-blue-50'); });
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        handleFiles(Array.from(e.dataTransfer.files));
    });
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(en => {
        document.body.addEventListener(en, (e) => { e.preventDefault(); e.stopPropagation(); });
    });
});
</script>
@endsection