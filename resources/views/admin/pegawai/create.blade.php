@extends('layouts.admin')

@section('title', 'Tambah Pegawai')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Pegawai / Guru</h1>
        <p class="text-gray-500 text-sm mt-1">Tambahkan data pegawai baru</p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Form Input --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow p-6">
                <form action="{{ route('admin.pegawai.store') }}" method="POST" enctype="multipart/form-data" id="pegawaiForm">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required class="w-full border rounded-lg px-4 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">NIP</label>
                            <input type="text" name="nip" id="nip" value="{{ old('nip') }}" class="w-full border rounded-lg px-4 py-2" placeholder="Nomor Induk Pegawai">
                            @error('nip') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Jabatan <span class="text-red-500">*</span></label>
                            <select name="jabatan" id="jabatan" required class="w-full border rounded-lg px-4 py-2">
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="Kepala Sekolah">🎓 Kepala Sekolah</option>
                                <option value="Wakil Kepala Sekolah">📋 Wakil Kepala Sekolah</option>
                                <option value="Guru">📚 Guru</option>
                                <option value="Guru BK">💬 Guru BK</option>
                                <option value="Kepala Perpustakaan">📖 Kepala Perpustakaan</option>
                                <option value="Kepala Laboratorium">🔬 Kepala Laboratorium</option>
                                <option value="Pembimbing Ekstrakurikuler">🏆 Pembimbing Ekstrakurikuler</option>
                                <option value="Staff TU">📁 Staff TU</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Pangkat / Bidang</label>
                            <input type="text" name="pangkat" id="pangkat" value="{{ old('pangkat') }}" class="w-full border rounded-lg px-4 py-2" placeholder="Contoh: Guru Matematika">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Foto</label>
                            <input type="file" name="foto" id="foto" accept="image/*" class="w-full border rounded-lg px-4 py-2" onchange="previewImage(event)">
                        </div>
                        <div class="flex gap-3 pt-4">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Simpan</button>
                            <a href="{{ route('admin.pegawai.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">Batal</a>
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

                <div class="pegawai-card group bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
                    <div class="flex flex-col items-center text-center">
                        {{-- Foto --}}
                        <div class="relative mb-4">
                            <div id="previewFotoDefault" class="w-28 h-28 rounded-full bg-gray-100 flex items-center justify-center border-4 border-gray-200">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <img id="previewFotoImg" class="w-28 h-28 rounded-full object-cover border-4 hidden" src="" alt="Preview">
                        </div>
                        
                        {{-- Nama --}}
                        <h3 id="previewNama" class="font-bold text-gray-800 text-lg">Nama Lengkap</h3>
                        
                        {{-- NIP --}}
                        <p id="previewNIP" class="text-xs text-gray-400 font-mono mt-0.5">NIP. -</p>
                        
                        {{-- Jabatan --}}
                        <p id="previewJabatan" class="font-medium text-sm mb-1 text-blue-600">Jabatan</p>
                        
                        {{-- Pangkat --}}
                        <p id="previewPangkat" class="text-gray-500 text-sm">Pangkat / Bidang</p>
                        
                        {{-- Icon Email --}}
                        <div class="flex gap-2 mt-4">
                            <span id="previewSocialBg" class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3 text-center">Preview akan diperbarui secara otomatis</p>
            </div>
        </div>
    </div>
</div>

<style>
.pegawai-card { transition: all 0.3s; }
.pegawai-card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
</style>

