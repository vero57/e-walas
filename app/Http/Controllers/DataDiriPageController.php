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
        // Menggunakan guard 'siswas' untuk mendapatkan data siswa yang login
        $siswa = Auth::guard('siswas')->user(); // Mendapatkan data siswa yang sedang login
    
        // Periksa apakah session 'siswa_id' ada
        if (!session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data siswa berdasarkan 'siswa_id' yang ada di session
        $siswa = Siswa::find(session('siswa_id'));
    
        // Periksa apakah data siswa ditemukan
        if (!$siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }
    
        // Ambil data biodata berdasarkan siswa yang login
        $biodata = BiodataSiswa::where('siswas_id', $siswa->id)->first(); // Menggunakan 'siswa_id'
    
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
        $request->validate([
            'walas_id' => 'nullable|integer',
            'siswas_id' => 'nullable|integer',
            'nama_lengkap' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:10',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'alamat_maps' => 'nullable|string|max:255',
            'jalur_masuk' => 'nullable|string|max:50',
            'jarak_rumah' => 'nullable|string|max:50',
            'transportasi_sekolah' => 'nullable|string|max:50',
            'transportasi_rumah' => 'nullable|string|max:50',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',
            'no_wa' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'nis' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'kelas' => 'nullable|string|max:50',
            'kompetensi' => 'nullable|string|max:100',
            'tahun_masuk' => 'nullable|string|max:4',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'tempat_lahir_ayah' => 'nullable|string|max:255',
            'tanggal_lahir_ayah' => 'nullable|date',
            'alamat_ayah' => 'nullable|string|max:255',
            'no_wa_ayah' => 'nullable|string|max:15',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'tempat_lahir_ibu' => 'nullable|string|max:255',
            'tanggal_lahir_ibu' => 'nullable|date',
            'alamat_ibu' => 'nullable|string|max:255',
            'no_wa_ibu' => 'nullable|string|max:15',
            'namasekolah_asal' => 'nullable|string|max:255',
            'alamat_sekolah' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|string|max:4',
            'riwayat_penyakit' => 'nullable|string|max:255',
            'alergi' => 'nullable|string|max:255',
            'prestasi_akademik' => 'nullable|string|max:255',
            'prestasi_non_akademik' => 'nullable|string|max:255',
            'pengalaman_ekskul' => 'nullable|string|max:255',
            'kepribadian' => 'nullable|string|max:255'
        ]);
    
       // Debugging: Cek ID siswa yang sedang login
       $siswaId = Auth::guard('siswas')->id();
       Log::info('Siswa ID: ' . $siswaId);  // Menulis ID siswa ke log

       if (!$siswaId) {
           return redirect()->route('loginsiswa')->with('error', 'Siswa belum login.');
       }

       // Debugging: Cek data yang akan disimpan
       Log::info('Data yang akan disimpan: ', $request->all());  // Menulis data yang diterima ke log

       try {
           // Simpan data dengan menambahkan 'siswas_id' dari ID siswa yang sedang login
           $biodata = BiodataSiswa::create(array_merge($request->all(), [
               'siswas_id' => $siswaId
           ]));

           // Debugging: Cek apakah data berhasil disimpan
           Log::info('Data Biodata berhasil disimpan:', $biodata->toArray());

           return redirect()->route('datadiripage.index')->with('success', 'Biodata berhasil disimpan!');
       } catch (\Exception $e) {
           // Menangani error jika ada masalah saat menyimpan
           Log::error('Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());

           return redirect()->route('datadiripage.index')->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
       }
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
