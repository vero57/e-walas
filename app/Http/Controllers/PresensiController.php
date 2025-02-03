<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiController extends Controller
{
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

        // Ambil data catatan kasus berdasarkan walas_id dengan relasi siswa
        $presensis = Presensi::where('walas_id', $walas->id)
            ->get();
    

        return view('admwalas.presensi.index', compact('presensis', 'walas'));
    }

    public function create()
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

        return view('admwalas.presensi.create', compact('walas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'kelas' => 'required|string|max:255',
            'tanggal' => 'required|date',
        ]);

        Presensi::create($request->all());
        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil ditambahkan!');
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
