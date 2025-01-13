<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Kepsek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StrukturOrganisasiKelas;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $struktur = DB::table('vwstrukturorganisasi')->first();
        return view("admwalas.strukturorganisasi.index" , compact('struktur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    $siswa = Siswa::all();
    $kepsek = Kepsek::all();
    $walas = Walas::all();
    return view('admwalas.strukturorganisasi.create', compact('siswa', 'kepsek', 'walas'));
}

public function store(Request $request)
{
    $validated = $request->validate([
        'walas_id' => 'required|string|max:255',
        'kepala_sekolah' => 'required|string|max:255',
        'walas' => 'required|string|max:255',
        'ketuakelas' => 'required|string|max:255',
        'waketuakelas' => 'required|string|max:255',
        'bendahara' => 'required|string|max:255',
        'sekretaris' => 'required|string|max:255',
        'seksi_kebersihan' => 'required|string|max:255',
        'seksi_perlengkapan' => 'required|string|max:255',
        'seksi_keamanan' => 'required|string|max:255',
        'seksi_kerohanian' => 'required|string|max:255',
    ]);

    StrukturOrganisasiKelas::create($validated);

    return redirect()->route('strukturorganisasi.index')->with('success', 'Struktur organisasi berhasil dibuat.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $struktur = StrukturOrganisasiKelas::findOrFail($id);
        $siswa = Siswa::all();
        $kepsek = Kepsek::all();
        $walas = Walas::all();
        return view('admwalas.strukturorganisasi.edit', compact('siswa', 'kepsek', 'walas', 'struktur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $struktur = StrukturOrganisasiKelas::findOrFail($id);
        $validated = $request->validate([
            'walas_id' => 'required|string|max:255',
            'kepala_sekolah' => 'required|string|max:255',
            'walas' => 'required|string|max:255',
            'ketuakelas' => 'required|string|max:255',
            'waketuakelas' => 'required|string|max:255',
            'bendahara' => 'required|string|max:255',
            'sekretaris' => 'required|string|max:255',
            'seksi_kebersihan' => 'required|string|max:255',
            'seksi_perlengkapan' => 'required|string|max:255',
            'seksi_keamanan' => 'required|string|max:255',
            'seksi_kerohanian' => 'required|string|max:255',
        ]);
        $struktur->update($validated);
        return redirect()->route('strukturorganisasi.index')->with('success', 'Struktur organisasi berhasil dibuat.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
