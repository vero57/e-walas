<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Siswa;
use App\Models\KelompokSiswa;
use App\Models\Rombel;
use App\Models\DenahTempatKerjaKelompok;
use Illuminate\Support\Facades\Auth;

class DenahKerjaKelompokSiswaController extends Controller
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
        $kelompok = DenahTempatKerjaKelompok::where('walas_id', $walas->id)->get();
    
        // Ambil data siswa yang terhubung dengan kelompok menggunakan model KelompokSiswa
        $kelompokSiswa = KelompokSiswa::whereIn('kelompok_id', $kelompok->pluck('id'))->get();

        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();
        
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }

        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
    
        $data = $kelompok->map(function ($item) use ($kelompokSiswa) {
            // Ambil siswa yang terhubung berdasarkan kelompok_id
            $siswas = $kelompokSiswa->where('kelompok_id', $item->id)->map(function ($kelompokSiswa) {
                return \App\Models\Siswa::find($kelompokSiswa->siswa_id); // Ambil data siswa berdasarkan siswa_id
            });
        
            // Pastikan id disertakan dalam array yang dikembalikan
            return [
                'id' => $item->id,  // Menambahkan id ke dalam data yang dikirim
                'nama_kelompok' => $item->nama_kelompok,
                'siswas' => $siswas,  // Menyimpan objek siswa yang terhubung
            ];
        })->toArray();
        
    
        // Kirim data kelompok dan walas ke view
        return view('admwalas.denahtempatkerjakelompok.index', compact('walas', 'data', 'siswas', 'rombel'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    // Di controller create
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

    // Jika tidak ada siswa di rombel, tampilkan pesan
    if ($siswas->isEmpty()) {
        $dataSiswa = 'Tidak ada siswa di kelompok ini';
    } else {
        $dataSiswa = $siswas;
    }

    $kelompok = DenahTempatKerjaKelompok::select('nama_kelompok')
    ->where('walas_id', $walas->id)
    ->distinct()
    ->get();


    if ($kelompok->isEmpty()) {
        $data = [
            ['nama_kelompok' => 'Kelompok 1', 'siswas' => '0'],
            ['nama_kelompok' => 'Kelompok 2', 'siswas' => '0'],
            ['nama_kelompok' => 'Kelompok 3', 'siswas' => '0'],
            ['nama_kelompok' => 'Kelompok 4', 'siswas' => '0'],
            ['nama_kelompok' => 'Kelompok 5', 'siswas' => '0'],
            ['nama_kelompok' => 'Kelompok 6', 'siswas' => '0'],
        ];
    } else {
        $data = $kelompok->map(function ($item) {
            return [
                'id' => $item->id, // Menambahkan id
                'nama_kelompok' => $item->nama_kelompok,
                'siswas' => $item->siswas_id, // Mengambil semua ID siswa yang terhubung
            ];
        })->toArray();
        
    }

    // Ambil data kelompok yang ada, dengan relasi siswa jika ada
    $kelompok = DenahTempatKerjaKelompok::where('walas_id', $walas->id)->with('siswas')->get();

    // Kirim data ke view
    return view('admwalas.denahtempatkerjakelompok.create', compact('walas', 'kelompok', 'dataSiswa', 'siswas', 'data'));
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
    
       // Validasi data yang diterima
    // Validasi data yang diterima
        $validatedData = $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'nullable', // Pastikan siswas_id berupa array
        ]);

        // Membuat kelompok baru tanpa menyertakan siswas_id
        $kelompok = DenahTempatKerjaKelompok::create([
            'nama_kelompok' => $validatedData['nama_kelompok'],
            'walas_id' => $validatedData['walas_id'],
        ]);

        // Menambahkan siswa ke kelompok menggunakan tabel pivot
        if (!empty($validatedData['siswas_id'])) {
            $kelompok->siswas()->attach($validatedData['siswas_id']);
        }

        return redirect()->route('denahkerjakelompok.index')->with('success', 'Kelompok berhasil dibuat!');
    }
    
    
    public function showSiswa($kelompokId)
    {
        $kelompok = DenahTempatKerjaKelompok::find($kelompokId);
        $siswas = Siswa::whereDoesntHave('kelompok', function ($query) use ($kelompokId) {
            $query->where('kelompok_id', $kelompokId);
        })->get();

        return view('/createkelompok', compact('kelompok', 'siswas'));
    }


    public function addSiswa(Request $request, $id)
    {
        $kelompok = DenahTempatKerjaKelompok::findOrFail($id);

        // Validasi maksimal 7 siswa
        if ($kelompok->siswas->count() >= 7) {
            return redirect()->back()->with('error', 'Maksimal 7 siswa per kelompok.');
        }

        // Tambahkan siswa ke kelompok
        $kelompok->siswas()->attach($request->siswas_id);

        return redirect('/denahkerjakelompok')->with('success', 'Siswa berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function simpan(Request $request)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas_id = Auth::guard('walas')->user();
    
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas_id = Walas::find(session('walas_id'));
    
        // Periksa apakah data walas ditemukan
        if (!$walas_id) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Validasi input
        $request->validate([
            'kelompok_id' => 'required|exists:denah_tempat_kerja_kelompoks,id',
            'siswas_id' => 'required|exists:siswas,id',
        ]);

        // Cek apakah siswa sudah ada di kelompok
        $existingSiswa = KelompokSiswa::where('kelompok_id', $request->kelompok_id) // Fokus hanya pada kelompok_id
        ->where('siswa_id', $request->siswas_id)
        ->exists();

        if ($existingSiswa) {
        return redirect()->back()->with('error', 'Siswa sudah ada dalam kelompok ini.');
        }

        // Tambahkan siswa ke kelompok jika validasi lolos
        KelompokSiswa::create([
        'kelompok_id' => $request->kelompok_id,
        'siswa_id' => $request->siswas_id,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke kelompok.');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kelompokSiswa = KelompokSiswa::find($id);

        if ($kelompokSiswa) {
            // Update data siswa
            $kelompokSiswa->siswas_id = $request->siswas_id;
            $kelompokSiswa->save();

            return redirect('/denahkerjakelompok')->with('success', 'Siswa berhasil diupdate');
        }

        return redirect('/denahkerjakelompok')->with('error', 'Siswa tidak ditemukan');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function hapussiswadata(string $siswa_id)
    {
        // Cari data berdasarkan siswa_id
        $siswa = KelompokSiswa::where('siswa_id', $siswa_id)->first();

        if ($siswa) {
            $siswa->delete();
            return redirect('/denahkerjakelompok')->with('success', 'Siswa Berhasil Dihapus');
        }
        
        return redirect('/denahkerjakelompok')->with('error', 'Siswa tidak ditemukan!');
    }

}
