<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Visit Report</title>
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
    <div class="title">LAPORAN HOME VISIT</div>
    <pre>
    Storage Path: {{ storage_path('app/public/homevisit/Photos/' . $item->bukti_url) }} <br>
    Public Path: {{ public_path('storage/homevisit/Photos/' . $item->bukti_url) }} <br>
    File Exists (Storage) : {{ file_exists(storage_path('app/public/homevisit/Photos/' . $item->bukti_url)) ? 'Ya' : 'Tidak' }} <br>
    File Exists (Public) : {{ file_exists(public_path('storage/homevisit/Photos/' . $item->bukti_url)) ? 'Ya' : 'Tidak' }} <br>
</pre>

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
            <th>Tanggal</th>
            <th>Nama Peserta Didik</th>
            <th>Keperluan</th>
            <th>Solusi</th>
            <th>Tindak Lanjut</th>
            <th>Foto Surat</th>
            <th>Dokumentasi</th>
        </tr>
        @foreach($homevisit as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->siswa->nama ?? 'Siswa Tidak Ditemukan' }}</td>
                <td>{{ $item->kasus }}</td>
                <td>{{ $item->solusi }}</td>
                <td>{{ $item->tindak_lanjut }}</td>
                <td>
    @php
        $imagePath = storage_path('app/public/homevisit/Photos/' . $item->bukti_url);
    @endphp

    @if(file_exists($imagePath))
        @php
            $imageData = base64_encode(file_get_contents($imagePath));
        @endphp
        <img style="width: 150px; margin-top: 5px; border: 1px solid lightgray; display: inline-block;"
             src="data:image/{{ pathinfo($item->bukti_url, PATHINFO_EXTENSION) }};base64,{{ $imageData }}">
    @else
        <p>Gambar tidak ditemukan: {{ $imagePath }}</p>
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