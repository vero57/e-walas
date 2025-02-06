<?php

namespace App\Imports;

use App\Models\Kakom;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KakomImport implements ToModel, WithHeadingRow 
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Kakom([
        'nama' => $row['nama'],
        'no_wa' => $row['no_wa'],
        'password' => $row['password'],
        'kompetensi' => $row['kompetensi'],
        ]);
    }
}
