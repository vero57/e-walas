<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Jumlah Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
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

    <div class="title">REKAPITULASI JUMLAH SISWA</div>
    
    <table>
        <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Jumlah Siswa Awal</th>
            <th>Jumlah Siswa Akhir</th>
            <th>Keterangan</th>
        </tr>
        @foreach ($rekapjumlahsiswa as $idx => $data)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $data->bulan }}</td>
                <td>{{ $data->jumlah_awal_siswa }}</td>
                <td>{{ $data->jumlah_akhir_siswa }}</td>
                <td>{{ $data->keterangan }}</td>
            </tr>
        @endforeach
    </table>


    <div class="signature">
        <table>
            <tr>
                <td>Mengetahui,</td>
                <td></td>
                <td>Cibinong, ..................... 20...</td>
            </tr>
            <tr>
                <td>Waka. Bidang Akademik,</td>
                <td></td>
                <td>Wali Kelas</td>
            </tr>
            <tr><td colspan="3"><br><br><br></td></tr>
            <tr>
                <td>(_________________)</td>
                <td></td>
                <td>(_________________)</td>
            </tr>
            <tr>
                <td>NIP: ......................</td>
                <td></td>
                <td>NIP: ......................</td>
            </tr>
        </table>
    </div>

</body>
</html>
