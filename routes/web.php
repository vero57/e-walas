<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LoginGtkController;
use App\Http\Controllers\LoginKaprogController;
use App\Http\Controllers\LoginKepsekController;
use App\Http\Controllers\LoginKurikulumController;
use App\Http\Controllers\LoginSiswaController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('loginadmin', LoginController::class);
Route::resource('logingtk', LoginGtkController::class);
Route::resource('loginkepsek', LoginKepsekController::class);
Route::resource('loginkaprog', LoginKaprogController::class);
Route::resource('loginkurikulum', LoginKurikulumController::class);
Route::resource('loginsiswa', LoginSiswaController::class);