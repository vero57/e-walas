<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kepsek;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KepsekRombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
      $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kurikulum yang sedang login

      // Periksa apakah session 'kurikulum_id' ada
      if (!session()->has('kepsek_id')) {
          return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
      }

      // Ambil data kurikulum berdasarkan 'kepsek_id' yang ada di session
      $kepsek = Kepsek::find(session('kepsek_id'));
      
      // Periksa apakah data kurikulum ditemukan
      if (!$kepsek) {
          return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
      }

      $vwrombels = DB::table('vwrombels')->get();

      return view('homepagekepsek.rombel.index', compact('kepsek', 'vwrombels'));
        
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
    public function showDetailKepsek($walas_id)
    {
      // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
      $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kurikulum yang sedang login

      // Periksa apakah session 'kurikulum_id' ada
      if (!session()->has('kepsek_id')) {
          return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
      }

      // Ambil data kurikulum berdasarkan 'kepsek_id' yang ada di session
      $kepsek = Kepsek::find(session('kepsek_id'));
      
      // Periksa apakah data kurikulum ditemukan
      if (!$kepsek) {
          return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
      }
        $rombel = Rombel::where('walas_id', $walas_id)
                        ->with('walas') // Pastikan relasi 'walas' sudah didefinisikan di model
                        ->first();

        // Jika rombel tidak ditemukan atau tidak sesuai dengan kompetensi kakom
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan atau kompetensi tidak cocok.');
        }

        // Ambil data siswa berdasarkan rombel_id yang ditemukan
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        // Ambil informasi wali kelas dari rombel yang dipilih
        $walas = $rombel->walas; // Menggunakan relasi langsung dari model

        // Ambil semua data rombels untuk kebutuhan lainnya
        $rombels = Rombel::all(); // Hanya ambil rombel sesuai kompetensi kakom

        // Kirim data ke view
        return view('homepagekepsek.rombel.view', compact('siswas', 'walas', 'rombel', 'rombels'));
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
