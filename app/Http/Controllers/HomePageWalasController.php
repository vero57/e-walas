<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use Illuminate\Support\Facades\Auth;


class HomePageWalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
       $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));
        
        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Kirim data walas ke view
        return view('homepagegtk.index', compact('walas'));
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
