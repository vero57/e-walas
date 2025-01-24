<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\CatatanKasusSiswa;
use Illuminate\Support\Facades\Auth;

class CatatanKasusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Mengambil siswa yang sedang login
    $siswa = Auth::guard('siswas')->user();

    // Periksa apakah session 'siswa_id' ada
    if (!session()->has('siswa_id')) {
        return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data siswa berdasarkan 'siswa_id' yang ada di session
    $siswa = Siswa::find(session('siswa_id'));

    // Periksa apakah data siswa ditemukan
    if (!$siswa) {
        return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
    }

    // Ambil catatan kasus berdasarkan siswa_id yang sedang login
    $catatankasus = CatatanKasusSiswa::where('siswas_id', $siswa->id)->get();

    // Kirim data siswa dan catatan kasus ke view
    return view('homepagesiswa.catatankasus.index', compact('catatankasus', 'siswa'));
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
}
