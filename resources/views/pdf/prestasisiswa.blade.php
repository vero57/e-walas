<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi Siswa</title>
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
        .img-container img {
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <div class="title">PRESTASI SISWA</div>

    <table class="info-table">
        <tr>
            <td>Wali Kelas</td>
            <td>: {{ $walas->nama ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>: {{ $rombel->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tahun Pelajaran</td>
            <td>: {{ date('Y') }}</td>
        </tr>
    </table>

    <table>
    <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Jenis Prestasi</th>
        <th>Nama Prestasi</th>
        <th>Tanggal</th>
        <th>Sertifikat</th>
        <th>Dokumentasi</th>
    </tr>
    @foreach($prestasisiswa as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</td>
            <td>{{ $item->jenis_prestasi }}</td>
            <td>{{ $item->nama_prestasi }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
            <td>
    @if($item->sertifikat_base64)
        <img src="{{ $item->sertifikat_base64 }}" style="width: 100%; max-width: 200px;">
    @else
        <p>No image</p>
    @endif
</td>

<td>
    @if($item->dokumentasi_base64)
        <img src="{{ $item->dokumentasi_base64 }}" style="width: 100%; max-width: 200px;">
    @else
        <p>No image</p>
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
                <td>{{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td>Wali Kelas</td>
                <td></td>
                <td>Waka. Bidang Akademik</td>
            </tr>
            <tr><td colspan="3"><br><br><br></td></tr>
            <tr>
                <td>(_________________)</td>
                <td></td>
                <td>(_________________)</td>
            </tr>
        </table>
    </div>
</body>
</html>