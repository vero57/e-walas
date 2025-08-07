-----

# 🎓 E-Walas Project: Absensi Berbasis Face Recognition

**E-Walas Project** adalah sebuah platform web untuk sistem absensi siswa yang inovatif, memanfaatkan teknologi **face recognition** dan terintegrasi dengan **WhatsApp**. Proyek ini bertujuan untuk membangun solusi absensi yang modern, akurat, dan efisien untuk lingkungan sekolah.

Fitur utama dari proyek ini meliputi:

  - **Absensi Face Recognition**: Verifikasi wajah dengan deteksi ekspresi untuk mencegah kecurangan.
  - **Integrasi WhatsApp**: Notifikasi absensi dan rekap harian/mingguan otomatis dikirim ke orang tua dan walas.
  - **Deteksi Lokasi Akurat**: Memastikan absensi hanya dapat dilakukan di lingkungan sekolah.
  - **Pengajuan Izin Online**: Orang tua dapat mengajukan izin sakit atau keperluan lain melalui platform web.
  - **Jurnal Mata Pelajaran Digital**: Siswa dapat mengisi jurnal dan mengunggah bukti foto kegiatan.
  - **Sistem Poin Pelanggaran**: Pencatatan poin otomatis untuk siswa yang terlambat.
  - **Live CCTV**: Tampilan CCTV real-time dari lab SIJA.

-----

## 📦 Instalasi & Deployment

