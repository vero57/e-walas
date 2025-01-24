<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Presensi;
use Illuminate\Http\Request;

class PresensiController extends Controller
{
    public function index()
    {
        $presensis = Presensi::all();
        return view('admwalas.presensi.index', compact('presensis'));
    }

    public function create()
    {
        $walas = Walas::all();
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
