<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CATATAN KASUS SISWA</title>
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

    <div class="title">CATATAN KASUS SISWA</div>

    <table class="info-table">
    <td>Wali Kelas</td>
    <td>: {{ $walasList->first()->nama ?? 'Tidak Ada Data' }}</td>
</tr>
        <tr>
    <td>Tahun Pelajaran</td>
    <td>: {{ (date('n') >= 7 ? date('Y') : date('Y') - 1) . '/' . (date('n') >= 7 ? date('Y') + 1 : date('Y')) }}</td>
        </tr>
    </table>

    <table>
        <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kasus</th>
                <th>Tindak Lanjut</th>
                <th>Keterangan</th>
        </tr>
        @foreach ($catatankasus as $idx => $data)
            <tr>
            <td>{{ $idx + 1 }}</td>
                    <td>{{ $data->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</td>
                    <td>{{ $data->kasus }}</td>
                    <td>{{ $data->tindak_lanjut }}</td>
                    <td>{{ $data->keterangan }}</td>
            </tr>
        @endforeach
    </table>

</body>
</html>
