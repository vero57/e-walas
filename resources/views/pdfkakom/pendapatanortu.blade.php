<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Pendapatan Orang Tua</title>
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
        .chart-container {
            text-align: center;
            margin-top: 20px;
        }
        .signature {
            margin-top: 30px;
            width: 100%;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="title">REKAPITULASI PENDAPATAN ORANG TUA</div>
    
    <table>
        <tr>
            <th>No</th>
            <th>Nama Siswa</th>
            <th>Pendapatan Orang Tua</th>
        </tr>
        @foreach ($pendapatan as $idx => $data)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $data->nama_lengkap }}</td>
                <td>{{ $data->pendapatan_ortu }}</td>
            </tr>
        @endforeach
    </table>

    <div class="chart-container">
        <h3>Grafik Pendapatan Orang Tua</h3>
        @if($chartImage)
    <div style="text-align: center; margin-bottom: 20px;">
        <img src="{{ $chartImage }}" style="width: 100%; max-width: 600px;">
    </div>
@endif
    </div>

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
            <td style="text-align: center;">NIP: {{ optional($wakaKurikulum)->nip ?? '......................' }}</td>
            <td></td>
            <td style="text-align: center;">NIP: {{ optional($walas)->nip ?? '......................' }}</td>
        </tr>
    </table>
</div>
</body>
</html>