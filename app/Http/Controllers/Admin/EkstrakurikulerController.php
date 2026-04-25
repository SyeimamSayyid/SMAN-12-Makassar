<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ekstrakurikuler;
use App\Models\Berita;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EkstrakurikulerController extends Controller
{
    public function index()
    {
        $ekstrakurikulers = Ekstrakurikuler::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.ekstrakurikuler.index', compact('ekstrakurikulers'));
    }

    public function create()
    {
        $beritas = Berita::orderBy('tanggal', 'desc')->get();
        return view('admin.ekstrakurikuler.create', compact('beritas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:3|max:100',
            'deskripsi' => 'required|min:10',
            'pembina' => 'nullable|string|max:100',
            'jadwal' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'prestasi' => 'nullable|array',
            'prestasi.*' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'bg_type' => 'nullable|in:gradient,upload',
            'bg_color1' => 'nullable|string|max:7',
            'bg_color2' => 'nullable|string|max:7',
            'bg_direction' => 'nullable|string|max:20',
            'bg_opacity' => 'nullable|integer|min:10|max:100',
            'background' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'galeri' => 'nullable|array|max:10',
            'galeri.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'berita_terkait' => 'nullable|array',
            'berita_terkait.*' => 'nullable|integer|exists:beritas,id',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $data = $request->except(['logo', 'background', 'galeri', 'prestasi', 'berita_terkait', '_token']);

            // ✅ Logo - SIMPAN KE STORAGE
            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('ekstrakurikuler/logo', 'public');
            }

            // ✅ Background - SIMPAN KE STORAGE
            if ($request->bg_type === 'upload' && $request->hasFile('background')) {
                $data['background'] = $request->file('background')->store('ekstrakurikuler/background', 'public');
            } elseif ($request->bg_type === 'gradient') {
                $data['background'] = null;
            }

            // ✅ Galeri - SIMPAN KE STORAGE
            $galeriPaths = [];
            if ($request->hasFile('galeri')) {
                foreach ($request->file('galeri') as $image) {
                    if ($image && $image->isValid()) {
                        $galeriPaths[] = $image->store('ekstrakurikuler/galeri', 'public');
                    }
                }
            }
            $data['galeri'] = $galeriPaths;

            // Prestasi
            $data['prestasi'] = array_values(array_filter($request->prestasi ?? [], function($value) {
                return !empty(trim($value));
            }));

            // Berita terkait
            $data['berita_terkait'] = $request->berita_terkait ?? [];

            // Slug
            $data['slug'] = $this->generateUniqueSlug($request->nama);
            $data['is_active'] = $request->has('is_active');

            $ekstrakurikuler = Ekstrakurikuler::create($data);

            return redirect()
                ->route('admin.ekstrakurikuler.index')
                ->with('success', 'Ekstrakurikuler "' . $ekstrakurikuler->nama . '" berhasil ditambahkan!');

        } catch (\Exception $e) {
            Log::error('Error saving ekstrakurikuler: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        return view('admin.ekstrakurikuler.show', compact('ekstrakurikuler'));
    }

    public function edit($id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
        $beritas = Berita::orderBy('tanggal', 'desc')->get();
        return view('admin.ekstrakurikuler.edit', compact('ekstrakurikuler', 'beritas'));
    }

    public function update(Request $request, $id)
    {
        $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);

        $request->validate([
            'nama' => 'required|min:3|max:100',
            'deskripsi' => 'required|min:10',
            'pembina' => 'nullable|string|max:100',
            'jadwal' => 'nullable|string|max:255',
            'tempat' => 'nullable|string|max:255',
            'jumlah_anggota' => 'nullable|integer|min:0',
            'prestasi' => 'nullable|array',
            'prestasi.*' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'bg_type' => 'nullable|in:gradient,upload',
            'bg_color1' => 'nullable|string|max:7',
            'bg_color2' => 'nullable|string|max:7',
            'bg_direction' => 'nullable|string|max:20',
            'bg_opacity' => 'nullable|integer|min:10|max:100',
            'background' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'galeri' => 'nullable|array|max:10',
            'galeri.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'deleted_galeri' => 'nullable|array',
            'deleted_galeri.*' => 'nullable|string',
            'berita_terkait' => 'nullable|array',
            'berita_terkait.*' => 'nullable|integer|exists:beritas,id',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $data = $request->except(['logo', 'background', 'galeri', 'deleted_galeri', 'prestasi', 'berita_terkait', '_token', '_method']);

            // ✅ Logo
            if ($request->hasFile('logo')) {
                // Hapus logo lama
                if ($ekstrakurikuler->logo) {
                    Storage::disk('public')->delete($ekstrakurikuler->logo);
                }
                $data['logo'] = $request->file('logo')->store('ekstrakurikuler/logo', 'public');
            }

            // ✅ Background
            if ($request->bg_type === 'upload' && $request->hasFile('background')) {
                if ($ekstrakurikuler->background) {
                    Storage::disk('public')->delete($ekstrakurikuler->background);
                }
                $data['background'] = $request->file('background')->store('ekstrakurikuler/background', 'public');
            } elseif ($request->bg_type === 'gradient') {
                if ($ekstrakurikuler->background) {
                    Storage::disk('public')->delete($ekstrakurikuler->background);
                }
                $data['background'] = null;
            }

            // ✅ Galeri
            $currentGaleri = $ekstrakurikuler->galeri ?? [];
            
            // Hapus galeri yang di-delete
            if ($request->has('deleted_galeri')) {
                foreach ($request->deleted_galeri as $deleted) {
                    Storage::disk('public')->delete($deleted);
                }
                $currentGaleri = array_values(array_diff($currentGaleri, $request->deleted_galeri));
            }

            // Tambah galeri baru
            if ($request->hasFile('galeri')) {
                foreach ($request->file('galeri') as $image) {
                    if ($image && $image->isValid()) {
                        $currentGaleri[] = $image->store('ekstrakurikuler/galeri', 'public');
                    }
                }
            }
            $data['galeri'] = array_values($currentGaleri);

            // Prestasi
            $data['prestasi'] = array_values(array_filter($request->prestasi ?? [], function($value) {
                return !empty(trim($value));
            }));

            // Berita terkait
            $data['berita_terkait'] = $request->berita_terkait ?? [];

            // Slug
            if ($request->nama !== $ekstrakurikuler->nama) {
                $data['slug'] = $this->generateUniqueSlug($request->nama, $ekstrakurikuler->id);
            }

            $data['is_active'] = $request->has('is_active');

            $ekstrakurikuler->update($data);

            return redirect()
                ->route('admin.ekstrakurikuler.index')
                ->with('success', 'Ekstrakurikuler "' . $ekstrakurikuler->nama . '" berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error updating ekstrakurikuler: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $ekstrakurikuler = Ekstrakurikuler::findOrFail($id);
            $nama = $ekstrakurikuler->nama;

            // Hapus file dari storage
            if ($ekstrakurikuler->logo) {
                Storage::disk('public')->delete($ekstrakurikuler->logo);
            }
            if ($ekstrakurikuler->background) {
                Storage::disk('public')->delete($ekstrakurikuler->background);
            }
            if ($ekstrakurikuler->galeri) {
                foreach ($ekstrakurikuler->galeri as $foto) {
                    Storage::disk('public')->delete($foto);
                }
            }

            $ekstrakurikuler->delete();

            return redirect()
                ->route('admin.ekstrakurikuler.index')
                ->with('success', 'Ekstrakurikuler "' . $nama . '" berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error deleting ekstrakurikuler: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat menghapus']);
        }
    }

    private function generateUniqueSlug($nama, $excludeId = null)
    {
        $slug = Str::slug($nama);
        $originalSlug = $slug;
        $count = 1;

        $query = Ekstrakurikuler::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            
            $query = Ekstrakurikuler::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }
}