<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafik Jarak Tempuh</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            width: 297mm;
            height: 210mm;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20mm;  /* Ruang tambahan agar gambar tidak kepotong */
        }

        .title {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    text-align: center;
    font-weight: bold;
    font-size: 16px;
    background-color: #007bff;
    color: white;
    padding: 10px;
    border-radius: 0;
    margin: 0;
}

        .chart-container {
            width: 80%;
            height: auto;
            text-align: center;
            padding: 10px;
        }

        .grafik-img {
            max-width: 90%;  /* Maksimal lebar 90% dari container */
            max-height: 70vh; /* Hindari gambar terlalu tinggi */
            object-fit: contain;  /* Jaga proporsi */
            border: 1px solid #ddd; /* Opsional: beri border biar rapi */
            border-radius: 5px;
            padding: 5px;
            background: white;
        }
    </style>
</head>
<body>
    <div class="title">Grafik Jarak Tempuh Siswa</div>
    <br><br>

    @if($chartImage)
        <div class="chart-container">
            <img src="{{ $chartImage }}" class="grafik-img" alt="Grafik Jarak Tempuh">
        </div>
    @endif
</body>
</html>
