<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<div class="min-h-screen p-8">

    <!-- Tombol kembali -->
    <div class="mb-6">
        <a href="{{ url('/') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
           ⬅ Kembali ke Website
        </a>
    </div>

    @yield('content')


    {-- Tambahkan di dalam menu sidebar --}}
<li>
    <a href="{{ route('admin.statistik.index') }}" 
       class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-gradient-to-r hover:from-purple-50 hover:to-indigo-50 hover:text-purple-700 transition-all duration-200 group {{ request()->routeIs('admin.statistik.*') ? 'bg-gradient-to-r from-purple-50 to-indigo-50 text-purple-700' : '' }}">
        <svg class="w-5 h-5 transition group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
        </svg>
        <span>Statistik</span>
    </a>
</li>
</div>
{{-- SPMB --}}
<li>
    <a href="{{ route('admin.spmb.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition">
        <x-maki-school class="w-5 h-5" />
        <span>SPMB</span>
    </a>
</li>
</body>
</html>
