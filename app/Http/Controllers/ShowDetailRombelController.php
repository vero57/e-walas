<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Walas;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Imports\RombelImport;
use Maatwebsite\Excel\Facades\Excel;

class ShowDetailRombelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showDetail($walas_id)
    {
        $rombel = Rombel::where('walas_id', $walas_id)->with('walas')->first();
    
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan untuk wali kelas ini.');
        }
    
        // Ambil data siswa berdasarkan rombel_id
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
    
        // Data wali kelas
        $walas = Rombel::where('walas_id', $walas_id)->with('walas')->get();
        // Ambil semua data rombels
       $rombels = Rombel::all();
    
        return view('homepageadmin.siswadata.datarombel', compact('siswas', 'walas', 'rombel', 'rombels'));
    }

    public function importsiswaadmin(Request $request){
        Excel::import(new SiswaImport, $request->file('file'));
        return back();
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_siswa.xlsx'); // Sesuaikan dengan lokasi file template Excel
        return response()->download($pathToFile);
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
