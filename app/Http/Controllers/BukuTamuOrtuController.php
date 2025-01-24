<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use Illuminate\Http\Request;
use App\Models\BukuTamuOrangtua;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BukuTamuOrtuController extends Controller
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
     $bukutamuortu = BukuTamuorangtua::where('walas_id', $walas->id)->get();

    // Return view dengan data yang difilter
    return view("admwalas.bukutamuortu.index", compact('bukutamuortu', 'walas'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Ambil data walas berdasarkan 'walas_id' yang ada di session
    $walas_id = session('walas_id');
    $walas = Walas::where('id', $walas_id)->get(); // Ambil hanya data sesuai walas_id

    $bukutamuortu = BukuTamuOrangtua::all();
    return view('admwalas.bukutamuortu.create', compact('bukutamuortu', 'walas'));
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
        $filePath = $request->file('image_url')->store('homevisit/Photos', 'public'); // simpan di storage/app/public/images
        
    }

    // simpan data ke database
    BukuTamuOrangtua::create([
        'walas_id' => $request->walas_id,
        'image_url' => $filePath, // simpan path file di database
    ]);

    // redirect dengan pesan sukses
    return redirect('/bukutamuortu')->with('success', 'Data berhasil disimpan!');
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
        $bukutamuortu = BukuTamuOrangtua::findOrFail($id);
    
        return view('admwalas.bukutamuortu.edit', compact('bukutamuortu', 'walas'));
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
    $bukutamuortu = BukuTamuOrangtua::findOrFail($id);

    // simpan file baru jika ada
    if ($request->hasFile('image_url')) {
        // hapus file lama
        if ($bukutamuortu->image_url && Storage::disk('public')->exists($bukutamuortu->image_url)) {
            Storage::disk('public')->delete($bukutamuortu->image_url);
        }

        // simpan file baru
        $filePath = $request->file('image_url')->store('bukutamu/photos', 'public');
        $bukutamuortu->image_url = $filePath;
    }

    // update data lainnya
    $bukutamuortu->walas_id = $request->walas_id;
    $bukutamuortu->save();

    // redirect dengan pesan sukses
    return redirect('/bukutamuortu')->with('success', 'Data berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function hapusbukutamuortu(string $id)
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

     // Periksa apakah session 'walas_id' ada
     if (!session()->has('walas_id')) {
         return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
     }

     // Ambil data walas berdasarkan 'walas_id' yang ada di session
     $walas = Walas::find(session('walas_id'));

        $bukutamuortu = BukuTamuOrangtua::find($id);
        if ($bukutamuortu) {
            $bukutamuortu->delete();
            return redirect('/bukutamuortu')->with('success', 'Data Berhasil Dihapus ');
        }
        return redirect('/bukutamuortu')->with('error', 'Data not found!');
    }
}
