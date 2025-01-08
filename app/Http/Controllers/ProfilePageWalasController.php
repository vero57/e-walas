<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfilePageWalasController extends Controller
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
       
           // Ambil data rombel yang dimiliki walas yang sedang login
           $rombel = Rombel::where('walas_id', $walas->id)->first();
       
           // Periksa apakah rombel ditemukan
           if (!$rombel) {
               return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
           }
       
           // Ambil data siswa berdasarkan rombel yang terkait dengan walas
           $siswa = DB::table('vwsiswas')
                       ->where('id', $rombel->id)  // Pastikan kolom yang digunakan sesuai dengan relasi rombel
                       ->get();
       
           // Ambil semua data rombels
           $rombels = Rombel::all();
  
          return view('profilewalas.index', compact('walas', 'rombel', 'siswa', 'rombels'));
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
