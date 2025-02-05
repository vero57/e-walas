<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Walas;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Imports\RombelImport;
use Maatwebsite\Excel\Facades\Excel;

class DetailKelasKaprogController extends Controller
{
    public function showDetail($walas_id)
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

        // Pastikan walas_id yang dipilih sesuai dengan kompetensi kakom
        $kompetensi_kakom = $kakom->kompetensi;
        $rombel = Rombel::where('walas_id', $walas_id)
                        ->where('kompetensi', $kompetensi_kakom)
                        ->with('walas')
                        ->first();

        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan untuk wali kelas ini atau kompetensi tidak cocok.');
        }

        // Ambil data siswa berdasarkan rombel_id
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        // Data wali kelas
        $walas = Rombel::where('walas_id', $walas_id)->with('walas')->first();

        // Ambil semua data rombels untuk kebutuhan lainnya
        $rombels = Rombel::all();

        return view('homepagegtk.rombel.index', compact('siswas', 'walas', 'rombel', 'rombels'));
    }

}
