@extends('layouts.app')

@section('title', 'Statistik Sekolah')

@section('content')

{{-- Hero Section --}}
<section class="pt-28 pb-12 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700">
    <div class="container mx-auto px-6">
        <div class="text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in">Statistik Sekolah</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto animate-slide-up">Data dan informasi statistik siswa SMAN 12 Makassar</p>
            
            {{-- Breadcrumb --}}
            <div class="flex items-center justify-center gap-2 mt-6 text-sm text-blue-200 animate-fade-in">
                <a href="{{ route('home') }}" class="hover:text-white transition">Home</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-white">Statistik</span>
            </div>
        </div>
    </div>
</section>

{{-- Filter Tahun --}}
<section class="py-6 bg-white border-b border-gray-200 sticky top-0 z-30 shadow-sm">
    <div class="container mx-auto px-6">
        <div class="flex justify-end">
            <form method="GET" class="flex items-center gap-3">
                <span class="text-sm text-gray-600">Tahun Ajaran:</span>
                <select name="tahun" class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 bg-white">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}/{{ $y+1 }}</option>
                    @endfor
                </select>
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
                    Filter
                </button>
            </form>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="py-12 bg-gradient-to-b from-white to-gray-50">
    <div class="container mx-auto px-6">
        
        {{-- Statistik Cards --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-10">
            @php
                $totalSiswa = ($detailKelas[10]->jumlah_siswa ?? 0) + ($detailKelas[11]->jumlah_siswa ?? 0) + ($detailKelas[12]->jumlah_siswa ?? 0);
                $totalRombel = ($detailKelas[10]->jumlah_rombel ?? 0) + ($detailKelas[11]->jumlah_rombel ?? 0) + ($detailKelas[12]->jumlah_rombel ?? 0);
            @endphp
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition-all duration-300 scroll-reveal">
                <div class="text-2xl md:text-3xl font-bold text-blue-600">{{ number_format($totalSiswa) }}</div>
                <p class="text-gray-600 text-sm md:text-base">Total Siswa</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition-all duration-300 scroll-reveal">
                <div class="text-2xl md:text-3xl font-bold text-green-600">{{ $totalRombel }}</div>
                <p class="text-gray-600 text-sm md:text-base">Total Rombel</p>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition-all duration-300 scroll-reveal">
                <div class="text-2xl md:text-3xl font-bold text-blue-600">{{ number_format($pieData['laki']) }}</div>
                <p class="text-gray-600 text-sm md:text-base">Laki-laki</p>
            </div>
            <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-2xl p-5 text-center shadow-sm hover:shadow-md transition-all duration-300 scroll-reveal">
                <div class="text-2xl md:text-3xl font-bold text-pink-600">{{ number_format($pieData['perempuan']) }}</div>
                <p class="text-gray-600 text-sm md:text-base">Perempuan</p>
            </div>
        </div>

        {{-- Bar Chart - Jumlah per Kelas --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 scroll-reveal">
            <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <span class="w-1 h-6 bg-gradient-to-b from-blue-500 to-indigo-600 rounded-full"></span>
                Jumlah Siswa per Kelas
            </h2>
            <div class="h-64 md:h-80">
                <canvas id="barChart"></canvas>
            </div>
        </div>

        {{-- Pie Chart & Detail Kelas --}}
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 scroll-reveal">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-gradient-to-b from-pink-500 to-rose-600 rounded-full"></span>
                    Perbandingan Gender
                </h2>
                <div class="h-64 md:h-72">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg p-6 scroll-reveal">
                <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-1 h-6 bg-gradient-to-b from-green-500 to-emerald-600 rounded-full"></span>
                    Detail per Kelas
                </h2>
                <div class="space-y-4">
                    @foreach([10, 11, 12] as $kelas)
                    @php $d = $detailKelas[$kelas] ?? null; @endphp
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <h3 class="font-bold text-gray-800 flex items-center justify-between">
                            <span>Kelas {{ $kelas }}</span>
                            <span class="text-sm font-normal text-gray-500">{{ $d->jumlah_rombel ?? 0 }} Rombel</span>
                        </h3>
                        <div class="grid grid-cols-3 gap-2 mt-3 text-sm">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-gray-800">{{ $d->jumlah_siswa ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Siswa</p>
                            </div>
                            <div class="text-center border-l border-r border-gray-200">
                                <p class="text-2xl font-bold text-blue-600">{{ $d->laki_laki ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Laki-laki</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-pink-600">{{ $d->perempuan ?? 0 }}</p>
                                <p class="text-xs text-gray-500">Perempuan</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.8s ease-out forwards;
}
.animate-slide-up {
    animation: slideUp 0.8s ease-out 0.2s forwards;
    opacity: 0;
}
.scroll-reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s ease, transform 0.8s ease;
}
.scroll-reveal.revealed {
    opacity: 1;
    transform: translateY(0);
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Scroll Reveal
    const revealElements = document.querySelectorAll('.scroll-reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15, rootMargin: '0px 0px -50px 0px' });
    revealElements.forEach(el => observer.observe(el));

    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($barData['labels']) !!},
            datasets: [{
                label: 'Jumlah Siswa',
                data: {!! json_encode($barData['jumlah']) !!},
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b'],
                borderRadius: 8,
                barPercentage: 0.6,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
    
    // Pie Chart
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [{{ $pieData['laki'] }}, {{ $pieData['perempuan'] }}],
                backgroundColor: ['#3b82f6', '#ec4899'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15 } }
            },
            cutout: '60%'
        }
    });
    
    // Line Chart
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($lineData['labels']) !!},
            datasets: [
                { 
                    label: 'Kelas 10', 
                    data: {!! json_encode($lineData['kelas10']) !!}, 
                    borderColor: '#3b82f6', 
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                },
                { 
                    label: 'Kelas 11', 
                    data: {!! json_encode($lineData['kelas11']) !!}, 
                    borderColor: '#10b981', 
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                },
                { 
                    label: 'Kelas 12', 
                    data: {!! json_encode($lineData['kelas12']) !!}, 
                    borderColor: '#f59e0b', 
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#f59e0b',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top', labels: { usePointStyle: true, padding: 15 } }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endsection