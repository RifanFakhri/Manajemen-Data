<?php

// app/Models/Siswa.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // Import ini

class Siswa extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'nisn',
        'tanggal_lahir',
        'nomor_kontak', // Saya ganti dari 'kontak_broj'
        'email',
        'alamat',
        'kota',
        'kode_pos',
        'negara',
        'dokumen_path',
        'foto_profil_path',
    ];

    /**
     * Bonus: Accessor untuk mendapatkan nama lengkap.
     * Nanti Anda bisa panggil $siswa->nama_lengkap
     */
    protected function namaLengkap(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->nama_depan . ' ' . $this->nama_belakang,
        );
    }
}