<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\Rombel;
use App\Models\Walas;
use App\Models\Admin;
use App\Models\Kepsek;
use App\Models\Kurikulum;
use App\Models\KeluarRombel;
use Illuminate\Support\Facades\Auth;

class KeluarRombelViewKurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $kurikulum = Auth::guard('kurikulums')->user();  // ini akan mendapatkan data siswa yang sedang login
       
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('kurikulum_id')) {
            return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
        }
   
        // Ambil data berdasarkan 'id' yang ada di session
        $kurikulum = Kurikulum::find(session('kurikulum_id'));
        
        // Periksa apakah data siswa ditemukan
        if (!$kurikulum) {
            return redirect('/loginkurikulum')->with('error', 'Data kurikulum tidak ditemukan.');
        }

       // Ambil data KeluarRombel dengan siswa dan rombel
        $keluarrombel = KeluarRombel::with(['siswa.rombel'])->get();

        // Kelompokkan data berdasarkan nama_kelas
        $kelasGroup = $keluarrombel->groupBy(function ($item) {
            return $item->siswa->rombel->nama_kelas ?? 'Tidak Ada Kelas';
        });

        return view('homepagekurikulum.keluarrombel.index', compact('kurikulum', 'kelasGroup'));
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
    public function showSiswaKeluarRombelKurikulum(string $id)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $kurikulum = Auth::guard('kurikulums')->user();  // ini akan mendapatkan data siswa yang sedang login
       
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('kurikulum_id')) {
            return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
        }
   
        // Ambil data berdasarkan 'id' yang ada di session
        $kurikulum = Kurikulum::find(session('kurikulum_id'));
        
        // Periksa apakah data siswa ditemukan
        if (!$kurikulum) {
            return redirect('/loginkurikulum')->with('error', 'Data kurikulum tidak ditemukan.');
        }

        // Ambil data KeluarRombel berdasarkan rombel_id yang dipilih
        $keluarrombel = KeluarRombel::with(['siswa.rombel'])->where('rombels_id', $id)->get();

        // Kelompokkan berdasarkan nama_kelas
        $kelasGroup = $keluarrombel->groupBy(function ($item) {
            return $item->siswa->rombel->nama_kelas ?? 'Tidak Ada Kelas';
        });

        return view('homepagekurikulum.keluarrombel.show', compact('kurikulum', 'kelasGroup'));
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
