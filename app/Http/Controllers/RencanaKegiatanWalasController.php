<?php

use Illuminate\Http\Request;
use App\Models\RencanaKegiatanWalas; // model untuk ganjil
use App\Models\RencanaKegiatanWalasGenap; // model untuk genap

class RencanaKegiatanWalasController extends Controller
{
    public function index($semester)
    {
        $model = $semester === 'ganjil' ? RencanaKegiatanWalas::class : RencanaKegiatanWalasGenap::class;
        $data = $model::with('walas', 'kurikulum')->get();

        return view('admwalas.rencana_kegiatan_walas.index', compact('data', 'semester'));
    }

    public function create($semester)
    {
        return view('admwalas.rencana_kegiatan_walas.create', compact('semester'));
    }

    public function store(Request $request, $semester)
    {
        $model = $semester === 'ganjil' ? RencanaKegiatanWalas::class : RencanaKegiatanWalasGenap::class;

        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'minggu_ke' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18',
            'kegiatan_bukti' => 'required',
            'keterangan' => 'required|in:true,false',
            'tanggalttd' => 'nullable|date',
            'ttdkurikulum_url' => 'nullable|string|max:255',
            'ttdwalas_url' => 'nullable|string|max:255',
        ]);

        $model::create($request->all());
        return redirect()->route('rencana_kegiatan_walas.index', $semester)
            ->with('success', 'Data berhasil disimpan!');
    }

    public function edit($semester, $id)
    {
        $model = $semester === 'ganjil' ? RencanaKegiatanWalas::class : RencanaKegiatanWalasGenap::class;
        $data = $model::findOrFail($id);

        return view('admwalas.rencana_kegiatan_walas.edit', compact('data', 'semester'));
    }

    public function update(Request $request, $semester, $id)
    {
        $model = $semester === 'ganjil' ? RencanaKegiatanWalas::class : RencanaKegiatanWalasGenap::class;

        $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'minggu_ke' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18',
            'kegiatan_bukti' => 'required',
            'keterangan' => 'required|in:true,false',
            'tanggalttd' => 'nullable|date',
            'ttdkurikulum_url' => 'nullable|string|max:255',
            'ttdwalas_url' => 'nullable|string|max:255',
        ]);

        $data = $model::findOrFail($id);
        $data->update($request->all());

        return redirect()->route('rencana_kegiatan_walas.index', $semester)
            ->with('success', 'Data berhasil diperbarui!');
    }
}
