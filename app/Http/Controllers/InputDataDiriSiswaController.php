<?php

namespace App\Http\Controllers;

use App\Models\BiodataSiswa;
use App\Models\Siswa;
use App\Models\Walas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InputDataDiriSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil siswa yang sedang login
        $siswa = Auth::guard('siswas')->user();

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

         // Mengambil data dari tabel walas
        $walas = DB::table('walas')->select('id', 'nama')->get();


        $biodatas = BiodataSiswa::all();
        return view('homepagesiswa.inputdatadiri.index', compact('biodatas', 'siswa', 'walas'));
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
    {
        // Menggunakan guard 'siswas' untuk mendapatkan data siswa yang login
        $siswa = Auth::guard('siswas')->user();

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

        // Validasi input
        $validatedData = $request->validate([
            'walas_id' => 'nullable|integer',
            'siswas_id' => 'nullable|integer',
            'nama_lengkap' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:10',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'alamat_maps' => 'nullable|string|max:1000',
            'fotorumah_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kepemilikan_rumah' => 'nullable|string|max:50',
            'jalur_masuk' => 'nullable|string|max:50',
            'jarak_rumah' => 'nullable|string|max:50',
            'transportasi_sekolah' => 'nullable|string|max:50',
            'transportasi_rumah' => 'nullable|string|max:50',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',
            'no_wa' => 'nullable|string|max:20',
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
            'no_wa_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'tempat_lahir_ibu' => 'nullable|string|max:255',
            'tanggal_lahir_ibu' => 'nullable|date',
            'alamat_ibu' => 'nullable|string|max:255',
            'no_wa_ibu' => 'nullable|string|max:20',
            'pendapatan_ortu' => 'string|max:255',
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

        // Menambahkan siswas_id ke request
        $validatedData['siswas_id'] = $siswa->id;

        // Cek dan simpan file gambar jika ada
        if ($request->hasFile('fotorumah_url')) {
            // Memberi nama unik pada file
            $fileName = uniqid() . '.' . $request->file('fotorumah_url')->getClientOriginalExtension();
            
            // Menyimpan file dengan nama unik
            $fotoRumahPath = $request->file('fotorumah_url')->storeAs('images/photos', $fileName, 'public');
            
            // Menyimpan path file yang ter-link di public
            $validatedData['fotorumah_url'] = $fotoRumahPath;
        }

        // Mengecek apakah pekerjaan ayah adalah "Lainnya" dan mengganti nilainya jika perlu
        if ($request->pekerjaan_ayah === 'Lainnya' && $request->filled('pekerjaan_ayah_lainnya')) {
            $validatedData['pekerjaan_ayah'] = $request->pekerjaan_ayah_lainnya;
        }

        // Mengecek apakah pekerjaan ibu adalah "Lainnya" dan mengganti nilainya jika perlu
        if ($request->pekerjaan_ibu === 'Lainnya' && $request->filled('pekerjaan_ibu_lainnya')) {
            $validatedData['pekerjaan_ibu'] = $request->pekerjaan_ibu_lainnya;
        }

        // Simpan data ke database
        BiodataSiswa::create($validatedData);
    
        return redirect('/datadiripage')->with('success', 'Data Berhasil Ditambahkan!');
    }

    
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $biodata = BiodataSiswa::findOrFail($id);
        return view('homepagesiswa.datadiri', compact('biodata'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Mengambil siswa yang sedang login
        $siswa = Auth::guard('siswas')->user();

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

        // Ambil biodata berdasarkan 'siswas_id'
        $biodata = BiodataSiswa::where('siswas_id', $siswa->id)->first();

        // Periksa apakah data biodata ditemukan
        if (!$biodata) {
            return redirect('/homepagesiswa')->with('error', 'Data biodata tidak ditemukan.');
        }

        // Cek apakah siswa sedang login
        if ($siswa) {
            // Ambil walas_id dari biodata
            $walas_id = $biodata ? $biodata->walas_id : null;

            // Ambil wali kelas berdasarkan walas_id (jika ada)
            $walas = $walas_id ? Walas::find($walas_id) : null;

            // Ambil nomor WhatsApp Walas atau tampilkan pesan default
            $no_wa_walas = $walas && !empty($walas->no_wa) ? $walas->no_wa : 'Nomor tidak tersedia';
        } else {
            $no_wa_walas = 'Nomor tidak tersedia';
        }

        // Ambil data rombel siswa
        $rombel = $siswa->rombel;

        // Ambil wali kelas dari rombel siswa
        $nowalas = $rombel ? $rombel->walas : null;

        // Mengambil data dari tabel walas
        $walasList = DB::table('walas')->select('id', 'nama')->get();

        // Ambil biodata siswa berdasarkan ID, tetapi hanya jika milik siswa yang login
        $biodata = BiodataSiswa::where('id', $id)->where('siswas_id', $siswa->id)->first();

        // Jika biodata tidak ditemukan atau bukan milik siswa yang login, redirect dengan error
        if (!$biodata) {
            return redirect('/homepagesiswa')->with('error', 'Data tidak ditemukan.');
        }

        // Return view dengan data yang dibutuhkan
        return view('homepagesiswa.inputdatadiri.edit', compact('biodata', 'siswa', 'nowalas', 'walasList', 'no_wa_walas', 'walas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input request
        $request->validate([
            'walas_id' => 'nullable|integer',
            'siswas_id' => 'nullable|integer',
            'nama_lengkap' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:10',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'alamat_maps' => 'nullable|string|max:5000',
            'fotorumah_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kepemilikan_rumah' => 'nullable|string|max:50',
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

        // Periksa sesi login siswa
        if (!session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data siswa dari sesi
        $siswa = Siswa::find(session('siswa_id'));
        if (!$siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Ambil data biodata siswa berdasarkan ID
        $biodata = BiodataSiswa::findOrFail($id);

        // Mengecek apakah pekerjaan ayah adalah "Lainnya" dan mengganti nilainya jika perlu
    if ($request->pekerjaan_ayah === 'Lainnya' && $request->has('pekerjaan_ayah_lainnya')) {
        $request->merge(['pekerjaan_ayah' => $request->pekerjaan_ayah_lainnya]);
    }

    // Mengecek apakah pekerjaan ibu adalah "Lainnya" dan mengganti nilainya jika perlu
    if ($request->pekerjaan_ibu === 'Lainnya' && $request->has('pekerjaan_ibu_lainnya')) {
        $request->merge(['pekerjaan_ibu' => $request->pekerjaan_ibu_lainnya]);
    }

    // Periksa apakah ada file baru yang diunggah
    if ($request->hasFile('fotorumah_url')) {
        // Hapus file lama jika ada
        if ($biodata->fotorumah_url && Storage::exists('public/' . $biodata->fotorumah_url)) {
            Storage::delete('public/' . $biodata->fotorumah_url);
        }
        // Simpan file baru
        $fotoRumahPath = $request->file('fotorumah_url')->store('images/photos', 'public');
    } else {
        $fotoRumahPath = $biodata->fotorumah_url; // Gunakan file lama jika tidak ada perubahan
    }


    // Update data siswa
    $biodata->fill($request->all());
    $biodata->siswas_id = $siswa->id; // Tambahkan siswas_id dari session
    $biodata->nama_lengkap = $request->nama_lengkap;
    $biodata->jenis_kelamin = $request->jenis_kelamin;
    $biodata->tempat_lahir = $request->tempat_lahir;
    $biodata->tanggal_lahir = $request->tanggal_lahir;
    $biodata->alamat = $request->alamat;
    $biodata->alamat_maps = $request->alamat_maps;
    $biodata->fotorumah_url = $fotoRumahPath;
    $biodata->kepemilikan_rumah = $request->kepemilikan_rumah;
    $biodata->jalur_masuk = $request->jalur_masuk;
    $biodata->jarak_rumah = $request->jarak_rumah;
    $biodata->transportasi_sekolah = $request->transportasi_sekolah;
    $biodata->transportasi_rumah = $request->transportasi_rumah;
    $biodata->agama = $request->agama;
    $biodata->kewarganegaraan = $request->kewarganegaraan;
    $biodata->anak_ke = $request->anak_ke;
    $biodata->jumlah_saudara = $request->jumlah_saudara;
    $biodata->no_wa = $request->no_wa;
    $biodata->email = $request->email;
    $biodata->nis = $request->nis;
    $biodata->nisn = $request->nisn;
    $biodata->kelas = $request->kelas;
    $biodata->kompetensi = $request->kompetensi;
    $biodata->tahun_masuk = $request->tahun_masuk;
    $biodata->nama_ayah = $request->nama_ayah;
    $biodata->pekerjaan_ayah = $request->pekerjaan_ayah;
    $biodata->tempat_lahir_ayah = $request->tempat_lahir_ayah;
    $biodata->tanggal_lahir_ayah = $request->tanggal_lahir_ayah;
    $biodata->alamat_ayah = $request->alamat_ayah;
    $biodata->no_wa_ayah = $request->no_wa_ayah;
    $biodata->nama_ibu = $request->nama_ibu;
    $biodata->pekerjaan_ibu = $request->pekerjaan_ibu;
    $biodata->tempat_lahir_ibu = $request->tempat_lahir_ibu;
    $biodata->tanggal_lahir_ibu = $request->tanggal_lahir_ibu;
    $biodata->alamat_ibu = $request->alamat_ibu;
    $biodata->no_wa_ibu = $request->no_wa_ibu;
    $biodata->namasekolah_asal = $request->namasekolah_asal;
    $biodata->alamat_sekolah = $request->alamat_sekolah;
    $biodata->tahun_lulus = $request->tahun_lulus;
    $biodata->riwayat_penyakit = $request->riwayat_penyakit;
    $biodata->alergi = $request->alergi;
    $biodata->prestasi_akademik = $request->prestasi_akademik;
    $biodata->prestasi_non_akademik = $request->prestasi_non_akademik;
    $biodata->pengalaman_ekskul = $request->pengalaman_ekskul;
    $biodata->kepribadian = $request->kepribadian;

    // Simpan data yang telah diubah
    $biodata->save();

    // Redirect ke halaman dengan pesan sukses
    return redirect('/datadiripage')->with([
        'success' => 'Data berhasil diperbarui!',
        'biodatas' => BiodataSiswa::all(),
        'siswa' => $siswa,
        'walas' => DB::table('walas')->select('id', 'nama')->get()
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        BiodataSiswa::destroy($id);
        return redirect()->route('inputdatadiri.index')->with('success', 'Data berhasil dihapus!');
    }
}
