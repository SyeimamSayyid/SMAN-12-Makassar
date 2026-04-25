<?php
// app/Http/Controllers/BeritaController.php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Display a listing of berita for public view.
     */
    public function index(Request $request)
    {
        // Ambil parameter untuk filtering
        $search = $request->get('search');
        $kategori = $request->get('kategori');
        $sortBy = $request->get('sort_by', 'tanggal');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Query builder
        $query = Berita::query();
        
        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%');
            });
        }
        
        // Filter berdasarkan kategori
        if ($kategori && $kategori !== 'all') {
            $query->where('kategori', $kategori);
        }
        
        // Sorting - validasi field yang diizinkan
        $allowedSortFields = ['tanggal', 'created_at', 'judul', 'views'];
        if (in_array($sortBy, $allowedSortFields)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        } else {
            $query->orderBy('tanggal', 'desc');
        }
        
        // Pagination - 12 berita per halaman
        $beritas = $query->paginate(12);
        
        // Berita terbaru untuk sidebar
        $beritaTerbaru = Berita::orderBy('tanggal', 'desc')->limit(5)->get();
        
        // Berita populer (berdasarkan views)
        $beritaPopuler = Berita::orderBy('views', 'desc')->limit(5)->get();
        
        // Kategori yang tersedia
        $kategoris = Berita::select('kategori')
                           ->distinct()
                           ->whereNotNull('kategori')
                           ->pluck('kategori');
        
        return view('berita.index', compact(
            'beritas', 
            'search',
            'kategori',
            'sortBy', 
            'sortOrder',
            'beritaTerbaru',
            'beritaPopuler',
            'kategoris'
        ));
    }

    /**
     * Display the specified berita as JSON for modal.
     */
    public function show($id)
    {
        try {
            $berita = Berita::findOrFail($id);
            
            // Increment view count
            $berita->increment('views');
            
            // Decode images if needed
            $images = [];
            if (is_array($berita->images)) {
                $images = $berita->images;
            } elseif (is_string($berita->images)) {
                $images = json_decode($berita->images, true) ?? [];
            }
            
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $berita->id,
                    'judul' => $berita->judul,
                    'tanggal' => $berita->tanggal instanceof \Carbon\Carbon 
                        ? $berita->tanggal->format('Y-m-d') 
                        : $berita->tanggal,
                    'author' => $berita->author,
                    'isi' => $berita->isi,
                    'kategori' => $berita->kategori,
                    'views' => $berita->views,
                    'images' => $images,
                    'created_at' => $berita->created_at,
                    'updated_at' => $berita->updated_at
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Display berita detail page.
     */
    public function detail($id)
    {
        $berita = Berita::findOrFail($id);
        
        // Increment view count
        $berita->increment('views');
        
        // Berita terkait (berdasarkan kategori atau terbaru)
        $query = Berita::where('id', '!=', $id);
        
        if ($berita->kategori) {
            $query->where('kategori', $berita->kategori);
        }
        
        $beritaTerkait = $query->orderBy('tanggal', 'desc')
                                ->limit(4)
                                ->get();
        
        // Jika berita terkait kurang dari 4, tambahkan berita terbaru
        if ($beritaTerkait->count() < 4) {
            $additionalBeritas = Berita::where('id', '!=', $id)
                                        ->whereNotIn('id', $beritaTerkait->pluck('id'))
                                        ->orderBy('tanggal', 'desc')
                                        ->limit(4 - $beritaTerkait->count())
                                        ->get();
            $beritaTerkait = $beritaTerkait->concat($additionalBeritas);
        }
        
        // Berita terbaru untuk sidebar
        $beritaTerbaru = Berita::orderBy('tanggal', 'desc')->limit(5)->get();
        
        return view('berita.detail', compact('berita', 'beritaTerkait', 'beritaTerbaru'));
    }

    /**
     * Display berita by author.
     */
    public function byAuthor($author)
    {
        $authorName = urldecode($author);
        
        $beritas = Berita::where('author', 'like', '%' . $authorName . '%')
                         ->orderBy('tanggal', 'desc')
                         ->paginate(12);
        
        $beritaTerbaru = Berita::orderBy('tanggal', 'desc')->limit(5)->get();
        
        return view('berita.by-author', compact('beritas', 'authorName', 'beritaTerbaru'));
    }

    /**
     * Search berita (AJAX endpoint).
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        if (!$search || strlen($search) < 2) {
            return response()->json([]);
        }
        
        $beritas = Berita::where('judul', 'like', '%' . $search . '%')
                         ->orWhere('isi', 'like', '%' . $search . '%')
                         ->orderBy('tanggal', 'desc')
                         ->limit(10)
                         ->get(['id', 'judul', 'tanggal', 'kategori']);
        
        return response()->json($beritas);
    }

    /**
     * Get recent berita for widget (AJAX endpoint).
     */
    public function recent()
    {
        $beritas = Berita::orderBy('tanggal', 'desc')
                         ->limit(5)
                         ->get(['id', 'judul', 'tanggal', 'author', 'kategori']);
        
        return response()->json($beritas);
    }

    /**
     * Get first image from berita images.
     */
    private function getFirstImage($berita)
    {
        $images = $berita->images;
        
        if (is_array($images)) {
            return $images[0] ?? null;
        }
        
        if (is_string($images)) {
            $decoded = json_decode($images, true);
            return $decoded[0] ?? null;
        }
        
        return null;
    }
}