<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>berita acara </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            background-color: #007bff;
            color: white;
            padding: 5px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 5px;
        }
        th {
            background-color: #f2f2f2;
        }
        .info-table {
            width: 50%;
            margin-bottom: 10px;
        }
        .signature {
            margin-top: 30px;
            width: 100%;
            text-align: left;
        }
    </style>
</head>
<body>
<div class="title">
        BERITA ACARA KELULUSAN
    </div>
    <br>
    
    @foreach ($beritaAcaraKelulusan as $data)
    <p>Pada hari {{ $data->formatted_tanggal }},
    telah diselenggarakan rapat kelulusan Tahun Pelajaran {{ now()->year - 1 }}/{{ now()->year }} 
    yang dihadiri oleh guru-guru SMK Negeri 1 Cibinong.</p>


        <p><strong>Hari/Tanggal:</strong> {{ $data->formatted_tanggal }}</p>
        <p><strong>Pukul:</strong> {{ $data->formatted_jam }}</p>
        <p><strong>Tempat:</strong> {{ $data->tempat }} SMKN 1 Cibinong</p>
        <p><strong>Jumlah peserta rapat:</strong> {{ $data->jumlah_peserta_rapat }} orang</p>

        @php
        $jumlah_lulus = $data->laki_laki_lulus + $data->perempuan_lulus;
        $jumlah_tidaklulus = $data->laki_laki_tidaklulus + $data->perempuan_tidaklulus;
        $total_siswa = ($data->laki_laki_lulus + $data->laki_laki_tidaklulus) + ($data->perempuan_lulus + $data->perempuan_tidaklulus);
        $persentase_lulus = $total_siswa > 0 ? round(($jumlah_lulus / $total_siswa) * 100, 2) : 0;
        $persentase_tidaklulus = $total_siswa > 0 ? round(($jumlah_tidaklulus / $total_siswa) * 100, 2) : 0;
    @endphp
        <br>
        <p><strong>Jumlah Peserta Didik kelas {{ $data->rombel->nama_kelas }} sebagai berikut:</strong></p>
        <table border="1" width="100%">
            <tr>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Jumlah</th>
            </tr>
            <tr>
                <td>{{ $data->laki_laki_lulus + $data->laki_laki_tidaklulus }}</td>
                <td>{{ $data->perempuan_lulus + $data->perempuan_tidaklulus }}</td>
                <td>{{ $total_siswa }}</td>
            </tr>
        </table>

        <br>
        <h4 style="text-align: center;">MEMUTUSKAN</h4>
        <p>Bahwa kelas {{ $data->rombel->nama_kelas }} dinyatakan:</p>
        
        <p><strong>LULUS </strong></p>
        <table border="1" width="100%">
            <tr>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
            <tr>
                <td>{{ $data->laki_laki_lulus }}</td>
                <td>{{ $data->perempuan_lulus }}</td>
                <td>{{ $jumlah_lulus }}</td>
                <td>{{ $persentase_lulus }}%</td>
            </tr>
        </table>
        
        <p><strong>TIDAK LULUS </strong></p>
        <table border="1" width="100%">
            <tr>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
            <tr>
                <td>{{ $data->laki_laki_tidaklulus }}</td>
                <td>{{ $data->perempuan_tidaklulus }}</td>
                <td>{{ $jumlah_tidaklulus }}</td>
                <td>{{ $persentase_tidaklulus }}%</td>
            </tr>
        </table>
        <br><br>
    @endforeach

    @php
        $wakaKurikulum = \App\Models\Kurikulum::first(); // Ambil satu data Waka Kurikulum
        \Carbon\Carbon::setLocale('id');
    @endphp

    <div class="signature">
        <table style="border: none; width: 100%;">
            <tr>
                <td style="text-align: center;">Mengetahui,</td>
                <td></td>
                <td style="text-align: center;">Cibinong, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            </tr>
            <tr>
                <td style="text-align: center;">Waka. Bidang Akademik,</td>
                <td></td>
                <td style="text-align: center;">Wali Kelas,</td>
            </tr>
            <tr><td colspan="3"><br><br><br></td></tr>
            <tr>
                <td style="text-align: center;">({{ optional($wakaKurikulum)->nama ?? '_________________' }})</td>
                <td></td>
                <td style="text-align: center;">({{ optional($walas)->nama ?? '_________________' }})</td>
            </tr>
            <tr>
                <td style="text-align: center;">NIP  {{ optional($wakaKurikulum)->nip ?? '......................' }}</td>
                <td></td>
                <td style="text-align: center;">NIP  {{ optional($walas)->nip ?? '......................' }}</td>
            </tr>
        </table>
    </div>

</body>
</html>