<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kakom;
use App\Imports\KakomImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KakomDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kakom = Kakom::all();
        return view('homepageadmin.kakomdata.index', compact('kakom'));
    }

    public function import(Request $request){
        Excel::import(new KakomImport, $request->file('file'));
    return redirect('/kakom');
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_kakom.xlsx'); // Sesuaikan dengan lokasi file template Excel
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
