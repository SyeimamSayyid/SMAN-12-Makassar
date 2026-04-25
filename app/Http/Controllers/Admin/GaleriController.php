<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $galeri = Galeri::orderBy('tanggal_kegiatan', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        return view('admin.galeri.index', compact('galeri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galeri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Upacara,Akademik,Olahraga,Seni,Keagamaan,Lomba,Study Tour,Lainnya',
            'deskripsi' => 'nullable|string',
            'tanggal_kegiatan' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_lain.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        // Generate unique slug
        $validated['slug'] = $this->generateUniqueSlug($validated['judul']);

        // Upload gambar utama
        if ($request->hasFile('gambar_utama')) {
            $validated['gambar_utama'] = $request->file('gambar_utama')->store('galeri', 'public');
        }

        // Upload gambar lain
        if ($request->hasFile('gambar_lain')) {
            $gambarLain = [];
            foreach ($request->file('gambar_lain') as $file) {
                $gambarLain[] = $file->store('galeri', 'public');
            }
            $validated['gambar_lain'] = $gambarLain;
        }

        // Set boolean values
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['views'] = 0;

        Galeri::create($validated);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri "' . $validated['judul'] . '" berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Galeri $galeri)
    {
        return view('admin.galeri.show', compact('galeri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Galeri $galeri)
    {
        return view('admin.galeri.edit', compact('galeri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Galeri $galeri)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:Upacara,Akademik,Olahraga,Seni,Keagamaan,Lomba,Study Tour,Lainnya',
            'deskripsi' => 'nullable|string',
            'tanggal_kegiatan' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:255',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gambar_lain.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'urutan' => 'nullable|integer',
        ]);

        // Update slug hanya jika judul berubah
        if ($galeri->judul !== $validated['judul']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['judul'], $galeri->id);
        } else {
            $validated['slug'] = $galeri->slug;
        }

        // Upload gambar utama baru
        if ($request->hasFile('gambar_utama')) {
            // Hapus gambar lama
            if ($galeri->gambar_utama) {
                Storage::disk('public')->delete($galeri->gambar_utama);
            }
            $validated['gambar_utama'] = $request->file('gambar_utama')->store('galeri', 'public');
        }

        // Upload gambar lain (tambah ke yang sudah ada)
        if ($request->hasFile('gambar_lain')) {
            $gambarLain = $galeri->gambar_lain ?? [];
            foreach ($request->file('gambar_lain') as $file) {
                $gambarLain[] = $file->store('galeri', 'public');
            }
            $validated['gambar_lain'] = $gambarLain;
        }

        // Set boolean values
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        $galeri->update($validated);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri "' . $galeri->judul . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Galeri $galeri)
    {
        $judul = $galeri->judul;

        // Hapus gambar utama
        if ($galeri->gambar_utama) {
            Storage::disk('public')->delete($galeri->gambar_utama);
        }

        // Hapus semua gambar lain
        if ($galeri->gambar_lain) {
            foreach ($galeri->gambar_lain as $gambar) {
                Storage::disk('public')->delete($gambar);
            }
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri "' . $judul . '" berhasil dihapus!');
    }

    /**
     * Delete single image from galeri.
     */
    public function deleteImage(Request $request, Galeri $galeri)
    {
        $index = $request->index;
        $gambarLain = $galeri->gambar_lain ?? [];
        
        if (isset($gambarLain[$index])) {
            Storage::disk('public')->delete($gambarLain[$index]);
            unset($gambarLain[$index]);
            $galeri->update(['gambar_lain' => array_values($gambarLain)]);
            
            return response()->json(['success' => true, 'message' => 'Gambar berhasil dihapus']);
        }
        
        return response()->json(['success' => false, 'message' => 'Gambar tidak ditemukan'], 404);
    }

    /**
     * Toggle featured status.
     */
    public function toggleFeatured(Galeri $galeri)
    {
        $galeri->update(['is_featured' => !$galeri->is_featured]);
        
        $status = $galeri->is_featured ? 'ditandai featured' : 'dihapus dari featured';
        
        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri "' . $galeri->judul . '" ' . $status);
    }

    /**
     * Toggle active status.
     */
    public function toggleActive(Galeri $galeri)
    {
        $galeri->update(['is_active' => !$galeri->is_active]);
        
        $status = $galeri->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri "' . $galeri->judul . '" ' . $status);
    }

    /**
     * Generate unique slug for galeri.
     */
    private function generateUniqueSlug($judul, $excludeId = null)
    {
        $slug = Str::slug($judul);
        $originalSlug = $slug;
        $count = 1;

        $query = Galeri::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            
            $query = Galeri::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }
}