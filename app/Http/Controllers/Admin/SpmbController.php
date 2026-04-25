<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpmbController extends Controller
{
    public function index()
    {
        $spmb = Spmb::orderBy('tanggal_upload', 'desc')->paginate(10);
        return view('admin.spmb.index', compact('spmb'));
    }

    public function create()
    {
        return view('admin.spmb.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link_pendaftaran' => 'nullable|url',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_type.*' => 'required_with:video_url,video_file|in:youtube,upload',
            'video_url.*' => 'nullable|string|max:255',
            'video_file.*' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200',
            'video_caption.*' => 'nullable|string|max:255',
            'galeri.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_upload' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_upload',
        ]);

        // Validasi jumlah video (max 5)
        $videoCount = count(array_filter($request->video_type ?? []));
        if ($videoCount > 5) {
            return back()->withErrors(['video' => 'Maksimal 5 video'])->withInput();
        }

        // Validasi jumlah foto (max 15)
        if ($request->hasFile('galeri') && count($request->file('galeri')) > 15) {
            return back()->withErrors(['galeri' => 'Maksimal 15 foto'])->withInput();
        }

        $validated['slug'] = $this->generateUniqueSlug($validated['judul']);
        $validated['created_by'] = auth()->id();
        $validated['is_active'] = true;

        // Proses Video
        $videos = [];
        if ($request->has('video_type')) {
            foreach ($request->video_type as $index => $type) {
                $videoData = [
                    'type' => $type,
                    'caption' => $request->video_caption[$index] ?? '',
                ];
                
                if ($type === 'youtube' && !empty($request->video_url[$index])) {
                    $videoData['url'] = Spmb::parseYoutubeUrl($request->video_url[$index]);
                } elseif ($type === 'upload' && $request->hasFile("video_file.{$index}")) {
                    $file = $request->file("video_file.{$index}");
                    $videoData['url'] = $file->store('spmb/videos', 'public');
                }
                
                if (isset($videoData['url'])) {
                    $videos[] = $videoData;
                }
            }
        }
        $validated['video'] = $videos;

        // Foto utama
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('spmb', 'public');
        }

        // Galeri
        if ($request->hasFile('galeri')) {
            $galeri = [];
            foreach ($request->file('galeri') as $file) {
                $galeri[] = $file->store('spmb/galeri', 'public');
            }
            $validated['galeri'] = $galeri;
        }

        Spmb::create($validated);

        return redirect()->route('admin.spmb.index')
            ->with('success', 'SPMB berhasil ditambahkan!');
    }

    public function edit(Spmb $spmb)
    {
        return view('admin.spmb.edit', compact('spmb'));
    }

    public function update(Request $request, Spmb $spmb)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'link_pendaftaran' => 'nullable|url',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_type.*' => 'required_with:video_url,video_file|in:youtube,upload',
            'video_url.*' => 'nullable|string|max:255',
            'video_file.*' => 'nullable|file|mimes:mp4,mov,avi,webm|max:51200',
            'video_caption.*' => 'nullable|string|max:255',
            'galeri.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tanggal_upload' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_upload',
            'is_active' => 'boolean',
        ]);

        // Validasi total video (existing + new) max 5
        $existingVideoCount = count($spmb->video ?? []);
        $newVideoCount = count(array_filter($request->video_type ?? []));
        if ($existingVideoCount + $newVideoCount > 5) {
            return back()->withErrors(['video' => 'Total video maksimal 5'])->withInput();
        }

        // Validasi total foto (existing + new) max 15
        $existingFotoCount = count($spmb->galeri ?? []);
        $newFotoCount = $request->hasFile('galeri') ? count($request->file('galeri')) : 0;
        if ($existingFotoCount + $newFotoCount > 15) {
            return back()->withErrors(['galeri' => 'Total foto maksimal 15'])->withInput();
        }

        if ($spmb->judul !== $validated['judul']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['judul'], $spmb->id);
        }

        // Foto utama
        if ($request->hasFile('foto')) {
            if ($spmb->foto) {
                Storage::disk('public')->delete($spmb->foto);
            }
            $validated['foto'] = $request->file('foto')->store('spmb', 'public');
        }

        // Proses video baru
        $newVideos = [];
        if ($request->has('video_type')) {
            foreach ($request->video_type as $index => $type) {
                $videoData = [
                    'type' => $type,
                    'caption' => $request->video_caption[$index] ?? '',
                ];
                
                if ($type === 'youtube' && !empty($request->video_url[$index])) {
                    $videoData['url'] = Spmb::parseYoutubeUrl($request->video_url[$index]);
                } elseif ($type === 'upload' && $request->hasFile("video_file.{$index}")) {
                    $file = $request->file("video_file.{$index}");
                    $videoData['url'] = $file->store('spmb/videos', 'public');
                }
                
                if (isset($videoData['url'])) {
                    $newVideos[] = $videoData;
                }
            }
        }
        
        // Gabungkan video existing dengan yang baru
        $allVideos = array_merge($spmb->video ?? [], $newVideos);
        $validated['video'] = $allVideos;

        // Galeri
        if ($request->hasFile('galeri')) {
            $galeri = $spmb->galeri ?? [];
            foreach ($request->file('galeri') as $file) {
                $galeri[] = $file->store('spmb/galeri', 'public');
            }
            $validated['galeri'] = $galeri;
        }

        $validated['is_active'] = $request->has('is_active');

        $spmb->update($validated);

        return redirect()->route('admin.spmb.index')
            ->with('success', 'SPMB berhasil diperbarui!');
    }

    public function destroy(Spmb $spmb)
    {
        // Hapus foto utama
        if ($spmb->foto) {
            Storage::disk('public')->delete($spmb->foto);
        }
        
        // Hapus galeri
        if ($spmb->galeri) {
            foreach ($spmb->galeri as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }
        
        // Hapus file video yang diupload (bukan YouTube)
        if ($spmb->video) {
            foreach ($spmb->video as $video) {
                if ($video['type'] === 'upload' && isset($video['url'])) {
                    Storage::disk('public')->delete($video['url']);
                }
            }
        }
        
        $spmb->delete();

        return redirect()->route('admin.spmb.index')
            ->with('success', 'SPMB berhasil dihapus!');
    }

    public function deleteImage(Request $request, Spmb $spmb)
    {
        $index = $request->index;
        $galeri = $spmb->galeri ?? [];
        
        if (isset($galeri[$index])) {
            Storage::disk('public')->delete($galeri[$index]);
            unset($galeri[$index]);
            $spmb->update(['galeri' => array_values($galeri)]);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function deleteVideo(Request $request, Spmb $spmb)
    {
        $index = $request->index;
        $videos = $spmb->video ?? [];
        
        if (isset($videos[$index])) {
            // Hapus file jika tipe upload
            if ($videos[$index]['type'] === 'upload' && isset($videos[$index]['url'])) {
                Storage::disk('public')->delete($videos[$index]['url']);
            }
            
            unset($videos[$index]);
            $spmb->update(['video' => array_values($videos)]);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    public function reorderImages(Request $request, Spmb $spmb)
    {
        $request->validate([
            'from' => 'required|integer|min:0',
            'to' => 'required|integer|min:0',
        ]);
        
        $from = $request->from;
        $to = $request->to;
        $galeri = $spmb->galeri ?? [];
        
        if (isset($galeri[$from])) {
            $moved = $galeri[$from];
            array_splice($galeri, $from, 1);
            array_splice($galeri, $to, 0, [$moved]); // ✅ SUDAH DIPERBAIKI
            $spmb->update(['galeri' => array_values($galeri)]);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false], 404);
    }

    private function generateUniqueSlug($judul, $excludeId = null)
    {
        $slug = Str::slug($judul);
        $originalSlug = $slug;
        $count = 1;

        $query = Spmb::where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
            
            $query = Spmb::where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }
}