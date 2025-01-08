<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Walas;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Imports\RombelImport;
use Maatwebsite\Excel\Facades\Excel;


class RombelPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    // Mengambil data dari tabel walas
    $walas = DB::table('walas')->select('id', 'nama')->get();

    // Mengirim data ke view
    return view('homepageadmin.rombeldata.index', [
        'vwrombels' => DB::table('vwrombels')->get(),
        'walas' => $walas // Kirim data wali kelas ke view
    ]);
}

public function import(Request $request){
    Excel::import(new RombelImport, $request->file('file'));
return redirect('/rombel');
}

public function downloadTemplate()
{
    $pathToFile = storage_path('app/public/template_rombel.xlsx'); // Sesuaikan dengan lokasi file template Excel
    return response()->download($pathToFile);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tingkat' => 'required',
            'kompetensi' => 'required',
            'nama_kelas' => 'required',
            'walas_id' => 'required|exists:walas,id',
        ]);
    
        // Simpan data ke tabel rombels
        Rombel::create([
            'tingkat' => $request->tingkat,
            'kompetensi' => $request->kompetensi,
            'nama_kelas' => $request->nama_kelas,
            'walas_id' => $request->walas_id
        ]);
    
        // Redirect kembali dengan data terbaru
        return redirect()->back()->with([
            'success' => 'Data Rombel berhasil ditambahkan!',
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
        // Ambil data rombel berdasarkan ID
        $rombel = Rombel::findOrFail($id);
        // Cek jika data walas ada
        $walas = Walas::all();
    
        if (!$walas) {
            // Jika data walas tidak ditemukan, kembalikan dengan error
            return redirect()->back()->with('error', 'Wali Kelas tidak ditemukan!');
        }
    
        // Kirim data ke view edit
        return view('homepageadmin.rombeldata.edit', compact('rombel', 'walas'));
    }
    
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'tingkat' => 'required',
            'kompetensi' => 'required',
            'nama_kelas' => 'required',
            'walas_id' => 'required',
        ]);
    
        $rombel = Rombel::findOrFail($id);
        $rombel->update($validated);
    
         // Redirect kembali dengan data terbaru
         return redirect('/rombel')->with('success', 'Data Rombel Berhasil di Edit');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function rombel_search(Request $request)
{
    $search_text = $request->keyword;
    $keywords = explode(' ', $search_text); 

    // Query untuk data vwrombels (table view)
    $vwrombels = DB::table('vwrombels');
    
    foreach ($keywords as $keyword) {
        $vwrombels->where('tingkat', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('kompetensi', 'LIKE', '%' . $keyword . '%');
    }
    
    $vwrombels = $vwrombels->get(); // Ambil data hasil pencarian

    // Ambil data wali kelas (misalnya dari tabel wali_kelas)
    $walas = Walas::all(); // Sesuaikan dengan model dan tabel yang benar

    // Kirim data ke view
    return view('homepageadmin.rombeldata.index', compact('vwrombels', 'walas'));
}

    
}
