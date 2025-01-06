<?php

namespace App\Imports;
use Illuminate\Support\Facades\Hash;
use App\Models\Walas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WalasImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Walas([
        'nama' => $row['nama'],
        'jenis_kelamin' => $row['jenis_kelamin'],
        'no_wa' => $row['no_wa'],
        'password' => Hash::make($row['password']),
        'nip' => $row['nip'],
        ]);
    }
}
