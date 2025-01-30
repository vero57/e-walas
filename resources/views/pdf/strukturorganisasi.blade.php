<!DOCTYPE html>
<html>
<head>
    <title>STRUKTUR ORGANISASI KELAS</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            font-size: 10px; /* Mengurangi ukuran font */
            line-height: 1.4;
            margin: 20px; /* Mengurangi margin */
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
        .signature {
            display: flex;
            justify-content: space-between;
            margin: 30px 20px 0 20px; /* Mengurangi margin untuk signature */
        }
        .signature div {
            text-align: center;
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
    
    <div class="footer">
        <p>Cibinong, ...................</p>
        <div class="signature">
            <div>
                <p>Waka. Guru Akademik</p>
                <br><br><br>
                <p>_____________________<br>NIP: ................</p>
            </div>
            <div>
                <p>Wali Kelas</p>
                <br><br><br>
                <p>_____________________<br>NIP: ................</p>
            </div>
        </div>
    </div>
@endforeach
</body>
</html>
