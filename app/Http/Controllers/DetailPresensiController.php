<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\DetailPresensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailPresensiController extends Controller
{
    public function index($presensiId)
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

         
        $presensi = Presensi::with('detailPresensis.siswa')->findOrFail($presensiId);
        
        return view('admwalas.detailpresensi.index', compact('presensi', 'walas'));
    }


    public function create($presensi_id)
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

    
        // Ambil data presensi
        $presensi = Presensi::findOrFail($presensi_id);
    
        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
    
        // Return ke view dengan data presensi, siswa, dan walas
        return view('admwalas.detailpresensi.create', compact('presensi', 'siswas', 'walas', 'rombel'));
    }
    

    public function store(Request $request, $presensi_id)
    {
        $request->validate([
            'siswas_id' => 'required|exists:siswas,id',
            'status' => 'required|in:hadir,izin,sakit,alfa',
        ]);

        DetailPresensi::create([
            'presensis_id' => $presensi_id,
            'siswas_id' => $request->siswas_id,
            'status' => $request->status,
        ]);

        return redirect()->route('detailpresensi.index', $presensi_id)->with('success', 'Detail presensi berhasil ditambahkan!');
    }

    public function edit($presensi_id, $detail_id)
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

        $presensi = Presensi::findOrFail($presensi_id);
        $detail = DetailPresensi::findOrFail($detail_id);
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
        return view('admwalas.detailpresensi.edit', compact('presensi', 'detail', 'siswas', 'walas', 'rombel'));
    }

    public function update(Request $request, $presensi_id, $detail_id)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alfa',
        ]);

        $detail = DetailPresensi::findOrFail($detail_id);
        $detail->update([
            'status' => $request->status,
        ]);

        return redirect()->route('detailpresensi.index', $presensi_id)->with('success', 'Detail presensi berhasil diperbarui!');
    }

    public function destroy($presensi_id, $detail_id)
    {
        $detail = DetailPresensi::findOrFail($detail_id);
        $detail->delete();

        return redirect()->route('detailpresensi.index', $presensi_id)->with('success', 'Detail presensi berhasil dihapus!');
    }
}
