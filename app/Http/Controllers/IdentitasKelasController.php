<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use App\Models\Walas;
use Illuminate\Http\Request;
use App\Models\IdentitasKelas;
use Illuminate\Support\Facades\DB;

class IdentitasKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $identitaskelas = DB::table('vwidentitaskelas')->get();

    if ($request->get('export') == 'pdf') {
        $pdf = Pdf::loadView('pdf.identitaskelas', ['data' => $identitaskelas]);
        return $pdf->download('Identitas_Kelas.pdf');
    }

    return view('admwalas.identitaskelas.index', compact('identitaskelas'));
}


    public function create()
    {
        // Mengambil data wali kelas dan siswa
        $walas = Walas::all();
        $siswas = Siswa::all();

        // Mengembalikan view dan mengirimkan data wali kelas dan siswa
        return view('admwalas.identitaskelas.create', compact('walas', 'siswas'));
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
        return redirect()->route('admwalas.identitaskelas.index')->with('success', 'Data identitas kelas berhasil disimpan');
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
    // Ambil data identitas kelas berdasarkan id
    $identitaskelas = IdentitasKelas::findOrFail($identitas_kelas_id);

    // Ambil data wali kelas dan siswa
    $walas = Walas::all();
    $siswas = Siswa::all();

    // Mengembalikan view dan mengirimkan data
    return view('admwalas.identitaskelas.edit', compact('identitaskelas', 'walas', 'siswas'));
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
