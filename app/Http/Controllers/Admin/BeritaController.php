<?php
// app/Http/Controllers/Admin/BeritaController.php

namespace App\Http\Controllers\Admin;

use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource for admin.
     */
    public function index(Request $request)
    {
        // Ambil parameter sorting dan search dari URL
        $sortBy = $request->get('sort_by', 'tanggal');
        $sortOrder = $request->get('sort_order', 'desc');
        $search = $request->get('search');
        
        // Validasi kolom yang boleh di-sort
        $allowedSorts = ['judul', 'tanggal', 'author'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'tanggal';
        }
        
        // Validasi order
        $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc']) ? $sortOrder : 'desc';
        
        // Query builder
        $query = Berita::query();
        
        // Filter pencarian
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('author', 'LIKE', "%{$search}%")
                  ->orWhere('isi', 'LIKE', "%{$search}%");
            });
        }
        
        // Ambil data berita dengan sorting untuk pagination
        $beritas = $query->orderBy($sortBy, $sortOrder)
                         ->paginate(10)
                         ->withQueryString();
        
        // Ambil semua berita untuk dropdown kesimpulan cepat
        $semuaBerita = Berita::orderBy('tanggal', 'desc')->get();
        
        return view('admin.berita.index', compact('beritas', 'sortBy', 'sortOrder', 'semuaBerita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi - MAX 10 FOTO, TOTAL 10MB
        $request->validate([
            'judul' => 'required|min:5|max:255',
            'tanggal' => 'required|date',
            'author' => 'required|string|max:100',
            'isi' => 'required|min:10',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120'
        ], [
            'judul.required' => 'Judul berita wajib diisi',
            'judul.min' => 'Judul minimal 5 karakter',
            'judul.max' => 'Judul maksimal 255 karakter',
            'tanggal.required' => 'Tanggal wajib diisi',
            'tanggal.date' => 'Format tanggal tidak valid',
            'author.required' => 'Nama penulis wajib diisi',
            'isi.required' => 'Isi berita wajib diisi',
            'isi.min' => 'Isi berita minimal 10 karakter',
            'images.required' => 'Minimal 1 foto harus diupload',
            'images.min' => 'Minimal 1 foto harus diupload',
            'images.max' => 'Maksimal 10 foto yang dapat diupload',
            'images.*.image' => 'File harus berupa gambar',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
            'images.*.max' => 'Ukuran per foto maksimal 5MB',
        ]);

        // Validasi total ukuran semua foto (maks 10MB)
        $totalSize = 0;
        foreach ($request->file('images') as $image) {
            $totalSize += $image->getSize();
        }
        
        if ($totalSize > 10 * 1024 * 1024) {
            return redirect()->back()
                            ->withInput()
                            ->withErrors(['images' => 'Total ukuran semua foto maksimal 10MB. Ukuran saat ini: ' . round($totalSize / 1024 / 1024, 2) . 'MB']);
        }

        try {
            $data = $request->except('images');
            
            // Handle upload multiple images ke base64
            if ($request->hasFile('images')) {
                $imageBase64 = [];
                foreach ($request->file('images') as $image) {
                    $imageContent = file_get_contents($image->getRealPath());
                    $base64 = 'data:' . $image->getMimeType() . ';base64,' . base64_encode($imageContent);
                    $imageBase64[] = $base64;
                }
                $data['images'] = $imageBase64;
            }

            $berita = Berita::create($data);

            return redirect()->route('admin.berita.index')
                            ->with('success', 'Berita "' . $berita->judul . '" berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan berita: ' . $e->getMessage());
            
            return redirect()->back()
                            ->withInput()
                            ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan berita. Silakan coba lagi.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($beritum)
    {
        $berita = Berita::findOrFail($beritum);
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($beritum)
    {
        // Ambil berita yang akan diedit
        $berita = Berita::findOrFail($beritum);
        
        // Ambil semua berita untuk dropdown
        $semuaBerita = Berita::orderBy('tanggal', 'desc')->get();
        
        return view('admin.berita.edit', compact('berita', 'semuaBerita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $beritum)
    {
        $berita = Berita::findOrFail($beritum);
        
        $rules = [
            'judul' => 'required|min:5|max:255',
            'tanggal' => 'required|date',
            'author' => 'required|string|max:100',
            'isi' => 'required|min:10',
        ];

        if ($request->hasFile('images')) {
            $rules['images'] = 'array|max:10';
            $rules['images.*'] = 'image|mimes:jpeg,png,jpg,gif|max:5120';
        }

        $request->validate($rules, [
            'images.max' => 'Maksimal 10 foto yang dapat diupload',
            'images.*.max' => 'Ukuran per foto maksimal 5MB',
        ]);

        try {
            $data = $request->except('images');
            
            // Handle existing images (yang tidak dihapus)
            $existingImages = [];
            if ($request->has('existing_images')) {
                $existingImages = $request->existing_images;
            }
            
            // Handle new images upload
            $newImages = [];
            if ($request->hasFile('images')) {
                // Check total size of new images
                $totalSize = 0;
                foreach ($request->file('images') as $image) {
                    $totalSize += $image->getSize();
                }
                
                if ($totalSize > 10 * 1024 * 1024) {
                    return redirect()->back()
                                    ->withInput()
                                    ->withErrors(['images' => 'Total ukuran foto baru maksimal 10MB. Ukuran saat ini: ' . round($totalSize / 1024 / 1024, 2) . 'MB']);
                }
                
                foreach ($request->file('images') as $image) {
                    $imageContent = file_get_contents($image->getRealPath());
                    $base64 = 'data:' . $image->getMimeType() . ';base64,' . base64_encode($imageContent);
                    $newImages[] = $base64;
                }
            }
            
            // Gabungkan existing images dengan new images
            $allImages = array_merge($existingImages, $newImages);
            
            // Check max 10 images
            if (count($allImages) > 10) {
                return redirect()->back()
                                ->withInput()
                                ->withErrors(['images' => 'Maksimal 10 foto yang dapat disimpan. Jumlah saat ini: ' . count($allImages) . ' foto']);
            }
            
            // Check minimal 1 image
            if (count($allImages) < 1) {
                return redirect()->back()
                                ->withInput()
                                ->withErrors(['images' => 'Minimal 1 foto harus disimpan']);
            }
            
            $data['images'] = $allImages;

            $berita->update($data);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita berhasil diperbarui',
                    'data' => $berita
                ]);
            }

            return redirect()->route('admin.berita.index')
                            ->with('success', 'Berita "' . $berita->judul . '" berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error saat mengupdate berita: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengupdate berita'
                ], 500);
            }
            
            return redirect()->back()
                            ->withInput()
                            ->withErrors(['error' => 'Terjadi kesalahan saat mengupdate berita. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($beritum)
    {
        try {
            $berita = Berita::findOrFail($beritum);
            $judul = $berita->judul;
            $berita->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berita "' . $judul . '" berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.berita.index')
                            ->with('success', 'Berita "' . $judul . '" berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error saat menghapus berita: ' . $e->getMessage());
            
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menghapus berita'
                ], 500);
            }
            
            return redirect()->back()
                            ->withErrors(['error' => 'Terjadi kesalahan saat menghapus berita. Silakan coba lagi.']);
        }
    }

    /**
     * Auto-save draft for berita
     */
    public function autoSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'berita_id' => 'nullable|exists:beritas,id',
            'judul' => 'nullable|string|max:255',
            'tanggal' => 'nullable|date',
            'isi' => 'nullable|string',
            'author' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            if ($request->has('berita_id') && $request->berita_id) {
                $berita = Berita::find($request->berita_id);
                if ($berita) {
                    $berita->update([
                        'judul' => $request->judul ?? $berita->judul,
                        'tanggal' => $request->tanggal ?? $berita->tanggal,
                        'isi' => $request->isi ?? $berita->isi,
                        'author' => $request->author ?? $berita->author,
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Draft berhasil disimpan',
                        'data' => $berita
                    ]);
                }
            }
            
            // For new berita, store in session temporarily
            session(['draft_berita' => [
                'judul' => $request->judul,
                'tanggal' => $request->tanggal,
                'isi' => $request->isi,
                'author' => $request->author,
            ]]);
            
            return response()->json([
                'success' => true,
                'message' => 'Draft berhasil disimpan',
                'data' => session('draft_berita')
            ]);
            
        } catch (\Exception $e) {
            Log::error('Auto-save error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan draft'
            ], 500);
        }
    }

    /**
     * Delete single image from berita
     */
    public function deleteImage(Request $request, $id)
    {
        try {
            $berita = Berita::findOrFail($id);
            $imageToDelete = $request->image;
            
            $currentImages = is_array($berita->images) ? $berita->images : (json_decode($berita->images, true) ?? []);
            
            // Remove the image
            $newImages = array_values(array_filter($currentImages, function($image) use ($imageToDelete) {
                return $image !== $imageToDelete;
            }));
            
            // Check minimal 1 image
            if (count($newImages) < 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'Minimal 1 foto harus disimpan'
                ], 422);
            }
            
            $berita->update([
                'images' => $newImages
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus',
                'images' => $newImages
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error deleting image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto'
            ], 500);
        }
    }
    
    /**
     * Upload single image to berita
     */
    public function uploadImage(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            $berita = Berita::findOrFail($id);
            $currentImages = is_array($berita->images) ? $berita->images : (json_decode($berita->images, true) ?? []);
            
            // Check max 10 images
            if (count($currentImages) >= 10) {
                return response()->json([
                    'success' => false,
                    'message' => 'Maksimal 10 foto yang dapat disimpan'
                ], 422);
            }
            
            // Upload new image
            $image = $request->file('image');
            $imageContent = file_get_contents($image->getRealPath());
            $base64 = 'data:' . $image->getMimeType() . ';base64,' . base64_encode($imageContent);
            
            // Add to existing images
            $currentImages[] = $base64;
            
            $berita->update([
                'images' => $currentImages
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil diupload',
                'image' => $base64,
                'images' => $currentImages
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error uploading image: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload foto'
            ], 500);
        }
    }
}