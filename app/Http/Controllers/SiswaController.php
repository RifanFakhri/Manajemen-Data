<?php

// app/Http/Controllers/SiswaController.php
namespace App\Http\Controllers;

use App\Models\Siswa; // Import model Siswa
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Import Storage

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar semua siswa (halaman 'data_siswa').
     */
    public function index()
    {
        $siswas = Siswa::latest()->paginate(10); // Ambil semua data siswa, urutkan
        return view('pages.data_siswa', compact('siswas'));
    }

    /**
     * Menampilkan formulir tambah siswa baru.
     */
    public function create()
    {
        return view('pages.siswa_form'); // Ini file Blade Anda
    }

    /**
     * Menyimpan data siswa baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'nisn' => 'required|string|size:10|unique:siswas',
            'tanggal_lahir' => 'required|date',
            'nomor_kontak' => 'required|string|max:15', // Pastikan nama input di form 'nomor_kontak'
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'kota' => 'nullable|string|max:100',
            'kode_pos' => 'nullable|string|max:10',
            'negara' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,png,jpg|max:2048', // maks 2MB
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // maks 2MB
        ]);

        // 2. Simpan File (jika ada)
        if ($request->hasFile('dokumen')) {
            $validatedData['dokumen_path'] = $request->file('dokumen')->store('dokumen-siswa', 'public');
        }

        if ($request->hasFile('foto_profil')) {
            $validatedData['foto_profil_path'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        // 3. Buat Data Siswa
        Siswa::create($validatedData);

        // 4. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('siswa.index')->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    // ... method show, edit, update, destroy lainnya bisa Anda isi nanti ...
}