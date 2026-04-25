@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 md:py-8">
    
    {{-- Header Section with Icons --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 md:mb-8">
        <div>
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-800 flex items-center gap-3">
                <i class="fas fa-newspaper text-indigo-500 text-3xl"></i>
                Kelola Berita
            </h1>
            <p class="text-gray-500 text-sm mt-1 flex items-center gap-1">
                <i class="fas fa-database text-xs"></i>
                Total <span class="font-semibold text-indigo-600">{{ $beritas->total() }}</span> berita tersedia
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 text-gray-700 text-sm font-medium shadow-sm hover:bg-gray-50 hover:shadow transition-all duration-200">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.berita.create') }}" 
               class="inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 text-white text-sm font-semibold shadow-md hover:shadow-lg hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200">
                <i class="fas fa-plus-circle"></i>
                Tambah Berita
            </a>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
    <div class="mb-4 bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 animate-fadeIn">
        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-white text-sm"></i>
        </div>
        <p class="text-green-800 text-sm font-medium">{{ session('success') }}</p>
    </div>
    @endif

    {{-- Alert Error --}}
    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 animate-fadeIn">
        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
            <i class="fas fa-exclamation text-white text-sm"></i>
        </div>
        <p class="text-red-800 text-sm font-medium">{{ $errors->first() }}</p>
    </div>
    @endif

    {{-- Search & Sort Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden">
        <div class="p-4 md:p-5">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                {{-- Search Form --}}
                <div class="flex-1 max-w-md">
                    <form method="GET" action="{{ route('admin.berita.index') }}" class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari judul atau penulis..." 
                               class="w-full pl-9 pr-10 py-2.5 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-200 focus:border-indigo-300 transition-all text-sm">
                        <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-indigo-50 text-indigo-600 rounded-lg px-3 py-1 text-xs font-medium hover:bg-indigo-100 transition">
                            Cari
                        </button>
                    </form>
                </div>
                
                {{-- Sort & Reset --}}
                <div class="flex items-center gap-3 flex-wrap">
                    @if(request('search'))
                        <a href="{{ route('admin.berita.index') }}" 
                           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 text-sm hover:bg-gray-200 transition">
                            <i class="fas fa-times-circle"></i>
                            Reset
                        </a>
                    @endif
                    
                    <div class="flex items-center gap-2 bg-gray-50 px-3 py-1.5 rounded-xl border border-gray-100">
                        <span class="text-xs text-gray-500 font-medium">
                            <i class="fas fa-sort-amount-down-alt mr-1"></i>Urutkan:
                        </span>
                        <form method="GET" action="{{ route('admin.berita.index') }}" id="sortForm" class="inline">
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            <select name="sort" onchange="this.form.submit()" 
                                    class="bg-transparent text-sm font-medium text-gray-700 focus:outline-none cursor-pointer">
                                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru ▼</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama ▲</option>
                                <option value="judul_asc" {{ request('sort') == 'judul_asc' ? 'selected' : '' }}>Judul A-Z</option>
                                <option value="judul_desc" {{ request('sort') == 'judul_desc' ? 'selected' : '' }}>Judul Z-A</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">NO</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">FOTO</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">JUDUL</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">TANGGAL</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">PENULIS</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($beritas as $index => $item)
                    <tr class="hover:bg-indigo-50/30 transition duration-150 group">
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                            {{ $beritas->firstItem() + $index }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @php
                                $images = is_array($item->images) 
                                    ? $item->images 
                                    : json_decode($item->images, true);
                                $firstImage = $images[0] ?? null;
                            @endphp
                            @if($firstImage)
                                <div class="h-11 w-11 rounded-xl bg-gray-100 overflow-hidden shadow-inner">
                                    <img src="{{ $firstImage }}" 
                                         alt="foto berita" 
                                         class="h-full w-full object-cover rounded-xl">
                                </div>
                            @else
                                <div class="h-11 w-11 rounded-xl bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-xl"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-4">
                            <div class="font-semibold text-gray-800 text-sm line-clamp-1">{{ $item->judul }}</div>
                            <div class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                <i class="fas fa-hashtag text-[10px]"></i>
                                <span>ID: #{{ $item->id }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400 flex items-center gap-1 mt-0.5">
                                <i class="far fa-clock"></i>
                                <span>{{ \Carbon\Carbon::parse($item->tanggal)->diffForHumans() }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-user-pen text-indigo-500 text-[10px]"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ $item->author }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                {{-- Edit Button --}}
                                <a href="{{ route('admin.berita.edit', $item->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-amber-600 bg-amber-50 hover:bg-amber-100 hover:text-amber-700 transition-all duration-200"
                                   title="Edit berita">
                                    <i class="fas fa-edit text-sm"></i>
                                    <span class="text-xs font-medium">Edit</span>
                                </a>
                                
                                {{-- Delete Form (Inline) --}}
                                <form action="{{ route('admin.berita.destroy', $item->id) }}" 
                                      method="POST" 
                                      class="inline-block delete-form"
                                      data-judul="{{ $item->judul }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 hover:text-rose-700 transition-all duration-200"
                                            title="Hapus berita">
                                        <i class="fas fa-trash-alt text-sm"></i>
                                        <span class="text-xs font-medium">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="h-16 w-16 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-newspaper text-gray-300 text-2xl"></i>
                                </div>
                                <p class="text-gray-400 font-medium">Tidak ada berita ditemukan</p>
                                <p class="text-xs text-gray-300">Silakan tambah berita baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination Footer --}}
        @if($beritas->count() > 0)
        <div class="border-t border-gray-100 bg-gray-50/30 px-5 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="text-xs text-gray-500 flex items-center gap-1">
                <i class="fas fa-chart-simple"></i>
                Menampilkan {{ $beritas->firstItem() }} - {{ $beritas->lastItem() }} dari {{ $beritas->total() }} berita
            </div>
            <div>
                {{ $beritas->withQueryString()->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

{{-- MODAL DELETE KONFIRMASI --}}
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 hidden">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" id="modalBackdrop"></div>
    <div class="relative bg-white rounded-2xl w-full max-w-md shadow-2xl transform transition-all animate-modal">
        <form method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-trash-can text-rose-500"></i>
                        Konfirmasi Hapus
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 transition" id="closeModalBtn">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="mb-6">
                    <p class="text-gray-700 text-base">
                        Yakin mau hapus berita <strong class="text-rose-600" id="judulHapus"></strong>?
                    </p>
                    <div class="mt-3 bg-rose-50 rounded-xl p-3 flex items-start gap-2">
                        <i class="fas fa-exclamation-triangle text-rose-400 mt-0.5"></i>
                        <p class="text-sm text-rose-700">Tindakan ini tidak dapat dibatalkan. Seluruh data akan dihapus permanen.</p>
                    </div>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" class="px-5 py-2.5 rounded-xl bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition-all" id="cancelBtn">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-rose-500 to-rose-600 text-white font-semibold shadow-md hover:shadow-lg hover:from-rose-600 transition-all flex items-center gap-2">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    @keyframes modalPop {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-modal {
        animation: modalPop 0.2s ease-out;
    }
    
    .animate-fadeIn {
        animation: fadeIn 0.3s ease-out;
    }
    
    /* Custom pagination styling untuk Laravel */
    .pagination {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }
    
    .pagination .page-item .page-link {
        padding: 0.5rem 0.75rem;
        border-radius: 0.5rem;
        color: #4b5563;
        background-color: white;
        border: 1px solid #e5e7eb;
        font-size: 0.875rem;
        transition: all 0.2s;
    }
    
    .pagination .page-item .page-link:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #6366f1;
        border-color: #6366f1;
        color: white;
    }
    
    .pagination .page-item.disabled .page-link {
        color: #9ca3af;
        cursor: not-allowed;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('deleteModal');
        const backdrop = document.getElementById('modalBackdrop');
        const closeBtn = document.getElementById('closeModalBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const deleteForm = document.getElementById('deleteForm');
        const judulHapus = document.getElementById('judulHapus');
        
        let currentDeleteForm = null;
        
        // Function to open modal
        function openModal() {
            modalElement.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        // Function to close modal
        function closeModal() {
            modalElement.classList.add('hidden');
            document.body.style.overflow = '';
            currentDeleteForm = null;
        }
        
        // Close modal events
        if (backdrop) backdrop.addEventListener('click', closeModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);
        
        // Handle delete form submissions dengan konfirmasi modal
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simpan referensi form yang akan di-submit
                currentDeleteForm = this;
                
                // Ambil judul dari data attribute
                const judul = this.dataset.judul || 'berita ini';
                
                // Set judul di modal
                if (judulHapus) {
                    judulHapus.innerText = judul;
                }
                
                // Set action form modal ke action form asli
                if (deleteForm) {
                    deleteForm.action = this.action;
                }
                
                // Buka modal
                openModal();
            });
        });
        
        // Handle submit dari modal form
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                // Tidak perlu prevent default, biarkan form submit normal
                // Tapi kita bisa tambahkan loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
                    submitBtn.disabled = true;
                }
            });
        }
        
        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modalElement && !modalElement.classList.contains('hidden')) {
                closeModal();
            }
        });
        
        // Fallback: Jika ada form delete yang belum di-handle, tambahkan konfirmasi native
        document.querySelectorAll('form[method="POST"]').forEach(form => {
            const methodInput = form.querySelector('input[name="_method"]');
            if (methodInput && methodInput.value === 'DELETE' && !form.classList.contains('delete-form')) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('Yakin ingin menghapus berita ini?')) {
                        e.preventDefault();
                    }
                });
            }
        });
    });
</script>
@endsection