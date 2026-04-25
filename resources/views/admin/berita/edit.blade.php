@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-8 rounded-3xl shadow-lg relative">
    <!-- Success Notification -->
    @if(session('success'))
    <div class="mb-6 animate-slideDown">
        <div class="card">
            <svg class="wave" viewBox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0,256L11.4,240C22.9,224,46,192,69,192C91.4,192,114,224,137,234.7C160,245,183,235,206,213.3C228.6,192,251,160,274,149.3C297.1,139,320,149,343,181.3C365.7,213,389,267,411,282.7C434.3,299,457,277,480,250.7C502.9,224,526,192,549,181.3C571.4,171,594,181,617,208C640,235,663,277,686,256C708.6,235,731,149,754,122.7C777.1,96,800,128,823,165.3C845.7,203,869,245,891,224C914.3,203,937,117,960,112C982.9,107,1006,181,1029,197.3C1051.4,213,1074,171,1097,144C1120,117,1143,107,1166,133.3C1188.6,160,1211,224,1234,218.7C1257.1,213,1280,139,1303,133.3C1325.7,128,1349,192,1371,192C1394.3,192,1417,128,1429,96L1440,64L1440,320L1428.6,320C1417.1,320,1394,320,1371,320C1348.6,320,1326,320,1303,320C1280,320,1257,320,1234,320C1211.4,320,1189,320,1166,320C1142.9,320,1120,320,1097,320C1074.3,320,1051,320,1029,320C1005.7,320,983,320,960,320C937.1,320,914,320,891,320C868.6,320,846,320,823,320C800,320,777,320,754,320C731.4,320,709,320,686,320C662.9,320,640,320,617,320C594.3,320,571,320,549,320C525.7,320,503,320,480,320C457.1,320,434,320,411,320C388.6,320,366,320,343,320C320,320,297,320,274,320C251.4,320,229,320,206,320C182.9,320,160,320,137,320C114.3,320,91,320,69,320C45.7,320,23,320,11,320L0,320Z"
                    fill-opacity="1"
                ></path>
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

    <!-- Error Notifications -->
    @if($errors->any())
    <div class="mb-6">
        @foreach($errors->all() as $error)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-2 rounded-lg shadow-md animate-slideDown">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
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

    <!-- Header dengan Judul dan Tombol Kembali -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
            </svg>
            Edit Berita
        </h1>

        <a href="{{ route('admin.dashboard') }}" 
           class="group flex items-center gap-2 bg-gradient-to-r from-gray-600 to-gray-700 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-x-1">
            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Form Input -->
        <div class="space-y-6">
            <form action="{{ route('admin.berita.update', $berita->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="beritaForm"
                  oninput="updatePreview()">

                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- Judul --}}
                    <div class="space-y-2">
                        <label class="block font-semibold text-gray-700">
                            Judul Berita <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="judul"
                               id="judul"
                               value="{{ old('judul', $berita->judul) }}"
                               required
                               class="w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>

                    {{-- Tanggal --}}
                    <div class="space-y-2">
                        <label class="block font-semibold text-gray-700">
                            Tanggal Upload <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="tanggal"
                               id="tanggal"
                               value="{{ old('tanggal', $berita->tanggal instanceof \DateTime ? $berita->tanggal->format('Y-m-d') : $berita->tanggal) }}"
                               required
                               class="w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>

                {{-- Author --}}
                <div class="space-y-2 mt-6">
                    <label class="block font-semibold text-gray-700">
                        Diunggah Oleh <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="author"
                           id="author"
                           value="{{ old('author', $berita->author) }}"
                           required
                           class="w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                {{-- Isi --}}
                <div class="space-y-2 mt-6">
                    <label class="block font-semibold text-gray-700">
                        Isi Berita <span class="text-red-500">*</span>
                    </label>
                    <textarea name="isi"
                              id="isi"
                              rows="8"
                              required
                              class="w-full border-2 border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition resize-y">{{ old('isi', $berita->isi) }}</textarea>
                </div>

                {{-- Existing Photos --}}
                @php
                    $existingImages = is_array($berita->images) ? $berita->images : (json_decode($berita->images, true) ?? []);
                @endphp
                
                @if(count($existingImages) > 0)
                <div class="space-y-4 mt-6">
                    <label class="block font-semibold text-gray-700">
                        Foto Saat Ini ({{ count($existingImages) }}/5)
                    </label>
                    <div id="existingImagesContainer" class="grid grid-cols-3 gap-3">
                        @foreach($existingImages as $index => $image)
                        <div class="relative group existing-image-item" data-image="{{ $image }}">
                            <img src="{{ $image }}" 
                                 alt="Foto berita" 
                                 class="w-full h-24 object-cover rounded-lg border-2 border-gray-200">
                            <button type="button" 
                                    class="delete-existing-btn absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600"
                                    data-image="{{ $image }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Upload Foto Baru --}}
                <div class="space-y-4 mt-6">
                    <label class="block font-semibold text-gray-700">
                        Tambah Foto Baru (Maksimal 5 foto total)
                    </label>

                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition group">
                        <input type="file"
                               name="images[]"
                               id="fileInput"
                               multiple
                               accept="image/*"
                               class="hidden"
                               onchange="previewNewImages(this); updatePreview()">

                        <label for="fileInput" class="cursor-pointer">
                            <svg class="w-12 h-12 mx-auto text-gray-400 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 group-hover:text-blue-600">
                                Klik untuk pilih foto baru
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Format: JPG, PNG, GIF (Maksimal 5MB per foto)
                            </p>
                        </label>
                    </div>
                    
                    <!-- Preview Foto Baru -->
                    <div id="newImagesPreview" class="grid grid-cols-3 gap-3 mt-4"></div>
                </div>

                {{-- Upload Progress --}}
                <div id="uploadProgress" class="mt-4 hidden">
                    <div class="flex items-center">
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="uploadProgressBar" class="bg-blue-500 h-2 rounded-full" style="width: 0%"></div>
                            </div>
                        </div>
                        <span id="uploadPercent" class="ml-2 text-sm text-gray-600">0%</span>
                    </div>
                    <p id="uploadStatus" class="text-xs text-gray-500 mt-1">Mengupload foto...</p>
                </div>

                {{-- Submit Button --}}
                <div class="flex items-center gap-4 pt-6">
                    <button type="submit"
                            id="submitBtn"
                            class="bg-blue-600 text-white px-8 py-3 rounded-xl font-semibold hover:bg-blue-700 transition transform hover:scale-105 flex items-center gap-2 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Update Berita
                    </button>
                    
                    <a href="{{ route('admin.berita.index') }}"
                       class="bg-gray-500 text-white px-8 py-3 rounded-xl font-semibold hover:bg-gray-600 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Newspaper Preview Card -->
        <div class="lg:sticky lg:top-4 h-fit">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    Koran Preview
                </h2>
                
                <button onclick="togglePreview()" id="eyeToggle" class="group relative">
                    <div class="absolute inset-0 bg-blue-100 rounded-full blur group-hover:blur-md transition-all opacity-0 group-hover:opacity-100"></div>
                    <svg id="eyeOpen" class="w-8 h-8 text-blue-600 cursor-pointer relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="eyeClosed" class="w-8 h-8 text-gray-400 cursor-pointer relative z-10 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                    </svg>
                </button>
            </div>

            <div id="newspaperCard" class="newspaper-card">
                <div class="newspaper-header">
                    <div class="flex items-center justify-between border-b-2 border-dashed border-gray-300 pb-2">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9"></path>
                            </svg>
                            <span class="text-sm font-bold text-gray-700 tracking-widest">THE DAILY NEWS</span>
                        </div>
                        <span class="text-xs text-gray-500">Edisi: <span id="newspaperDate">{{ $berita->tanggal instanceof \DateTime ? $berita->tanggal->format('d M Y') : date('d M Y', strtotime($berita->tanggal)) }}</span></span>
                    </div>
                </div>

                <div id="previewContent" class="preview-content">
                    <div class="newspaper-image-container">
                        <div id="mainImagePreview" class="w-full h-56 bg-gray-100 flex items-center justify-center newspaper-image">
                            @if(count($existingImages) > 0)
                                <img src="{{ $existingImages[0] }}" class="w-full h-full object-cover">
                            @else
                                <div class="text-center text-gray-400">
                                    <svg class="w-16 h-16 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-sm">Foto utama akan tampil di sini</p>
                                </div>
                            @endif
                        </div>
                        <div class="newspaper-image-caption">Foto Utama - Dokumentasi</div>
                    </div>

                    <div class="p-6">
                        <div class="newspaper-headline">
                            <h3 id="previewJudul" class="font-black text-3xl mb-3 leading-tight">
                                {{ $berita->judul }}
                            </h3>
                        </div>

                        <div class="newspaper-byline flex items-center gap-4 mb-4 text-sm border-b border-gray-200 pb-3">
                            <span id="previewAuthor" class="flex items-center gap-1 font-semibold text-gray-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Oleh: <span class="font-normal">{{ $berita->author }}</span>
                            </span>
                            <span class="text-gray-400">|</span>
                            <span id="previewTanggal" class="text-gray-500 text-xs italic">
                                {{ $berita->tanggal instanceof \DateTime ? $berita->tanggal->format('d M Y') : date('d M Y', strtotime($berita->tanggal)) }}
                            </span>
                        </div>

                        <div id="previewDeskripsi" class="newspaper-content text-gray-700 leading-relaxed text-justify">
                            {!! nl2br(e($berita->isi)) !!}
                        </div>

                        <div class="mt-6">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <p class="text-xs font-bold text-gray-600 tracking-wider">GALERI FOTO</p>
                            </div>
                            <div id="previewThumbnails" class="newspaper-gallery grid grid-cols-5 gap-2">
                                @foreach($existingImages as $index => $image)
                                <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}" onclick="setMainImageFromExisting({{ $index }})">
                                    <img src="{{ $image }}" alt="Thumbnail {{ $index + 1 }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="newspaper-footer border-t-2 border-dashed border-gray-300 mt-2 pt-2 px-6 pb-4">
                    <div class="flex justify-between items-center text-[10px] text-gray-400 uppercase tracking-wider">
                        <span>Halaman 1</span>
                        <span>Koran Digital • {{ date('Y') }}</span>
                        <span>Eksklusif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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

