<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeluarRombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function saveKeterangan(Request $request)
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

     // Periksa apakah session 'walas_id' ada
     if (!session()->has('walas_id')) {
         return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
     }

     // Ambil data walas berdasarkan 'walas_id' yang ada di session
     $walas = Walas::find(session('walas_id'));
     
     // Periksa apakah data walas ditemukan
     if (!$walas) {
         return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
     }

    // Ambil rombel berdasarkan walas yang sedang login
        $rombel = Rombel::where('walas_id', $walas->id)->first();

        if (!$rombel) {
            return response()->json(['error' => 'Rombel tidak ditemukan untuk walas ini.'], 404);
        }

        // Validasi input
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'keterangan' => 'required|in:naik_kelas,tidak_naik_kelas,pindah_sekolah',
        ]);

        // Ambil nama siswa berdasarkan siswa_id yang dipilih
        $siswa = Siswa::find($request->siswa_id);

        // Buat data baru untuk KeluarRombel
        $keluarRombel = KeluarRombel::create([
            'nama_siswa' => $siswa->nama, // Nama siswa diambil dari database
            'keterangan' => $request->keterangan,
            'rombels_id' => $rombel->id, // Rombel diambil dari data rombel yang sesuai
        ]);

        return response()->json(['success' => 'Data berhasil disimpan!', 'keluarRombel' => $keluarRombel]);
    }
}
