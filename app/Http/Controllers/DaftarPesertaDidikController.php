<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kurikulum;
use App\Models\DaftarPesertaDidik;
use Illuminate\Support\Facades\Auth;


class DaftarPesertaDidikController extends Controller
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
        
        // Ambil data catatan kasus berdasarkan walas_id dengan relasi siswa
        $daftarpdidik = DaftarPesertaDidik::where('walas_id', $walas->id)
            ->with('siswa')
            ->get();

        // Hitung jumlah jenis kelamin berdasarkan walas_id
        $jenisKelaminCount = $daftarpdidik->groupBy('jenis_kelamin')->map(function ($items) {
            return $items->count();
        });

        // Kirim data walas, siswa, catatan kasus, dan jenisKelaminCount ke view
        return view('admwalas.daftarpesertadidik.index', compact('walas', 'daftarpdidik', 'siswas', 'jenisKelaminCount'));
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

        // Ambil data siswa dengan relasi biodata siswa
        $siswas = Siswa::where('rombels_id', $rombel->id)
            ->with('biodataSiswa') // Asumsi ada relasi 'biodataSiswa' di model Siswa
            ->get();

        // Ambil ID pertama dari tabel kurikulums
        $kurikulumIdPertama = Kurikulum::first()->id ?? null;

        // Kirim data ke view
        return view('admwalas.daftarpesertadidik.create', compact('walas', 'siswas', 'rombel', 'kurikulumIdPertama'));
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

        // Ambil ID pertama dari tabel kurikulums
        $kurikulum = Kurikulum::first();
        $kurikulum_id = $kurikulum ? $kurikulum->id : null;

        // Validasi input
        $validatedData = $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'kurikulum_id' => 'required|integer',
            'nis' => 'required',
            'nisn' => 'required',
            'nama_siswa' => 'required|string|max:255',
            'keterangan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jenis_kelamin' => 'required',
            'ttdwalas_url' => 'nullable|url',
        ]);

        // Tambahkan kurikulum_id secara otomatis
        $validatedData['kurikulum_id'] = $kurikulum_id;

        // Simpan data ke database
        DaftarPesertaDidik::create($validatedData);

        return redirect('/daftarpesertadidik')->with('success', 'Data berhasil disimpan.');
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

        // Ambil data siswa dengan relasi biodata siswa
        $siswas = Siswa::where('rombels_id', $rombel->id)
            ->with('biodataSiswa') // Asumsi ada relasi 'biodataSiswa' di model Siswa
            ->get();

        // Ambil ID pertama dari tabel kurikulums
        $kurikulumIdPertama = Kurikulum::first()->id ?? null;

        $daftarPesertaDidik = DaftarPesertaDidik::findOrFail($id);

        // Kirim data ke view
        return view('admwalas.daftarpesertadidik.edit', compact('walas', 'siswas', 'rombel', 'kurikulumIdPertama', 'daftarPesertaDidik'));
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
    $daftarPesertaDidik = DaftarPesertaDidik::findOrFail($id);

    // Ambil ID pertama dari tabel kurikulums
    $kurikulum = Kurikulum::first();
    $kurikulum_id = $kurikulum ? $kurikulum->id : null;

    // Validasi input
    $validatedData = $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'kurikulum_id' => 'required|integer',
        'nis' => 'required',
        'nisn' => 'required',
        'nama_siswa' => 'required|string|max:255',
        'keterangan' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'jenis_kelamin' => 'required',
        'ttdwalas_url' => 'nullable|url',
    ]);

    // Tambahkan kurikulum_id secara otomatis
    $validatedData['kurikulum_id'] = $kurikulum_id;

    // Update data DaftarPesertaDidik
    $daftarPesertaDidik->update($validatedData);

    return redirect('/daftarpesertadidik')->with('success', 'Data berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function hapusdaftarpesertadidik(string $id)
    {
        $daftarpdidik = DaftarPesertaDidik::find($id);
        if ($daftarpdidik) {
            $daftarpdidik->delete();
            return redirect('/daftarpesertadidik')->with('success', 'Data Peserta Didik Berhasil Dihapus ');
        }
        return redirect('/daftarpesertadidik')->with('error', 'Data Peserta Didik Walas not found!');
    }
}
