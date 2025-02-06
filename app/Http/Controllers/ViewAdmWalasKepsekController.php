<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Walas;
use App\Models\Kakom;
use App\Models\Rombel;
use App\Models\AgendaKegiatanWalas;
use App\Models\IdentitasKelas;
use App\Models\LembarPengesahan;
use App\Models\StrukturOrganisasiKelas;
use App\Models\JadwalKbm;
use App\Models\Mapel;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Presensi;
use App\Models\JadwalPiket;
use App\Models\DetailJadwalPiket;
use App\Models\DaftarSerahTerimaRapor;
use App\Models\CatatanKasusSiswa;
use App\Models\DaftarPesertaDidik;
use App\Models\RekapitulasiJumlahSiswa;
use App\Models\HomeVisit;
use App\Models\BukuTamuOrangtua;
use App\Models\PersentaseSosialEkonomi;
use App\Models\BiodataSiswa;
use App\Models\PrestasiSiswa;
use App\Models\Kepsek;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewAdmWalasKepsekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function agendawalaskepsek(Request $request)
    {
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();  

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }

        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan ID yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter

        $agendaList = AgendaKegiatanWalas::whereIn('walas_id', $walasIds);

        // Filter berdasarkan walas_id jika ada pilihan
        if ($walasIdSelected) {
            $agendaList->where('walas_id', $walasIdSelected);
        }

        // Eksekusi query dan ambil data agenda
        $agendaList = $agendaList->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfkepsek.agendawalas', compact('walasList', 'walasIds', 'kepsek', 'agendaList'));
            return $pdf->stream('Agenda_Walas.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.agendawalas.index", compact('walasList', 'walasIds', 'kepsek', 'agendaList'));
    }

    public function identitaskelaskepsek(Request $request)
    {
         // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
         $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

         // Periksa apakah session 'kepsek_id' ada
         if (!session()->has('kepsek_id')) {
             return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
         }
 
         // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
         $kepsek = Kepsek::find(session('kepsek_id'));
 
         // Periksa apakah data kepsek ditemukan
         if (!$kepsek) {
             return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
         }
 
         // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan ID yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter

        $identiasKelasList = IdentitasKelas::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $identiasKelasList = $identiasKelasList->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $identiasKelasList = $identiasKelasList->get();

        if ($request->get('export') == 'pdf') {
            $pdf = Pdf::loadView('pdfkepsek.identitaskelas', ['data' => $identiasKelasList]);
            return $pdf->stream('Identitas_Kelas.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.identitaskelas.index", compact('walasList', 'walasIds', 'kepsek', 'identiasKelasList'));
    } 

    public function lembarpengesahankepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil semua ID walas
       $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

       // Ambil data walas berdasarkan ID yang sesuai
       $walasList = Walas::whereIn('id', $walasIds)->get();

       // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
       $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $lembarPengesahan = LembarPengesahan::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $lembarPengesahan = $lembarPengesahan->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $lembarPengesahan = $lembarPengesahan->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.lembarpengesahan.index", compact('walasList', 'walasIds', 'kepsek', 'lembarPengesahan'));
    } 

    public function strukturorganisasikelaskepsek(Request $request)
    {
         // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
         $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

         // Periksa apakah session 'kepsek_id' ada
         if (!session()->has('kepsek_id')) {
             return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
         }
 
         // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
         $kepsek = Kepsek::find(session('kepsek_id'));
 
         // Periksa apakah data kepsek ditemukan
         if (!$kepsek) {
             return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
         }
 
         // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $strukturOrganisasi = StrukturOrganisasiKelas::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $strukturOrganisasi = $strukturOrganisasi->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $strukturOrganisasi = $strukturOrganisasi->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.strukturorganisasi.index", compact('walasList', 'walasIds', 'kepsek', 'strukturOrganisasi'));
    } 

    public function jadwalkbmkepsek(Request $request)
    {
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }

        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil walas_id dari URL query parameter
        $walasIdSelected = $request->query('walas_id'); 

        // Ambil data rombel berdasarkan walas_id yang dipilih
        $rombel = null;
        if ($walasIdSelected) {
            $rombel = Rombel::where('walas_id', $walasIdSelected)->first();
        }

        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/walaspage')->with('error', 'Rombel untuk Walas ini tidak ditemukan.');
        }

        // Ambil data siswa berdasarkan rombel yang terkait dengan walas
        $siswa = DB::table('siswas')
            ->where('rombels_id', $rombel->id) // Sesuaikan dengan kolom yang tepat
            ->get();

        // Ambil semua data rombel
        $rombels = Rombel::all();

        // **[PERBAIKAN]: Buat variabel query sebelum filter**
        $jadwalKbmsQuery = JadwalKBM::with(['rombel', 'walas', 'mapels', 'gurus']);

        if ($walasIdSelected) {
            $jadwalKbmsQuery->where('walas_id', $walasIdSelected);
        }

        // Eksekusi query untuk mendapatkan hasil
        $jadwalKbms = $jadwalKbmsQuery->get();

        // Ambil data mapel dan guru untuk ditampilkan
        $mapels = Mapel::all()->keyBy('id');
        $gurus = Guru::all()->keyBy('id');

        // Jika export ke PDF
        if ($request->input('export') === 'pdf') {
            $data = [
                'jadwalKbms' => $jadwalKbms,
                'mapels' => $mapels,
                'gurus' => $gurus
            ];
            $pdf = Pdf::loadView('pdf.jadwalkbm', $data)->setPaper('A4', 'portrait');
            return $pdf->stream('Jadwal_KBM.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.jadwalkbm.index", compact('walasList', 'walasIds', 'kepsek', 'jadwalKbms', 'rombel', 'siswa'));
    }


    public function presensiskepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data walas_id yang dipilih dari query parameter
        $walasIdSelected = $request->query('walas_id');
        $semester = $request->query('semester'); // Parameter semester (ganjil/genap)

        // Query presensi
        $presensis = Presensi::whereIn('walas_id', $walasIds) // Perbaikan: Menggunakan whereIn()
            ->when($walasIdSelected, function ($query) use ($walasIdSelected) {
                return $query->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
            })
            ->when($semester === 'ganjil', function ($query) {
                return $query->whereMonth('tanggal', '>=', 7)->whereMonth('tanggal', '<=', 12);
            })
            ->when($semester === 'genap', function ($query) {
                return $query->whereMonth('tanggal', '>=', 1)->whereMonth('tanggal', '<=', 6);
            })
            ->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.presensi.index", compact('walasList', 'walasIds', 'kepsek', 'presensis'));
    }

    public function piketkelaskepsek(Request $request)
    {
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }

        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array
        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        // Ambil data kelompok berdasarkan 'walas_id'
        $piket = JadwalPiket::whereIn('walas_id', $walasIds)->get();
    
        // Ambil data siswa yang terhubung dengan kelompok menggunakan model DetailJadwalPiket
        $detailpiket = DetailJadwalPiket::whereIn('jadwalpikets_id', $piket->pluck('id'))->get();

        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::whereIn('walas_id', $walasIds)->first();
        
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }

        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::where('rombels_id', $rombel->id)->get();
    
        $data = $piket->map(function ($item) use ($detailpiket) {
            // Ambil siswa yang terhubung berdasarkan jadwalpikets_id
            $siswas = $detailpiket->where('jadwalpikets_id', $item->id)->map(function ($detailpiket) {
                return \App\Models\Siswa::find($detailpiket->siswas_id); // Ambil data siswa berdasarkan siswas_id
            });
        
            return [
                'id' => $item->id,
                'nama_hari' => $item->nama_hari,
                'siswas' => $siswas, // Menyimpan objek siswa yang terhubung
            ];
        })->toArray();
        

        if ($walasIdSelected) {
            $piket = $piket->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfkepsek.jadwalpiket', compact( 'walasList','data', 'siswas', 'rombel'));
            return $pdf->stream('Jadwal_Piket.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.jadwalpiket.index", compact('walasList', 'walasIds', 'kepsek', 'piket', 'detailpiket', 'data', 'siswas','rombel'));
    }

    public function serahterimaraporkepsek(Request $request)
    {
        
        $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $rapor = DaftarSerahTerimaRapor::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $rapor = $rapor->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $rapor = $rapor->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.daftarpenyerahanrapot.index", compact('walasList', 'walasIds', 'kepsek', 'rapor'));
    }

    public function catatankasuskepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil semua ID walas
        $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $catatankasus = CatatanKasusSiswa::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $catatankasus = $catatankasus->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $catatankasus = $catatankasus->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.catatankasus.index", compact('walasList', 'walasIds', 'kepsek', 'catatankasus'));
    }

    public function daftarpesertadidikkepsek(Request $request)
    {
        // Menggunakan guard 'kepseks' untuk mendapatkan data kepsek yang login
        $kepsek = Auth::guard('kepseks')->user();

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }

        // Ambil semua ID walas dalam bentuk array
        $walasIds = Walas::pluck('id')->toArray();

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil walas_id dari URL query parameter
        $walasIdSelected = $request->query('walas_id');

        // Ambil data peserta didik berdasarkan walas_id
        $daftarPDidik = DaftarPesertaDidik::whereIn('walas_id', $walasIds);

        // Filter jika walas_id dipilih
        if ($walasIdSelected && in_array($walasIdSelected, $walasIds)) {
            $daftarPDidik = $daftarPDidik->where('walas_id', $walasIdSelected);
        }

        // Ambil data daftar peserta didik setelah filter
        $daftarPDidik = $daftarPDidik->get();

        // Hitung jumlah jenis kelamin setelah data diambil
        $jenisKelaminCount = $daftarPDidik->groupBy('jenis_kelamin')->map(function ($items) {
            return count($items);
        });

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.daftarpesertadidik.index", compact('walasList', 'walasIds', 'kepsek', 'daftarPDidik', 'jenisKelaminCount'));
    }


    public function rekapitulasipdidikkepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

        // Periksa apakah session 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
        $kepsek = Kepsek::find(session('kepsek_id'));

        // Periksa apakah data kepsek ditemukan
        if (!$kepsek) {
            return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil semua ID walas
       $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

       // Ambil data walas berdasarkan walas_id yang sesuai
       $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $rekapitulasiPDidik = RekapitulasiJumlahSiswa::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $rekapitulasiPDidik = $rekapitulasiPDidik->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $rekapitulasiPDidik = $rekapitulasiPDidik->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.rekapitulasijumlahsiswa.index", compact('walasList', 'walasIds', 'kepsek', 'rekapitulasiPDidik'));
    }

    public function homevisitkepsek(Request $request)
    {
       // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
      $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $homevisit = HomeVisit::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $homevisit = $homevisit->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $homevisit = $homevisit->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.homevisit.index", compact('walasList', 'walasIds', 'kepsek', 'homevisit'));
    }

    public function bukutamuortukepsek(Request $request)
    {
         // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
      $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $bukutamu = BukuTamuOrangtua::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $bukutamu = $bukutamu->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $bukutamu = $bukutamu->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.bukutamuortu.index", compact('walasList', 'walasIds', 'kepsek', 'bukutamu'));
    }

    public function persentasesosialekonomikepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
      $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $persentasesosialekonomi = PersentaseSosialEkonomi::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $persentasesosialekonomi = $persentasesosialekonomi->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $persentasesosialekonomi = $persentasesosialekonomi->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.persentasesosialekonomi.index", compact('walasList', 'walasIds', 'kepsek', 'persentasesosialekonomi'));
    }

    public function rentangpendapatanortukepsek(Request $request)
    {
         // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
      $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil walas_id dari URL query parameter
        $walasIdSelected = $request->query('walas_id'); 

        // Query utama untuk data siswa
        $query = BiodataSiswa::whereIn('walas_id', $walasIds);

        // Filter jika ada walas_id yang dipilih
        if ($walasIdSelected) {
            $query->where('walas_id', $walasIdSelected);
        }

        // Kelompokkan data berdasarkan rentang pendapatan
        $dataPendapatan = [
            'Kurang dari Rp1.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Kurang dari Rp1.000.000,00')->count(),
            'Rp1.000.000,00 - Rp3.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp1.000.000,00 - Rp3.000.000,00')->count(),
            'Rp3.000.000,00 - Rp5.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp3.000.000,00 - Rp5.000.000,00')->count(),
            'Rp5.000.000,00 - Rp10.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp5.000.000,00 - Rp10.000.000,00')->count(),
            'Rp10.000.000,00 - Rp25.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp10.000.000,00 - Rp25.000.000,00')->count(),
            'Rp25.000.000,00 - Rp50.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp25.000.000,00 - Rp50.000.000,00')->count(),
            'Lebih dari Rp50.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Lebih dari Rp50.000.000,00')->count(),
        ];

        // Ambil data siswa hanya untuk walas yang sedang login
            $pendapatan = BiodataSiswa::select('id', 'nama_lengkap', 'pendapatan_ortu')
                ->where('walas_id', $walasIdSelected)
                ->get();
        
        if (request()->has('export') && request()->get('export') === 'pdf') {
            $chartImage = request()->input('chartImage'); // Ambil data grafik dari form
            dd($chartImage); 
            $pdf = Pdf::loadView('pdf.pendapatanortu', compact('pendapatan', 'walas', 'dataPendapatan', 'chartImage'));
            return $pdf->stream('Pendapatan_Orang_Tua.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.pendapatanortu.index", compact('walasList', 'walasIds', 'kepsek','dataPendapatan', 'pendapatan', 'walasIdSelected'));
    }

    public function prestasisiswakepsek(Request $request)
    {
         // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
      $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $prestasisiswa = PrestasiSiswa::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $prestasisiswa = $prestasisiswa->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_ids
        $prestasisiswa = $prestasisiswa->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.prestasisiswa.index", compact('walasList', 'walasIds', 'kepsek', 'prestasisiswa'));
    }
    public function generatePDFkepsekprestasi(Request $request)
{
     // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
     $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

     // Periksa apakah session 'kepsek_id' ada
     if (!session()->has('kepsek_id')) {
         return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
     }

     // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
     $kepsek = Kepsek::find(session('kepsek_id'));

     // Periksa apakah data kepsek ditemukan
     if (!$kepsek) {
         return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
     }

     // Ambil semua ID walas
    $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

    // Ambil data walas berdasarkan walas_id yang sesuai
    $walasList = Walas::whereIn('id', $walasIds)->get();

      // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
      $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
      $prestasisiswa = PrestasiSiswa::whereIn('walas_id', $walasIds);

      if ($walasIdSelected) {
          $prestasisiswa = $prestasisiswa->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
      }

      // Ambil data agenda sesuai filter walas_ids
      $prestasisiswa = $prestasisiswa->get();

    // Ambil base64 dari request (grafik chart)
    $sertifImage = $request->input('sertifImage');
    $dokumImage = $request->input('dokumImage');

    // Konversi gambar bukti_url dan dokumentasi_url ke base64
    foreach ($prestasisiswa as $item) {
        $item->sertifikat_base64 = $this->convertToBase64($item->sertifikat_url);
        $item->dokumentasi_base64 = $this->convertToBase64($item->dokumentasi_url);
    }

    // Load view PDF
    $pdf = Pdf::loadView('pdfkepsek.prestasisiswa', compact('walasList', 'walasIds', 'kepsek', 'prestasisiswa', 'sertifImage', 'dokumImage'));

    return $pdf->stream('Prestasi_Siswa.pdf');
}

// Fungsi untuk mengubah gambar ke base64
private function convertToBase64($path)
{
    $fullPath = storage_path("app/public/" . $path);
    
    if (file_exists($fullPath)) {
        $imageData = file_get_contents($fullPath);
        $mimeType = mime_content_type($fullPath);
        return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
    }

    return null;
}

    public function grafikjaraktempuhkepsek(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
       $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data kepsek yang sedang login

       // Periksa apakah session 'kepsek_id' ada
       if (!session()->has('kepsek_id')) {
           return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
       }

       // Ambil data kepsek berdasarkan 'kepsek_id' yang ada di session
       $kepsek = Kepsek::find(session('kepsek_id'));

       // Periksa apakah data kepsek ditemukan
       if (!$kepsek) {
           return redirect('/loginkepsek')->with('error', 'Data Kaprog tidak ditemukan.');
       }

       // Ambil semua ID walas
      $walasIds = Walas::pluck('id'); // Mengambil hanya ID dalam bentuk array

      // Ambil data walas berdasarkan walas_id yang sesuai
      $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $grafikjaraktempuh = BiodataSiswa::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $grafikjaraktempuh = $grafikjaraktempuh->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

         // Kelompokkan data berdasarkan rentang jarak tempuh
         $dataJarak = [
            'Kurang dari 1 km' => 0,
            '1 km - 3 km' => 0,
            '3 km - 5 km' => 0,
            '5 km - 10 km' => 0,
            '10 km - 25 km' => 0,
            '25 km - 50 km' => 0,
            'Lebih dari 50 km' => 0,
        ];
    
        // Ambil semua data jarak tempuh dari database
        $jarakSiswa = BiodataSiswa::pluck('jarak_rumah');
    
        foreach ($jarakSiswa as $jarak) {
            preg_match('/\d+(\.\d+)?/', $jarak, $matches); // Ambil angka dari string (termasuk desimal)
            $km = isset($matches[0]) ? floatval($matches[0]) : null;
    
            if ($km !== null) {
                if ($km < 1) {
                    $dataJarak['Kurang dari 1 km']++;
                } elseif ($km < 3) {
                    $dataJarak['1 km - 3 km']++;
                } elseif ($km < 5) {
                    $dataJarak['3 km - 5 km']++;
                } elseif ($km < 10) {
                    $dataJarak['5 km - 10 km']++;
                } elseif ($km < 25) {
                    $dataJarak['10 km - 25 km']++;
                } elseif ($km < 50) {
                    $dataJarak['25 km - 50 km']++;
                } else {
                    $dataJarak['Lebih dari 50 km']++;
                }
            }
        }

        // Ambil data agenda sesuai filter walas_id
        $grafikjaraktempuh = $grafikjaraktempuh->get();

        // Return view dengan data yang difilter
        return view("homepagekepsek.admwalas.grafikjaraktempuh.index", compact('walasList', 'walasIds', 'kepsek', 'grafikjaraktempuh', 'dataJarak'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($walas_id)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login
    
        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }
  
        // Ambil data kurikulum berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));
        
        // Periksa apakah data kurikulum ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas berdasarkan walas_id
        $walas = Walas::find($walas_id);
    
        // Jika tidak ditemukan, kembalikan ke halaman sebelumnya dengan pesan error
        if (!$walas) {
            return redirect()->route('admwalasview.index')->with('error', 'Data Walas tidak ditemukan.');
        }
    
        // Kirim data ke view detail
        return view('homepagekaprog.admwalasview.admwalas', compact('walas', 'kakom'));
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
