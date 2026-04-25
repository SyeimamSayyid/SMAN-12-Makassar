<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Exports\PegawaiExportPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pegawai = Pegawai::orderBy('jabatan')->orderBy('nama')->paginate(10);
        return view('admin.pegawai.index', compact('pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pegawai.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:pegawai,nip',
            'jabatan' => 'required|in:Kepala Sekolah,Wakil Kepala Sekolah,Guru,Guru BK,Kepala Perpustakaan,Staff TU',
            'pangkat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nip.unique' => 'NIP sudah terdaftar!',
        ]);

        $validated['is_active'] = true;

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        Pegawai::create($validated);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai "' . $validated['nama'] . '" berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pegawai $pegawai)
    {
        return view('admin.pegawai.edit', compact('pegawai'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pegawai $pegawai)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:pegawai,nip,' . $pegawai->id,
            'jabatan' => 'required|in:Kepala Sekolah,Wakil Kepala Sekolah,Guru,Guru BK,Kepala Perpustakaan,Staff TU',
            'pangkat' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_active' => 'boolean',
        ], [
            'nip.unique' => 'NIP sudah terdaftar!',
        ]);

        if ($request->hasFile('foto')) {
            if ($pegawai->foto) {
                Storage::disk('public')->delete($pegawai->foto);
            }
            $validated['foto'] = $request->file('foto')->store('pegawai', 'public');
        }

        $validated['is_active'] = $request->has('is_active');

        $pegawai->update($validated);

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai "' . $pegawai->nama . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pegawai $pegawai)
    {
        if ($pegawai->foto) {
            Storage::disk('public')->delete($pegawai->foto);
        }
        
        $nama = $pegawai->nama;
        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai "' . $nama . '" berhasil dihapus!');
    }

    /**
     * Export PDF
     */
    public function exportPDF(Request $request)
    {
        $jabatan = $request->get('jabatan', 'all');
        
        $export = new PegawaiExportPDF($jabatan);
        return $export->download();
    }
}