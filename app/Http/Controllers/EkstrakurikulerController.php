<?php

namespace App\Http\Controllers;

use App\Models\Ekstrakurikuler;
use App\Models\Berita;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    /**
     * Display a listing of ekstrakurikuler for public view.
     */
    public function index(Request $request)
    {
        // Ambil parameter untuk filtering
        $search = $request->get('search');
        $sortBy = $request->get('sort_by', 'nama');
        $sortOrder = $request->get('sort_order', 'asc');
        
        // Query builder
        $query = Ekstrakurikuler::where('is_active', true);
        
        // Filter berdasarkan pencarian
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhere('pembina', 'like', '%' . $search . '%');
            });
        }
        
        // Sorting
        $allowedSorts = ['nama', 'jumlah_anggota', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->orderBy('nama', 'asc');
        }
        
        // Get all active eskul for PlayStation-style view
        $eskuls = $query->get();
        
        // Ekstrakurikuler populer (berdasarkan jumlah anggota)
        $ekstrakurikulerPopuler = Ekstrakurikuler::where('is_active', true)
            ->orderBy('jumlah_anggota', 'desc')
            ->limit(5)
            ->get();
        
        return view('ekstrakurikuler.index', compact(
            'eskuls',
            'search',
            'sortBy',
            'sortOrder',
            'ekstrakurikulerPopuler'
        ));
    }

    /**
     * Display the specified ekstrakurikuler.
     */
    public function show($slug)
    {
        $eskul = Ekstrakurikuler::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
        
        // Get related berita based on berita_terkait
        $beritaTerkait = collect();
        if ($eskul->berita_terkait && count($eskul->berita_terkait) > 0) {
            $beritaTerkait = Berita::whereIn('id', $eskul->berita_terkait)
                ->orderBy('tanggal', 'desc')
                ->get();
        }
        
        // Get other ekstrakurikuler for sidebar
        $ekstrakurikulerLain = Ekstrakurikuler::where('is_active', true)
            ->where('id', '!=', $eskul->id)
            ->limit(4)
            ->get();
        
        return view('ekstrakurikuler.show', compact(
            'eskul',
            'beritaTerkait',
            'ekstrakurikulerLain'
        ));
    }

    /**
     * Display ekstrakurikuler by pembina.
     */
    public function byPembina($pembina)
    {
        $ekstrakurikulers = Ekstrakurikuler::where('pembina', 'like', '%' . $pembina . '%')
            ->where('is_active', true)
            ->orderBy('nama', 'asc')
            ->paginate(12);
        
        return view('ekstrakurikuler.by-pembina', compact('ekstrakurikulers', 'pembina'));
    }

    /**
     * Search ekstrakurikuler (AJAX endpoint).
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $ekstrakurikulers = Ekstrakurikuler::where('is_active', true)
            ->where(function($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            })
            ->limit(10)
            ->get(['id', 'nama', 'slug', 'logo']);
        
        return response()->json($ekstrakurikulers);
    }

    /**
     * Get popular ekstrakurikuler for widget (AJAX endpoint).
     */
    public function popular()
    {
        $ekstrakurikulers = Ekstrakurikuler::where('is_active', true)
            ->orderBy('jumlah_anggota', 'desc')
            ->limit(5)
            ->get(['id', 'nama', 'slug', 'logo', 'jumlah_anggota']);
        
        return response()->json($ekstrakurikulers);
    }
}