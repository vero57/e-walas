<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kurikulum;
use App\Models\PrestasiSiswa;
use App\Models\RekapitulasiJumlahSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiSiswaController extends Controller
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
        
        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();
        
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }
        
        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        
        // Ambil data rekapitulasi jumlah siswa berdasarkan walas_id tanpa relasi siswa
        $prestasisiswa = PrestasiSiswa::where('walas_id', $walas->id)->get();

        // Kirim data walas, siswa, dan rekapitulasi jumlah siswa ke view
        return view('admwalas.prestasisiswa.index', compact('walas', 'prestasisiswa', 'siswas'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
        
        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();
        
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }
        
        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();


        // Kirim data ke view
        return view('admwalas.prestasisiswa.create', compact('walas', 'siswas', 'rombel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        // Validasi input
        $validatedData = $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'required|exists:siswas,id', // Pastikan siswa valid
            'rombels_id' => 'required',
            'jenis_prestasi' => 'required',
            'nama_prestasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'sertifikat_url' => 'nullable',
            'dokumentasi_url' => 'nullable',
        ]);

        // Simpan file ke storage
        if ($request->hasFile('sertifikat_url')) {
            $sertifikatPath = $request->file('sertifikat_url')->store('prestasisiswa/Photos', 'public'); // Simpan di storage/app/public/images
        }

         // Simpan file ke storage
         if ($request->hasFile('dokumentasi_url')) {
            $dokumentasiPath = $request->file('dokumentasi_url')->store('prestasisiswa/Photos', 'public'); // Simpan di storage/app/public/images
        }

        // Simpan data ke database
        PrestasiSiswa::create([
            'walas_id' => $request->walas_id,
            'siswas_id' => $request->siswas_id,
            'rombels_id' => $request->rombels_id,
            'jenis_prestasi' => $request->jenis_prestasi,
            'nama_prestasi' => $request->nama_prestasi,
            'tanggal' => $request->tanggal,
            'sertifikat_url' => $sertifikatPath,
            'dokumentasi_url' => $dokumentasiPath, // Simpan path file di database
        ]);

        return redirect('/prestasisiswa')->with('success', 'Data berhasil disimpan.');
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
        
        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();
        
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }
        
        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();

        $prestasisiswa = PrestasiSiswa::findOrFail($id);

        // Kirim data ke view
        return view('admwalas.prestasisiswa.edit', compact('walas', 'rombel', 'prestasisiswa', 'siswas'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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

    // Ambil data DaftarPesertaDidik yang akan diedit
    $prestasisiswa = PrestasiSiswa::findOrFail($id);

    // Validasi input
    $validatedData = $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'siswas_id' => 'required|exists:siswas,id', // Pastikan siswa valid
        'rombels_id' => 'required',
        'jenis_prestasi' => 'required',
        'nama_prestasi' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'sertifikat_url' => 'nullable',
        'dokumentasi_url' => 'nullable',
    ]);

    if ($request->hasFile('sertifikat_url')) {
        // Hapus file yang lama jika ada
        if ($prestasisiswa->sertifikat_url && Storage::exists('public/' . $prestasisiswa->sertifikat_url)) {
            Storage::delete('public/' . $prestasisiswa->sertifikat_url);
        }
        $sertifikatPath = $request->file('sertifikat_url')->store('prestasisiswa/Photos', 'public');  // simpan di storage/app/public/images
    } else {
        $sertifikatPath = $prestasisiswa->sertifikat_url;  // Jika tidak ada perubahan, gunakan file lama
    }

    if ($request->hasFile('dokumentasi_url')) {
        // Hapus file yang lama jika ada
        if ($prestasisiswa->dokumentasi_url && Storage::exists('public/' . $prestasisiswa->dokumentasi_url)) {
            Storage::delete('public/' . $prestasisiswa->dokumentasi_url);
        }
        $dokumentasiPath = $request->file('dokumentasi_url')->store('prestasisiswa/Photos', 'public');  // simpan di storage/app/public/images
    } else {
        $dokumentasiPath = $prestasisiswa->dokumentasi_url;  // Jika tidak ada perubahan, gunakan file lama
    }

    // Update data HomeVisit
    $prestasisiswa->update([
        '   walas_id' => $request->walas_id,
            'siswas_id' => $request->siswas_id,
            'rombels_id' => $request->rombels_id,
            'jenis_prestasi' => $request->jenis_prestasi,
            'nama_prestasi' => $request->nama_prestasi,
            'tanggal' => $request->tanggal,
            'sertifikat_url' => $sertifikatPath,
            'dokumentasi_url' => $dokumentasiPath, // 
    ]);


    return redirect('/prestasisiswa')->with('success', 'Data berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function hapusrekapjumlahsiswa(string $id)
    {
        $prestasisiswa = RekapitulasiJumlahSiswa::find($id);
        if ($prestasisiswa) {
            $prestasisiswa->delete();
            return redirect('/rekapjumlahsiswa')->with('success', 'Data Rekaptiulasi Berhasil Dihapus ');
        }
        return redirect('/rekapjumlahsiswa')->with('error', 'Data Rekapitulasi not found!');
    }
}
