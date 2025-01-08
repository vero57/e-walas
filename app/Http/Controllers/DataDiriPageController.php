<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiodataSiswa;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

class DataDiriPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
    $siswa = Auth::guard('siswas')->user();  // ini akan mendapatkan data siswa yang sedang login

    // Periksa apakah session 'siswa_id' ada
    if (!session()->has('siswa_id')) {
        return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data siswa berdasarkan 'siswa_siswa_id' yang ada di session
    $siswa = Siswa::find(session('siswa_id'));
    
    // Periksa apakah data siswa ditemukan
    if (!$siswa) {
        return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
    }
    // Ambil data biodata berdasarkan siswa yang login
    $biodata = BiodataSiswa::where('id', $siswa->id)->first();

    // Tentukan status apakah biodata sudah diisi atau belum
    $status = $biodata ? 'Sudah Diisi' : 'Belum Diisi';

    // Tampilkan view dengan data siswa dan status
    return view('homepagesiswa.datadiri', compact('siswa', 'biodata', 'status'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Form untuk membuat data baru
        return view('homepagesiswa.create_datadiri');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            // Tambahkan validasi lainnya
        ]);

        // Simpan data
        BiodataSiswa::create(array_merge($request->all(), [
            'siswas_id' => Auth::id()
        ]));

        return redirect()->route('datadiripage.index')->with('success', 'Biodata berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $biodata = BiodataSiswa::findOrFail($id);
        return view('homepagesiswa.show_datadiri', compact('biodata'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $biodata = BiodataSiswa::findOrFail($id);
        return view('homepagesiswa.edit_datadiri', compact('biodata'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            // Tambahkan validasi lainnya
        ]);

        $biodata = BiodataSiswa::findOrFail($id);
        $biodata->update($request->all());

        return redirect()->route('datadiripage.index')->with('success', 'Biodata berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $biodata = BiodataSiswa::findOrFail($id);
        $biodata->delete();

        return redirect()->route('datadiripage.index')->with('success', 'Biodata berhasil dihapus!');
    }
}
