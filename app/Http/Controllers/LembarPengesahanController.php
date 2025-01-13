<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use Illuminate\Http\Request;
use App\Models\LembarPengesahan;
use Illuminate\Support\Facades\Storage;

class LembarPengesahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lembarpengesahan = LembarPengesahan::all();
        return view("admwalas.lembarpengesahan.index" , compact('lembarpengesahan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $walas = Walas::all();
        $lembarpengesahan = LembarPengesahan::all();
        return view('admwalas.lembarpengesahan.create', compact('lembarpengesahan', 'walas'));
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    // validasi input
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar
    ]);

    // simpan file ke storage
    if ($request->hasFile('image_url')) {
        $filePath = $request->file('image_url')->store('images/photos', 'public'); // simpan di storage/app/public/images
        
    }

    // simpan data ke database
    LembarPengesahan::create([
        'walas_id' => $request->walas_id,
        'image_url' => $filePath, // simpan path file di database
    ]);

    // redirect dengan pesan sukses
    return redirect()->route('lembarpengesahan.index')->with('success', 'Data berhasil disimpan!');
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
    public function edit($id)
{
    // ambil data berdasarkan id
    $lembarpengesahan = LembarPengesahan::findOrFail($id);
    $walas = Walas::all(); // untuk dropdown wali kelas

    return view('admwalas.lembarpengesahan.edit', compact('lembarpengesahan', 'walas'));
}

public function update(Request $request, $id)
{
    // validasi input
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar
    ]);

    // ambil data lama
    $lembarpengesahan = LembarPengesahan::findOrFail($id);

    // simpan file baru jika ada
    if ($request->hasFile('image_url')) {
        // hapus file lama
        if ($lembarpengesahan->image_url && Storage::disk('public')->exists($lembarpengesahan->image_url)) {
            Storage::disk('public')->delete($lembarpengesahan->image_url);
        }

        // simpan file baru
        $filePath = $request->file('image_url')->store('images/photos', 'public');
        $lembarpengesahan->image_url = $filePath;
    }

    // update data lainnya
    $lembarpengesahan->walas_id = $request->walas_id;
    $lembarpengesahan->save();

    // redirect dengan pesan sukses
    return redirect()->route('lembarpengesahan.index')->with('success', 'Data berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
