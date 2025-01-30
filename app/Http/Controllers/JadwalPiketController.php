<?php

namespace App\Http\Controllers;
use App\Models\Walas;
use App\Models\Siswa;
use App\Models\DetailJadwalPiket;
use App\Models\Rombel;
use App\Models\JadwalPiket;
use App\Models\Kurikulum;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalPiketController extends Controller
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
        $piket = JadwalPiket::where('walas_id', $walas->id)->get();
    
        // Ambil data siswa yang terhubung dengan kelompok menggunakan model DetailJadwalPiket
        $detailpiket = DetailJadwalPiket::whereIn('jadwalpikets_id', $piket->pluck('id'))->get();

        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walas->id)->first();
        
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }

        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
    
        $data = $piket->map(function ($item) use ($detailpiket) {
            // Ambil siswa yang terhubung berdasarkan jadwalpikets_id
            $siswas = $detailpiket->where('jadwalpikets_id', $item->id)->map(function ($detailpiket) {
                return \App\Models\Siswa::find($detailpiket->siswas_id); // Ambil data siswa berdasarkan siswas_id
            });
        
            return [
                'id' => $item->id,
                'nama_hari' => $item->nama_hari,
                'siswas' => $siswas, // Menyimpan objek siswa yang terhubung
            ];
        })->toArray();
        

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.jadwalpiket', compact('walas', 'data', 'siswas', 'rombel'));
            return $pdf->download('Jadwal_Piket.pdf');
        }
        
        // Kirim data kelompok dan walas ke view
        return view('admwalas.jadwalpiket.index', compact('walas', 'data', 'siswas', 'rombel'));
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
    
        // Jika tidak ada siswa di rombel, tampilkan pesan
        if ($siswas->isEmpty()) {
            $dataSiswa = 'Tidak ada siswa di kelompok ini';
        } else {
            $dataSiswa = $siswas;
        }
    
        $piket = JadwalPiket::select('nama_hari')
        ->where('walas_id', $walas->id)
        ->distinct()
        ->get();
    
    
        if ($piket->isEmpty()) {
            $data = [
                ['nama_hari' => 'Senin', 'siswas' => '0'],
                ['nama_hari' => 'Selasa', 'siswas' => '0'],
                ['nama_hari' => 'Rabu', 'siswas' => '0'],
                ['nama_hari' => 'Kamis', 'siswas' => '0'],
                ['nama_hari' => 'Jumat', 'siswas' => '0'],
            ];
        } else {
            $data = $piket->map(function ($item) {
                return [
                    'id' => $item->id, // Menambahkan id
                    'nama_hari' => $item->nama_hari,
                    'siswas' => $item->siswas_id, // Mengambil semua ID siswa yang terhubung
                ];
            })->toArray();
            
        }
    
        // Ambil data kelompok yang ada, dengan relasi siswa jika ada
        $piket = JadwalPiket::where('walas_id', $walas->id)->with('siswas')->get();
    
        // Kirim data ke view
        return view('admwalas.jadwalpiket.create', compact('walas', 'piket', 'dataSiswa', 'siswas', 'data'));
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
            'nama_hari' => 'required|string|max:255',
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'nullable', // Pastikan siswas_id berupa array
        ]);

        // Membuat kelompok baru tanpa menyertakan siswas_id
        $piket = JadwalPiket::create([
            'nama_hari' => $validatedData['nama_hari'],
            'walas_id' => $validatedData['walas_id'],
        ]);

        // Menambahkan siswa ke kelompok menggunakan tabel pivot
        if (!empty($validatedData['siswas_id'])) {
            $piket->siswas()->attach($validatedData['siswas_id']);
        }

        return redirect()->route('jadwalpiket.index')->with('success', 'Jadwal Piket berhasil dibuat!');
    }


    public function showSiswa($kelompokId)
    {
        $piket = JadwalPiket::find($kelompokId);
        $siswas = Siswa::whereDoesntHave('kelompok', function ($query) use ($kelompokId) {
            $query->where('jadwalpikets_id', $kelompokId);
        })->get();

        return view('/createpiket', compact('kelompok', 'siswas'));
    }


    public function addSiswa(Request $request, $id)
    {
        $piket = JadwalPiket::findOrFail($id);

        // Validasi maksimal 7 siswa
        if ($piket->siswas->count() >= 7) {
            return redirect()->back()->with('error', 'Maksimal 7 siswa per hari.');
        }

        // Tambahkan siswa ke kelompok
        $piket->siswas()->attach($request->siswas_id);

        return redirect('/jadwalpiket')->with('success', 'Siswa berhasil ditambahkan.');
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
            'jadwalpikets_id' => 'required|exists:jadwal_pikets,id',
            'siswas_id' => 'required|exists:siswas,id',
        ]);

        // Cek apakah siswa sudah ada di kelompok
        $existingSiswa = DetailJadwalPiket::where('jadwalpikets_id', $request->jadwalpikets_id) // Fokus hanya pada jadwalpikets_id
        ->where('siswas_id', $request->siswas_id)
        ->exists();

        if ($existingSiswa) {
        return redirect()->back()->with('error', 'Siswa sudah ada dalam hari ini.');
        }

        // Tambahkan siswa ke kelompok jika validasi lolos
        DetailJadwalPiket::create([
        'jadwalpikets_id' => $request->jadwalpikets_id,
        'siswas_id' => $request->siswas_id,
        ]);

        return redirect()->back()->with('success', 'Siswa berhasil ditambahkan ke hari.');

    }


    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
{

}


    /**
     * Update the specified resource in storage.
     */
     public function update(Request $request, $id)
    {
        $detailpiket = DetailJadwalPiket::find($id);

        if ($detailpiket) {
            // Update data siswa
            $detailpiket->siswas_id = $request->siswas_id;
            $detailpiket->save();

            return redirect('/jadwalpiket')->with('success', 'Siswa berhasil diupdate');
        }

        return redirect('/jadwalpiket')->with('error', 'Siswa tidak ditemukan');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function hapussiswapiket(string $siswas_id)
    {
        // Cari data berdasarkan siswas_id
        $siswas = DetailJadwalPiket::where('siswas_id', $siswas_id)->first();

        if ($siswas) {
            $siswas->delete();
            return redirect('/jadwalpiket')->with('success', 'Siswa Berhasil Dihapus');
        }
        
        return redirect('/jadwalpiket')->with('error', 'Siswa tidak ditemukan!');
    }

}
