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
use App\Models\Kakom;
use App\Models\KeluarRombel;
use Illuminate\Support\Facades\Auth;

class KeluarRombelViewKakomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkakom')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom yang sedang login
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkakom')->with('error', 'Data kakom tidak ditemukan.');
        }

        // Ambil kompetensi dari kakom yang login
        $kompetensi = $kakom->kompetensi;

        // Ambil ID rombels yang memiliki kompetensi yang sama dengan kakom
        $rombelIds = Rombel::where('kompetensi', $kompetensi)->pluck('id');

        // Ambil hanya data KeluarRombel yang memiliki siswa dalam rombel yang sesuai
        $keluarrombel = KeluarRombel::whereHas('siswa', function ($query) use ($rombelIds) {
            $query->whereIn('rombels_id', $rombelIds);
        })->with(['siswa.rombel'])->get();

        // Kelompokkan data berdasarkan nama_kelas
        $kelasGroup = $keluarrombel->groupBy(function ($item) {
            return $item->siswa->rombel->nama_kelas ?? 'Tidak Ada Kelas';
        });

        return view('homepagekaprog.keluarrombel.index', compact('kakom', 'kelasGroup'));
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
    public function showSiswaKeluarRombelKakom(string $id)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data siswa yang sedang login
       
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkakom')->with('error', 'Silakan login terlebih dahulu.');
        }
   
        // Ambil data berdasarkan 'id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));
        
        // Periksa apakah data siswa ditemukan
        if (!$kakom) {
            return redirect('/loginkakom')->with('error', 'Data kakom tidak ditemukan.');
        }

        // Ambil data KeluarRombel berdasarkan rombel_id yang dipilih
        $keluarrombel = KeluarRombel::with(['siswa.rombel'])->where('rombels_id', $id)->get();

        // Kelompokkan berdasarkan nama_kelas
        $kelasGroup = $keluarrombel->groupBy(function ($item) {
            return $item->siswa->rombel->nama_kelas ?? 'Tidak Ada Kelas';
        });

        return view('homepagekaprog.keluarrombel.show', compact('kakom', 'kelasGroup'));
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
