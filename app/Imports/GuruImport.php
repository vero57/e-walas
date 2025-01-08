<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;


class GuruImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
   public function model(array $row)
    {
        if (isset($row['nama_lengkap_guru']) && !empty($row['nama_lengkap_guru'])) {
            return new Guru([
                'nama' => $row['nama_lengkap_guru'],
            ]);
        }

        // log data yang gagal
        Log::warning('Data kosong atau tidak valid di file excel', $row);

        return null;
    }
}
