<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\AgendaKegiatanWalas;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class AgendaKegiatanWalasController extends Controller
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
    
        // Ambil data agenda berdasarkan walas_id
        $agendawalas = AgendaKegiatanWalas::where('walas_id', $walas->id)->get();
    
        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdf.agendawalas', compact('walas', 'agendawalas'));
            return $pdf->stream('Agenda_Walas.pdf');
        }

        // Mengirim data ke view
        return view('admwalas.agendawalas.index', [
            'walas' => $walas,
            'agendawalas' => $agendawalas,
        ]);
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

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walasid = Walas::all();

        // Kirim data ke view
        return view('admwalas.agendawalas.create', compact('walas', 'walasid'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
        // Validasi input
        $request->validate([
            'hari' => 'required',
            'tanggal' => 'required',
            'nama_kegiatan' => 'required', // perbaiki typo: 'nama_kegaitan' -> 'nama_kegiatan'
            'hasil' => 'required',
            'waktu' => 'required',
            'keterangan' => 'required',
            'tanggalttd' => 'required',
            'ttdwalas_url' => 'nullable|image|max:5000',
        ]);

        $imagePath = null;
        if ($request->hasFile('ttdwalas_url')) {
            $imagePath = $request->file('ttdwalas_url')->store('ttdwalas/Photos', 'public');
        }


        // Simpan data ke database, termasuk path gambar
        AgendaKegiatanWalas::create([
            'walas_id' => $walas->id, // Menyimpan ID wali kelas yang sedang login
            'hari' => $request->hari,
            'tanggal' => $request->tanggal,
            'nama_kegiatan' => $request->nama_kegiatan,
            'hasil' => $request->hasil,
            'waktu' => $request->waktu,
            'keterangan' => $request->keterangan,
            'tanggalttd' => $request->tanggalttd,
            'ttdwalas_url' => $imagePath, // Simpan path gambar di database
        ]);

        // Redirect kembali dengan data terbaru
        return redirect('/agendawalas')->with([
            'success' => 'Agenda Wali Kelas berhasil ditambahkan!',
        ]);
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

        $agendawalas = AgendaKegiatanWalas::findOrFail($id);

        // Kirim data ke view
        return view('admwalas.agendawalas.edit', compact('walas', 'walasid', 'agendawalas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
            'hari' => 'required',
            'tanggal' => 'required',
            'nama_kegiatan' => 'required', // perbaiki typo: 'nama_kegaitan' -> 'nama_kegiatan'
            'hasil' => 'required',
            'waktu' => 'required',
            'keterangan' => 'required',
            'tanggalttd' => 'required',
            'ttdwalas_url' => 'nullable|image|max:5000',
    ]);

    $agendawalas = AgendaKegiatanWalas::findOrFail($id);
    $agendawalas->walas_id = $request->walas_id;
    $agendawalas->hari = $request->hari;
    $agendawalas->tanggal = $request->tanggal;
    $agendawalas->nama_kegiatan = $request->nama_kegiatan;
    $agendawalas->hasil = $request->hasil;
    $agendawalas->waktu = $request->waktu;
    $agendawalas->keterangan = $request->keterangan;
    $agendawalas->tanggalttd = $request->tanggalttd;

    if ($request->hasFile('ttdwalas_url')) {
        // Hapus foto tanda tangan lama jika ada
        if ($agendawalas->ttdwalas_url) {
            Storage::delete('public/' . $agendawalas->ttdwalas_url);
        }
        // Simpan foto tanda tangan yang baru
        $path = $request->file('ttdwalas_url')->store('ttdwalas', 'public');
        $agendawalas->ttdwalas_url = $path;
    }

    $agendawalas->save();

    return redirect()->route('agendawalas.index')->with('success', 'Agenda berhasil diupdate');
}

    /**
     * Remove the specified resource from storage.
     */
    public function hapusagendawalas(string $id)
    {
        $agendawalas = AgendaKegiatanWalas::find($id);
        if ($agendawalas) {
            $agendawalas->delete();
            return redirect('/agendawalas')->with('success', 'Agenda Walas data Berhasil Dihapus ');
        }
        return redirect('/agendawalas')->with('error', 'Agenda Walas not found!');
    }
}
