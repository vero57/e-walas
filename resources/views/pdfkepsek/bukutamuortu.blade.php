<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu Ortu</title>
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
    <div class="title">BUKU TAMU ORTU</div>

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
        <th>No</th>
        <th>Tanggal</th>
        <th>Nama Peserta Didik</th>
        <th>Nama Orang Tua/Wali</th>
        <th>Keperluan</th>
        <th>Solusi</th>
        <th>Tindak Lanjut</th>
        <th>Dokumentasi</th>
    </tr>
    @foreach($bukutamu as $index => $item)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</td>
            <td>{{ $item->nama_orang_tua }}</td>
            <td>{{ $item->kasus }}</td>
            <td>{{ $item->solusi }}</td>
            <td>{{ $item->tindak_lanjut }}</td>
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


@php
\Carbon\Carbon::setLocale('id');
@endphp
    <div class="signature">
        <table>
            <tr>
                <td>Mengetahui,</td>
                <td></td>
                <td>Cibinong, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</td>
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