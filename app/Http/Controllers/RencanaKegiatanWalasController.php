<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RencanaKegiatanWalas; // model untuk ganjil
use App\Models\RencanaKegiatanWalasGenap; // model untuk genap
use App\Models\Walas;
use App\Models\Rombel;
use Illuminate\Support\Facades\Auth;

class RencanaKegiatanWalasController extends Controller
{
    public function index($semester)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

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

        $model = $semester === 'ganjil' ? RencanaKegiatanWalas::class : RencanaKegiatanWalasGenap::class;
        $data = $model::with('walas', 'kurikulum')->get();

        return view('admwalas.rencana_kegiatan_walas.index', compact('data', 'semester', 'walas'));
    }

    public function create($semester)
    {
       // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
       $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

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

        // Ambil data rombel yang dimiliki walas yang sedang login
        $rombel = Rombel::where('walas_id', $walas->id)->first();

        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
        }

        return view('admwalas.rencana_kegiatan_walas.create', compact('semester','walas', 'rombel'));
    }
    

    public function store(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'minggu_ke' => 'required',
        'kegiatan_bukti' => 'required',
        'keterangan' => 'required',
        'tanggal' => 'nullable|date',
        'ttdwalas_url' => 'nullable|url',
    ]);

    // Cek semester yang dipilih
    if ($request->semester === 'ganjil') {
        // Simpan ke tabel rencana_kegiatan_walas
        RencanaKegiatanWalas::create([
            'walas_id' => $request->walas_id,
            'minggu_ke' => $request->minggu_ke,
            'kegiatan_bukti' => $request->kegiatan_bukti,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'ttdwalas_url' => $request->ttdwalas_url,
        ]);
    } else {
        // Simpan ke tabel rencana_kegiatan_walas_genap
        RencanaKegiatanWalasGenap::create([
            'walas_id' => $request->walas_id,
            'minggu_ke' => $request->minggu_ke,
            'kegiatan_bukti' => $request->kegiatan_bukti,
            'keterangan' => $request->keterangan,
            'tanggal' => $request->tanggal,
            'ttdwalas_url' => $request->ttdwalas_url,
        ]);
    }

    return redirect()->route('rencana_kegiatan_walas.index', ['semester' => $request->semester])
                 ->with('success', 'Data berhasil disimpan');
}

public function edit($semester, $id) 
{
    $rencana_kegiatan = RencanaKegiatanWalas::findOrFail($id); // Mendapatkan data berdasarkan ID
    $walas = Walas::all(); // Mendapatkan semua data wali kelas

    return view('admwalas.rencana_kegiatan_walas.edit', compact('rencana_kegiatan', 'walas', 'semester'));
}

    public function update(Request $request, $semester, $id)
    {
        $model = $semester === 'ganjil' ? RencanaKegiatanWalas::class : RencanaKegiatanWalasGenap::class;

        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'minggu_ke' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18',
            'kegiatan_bukti' => 'required',
            'keterangan' => 'required|in:true,false',
            'tanggalttd' => 'nullable|date',
            'ttdkurikulum_url' => 'nullable|string|max:255',
            'ttdwalas_url' => 'nullable|string|max:255',
        ]);

        $data = $model::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('rencana_kegiatan_walas.index', $semester)
            ->with('success', 'Data berhasil diperbarui!');
    }
}
