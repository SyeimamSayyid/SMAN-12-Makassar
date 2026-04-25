<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori', 'all');
        
        $galeri = Galeri::aktif()
            ->when($kategori !== 'all', fn($q) => $q->where('kategori', $kategori))
            ->orderBy('tanggal_kegiatan', 'desc')
            ->paginate(12);
        
        $kategoris = Galeri::aktif()->distinct()->pluck('kategori');
        
        return view('galeri.index', compact('galeri', 'kategori', 'kategoris'));
    }

    public function show($slug)
    {
        $galeri = Galeri::where('slug', $slug)->aktif()->firstOrFail();
        $galeri->increment('views');
        
        $galeriLain = Galeri::aktif()
            ->where('id', '!=', $galeri->id)
            ->where('kategori', $galeri->kategori)
            ->orderBy('tanggal_kegiatan', 'desc')
            ->limit(4)
            ->get();
        
        return view('galeri.show', compact('galeri', 'galeriLain'));
    }
}