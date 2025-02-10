<!DOCTYPE html>
<html>
<head>
    <title>STRUKTUR ORGANISASI KELAS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px; 
            line-height: 1.4;
            margin: 20px;
        }
        .title {
            text-align: center;
            font-size: 12px; /* Menyesuaikan ukuran font judul */
            font-weight: bold;
            text-transform: uppercase;
            color: white;
            background-color: #2671eb;
            padding: 8px; /* Mengurangi padding */
            margin-bottom: 15px; /* Mengurangi margin bawah */
        }
        .tree-container {
            text-align: center;
            margin: 0 auto;
        }
        .node {
            display: inline-block;
            margin: 5px; /* Mengurangi margin antar kotak */
            text-align: center;
            padding: 8px; /* Mengurangi padding di dalam kotak */
            border: 1px solid black;
            width: 150px; /* Mengurangi lebar kotak */
        }
        .line {
            width: 2px;
            height: 25px; /* Mengurangi tinggi garis */
            background-color: black;
            margin: 0 auto;
        }
        .line-horizontal {
            width: 20px;
            height: 2px;
            background-color: black;
            margin: 0 auto;
        }
        .branch {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .footer {
            margin-top: 30px; /* Mengurangi margin atas footer */
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
@foreach ($struktur as $data)
    <div class="title">STRUKTUR ORGANISASI KELAS<br>TAHUN PELAJARAN 20../20..</div>
    <div class="tree-container">
        <!-- Kepala Sekolah -->
        <div class="node">Kepala Sekolah<br>{{ $data->kepala_sekolah ?? '...' }}</div>
        <div class="line"></div>

        <!-- Wali Kelas -->
        <div class="node">Wali Kelas<br>{{ $data->wali_kelas ?? '...' }}</div>
        <div class="line"></div>

        <!-- Ketua Kelas -->
        <div class="node">Ketua Kelas<br>{{ $data->ketua_kelas ?? '...' }}</div>
        <div class="line"></div>

        <!-- Wakil Ketua Kelas -->
        <div class="node">Wakil Ketua Kelas<br>{{ $data->wakil_ketua_kelas ?? '...' }}</div>
        
        <!-- Branching (Bendahara dan Sekretaris) -->
        <div class="branch">
            <div>
                <div class="line"></div>
                <div class="line-horizontal"></div>
                <div class="node">Bendahara Kelas<br>{{ $data->bendahara ?? '...' }}</div>
                <div class="node">Sekretaris<br>{{ $data->sekretaris ?? '...' }}</div>
                <div class="branch">
                <div class="line"></div>
                <div class="line-horizontal"></div>
                    <div class="node">Seksi Kebersihan<br>{{ $data->seksi_kebersihan ?? '...' }}</div>
                    <div class="node">Seksi Perlengkapan<br>{{ $data->seksi_perlengkapan ?? '...' }}</div>
                </div>
            </div>
            <div>
            <div class="line"></div>
                <div class="line-horizontal"></div>
                <div class="branch">
                    <div class="node">Seksi Keamanan<br>{{ $data->seksi_keamanan ?? '...' }}</div>
                    <div class="node">Seksi Kerohanian<br>{{ $data->seksi_kerohanian ?? '...' }}</div>
                </div>
            </div>
        </div>
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
                <td style="text-align: center;">({{ optional($walaslogin)->nama ?? '_________________' }})</td>
            </tr>
            <tr>
                <td style="text-align: center;">NIP  {{ optional($wakaKurikulum)->nip ?? '......................' }}</td>
                <td></td>
                <td style="text-align: center;">NIP  {{ optional($walaslogin)->nip ?? '......................' }}</td>
            </tr>
        </table>
    </div>
@endforeach
</body>
</html>
