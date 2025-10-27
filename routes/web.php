<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SiswaController; 

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', function () {
    return view('pages.home_screen');
})->name('dashboard');


Route::resource('data-siswa', SiswaController::class)
    // ==========================================================
    // INI ADALAH PERBAIKANNYA:
    // Menambahkan ->names('siswa') agar rute Anda dipanggil 
    // sebagai 'siswa.index', 'siswa.create', 'siswa.update', dll.
    // ==========================================================
    ->names('siswa') 
    ->parameters(['data-siswa' => 'siswa']);

