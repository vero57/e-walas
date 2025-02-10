<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\RombelPageController;

Schedule::call(function () {
    (new RombelPageController)->naikKelas();
})->cron('0 0 7 7 *'); // Eksekusi pada 7 Juli setiap tahun


