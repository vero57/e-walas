<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kepsek;
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
