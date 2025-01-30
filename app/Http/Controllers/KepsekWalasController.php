<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Kepsek;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class KepsekWalasController extends Controller
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

    // Kirim data siswa, rombels, dan walas ke view
    return view("homepagekepsek.datawalas", compact('kepsek'));
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
