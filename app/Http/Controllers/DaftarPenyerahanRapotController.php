<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use Illuminate\Http\Request;
use App\Models\DaftarSerahTerimaRapor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class DaftarPenyerahanRapotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
     // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walas = Auth::guard('walas')->user();

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
 
     // Ambil data kelompok berdasarkan 'walas_id'
     $penyerahanrapot = DaftarSerahTerimaRapor::where('walas_id', $walas->id)->get();

    // Return view dengan data yang difilter
    return view("admwalas.daftarpenyerahanrapot.index", compact('penyerahanrapot', 'walas'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Ambil data walas berdasarkan 'walas_id' yang ada di session
    $walas_id = session('walas_id');
    $walas = Walas::where('id', $walas_id)->get(); // Ambil hanya data sesuai walas_id

    $penyerahanrapot = DaftarSerahTerimaRapor::all();
    return view('admwalas.daftarpenyerahanrapot.create', compact('penyerahanrapot', 'walas'));
}

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
      // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
      $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

      // Periksa apakah session 'walas_id' ada
      if (!session()->has('walas_id')) {
          return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
      }
 
      // Ambil data walas berdasarkan 'walas_id' yang ada di session
      $walas = Walas::find(session('walas_id'));

    // validasi input
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar
    ]);

    // simpan file ke storage
    if ($request->hasFile('image_url')) {
        $filePath = $request->file('image_url')->store('penyerahanrapot/Photos', 'public'); // simpan di storage/app/public/images
        
    }

    // simpan data ke database
    DaftarSerahTerimaRapor::create([
        'walas_id' => $request->walas_id,
        'image_url' => $filePath, // simpan path file di database
    ]);

    // redirect dengan pesan sukses
    return redirect('/serahterimarapor')->with('success', 'Data berhasil disimpan!');
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
        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas_id = session('walas_id');
        $walas = Walas::where('id', $walas_id)->get(); // Ambil hanya data sesuai walas_id
    
        // Ambil data berdasarkan id
        $penyerahanrapot = DaftarSerahTerimaRapor::findOrFail($id);
    
        return view('admwalas.daftarpenyerahanrapot.edit', compact('penyerahanrapot', 'walas'));
    }
    
public function update(Request $request, $id)
{
      // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
      $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

      // Periksa apakah session 'walas_id' ada
      if (!session()->has('walas_id')) {
          return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
      }
 
      // Ambil data walas berdasarkan 'walas_id' yang ada di session
      $walas = Walas::find(session('walas_id'));

    // validasi input
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar
    ]);

    // ambil data lama
    $penyerahanrapot = DaftarSerahTerimaRapor::findOrFail($id);

    // simpan file baru jika ada
    if ($request->hasFile('image_url')) {
        // hapus file lama
        if ($penyerahanrapot->image_url && Storage::disk('public')->exists($penyerahanrapot->image_url)) {
            Storage::disk('public')->delete($penyerahanrapot->image_url);
        }

        // simpan file baru
        $filePath = $request->file('image_url')->store('penyerahanrapot/photos', 'public');
        $penyerahanrapot->image_url = $filePath;
    }

    // update data lainnya
    $penyerahanrapot->walas_id = $request->walas_id;
    $penyerahanrapot->save();

    // redirect dengan pesan sukses
    return redirect('/serahterimarapor')->with('success', 'Data berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function hapuspenyerahanrapot(string $id)
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

     // Periksa apakah session 'walas_id' ada
     if (!session()->has('walas_id')) {
         return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
     }

     // Ambil data walas berdasarkan 'walas_id' yang ada di session
     $walas = Walas::find(session('walas_id'));

        $penyerahanrapot = DaftarSerahTerimaRapor::find($id);
        if ($penyerahanrapot) {
            $penyerahanrapot->delete();
            return redirect('/serahterimarapor')->with('success', 'Data Berhasil Dihapus ');
        }
        return redirect('/serahterimarapor')->with('error', 'Data not found!');
    }
}