.message-text,
.sub-text {
    margin: 0;
    cursor: default;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    width: 100%;
}

.message-text {
    color: #269b24;
    font-size: 17px;
    font-weight: 700;
}

.sub-text {
    font-size: 14px;
    color: #555;
}

.cross-icon {
    width: 18px;
    height: 18px;
    color: #555;
    cursor: pointer;
    flex-shrink: 0;
    transition: color 0.3s;
}

.cross-icon:hover {
    color: #ff4444;
}

.newspaper-card {
    background: #fffdf8;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1), 0 0 0 1px rgba(0,0,0,0.05);
    overflow: hidden;
    transition: all 0.3s ease;
    position: relative;
}

.newspaper-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6, #ec4899);
}

.newspaper-header {
    padding: 16px 24px 8px;
    background: #faf7f0;
}

.newspaper-image-container {
    position: relative;
    margin: 0 24px;
}

.newspaper-image {
    border: 1px solid #e5e7eb;
    box-shadow: 0 4px 6px -2px rgba(0,0,0,0.05);
    border-radius: 8px;
    overflow: hidden;
}

.newspaper-image-caption {
    text-align: center;
    font-size: 11px;
    color: #6b7280;
    margin-top: 4px;
    font-style: italic;
}

.newspaper-headline h3 {
    font-family: 'Times New Roman', serif;
    color: #1f2937;
    text-shadow: 1px 1px 0 rgba(0,0,0,0.05);
}