Sebelum memulai proses instalasi dan deployment proyek ini secara lokal, pastikan Anda telah menginstal beberapa **perangkat lunak pendukung (development tools)** berikut:

  - **Git** – untuk meng-clone repository dari GitHub
  - **Code editor** – disarankan menggunakan [Visual Studio Code](https://code.visualstudio.com/)
  - **Web server stack** – seperti [Laragon](https://laragon.org/) atau [XAMPP](https://www.apachefriends.org/index.html), yang berfungsi sebagai aplikasi server lokal untuk menjalankan PHP dan MySQL

-----

### 1\. Clone Repository

Untuk mulai bekerja dengan proyek ini, jalankan perintah berikut di terminal untuk meng-clone repository ke komputer lokal Anda:

```bash
git clone https://github.com/berbinarin/e-walas.git
cd e-walas
```

Setelah itu, buka folder proyek yang telah di-clone menggunakan code editor seperti Visual Studio Code.

-----

### 2\. Instalasi Dependency

Selanjutnya, instal semua dependency backend dan frontend menggunakan perintah berikut di terminal:

```bash
composer install
```

-----

### 3\. Konfigurasi Environment

Laravel menggunakan file `.env` untuk mengatur konfigurasi aplikasi. Jalankan langkah berikut:

```bash
cp .env.example .env
```

Kemudian, sesuaikan isi file `.env` dengan pengaturan lokal Anda, seperti nama database, user, dan password.

Setelah file `.env` disiapkan, langkah selanjutnya adalah menghasilkan kunci aplikasi Laravel. Jalankan perintah berikut di terminal:

```bash
php artisan key:generate
```

Perintah ini akan menghasilkan kunci aplikasi yang digunakan untuk mengenkripsi data sensitif di aplikasi Laravel Anda.

-----

### 4\. Migrasi & Seeding Database

Pastikan aplikasi **web server stack** (seperti Laragon atau XAMPP) Anda sudah aktif dan database server (MySQL/MariaDB) sedang berjalan.

Lalu jalankan perintah berikut untuk membuat dan mengisi struktur database:

```bash
php artisan migrate --seed
```

-----

### 5\. Menjalankan Proyek

Buka dua terminal terpisah untuk menjalankan backend Laravel dan frontend Vite (bila menggunakan Laravel + Vite):

**Terminal – Laravel:**

```bash
php artisan serve
```

Lalu akses webnya melalui browser dengan mengetikan url

```bash
http://localhost:8000
```

-----

## 👍🏻 Standarisasi dan Best Practice

Pada poin ini akan dibahas beberapa Standar atau best practice yang diterapkan pada project ini guna meningkatkan efisiensi dan *readability* pada *source code*. Materi pada bagian ini banyak mengambil referensi dari repository GitHub [alexeymezenin - Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices).

### 1\. Penamaan Direktori dan File

| **Konvensi** | **Penjelasan** | **Contoh** |
|:---|:---|:---|
| **Controller** | File controller di dalam folder **Controllers** harus diakhiri dengan kata `Controller` menggunakan format **PascalCase**. | `SiswaController.php`, `WalasController` |
| **Model** | Nama file model menggunakan format **PascalCase** dan disarankan menggunakan nama tunggal untuk representasi entitas tunggal. | `Siswa.php`, `Kelas.php` |
| **Migration** | File migrasi harus menggunakan format **snake\_case** dan disertai dengan deskripsi yang jelas mengenai fungsinya. | `create_absensis_table.php`, `add_geolokasi_to_absensis.php` |
| **Seeder** | Gunakan format **PascalCase** untuk file seeder. Seeder biasanya menggunakan nama entitas yang dimodifikasi. | `UserSeeder.php`, `SiswaSeeder.php` |
| **Middleware** | Gunakan format **PascalCase** untuk nama file middleware dan harus jelas menggambarkan fungsinya. | `Authenticate.php`, `CheckWalas.php` |
| **Request** | Gunakan **PascalCase** untuk nama file request dan beri nama berdasarkan tindakan atau data yang diproses. | `StoreAbsensiRequest.php`, `UpdateJurnalRequest.php` |
| **Service** | Jika menggunakan service classes, nama file harus menggunakan **PascalCase**. | `AbsensiService.php`, `WhatsAppService.php` |

### 2\. Penamaan Variabel dan Properti

| **Konvensi** | **Penjelasan** | **Contoh** |
|:---|:---|:---|
| **Variable dan Property** | Gunakan format **camelCase** untuk penamaan variabel dan properti di dalam kelas. | `$listSiswa`, `$notifikasiWhatsApp` |
| **Constanta** | Gunakan format **UPPER\_SNAKE\_CASE** untuk konstanta, yang terdiri dari huruf kapital dan dipisahkan dengan underscore. | `MAX_TELAT_MENIT`, `DEFAULT_ROLE` |
| **Function/Method** | Gunakan format **camelCase** untuk function atau method, dengan kata kerja yang jelas dan deskriptif. | `absenSiswa()`, `kirimNotifikasi()`, `verifikasiWajah()` |
| **Function/Method di Resource Controller** | Gunakan format yang telah ditentukan oleh Laravel (index, store, show, update, destroy). | `index()`, `store()` |
| **Parameter Function** | Gunakan **camelCase** untuk parameter function, sesuai dengan konvensi penamaan pada variabel. | `function kirimNotifikasi($siswaId, $pesan)` |

### 3\. Penamaan URL, Route, dan View

| **Konvensi** | **Penjelasan** | **Contoh** |
|:---|:---|:---|
| **URL/Route** | Gunakan **kebab-case** untuk nama URL dan route, sehingga mudah dibaca dan konsisten. Setiap kata dipisahkan dengan tanda hubung (-). | `/absensi`, `/jurnal-mapel` |
| **Route Name** | Gunakan **snake\_case** dengan **dot notation** untuk route name. Setiap kata dipisahkan dengan tanda (\_). | `absensi.index`, `jurnal.create` |
| **Blade View dan Components** | Gunakan format **kebab-case** untuk penamaan komponen Blade. | `absen-harian.blade.php`, `form-izin.blade.php` |

### 4\. Penamaan Tabel dan Kolom Database

| **Konvensi** | **Penjelasan** | **Contoh** |
|:---|:---|:---|
| **Tabel** | Gunakan **plural snake\_case** untuk nama tabel di database. Nama tabel harus menjelaskan jenis entitas yang disimpan. | `siswas`, `absensis`, `jurnals` |
| **Column** | Gunakan **snake\_case** untuk nama kolom, dan pastikan nama kolom konsisten dan deskriptif terhadap data yang disimpan. | `id`, `nama_siswa`, `waktu_absensi` |
| **Indeks/Foreign Key** | Gunakan **snake\_case** untuk nama indeks atau relation dan konsisten dalam penamaan. | `siswa_id`, `kelas_id`, `waktu_absensi_index` |

### 5\. Best Practices Lainnya

  - **Deskriptif**: Gunakan nama yang deskriptif untuk semua elemen dalam proyek agar mudah dipahami oleh pengembang lain.
  - **Konsisten**: Pastikan Anda konsisten dengan format penamaan yang digunakan di seluruh proyek untuk menjaga kejelasan dan keterbacaan.
  - **Singkat dan Padat**: Hindari penggunaan nama yang terlalu panjang. Usahakan agar nama tetap deskriptif namun tidak berlebihan.
