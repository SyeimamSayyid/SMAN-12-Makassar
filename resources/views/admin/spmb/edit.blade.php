@extends('layouts.admin')

@section('title', 'Edit SPMB')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit SPMB</h1>
        <p class="text-gray-500 text-sm mt-1">Perbarui informasi Seleksi Penerimaan Murid Baru</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        
        {{-- FORM SECTION --}}
        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('admin.spmb.update', $spmb) }}" method="POST" enctype="multipart/form-data" id="spmbForm">
                @csrf @method('PUT')
                <div class="space-y-5">
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Judul <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" id="inputJudul" value="{{ old('judul', $spmb->judul) }}" required 
                               class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                        @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Deskripsi</label>
                        <textarea name="deskripsi" id="inputDeskripsi" rows="4" 
                                  class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">{{ old('deskripsi', $spmb->deskripsi) }}</textarea>
                        @error('deskripsi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Link Pendaftaran</label>
                        <input type="url" name="link_pendaftaran" id="inputLink" value="{{ old('link_pendaftaran', $spmb->link_pendaftaran) }}" 
                               class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500" 
                               placeholder="https://ppdb.sman12mks.sch.id">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Upload <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_upload" id="inputTglUpload" value="{{ old('tanggal_upload', $spmb->tanggal_upload->format('Y-m-d')) }}" required 
                                   class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Berakhir <span class="text-red-500">*</span></label>
                            <input type="date" name="tanggal_berakhir" id="inputTglBerakhir" value="{{ old('tanggal_berakhir', $spmb->tanggal_berakhir->format('Y-m-d')) }}" required 
                                   class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" id="inputIsActive" value="1" {{ old('is_active', $spmb->is_active) ? 'checked' : '' }} 
                                   class="w-4 h-4 text-blue-600 rounded">
                            <span class="ml-2 text-sm text-gray-700">Aktifkan SPMB ini</span>
                        </label>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Foto Utama</label>
                        @if($spmb->foto)
                            <img src="{{ asset('storage/' . $spmb->foto) }}" class="w-24 h-24 object-cover rounded-lg mb-2 border">
                        @endif
                        <input type="file" name="foto" id="inputFoto" accept="image/*" 
                               class="w-full border rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-blue-500">
                        <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengganti</p>
                    </div>

                    @if($spmb->video && count($spmb->video) > 0)
                    <div>
                        <label class="block text-sm font-medium mb-2">Video yang Sudah Ada</label>
                        <div class="space-y-2">
                            @foreach($spmb->video as $index => $video)
                            <div class="bg-gray-50 p-3 rounded-lg border">
                                <div class="flex justify-between">
                                    <div>
                                        <span class="inline-block px-2 py-0.5 text-xs rounded-full mb-1 {{ $video['type'] === 'youtube' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $video['type'] === 'youtube' ? '🎬 YouTube' : '📁 Upload' }}
                                        </span>
                                        <p class="text-sm truncate">{{ $video['url'] }}</p>
                                        @if(isset($video['caption']))<p class="text-xs text-gray-500">Caption: {{ $video['caption'] }}</p>@endif
                                    </div>
                                    <button type="button" onclick="deleteVideo({{ $index }})" class="text-red-500">✕</button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium mb-2">Tambah Video Baru 
                            <span class="text-gray-400 text-xs">(Maks {{ 5 - count($spmb->video ?? []) }} lagi)</span>
                        </label>
                        <div id="video-container"></div>
                        <button type="button" onclick="addVideoField()" class="mt-3 text-blue-600 text-sm flex items-center gap-1"
                                @if(count($spmb->video ?? []) >= 5) disabled style="opacity:0.5" @endif>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Video
                        </button>
                    </div>

                    {{-- GALERI DENGAN REORDER --}}
                    <div>
                        <label class="block text-sm font-medium mb-2">Galeri Foto 
                            <span class="text-gray-400 text-xs">(Total: <span id="totalPhotoCount">{{ count($spmb->galeri ?? []) }}</span>/15, drag untuk atur ulang)</span>
                        </label>
                        
                        {{-- Existing Photos (bisa di-reorder) --}}
                        @if($spmb->galeri && count($spmb->galeri) > 0)
                            <p class="text-xs text-gray-500 mb-2">📸 Foto existing (drag untuk atur ulang):</p>
                            <div class="grid grid-cols-5 gap-2 mb-3" id="existing-images">
                                @foreach($spmb->galeri as $index => $img)
                                    <div class="gallery-item-existing relative group" draggable="true" data-existing-index="{{ $index }}">
                                        <img src="{{ asset('storage/' . $img) }}" class="w-full aspect-square object-cover rounded-lg border">
                                        <button type="button" onclick="deleteExistingImage({{ $index }})" 
                                                class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs z-10">
                                            ×
                                        </button>
                                        <span class="absolute bottom-1 left-1 bg-black/60 text-white text-[10px] px-1.5 py-0.5 rounded-md">{{ $index + 1 }}</span>
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                            <span class="bg-black/50 text-white text-[10px] px-2 py-1 rounded-full">↕️ Drag</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="my-3 border-t"></div>
                        @endif
                        
                        {{-- New Photos Preview --}}
                        <div id="galeriPreview" class="grid grid-cols-5 gap-2 mb-3 min-h-[80px]"></div>
                        
                        {{-- Upload Area --}}
                        <div id="dropZone" class="relative border-2 border-dashed border-gray-300 rounded-xl p-6 hover:border-blue-400 hover:bg-blue-50/50 cursor-pointer transition">
                            <input type="file" name="galeri[]" id="inputGaleri" accept="image/*" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="text-center pointer-events-none">
                                <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-gray-600 text-sm"><span class="text-blue-600">Drag & drop</span> atau klik</p>
                                <p class="text-xs text-gray-400">Sisa <span id="remainingSlots">{{ 15 - count($spmb->galeri ?? []) }}</span> slot</p>
                            </div>
                        </div>
                        
                        <div class="mt-2 flex justify-between text-xs">
                            <span id="photoCount" class="text-gray-500">0 foto baru</span>
                            <span class="text-gray-400 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4"></path></svg>Drag untuk atur ulang</span>
                            <span id="photoSizeWarning" class="text-orange-500 hidden">⚠️ >2MB</span>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-4 border-t">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg">Simpan</button>
                        <a href="{{ route('admin.spmb.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg">Batal</a>
                    </div>
                </div>
            </form>
        </div>

        {{-- PREVIEW CARD --}}
        <div class="lg:sticky lg:top-24 h-fit">
            <div class="bg-white rounded-xl shadow p-4">
                <div class="flex items-center justify-between mb-4 pb-2 border-b">
                    <h3 class="font-semibold text-gray-700 flex items-center gap-2"><svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>Preview</h3>
                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Live</span>
                </div>
                
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border">
                    <div class="relative aspect-[4/3] overflow-hidden bg-gradient-to-br from-blue-100 to-indigo-100">
                        <img id="previewFoto" src="{{ $spmb->foto ? asset('storage/' . $spmb->foto) : asset('images/default-spmb.jpg') }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        <div class="absolute top-3 left-3">
                            @php $status = $spmb->status; @endphp
                            <span id="previewStatus" class="px-2.5 py-1 {{ $status[0] }} rounded-full text-xs shadow-md">{{ $status[1] }}</span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span id="previewTanggal" class="bg-white/90 text-gray-700 px-2.5 py-1 rounded-full text-xs shadow-md flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span id="previewTanggalText">{{ $spmb->tanggal_upload->format('d M Y') }}</span>
                            </span>
                        </div>
                        <div class="absolute bottom-3 left-3 right-16">
                            <h4 id="previewJudul" class="text-white font-bold text-base drop-shadow-lg line-clamp-2">{{ $spmb->judul }}</h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <p id="previewDeskripsi" class="text-gray-600 text-sm line-clamp-3 mb-3">{{ $spmb->deskripsi ?? 'Deskripsi...' }}</p>
                        <div id="previewLinkContainer" class="mb-3 {{ $spmb->link_pendaftaran ? '' : 'hidden' }}">
                            <span class="inline-flex items-center gap-1 text-sm text-green-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>Daftar Sekarang</span>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 pt-3 border-t">
                            <span id="previewTglBerakhir" class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Berakhir: {{ $spmb->tanggal_berakhir->format('d M Y') }}</span>
                            <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>{{ $spmb->views }} views</span>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2 text-center"><span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse inline-block mr-1"></span>Preview otomatis</p>
            </div>
        </div>
    </div>
</div>

<style>
.line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
#dropZone { transition: all 0.2s; }
#dropZone.border-blue-500 { border-color: #3b82f6 !important; background-color: #eff6ff !important; }
.gallery-item-new, .gallery-item-existing { cursor: grab; transition: all 0.2s; }
.gallery-item-new:active, .gallery-item-existing:active { cursor: grabbing; opacity: 0.7; }
.gallery-item-new.dragging, .gallery-item-existing.dragging { opacity: 0.5; transform: scale(0.95); }
.gallery-item-new.drag-over, .gallery-item-existing.drag-over { border: 2px solid #3b82f6; transform: scale(1.02); }
</style>

<script>
let videoCount = 0;
const MAX_VIDEOS = 5;
const existingVideoCount = {{ count($spmb->video ?? []) }};
let newSelectedFiles = [];
const existingPhotoCount = {{ count($spmb->galeri ?? []) }};
const MAX_PHOTOS = 15;
const MAX_SIZE = 2 * 1024 * 1024;
let draggedIndex = null;
let draggedType = null;

// ========== PREVIEW ==========
function updatePreview() {
    const judul = document.getElementById('inputJudul').value;
    if (judul) document.getElementById('previewJudul').textContent = judul;
    document.getElementById('previewDeskripsi').textContent = document.getElementById('inputDeskripsi').value || 'Deskripsi...';
    
    const tglUpload = document.getElementById('inputTglUpload').value;
    if (tglUpload) {
        const d = new Date(tglUpload);
        document.getElementById('previewTanggalText').textContent = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    }
    
    const tglBerakhir = document.getElementById('inputTglBerakhir').value;
    if (tglBerakhir) {
        const d = new Date(tglBerakhir);
        document.getElementById('previewTglBerakhir').innerHTML = `<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Berakhir: ${d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}`;
    }
    
    const link = document.getElementById('inputLink').value;
    document.getElementById('previewLinkContainer').classList.toggle('hidden', !link);
    
    const isActive = document.getElementById('inputIsActive')?.checked;
    const statusSpan = document.getElementById('previewStatus');
    if (statusSpan && isActive !== undefined) {
        statusSpan.className = isActive ? 'px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs shadow-md' : 'px-2.5 py-1 bg-gray-100 text-gray-700 rounded-full text-xs shadow-md';
        statusSpan.textContent = isActive ? '✅ Aktif' : '⏸️ Nonaktif';
    }
    
    const foto = document.getElementById('inputFoto');
    if (foto.files[0]) {
        const r = new FileReader();
        r.onload = e => document.getElementById('previewFoto').src = e.target.result;
        r.readAsDataURL(foto.files[0]);
    }
}

// ========== VIDEO ==========
function addVideoField() {
    if (videoCount + existingVideoCount >= MAX_VIDEOS) { alert('Maks 5 video!'); return; }
    const c = document.getElementById('video-container');
    const i = videoCount;
    const d = document.createElement('div');
    d.className = 'bg-gray-50 p-4 rounded-lg mb-3 border';
    d.id = `video-field-${i}`;
    d.innerHTML = `<div class="flex justify-between mb-3"><span>Video Baru ${i+1}</span><button type="button" onclick="removeVideoField(${i})" class="text-red-500">✕</button></div>
        <div class="mb-3"><label class="block text-sm mb-1">Tipe</label><select name="video_type[]" onchange="toggleVideoInput(this,${i})" class="w-full border rounded px-3 py-2"><option value="youtube">🎬 YouTube</option><option value="upload">📁 Upload</option></select></div>
        <div class="youtube-input-${i}"><label class="block text-sm mb-1">URL</label><input type="text" name="video_url[]" placeholder="https://..." class="w-full border rounded px-4 py-2"></div>
        <div class="upload-input-${i} hidden"><label class="block text-sm mb-1">File</label><input type="file" name="video_file[]" accept="video/*" class="w-full border rounded px-4 py-2"><p class="text-xs text-gray-400 mt-1">Maks 50MB</p></div>
        <div class="mt-3"><label class="block text-sm mb-1">Caption</label><input type="text" name="video_caption[]" class="w-full border rounded px-4 py-2"></div>`;
    c.appendChild(d);
    videoCount++;
}
function removeVideoField(i) { document.getElementById(`video-field-${i}`)?.remove(); videoCount--; reindexVideoFields(); }
function toggleVideoInput(s, i) {
    document.querySelector(`.youtube-input-${i}`).classList.toggle('hidden', s.value !== 'youtube');
    document.querySelector(`.upload-input-${i}`).classList.toggle('hidden', s.value === 'youtube');
}
function reindexVideoFields() {
    const fs = document.querySelectorAll('#video-container > div');
    videoCount = fs.length;
    fs.forEach((f, idx) => {
        f.id = `video-field-${idx}`;
        f.querySelector('span').textContent = `Video Baru ${idx+1}`;
        f.querySelector('button').setAttribute('onclick', `removeVideoField(${idx})`);
        const s = f.querySelector('select'); s.setAttribute('onchange', `toggleVideoInput(this,${idx})`);
        f.querySelector('[class*="youtube-input-"]').className = `youtube-input-${idx}`;
        f.querySelector('[class*="upload-input-"]').className = `upload-input-${idx} ${f.querySelector('[class*="upload-input-"]').classList.contains('hidden') ? 'hidden' : ''}`;
    });
}
function deleteVideo(i) {
    if (!confirm('Hapus?')) return;
    fetch('{{ route("admin.spmb.delete-video", $spmb) }}', { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body:JSON.stringify({index:i}) })
    .then(r => r.json()).then(d => { if(d.success) location.reload(); });
}

// ========== GALERI ==========
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('inputGaleri');
const galeriPreview = document.getElementById('galeriPreview');
const photoCountSpan = document.getElementById('photoCount');
const photoSizeWarning = document.getElementById('photoSizeWarning');
const remainingSlotsSpan = document.getElementById('remainingSlots');
const totalPhotoCountSpan = document.getElementById('totalPhotoCount');

function updateCounters() {
    const total = existingPhotoCount + newSelectedFiles.length;
    if (remainingSlotsSpan) remainingSlotsSpan.textContent = MAX_PHOTOS - total;
    if (totalPhotoCountSpan) totalPhotoCountSpan.textContent = total;
    photoCountSpan.textContent = `${newSelectedFiles.length} foto baru`;
}

function handleFiles(files) {
    let hasOversize = false;
    const valid = [];
    const remaining = MAX_PHOTOS - (existingPhotoCount + newSelectedFiles.length);
    if (remaining <= 0) { alert(`Maks ${MAX_PHOTOS}!`); return; }
    for (let f of files) {
        if (!f.type.startsWith('image/')) continue;
        if (f.size > MAX_SIZE) { hasOversize = true; continue; }
        if (valid.length >= remaining) { alert(`Sisa ${remaining} slot!`); break; }
        valid.push(f);
    }
    if (hasOversize) { photoSizeWarning.classList.remove('hidden'); setTimeout(() => photoSizeWarning.classList.add('hidden'), 3000); }
    newSelectedFiles = [...newSelectedFiles, ...valid];
    updateFileInput();
    renderGalleryPreview();
    updateCounters();
}

function updateFileInput() {
    const dt = new DataTransfer();
    newSelectedFiles.forEach(f => dt.items.add(f));
    fileInput.files = dt.files;
}

function renderGalleryPreview() {
    galeriPreview.innerHTML = '';
    if (newSelectedFiles.length === 0) { galeriPreview.innerHTML = '<p class="col-span-5 text-center text-xs text-gray-400 py-2">Belum ada foto baru</p>'; return; }
    newSelectedFiles.forEach((f, i) => {
        const r = new FileReader();
        r.onload = e => {
            const div = document.createElement('div');
            div.className = 'gallery-item-new relative group';
            div.draggable = true;
            div.dataset.newIndex = i;
            div.innerHTML = `<img src="${e.target.result}" class="w-full aspect-square object-cover rounded-lg border border-green-300">
                <button type="button" onclick="removeNewPhoto(${i})" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs z-10">×</button>
                <span class="absolute bottom-1 left-1 bg-green-600 text-white text-[10px] px-1.5 py-0.5 rounded-md">Baru</span>
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100"><span class="bg-black/50 text-white text-[10px] px-2 py-1 rounded-full">↕️ Drag</span></div>`;
            div.addEventListener('dragstart', e => { draggedIndex = i; draggedType = 'new'; e.target.closest('.gallery-item-new').classList.add('dragging'); });
            div.addEventListener('dragend', e => { document.querySelectorAll('.gallery-item-new').forEach(el => el.classList.remove('dragging', 'drag-over')); draggedIndex = null; });
            div.addEventListener('dragover', e => e.preventDefault());
            div.addEventListener('dragenter', e => { e.preventDefault(); const el = e.target.closest('.gallery-item-new'); if (el && parseInt(el.dataset.newIndex) !== draggedIndex) el.classList.add('drag-over'); });
            div.addEventListener('dragleave', e => e.target.closest('.gallery-item-new')?.classList.remove('drag-over'));
            div.addEventListener('drop', e => {
                e.preventDefault();
                const target = e.target.closest('.gallery-item-new');
                if (!target || draggedType !== 'new') return;
                const targetIdx = parseInt(target.dataset.newIndex);
                if (draggedIndex !== null && draggedIndex !== targetIdx) {
                    const [moved] = newSelectedFiles.splice(draggedIndex, 1);
                    newSelectedFiles.splice(targetIdx, 0, moved);
                    updateFileInput(); renderGalleryPreview();
                }
                document.querySelectorAll('.gallery-item-new').forEach(el => el.classList.remove('drag-over'));
            });
            galeriPreview.appendChild(div);
        };
        r.readAsDataURL(f);
    });
}

function removeNewPhoto(i) { newSelectedFiles.splice(i, 1); updateFileInput(); renderGalleryPreview(); updateCounters(); }

function deleteExistingImage(i) {
    if (!confirm('Hapus?')) return;
    fetch('{{ route("admin.spmb.delete-image", $spmb) }}', { method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body:JSON.stringify({index:i}) })
    .then(r => r.json()).then(d => { if(d.success) location.reload(); });
}

// Reorder Existing Photos
function initExistingReorder() {
    document.querySelectorAll('.gallery-item-existing').forEach(el => {
        el.addEventListener('dragstart', e => { draggedIndex = parseInt(el.dataset.existingIndex); draggedType = 'existing'; el.classList.add('dragging'); });
        el.addEventListener('dragend', () => { document.querySelectorAll('.gallery-item-existing').forEach(e => e.classList.remove('dragging', 'drag-over')); });
        el.addEventListener('dragover', e => e.preventDefault());
        el.addEventListener('dragenter', e => { e.preventDefault(); const target = e.target.closest('.gallery-item-existing'); if (target && parseInt(target.dataset.existingIndex) !== draggedIndex) target.classList.add('drag-over'); });
        el.addEventListener('dragleave', e => e.target.closest('.gallery-item-existing')?.classList.remove('drag-over'));
        el.addEventListener('drop', e => {
            e.preventDefault();
            const target = e.target.closest('.gallery-item-existing');
            if (!target || draggedType !== 'existing') return;
            const from = draggedIndex;
            const to = parseInt(target.dataset.existingIndex);
            if (from !== null && from !== to) {
                fetch('{{ route("admin.spmb.reorder-images", $spmb) }}', {
                    method: 'POST',
                    headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
                    body: JSON.stringify({from, to})
                }).then(r => r.json()).then(d => { if(d.success) location.reload(); });
            }
            document.querySelectorAll('.gallery-item-existing').forEach(e => e.classList.remove('drag-over'));
        });
    });
}

// ========== INIT ==========
document.addEventListener('DOMContentLoaded', () => {
    ['inputJudul','inputDeskripsi','inputLink','inputTglUpload','inputTglBerakhir'].forEach(id => document.getElementById(id)?.addEventListener('input', updatePreview));
    document.getElementById('inputFoto')?.addEventListener('change', updatePreview);
    document.getElementById('inputIsActive')?.addEventListener('change', updatePreview);
    updatePreview(); updateCounters(); initExistingReorder();
    
    fileInput?.addEventListener('change', e => handleFiles(e.target.files));
    dropZone?.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-blue-500','bg-blue-50'); });
    dropZone?.addEventListener('dragleave', () => dropZone.classList.remove('border-blue-500','bg-blue-50'));
    dropZone?.addEventListener('drop', e => { e.preventDefault(); dropZone.classList.remove('border-blue-500','bg-blue-50'); handleFiles(Array.from(e.dataTransfer.files)); });
    ['dragenter','dragover','dragleave','drop'].forEach(en => document.body.addEventListener(en, e => { e.preventDefault(); e.stopPropagation(); }));
});
</script>
@endsection