.newspaper-byline {
    font-family: 'Courier New', monospace;
}

.newspaper-content {
    font-family: 'Georgia', serif;
    line-height: 1.8;
    color: #374151;
}

.newspaper-gallery {
    padding: 8px;
    background: #f3f4f6;
    border-radius: 8px;
}

.preview-content {
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.preview-content.collapsed {
    max-height: 300px;
    opacity: 0.7;
    filter: blur(0.5px);
}

.preview-content.collapsed .newspaper-image-container {
    opacity: 0.5;
}

.preview-content.collapsed .newspaper-headline h3 {
    font-size: 1.5rem;
}

.thumbnail-item {
    aspect-ratio: 1/1;
    border-radius: 0.5rem;
    overflow: hidden;
    border: 2px solid white;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    cursor: pointer;
}

.thumbnail-item:hover {
    transform: scale(1.1) rotate(2deg);
    z-index: 10;
    border-color: #3b82f6;
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail-item.active {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
}

.existing-image-item {
    position: relative;
}

.delete-existing-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slideDown {
    animation: slideDown 0.5s ease-out;
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let newImageFiles = [];
let deletedImages = [];
let autoSaveTimer;
let beritaId = {{ $berita->id }};
let existingImages = @json($existingImages);

// Show notification
function showNotification(message, type = 'info') {
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500'
    };
    
    const notification = $('<div>')
        .addClass(`fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-opacity duration-300`)
        .text(message);
    
    $('body').append(notification);
    
    setTimeout(() => {
        notification.fadeOut(300, function() {
            $(this).remove();
        });
    }, 3000);
}

// Delete existing image
function deleteExistingImage(button, imagePath) {
    if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
        deletedImages.push(imagePath);
        $(button).closest('.existing-image-item').fadeOut(300, function() {
            $(this).remove();
            
            // Update hidden input for deleted images
            updateDeletedImagesInput();
            
            // Update preview
            updatePreview();
            showNotification('Foto akan dihapus saat update', 'info');
        });
    }
}

function updateDeletedImagesInput() {
    let existingInput = $('input[name="deleted_images[]"]');
    existingInput.remove();
    
    deletedImages.forEach(path => {
        $('<input>').attr({
            type: 'hidden',
            name: 'deleted_images[]',
            value: path
        }).appendTo('#beritaForm');
    });
}

// Preview new images
function previewNewImages(input) {
    if (input.files) {
        const totalExisting = $('#existingImagesContainer .existing-image-item').length;
        const totalNew = input.files.length;
        
        if (totalExisting + totalNew > 5) {
            alert('Maksimal 5 foto total!');
            input.value = '';
            return;
        }
        
        newImageFiles = Array.from(input.files);
        
        const previewContainer = document.getElementById('newImagesPreview');
        previewContainer.innerHTML = '';
        
        newImageFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-gray-200">
                    <button type="button" class="remove-new-image absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                previewContainer.appendChild(div);
                
                $(div).find('.remove-new-image').on('click', function() {
                    div.remove();
                    newImageFiles = newImageFiles.filter((_, i) => i !== index);
                    updateNewImagesInput();
                    updatePreview();
                });
            };
            reader.readAsDataURL(file);
        });
        
        updateNewImagesInput();
        updatePreview();
    }
}

