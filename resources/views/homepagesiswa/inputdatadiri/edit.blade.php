<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>E Walas SMKN 1 Cibinong - Siswa</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="../../images/logokampak.png" rel="icon">
  <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/../../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="/../../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/../../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="/../../assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: iLanding
  * Template URL: https://bootstrapmade.com/ilanding-bootstrap-landing-page-template/
  * Updated: Nov 12 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
        /* Kotak pesan */
        .alert {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            z-index: 9999;
            text-align: center;
            font-size: 16px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.5s ease-out;
            box-sizing: border-box;
            max-height: 60px; /* Menentukan tinggi kotak pesan agar tidak terlalu panjang */
            overflow: hidden;
            
            /* Flexbox untuk menyejajarkan teks di tengah */
            display: flex;
            justify-content: center; /* Mengatur teks ke tengah secara horizontal */
            align-items: center; /* Mengatur teks ke tengah secara vertikal */
        }

        .alert-danger {
            background-color: #e74c3c; /* Merah */
        }

        .alert-success {
            background-color: #2ecc71; /* Hijau */
        }

        /* Animasi slide down */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }

        /* Animasi slide up untuk saat pesan hilang */
        @keyframes slideUp {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-100%);
            }
        }

        /* Styling untuk tabel */
.table {
  width: 300%;
  border-collapse: collapse;
}

.table th, .table td {
  padding: 8px;
  text-align: left;
}

.table .btn {
  margin-right: 5px;
}

    </style>

<style>
 table {
    width: 310%;
    border-collapse: collapse; /* Menghilangkan ruang antara sel */
    border-radius: 8px; /* Sudut melengkung untuk tabel */
    overflow: hidden; /* Untuk memastikan konten tidak melampaui sudut melengkung */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Efek bayangan di sekitar tabel */
  }
  th, td {
    text-align: center; /* Menyelaraskan teks ke tengah */
    padding: 12px; /* Memberikan ruang dalam sel tabel */
    border: 1px solid #ddd; /* Menambahkan border di sekitar sel */
  }
  th {
    background-color: #f4f4f4; /* Warna latar belakang untuk header tabel */
    font-weight: bold; /* Membuat teks header lebih tebal */
  }
  td {
    background-color: #fff; /* Warna latar belakang untuk baris data */
  }
  tr:nth-child(even) td {
    background-color: #f9f9f9; /* Warna latar belakang untuk baris genap */
  }
  button {
    border-radius: 5px; /* Menambahkan sudut melengkung pada tombol */
  }

  .btn {
    border-radius: 10px; /* Membuat tombol melengkung */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan */
    transition: all 0.3s ease; /* Transisi halus untuk efek hover */
}

.btn-primary {
    background-color: #007bff; /* Warna biru untuk tombol utama */
    color: #fff;
}

.btn-primary:hover {
    background-color: #3399ff; /* Biru muda saat hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Bayangan lebih besar saat hover */
}

.btn-danger {
    background-color: #dc3545; /* Warna merah untuk tombol batal */
    color: #fff;
}

.btn-danger:hover {
    background-color: #ff6666; /* Merah muda saat hover */
    box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2); /* Bayangan lebih besar saat hover */
}

</style>
</head>

