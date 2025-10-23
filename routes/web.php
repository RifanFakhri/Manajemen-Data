<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web". Buat sesuatu yang hebat!
|
*/

// Rute ini akan me-redirect halaman utama (/) ke halaman dashboard
Route::get('/', function () {
    return redirect('/dashboard');
});

// Rute-rute yang sudah Anda buat sebelumnya
Route::get('/dashboard', function () {
    return view('pages.home_screen');
})->name('dashboard');

// Rute ini untuk menampilkan halaman daftar siswa
Route::get('/data-siswa', function () {
    return view('pages.data_siswa');
})->name('siswa.index');

// Rute ini untuk menampilkan formulir tambah siswa baru
Route::get('/data-siswa/tambah', function () {
    return view('pages.siswa_form');
})->name('siswa.create');