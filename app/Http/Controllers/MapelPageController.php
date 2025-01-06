<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Mapel;
use App\Imports\MapelImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MapelPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel = Mapel::all();
        return view('homepageadmin.mapeldata.index', compact('mapel'));
    }

    public function import(Request $request){
        Excel::import(new MapelImport, $request->file('file'));
    return redirect('/datamapel');
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_mapel.xlsx'); // Sesuaikan dengan lokasi file template Excel
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
