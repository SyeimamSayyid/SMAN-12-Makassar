<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Universitas;
use Illuminate\Http\Request;

class AlumniController extends Controller
{
    /**
     * Halaman utama alumni
     */
    public function index()
    {
        // Alumni featured
        $featuredAlumni = Alumni::with('universitas')
            ->featured()
            ->orderBy('tahun_lulus', 'desc')
            ->limit(6)
            ->get();
        
        // Statistik
        $stats = [
            'total' => Alumni::approved()->count(),
            'universitas' => Universitas::count(),
            'provinsi' => Alumni::approved()->whereNotNull('provinsi')->distinct('provinsi')->count('provinsi'),
        ];
        
        // Floating Alumni
        $floatingAlumni = Alumni::with('universitas')
            ->approved()
            ->whereNotNull('universitas_id')
            ->inRandomOrder()
            ->limit(16)
            ->get();
        
        return view('alumni.index', compact('featuredAlumni', 'stats', 'floatingAlumni'));
    }

    /**
     * Form pendaftaran alumni
     */
    public function create()
    {
        $universitasList = Universitas::orderBy('nama')->get();
        return view('alumni.create', compact('universitasList'));
    }

    /**
     * Simpan pendaftaran
     */
    public function store(Request $request)
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
            'instagram' => 'nullable|string|max:100',
            'testimoni' => 'nullable|string|max:500',
        ]);
        
        $validated['status'] = 'pending';
        
        // Geocoding sederhana
        if ($request->provinsi && $request->kota) {
            $coords = $this->geocode($request->provinsi . ', ' . $request->kota);
            if ($coords) {
                $validated['latitude'] = $coords['lat'];
                $validated['longitude'] = $coords['lng'];
            }
        }
        
        Alumni::create($validated);
        
        return redirect()->route('alumni.index')
            ->with('success', 'Terima kasih telah mendaftar! Data Anda akan diverifikasi oleh admin.');
    }

    /**
     * API data peta (dinonaktifkan, return kosong)
     */
    public function mapData()
    {
        return response()->json([]);
    }

    /**
     * Geocoding sederhana
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
            'Lampung' => ['lat' => -4.5585849, 'lng' => 105.4068079],
            'DKI Jakarta' => ['lat' => -6.2087634, 'lng' => 106.845599],
            'Jawa Barat' => ['lat' => -6.9174639, 'lng' => 107.6191228],
            'Jawa Tengah' => ['lat' => -7.150975, 'lng' => 110.1402594],
            'DI Yogyakarta' => ['lat' => -7.7955798, 'lng' => 110.3694896],
            'Jawa Timur' => ['lat' => -7.5360639, 'lng' => 112.2384017],
            'Bali' => ['lat' => -8.4095178, 'lng' => 115.188916],
            'Kalimantan Selatan' => ['lat' => -3.0926415, 'lng' => 115.2837585],
            'Kalimantan Timur' => ['lat' => 1.6406296, 'lng' => 116.419389],
            'Sulawesi Selatan' => ['lat' => -3.6687994, 'lng' => 119.9740534],
            'Sulawesi Utara' => ['lat' => 0.6246932, 'lng' => 123.9750018],
            'Papua' => ['lat' => -4.269928, 'lng' => 138.0803529],
        ];
        
        foreach ($provinsiCoords as $provinsi => $coords) {
            if (stripos($address, $provinsi) !== false) {
                return $coords;
            }
        }
        
        return ['lat' => -6.2087634, 'lng' => 106.845599];
    }
}