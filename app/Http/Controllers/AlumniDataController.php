<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rombel;
use App\Models\Alumni;
use App\Models\Siswa;
use App\Models\Admin;
use App\Models\Kepsek;
use App\Models\Kakom;
use App\Models\Kurikulum;
use Illuminate\Support\Facades\Auth;

class AlumniDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pengaturanalumni()
    {
        // Periksa apakah admin sudah login
        if (!session()->has('admin_id')) {
            return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data admin yang sedang login
        $admin = Admin::find(session('admin_id'));
        
        if (!$admin) {
            return redirect('/loginadmin')->with('error', 'Data Admin tidak ditemukan.');
        }

        // Ambil semua siswa yang statusnya 'nonaktif'
        $siswas = Siswa::where('status', 'nonaktif')->get();

        foreach ($siswas as $siswa) {
            // Simpan data siswa ke tabel alumni sebelum menghapusnya
            Alumni::create([
                'siswa_id' => $siswa->id,
                'nama' => $siswa->nama,
                'no_wa' => $siswa->no_wa,
                'rombels_id' => $siswa->rombels_id,
            ]);

            // Hapus siswa dari tabel siswas
            $siswa->delete();
        }

        $alumni = Alumni::with('siswa.rombel')->get();

        return view('homepageadmin.alumni.index', compact('alumni', 'admin'));
    }

    public function pengaturanalumnikepsek()
    {
        // Periksa apakah admin sudah login
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data admin yang sedang login
        $kepsek = Kepsek::find(session('kepsek_id'));
        
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data kepsek tidak ditemukan.');
        }

        $alumni = Alumni::with('siswa.rombel')->get();

        return view('homepagekepsek.alumni.index', compact('alumni', 'kepsek'));
    }

    public function pengaturanalumnikakom()
    {
        // Periksa apakah kakom sudah login
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom yang sedang login
        $kakom = Kakom::find(session('kakom_id'));

        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data kakom tidak ditemukan.');
        }

        // Ambil kompetensi dari kakom yang login
        $kompetensi = $kakom->kompetensi;

        // Ambil rombels yang memiliki kompetensi yang sama dengan kakom
        $rombelIds = Rombel::where('kompetensi', $kompetensi)->pluck('id');

        // Ambil alumni berdasarkan rombels_id
        $alumni = Alumni::whereIn('rombels_id', $rombelIds)->with('siswa.rombel')->get();

        return view('homepagekaprog.alumni.index', compact('alumni', 'kakom'));
    }

    public function pengaturanalumnikurikulum()
    {
        // Periksa apakah admin sudah login
        if (!session()->has('kurikulum_id')) {
            return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data admin yang sedang login
        $kurikulum = Kurikulum::find(session('kurikulum_id'));
        
        if (!$kurikulum) {
            return redirect('/loginkurikulum')->with('error', 'Data kurikulum tidak ditemukan.');
        }

        $alumni = Alumni::with('siswa.rombel')->get();

        return view('homepagekurikulum.alumni.index', compact('alumni', 'kurikulum'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
