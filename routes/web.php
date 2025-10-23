<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController; // <-- 1. TAMBAHKAN IMPORT INI

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


// 2. HAPUS DUA RUTE LAMA DI BAWAH INI:
// Route::get('/data-siswa', function () {
//     return view('pages.data_siswa');
// })->name('siswa.index');
//
// Route::get('/data-siswa/tambah', function () {
//     return view('pages.siswa_form');
// })->name('siswa.create');


// 3. GANTI DENGAN SATU BARIS INI:
Route::resource('data-siswa', SiswaController::class)->names('siswa');