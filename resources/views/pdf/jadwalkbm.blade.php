<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal KBM</title>
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

    <div class="title">JADWAL KEGIATAN BELAJAR MENGAJAR (KBM)</div>

    <table class="info-table">
        <tr>
            <td>Kelas</td>
            <td>: {{ $jadwalKbms->first()->rombel->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
    <td>Tahun Pelajaran</td>
    <td>: {{ (date('n') >= 7 ? date('Y') : date('Y') - 1) . '/' . (date('n') >= 7 ? date('Y') + 1 : date('Y')) }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <th rowspan="2">Jam Ke</th>
            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                <th colspan="2">{{ $hari }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $hari)
                <th>Mapel</th>
                <th>Guru</th>
            @endforeach
        </tr>
        @for ($jam = 1; $jam <= 12; $jam++)
            <tr>
                <td>{{ $jam }}</td>  {{-- Tambahkan kolom "Jam Ke" di kiri --}}
                @foreach (['senin', 'selasa', 'rabu', 'kamis', 'jumat'] as $hari)
                    @php
                        $jadwalHari = collect(json_decode($jadwalKbms->first()->$hari, true) ?? [])->firstWhere('jam', $jam);
                    @endphp
                    <td>{{ $jadwalHari ? $mapels[$jadwalHari['mapel_id']]->nama_mapel ?? '-' : '-' }}</td>
                    <td>{{ $jadwalHari ? $gurus[$jadwalHari['guru_id']]->nama ?? '-' : '-' }}</td>
                @endforeach
            </tr>
        @endfor
    </table>

    
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
