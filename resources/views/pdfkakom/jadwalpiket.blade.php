<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Piket</title>
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

    <div class="title">JADWAL PIKET KELAS</div>

    <table class="info-table">
        <tr>
            <td>Kelas</td>
            <td>: {{ $rombel->nama_kelas ?? '-' }}</td>
        </tr>
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
            <th>Hari</th>
            <th>Anggota Piket</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{ ucfirst($item['nama_hari']) }}</td>
                <td>
                    @if ($item['siswas']->isNotEmpty())
                        <!-- Menampilkan siswa dengan pemisah baris -->
                        @foreach ($item['siswas'] as $siswa)
                            {{ $siswa->nama }}<br>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
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
