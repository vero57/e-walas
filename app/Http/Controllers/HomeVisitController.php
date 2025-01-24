<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use Illuminate\Http\Request;
use App\Models\HomeVisit;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class HomeVisitController extends Controller
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
     $homevisit = HomeVisit::where('walas_id', $walas->id)->get();

    // Return view dengan data yang difilter
    return view("admwalas.homevisit.index", compact('homevisit', 'walas'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    // Ambil data walas berdasarkan 'walas_id' yang ada di session
    $walas_id = session('walas_id');
    $walas = Walas::where('id', $walas_id)->get(); // Ambil hanya data sesuai walas_id

    $homevisit = HomeVisit::all();
    return view('admwalas.homevisit.create', compact('homevisit', 'walas'));
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
    HomeVisit::create([
        'walas_id' => $request->walas_id,
        'image_url' => $filePath, // simpan path file di database
    ]);

    // redirect dengan pesan sukses
    return redirect('/homevisit')->with('success', 'Data berhasil disimpan!');
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
        $homevisit = HomeVisit::findOrFail($id);
    
        return view('admwalas.homevisit.edit', compact('homevisit', 'walas'));
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
    $homevisit = HomeVisit::findOrFail($id);

    // simpan file baru jika ada
    if ($request->hasFile('image_url')) {
        // hapus file lama
        if ($homevisit->image_url && Storage::disk('public')->exists($homevisit->image_url)) {
            Storage::disk('public')->delete($homevisit->image_url);
        }

        // simpan file baru
        $filePath = $request->file('image_url')->store('homevisit/photos', 'public');
        $homevisit->image_url = $filePath;
    }

    // update data lainnya
    $homevisit->walas_id = $request->walas_id;
    $homevisit->save();

    // redirect dengan pesan sukses
    return redirect('/homevisit')->with('success', 'Data berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function hapushomevisit(string $id)
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

     // Periksa apakah session 'walas_id' ada
     if (!session()->has('walas_id')) {
         return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
     }

     // Ambil data walas berdasarkan 'walas_id' yang ada di session
     $walas = Walas::find(session('walas_id'));

        $homevisit = HomeVisit::find($id);
        if ($homevisit) {
            $homevisit->delete();
            return redirect('/homevisit')->with('success', 'Data Berhasil Dihapus ');
        }
        return redirect('/homevisit')->with('error', 'Data not found!');
    }
}
