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
        .signature td, 
        .signature th {
        border: none !important;
        }
    </style>
</head>
<body>
<div class="title">
        BERITA ACARA KENAIKAN KELAS
    </div>
    <br>
    
    @foreach ($beritaAcara as $data)
    <p>Pada hari {{ $data->formatted_tanggal }},
    telah diselenggarakan rapat kenaikan kelas Tahun Pelajaran {{ now()->year - 1 }}/{{ now()->year }} 
    yang dihadiri oleh guru-guru SMK Negeri 1 Cibinong.</p>


        <p><strong>Hari/Tanggal:</strong> {{ $data->formatted_tanggal }}</p>
        <p><strong>Pukul:</strong> {{ $data->formatted_jam }}</p>
        <p><strong>Tempat:</strong> {{ $data->tempat }} SMKN 1 Cibinong</p>
        <p><strong>Jumlah peserta rapat:</strong> {{ $data->jumlah_peserta_rapat }} orang</p>

        @php
        $jumlah_naik = $data->laki_laki_naik + $data->perempuan_naik;
        $jumlah_tinggal = $data->laki_laki_tinggal + $data->perempuan_tinggal;
        $total_siswa = ($data->laki_laki_naik + $data->laki_laki_tinggal) + ($data->perempuan_naik + $data->perempuan_tinggal);
        $persentase_naik = $total_siswa > 0 ? round(($jumlah_naik / $total_siswa) * 100, 2) : 0;
        $persentase_tinggal = $total_siswa > 0 ? round(($jumlah_tinggal / $total_siswa) * 100, 2) : 0;
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
                <td>{{ $data->laki_laki_naik + $data->laki_laki_tinggal }}</td>
                <td>{{ $data->perempuan_naik + $data->perempuan_tinggal }}</td>
                <td>{{ $total_siswa }}</td>
            </tr>
        </table>

        <br>
        <h4>MEMUTUSKAN</h4>
        <p>Bahwa kelas {{ $data->rombel->nama_kelas }} dinyatakan:</p>
        
        <p><strong>Naik ke kelas {{ $data->kelas_baru }}:</strong></p>
        <table border="1" width="100%">
            <tr>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
            <tr>
                <td>{{ $data->laki_laki_naik }}</td>
                <td>{{ $data->perempuan_naik }}</td>
                <td>{{ $jumlah_naik }}</td>
                <td>{{ $persentase_naik }}%</td>
            </tr>
        </table>
        
        <p><strong>Tinggal di kelas {{ $data->rombel->nama_kelas }}:</strong></p>
        <table border="1" width="100%">
            <tr>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Jumlah</th>
                <th>Persentase</th>
            </tr>
            <tr>
                <td>{{ $data->laki_laki_tinggal }}</td>
                <td>{{ $data->perempuan_tinggal }}</td>
                <td>{{ $jumlah_tinggal }}</td>
                <td>{{ $persentase_tinggal }}%</td>
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