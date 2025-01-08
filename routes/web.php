<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginGtkController;
use App\Http\Controllers\LoginKaprogController;
use App\Http\Controllers\LoginKepsekController;
use App\Http\Controllers\LoginKurikulumController;
use App\Http\Controllers\LoginSiswaController;
use App\Http\Controllers\DashAdminController;
use App\Http\Controllers\WargaSekolahController;
use App\Http\Controllers\WaliKelasPageController;
use App\Http\Controllers\KakomDataController;
use App\Http\Controllers\KurikulumPageController;
use App\Http\Controllers\KepsekPageController;
use App\Http\Controllers\GuruPageController;
use App\Http\Controllers\DataSiswaWalasController;
use App\Http\Controllers\AdministrasiWalasController;
use App\Http\Controllers\KakomTAController;
use App\Http\Controllers\KakomWalasController;
use App\Http\Controllers\KepsekTAController;
use App\Http\Controllers\KepsekWalasController;
use App\Http\Controllers\KepsekRombelController;
use App\Http\Controllers\KakomRombelController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\RombelPageController;
use App\Http\Controllers\MapelPageController;
use App\Http\Controllers\TaDataController;
use App\Http\Controllers\RombelDataController;
use App\Http\Controllers\KinerjaGuruController;
use App\Http\Controllers\DataDiriPageController;
use App\Http\Controllers\InputDataDiriSiswaController;
use App\Http\Controllers\DataDiriDataController;
use App\Http\Controllers\HomePageWalasController;
use App\Http\Controllers\ProfilePageWalasController;
use App\Http\Controllers\ProfilePageController;
use App\Http\Controllers\SiswaPageController;
use App\Http\Middleware\SiswaMiddleware;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('loginadmin', LoginController::class);
Route::post('/loginadmin', [LoginController::class, 'store'])->name('login.store');

Route::get('/logingtk', [LoginGtkController::class, 'index'])->name('logingtk.index');
Route::post('/logingtk', [LoginGtkController::class, 'store'])->name('logingtk.store');

Route::resource('loginkepsek', LoginKepsekController::class);
Route::post('/loginkepsek', [LoginKepsekController::class, 'store'])->name('loginkepsek.store');

Route::resource('logingtk', LoginGtkController::class);
Route::resource('loginkepsek', LoginKepsekController::class);
Route::resource('loginkaprog', LoginKaprogController::class);
Route::resource('loginkurikulum', LoginKurikulumController::class);
// Route untuk menampilkan form login siswa
Route::get('/loginsiswa', [LoginSiswaController::class, 'index'])->name('loginsiswa');

// Route untuk menangani proses login siswa
Route::post('/loginsiswa', [LoginSiswaController::class, 'store'])->name('loginsiswa.store');


// Halaman Utama Controller

