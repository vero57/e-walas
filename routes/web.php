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
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\RombelPageController;
use App\Http\Controllers\MapelPageController;
use App\Http\Controllers\TaDataController;
use App\Http\Controllers\RombelDataController;
use App\Http\Controllers\KinerjaGuruController;
use App\Http\Controllers\DataDiriPageController;
use App\Http\Controllers\InputDataDiriSiswaController;
use App\Http\Controllers\DataDiriDataController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('loginadmin', LoginController::class);
Route::post('/loginadmin', [LoginController::class, 'store'])->name('login.store');

Route::resource('logingtk', LoginGtkController::class);
Route::post('/logingtk', [LoginGtkController::class, 'store'])->name('logingtk.store');

Route::resource('loginkepsek', LoginKepsekController::class);
Route::post('/loginkepsek', [LoginKepsekController::class, 'store'])->name('loginkepsek.store');

Route::resource('logingtk', LoginGtkController::class);
Route::resource('loginkepsek', LoginKepsekController::class);
Route::resource('loginkaprog', LoginKaprogController::class);
Route::resource('loginkurikulum', LoginKurikulumController::class);
Route::resource('loginsiswa', LoginSiswaController::class);

// Halaman Utama Controller

// Route halaman admin
Route::get('/adminpage', function () {
    if (!session()->has('admin_id')) {
        return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('homepageadmin.index'); // File di views/adminpage/index.blade.php

})->name('homepageadmin.index');
Route::resource('wargasekolah', WargaSekolahController::class);
Route::resource('walas', WaliKelasPageController::class);
Route::resource('kakom', KakomDataController::class);
Route::resource('kurikulum', KurikulumPageController::class);
Route::resource('kepalasekolah', KepsekPageController::class);
Route::resource('guru', GuruPageController::class);

Route::resource('tahunajaran', TahunAjaranController::class);
Route::resource('rombel', RombelPageController::class);
Route::resource('datamapel', MapelPageController::class);


// Route Halaman Walas
Route::get('/walaspage', function () {
    if (!session()->has('walas_id')) {
        return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('homepagegtk.index'); // File di views/adminpage/index.blade.php
})->name('homepagegtk.index');

// Route Halaman Kepsek
Route::get('/kepsekpage', function () {
    if (!session()->has('kepsek_id')) {
        return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('homepagekepsek.index'); // File di views/adminpage/index.blade.php
})->name('homepagekepsek.index');

// Route Halaman Kaprog
Route::get('/kaprogpage', function () {
    if (!session()->has('kaprog_id')) {
        return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('homepagekaprog.index'); // File di views/adminpage/index.blade.php
})->name('homepagekaprog.index');

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



// Route Halaman Siswa
Route::get('/siswapage', function () {
    if (!session()->has('siswa_id')) {
        return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
    }
    return view('homepagesiswa.index'); // File di views/adminpage/index.blade.php
})->name('homepagesiswa.index');
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