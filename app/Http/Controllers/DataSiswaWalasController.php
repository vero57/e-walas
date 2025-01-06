<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Imports\SiswaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class DataSiswaWalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = DB::table('vwsiswas')->get();
        return view ("homepagegtk.siswadata", compact('siswa'));
    }

    public function import(Request $request){
        Excel::import(new SiswaImport, $request->file('file'));
    return redirect('/siswadata');
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
