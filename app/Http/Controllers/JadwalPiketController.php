<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Kurikulum;
use App\Models\JadwalPiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPiketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    $jadwalpiket = JadwalPiket::with(['siswa1', 'siswa2', 'siswa3', 'siswa4', 'siswa5'])->get();
    return view('admwalas.jadwalpiket.index', compact('jadwalpiket', 'walas'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
    
    $siswas = Siswa::all();
    $kurikulum = Kurikulum::all();
    return view('admwalas.jadwalpiket.create', compact('walas', 'siswas', 'kurikulum'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'hari1' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa1_id' => 'required|exists:siswas,id',
        'hari2' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa2_id' => 'required|exists:siswas,id',
        'hari3' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa3_id' => 'required|exists:siswas,id',
        'hari4' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa4_id' => 'required|exists:siswas,id',
        'hari5' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa5_id' => 'required|exists:siswas,id',
    ]);

    // Simpan data ke dalam tabel
    JadwalPiket::create([
        'walas_id' => $request->walas_id,
        'hari1' => $request->hari1,
        'siswa1_id' => $request->siswa1_id,
        'hari2' => $request->hari2,
        'siswa2_id' => $request->siswa2_id,
        'hari3' => $request->hari3,
        'siswa3_id' => $request->siswa3_id,
        'hari4' => $request->hari4,
        'siswa4_id' => $request->siswa4_id,
        'hari5' => $request->hari5,
        'siswa5_id' => $request->siswa5_id,
    ]);

    // Redirect ke halaman jadwal piket setelah berhasil menyimpan
    return redirect()->route('jadwalpiket.index')->with('success', 'Jadwal Piket berhasil disimpan.');
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
    public function edit($id)
{
    $jadwal = JadwalPiket::findOrFail($id);
    $walas = Walas::all();
    $siswas = Siswa::all();
    $kurikulum = Kurikulum::all();
    return view('admwalas.jadwalpiket.edit', compact('jadwal', 'walas', 'siswas', 'kurikulum'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validasi input
    $validated = $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'hari1' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa1_id' => 'required|exists:siswas,id',
        'hari2' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa2_id' => 'required|exists:siswas,id',
        'hari3' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa3_id' => 'required|exists:siswas,id',
        'hari4' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa4_id' => 'required|exists:siswas,id',
        'hari5' => 'required|in:senin,selasa,rabu,kamis,jumat',
        'siswa5_id' => 'required|exists:siswas,id',
    ]);

    // Temukan data jadwal piket yang akan diupdate
    $jadwal = JadwalPiket::findOrFail($id);

    // Update data
    $jadwal->update([
        'walas_id' => $request->walas_id,
        'hari1' => $request->hari1,
        'siswa1_id' => $request->siswa1_id,
        'hari2' => $request->hari2,
        'siswa2_id' => $request->siswa2_id,
        'hari3' => $request->hari3,
        'siswa3_id' => $request->siswa3_id,
        'hari4' => $request->hari4,
        'siswa4_id' => $request->siswa4_id,
        'hari5' => $request->hari5,
        'siswa5_id' => $request->siswa5_id,
    ]);

    // Redirect ke halaman jadwal piket setelah berhasil diupdate
    return redirect()->route('jadwalpiket.index')->with('success', 'Jadwal Piket berhasil diupdate.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