function updateNewImagesInput() {
    let existingInput = $('input[name="new_images_data[]"]');
    existingInput.remove();
    
    newImageFiles.forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('<input>').attr({
                type: 'hidden',
                name: 'new_images_data[]',
                value: e.target.result
            }).appendTo('#beritaForm');
        };
        reader.readAsDataURL(file);
    });
}

// Update preview
function updatePreview() {
    // Update judul
    const judul = document.getElementById('judul').value;
    document.getElementById('previewJudul').textContent = judul || 'Judul Berita';
    
    // Update tanggal
    const tanggal = document.getElementById('tanggal').value;
    if (tanggal) {
        const options = { day: 'numeric', month: 'long', year: 'numeric' };
        const date = new Date(tanggal + 'T00:00:00');
        document.getElementById('previewTanggal').textContent = date.toLocaleDateString('id-ID', options);
        document.getElementById('newspaperDate').textContent = date.toLocaleDateString('id-ID', options);
    }
    
    // Update author
    const author = document.getElementById('author').value;
    document.getElementById('previewAuthor').innerHTML = `
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
        Oleh: <span class="font-normal">${author || 'Author'}</span>
    `;
    
    // Update isi
    const isi = document.getElementById('isi').value;
    const previewDeskripsi = document.getElementById('previewDeskripsi');
    if (isi) {
        previewDeskripsi.innerHTML = isi.split('\n').filter(p => p.trim() !== '').map(p => `<p class="mb-4 last:mb-0">${p}</p>`).join('');
    }
    
    // Update main image
    const allImages = [...existingImages.filter(img => !deletedImages.includes(img)), ...newImageFiles];
    if (allImages.length > 0) {
        const mainPreview = document.getElementById('mainImagePreview');
        if (allImages[0] instanceof File) {
            const reader = new FileReader();
            reader.onload = function(e) {
                mainPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
            };
            reader.readAsDataURL(allImages[0]);
        } else {
            mainPreview.innerHTML = `<img src="${allImages[0]}" class="w-full h-full object-cover">`;
        }
    }
    
    // Update thumbnails
    const thumbnailsContainer = document.getElementById('previewThumbnails');
    thumbnailsContainer.innerHTML = '';
    allImages.forEach((image, index) => {
        const thumbnail = document.createElement('div');
        thumbnail.className = `thumbnail-item ${index === 0 ? 'active' : ''}`;
        if (image instanceof File) {
            const reader = new FileReader();
            reader.onload = function(e) {
                thumbnail.innerHTML = `<img src="${e.target.result}" alt="Thumbnail ${index + 1}">`;
            };
            reader.readAsDataURL(image);
        } else {
            thumbnail.innerHTML = `<img src="${image}" alt="Thumbnail ${index + 1}">`;
        }
        thumbnail.setAttribute('onclick', `setMainImageFromPreview(${index})`);
        thumbnailsContainer.appendChild(thumbnail);
    });
}

