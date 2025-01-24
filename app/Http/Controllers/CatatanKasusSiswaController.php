<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\CatatanKasusSiswa;
use App\Models\Rombel;
use Illuminate\Support\Facades\Auth;

class CatatanKasusSiswaController extends Controller
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
        $catatankasus = CatatanKasusSiswa::where('walas_id', $walas->id)
            ->with('siswa')
            ->get();
    
        // Kirim data walas, siswa, dan catatan kasus ke view
        return view('admwalas.catatankasus.index', compact('walas', 'catatankasus', 'siswas'));
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
        return view('admwalas.catatankasus.create', compact('walas', 'siswas', 'rombel'));
    }




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi data yang diterima dari form
    $validatedData = $request->validate([
        'walas_id' => 'required|exists:walas,id', // Pastikan wali kelas valid
        'siswas_id' => 'required|exists:siswas,id', // Pastikan siswa valid
        'kasus' => 'required|string|max:255', // Kasus tidak boleh kosong
        'tindak_lanjut' => 'required|string|max:255', // Tindak lanjut tidak boleh kosong
        'keterangan' => 'nullable|string', // Keterangan bersifat opsional
    ]);

    // Simpan data ke dalam database
    CatatanKasusSiswa::create([
        'walas_id' => $validatedData['walas_id'],
        'siswas_id' => $validatedData['siswas_id'],
        'kasus' => $validatedData['kasus'],
        'tindak_lanjut' => $validatedData['tindak_lanjut'],
        'keterangan' => $validatedData['keterangan'],
    ]);

    // Redirect ke halaman /catatankasus dengan pesan sukses
    return redirect('/catatankasus')->with('success', 'Catatan kasus berhasil disimpan!');
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

        $catatan = CatatanKasusSiswa::findOrFail($id);

        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        // Kirim data ke view
        return view('admwalas.catatankasus.edit', compact('walas', 'siswas', 'rombel', 'catatan'));
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
    
        // Validasi input
        $request->validate([
            'siswas_id' => 'required|exists:siswas,id',
            'kasus' => 'required|string|max:255',
            'tindak_lanjut' => 'required|string|max:255',
            'keterangan' => 'required|string',
        ]);

        // Cari catatan kasus berdasarkan ID
        $catatan = CatatanKasusSiswa::findOrFail($id);

        // Update data catatan kasus
        $catatan->update([
            'walas_id' => $request->walas_id,
            'siswas_id' => $request->siswas_id,
            'kasus' => $request->kasus,
            'tindak_lanjut' => $request->tindak_lanjut,
            'keterangan' => $request->keterangan,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('catatankasus.index')->with('success', 'Catatan kasus berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function hapuscatatankasus(string $id)
    {
        $catatankasus = CatatanKasusSiswa::find($id);
        if ($catatankasus) {
            $catatankasus->delete();
            return redirect('/catatankasus')->with('success', 'Agenda Walas data Berhasil Dihapus ');
        }
        return redirect('/catatankasus')->with('error', 'Agenda Walas not found!');
    }
}
