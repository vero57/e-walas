<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Siswa;
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
     // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walaslogin = Auth::guard('walas')->user();

     // Periksa apakah session 'walas_id' ada
     if (!session()->has('walas_id')) {
         return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
     }
 
     // Ambil data walas berdasarkan 'walas_id' yang ada di session
     $walaslogin = Walas::find(session('walas_id'));
 
     // Periksa apakah data walas ditemukan
     if (!$walaslogin) {
         return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
     }
     
     // Ambil data rombel berdasarkan 'walas_id'
     $rombel = Rombel::where('walas_id', $walaslogin->id)->first();
        
     // Periksa apakah rombel ditemukan
     if (!$rombel) {
         return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
     }
 
     // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
     $siswas = Siswa::where('rombels_id', $rombel->id)->get();
     
     // Ambil data walas berdasarkan id walaslogin
     $walas = Walas::where('id', $walaslogin->id)->get(); // Perbaiki sini

    // Ambil data BukuTamuOrangtua
    $bukutamuortu = BukuTamuOrangtua::all();
    
    return view('admwalas.bukutamuortu.create', compact('bukutamuortu', 'rombel', 'siswas', 'walaslogin', 'walas'));
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
     
         // Validasi input
         $request->validate([
             'walas_id' => 'required|exists:walas,id',
             'tanggal' => 'required|date', // Validasi untuk tanggal
             'nama_peserta_didik' => 'required|string|max:255', // Validasi nama peserta didik
             'tindak_lanjut' => 'required|string', // Validasi tindak lanjut
             'kasus' => 'required|string', // Validasi kasus
             'solusi' => 'required|string', // Validasi solusi
             'dokumentasi_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
         ]);
     
         // Simpan file ke storage
         if ($request->hasFile('dokumentasi_url')) {
             $filePath = $request->file('dokumentasi_url')->store('homevisit/Photos', 'public'); // Simpan di storage/app/public/images
         }
     
         // Simpan data ke database
         BukuTamuOrangtua::create([
             'walas_id' => $request->walas_id,
             'tanggal' => $request->tanggal,
             'nama_peserta_didik' => $request->nama_peserta_didik,
             'tindak_lanjut' => $request->tindak_lanjut,
             'kasus' => $request->kasus,
             'solusi' => $request->solusi,
             'dokumentasi_url' => $filePath, // Simpan path file di database
         ]);
     
         // Redirect dengan pesan sukses
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
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walaslogin = Auth::guard('walas')->user();

     // Periksa apakah session 'walas_id' ada
     if (!session()->has('walas_id')) {
         return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
     }
 
     // Ambil data walas berdasarkan 'walas_id' yang ada di session
     $walaslogin = Walas::find(session('walas_id'));
 
     // Periksa apakah data walas ditemukan
     if (!$walaslogin) {
         return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
     }
     
     // Ambil data rombel berdasarkan 'walas_id'
     $rombel = Rombel::where('walas_id', $walaslogin->id)->first();
        
     // Periksa apakah rombel ditemukan
     if (!$rombel) {
         return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
     }
 
     // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
     $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas_id = session('walas_id');
        $walas = Walas::where('id', $walas_id)->get(); // Ambil hanya data sesuai walas_id
    
        // Ambil data berdasarkan id
        $bukutamuortu = BukuTamuOrangtua::findOrFail($id);
    
        return view('admwalas.bukutamuortu.edit', compact('bukutamuortu', 'walas', 'walaslogin', 'siswas', 'rombel'));
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

    // Validasi input
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'nama_peserta_didik' => 'required',
        'tanggal' => 'required',
        'kasus' => 'required',
        'solusi' => 'required',
        'tindak_lanjut' => 'required',
        'dokumentasi_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar, nullable agar tidak harus upload ulang jika tidak ada perubahan
    ]);

    // Ambil data HomeVisit berdasarkan ID
    $bukutamuortu = BukuTamuOrangtua::findOrFail($id);

    if ($request->hasFile('dokumentasi_url')) {
        // Hapus file yang lama jika ada
        if ($bukutamuortu->dokumentasi_url && Storage::exists('public/' . $bukutamuortu->dokumentasi_url)) {
            Storage::delete('public/' . $bukutamuortu->dokumentasi_url);
        }
        $dokumentasiPath = $request->file('dokumentasi_url')->store('bukutamu/Photos', 'public');  // simpan di storage/app/public/images
    } else {
        $dokumentasiPath = $bukutamuortu->dokumentasi_url;  // Jika tidak ada perubahan, gunakan file lama
    }

    // Update data HomeVisit
    $bukutamuortu->update([
        'walas_id' => $request->walas_id,
        'nama_peserta_didik' => $request->nama_peserta_didik,
        'tanggal' => $request->tanggal,
        'kasus' => $request->kasus,
        'solusi' => $request->solusi,
        'tindak_lanjut' => $request->tindak_lanjut,
        'dokumentasi_url' => $dokumentasiPath,
    ]);

    // Redirect dengan pesan sukses
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