// Route halaman admin
Route::get('/adminpage', function () {
    if (!session()->has('admin_id')) {
        return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('homepageadmin.index'); // File di views/adminpage/index.blade.php

})->name('homepageadmin.index');
Route::resource('wargasekolah', WargaSekolahController::class);

// CRUD WALAS
Route::resource('walas', WaliKelasPageController::class);
Route::get('/hapuswalas/{id}', [WaliKelasPageController::class, 'hapuswalas'])->name('hapuswalas');
Route::get('/walas/hapuswalas/{id}', [WaliKelasPageController::class, 'hapuswalas']);
Route::put('/walas/{id}', [WaliKelasPageController::class, 'update'])->name('walas.update');
Route::get('/walas/{id}/edit', [WaliKelasPageController::class, 'edit'])->name('walas.edit');
Route::get ('/walas_search', [WaliKelasPageController::class,'walas_search']);

// CRUD KAKOM
Route::resource('kakom', KakomDataController::class);
Route::get('/hapuskakom/{id}', [KakomDataController::class, 'hapuskakom'])->name('hapuskakom');
Route::get('/kakom/hapuskakom/{id}', [KakomDataController::class, 'hapuskakom']);
Route::put('/kakom/{id}', [KakomDataController::class, 'update'])->name('kakom.update');
Route::get('/kakom/{id}/edit', [KakomDataController::class, 'edit'])->name('kakom.edit');
Route::get ('/kakom_search', [KakomDataController::class,'kakom_search']);

// CRUD KURIKULUM
Route::resource('kurikulum', KurikulumPageController::class);
Route::get('/hapuskurikulum/{id}', [KurikulumPageController::class, 'hapuskurikulum'])->name('hapuskurikulum');
Route::get('/kurikulum/hapuskurikulum/{id}', [KurikulumPageController::class, 'hapuskurikulum']);
Route::put('/kurikulum/{id}', [KurikulumPageController::class, 'update'])->name('kurikulum.update');
Route::get('/kurikulum/{id}/edit', [KurikulumPageController::class, 'edit'])->name('kurikulum.edit');
Route::get ('/kurikulum_search', [KurikulumPageController::class,'kurikulum_search']);

// CRUD KEPSEK
Route::resource('kepalasekolah', KepsekPageController::class);
Route::get('/hapuskepsek/{id}', [KepsekPageController::class, 'hapuskepsek'])->name('hapuskepsek');
Route::get('/kepsek/hapuskepsek/{id}', [KepsekPageController::class, 'hapuskepsek']);
Route::put('/kepsek/{id}', [KepsekPageController::class, 'update'])->name('kepsek.update');
Route::get('/kepsek/{id}/edit', [KepsekPageController::class, 'edit'])->name('kepsek.edit');
Route::post('/kepsek/rombel/store', [KepsekPageController::class, 'store'])->name('kepsek.store');
Route::get ('/kepsek_search', [KepsekPageController::class,'kepsek_search']);

// CRUD GURU
Route::resource('guru', GuruPageController::class);
Route::get('/hapusguru/{id}', [GuruPageController::class, 'hapusguru'])->name('hapusguru');
Route::get('/guru/hapusguru/{id}', [GuruPageController::class, 'hapusguru']);
Route::put('/guru/{id}', [GuruPageController::class, 'update'])->name('guru.update');
Route::get('/guru/{id}/edit', [GuruPageController::class, 'edit'])->name('guru.edit');
Route::get ('/guru_search', [GuruPageController::class,'guru_search']);


Route::resource('tahunajaran', TahunAjaranController::class);

Route::post('/walas-import', [WaliKelasPageController::class, 'import']);
Route::get('/walas-download-template', [WaliKelasPageController::class, 'downloadTemplate'])->name('walas.download-template');
Route::post('/guru-import', [GuruPageController::class, 'import']);
Route::get('/guru-download-template', [GuruPageController::class, 'downloadTemplate'])->name('guru.download-template');
Route::post('/kakom-import', [KakomDataController::class, 'import']);
Route::get('/kakom-download-template', [KakomDataController::class, 'downloadTemplate'])->name('kakom.download-template');
Route::post('/kurikulum-import', [KurikulumPageController::class, 'import']);
Route::get('/kurikulum-download-template', [KurikulumPageController::class, 'downloadTemplate'])->name('kurikulum.download-template');
Route::post('/kepsek-import', [KepsekPageController::class, 'import']);
Route::get('/kepsek-download-template', [KepsekPageController::class, 'downloadTemplate'])->name('kepsek.download-template');
Route::post('/mapel-import', [MapelPageController::class, 'import']);
Route::get('/mapel-download-template', [MapelPageController::class, 'downloadTemplate'])->name('mapel.download-template');
Route::post('/siswa-import', [DataSiswaWalasController::class, 'import']);
Route::get('/siswa-download-template', [DataSiswaWalasController::class, 'downloadTemplate'])->name('siswa.download-template');
// CRUD ROMBEL
Route::resource('rombel', RombelPageController::class); // Ini sudah mencakup semua route CRUD, termasuk edit
Route::post('/rombel/store', [RombelPageController::class, 'store'])->name('rombels.store');
Route::put('/rombels/{id}', [RombelPageController::class, 'update'])->name('rombels.update');
Route::get('/rombels/{id}/edit', [RombelPageController::class, 'edit'])->name('rombels.edit'); // Pastikan edit menggunakan GET
Route::get('/hapusrombel/{id}', [RombelPageController::class, 'hapusrombel'])->name('hapusrombel');
Route::get('/rombel/hapusrombel/{id}', [RombelPageController::class, 'hapusrombel']);
Route::get ('/rombel_search', [RombelPageController::class,'rombel_search']);


// CRUD MAPEL
Route::resource('datamapel', MapelPageController::class);
Route::get('/hapusmapel/{id}', [MapelPageController::class, 'hapusmapel'])->name('hapusmapel');
Route::get('/mapel/hapusmapel/{id}', [MapelPageController::class, 'hapusmapel']);
Route::put('/mapel/{id}', [MapelPageController::class, 'update'])->name('mapel.update');
Route::get('/mapel/{id}/edit', [MapelPageController::class, 'edit'])->name('mapel.edit');
Route::post('/mapel/tambah/store', [MapelPageController::class, 'store'])->name('mapel.store');
Route::get ('/mapel_search', [MapelPageController::class,'mapel_search']);

Route::get('/walaspage', [HomePageWalasController::class, 'index'])->name('homepagegtk.index');

Route::resource('siswadata', DataSiswaWalasController::class);

Route::resource('profilewalas', ProfilePageWalasController::class);
Route::resource('profilesiswa', ProfilePageController::class);


Route::get ('/siswadata_search', [DataSiswaWalasController::class,'siswadata_search']);

Route::post('/siswadata/tambah/store', [DataSiswaWalasController::class, 'store'])
// Menambahkan middleware auth:walas
    ->name('siswa.store');

Route::get('/hapussiswa/{id}', [DataSiswaWalasController::class, 'hapussiswa'])
// Menambahkan middleware auth:walas
    ->name('hapussiswa');

Route::get('/siswa/{id}/edit', [DataSiswaWalasController::class, 'edit'])
// Menambahkan middleware auth:walas
    ->name('siswa.edit');

Route::put('/siswa/{id}', [DataSiswaWalasController::class, 'update'])
// Menambahkan middleware auth:walas
    ->name('siswa.update');
Route::resource('adminwalas', AdministrasiWalasController::class);

// Route Halaman Kepsek
Route::get('/kepsekpage', function () {
    if (!session()->has('kepsek_id')) {
        return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('homepagekepsek.index'); // File di views/adminpage/index.blade.php
})->name('homepagekepsek.index');
Route::resource('kepsekta', KepsekTAController::class);
Route::resource('kepsekwalas', KepsekWalasController::class);
Route::resource('kepsekrombel', KepsekRombelController::class);

// Route Halaman Kaprog
Route::get('/kaprogpage', function () {
    if (!session()->has('kaprog_id')) {
        return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('homepagekaprog.index'); // File di views/adminpage/index.blade.php
})->name('homepagekaprog.index');
Route::resource('kakomta', KakomTAController::class);
Route::resource('kakomwalas', KakomWalasController::class);
Route::resource('kakomrombel', KakomRombelController::class);

// Route Halaman Kurikulum
Route::get('/kurikulumpage', function () {
    if (!session()->has('kurikulum_id')) {
        return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('homepagekurikulum.index'); // File di views/adminpage/index.blade.php
})->name('homepagekurikulum.index');
Route::resource('tahunajarandata', TaDataController::class);
Route::resource('rombelpage', RombelDataController::class);
Route::resource('kinerjaguru', KinerjaGuruController::class);

// Route Siswa Halaman
 

    Route::get('/siswapage', [SiswaPageController::class, 'index'])->name('homepagesiswa.index');
    Route::resource('datadiri', DataDiriPageController::class);
    Route::resource('inputdatadiri', InputDataDiriSiswaController::class);
    Route::resource('datadiripage', DataDiriDataController::class);


// Logout admin
Route::post('/homepageadmin/logout', function () {
    Auth::guard('admins')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutadmin');


// Logout admin
Route::post('/homepageadmin/logout', function () {
    Auth::guard('admins')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutadmin');

// Logout walas
Route::post('/homepagegtk/logout', function () {
    Auth::guard('walas')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutwalas');

// Logout kakom
Route::post('/homepagekaprog/logout', function () {
    Auth::guard('kakoms')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutkakom');

// Logout kepsek
Route::post('/homepagekepsek/logout', function () {
    Auth::guard('kepseks')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutkepsek');

// Logout kurikullum
Route::post('/homepagekurikulum/logout', function () {
    Auth::guard('kurikulums')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutkurikulum');

// Logout kurikullum
Route::post('/homepagesiswa/logout', function () {
    Auth::guard('siswas')->logout();
    session()->flash('status', 'Logout Berhasil');
    return redirect('/');
})->name('logoutsiswa');