<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfilePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
            $siswa = Auth::guard('siswas')->user();  // ini akan mendapatkan data siswa yang sedang login
       
            // Periksa apakah session 'walas_id' ada
            if (!session()->has('siswa_id')) {
                return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
            }
       
            // Ambil data siswa berdasarkan 'walas_id' yang ada di session
            $siswa = Siswa::find(session('siswa_id'));
            
            // Periksa apakah data siswa ditemukan
            if (!$siswa) {
                return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
            }
       
          return view('profilesiswa.index', compact('siswa'));
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
