<?php

namespace App\Http\Controllers;

use App\Models\Walas;
use App\Models\Rombel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BeritaAcaraKenaikan;
use Illuminate\Support\Facades\Auth;

class BeritaAcaraKenaikanController extends Controller
{
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

        //$beritaAcara = BeritaAcaraKenaikan::with(['walas', 'rombel'])->get();
        $beritaAcara = BeritaAcaraKenaikan::where('walas_id', $walas->id)->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.beritaacarakenaikan', compact('walas', 'beritaAcara'));
            return $pdf->stream('Berita_Acara.pdf');
        }

        return view('admwalas.beritaacarakenaikan.index', compact('beritaAcara', 'walas'));
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
        return view('admwalas.beritaacarakenaikan.create', compact('walasid','walas', 'rombels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'waktu_tanggal' => 'required|date',
            'tempat' => 'required|string|max:20',
            'jumlah_peserta_rapat' => 'required|string|max:5',
            'rombels_id' => 'required|exists:rombels,id',
            'kelas_baru' => 'required|string',
            'laki_laki_naik' => 'required|string|max:5',
            'perempuan_naik' => 'required|string|max:5',
            'laki_laki_tinggal' => 'required|string|max:5',
            'perempuan_tinggal' => 'required|string|max:5',
        ]);

        BeritaAcaraKenaikan::create($request->all());

        return redirect()->route('beritaacarakenaikan.index')->with('success', 'Data berhasil ditambahkan.');
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

    $beritaAcara = BeritaAcaraKenaikan::findOrFail($id);
    $rombels = Rombel::all();

    return view('admwalas.beritaacarakenaikan.edit', compact('beritaAcara', 'walas', 'rombels'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'waktu_tanggal' => 'required|date',
        'tempat' => 'required|string|max:20',
        'jumlah_peserta_rapat' => 'required|string|max:5',
        'rombels_id' => 'required|exists:rombels,id',
        'kelas_baru' => 'required|string',
        'laki_laki_naik' => 'required|string|max:5',
        'perempuan_naik' => 'required|string|max:5',
        'laki_laki_tinggal' => 'required|string|max:5',
        'perempuan_tinggal' => 'required|string|max:5',
    ]);

    $beritaAcara = BeritaAcaraKenaikan::findOrFail($id);
    $beritaAcara->update($request->all());

    return redirect()->route('beritaacarakenaikan.index')->with('success', 'Data berhasil diperbarui.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