function setMainImageFromPreview(index) {
    const allImages = [...existingImages.filter(img => !deletedImages.includes(img)), ...newImageFiles];
    const mainPreview = document.getElementById('mainImagePreview');
    
    if (allImages[index] instanceof File) {
        const reader = new FileReader();
        reader.onload = function(e) {
            mainPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(allImages[index]);
    } else {
        mainPreview.innerHTML = `<img src="${allImages[index]}" class="w-full h-full object-cover">`;
    }
    
    document.querySelectorAll('.thumbnail-item').forEach((thumb, i) => {
        if (i === index) {
            thumb.classList.add('active');
        } else {
            thumb.classList.remove('active');
        }
    });
}

function setMainImageFromExisting(index) {
    const mainPreview = document.getElementById('mainImagePreview');
    const notDeletedImages = existingImages.filter(img => !deletedImages.includes(img));
    if (notDeletedImages[index]) {
        mainPreview.innerHTML = `<img src="${notDeletedImages[index]}" class="w-full h-full object-cover">`;
        
        document.querySelectorAll('.thumbnail-item').forEach((thumb, i) => {
            if (i === index) {
                thumb.classList.add('active');
            } else {
                thumb.classList.remove('active');
            }
        });
    }
}

// Auto-save draft
function autoSave() {
    $.ajax({
        url: '{{ route("admin.berita.auto-save") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            berita_id: beritaId,
            judul: $('#judul').val(),
            tanggal: $('#tanggal').val(),
            isi: $('#isi').val(),
            author: $('#author').val()
        },
        success: function(response) {
            if (response.success) {
                console.log('Auto-save successful at', new Date().toLocaleTimeString());
            }
        },
        error: function(xhr) {
            console.error('Auto-save failed:', xhr);
        }
    });
}

// Start auto-save timer
function startAutoSave() {
    if (autoSaveTimer) clearInterval(autoSaveTimer);
    autoSaveTimer = setInterval(autoSave, 30000);
}

// Toggle preview collapse
let isPreviewExpanded = true;

function togglePreview() {
    const content = document.getElementById('previewContent');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeClosed = document.getElementById('eyeClosed');
    
    if (isPreviewExpanded) {
        content.classList.add('collapsed');
        eyeOpen.classList.add('hidden');
        eyeClosed.classList.remove('hidden');
    } else {
        content.classList.remove('collapsed');
        eyeOpen.classList.remove('hidden');
        eyeClosed.classList.add('hidden');
    }
    
    isPreviewExpanded = !isPreviewExpanded;
}

// Form submit with validation
$('#beritaForm').on('submit', function(e) {
    const totalExisting = $('#existingImagesContainer .existing-image-item').length;
    const totalNew = newImageFiles.length;
    const totalAfterDelete = existingImages.filter(img => !deletedImages.includes(img)).length;
    const finalTotal = totalAfterDelete + totalNew;
    
    if (finalTotal === 0) {
        e.preventDefault();
        alert('Minimal 1 foto harus diupload!');
        return false;
    }
    
    if (finalTotal > 5) {
        e.preventDefault();
        alert('Maksimal 5 foto!');
        return false;
    }
    
    $('#submitBtn').prop('disabled', true).html('<svg class="inline w-5 h-5 animate-spin mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Menyimpan...');
    
    updateDeletedImagesInput();
    updateNewImagesInput();
    
    return true;
});

// Delete existing image event
$(document).on('click', '.delete-existing-btn', function() {
    deleteExistingImage(this, $(this).data('image'));
});

// Initialize
$(document).ready(function() {
    startAutoSave();
    updatePreview();
    
    // Save to localStorage for draft recovery
    setInterval(function() {
        const draft = {
            judul: $('#judul').val(),
            tanggal: $('#tanggal').val(),
            isi: $('#isi').val(),
            author: $('#author').val(),
            timestamp: new Date().getTime()
        };
        localStorage.setItem('berita_edit_draft', JSON.stringify(draft));
    }, 10000);
    
    // Check for saved draft
    const savedDraft = localStorage.getItem('berita_edit_draft');
    if (savedDraft) {
        const draft = JSON.parse(savedDraft);
        const now = new Date().getTime();
        if (now - draft.timestamp < 3600000) {
            if (confirm('Ada draft yang belum tersimpan. Apakah Anda ingin memuatnya?')) {
                if (draft.judul) $('#judul').val(draft.judul);
                if (draft.tanggal) $('#tanggal').val(draft.tanggal);
                if (draft.isi) $('#isi').val(draft.isi);
                if (draft.author) $('#author').val(draft.author);
                updatePreview();
                showNotification('Draft berhasil dimuat', 'success');
            }
        }
        localStorage.removeItem('berita_edit_draft');
    }
    
    // Auto-hide success notification
    const successCard = document.querySelector('.card');
    if (successCard) {
        setTimeout(() => {
            successCard.style.transition = 'opacity 0.5s';
            successCard.style.opacity = '0';
            setTimeout(() => {
                successCard.remove();
            }, 500);
        }, 5000);
    }
});
</script>
@endsection