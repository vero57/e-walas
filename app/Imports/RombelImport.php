<?php

namespace App\Imports;

use App\Models\Walas;
use App\Models\Rombel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RombelImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $walas = Walas::where('nama', $row['walas'])->first();
            if($walas != null){
                Rombel::create([
                    'tingkat' => $row['tingkat'],
                    'kompetensi' => $row['kompetensi'],
                    'nama_kelas' => $row['nama_kelas'],
                    'walas_id' => $walas['id'],
                ]);
            }else {
                \Log::info("walas not found for: " . $row['walas']);
        }
    }
}
}