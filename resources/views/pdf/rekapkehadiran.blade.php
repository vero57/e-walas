<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran</title>
    <style>
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
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
        }
        th {
            background-color: #ddd;
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
        REKAP KEHADIRAN PESERTA DIDIK
    </div>
    

    <!-- Tabel untuk Semester Genap (Januari-Juni) -->
    @if ($semester === 'genap')
    <table border>
        <caption>Rekap Kehadiran Semester Genap (Januari - Juni)</caption>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Peserta Didik</th>
            <th colspan="4">Januari</th>
            <th colspan="4">Februari</th>
            <th colspan="4">Maret</th>
            <th colspan="4">April</th>
            <th colspan="4">Mei</th>
            <th colspan="4">Juni</th>
            <th colspan="2">Jumlah Kehadiran</th>
        </tr>
        <tr>
            @for ($i = 0; $i < 6; $i++)
                <th>H</th>
                <th>I</th>
                <th>S</th>
                <th>A</th>
            @endfor
                <th>H</th>
                <th>TH</th>
        </tr>

        @php
    $siswaData = [];
@endphp

@foreach ($presensis as $presensi)
    @foreach ($presensi->detailPresensis as $detail)
        @php
            $nama = $detail->siswa->nama;
            $bulan = \Carbon\Carbon::parse($presensi->tanggal)->format('n'); 
            $status = $detail->status;

            if (!isset($siswaData[$nama])) {
                $siswaData[$nama] = [];
                for ($i = 1; $i <= 6; $i++) {
                    $siswaData[$nama][$i] = ['H' => 0, 'I' => 0, 'S' => 0, 'A' => 0];
                }
                $siswaData[$nama]['total_hadir'] = 0;
                $siswaData[$nama]['total_pertemuan'] = 0;
            }

            // Pastikan bulan dalam range 1-6 agar sesuai semester genap
            if ($bulan >= 1 && $bulan <= 6) {
                if ($status === 'hadir') {
                    $siswaData[$nama][$bulan]['H'] += 1;
                    $siswaData[$nama]['total_hadir'] += 1;
                } elseif ($status === 'izin') {
                    $siswaData[$nama][$bulan]['I'] += 1;
                } elseif ($status === 'sakit') {
                    $siswaData[$nama][$bulan]['S'] += 1;
                } elseif ($status === 'alfa') {
                    $siswaData[$nama][$bulan]['A'] += 1;
                }

                $siswaData[$nama]['total_pertemuan'] += 1;
            }
        @endphp
    @endforeach
@endforeach

@php $no = 1; @endphp
@foreach ($siswaData as $nama => $data)
    <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $nama }}</td>
        @for ($i = 1; $i <= 6; $i++)
            <td>{{ $data[$i]['H'] }}</td>
            <td>{{ $data[$i]['I'] }}</td>
            <td>{{ $data[$i]['S'] }}</td>
            <td>{{ $data[$i]['A'] }}</td>
        @endfor
        <td>{{ $data['total_hadir'] }}</td>
        <td>
            @php
                $total_tidakhadir = $data['total_pertemuan'] > 0 ? round($data['total_pertemuan'] - $data['total_hadir']) : 0;
            @endphp
            {{ $total_tidakhadir }}
        </td>
    </tr>
@endforeach
    </table>
    @endif

    <!-- Tabel untuk Semester Ganjil (Juli-Desember) -->
    @if ($semester === 'ganjil')
    <table border>
        <caption>Rekap Kehadiran Semester Ganjil (Juli - Desember)</caption>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama Peserta Didik</th>
            <th colspan="4">Juli</th>
            <th colspan="4">Agustus</th>
            <th colspan="4">September</th>
            <th colspan="4">Oktober</th>
            <th colspan="4">November</th>
            <th colspan="4">Desember</th>
            <th colspan="2">Jumlah Kehadiran</th>
        </tr>
        <tr>
        @for ($i = 7; $i <= 12; $i++)
                <th>H</th>
                <th>I</th>
                <th>S</th>
                <th>A</th>
            @endfor
                <th>H</th>
                <th>TH</th>
        </tr>

        @php
    $siswaData = [];
@endphp

@foreach ($presensis as $presensi)
    @foreach ($presensi->detailPresensis as $detail)
        @php
            $nama = $detail->siswa->nama;
            $bulan = \Carbon\Carbon::parse($presensi->tanggal)->format('n'); 
            $status = $detail->status;

            if (!isset($siswaData[$nama])) {
                $siswaData[$nama] = [];
                for ($i = 7; $i <= 12; $i++) {
                    $siswaData[$nama][$i] = ['H' => 0, 'I' => 0, 'S' => 0, 'A' => 0];
                }
                $siswaData[$nama]['total_hadir'] = 0;
                $siswaData[$nama]['total_pertemuan'] = 0;
            }

            
            if ($bulan >= 7 && $bulan <= 12) {
                if ($status === 'hadir') {
                    $siswaData[$nama][$bulan]['H'] += 1;
                    $siswaData[$nama]['total_hadir'] += 1;
                } elseif ($status === 'izin') {
                    $siswaData[$nama][$bulan]['I'] += 1;
                } elseif ($status === 'sakit') {
                    $siswaData[$nama][$bulan]['S'] += 1;
                } elseif ($status === 'alfa') {
                    $siswaData[$nama][$bulan]['A'] += 1;
                }

                $siswaData[$nama]['total_pertemuan'] += 1;
            }
        @endphp
    @endforeach
@endforeach

@php $no = 1; @endphp
@foreach ($siswaData as $nama => $data)
    <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $nama }}</td>
        @for ($i = 7; $i <= 12; $i++)
            <td>{{ $data[$i]['H'] }}</td>
            <td>{{ $data[$i]['I'] }}</td>
            <td>{{ $data[$i]['S'] }}</td>
            <td>{{ $data[$i]['A'] }}</td>
        @endfor
        <td>{{ $data['total_hadir'] }}</td>
        <td>
            @php
                $total_tidakhadir = $data['total_pertemuan'] > 0 ? round($data['total_pertemuan'] - $data['total_hadir']) : 0;
            @endphp
            {{ $total_tidakhadir }}
        </td>
    </tr>
@endforeach
    </table>
    @endif

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
