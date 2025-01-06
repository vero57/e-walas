<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Guru;
use App\Imports\GuruImport;
use Illuminate\Http\Request;


class GuruPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('homepageadmin.gurudata.index', [
            'gurudata' =>  Guru::all(),
        ]);
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
            'nama' => 'required|string|max:255',
        ]);
    
        // Simpan data ke database, termasuk path gambar
        Guru::create([
            'nama' => $request->nama,
        ]);
    
        /// Redirect kembali dengan data terbaru
        return redirect()->back()->with([
            'success' => 'Data Guru berhasil ditambahkan!',
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
    public function edit(string $id)
    {
        {
            // Ambil data produk berdasarkan ID
            $guru = Guru::findOrFail($id);
    
            // Kirim data ke view edit
            return view('homepageadmin.gurudata.edit', compact('guru'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);
    
        // Cari Wali Kelas berdasarkan ID
        $guru = Guru::findOrFail($id); // Jika tidak ditemukan, akan mengembalikan error 404
    
        // Update data Wali Kelas
        $guru->nama = $request->nama;
    
        // Simpan perubahan ke database
        $guru->save();
    
        // Redirect dengan pesan sukses
        return redirect('/guru')->with('success', 'Data guru Berhasil di Edit');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function hapusguru(string $id)
    {
        $guru = Guru::find($id);
        if ($guru) {
            $guru->delete();
            return redirect('/guru')->with('success', 'guru data Berhasil Dihapus ');
        }
        return redirect('/guru')->with('error', 'guru not found!');
    }

    public function guru_search(Request $request)
    {
        $search_text = $request->keyword;
        $keywords = explode(' ', $search_text); 
        $guruQuery = Guru::query();
    
        foreach ($keywords as $keyword) {
            $guruQuery->where('nama', 'LIKE', '%' . $keyword . '%');
        }
    
        $gurudata = $guruQuery->get();
    
        return view('homepageadmin.gurudata.index', compact('gurudata'));
    }
}
