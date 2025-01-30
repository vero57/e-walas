<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\JadwalKbm;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class JadwalKbmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

public function index(Request $request)
{
    $jadwalKbms = JadwalKbm::with(['rombel', 'walas', 'mapels', 'gurus'])->get();
    $message = $jadwalKbms->isEmpty() ? 'Data jadwal belum tersedia.' : null;

    $mapels = Mapel::all()->keyBy('id');
    $gurus = Guru::all()->keyBy('id');

    if ($request->input('export') === 'pdf') {
        $data = [
            'jadwalKbms' => $jadwalKbms,
            'mapels' => $mapels,
            'gurus' => $gurus
        ];
        $pdf = Pdf::loadView('pdf.jadwalkbm', $data)->setPaper('A4', 'portrait');
        return $pdf->download('Jadwal_KBM.pdf');
    }
    

    return view('admwalas.jadwalkbm.index', compact('jadwalKbms', 'mapels', 'gurus', 'message'));
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
{
    $rombels = Rombel::all(); 
    $walasList = Walas::all(); 
    $mapels = Mapel::all();
    $gurus = Guru::all();

    return view('admwalas.jadwalkbm.create', compact('rombels', 'walasList', 'mapels', 'gurus'));
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $request->validate([
        'rombels_id' => 'required|exists:rombels,id',
        'walas_id' => 'required|exists:walas,id',
        'senin' => 'nullable|array',
        'selasa' => 'nullable|array',
        'rabu' => 'nullable|array',
        'kamis' => 'nullable|array',
        'jumat' => 'nullable|array',
    ]);

    // Loop dan pastikan setiap jam memiliki mapel dan guru yang valid
    $senin = $this->prepareScheduleData($request->senin);
    $selasa = $this->prepareScheduleData($request->selasa);
    $rabu = $this->prepareScheduleData($request->rabu);
    $kamis = $this->prepareScheduleData($request->kamis);
    $jumat = $this->prepareScheduleData($request->jumat);

    // Simpan data ke database
    JadwalKbm::create([
        'rombels_id' => $request->rombels_id,
        'walas_id' => $request->walas_id,
        'senin' => json_encode($senin),
        'selasa' => json_encode($selasa),
        'rabu' => json_encode($rabu),
        'kamis' => json_encode($kamis),
        'jumat' => json_encode($jumat),
    ]);

    return redirect()->route('jadwalkbm.index')->with('success', 'Jadwal berhasil ditambahkan.');
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JadwalKbm  $jadwalKbm
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
{
    $jadwalKbm = JadwalKbm::find($id);

    if (!$jadwalKbm) {
        abort(404);
    }

    // Dekode JSON untuk setiap hari
    foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $hari) {
        $jadwalKbm->$hari = json_decode($jadwalKbm->$hari, true) ?? [];
    }

    $rombels = Rombel::all();
    $walasList = Walas::all();
    $mapels = Mapel::all();
    $gurus = Guru::all();

    return view('admwalas.jadwalkbm.edit', compact('jadwalKbm', 'rombels', 'walasList', 'mapels', 'gurus'));
}

public function update(Request $request, $id)
{
    // Ambil data jadwal berdasarkan ID
    $jadwalKbm = JadwalKbm::find($id);

    if (!$jadwalKbm) {
        return redirect()->route('jadwalkbm.index')->with('error', 'Data tidak ditemukan');
    }

    // Validasi data (contoh validasi)
    $request->validate([
        'rombels_id' => 'required|exists:rombels,id',
        'walas_id' => 'required|exists:walas,id',
        // Tambahkan validasi lain sesuai kebutuhan
    ]);

    // Siapkan data jadwal KBM
    $jadwalKbm->rombels_id = $request->rombels_id;
    $jadwalKbm->walas_id = $request->walas_id;

    // Proses data hari (contoh: senin)
    $jadwalKbm->senin = json_encode($this->prepareScheduleData($request->input('senin')));
    $jadwalKbm->selasa = json_encode($this->prepareScheduleData($request->input('selasa')));
    $jadwalKbm->rabu = json_encode($this->prepareScheduleData($request->input('rabu')));
    $jadwalKbm->kamis = json_encode($this->prepareScheduleData($request->input('kamis')));
    $jadwalKbm->jumat = json_encode($this->prepareScheduleData($request->input('jumat')));

    // Simpan data ke database
    $jadwalKbm->save();

    // Redirect dengan pesan sukses
    return redirect()->route('jadwalkbm.index')->with('success', 'Data jadwal berhasil diperbarui.');
}


    
            private function prepareScheduleData($scheduleData)
            {
                $preparedData = [];
                if (is_array($scheduleData)) {
                    foreach ($scheduleData as $jam => $detail) {
                        if (isset($detail['mapel']) && isset($detail['guru'])) {
                            $preparedData[] = [
                                'jam' => $jam,
                                'mapel_id' => $detail['mapel'],
                                'guru_id' => $detail['guru'],
                            ];
                        }
                    }
                }
                return $preparedData;
            }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JadwalKbm  $jadwalKbm
     * @return \Illuminate\Http\Response
     */
    public function destroy(JadwalKbm $jadwalKbm)
    {
        $jadwalKbm->delete();
        return redirect()->route('jadwalkbm.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