<script>
const jabatanColors = {
    'Kepala Sekolah': { text: 'text-purple-600', border: 'border-purple-200', bg: 'bg-purple-50', icon: 'text-purple-600' },
    'Wakil Kepala Sekolah': { text: 'text-orange-600', border: 'border-orange-200', bg: 'bg-orange-50', icon: 'text-orange-600' },
    'Guru': { text: 'text-blue-600', border: 'border-blue-200', bg: 'bg-blue-50', icon: 'text-blue-600' },
    'Guru BK': { text: 'text-teal-600', border: 'border-teal-200', bg: 'bg-teal-50', icon: 'text-teal-600' },
    'Kepala Perpustakaan': { text: 'text-amber-600', border: 'border-amber-200', bg: 'bg-amber-50', icon: 'text-amber-600' },
    'Kepala Laboratorium': { text: 'text-cyan-600', border: 'border-cyan-200', bg: 'bg-cyan-50', icon: 'text-cyan-600' },
    'Pembimbing Ekstrakurikuler': { text: 'text-indigo-600', border: 'border-indigo-200', bg: 'bg-indigo-50', icon: 'text-indigo-600' },
    'Staff TU': { text: 'text-green-600', border: 'border-green-200', bg: 'bg-green-50', icon: 'text-green-600' }
};

const jabatanLabels = {
    'Kepala Sekolah': '🎓 Kepala Sekolah',
    'Wakil Kepala Sekolah': '📋 Wakil Kepala Sekolah',
    'Guru': '📚 Guru',
    'Guru BK': '💬 Guru BK',
    'Kepala Perpustakaan': '📖 Kepala Perpustakaan',
    'Kepala Laboratorium': '🔬 Kepala Laboratorium',
    'Pembimbing Ekstrakurikuler': '🏆 Pembimbing Eskul',
    'Staff TU': '📁 Staff TU'
};

function updatePreview() {
    // Nama
    document.getElementById('previewNama').textContent = document.getElementById('nama').value || 'Nama Lengkap';
    
    // NIP
    const nip = document.getElementById('nip').value;
    document.getElementById('previewNIP').textContent = nip ? 'NIP. ' + nip : 'NIP. -';
    
    // Jabatan
    const jabatan = document.getElementById('jabatan').value;
    const previewJabatan = document.getElementById('previewJabatan');
    previewJabatan.textContent = jabatanLabels[jabatan] || 'Jabatan';
    
    // Warna
    if (jabatan && jabatanColors[jabatan]) {
        const colors = jabatanColors[jabatan];
        previewJabatan.className = `font-medium text-sm mb-1 ${colors.text}`;
        document.getElementById('previewFotoDefault').className = `w-28 h-28 rounded-full bg-gray-100 flex items-center justify-center border-4 ${colors.border}`;
        document.getElementById('previewSocialBg').className = `w-8 h-8 ${colors.bg} rounded-full flex items-center justify-center ${colors.icon}`;
    } else {
        previewJabatan.className = 'font-medium text-sm mb-1 text-gray-600';
        document.getElementById('previewFotoDefault').className = 'w-28 h-28 rounded-full bg-gray-100 flex items-center justify-center border-4 border-gray-200';
        document.getElementById('previewSocialBg').className = 'w-8 h-8 bg-gray-50 rounded-full flex items-center justify-center text-gray-600';
    }
    
    // Pangkat
    document.getElementById('previewPangkat').textContent = document.getElementById('pangkat').value || 'Pangkat / Bidang';
}

function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewFotoImg').src = e.target.result;
            document.getElementById('previewFotoDefault').classList.add('hidden');
            document.getElementById('previewFotoImg').classList.remove('hidden');
            
            const jabatan = document.getElementById('jabatan').value;
            if (jabatan && jabatanColors[jabatan]) {
                document.getElementById('previewFotoImg').className = `w-28 h-28 rounded-full object-cover border-4 ${jabatanColors[jabatan].border}`;
            }
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('previewFotoImg').src = '';
        document.getElementById('previewFotoDefault').classList.remove('hidden');
        document.getElementById('previewFotoImg').classList.add('hidden');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    ['nama', 'nip', 'jabatan', 'pangkat'].forEach(id => {
        document.getElementById(id)?.addEventListener('input', updatePreview);
    });
    updatePreview();
});
</script>
@endsection