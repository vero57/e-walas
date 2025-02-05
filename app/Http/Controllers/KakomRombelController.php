<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rombel;
use App\Models\Kakom;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class KakomRombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kakom = Auth::guard('kakoms')->user();  // Mendapatkan data kakom yang sedang login
        
        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil kompetensi dari kakom yang sedang login
        $kompetensi_kakom = $kakom->kompetensi;

        // Ambil semua rombel yang memiliki kompetensi yang sama dengan kompetensi kakom yang sedang login
        $kompetensi = Rombel::where('kompetensi', $kompetensi_kakom)->get();

        // Ambil data walas_id berdasarkan kompetensi yang sama dengan kompetensi kakom
        $walasIds = $kompetensi->pluck('walas_id')->toArray();

        // Ambil data dari 'vwrombels' berdasarkan walas_id yang sesuai
        $vwrombels = DB::table('vwrombels')
                        ->whereIn('walas_id', $walasIds)
                        ->get();

        // Mengembalikan view dengan data yang telah difilter
        return view('homepagekaprog.rombel.index', compact('vwrombels', 'kakom', 'kompetensi_kakom', 'kompetensi', 'walasIds'));
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
    public function showDetail($walas_id)
    {
        $kakom = Auth::guard('kakoms')->user(); // Mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Pastikan walas_id yang dipilih sesuai dengan kompetensi kakom
        $kompetensi_kakom = $kakom->kompetensi;
        $rombel = Rombel::where('walas_id', $walas_id)
                        ->where('kompetensi', $kompetensi_kakom)
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
        $rombels = Rombel::where('kompetensi', $kompetensi_kakom)->get(); // Hanya ambil rombel sesuai kompetensi kakom

        // Kirim data ke view
        return view('homepagekaprog.rombel.view', compact('siswas', 'walas', 'rombel', 'rombels'));
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
