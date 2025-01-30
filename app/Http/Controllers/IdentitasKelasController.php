<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use Illuminate\Http\Request;
use App\Models\IdentitasKelas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IdentitasKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
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

    // Ambil data rombel yang dimiliki walas yang sedang login
    $rombel = Rombel::where('walas_id', $walas->id)->first();

    // Periksa apakah rombel ditemukan
    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
    }

    // Mengambil data IdentitasKelas hanya yang sesuai dengan walas yang login
    $identitaskelas = IdentitasKelas::where('walas_id', $walas->id)->get();

    if ($request->get('export') == 'pdf') {
        $pdf = Pdf::loadView('pdf.identitaskelas', ['data' => $identitaskelas]);
        return $pdf->download('Identitas_Kelas.pdf');
    }

    return view('admwalas.identitaskelas.index', compact('identitaskelas', 'walas', 'rombel'));
}


    public function create()
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walaslogin = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login
       
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

    // Ambil data rombel yang dimiliki walas yang sedang login
    $rombel = Rombel::where('walas_id', $walaslogin->id)->first();

    // Periksa apakah rombel ditemukan
    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
    }
    
        // Mengambil data wali kelas dan siswa
        $walas = Walas::all();
        $siswas = Siswa::all();

        // Mengembalikan view dan mengirimkan data wali kelas dan siswa
        return view('admwalas.identitaskelas.create', compact('walas', 'siswas', 'rombel', 'walaslogin'));
    }


    // Menyimpan data identitas kelas yang diinputkan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'program_keahlian' => 'required|in:SIJA,TKJ,RPL,DKV,DPIB,TKP,TP,TFLM,TKR,TOI',
            'kompetensi_keahlian' => 'required|in:SIJA,TKJ,RPL,DKV,DPIB,TKP,TP,TFLM,TKR,TOI',
            'walas_id_10' => 'required|exists:walas,id',
            'walas_id_11' => 'required|exists:walas,id',
            'walas_id_12' => 'required|exists:walas,id',
            'walas_id_13' => 'required|exists:walas,id',
            'siswas_id_10' => 'required|exists:siswas,id',
            'siswas_id_11' => 'required|exists:siswas,id',
            'siswas_id_12' => 'required|exists:siswas,id',
            'siswas_id_13' => 'required|exists:siswas,id',
        ]);

        // Menyimpan data ke dalam database
        IdentitasKelas::create([
            'walas_id' => $request->walas_id,
            'program_keahlian' => $request->program_keahlian,
            'kompetensi_keahlian' => $request->kompetensi_keahlian,
            'walas_id_10' => $request->walas_id_10,
            'walas_id_11' => $request->walas_id_11,
            'walas_id_12' => $request->walas_id_12,
            'walas_id_13' => $request->walas_id_13,
            'siswas_id_10' => $request->siswas_id_10,
            'siswas_id_11' => $request->siswas_id_11,
            'siswas_id_12' => $request->siswas_id_12,
            'siswas_id_13' => $request->siswas_id_13,
        ]);

        // Redirect ke halaman index setelah berhasil menyimpan
        return redirect('/identitaskelas')->with('success', 'Data identitas kelas berhasil disimpan');
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
    public function edit($identitas_kelas_id)
{
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
         $walaslogin = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login
       
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
    
        // Ambil data rombel yang dimiliki walas yang sedang login
        $rombel = Rombel::where('walas_id', $walaslogin->id)->first();
    
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
        }

    // Ambil data identitas kelas berdasarkan id
    $identitaskelas = IdentitasKelas::findOrFail($identitas_kelas_id);

    // Ambil data wali kelas dan siswa
    $walas = Walas::all();
    $siswas = Siswa::all();

    // Mengembalikan view dan mengirimkan data
    return view('admwalas.identitaskelas.edit', compact('identitaskelas', 'walas', 'siswas', 'walaslogin', 'rombel'));
}

public function update(Request $request, $identitas_kelas_id)
{
    // Validasi input
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'program_keahlian' => 'required|in:SIJA,TKJ,RPL,DKV,DPIB,TKP,TP,TFLM,TKR,TOI',
        'kompetensi_keahlian' => 'required|in:SIJA,TKJ,RPL,DKV,DPIB,TKP,TP,TFLM,TKR,TOI',
        'walas_id_10' => 'required|exists:walas,id',
        'walas_id_11' => 'required|exists:walas,id',
        'walas_id_12' => 'required|exists:walas,id',
        'walas_id_13' => 'required|exists:walas,id',
        'siswas_id_10' => 'required|exists:siswas,id',
        'siswas_id_11' => 'required|exists:siswas,id',
        'siswas_id_12' => 'required|exists:siswas,id',
        'siswas_id_13' => 'required|exists:siswas,id',
    ]);

    // Menemukan data IdentitasKelas berdasarkan id
    $identitaskelas = IdentitasKelas::findOrFail($identitas_kelas_id);

    // Update data identitas kelas
    $identitaskelas->update([
        'walas_id' => $request->walas_id,
        'program_keahlian' => $request->program_keahlian,
        'kompetensi_keahlian' => $request->kompetensi_keahlian,
        'walas_id_10' => $request->walas_id_10,
        'walas_id_11' => $request->walas_id_11,
        'walas_id_12' => $request->walas_id_12,
        'walas_id_13' => $request->walas_id_13,
        'siswas_id_10' => $request->siswas_id_10,
        'siswas_id_11' => $request->siswas_id_11,
        'siswas_id_12' => $request->siswas_id_12,
        'siswas_id_13' => $request->siswas_id_13,
    ]);

    // Redirect ke halaman index setelah berhasil memperbarui
    return redirect()->route('identitaskelas.index')->with('success', 'Data identitas kelas berhasil diperbarui');
}



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
