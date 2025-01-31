<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use Illuminate\Http\Request;
use App\Models\HomeVisit;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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

     // Ambil data rombel berdasarkan 'walas_id'
    $rombel = Rombel::where('walas_id', $walas->id)->first();
        
    // Periksa apakah rombel ditemukan
    if (!$rombel) {
        return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
    }

       // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
     $siswas = Siswa::where('rombels_id', $rombel->id)->get();

     if (request()->has('export') && request()->get('export') === 'pdf') {
        $pdf = Pdf::loadView('pdf.homevisit', compact('walas', 'homevisit', 'siswas', 'rombel'));
        return $pdf->stream('Home_Visit.pdf');
    }

    // Return view dengan data yang difilter
    return view("admwalas.homevisit.index", compact('homevisit', 'walas', 'siswas', 'rombel'));
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

    // Ambil data walas berdasarkan 'walas_id' yang ada di session
    $walas_id = session('walas_id');
    $walas = Walas::where('id', $walas_id)->get(); // Ambil hanya data sesuai walas_id

    $homevisit = HomeVisit::all();
    return view('admwalas.homevisit.create', compact('homevisit', 'walas', 'walaslogin', 'siswas'));
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
            'nama_peserta_didik' => 'required',
            'tanggal' => 'required',
            'kasus' => 'required',
            'solusi' => 'required',
            'tindak_lanjut' => 'required',
            'bukti_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar
            'dokumentasi_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar
        ]);

        // simpan file ke storage
        if ($request->hasFile('bukti_url')) {
            $buktiPath = $request->file('bukti_url')->store('homevisit/Photos', 'public'); // simpan di storage/app/public/images
            
        }
        
        // simpan file ke storage
        if ($request->hasFile('dokumentasi_url')) {
            $dokumentasiPath = $request->file('dokumentasi_url')->store('homevisit/Photos', 'public'); // simpan di storage/app/public/images
            
        }

        HomeVisit::create([
            'walas_id' => $request->walas_id,
            'nama_peserta_didik' => $request->nama_peserta_didik,
            'tanggal' => $request->tanggal,
            'kasus' => $request->kasus,
            'solusi' => $request->solusi,
            'tindak_lanjut' => $request->tindak_lanjut,
            'bukti_url' => $buktiPath,
            'dokumentasi_url' => $dokumentasiPath,
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

    // Ambil data home visit yang akan diedit
    $homevisit = HomeVisit::findOrFail($id);

    // Ambil data walas berdasarkan 'walas_id' yang ada di session
    $walas_id = session('walas_id');
    $walas = Walas::where('id', $walas_id)->get(); // Ambil hanya data sesuai walas_id

    return view('admwalas.homevisit.edit', compact('homevisit', 'walas', 'walaslogin', 'siswas'));
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
        'bukti_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar, nullable agar tidak harus upload ulang jika tidak ada perubahan
        'dokumentasi_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // validasi file gambar, nullable agar tidak harus upload ulang jika tidak ada perubahan
    ]);

    // Ambil data HomeVisit berdasarkan ID
    $homevisit = HomeVisit::findOrFail($id);

    // Simpan file ke storage jika ada perubahan file
    if ($request->hasFile('bukti_url')) {
        // Hapus file yang lama jika ada
        if ($homevisit->bukti_url && Storage::exists('public/' . $homevisit->bukti_url)) {
            Storage::delete('public/' . $homevisit->bukti_url);
        }
        $buktiPath = $request->file('bukti_url')->store('homevisit/Photos', 'public');  // simpan di storage/app/public/images
    } else {
        $buktiPath = $homevisit->bukti_url;  // Jika tidak ada perubahan, gunakan file lama
    }

    if ($request->hasFile('dokumentasi_url')) {
        // Hapus file yang lama jika ada
        if ($homevisit->dokumentasi_url && Storage::exists('public/' . $homevisit->dokumentasi_url)) {
            Storage::delete('public/' . $homevisit->dokumentasi_url);
        }
        $dokumentasiPath = $request->file('dokumentasi_url')->store('homevisit/Photos', 'public');  // simpan di storage/app/public/images
    } else {
        $dokumentasiPath = $homevisit->dokumentasi_url;  // Jika tidak ada perubahan, gunakan file lama
    }

    // Update data HomeVisit
    $homevisit->update([
        'walas_id' => $request->walas_id,
        'nama_peserta_didik' => $request->nama_peserta_didik,
        'tanggal' => $request->tanggal,
        'kasus' => $request->kasus,
        'solusi' => $request->solusi,
        'tindak_lanjut' => $request->tindak_lanjut,
        'bukti_url' => $buktiPath,
        'dokumentasi_url' => $dokumentasiPath,
    ]);

    // Redirect dengan pesan sukses
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
