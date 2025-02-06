<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Kepsek;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StrukturOrganisasiKelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class StrukturOrganisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
{
    // Pastikan user login sebagai walas
    if (!session()->has('walas_id')) {
        return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data walas yang sedang login
    $walaslogin = Walas::find(session('walas_id'));

    // Jika data walas tidak ditemukan, redirect ke halaman login
    if (!$walaslogin) {
        return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
    }

    // Ambil data rombel berdasarkan walas yang login
    $rombel = Rombel::where('walas_id', $walaslogin->id)->first();
    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
    }

    // **Filter data dari View berdasarkan nama wali kelas yang login**
    $struktur = DB::table('vwstrukturorganisasi')
        ->where('wali_kelas', $walaslogin->nama) // Filter berdasarkan nama walas yang login
        ->get();

    // **Export PDF**
    if ($request->get('export') == 'pdf') {
        if ($struktur->isEmpty()) {
            return redirect()->route('strukturorganisasi.index')->with('error', 'Data tidak tersedia untuk diunduh.');
        }

        $pdf = Pdf::loadView('pdf.strukturorganisasi', ['struktur' => $struktur]);
        return $pdf->stream('Struktur_Organisasi.pdf');
    }

    return view("admwalas.strukturorganisasi.index", compact('struktur', 'walaslogin', 'rombel'));
}

     
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
     // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walaslogin = Auth::guard('walas')->user();

     // Periksa apakah session 'walas_id' ada
     if (!session()->has('walas_id')) {
         return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
     }
 
     // Ambil data walas berdasarkan 'walas_id' yang ada di session
     $walaslogin = Walas::find(session('walas_id'));
 
     // Periksa apakah data walas ditemukan
     if (!$walaslogin) {
         return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
     }
 
     // Ambil data rombel yang dimiliki walas yang sedang login
     $rombel = Rombel::where('walas_id', $walaslogin->id)->first();
 
     // Periksa apakah rombel ditemukan
     if (!$rombel) {
         return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
     }
    // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
    $siswa = Siswa::where('rombels_id', $rombel->id)->get();
    $kepsek = Kepsek::all();
    $walas = Walas::all();
    return view('admwalas.strukturorganisasi.create', compact('siswa', 'kepsek', 'walaslogin', 'walas'));
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
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walaslogin = Auth::guard('walas')->user();

     // Periksa apakah session 'walas_id' ada
     if (!session()->has('walas_id')) {
         return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
     }
 
     // Ambil data walas berdasarkan 'walas_id' yang ada di session
     $walaslogin = Walas::find(session('walas_id'));
 
     // Periksa apakah data walas ditemukan
     if (!$walaslogin) {
         return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
     }
 
     // Ambil data rombel yang dimiliki walas yang sedang login
     $rombel = Rombel::where('walas_id', $walaslogin->id)->first();
 
     // Periksa apakah rombel ditemukan
     if (!$rombel) {
         return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
     }

        $struktur = StrukturOrganisasiKelas::findOrFail($id);
        $siswa = Siswa::where('rombels_id', $rombel->id)->get();
        $kepsek = Kepsek::all();
        $walas = Walas::all();
        return view('admwalas.strukturorganisasi.edit', compact('siswa', 'kepsek', 'walas', 'struktur', 'walaslogin', 'rombel'));
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
