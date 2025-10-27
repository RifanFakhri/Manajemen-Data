<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Penting untuk URL

class Siswa extends Model
{
    use HasFactory;

    /**
     * INI ADALAH KUNCI PERBAIKANNYA.
     * Daftar semua kolom dari form Anda yang BOLEH diisi/di-update.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_depan',
        'nama_belakang',
        'nisn',
        'tanggal_lahir',
        'nomor_kontak',
        'email',
        'alamat',
        'kota',
        'kode_pos',
        'negara',
        'dokumen_path',     // <-- Ini penting
        'foto_profil_path', // <-- Ini penting
    ];

    /**
     * Atribut tambahan (Accessor) yang akan ditambahkan ke JSON/array.
     * Ini agar view Anda bisa memanggil $siswa->nama_lengkap, dll.
     *
     * @var array
     */
    protected $appends = [
        'nama_lengkap',
        'foto_profil_url',
        'dokumen_url'
    ];

    //======================================
    // ACCESSOR UNTUK NAMA LENGKAP
    //======================================
    protected function namaLengkap(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn () => $this->nama_depan . ' ' . $this->nama_belakang,
        );
    }

    //======================================
    // ACCESSOR UNTUK FOTO PROFIL
    //======================================
    protected function fotoProfilUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                if ($this->foto_profil_path) {
                    // Membuat URL ke 'storage/foto-profil/namafile.jpg'
                    return Storage::disk('public')->url($this->foto_profil_path);
                }
                // Jika tidak ada, berikan placeholder
                return 'https://ui-avatars.com/api/?name=' . urlencode($this->nama_depan) . '&background=random';
            },
        );
    }

    //======================================
    // ACCESSOR UNTUK DOKUMEN
    //======================================
    protected function dokumenUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                if ($this->dokumen_path) {
                    return Storage::disk('public')->url($this->dokumen_path);
                }
                return null;
            },
        );
    }
}

