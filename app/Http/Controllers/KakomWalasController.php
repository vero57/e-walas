<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Kakom;
use Illuminate\Support\Facades\Auth;

class KakomWalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
       $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login
    
       // Periksa apakah session 'kakom_id' ada
       if (!session()->has('kakom_id')) {
           return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
       }
 
       // Ambil data kurikulum berdasarkan 'kakom_id' yang ada di session
       $kakom = Kakom::find(session('kakom_id'));
       
       // Periksa apakah data kurikulum ditemukan
       if (!$kakom) {
           return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
       }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

       // Ambil kompetensi kakom yang sedang login
        $kompetensi_kakom = $kakom->kompetensi;

        // Ambil semua rombel yang memiliki kompetensi yang sama dengan kakom yang login
        $rombels = Rombel::where('kompetensi', $kompetensi_kakom)->with('walas')->get();

        // Ambil daftar walas dari semua rombel, hindari duplikasi dengan unique()
        $walasList = $rombels->pluck('walas')->filter()->unique('id');

        // Kirim data ke view
        return view('homepagekaprog.datawalas', compact('rombels', 'kakom', 'kompetensi_kakom', 'walasList'));
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
