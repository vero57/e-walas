<!DOCTYPE html>
<html>
<head>
    <title>IDENTITAS KELAS</title>
    <style>
        body {
            font-family: Tahoma, sans-serif;
            font-size: 11px;
            line-height: 4; /* Line spacing 2.0 */
            margin: 30px;
        }
        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            color: white;
            background-color: #2671eb;
            padding: 10px;
            line-height: 1; 
        }
        .content {
            font-size: 11px;
        }
        .content .label {
            width: 200px;
            display: inline-block;
        }
        .content .dots {
            border-bottom: 1px dotted black;
            width: 300px;
            display: inline-block;
        }
        .section-title {
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="title">IDENTITAS KELAS</div>
    <div class="content">
        <div>
            <span class="label">SATUAN PENDIDIKAN</span>: SMKN 1 CIBINONG
        </div>
        <div>
            <span class="label">PROGRAM KEAHLIAN</span>: 
            <span class="dots">{{ $data->first()->program_keahlian ?? '..............................' }}</span>
        </div>
        <div>
            <span class="label">KONSENTRASI/KOMPETENSI KEAHLIAN</span>: 
            <span class="dots">{{ $data->first()->kompetensi_keahlian ?? '..............................' }}</span>
        </div>
        <div class="section-title">NAMA WALI KELAS</div>
        <div>
            <span class="label">KELAS X</span>: 
            <span class="dots">{{ $data->first()->walas10->nama ?? '..............................' }}</span>
        </div>
        <div>
            <span class="label">KELAS XI</span>: 
            <span class="dots">{{ $data->first()->walas11->nama ?? '..............................' }}</span>
        </div>
        <div>
            <span class="label">KELAS XII</span>: 
            <span class="dots">{{ $data->first()->walas12->nama ?? '..............................' }}</span>
        </div>
        <div>
            <span class="label">KELAS XIII</span>: 
            <span class="dots">{{ $data->first()->walas13->nama ?? '..............................' }}</span>
        </div>
        <div class="section-title">NAMA KETUA KELAS</div>
        <div>
            <span class="label">KELAS X</span>: 
            <span class="dots">{{ $data->first()->siswa10->nama ?? '..............................' }}</span>
        </div>
        <div>
            <span class="label">KELAS XI</span>: 
            <span class="dots">{{ $data->first()->siswa11->nama ?? '..............................' }}</span>
        </div>
        <div>
            <span class="label">KELAS XII</span>: 
            <span class="dots">{{ $data->first()->siswa12->nama ?? '..............................' }}</span>
        </div>
        <div>
            <span class="label">KELAS XIII</span>: 
            <span class="dots">{{ $data->first()->siswa13->nama ?? '..............................' }}</span>
        </div>
    </div>
</body>
</html>
