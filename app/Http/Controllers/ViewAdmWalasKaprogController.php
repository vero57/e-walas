<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kakom;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Presensi;
use App\Models\HomeVisit;
use App\Models\JadwalKbm;
use App\Models\JadwalPiket;
use App\Models\BiodataSiswa;
use Illuminate\Http\Request;
use App\Models\PrestasiSiswa;
use App\Models\IdentitasKelas;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\BukuTamuOrangtua;
use App\Models\LembarPengesahan;
use App\Models\CatatanKasusSiswa;
use App\Models\DetailJadwalPiket;
use App\Models\DaftarPesertaDidik;
use Illuminate\Support\Facades\DB;
use App\Models\AgendaKegiatanWalas;
use Illuminate\Support\Facades\Auth;
use App\Models\DaftarSerahTerimaRapor;
use App\Models\PersentaseSosialEkonomi;
use App\Models\RekapitulasiJumlahSiswa;
use App\Models\StrukturOrganisasiKelas;

class ViewAdmWalasKaprogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function agendawalas(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $agendaList = AgendaKegiatanWalas::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $agendaList = $agendaList->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $agendaList = $agendaList->get();

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfkakom.agendawalas', compact('walasList', 'walasIds', 'kakom', 'agendaList'));
            return $pdf->stream('Agenda_Walas.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekaprog.admwalas.agendawalas.index", compact('walasList', 'walasIds', 'kakom', 'agendaList'));
    }

    public function identitaskelas(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

        // Ambil data walas berdasarkan walas_id yang sesuai
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
            $pdf = Pdf::loadView('pdfkakom.identitaskelas', ['data' => $identiasKelasList]);
            return $pdf->stream('Identitas_Kelas.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekaprog.admwalas.identitaskelas.index", compact('walasList', 'walasIds', 'kakom', 'identiasKelasList'));
    } 

    public function lembarpengesahan(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

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
        return view("homepagekaprog.admwalas.lembarpengesahan.index", compact('walasList', 'walasIds', 'kakom', 'lembarPengesahan'));
    } 

    public function strukturorganisasikelas(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

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
        return view("homepagekaprog.admwalas.strukturorganisasi.index", compact('walasList', 'walasIds', 'kakom', 'strukturOrganisasi'));
    } 

    public function jadwalkbm(Request $request)
{
    if (!session()->has('kakom_id')) {
        return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
    }

    $kakom = Kakom::find(session('kakom_id'));

    if (!$kakom) {
        return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
    }

    $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');
    $walasList = Walas::whereIn('id', $walasIds)->get();

    $walasIdSelected = $request->query('walas_id');
    $rombel = $walasIdSelected ? Rombel::where('walas_id', $walasIdSelected)->first() : null;

    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel untuk Walas ini tidak ditemukan.');
    }// Menggunakan guard 'walas' untuk mendapatkan data walas yang login
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
    // Ambil data siswa berdasarkan rombel yang terkait dengan walas
    $siswa = DB::table('siswas')
                ->where('rombels_id', $rombel->id)  // Sesuaikan dengan kolom yang tepat
                ->get();

    // Ambil semua data rombel
    $rombels = Rombel::all();

    $jadwalKbm = JadwalKBM::with(['rombel', 'walas', 'mapels', 'gurus'])
        ->where('walas_id', $walas->id)
        ->get();

    $mapels = Mapel::all()->keyBy('id');
    $gurus = Guru::all()->keyBy('id');

    $dataHari = [
        'senin'  => json_decode($jadwalKbm->first()->senin, true)  ?? [],
        'selasa' => json_decode($jadwalKbm->first()->selasa, true) ?? [],
        'rabu'   => json_decode($jadwalKbm->first()->rabu, true)   ?? [],
        'kamis'  => json_decode($jadwalKbm->first()->kamis, true)  ?? [],
        'jumat'  => json_decode($jadwalKbm->first()->jumat, true)  ?? [],
    ];
    return view("homepagekaprog.admwalas.jadwalkbm.index", [
        'walasList' => $walasList,
        'walasIds' => $walasIds,
        'kakom' => $kakom,
        'jadwalKbm' => $jadwalKbm->first(),
        'rombel' => $rombel,
        'siswa' => $siswa,
        'hari' => $dataHari,
        'mapels' => Mapel::pluck('nama_mapel', 'id'),
        'gurus' => Guru::pluck('nama', 'id'),
    ]);
}


    

    public function presensis(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id')->toArray();

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
            // Jika ada parameter 'export=pdf', generate PDF
    if (request()->has('export') && request()->get('export') === 'pdf') {
        $semester = request()->get('semester'); // Ambil semester yang dipilih
        $pdf = Pdf::loadView('pdfkakom.rekapkehadiran', compact('walasList', 'presensis', 'semester'))
            ->setPaper('A4', 'landscape');
        return $pdf->stream('rekap_kehadiran_' . $semester . '.pdf');
    }

        // Return view dengan data yang difilter
        return view("homepagekaprog.admwalas.presensi.index", compact('walasList', 'walasIds', 'kakom', 'presensis'));
    }

    public function piketkelas(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id')->toArray();

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        // Ambil data kelompok berdasarkan 'walas_id'
        $piket = JadwalPiket::whereIn('walas_id', $walasIds)->get();
    
        // Ambil data siswa yang terhubung dengan kelompok menggunakan model DetailJadwalPiket
        $detailpiket = DetailJadwalPiket::whereIn('jadwalpikets_id', $piket->pluck('id'))->get();

        // Ambil data rombel berdasarkan 'walas_id'
        $rombel = Rombel::where('walas_id', $walasIds)->first();
        
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
            $pdf = Pdf::loadView('pdfkakom.jadwalpiket', compact( 'walasList','data', 'siswas', 'rombel'));
            return $pdf->stream('Jadwal_Piket.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekaprog.admwalas.jadwalpiket.index", compact('walasList', 'walasIds', 'kakom', 'piket', 'detailpiket', 'data', 'siswas'));
    }

    public function serahterimarapor(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

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
        return view("homepagekaprog.admwalas.daftarpenyerahanrapot.index", compact('walasList', 'walasIds', 'kakom', 'rapor'));
    }

    public function catatankasus(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

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

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfkakom.catatankasus', compact('walasList', 'walasIds','kakom', 'catatankasus'));
            return $pdf->stream('Catatan_Kasus.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekaprog.admwalas.catatankasus.index", compact('walasList', 'walasIds', 'kakom', 'catatankasus'));
    }

    public function daftarpesertadidik(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id')->toArray();

        // Pastikan $walasIds tidak kosong
        if (empty($walasIds)) {
            return redirect('/')->with('error', 'Tidak ada wali kelas yang sesuai dengan kompetensi.');
        }

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

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfkakom.daftarpesertadidik', compact('walasList', 'walasIds', 'kakom', 'daftarPDidik', 'jenisKelaminCount'));
            return $pdf->stream('Daftar_Peserta_Didik.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekaprog.admwalas.daftarpesertadidik.index", compact('walasList', 'walasIds', 'kakom', 'daftarPDidik', 'jenisKelaminCount'));
    }

    public function rekapitulasipdidik(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

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

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfkakom.rekapitulasijumlahsiswa', compact('walasList', 'walasIds', 'kakom', 'rekapitulasiPDidik'));
            return $pdf->stream('Rekap_Jumlah_Siswa.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekaprog.admwalas.rekapitulasijumlahsiswa.index", compact('walasList', 'walasIds', 'kakom', 'rekapitulasiPDidik'));
    }

    public function homevisit(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

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
        return view("homepagekaprog.admwalas.homevisit.index", compact('walasList', 'walasIds', 'kakom', 'homevisit'));
    }
    
public function generatePDFhomevisit(Request $request)
{
// Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
$kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

// Periksa apakah session 'kakom_id' ada
if (!session()->has('kakom_id')) {
    return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
}

// Ambil data kakom berdasarkan 'kakom_id' yang ada di session
$kakom = Kakom::find(session('kakom_id'));

// Periksa apakah data kakom ditemukan
if (!$kakom) {
    return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
}

// Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
$walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

// Ambil data walas berdasarkan walas_id yang sesuai
$walasList = Walas::whereIn('id', $walasIds)->get();

// Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
$walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
$homevisit = HomeVisit::whereIn('walas_id', $walasIds);

if ($walasIdSelected) {
    $homevisit = $homevisit->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
}
// Ambil data rombel berdasarkan 'walas_id'
$rombel = Rombel::where('walas_id', $walasIds)->first();
        
// Periksa apakah rombel ditemukan
if (!$rombel) {
    return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
}

// Ambil data agenda sesuai filter walas_id
$homevisit = $homevisit->get();
    // Ambil base64 dari request (grafik chart)
    $suratImage = $request->input('suratImage');
    $dokumImage = $request->input('dokumImage');

    // Konversi gambar bukti_url dan dokumentasi_url ke base64
    foreach ($homevisit as $item) {
        $item->bukti_base64 = $this->convertToBase64($item->bukti_url);
        $item->dokumentasi_base64 = $this->convertToBase64($item->dokumentasi_url);
    }

    // Load view PDF
    $pdf = Pdf::loadView('pdfkakom.homevisit', compact('walasList', 'rombel', 'walasIds', 'kakom', 'homevisit', 'suratImage', 'dokumImage'));

    return $pdf->stream('Home_Visit.pdf');
}



    public function bukutamuortu(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

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
        return view("homepagekaprog.admwalas.bukutamuortu.index", compact('walasList', 'walasIds', 'kakom', 'bukutamu'));
    }
    public function generatePDFbukutamuortu(Request $request)
{
    // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
    $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

    // Periksa apakah session 'kakom_id' ada
    if (!session()->has('kakom_id')) {
        return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
    $kakom = Kakom::find(session('kakom_id'));

    // Periksa apakah data kakom ditemukan
    if (!$kakom) {
        return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
    }

    // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
    $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

    // Ambil data walas berdasarkan walas_id yang sesuai
    $walasList = Walas::whereIn('id', $walasIds)->get();

    // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
    $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
    $bukutamu = BukuTamuOrangtua::whereIn('walas_id', $walasIds);

    if ($walasIdSelected) {
        $bukutamu = $bukutamu->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
    }
    
    $rombel = Rombel::where('walas_id', $walasIds)->first();
            
    
    if (!$rombel) {
        return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
    }

    // Ambil data agenda sesuai filter walas_id
    $bukutamu = $bukutamu->get();

    $dokumImage = $request->input('dokumImage');

    foreach ($bukutamu as $item) {
        $item->dokumentasi_base64 = $this->convertToBase64($item->dokumentasi_url);
    }

    // Load view PDF
    $pdf = Pdf::loadView('pdfkakom.bukutamuortu', compact('rombel','walasList', 'walasIds', 'kakom', 'bukutamu', 'dokumImage'));

    return $pdf->stream('Buku_Tamu_Ortu.pdf');
}

    public function persentasesosialekonomi(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

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
        if (request()->has('export') && request()->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfkakom.persentasesosialekonomi', compact('walasList', 'walasIds', 'kakom', 'persentasesosialekonomi'));
            return $pdf->download('Persentase Sosial Ekonomi.pdf');
        }

        // Return view dengan data yang difilter
        return view("homepagekaprog.admwalas.persentasesosialekonomi.index", compact('walasList', 'walasIds', 'kakom', 'persentasesosialekonomi'));
    }

    public function rentangpendapatanortu(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id')->toArray();

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
        return view("homepagekaprog.admwalas.pendapatanortu.index", compact('walasList', 'walasIds', 'kakom','dataPendapatan', 'pendapatan', 'walasIdSelected'));
    }
    public function generatePDFpendapatanortu(Request $request)
{
    $pendapatan = BiodataSiswa::select('id', 'nama_lengkap', 'pendapatan_ortu')->get();
    $kakom = Kakom::find(session('kakom_id'));

    $dataPendapatan = [
        'Kurang dari Rp1.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Kurang dari Rp1.000.000,00')->count(),
        'Rp1.000.000,00 - Rp3.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp1.000.000,00 - Rp3.000.000,00')->count(),
        'Rp3.000.000,00 - Rp5.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp3.000.000,00 - Rp5.000.000,00')->count(),
        'Rp5.000.000,00 - Rp10.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp5.000.000,00 - Rp10.000.000,00')->count(),
        'Rp10.000.000,00 - Rp25.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp10.000.000,00 - Rp25.000.000,00')->count(),
        'Rp25.000.000,00 - Rp50.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Rp25.000.000,00 - Rp50.000.000,00')->count(),
        'Lebih dari Rp50.000.000,00' => BiodataSiswa::where('pendapatan_ortu', 'Lebih dari Rp50.000.000,00')->count(),
    ];

    // Ambil base64 dari request
    $chartImage = $request->input('chartImage');

    $pdf = Pdf::loadView('pdfkakom.pendapatanortu', compact('pendapatan', 'kakom', 'dataPendapatan', 'chartImage'));
    return $pdf->stream('Pendapatan_Orang_Tua.pdf');
}

    public function prestasisiswa(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

        // Ambil data walas berdasarkan walas_id yang sesuai
        $walasList = Walas::whereIn('id', $walasIds)->get();

        // Ambil data agenda kegiatan walas berdasarkan walas_id yang sesuai
        $walasIdSelected = $request->query('walas_id'); // Ambil walas_id dari URL query parameter
        $prestasisiswa = PrestasiSiswa::whereIn('walas_id', $walasIds);

        if ($walasIdSelected) {
            $prestasisiswa = $prestasisiswa->where('walas_id', $walasIdSelected); // Filter berdasarkan walas_id yang dipilih
        }

        // Ambil data agenda sesuai filter walas_id
        $prestasisiswa = $prestasisiswa->get();

        // Return view dengan data yang difilter
        return view("homepagekaprog.admwalas.prestasisiswa.index", compact('walasList', 'walasIds', 'kakom', 'prestasisiswa'));
    }

    public function generatePDFprestasi(Request $request)
{
    $kakom = Auth::guard('kakoms')->user();  
    if (!session()->has('kakom_id')) {
        return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
    }

    $kakom = Kakom::find(session('kakom_id'));

    if (!$kakom) {
        return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
    }

    $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

    $walasList = Walas::whereIn('id', $walasIds)->get();

    $walasIdSelected = $request->query('walas_id');
    $prestasisiswa = PrestasiSiswa::whereIn('walas_id', $walasIds);

    if ($walasIdSelected) {
        $prestasisiswa = $prestasisiswa->where('walas_id', $walasIdSelected); 
    }

    $rombel = Rombel::where('walas_id', $walasIds)->first();
        
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/rombels')->with('error', 'Rombel tidak ditemukan.');
        }

    // Ambil data agenda sesuai filter walas_id
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
    $pdf = Pdf::loadView('pdfkakom.prestasisiswa', compact('rombel','kakom','walasList', 'prestasisiswa', 'sertifImage', 'dokumImage'));

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


    public function grafikjaraktempuh(Request $request)
    {
        // Menggunakan guard 'kakoms' untuk mendapatkan data kakom yang login
        $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data kakom yang sedang login

        // Periksa apakah session 'kakom_id' ada
        if (!session()->has('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data kakom berdasarkan 'kakom_id' yang ada di session
        $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

        // Ambil data walas_id dari tabel rombel berdasarkan 'kompetensi' yang sama dengan kakom
        $walasIds = Rombel::where('kompetensi', $kakom->kompetensi)->pluck('walas_id');

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
        return view("homepagekaprog.admwalas.grafikjaraktempuh.index", compact('walasList', 'walasIds', 'kakom', 'grafikjaraktempuh', 'dataJarak'));
    }
    public function generatePDFgrafikjaraktempuh(Request $request)
{
    $kakom = Kakom::find(session('kakom_id'));

        // Periksa apakah data kakom ditemukan
        if (!$kakom) {
            return redirect('/loginkaprog')->with('error', 'Data Kaprog tidak ditemukan.');
        }

    // Kelompokkan data jarak tempuh (sama seperti di index)
    $dataJarak = [
        'Kurang dari 1 km' => 0,
        '1 km - 3 km' => 0,
        '3 km - 5 km' => 0,
        '5 km - 10 km' => 0,
        '10 km - 25 km' => 0,
        '25 km - 50 km' => 0,
        'Lebih dari 50 km' => 0,
    ];

    $jarakSiswa = BiodataSiswa::pluck('jarak_rumah');

    foreach ($jarakSiswa as $jarak) {
        preg_match('/\d+(\.\d+)?/', $jarak, $matches);
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

    // Ambil base64 dari request (gambar grafik)
    $chartImage = $request->input('chartImage');

    // Load view PDF
    $pdf = Pdf::loadView('pdfkakom.grafikjaraktempuh', compact('kakom', 'dataJarak', 'chartImage'))
    ->setPaper('A4', 'landscape');
    return $pdf->stream('Jarak_rumah_Siswa.pdf');
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