<body class="index-page">
     <!-- Tampilkan pesan error -->
     @if (session('error'))
        <div class="alert alert-danger" id="alertError">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Tampilkan pesan success -->
    @if (session('success'))
        <div class="alert alert-success" id="alertSuccess">
            <p>{{ session('success') }}</p>
        </div>
    @endif

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="header-container container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="/siswapage" class="logo d-flex align-items-center me-auto me-xl-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">E - Walas</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        <li><a href="/datadiri" >Beranda</a></li>
        <li><a href="/datadiripage" >Data Diri</a></li>
          <li><a href="/inputdatadiri">Input Data Diri</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div class="user-info d-flex align-items-center">
            @if(session()->has('siswa_id'))
                <i class="bi bi-person-circle text-primary me-2" style="font-size: 24px;"></i>  <!-- Icon User dengan warna biru -->
                
                <!-- Tautkan nama walas ke /userprofile -->
                <a href="/profilesiswa" class="text-decoration-none">
                    <span>{{ $siswa->nama }}</span>  <!-- Nama Walas yang sedang login -->
                </a>
            @endif

            <form action="{{ route('logoutsiswa') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn-getstarted">Logout</button>
            </form>
        </div>
      

    </div>
  </header>

  <main class="main">
    

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">
          <div class="col-lg-6">
            
             <div class="hero-content" data-aos="fade-up" data-aos-delay="200">
              <div class="company-badge mb-4">
                <i class="bi bi-gear-fill me-2"></i>
                    Edit Biodata Diri
              </div> 

              <!-- <h1 class="mb-4">
               Kelola Data Diri Siswa <br>
                <span class="accent-text">SMK Negeri 1 Cibinong</span>
              </h1> -->

              <!-- <div class="hero-buttons">
                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="btn btn-link tutorial-btn mt-2 mt-sm-0 glightbox">
                    <i class="bi bi-play-circle me-1"></i>
                    Tutorial Penggunaan Website
                </a> 
            </div> -->
            </div>
          </div>

          <div class="col-lg-6">
            <!-- <div class="hero-image" data-aos="zoom-out" data-aos-delay="300">
              <img src="assets/img/illustration-1.webp" alt="Hero Image" class="img-fluid">
            </div> -->
          </div>
        </div>

        <div class="row stats-row gy-100 mt-9 justify-content-start align-items-start" data-aos="fade-up" data-aos-delay="500">
        <div class="col-lg-12">
    <br>
    <div class="col-lg-12">
    <br>
    <h1 class="mb-4 text-center">
        Edit Biodata Diri <br>
        <span class="accent-text"></span>
    </h1>
    <br>
    <form action="{{ route('biodatasiswa.update', $biodata->id) }}" method="POST">
    @csrf
    @method('PUT')
            <h4 class="text-bold">Data Pribadi</h4>
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $biodata->nama_lengkap ?? '') }}" required>
                </div>
            </div>  
            <div class="row mb-3">
                <div class="col-12">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="form-control w-100" required>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $biodata->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="walas" class="form-label">Wali Kelas</label>
                <select class="form-select" id="walas" name="walas_id" required>
                    <option selected disabled>Pilih Wali Kelas</option>
                    @foreach ($walas as $wali)
                        <option value="{{ $wali->id }}" {{ old('walas_id', $biodata->walas_id ?? '') == $wali->id ? 'selected' : '' }}>{{ $wali->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control w-100" value="{{ old('tempat_lahir', $biodata->tempat_lahir ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control w-100" value="{{ old('tanggal_lahir', $biodata->tanggal_lahir ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control w-100" rows="3" required>{{ old('alamat', $biodata->alamat ?? '') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="alamat_maps" class="form-label">Alamat Maps</label>
                    <textarea name="alamat_maps" id="alamat_maps" class="form-control w-100" rows="3" required>{{ old('alamat_maps', $biodata->alamat_maps ?? '') }}</textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label for="jalur_masuk" class="form-label">Jalur Masuk</label>
                    <select name="jalur_masuk" id="jalur_masuk" class="form-control w-100" required>
                        <option value="Afirmasi" {{ old('jalur_masuk', $biodata->jalur_masuk ?? '') == 'Afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                        <option value="Zonasi" {{ old('jalur_masuk', $biodata->jalur_masuk ?? '') == 'Zonasi' ? 'selected' : '' }}>Zonasi</option>
                        <option value="Rapor" {{ old('jalur_masuk', $biodata->jalur_masuk ?? '') == 'Rapor' ? 'selected' : '' }}>Rapor</option>
                        <option value="Prestasi" {{ old('jalur_masuk', $biodata->jalur_masuk ?? '') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                        <option value="Anak Guru" {{ old('jalur_masuk', $biodata->jalur_masuk ?? '') == 'Anak Guru' ? 'selected' : '' }}>Anak Guru</option>
                        <option value="Perpindahan Orang Tua" {{ old('jalur_masuk', $biodata->jalur_masuk ?? '') == 'Perpindahan Orang Tua' ? 'selected' : '' }}>Perpindahan Orang Tua</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="jarak_rumah" class="form-label">Jarak Rumah (meter)</label>
                    <input type="text" name="jarak_rumah" id="jarak_rumah" class="form-control" value="{{ old('jarak_rumah', $biodata->jarak_rumah ?? '') }}" maxlength="255" required>
                </div>
                <div class="col-md-6">
                    <label for="transportasi_sekolah" class="form-label">Transportasi ke Sekolah</label>
                    <input type="text" name="transportasi_sekolah" id="transportasi_sekolah" class="form-control" value="{{ old('transportasi_sekolah', $biodata->transportasi_sekolah ?? '') }}" maxlength="255" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="transportasi_rumah" class="form-label">Transportasi ke Rumah</label>
                    <input type="text" name="transportasi_rumah" id="transportasi_rumah" class="form-control" value="{{ old('transportasi_rumah', $biodata->transportasi_rumah ?? '') }}" maxlength="255" required>
                </div>
                <div class="col-md-6">
                    <label for="agama" class="form-label">Agama</label>
                    <select name="agama" id="agama" class="form-control" required>
                        <option value="Islam" {{ old('agama', $biodata->agama ?? '') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen Protestan" {{ old('agama', $biodata->agama ?? '') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                        <option value="Kristen Katolik" {{ old('agama', $biodata->agama ?? '') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                        <option value="Hindu" {{ old('agama', $biodata->agama ?? '') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Budha" {{ old('agama', $biodata->agama ?? '') == 'Budha' ? 'selected' : '' }}>Budha</option>
                        <option value="Konghucu" {{ old('agama', $biodata->agama ?? '') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                    <input type="text" name="kewarganegaraan" id="kewarganegaraan" class="form-control" value="{{ old('kewarganegaraan', $biodata->kewarganegaraan ?? '') }}" maxlength="20" required>
                </div>
                <div class="col-md-3">
                    <label for="anak_ke" class="form-label">Anak Ke</label>
                    <input type="number" name="anak_ke" id="anak_ke" class="form-control" value="{{ old('anak_ke', $biodata->anak_ke ?? '') }}" maxlength="5" required>
                </div>
                <div class="col-md-3">
                    <label for="jumlah_saudara" class="form-label">Jumlah Saudara</label>
                    <input type="number" name="jumlah_saudara" id="jumlah_saudara" class="form-control" value="{{ old('jumlah_saudara', $biodata->jumlah_saudara ?? '') }}" maxlength="5" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="no_wa" class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="no_wa" id="no_wa" class="form-control" value="{{ old('no_wa', $biodata->no_wa ?? '') }}" maxlength="15" placeholder="Contoh: 081234567890" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $biodata->email ?? '') }}" maxlength="50" placeholder="Contoh: email@example.com" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="nis" class="form-label">NIS</label>
                    <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis', $biodata->nis ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label for="nisn" class="form-label">NISN</label>
                    <input type="text" name="nisn" id="nisn" class="form-control" value="{{ old('nisn', $biodata->nisn ?? '') }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="kelas" class="form-label">Kelas</label>
                    <select name="kelas" id="kelas" class="form-control" required>
                        <option value="X" {{ old('kelas', $biodata->kelas ?? '') == 'X' ? 'selected' : '' }}>X</option>
                        <option value="XI" {{ old('kelas', $biodata->kelas ?? '') == 'XI' ? 'selected' : '' }}>XI</option>
                        <option value="XII" {{ old('kelas', $biodata->kelas ?? '') == 'XII' ? 'selected' : '' }}>XII</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="kompetensi" class="form-label">Kompetensi</label>
                    <select name="kompetensi" id="kompetensi" class="form-control" required>
                        <option value="SIJA" {{ old('kompetensi', $biodata->kompetensi ?? '') == 'SIJA' ? 'selected' : '' }}>SIJA</option>
                        <option value="TKJ" {{ old('kompetensi', $biodata->kompetensi ?? '') == 'TKJ' ? 'selected' : '' }}>TKJ</option>
                        <option value="RPL" {{ old('kompetensi', $biodata->kompetensi ?? '') == 'RPL' ? 'selected' : '' }}>RPL</option>
                        <option value="DKV" {{ old('kompetensi', $biodata->kompetensi ?? '') == 'DKV' ? 'selected' : '' }}>DKV</option>
                        <option value="DPIB" {{ old('kompetensi', $biodata->kompetensi ?? '') == 'DPIB' ? 'selected' : '' }}>DPIB</option>
                        <option value="TKP" {{ old('kompetensi', $biodata->kompetensi ?? '') == 'TKP' ? 'selected' : '' }}>TKP</option>
                    </select>
                </div>
                <div class="row mb-3">
                <div class="row mb-3">
                <div class="col-md-12">
                    <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                    <input type="text" name="tahun_masuk" id="tahun_masuk" class="form-control" value="{{ old('tahun_masuk', $biodata->tahun_masuk ?? '') }}" required>
                </div>
            </div>  
                <br><br>
                <h4 class="text-bold">Data Orang Tua atau Wali</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control" value="{{ old('nama_ayah', $biodata->nama_ayah ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ayah" class="form-label">Pekerjaan Ayah</label>
                        <ul id="pekerjaan_ayah" class="list-unstyled d-flex flex-wrap">
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="TNI/POLRI" id="TNI_POLRI" onchange="togglePekerjaanInput()"> 
                                <label for="TNI_POLRI">TNI/POLRI</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="ASN/PNS" id="ASN_PNS" onchange="togglePekerjaanInput()"> 
                                <label for="ASN_PNS">ASN/PNS</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Karyawan" id="Karyawan" onchange="togglePekerjaanInput()"> 
                                <label for="Karyawan">Karyawan</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Wiraswasta" id="Wiraswasta" onchange="togglePekerjaanInput()"> 
                                <label for="Wiraswasta">Wiraswasta</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Pengemudi" id="Pengemudi" onchange="togglePekerjaanInput()"> 
                                <label for="Pengemudi">Pengemudi</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Buruh" id="Buruh" onchange="togglePekerjaanInput()"> 
                                <label for="Buruh">Buruh</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Tani" id="Tani" onchange="togglePekerjaanInput()"> 
                                <label for="Tani">Tani</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Pensiunan" id="Pensiunan" onchange="togglePekerjaanInput()"> 
                                <label for="Pensiunan">Pensiunan</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ayah" value="Lainnya" id="Lainnya" onchange="togglePekerjaanInput()"> 
                                <label for="Lainnya">Lainnya</label>
                            </li>
                        </ul>
                        <input type="text" name="pekerjaan_ayah_lainnya" id="pekerjaan_ayah_lainnya" class="form-control mt-2" placeholder="Masukkan pekerjaan lain..." style="display: none;">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tempat_lahir_ayah" class="form-label">Tempat Lahir Ayah</label>
                        <input type="text" name="tempat_lahir_ayah" id="tempat_lahir_ayah" class="form-control" maxlength="50" placeholder="Contoh: Jakarta" value="{{ old('tempat_lahir_ayah', $biodata->tempat_lahir_ayah ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir_ayah" class="form-label">Tanggal Lahir Ayah</label>
                        <input type="date" name="tanggal_lahir_ayah" id="tanggal_lahir_ayah" class="form-control" value="{{ old('tanggal_lahir_ayah', $biodata->tanggal_lahir_ayah ?? '') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="alamat_ayah" class="form-label">Alamat Ayah</label>
                        <textarea name="alamat_ayah" id="alamat_ayah" class="form-control" rows="3" placeholder="Contoh: Jl. Mawar No. 123, Jakarta" required>{{ old('alamat_ayah', $biodata->alamat_ayah ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="no_wa_ayah" class="form-label">Nomor WhatsApp Ayah</label>
                        <input type="text" name="no_wa_ayah" id="no_wa_ayah" class="form-control" maxlength="15" placeholder="Contoh: 081234567890" value="{{ old('no_wa_ayah', $biodata->no_wa_ayah ?? '') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="{{ old('nama_ibu', $biodata->nama_ibu ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="pekerjaan_ibu" class="form-label">Pekerjaan Ibu</label>
                        <ul id="pekerjaan_ibu" class="list-unstyled d-flex flex-wrap">
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="TNI/POLRI" id="TNI_POLRI" onchange="togglePekerjaanInput()"> 
                                <label for="TNI_POLRI">TNI/POLRI</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="ASN/PNS" id="ASN_PNS" onchange="togglePekerjaanInput()"> 
                                <label for="ASN_PNS">ASN/PNS</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Karyawan" id="Karyawan" onchange="togglePekerjaanInput()"> 
                                <label for="Karyawan">Karyawan</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Wiraswasta" id="Wiraswasta" onchange="togglePekerjaanInput()"> 
                                <label for="Wiraswasta">Wiraswasta</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Ibu Rumah Tangga" id="Ibu Rumah Tangga" onchange="togglePekerjaanInput()"> 
                                <label for="Ibu Rumah Tangga">Ibu Rumah Tangga</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Buruh" id="Buruh" onchange="togglePekerjaanInput()"> 
                                <label for="Buruh">Buruh</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Tani" id="Tani" onchange="togglePekerjaanInput()"> 
                                <label for="Tani">Tani</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Pensiunan" id="Pensiunan" onchange="togglePekerjaanInput()"> 
                                <label for="Pensiunan">Pensiunan</label>
                            </li>
                            <li class="col-md-6">
                                <input type="radio" name="pekerjaan_ibu" value="Lainnya" id="Lainnya" onchange="togglePekerjaanInput()"> 
                                <label for="Lainnya">Lainnya</label>
                            </li>
                        </ul>
                        <input type="text" name="pekerjaan_ibu_lainnya" id="pekerjaan_ibu_lainnya" class="form-control mt-2" placeholder="Masukkan pekerjaan lain..." style="display: none;">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="tempat_lahir_ibu" class="form-label">Tempat Lahir Ibu</label>
                        <input type="text" name="tempat_lahir_ibu" id="tempat_lahir_ibu" class="form-control" maxlength="50" placeholder="Contoh: Jakarta" value="{{ old('tempat_lahir_ibu', $biodata->tempat_lahir_ibu ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal_lahir_ibu" class="form-label">Tanggal Lahir Ibu</label>
                        <input type="date" name="tanggal_lahir_ibu" id="tanggal_lahir_ibu" class="form-control" value="{{ old('tanggal_lahir_ibu', $biodata->tanggal_lahir_ibu ?? '') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="alamat_ibu" class="form-label">Alamat Ibu</label>
                        <textarea name="alamat_ibu" id="alamat_ibu" class="form-control" rows="3" placeholder="Contoh: Jl. Mawar No. 123, Jakarta" required>{{ old('alamat_ibu', $biodata->alamat_ibu ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="no_wa_ibu" class="form-label">Nomor WhatsApp Ibu</label>
                        <input type="text" name="no_wa_ibu" id="no_wa_ibu" class="form-control" maxlength="15" placeholder="Contoh: 081234567890" value="{{ old('no_wa_ibu', $biodata->no_wa_ibu ?? '') }}" required>
                    </div>
                </div>
                <br><br>
                <h4>Data Pendidikan Sebelumnya</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="namasekolah_asal" class="form-label">Nama Sekolah Asal</label>
                        <input type="text" name="namasekolah_asal" id="namasekolah_asal" class="form-control" maxlength="50" placeholder="Contoh: SMK Negeri 1 Cibinong" value="{{ old('namasekolah_asal', $biodata->namasekolah_asal ?? '') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="text" name="tahun_lulus" id="tahun_lulus" class="form-control" maxlength="4" placeholder="Contoh: 2024" value="{{ old('tahun_lulus', $biodata->tahun_lulus ?? '') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="alamat_sekolah" class="form-label">Alamat Sekolah</label>
                        <textarea name="alamat_sekolah" id="alamat_sekolah" class="form-control" rows="3" placeholder="Contoh: Jl. Raya Bogor KM 46, Cibinong, Bogor" required>{{ old('alamat_sekolah', $biodata->alamat_sekolah ?? '') }}</textarea>
                    </div>
                </div>
                <br>
                <h4>Riwayat Penyakit</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="riwayat_penyakit" class="form-label">Riwayat Penyakit</label>
                        <input type="text" name="riwayat_penyakit" id="riwayat_penyakit" class="form-control" value="{{ old('riwayat_penyakit', $biodata->riwayat_penyakit ?? '') }}">
                    </div>
                    <div class="col-md-6">
                        <label for="alergi" class="form-label">Alergi</label>
                        <input type="text" name="alergi" id="alergi" class="form-control" value="{{ old('alergi', $biodata->alergi ?? '') }}">
                    </div>
                </div>
                <br>
                <h4>Prestasi dan Pengalaman</h4>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="prestasi_akademik" class="form-label">Prestasi Akademik</label>
                        <textarea name="prestasi_akademik" id="prestasi_akademik" class="form-control" rows="3">{{ old('prestasi_akademik', $biodata->prestasi_akademik ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="prestasi_non_akademik" class="form-label">Prestasi Non-Akademik</label>
                        <textarea name="prestasi_non_akademik" id="prestasi_non_akademik" class="form-control" rows="3">{{ old('prestasi_non_akademik', $biodata->prestasi_non_akademik ?? '') }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="pengalaman_ekskul" class="form-label">Pengalaman Ekskul</label>
                        <textarea name="pengalaman_ekskul" id="pengalaman_ekskul" class="form-control" rows="3">{{ old('pengalaman_ekskul', $biodata->pengalaman_ekskul ?? '') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="kepribadian" class="form-label">Kepribadian</label>
                        <textarea name="kepribadian" id="kepribadian" class="form-control" rows="3">{{ old('kepribadian', $biodata->kepribadian ?? '') }}</textarea>
                    </div>
                </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</section><!-- /Hero Section -->

</main>
  
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">SIJA SMKN 1 Cibinong</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/../../assets/vendor/php-email-form/validate.js"></script>
  <script src="/../../assets/vendor/aos/aos.js"></script>
  <script src="/../../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/../../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/../../assets/vendor/purecounter/purecounter_vanilla.js"></script>

  <!-- Main JS File -->
  <script src="/../../assets/js/main.js"></script>

  <script>
        window.onload = function() {
            // Cek jika ada pesan error
            var errorAlert = document.getElementById('alertError');
            var successAlert = document.getElementById('alertSuccess');

            // Jika ada pesan error, sembunyikan setelah 2 detik dengan animasi
            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.style.animation = 'slideUp 0.5s ease-out'; // Animasi naik
                    setTimeout(function() {
                        errorAlert.style.display = 'none'; // Sembunyikan setelah animasi selesai
                    }, 500); // Durasi animasi
                }, 2000); // Tunda selama 2 detik sebelum animasi
            }

            // Jika ada pesan success, sembunyikan setelah 2 detik dengan animasi
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.animation = 'slideUp 0.5s ease-out'; // Animasi naik
                    setTimeout(function() {
                        successAlert.style.display = 'none'; // Sembunyikan setelah animasi selesai
                    }, 500); // Durasi animasi
                }, 2000); // Tunda selama 2 detik sebelum animasi
            }
        };
    </script>

<script>
  function togglePekerjaanInput() {
    var pekerjaanAyah = document.querySelector('input[name="pekerjaan_ayah"]:checked').value;
    var pekerjaanInput = document.getElementById("pekerjaan_ayah_lainnya");

    if (pekerjaanAyah === "Lainnya") {
        pekerjaanInput.style.display = "block";
    } else {
        pekerjaanInput.style.display = "none";
    }
}
</script>

<script>
  function togglePekerjaanInput() {
    var pekerjaanibu = document.querySelector('input[name="pekerjaan_ibu"]:checked').value;
    var pekerjaanInput = document.getElementById("pekerjaan_ibu_lainnya");

    if (pekerjaanibu === "Lainnya") {
        pekerjaanInput.style.display = "block";
    } else {
        pekerjaanInput.style.display = "none";
    }
}
</script>

</body>

</html>