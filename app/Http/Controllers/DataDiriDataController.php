<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;
use App\Models\BiodataSiswa;

class DataDiriDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil siswa yang sedang login
        $siswa = Auth::guard('siswas')->user();
    
        // Periksa apakah session 'siswa_id' ada
        if (!session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data siswa berdasarkan 'siswa_id' yang ada di session
        $siswa = Siswa::find(session('siswa_id'));
    
        // Periksa apakah data siswa ditemukan
        if (!$siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }
    
        // Ambil data biodata hanya untuk siswa yang sedang login
        $biodatas = BiodataSiswa::where('siswas_id', $siswa->id)->get();
    
        // Kirim data ke view
        return view('homepagesiswa.inputdatadiri.page', compact('biodatas'));
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
