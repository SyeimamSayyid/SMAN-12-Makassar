<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Universitas;
use App\Exports\AlumniExportPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlumniController extends Controller
{
    /**
     * Halaman index alumni (admin)
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $alumni = Alumni::with(['universitas', 'verifier'])
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $stats = [
            'total' => Alumni::count(),
            'pending' => Alumni::pending()->count(),
            'approved' => Alumni::approved()->count(),
            'rejected' => Alumni::rejected()->count(),
        ];
        
        return view('admin.alumni.index', compact('alumni', 'stats', 'status'));
    }

    /**
     * Form tambah alumni (admin)
     */
    public function create()
    {
        $universitas = Universitas::orderBy('nama')->get();
        return view('admin.alumni.create', compact('universitas'));
    }

    /**
     * Simpan alumni baru (admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tahun_lulus' => 'required|integer|min:1900|max:' . date('Y'),
            'universitas_id' => 'nullable|exists:universitas,id',
            'program_studi' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'testimoni' => 'nullable|string',
            'is_featured' => 'boolean',
        ]);

        // Cek duplikat nomor HP
        if (!empty($validated['no_hp'])) {
            $exists = Alumni::where('no_hp', $validated['no_hp'])->exists();
            if ($exists) {
                session()->flash('warning', '⚠️ Nomor HP "' . $validated['no_hp'] . '" sudah terdaftar! Silakan cek data duplikat.');
            }
        }

        $validated['status'] = 'approved';
        $validated['verified_by'] = auth()->id();
        $validated['verified_at'] = now();
        $validated['is_featured'] = $request->has('is_featured');

        // Geocoding dari provinsi & kota
        if ($request->provinsi && $request->kota) {
            $coords = $this->geocode($request->provinsi . ', ' . $request->kota);
            if ($coords) {
                $validated['latitude'] = $coords['lat'];
                $validated['longitude'] = $coords['lng'];
            }
        }

        Alumni::create($validated);

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni "' . $validated['nama_lengkap'] . '" berhasil ditambahkan!');
    }

    /**
     * Form edit alumni
     */
    public function edit(Alumni $alumni)
    {
        $universitas = Universitas::orderBy('nama')->get();
        return view('admin.alumni.edit', compact('alumni', 'universitas'));
    }

    /**
     * Update data alumni
     */
    public function update(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tahun_lulus' => 'required|integer|min:1900|max:' . date('Y'),
            'universitas_id' => 'nullable|exists:universitas,id',
            'program_studi' => 'nullable|string|max:100',
            'tahun_masuk_kuliah' => 'nullable|integer|min:1900|max:' . date('Y'),
            'pekerjaan' => 'nullable|string|max:100',
            'perusahaan' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'kota' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:20',
            'instagram' => 'nullable|string|max:100',
            'testimoni' => 'nullable|string',
        ]);

        // Cek duplikat nomor HP
        if (!empty($validated['no_hp'])) {
            $exists = Alumni::where('no_hp', $validated['no_hp'])
                ->where('id', '!=', $alumni->id)
                ->exists();
            if ($exists) {
                session()->flash('warning', '⚠️ Nomor HP "' . $validated['no_hp'] . '" sudah terdaftar! Silakan cek data duplikat.');
            }
        }

        // Geocoding dari provinsi & kota
        if ($request->provinsi && $request->kota) {
            $coords = $this->geocode($request->provinsi . ', ' . $request->kota);
            if ($coords) {
                $validated['latitude'] = $coords['lat'];
                $validated['longitude'] = $coords['lng'];
            }
        }

        $alumni->update($validated);

        return redirect()->route('admin.alumni.index')
            ->with('success', 'Data alumni "' . $alumni->nama_lengkap . '" berhasil diperbarui!');
    }

    /**
     * Approve alumni
     */
    public function approve(Request $request, Alumni $alumni)
    {
        $alumni->update([
            'status' => 'approved',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'catatan_admin' => $request->catatan_admin,
            'is_featured' => $request->has('is_featured'),
        ]);
        
        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni "' . $alumni->nama_lengkap . '" berhasil diverifikasi!');
    }

    /**
     * Reject alumni
     */
    public function reject(Request $request, Alumni $alumni)
    {
        $alumni->update([
            'status' => 'rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'catatan_admin' => $request->catatan_admin,
        ]);
        
        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni "' . $alumni->nama_lengkap . '" ditolak!');
    }

    /**
     * Toggle featured
     */
    public function toggleFeatured(Alumni $alumni)
    {
        if ($alumni->status !== 'approved') {
            return back()->with('error', 'Alumni harus diverifikasi terlebih dahulu!');
        }
        
        $alumni->update(['is_featured' => !$alumni->is_featured]);
        
        $status = $alumni->is_featured ? 'ditandai featured' : 'dihapus dari featured';
        return back()->with('success', 'Alumni "' . $alumni->nama_lengkap . '" ' . $status);
    }

    /**
     * Hapus alumni
     */
    public function destroy(Alumni $alumni)
    {
        $nama = $alumni->nama_lengkap;
        $alumni->delete();
        
        return redirect()->route('admin.alumni.index')
            ->with('success', 'Alumni "' . $nama . '" berhasil dihapus!');
    }

    /**
     * Export PDF dengan filter
     */
    public function exportPDF(Request $request)
    {
        $tahun_lulus = $request->get('tahun_lulus', 'all');
        $universitas_id = $request->get('universitas_id', 'all');
        $jenjang_karir = $request->get('jenjang_karir', 'all');

        $export = new AlumniExportPDF($tahun_lulus, $universitas_id, $jenjang_karir);
        return $export->download();
    }

    /**
     * Cek duplikat nomor HP
     */
    public function checkDuplicateNoHP()
    {
        $duplicates = Alumni::select('no_hp')
            ->whereNotNull('no_hp')
            ->where('no_hp', '!=', '')
            ->groupBy('no_hp')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        if ($duplicates->isNotEmpty()) {
            $detailDuplicates = [];
            foreach ($duplicates as $dup) {
                $data = Alumni::with('universitas')->where('no_hp', $dup->no_hp)->get();
                $detailDuplicates[] = [
                    'no_hp' => $dup->no_hp,
                    'count' => $data->count(),
                    'data' => $data
                ];
            }
            return view('admin.alumni.duplicates', compact('detailDuplicates'));
        }

        return redirect()->route('admin.alumni.index')
            ->with('success', '✅ Tidak ada data duplikat nomor HP!');
    }

    /**
     * Hapus duplikat nomor HP (sisakan yang pertama)
     */
    public function deleteDuplicates(Request $request)
    {
        $no_hp = $request->no_hp;
        
        if ($no_hp) {
            $first = Alumni::where('no_hp', $no_hp)->orderBy('id')->first();
            if ($first) {
                Alumni::where('no_hp', $no_hp)
                    ->where('id', '!=', $first->id)
                    ->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Data duplikat berhasil dihapus!'
                ]);
            }
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal menghapus duplikat'
        ]);
    }

    /**
     * Kelola Universitas
     */
    public function universitasIndex()
    {
        $universitas = Universitas::orderBy('nama')->paginate(20);
        return view('admin.alumni.universitas', compact('universitas'));
    }

    /**
     * Simpan Universitas
     */
    public function universitasStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'akronim' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required|in:Negeri,Swasta,Kedinasan',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('universitas', 'public');
        }
        
        Universitas::create($validated);
        
        return redirect()->route('admin.alumni.universitas')
            ->with('success', 'Universitas "' . $validated['nama'] . '" berhasil ditambahkan!');
    }

    /**
     * Update Universitas
     */
    public function universitasUpdate(Request $request, Universitas $universitas)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'akronim' => 'nullable|string|max:50',
            'provinsi' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'status' => 'required|in:Negeri,Swasta,Kedinasan',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        if ($request->hasFile('logo')) {
            if ($universitas->logo) {
                Storage::disk('public')->delete($universitas->logo);
            }
            $validated['logo'] = $request->file('logo')->store('universitas', 'public');
        }
        
        $universitas->update($validated);
        
        return redirect()->route('admin.alumni.universitas')
            ->with('success', 'Universitas "' . $validated['nama'] . '" berhasil diperbarui!');
    }

    /**
     * Hapus Universitas
     */
    public function universitasDestroy(Universitas $universitas)
    {
        if ($universitas->logo) {
            Storage::disk('public')->delete($universitas->logo);
        }
        
        $nama = $universitas->nama;
        $universitas->delete();
        
        return redirect()->route('admin.alumni.universitas')
            ->with('success', 'Universitas "' . $nama . '" berhasil dihapus!');
    }

    /**
     * Geocoding sederhana (fallback koordinat per provinsi)
     */
    private function geocode($address)
    {
        $provinsiCoords = [
            'Aceh' => ['lat' => 4.695135, 'lng' => 96.749399],
            'Sumatera Utara' => ['lat' => 2.1153547, 'lng' => 99.5450974],
            'Sumatera Barat' => ['lat' => -0.7399397, 'lng' => 100.8000051],
            'Riau' => ['lat' => 0.2933469, 'lng' => 101.7068294],
            'Jambi' => ['lat' => -1.4851831, 'lng' => 102.4380581],
            'Sumatera Selatan' => ['lat' => -3.3194374, 'lng' => 103.914399],
            'Bengkulu' => ['lat' => -3.7928451, 'lng' => 102.2607641],
            'Lampung' => ['lat' => -4.5585849, 'lng' => 105.4068079],
            'DKI Jakarta' => ['lat' => -6.2087634, 'lng' => 106.845599],
            'Jawa Barat' => ['lat' => -6.9174639, 'lng' => 107.6191228],
            'Banten' => ['lat' => -6.4058172, 'lng' => 106.0640179],
            'Jawa Tengah' => ['lat' => -7.150975, 'lng' => 110.1402594],
            'DI Yogyakarta' => ['lat' => -7.7955798, 'lng' => 110.3694896],
            'Jawa Timur' => ['lat' => -7.5360639, 'lng' => 112.2384017],
            'Bali' => ['lat' => -8.4095178, 'lng' => 115.188916],
            'Nusa Tenggara Barat' => ['lat' => -8.6529334, 'lng' => 117.3616476],
            'Nusa Tenggara Timur' => ['lat' => -8.6573819, 'lng' => 121.0793705],
            'Kalimantan Barat' => ['lat' => -0.2787808, 'lng' => 111.4752851],
            'Kalimantan Tengah' => ['lat' => -1.6814878, 'lng' => 113.3823545],
            'Kalimantan Selatan' => ['lat' => -3.0926415, 'lng' => 115.2837585],
            'Kalimantan Timur' => ['lat' => 1.6406296, 'lng' => 116.419389],
            'Kalimantan Utara' => ['lat' => 3.2951653, 'lng' => 117.1560097],
            'Sulawesi Utara' => ['lat' => 0.6246932, 'lng' => 123.9750018],
            'Sulawesi Tengah' => ['lat' => -1.4300254, 'lng' => 121.4456179],
            'Sulawesi Selatan' => ['lat' => -3.6687994, 'lng' => 119.9740534],
            'Sulawesi Tenggara' => ['lat' => -4.14491, 'lng' => 122.174605],
            'Gorontalo' => ['lat' => 0.6999372, 'lng' => 122.4467238],
            'Sulawesi Barat' => ['lat' => -2.8441371, 'lng' => 119.2320784],
            'Maluku' => ['lat' => -3.2384616, 'lng' => 130.1452734],
            'Maluku Utara' => ['lat' => 1.5709993, 'lng' => 127.8087693],
            'Papua' => ['lat' => -4.269928, 'lng' => 138.0803529],
            'Papua Barat' => ['lat' => -1.3361154, 'lng' => 133.1747162],
        ];
        
        foreach ($provinsiCoords as $provinsi => $coords) {
            if (stripos($address, $provinsi) !== false) {
                return $coords;
            }
        }
        
        return ['lat' => -6.2087634, 'lng' => 106.845599];
    }
}