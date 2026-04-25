{{-- Modal Filter Export PDF --}}
<div id="exportModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
        <div class="p-6 border-b">
            <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Filter Export PDF
            </h3>
        </div>
        
        <form action="{{ route('admin.alumni.export-pdf') }}" method="GET" class="p-6 space-y-4">
            {{-- Filter Tahun Lulus --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun Lulus</label>
                <select name="tahun_lulus" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500">
                    <option value="all">📋 Semua Tahun</option>
                    @php
                        $tahunList = \App\Models\Alumni::approved()
                            ->select('tahun_lulus')
                            ->distinct()
                            ->orderBy('tahun_lulus', 'desc')
                            ->pluck('tahun_lulus');
                    @endphp
                    @foreach($tahunList as $th)
                        <option value="{{ $th }}">🎓 Angkatan {{ $th }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Universitas --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Universitas</label>
                <select name="universitas_id" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500">
                    <option value="all">🏫 Semua Universitas</option>
                    @php
                        $universitasList = \App\Models\Universitas::orderBy('nama')->get();
                    @endphp
                    @foreach($universitasList as $univ)
                        <option value="{{ $univ->id }}">{{ $univ->nama }} ({{ $univ->akronim }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Jenjang Karir --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Jenjang Karir</label>
                <select name="jenjang_karir" class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-rose-500">
                    <option value="all">💼 Semua Jenjang</option>
                    <option value="kuliah">📚 Melanjutkan Kuliah</option>
                    <option value="bekerja">💻 Sudah Bekerja</option>
                    <option value="wirausaha">🚀 Wirausaha</option>
                </select>
            </div>

            <div class="flex gap-3 pt-4 border-t">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-lg font-medium transition">
                    📥 Download PDF
                </button>
                <button type="button" onclick="closeExportModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-lg font-medium transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openExportModal() {
    document.getElementById('exportModal').classList.remove('hidden');
    document.getElementById('exportModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeExportModal() {
    document.getElementById('exportModal').classList.add('hidden');
    document.getElementById('exportModal').classList.remove('flex');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeExportModal();
});

document.getElementById('exportModal')?.addEventListener('click', (e) => {
    if (e.target === e.currentTarget) closeExportModal();
});
</script>