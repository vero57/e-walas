<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BeritaAcaraKelulusan;
use Illuminate\Support\Facades\Auth;


class BeritaAcaraKelulusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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

        $beritaAcaraKelulusan = BeritaAcaraKelulusan::where('walas_id', $walas->id)->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.beritaacarakelulusan', compact('walas', 'beritaAcaraKelulusan'));
            return $pdf->stream('Berita_Acara.pdf');
        }

        return view('admwalas.beritaacarakelulusan.index', compact('beritaAcaraKelulusan', 'walas'));
    }

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

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walasid = Walas::all();

        $rombels = Rombel::all();
        return view('admwalas.beritaacarakelulusan.create', compact('walasid','walas', 'rombels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'waktu_tanggal' => 'required|date',
            'tempat' => 'required|string|max:20',
            'jumlah_peserta_rapat' => 'required|string|max:5',
            'rombels_id' => 'required|exists:rombels,id',
            'laki_laki_lulus' => 'required|string|max:5',
            'perempuan_lulus' => 'required|string|max:5',
            'laki_laki_tidaklulus' => 'required|string|max:5',
            'perempuan_tidaklulus' => 'required|string|max:5',
        ]);

        BeritaAcaraKelulusan::create($request->all());

        return redirect()->route('beritaacarakelulusan.index')->with('success', 'Data berhasil ditambahkan.');
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
    $walas = Auth::guard('walas')->user();

    if (!session()->has('walas_id')) {
        return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
    }

    $walas = Walas::find(session('walas_id'));

    if (!$walas) {
        return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
    }

    $beritaAcaraKelulusan = BeritaAcaraKelulusan::findOrFail($id);
    $rombels = Rombel::all();

    return view('admwalas.beritaacarakelulusan.edit', compact('beritaAcaraKelulusan', 'walas', 'rombels'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'waktu_tanggal' => 'required|date',
        'tempat' => 'required|string|max:20',
        'jumlah_peserta_rapat' => 'required|string|max:5',
        'rombels_id' => 'required|exists:rombels,id',
        'laki_laki_lulus' => 'required|string|max:5',
        'perempuan_lulus' => 'required|string|max:5',
        'laki_laki_tidaklulus' => 'required|string|max:5',
        'perempuan_tidaklulus' => 'required|string|max:5',
    ]);

    $beritaAcaraKelulusan = BeritaAcaraKelulusan::findOrFail($id);
    $beritaAcaraKelulusan->update($request->all());

    return redirect()->route('beritaacarakelulusan.index')->with('success', 'Data berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
